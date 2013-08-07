<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

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
		
		if ($this->customer->islogged()) {  
  			redirect('account');
		}

		$data['heading'] = 'Account Login';

		//$data['heading'] = 'Checkout';
		if ($this->input->post('submit') === 'Login') {
			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[32]|md5');

  			if ($this->form_validation->run() === TRUE) {
				$email = $this->input->post('email');
				$password = $this->input->post('password');
			
				if ($this->customer->login($email, $password) === FALSE) {
					$this->session->set_flashdata('alert', 'Username and Password not found');
  					redirect('account/login');
    			} else {
  					redirect('account');
  				}
    		}
		}
		
		//check if file exists in views
		if ( !file_exists('application/views/main/login.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		} else {
			$this->load->template('main/login', $data);
		}
	}
}

/* End of file login.php */
/* Location: ./application/controllers/account_login.php */