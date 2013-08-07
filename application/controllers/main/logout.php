<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function __construct() {
		parent::__construct();
		//$this->load->model('Customer_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		$data['heading'] = 'Account Logged Out'; 

		$this->customer->logout();
		
		
		$this->load->template('main/logout', $data);
	}
}

/* End of file logout.php */
/* Location: ./application/controllers/logout.php */