<<<<<<< HEAD
<?php 

class Orders extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->model('Orders_model');														// load orders model
		$this->load->library('currency'); 														// load the currency library
	}

	public function index() {
		$this->lang->load('main/orders');  														// loads language file
		
		if ( !file_exists('application/views/main/orders.php')) { 								//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}
		
		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		}

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_empty'] 			= $this->lang->line('text_empty');
		$data['text_delivery'] 			= $this->lang->line('text_delivery');
		$data['text_collection'] 		= $this->lang->line('text_collection');
		$data['column_id'] 				= $this->lang->line('column_id');
		$data['column_status'] 			= $this->lang->line('column_status');
		$data['column_location'] 		= $this->lang->line('column_location');
		$data['column_date'] 			= $this->lang->line('column_date');
		$data['column_order'] 			= $this->lang->line('column_order');
		$data['column_items'] 			= $this->lang->line('column_items');
		$data['column_total'] 			= $this->lang->line('column_total');
		$data['button_back'] 			= $this->lang->line('button_back');
		$data['button_order'] 			= $this->lang->line('button_order');
		// END of retrieving lines from language file to pass to view.

		$data['back'] 					= $this->config->site_url('account');

		$data['orders'] = array();
		$results = $this->Orders_model->getMainOrders($this->customer->getId());				// retrieve customer orders based on customer id from getMainOrders method in Orders model
		foreach ($results as $result) {

			if ($result['order_type'] === '1') {												// if order type is equal to 1, order type is delivery else collection
				$order_type = $this->lang->line('text_delivery');
			} else {
				$order_type = $this->lang->line('text_collection');
			}
					
			$data['orders'][] = array(															// create array of customer orders to pass to view
				'order_id' 				=> $result['order_id'],
				'location_name' 		=> $result['location_name'],
				'date_added' 			=> mdate('%d-%m-%Y', strtotime($result['date_added'])),
				'order_time'			=> $result['order_time'],
				'total_items'			=> $result['total_items'],
				'order_total' 			=> $this->currency->format($result['order_total']),		// add currency symbol and format order total to two decimal places
				'order_type' 			=> ucwords(strtolower($order_type)),					// convert string to lower case and capitalize first letter
				'status_name' 	=> $result['status_name']
			);
		}
				
		// pass array $data and load view files
		$this->load->view('main/header', $data);
		$this->load->view('main/content_left');
		$this->load->view('main/orders', $data);
		$this->load->view('main/footer');
=======
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */