<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Orders extends CI_Controller {

	private $error = array();

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->library('currency');
		$this->load->model('Orders_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
		//check if file exists in views
		if ( !file_exists('application/views/admin/orders.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}
		
		if ($this->uri->segment(3)) {
			$page = $this->uri->segment(3);
		} else {
			$page = 0;
		}
		
		$config['base_url'] = $this->config->site_url('admin/orders');
		$config['total_rows'] = $this->Orders_model->record_count();
		$config['per_page'] = 20;
		$config['uri_segment'] = 3;
		$choice = $config['total_rows'] / $config['per_page'];
		$config['num_links'] = round($choice);
		$config['use_page_numbers'] = TRUE;
		
		$this->pagination->initialize($config);
				
		$data['title'] = 'Orders Management';
		$data['text_no_orders'] = 'There are no order(s).';
		
		$results = $this->Orders_model->getList($config['per_page'], $page);
		
		//load category data into array
		$data['orders'] = array();
		foreach ($results as $result) {					
			$data['orders'][] = array(
				'order_id'			=> $result['order_id'],
				'first_name'		=> $result['first_name'],
				'last_name'			=> $result['last_name'],
				'order_total'		=> $this->currency->symbol() . $result['order_total'],
				'order_date'		=> $result['order_date'],
				'order_time'		=> $result['order_time'],
				'telephone'			=> $result['telephone'],
				'location_name'		=> $result['location_name'],
				'notify'			=> $result['notify'],
				'order_status'		=> $result['order_status_name'],
				'staff_name'		=> $result['staff_name'],
				'edit' 				=> $this->config->site_url('admin/orders/edit/' . $result['order_id'])
			);
		}
				
		$data['pagination'] = array(
			'info'		=> '(Showing: ' . $config['per_page'] . ' of ' . $config['total_rows'] . ')',
			'links'		=> $this->pagination->create_links()
		);

		$this->load->view('admin/header', $data);
		$this->load->view('admin/orders', $data);
		$this->load->view('admin/footer');
	}

	public function edit() {
		//check if file exists in views
		if ( !file_exists('application/views/admin/orders_edit.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

		$data['title'] = 'Orders Management';

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		

		//check if customer_id is set in uri string
		if ($this->uri->segment(4)) {
			$order_id = (int)$this->uri->segment(4);
		} else {
		    redirect('admin/orders');
		}
		
		$data['action'] = $this->config->site_url('admin/orders/edit/' . $order_id);

		$order_info = $this->Orders_model->getAdminOrder($order_id);

		$data['order_id'] 			= $order_info['order_id'];
		$data['location_name'] 		= $order_info['location_name'];
		$data['location_address'] 	= $order_info['location_address'];
		$data['location_region'] 	= $order_info['location_region'];
		$data['location_city'] 		= $order_info['location_city'];
		$data['location_postcode'] 	= $order_info['location_postcode'];
		$data['first_name'] 		= $order_info['first_name'];
		$data['last_name'] 			= $order_info['last_name'];
		$data['email'] 				= $order_info['email'];
		$data['telephone'] 			= $order_info['telephone'];
		$data['address_1'] 			= $order_info['address_1'];
		$data['address_2'] 			= $order_info['address_2'];
		$data['city'] 				= $order_info['city'];
		$data['postcode'] 			= $order_info['postcode'];
		$data['country'] 			= $order_info['country'];
		$data['order_date'] 		= $order_info['order_date'];
		$data['order_time'] 		= $order_info['order_time'];
		$data['order_total'] 		= $this->currency->symbol() . $order_info['order_total'];
		$data['order_type'] 		= ucwords(strtolower($order_info['order_type']));
		$data['payment_method'] 	= $order_info['payment_method'];
		$data['order_status_id'] 	= $order_info['order_status_id'];
		$data['staff_id'] 			= $order_info['staff_id'];
		$data['comment'] 			= $order_info['comment'];
		$data['notify'] 			= $order_info['notify'];
		$data['cart_items'] 		= unserialize($order_info['cart']);
		     	     	
		     	     	
		$data['order_statuses'] = array();
		$order_statuses = $this->Orders_model->getOrderStatuses();
		foreach ($order_statuses as $order_status) {
			$data['order_statuses'][] = array(
				'order_status_id'	=> $order_status['order_status_id'],
				'order_status_name'	=> $order_status['order_status_name']
			);
		}

		$this->load->model('Staffs_model');
		$data['staffs'] = array();
		$staffs = $this->Staffs_model->getStaffs();
		foreach ($staffs as $staff) {
			$data['staffs'][] = array(
				'staff_id'		=> $staff['staff_id'],
				'staff_name'	=> $staff['staff_name']
			);
		}

		// check if POST add_food, validate fields and add Food to model
		if (($this->input->post('submit') === 'Update') && ( ! $this->input->post('delete')) && ($this->_updateOrder($order_id) === TRUE)) {
		
			$this->session->set_flashdata('alert', 'Order Updated Sucessfully!');
				
			redirect('admin/orders');
		}
		
						
		//Remove Food
		if ($this->input->post('delete')) {
					
			$this->Orders_model->deleteOrder($order_id);
					
			$this->session->set_flashdata('alert', 'Order Removed Sucessfully!');

			redirect('admin/orders');
		}
		
		$this->load->view('admin/header', $data);
		$this->load->view('admin/orders_edit', $data);
		$this->load->view('admin/footer');
	}

	public function _updateOrder($order_id) {
			
		$update_data = array();
		
		$this->form_validation->set_rules('order_status', 'Order Status', 'trim|required|integer');

	  	if ($this->form_validation->run() === TRUE) {
				
  		    //Sanitizing the POST values
			$update_data['order_status_id'] = (int)$this->input->post('order_status');

			$update_data['staff_id'] = (int)$this->input->post('assigned_staff');
			
			$update_data['notify'] = (int)$this->input->post('notify');
			
			if ($this->Orders_model->updateOrder($order_id, $update_data)) {
			
				return TRUE;
			}
		}
	}
}