<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

<<<<<<< HEAD
class Login extends MX_Controller {

	public function index() {
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
		$this->lang->load('main/login_register');  												// loads language file

		if ( !file_exists('application/views/main/login.php')) { 								//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
=======
class Login extends CI_Controller {

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
		if ($this->customer->islogged()) { 														// checks if customer is logged in then redirect to account page.	
  			redirect('account');
		}

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_login'] 			= $this->lang->line('text_login');
		$data['text_register'] 			= $this->lang->line('text_register');
		$data['text_forgot'] 			= $this->lang->line('text_forgot');
		$data['entry_email'] 			= $this->lang->line('entry_email');
		$data['entry_password'] 		= $this->lang->line('entry_password');
		$data['button_login'] 			= $this->lang->line('button_login');
		$data['text_login_register'] 		= $this->lang->line('text_login_register');
		// END of retrieving lines from language file to send to view.

		if ($this->input->post('submit') === 'Login') {																// checks if $_POST data is set 
	
			// START of form validation rules
			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[32]');
			// END of form validation rules

  			if ($this->form_validation->run() === TRUE) {										// checks if form validation routines ran successfully
				
				$email = $this->input->post('email');											// retrieves email value from $_POST data if set
				$password = $this->input->post('password');										// retrieves password value from $_POST data if set
			
				if ($this->customer->login($email, $password) === FALSE) {						// invoke login method in customer library with email and password $_POST data value then check if login was unsuccessful
					$this->session->set_flashdata('alert', $this->lang->line('text_invalid_login'));	// display error message and redirect to account login page
  					redirect('account/login');
    			} else {																		// else if login was successful redirect to account page
=======
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
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
  					redirect('account');
  				}
    		}
		}
		
<<<<<<< HEAD
		// pass array $data and load view files
		$this->load->view('main/header', $data);
		$this->load->view('main/login', $data);
		$this->load->view('main/footer');
	}

	public function _addCustomer() {
						
		// START of form validation rules
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]|max_length[12]');
		$this->form_validation->set_rules('last_name', 'First Name', 'trim|required|min_length[2]|max_length[12]');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|is_unique[customers.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[32]|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirm', 'trim|required');
		$this->form_validation->set_rules('telephone', 'Telephone', 'trim|required|integer');
		$this->form_validation->set_rules('security_question', 'Security Question', 'trim|required|integer');
		$this->form_validation->set_rules('security_answer', 'Security Answer', 'trim|required|min_length[2]');
		// END of form validation rules

  		if ($this->form_validation->run() === TRUE) {											// checks if form validation routines ran successfully
  			$add = array();
  			
  			// if successful CREATE an array with the following $_POST data values
			$add['first_name'] 				= $this->input->post('first_name');
			$add['last_name'] 				= $this->input->post('last_name');
			$add['email'] 					= $this->input->post('email');
			$add['password'] 				= $this->input->post('password');
			$add['telephone'] 				= $this->input->post('telephone');
			$add['security_question_id']	= $this->input->post('security_question');
			$add['security_answer'] 		= $this->input->post('security_answer');

			if (!empty($add)) {																	// checks if add array is not empty
				$this->Customers_model->addCustomer($add);										// pass add array data to addCustomer method in Customers model then return TRUE
  				
  				return TRUE;		
			}
=======
		//check if file exists in views
		if ( !file_exists('application/views/main/login.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		} else {
			$this->load->template('main/login', $data);
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
		}
	}
}

/* End of file login.php */
<<<<<<< HEAD
/* Location: ./application/controllers/main/login.php */
=======
/* Location: ./application/controllers/account_login.php */
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
