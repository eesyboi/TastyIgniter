<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

<<<<<<< HEAD
class Register extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->model('Customers_model');													// load the customers model
		$this->load->model('Security_questions_model');											// load the security questions model
	}

	public function index() {
		$this->lang->load('main/login_register');  												// loads language file

		if ( !file_exists('application/views/main/register.php')) { 							//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
=======
class Register extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Customers_model');
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
		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 				= $this->lang->line('text_heading');
		$data['text_login_register'] 		= $this->lang->line('text_login_register');
		$data['text_login'] 				= $this->lang->line('text_login');
		$data['text_register'] 				= $this->lang->line('text_register');
		$data['text_required'] 				= $this->lang->line('text_required');
		$data['entry_first_name'] 			= $this->lang->line('entry_first_name');
		$data['entry_last_name'] 			= $this->lang->line('entry_last_name');
		$data['entry_email'] 				= $this->lang->line('entry_email');
		$data['entry_password'] 			= $this->lang->line('entry_password');
		$data['entry_password_confirm'] 	= $this->lang->line('entry_password_confirm');
		$data['entry_telephone'] 			= $this->lang->line('entry_telephone');
		$data['entry_s_question'] 			= $this->lang->line('entry_s_question');
		$data['entry_s_answer'] 			= $this->lang->line('entry_s_answer');
		$data['button_register'] 			= $this->lang->line('button_register');
		// END of retrieving lines from language file to send to view.
		
		$data['questions'] = array();
		$results = $this->Security_questions_model->getSecurityQuestions();						// retrieve array of security questions from getSecurityQuestions method in Security questions model
		foreach ($results as $result) {															// loop through security questions array
			$data['questions'][] = array(														// create an array of security questions to pass to view
=======
		$data['heading'] = 'Account Register';
		
		$data['questions'] = array();
		$results = $this->Customers_model->getSecurityQuestions();
		foreach ($results as $result) {
			$data['questions'][] = array(
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
				'id'	=> $result['question_id'],
				'text'	=> $result['question_text']
			);
		}

<<<<<<< HEAD
		if ($this->input->post() && $this->_addCustomer() === TRUE) {							// checks if $_POST data is set and if registration validation was successful

			$this->session->set_flashdata('alert', $this->lang->line('text_account_created'));	// display success message and redirect to account login page
=======
		//if POST sumbit is Register then call the _addCustomer method
		if (($this->input->post('submit') === 'Register') && ($this->_addCustomer() === TRUE)) {

			$this->session->set_flashdata('alert', 'Account Created Successfully, Login below!');
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
		
			redirect('account/login');
		}
		
<<<<<<< HEAD
		// pass array $data and load view files
		$this->load->view('main/header', $data);
		$this->load->view('main/register', $data);
		$this->load->view('main/footer');
=======
		//check if file exists in views
		if ( !file_exists('application/views/main/register.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		} else {
			$this->load->template('main/register', $data);
		}
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
	}

	public function _addCustomer() {
						
<<<<<<< HEAD
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
			$add['date_added'] 				= mdate('%Y-%m-%d', time());
			$add['status'] 					= '1';

			if (!empty($add)) {																	// checks if add array is not empty
				$this->Customers_model->addCustomer($add);										// pass add array data to addCustomer method in Customers model then return TRUE
  				
  				return TRUE;		
			}
=======
		//validate form
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('last_name', 'First Name', 'trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|is_unique[customers.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[32]|matches[password_confirm]|md5');
		$this->form_validation->set_rules('password_confirm', 'Password Confirm', 'trim|required');
		$this->form_validation->set_rules('telephone', 'Telephone', 'trim|required|integer');
		$this->form_validation->set_rules('security_question', 'Security Question', 'required');
		$this->form_validation->set_rules('security_answer', 'Security Answer', 'required|min_length[3]|max_length[32]');

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
			$this->Customers_model->addCustomer($first_name, $last_name, $email, $password, $telephone, $security_question_id, $security_answer);	
  				
  			return TRUE;		
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
		}
	}
}