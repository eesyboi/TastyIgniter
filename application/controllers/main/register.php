<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Customers_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		$data['heading'] = 'Account Register';
		
		$data['questions'] = array();
		$results = $this->Customers_model->getSecurityQuestions();
		foreach ($results as $result) {
			$data['questions'][] = array(
				'id'	=> $result['question_id'],
				'text'	=> $result['question_text']
			);
		}

		//if POST sumbit is Register then call the _addCustomer method
		if (($this->input->post('submit') === 'Register') && ($this->_addCustomer() === TRUE)) {

			$this->session->set_flashdata('alert', 'Account Created Successfully, Login below!');
		
			redirect('account/login');
		}
		
		//check if file exists in views
		if ( !file_exists('application/views/main/register.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		} else {
			$this->load->template('main/register', $data);
		}
	}

	public function _addCustomer() {
						
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
		}
	}
}