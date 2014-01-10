<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

<<<<<<< HEAD
class Logout extends MX_Controller {

	public function index() {
		$this->lang->load('main/login_register');  												// loads language file

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
=======
class Logout extends CI_Controller {

	public function __construct() {
		parent::__construct();
		//$this->load->model('Customer_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
		} else {
			$data['alert'] = '';
		}

<<<<<<< HEAD
		$data['text_heading'] 			= $this->lang->line('text_logout_heading');
		$data['text_logout_msg'] 		= sprintf($this->lang->line('text_logout_msg'), $this->config->site_url('account/login'));
=======
		$data['heading'] = 'Account Logged Out'; 
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e

		$this->customer->logout();
		
		
		$this->load->template('main/logout', $data);
	}
}

/* End of file logout.php */
/* Location: ./application/controllers/logout.php */