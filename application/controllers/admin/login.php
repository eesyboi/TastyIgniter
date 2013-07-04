<?php
class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('admin');
		//$this->load->model('Admin_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
		//check if file exists in views
		if ( !file_exists('application/views/admin/login.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		$data['title'] = 'Adminstrator Login'; 
		
		if ($this->admin->islogged()) {  
  			redirect('admin/dashboard');
		}
		if (($this->input->post('login')) || ($this->input->post('password'))) {
			$login = $this->input->post('login');
			$password = $this->input->post('password');
			
			if (!$this->admin->login($login, $password)) {
				$data['errmsg_arr'] = 'Username and Password not found';
    		//} else {
  				//redirect('admin/dashboard');
  			}
    	}
		
		$this->load->view('admin/header', $data);
		$this->load->view('admin/login', $data);
		$this->load->view('admin/footer');
	}
}