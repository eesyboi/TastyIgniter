<?php
class Account extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('customer');
		$this->load->model('Customer_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
			
		//check if file exists in views
		if ( !file_exists('application/views/main/account.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		$data['heading'] = 'My Account';

		if (!$this->customer->islogged()) {  
  			redirect('checkout');
		}

		$this->load->view('main/header', $data);
		$this->load->view('main/account', $data);
		$this->load->view('main/footer');
	}
}