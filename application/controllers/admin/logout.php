<?php
class Logout extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('admin');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
		//check if file exists in views
		if ( !file_exists('application/views/admin/logout.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		$data['title'] = 'Adminstrator Logged Out'; 

		$this->admin->logout();

		$this->load->view('admin/header', $data);
		$this->load->view('admin/logout', $data);
		$this->load->view('admin/footer');
	}
}