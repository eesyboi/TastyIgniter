<?php
class Orders_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

    public function record_count() {
        return $this->db->count_all('orders');
    }
    
	public function getList($limit = FALSE, $start = FALSE) {
		if ($start !== 0) {
			$start = ($start - 1) * $limit;
		}
			
		if ($this->db->limit($limit, $start)) {
			$this->db->from('orders');
			$this->db->join('order_status', 'order_status.order_status_id = orders.order_status_id', 'left');
			$this->db->join('staffs', 'staffs.staff_id = orders.staff_id', 'left');
			$this->db->join('locations', 'locations.location_id = orders.order_location', 'left');

			$query = $this->db->get();
			return $query->result_array();
		}
	}
	
	public function getOrders() {
		$this->db->from('orders');
		$this->db->join('order_status', 'order_status.order_status_id = orders.order_status_id', 'left');
		$this->db->join('staffs', 'staffs.staff_id = orders.staff_id', 'left');
		$this->db->join('locations', 'locations.location_id = orders.order_location', 'left');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function getAdminOrder($order_id = FALSE) {
		if ($order_id !== FALSE) {
			$this->db->from('orders');
			$this->db->join('order_status', 'order_status.order_status_id = orders.order_status_id', 'left');
			$this->db->join('staffs', 'staffs.staff_id = orders.staff_id', 'left');
			$this->db->join('locations', 'locations.location_id = orders.order_location', 'left');
			$this->db->join('address', 'address.address_id = orders.address_id', 'left');
		
			$this->db->where('order_id', $order_id);			
			$query = $this->db->get();
		
			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function getOrder($order_id, $customer_id) {
		$this->db->from('orders');
		$this->db->where('order_id', $order_id);
		$this->db->where('customer_id', $customer_id);
			
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getOrderStatuses($order_status_id = FALSE) {
		$this->db->from('order_status');
		
		$query = $this->db->get();
		return $query->result_array();
	}

	public function addOrder($order_details = array()) {

		if (!empty($order_details)) {
			$this->db->insert('orders', $order_details);
		
			if ($this->db->affected_rows() > 0) {
				$order_id = $this->db->insert_id();
				
				$this->confirmOrder($order_id, $order_details['customer_id']);

				return $order_id;
			}
		}
	}	

	public function confirmOrder($order_id, $customer_id) {
		
		$order_info = $this->getOrder($order_id, $customer_id);
		
		if ($order_info && $order_info['order_status_id'] === '0') {
			
			$config = Array(
    			'protocol' => 'smtp',
    			'smtp_host' => 'ssl://smtp.googlemail.com',
    			'smtp_port' => 465,
    			'smtp_user' => 'eesyboi@gmail.com',
    			'smtp_pass' => 'Letmein8',
    			'mailtype'  => 'html', 
    			'charset'   => 'iso-8859-1',
				'wordwrap' 	=> 'TRUE',
				'validate' 	=> 'TRUE',
				'priority' 	=> '3'
			);
			
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->lang->load('main/checkout');
	
			$data['heading'] = 'Order Successful';
			$data['message'] = sprintf($this->lang->line('text_success_message'), $order_info['order_id'], $this->config->site_url('account_orders/' . $order_info['order_id']));
			$message = $this->load->view('main/order_email', $data, TRUE);

			$this->email->from('store@email.com', 'TastyIgniter');
			$this->email->to($order_info['email']);

			$this->email->subject('Order Confirmation');
			$this->email->message($message);

			if ( ! $this->email->send()) {
				$notify = '0';
			} else {
				$notify = '1';
			}			
		
			$update_data = array(
               'order_status_id' 	=> '1',
               'notify' 	=> $notify
            );

			$this->db->where('order_id', $order_id);
			$this->db->update('orders', $update_data); 
			
			return TRUE;
		}
		
	}

	public function updateOrder($order_id, $update_data = array()) {
		if (!empty($update_data)) {
			
			$this->db->where('order_id', $order_id);
			return $this->db->update('orders', $update_data);
		
		}
	}
}