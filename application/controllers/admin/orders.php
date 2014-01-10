<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Orders extends MX_Controller {

	private $error = array();

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->library('currency'); // load the currency library
		$this->load->model('Customers_model');
		$this->load->model('Locations_model');
		$this->load->model('Orders_model');
		$this->load->model('Statuses_model');
		$this->load->model('Payments_model');
		$this->load->model('Countries_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
		
		if ( !file_exists('application/views/admin/orders.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}
		
    	if (!$this->user->hasPermissions('access', 'admin/orders')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}
		
		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = 1;
		}
		
		if ($this->config->item('config_page_limit')) {
			$filter['limit'] = $this->config->item('config_page_limit');
		}
				
		$data['heading'] 			= 'Orders';
		$data['sub_menu_list'] 		= '<li><a href="'. site_url('admin/orders/assigned') . '">Switch to assigned orders</a></li>';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['text_empty'] 		= 'There are no order(s).';
		
		$results = $this->Orders_model->getList($filter);
		
		//load category data into array
		$data['orders'] = array();
		foreach ($results as $result) {					
			$data['orders'][] = array(
				'order_id'			=> $result['order_id'],
				'location_name'		=> $result['location_name'],
				'first_name'		=> $result['first_name'],
				'last_name'			=> $result['last_name'],
				'order_type' 		=> ($result['order_type'] === '1') ? 'Delivery' : 'Collection',
				'order_time'		=> mdate('%H:%i', strtotime($result['order_time'])),
				'order_status'		=> $result['status_name'],
				'staff_name'		=> $result['staff_name'],
				'date_added'		=> mdate('%d-%m-%Y', strtotime($result['date_added'])),
				'date_modified'		=> mdate('%d-%m-%Y', strtotime($result['date_modified'])),
				'edit' 				=> $this->config->site_url('admin/orders/edit/' . $result['order_id'])
			);
		}
			
		$config['base_url'] 		= $this->config->site_url('admin/orders');
		$config['total_rows'] 		= $this->Orders_model->record_count();
		$config['per_page'] 		= $filter['limit'];
		$config['num_links'] 		= round($config['total_rows'] / $config['per_page']);
		
		$this->pagination->initialize($config);
				
		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		//check if POST submit then remove order_id
		if ($this->input->post('delete') && $this->_deleteOrder() === TRUE) {
			
			redirect('admin/orders');
		}	

		$this->load->view('admin/header', $data);
		$this->load->view('admin/orders', $data);
		$this->load->view('admin/footer');
	}

	public function assigned() {
		
		if ( !file_exists('application/views/admin/orders.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}
		
    	if (!$this->user->hasPermissions('access', 'admin/orders')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}
		
		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = 1;
		}
		
		if ($this->config->item('config_page_limit')) {
			$filter['limit'] = $this->config->item('config_page_limit');
		}
				
		if ($this->user->getStaffId()) {
			$filter['staff_id'] = $this->user->getStaffId();
		}
				
		$data['heading'] 			= 'Orders';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['sub_menu_list'] 		= '<li><a href="'. site_url('admin/orders') . '">Switch to all orders</a></li>';
		$data['text_empty'] 		= 'There are no assigned order(s).';
		
		$data['orders'] = array();
		$results = $this->Orders_model->getList($filter);
		foreach ($results as $result) {					
			$data['orders'][] = array(
				'order_id'			=> $result['order_id'],
				'location_name'		=> $result['location_name'],
				'first_name'		=> $result['first_name'],
				'last_name'			=> $result['last_name'],
				'order_type' 		=> ($result['order_type'] === '1') ? 'Delivery' : 'Collection',
				'order_time'		=> mdate('%H:%i', strtotime($result['order_time'])),
				'order_status'		=> $result['status_name'],
				'staff_name'		=> $result['staff_name'],
				'date_added'		=> mdate('%d-%m-%Y', strtotime($result['date_added'])),
				'date_modified'		=> mdate('%d-%m-%Y', strtotime($result['date_modified'])),
				'edit' 				=> $this->config->site_url('admin/orders/edit/' . $result['order_id'])
			);
		}
				
		$config['base_url'] 		= $this->config->site_url('admin/orders/assigned');
		$config['total_rows'] 		= $this->Orders_model->assigned_record_count($filter);
		$config['per_page'] 		= $filter['limit'];
		$config['num_links'] 		= round($config['total_rows'] / $config['per_page']);
		
		$this->pagination->initialize($config);
				
		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		//check if POST submit then remove order_id
		if ($this->input->post('delete') && $this->_deleteOrder() === TRUE) {
			
			redirect('admin/orders/assigned');
		}	

		$this->load->view('admin/header', $data);
		$this->load->view('admin/orders', $data);
		$this->load->view('admin/footer');
	}

	public function edit() {
		
		if ( !file_exists('application/views/admin/orders_edit.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/orders')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		

		//check if customer_id is set in uri string
		if ($this->uri->segment(4)) {
			$order_id = (int)$this->uri->segment(4);
		} else {
		    redirect('admin/orders');
		}
		
		$order_info = $this->Orders_model->getAdminOrder($order_id);

		if ($order_info) {
			$data['heading'] 			= 'Orders';
			$data['sub_menu_update'] 	= 'Update';
			$data['sub_menu_back'] 		= $this->config->site_url('admin/orders');

			$data['order_id'] 			= $order_info['order_id'];
			$data['customer_id'] 		= $order_info['order_customer_id'];
			$data['first_name'] 		= $order_info['first_name'];
			$data['last_name'] 			= $order_info['last_name'];
			$data['email'] 				= $order_info['email'];
			$data['telephone'] 			= $order_info['telephone'];
			$data['date_added'] 		= mdate('%d-%m-%Y', strtotime($order_info['date_added']));
			$data['date_modified'] 		= mdate('%d-%m-%Y', strtotime($order_info['date_modified']));
			$data['order_time'] 		= mdate('%H:%i', strtotime($order_info['order_time']));
			$data['order_total'] 		= $this->currency->format($order_info['order_total']);
			$data['total_items']		= $order_info['total_items'];
			$data['order_type'] 		= ($order_info['order_type'] === '1') ? 'Delivery' : 'Collection';
			$data['status_id'] 			= $order_info['status_id'];
			$data['staff_id'] 			= $order_info['staff_id'];
			$data['comment'] 			= $order_info['comment'];
			$data['notify'] 			= $order_info['notify'];
			$data['ip_address'] 		= $order_info['ip_address'];
			$data['user_agent'] 		= $order_info['user_agent'];

			$location = $this->Locations_model->getLocation($order_info['order_location_id']);
			$data['location_name'] 		= $location['location_name'];
			$data['location_address_1'] = $location['location_address_1'];
			$data['location_address_2'] = $location['location_address_2'];
			$data['location_city'] 		= $location['location_city'];
			$data['location_postcode'] 	= $location['location_postcode'];
			$data['location_country'] 	= $location['country_name'];
			
			$customer_address = $this->Customers_model->getCustomerAddress($order_info['order_customer_id'], $order_info['order_address_id']);
			$data['address_1'] 			= $customer_address['address_1'];
			$data['address_2'] 			= $customer_address['address_2'];
			$data['city'] 				= $customer_address['city'];
			$data['postcode'] 			= $customer_address['postcode'];
			$data['country'] 			= $customer_address['country'];
		
			if ($order_info['payment'] === 'paypal') {
				$data['payment'] = 'PayPal';
				$data['paypal_details'] = $this->Payments_model->getPaypalDetails($order_info['order_id'], $order_info['order_customer_id']);
			} else if ($order_info['payment'] === 'cod') {
				$data['payment'] = 'Cash On Delivery';
				$data['paypal_details'] = array();
			} else {
				$data['payment'] = 'No Payment';
				$data['paypal_details'] = array();			
			}
		
			
			$cart_items = $this->Orders_model->getOrderMenus($order_info['order_id']);
			foreach ($cart_items as $cart_item) {
				if (!empty($cart_item['options'])) {
					$options = unserialize($cart_item['options']);
				} else {
					$options = '';
				}
				
				$data['cart_items'][] = array(
					'id' 			=> $cart_item['menu_id'],
					'name' 			=> $cart_item['name'],			
					'qty' 			=> $cart_item['quantity'],
					'price' 		=> $this->currency->format($cart_item['price']),
					'subtotal' 		=> $this->currency->format($cart_item['subtotal']),
					'options'		=> $options
				);
			}
						
			$data['countries'] = array();
			$results = $this->Countries_model->getCountries();
			foreach ($results as $result) {					
				$data['countries'][] = array(
					'country_id'	=>	$result['country_id'],
					'name'			=>	$result['country_name'],
				);
			}
										
			$data['statuses'] = array();
			$statuses = $this->Statuses_model->getStatuses();
			foreach ($statuses as $statuses) {
				$data['statuses'][] = array(
					'status_id'	=> $statuses['status_id'],
					'status_name'	=> $statuses['status_name']
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

			if ($this->input->post() && $this->_updateOrder($order_id) === TRUE) {
		
				redirect('admin/orders');
			}
		}
				
		$this->load->view('admin/header', $data);
		$this->load->view('admin/orders_edit', $data);
		$this->load->view('admin/footer');
	}

	public function _updateOrder($order_id) {
			
    	if (!$this->user->hasPermissions('modify', 'admin/orders')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
			return TRUE;
    	
    	} else if ( ! $this->input->post('delete')) { 
			
			$date_format = '%Y-%m-%d';															// retrieve date format from config
			$current_date_time = time();														// retrieve current timestamp
		
			$this->form_validation->set_rules('order_status', 'Order Status', 'trim|required|integer');
			$this->form_validation->set_rules('assigned_staff', 'Assign Staff', 'trim|integer');

			if ($this->form_validation->run() === TRUE) {
				$update = array();
				
				//Sanitizing the POST values
				$update['order_id'] = (int)$order_id;
				
				$update['status_id'] = (int)$this->input->post('order_status');
			
				$update['order_staff_id'] = (int)$this->input->post('assigned_staff');
				
				$update['date_modified'] =  mdate($date_format, $current_date_time);
			
				if ($this->Orders_model->updateOrder($update)) {
			
					$this->session->set_flashdata('alert', '<p class="success">Order Updated Sucessfully!</p>');
				} else {

					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');
				}
		
				return TRUE;
			}
		}
	}

	public function _deleteOrder($order_id = FALSE) {
    	if (!$this->user->hasPermissions('modify', 'admin/orders')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
    	} else { 
		
			if (is_array($this->input->post('delete'))) {

				//sorting the post[quantity] array to rowid and qty.
				foreach ($this->input->post('delete') as $key => $value) {
					$order_id = $value;            	
					
					$this->Orders_model->deleteOrder($order_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Order Deleted Sucessfully!</p>');

			}
		}
				
		return TRUE;
	}
}