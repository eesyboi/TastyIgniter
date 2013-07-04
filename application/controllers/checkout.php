<?php
class Checkout extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Customer_model');
		//$this->load->library('cart');
		//$this->load->vars($data);
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
		//check if file exists in views
		if ( !file_exists('application/views/main/checkout.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		$data['heading'] = 'Checkout';

		if (!$this->customer->islogged()) {  
  			redirect('checkout/login');
		}

		
		//redirect('/checkout');
		
		$this->load->view('main/header', $data);
		$this->load->view('main/checkout', $data);
		$this->load->view('main/footer');
	}
	
	public function login() {
		//check if file exists in views
		if ( !file_exists('application/views/main/login.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		if ($this->session->flashdata('error')) {
			$data['errmsg'] = $this->session->flashdata('error');
		}
		
		$data['heading'] = 'Account Login';

		//$data['heading'] = 'Checkout';
		if ($this->input->post('submit') === 'Login') {
			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'First Name', 'trim|required|min_length[6]|max_length[32]');

  			if ($this->form_validation->run() === TRUE) {
				$email = $this->input->post('email');
				$password = $this->input->post('password');
			
				if (!$this->customer->login($email, $password)) {
					$this->session->set_flashdata('error', 'Username and Password not found');
    			} else {
  					//redirect('account');
  				}
    		}
		}
		
		$this->load->view('main/header', $data);
		$this->load->view('main/login', $data);
		$this->load->view('main/footer');
	}

	public function register() {
		if ( !file_exists('application/views/main/register.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		$data['heading'] = 'Account Register';
		
		$data['questions'] = array();
		$questions = $this->Customer_model->questions();
		foreach ($questions as $question) {
			$data['questions'][] = array(
				'id'	=> $question['question_id'],
				'text'	=> $question['question_text']
			);
		}

		if ($this->input->post('submit') === 'Register') {
						
			//validate form
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]|max_length[12]');
			$this->form_validation->set_rules('last_name', 'First Name', 'trim|required|min_length[2]|max_length[12]');
			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|is_unique[customers.email]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[32]|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', 'Password Confirm', 'trim|required');
			$this->form_validation->set_rules('telephone', 'Telephone', 'trim|required|integer');
			$this->form_validation->set_rules('security_question', 'Security Question', 'required');
			$this->form_validation->set_rules('security_answer', 'Security Answer', 'required');

			//if validation is true
  			if ($this->form_validation->run() === TRUE) {
  		
  				//store post values
				$first_name = $this->input->post('first_name');
				$last_name = $this->input->post('last_name');
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				$telephone = $this->input->post('telephone');
				$security_question_id = $this->input->post('security_question');
				$security_answer = $this->input->post('security_answer');

				//add into database
				$this->Customer_model->register($first_name, $last_name, $email, $password, $telephone, $security_question_id, $security_answer);	
  				//redirect('account');
		
			}
		}
		
		$this->load->view('main/header', $data);
		$this->load->view('main/register', $data);
		$this->load->view('main/footer');
	}

	public function logout() {
		//check if file exists in views
		if ( !file_exists('application/views/main/logout.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		$data['heading'] = 'Account Logged Out'; 

		$this->customer->logout();
		
		$this->load->view('main/header', $data);
		$this->load->view('main/logout', $data);
		$this->load->view('main/footer');
	}
}