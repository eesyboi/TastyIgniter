<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Password_reset extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Customers_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
		//check if file exists in views
		if ( !file_exists('application/views/main/password_reset.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}
		
		if ($this->customer->islogged()) {  
  			redirect('account');
		}

		$data['heading'] = 'Account Password Reset';
		$data['action'] = $this->config->site_url('main/password_reset');

		$data['questions'] = array();
		$results = $this->Customers_model->getSecurityQuestions();
		foreach ($results as $result) {
			$data['questions'][] = array(
				'id'	=> $result['question_id'],
				'text'	=> $result['question_text']
			);
		}

		if ($this->session->flashdata('security_question_id')) {
				
			$security_question_id = $this->session->flashdata('security_question_id');
			$question_data = $this->Customers_model->getSecurityQuestions($security_question_id);
			
			$data['security_question'] = $question_data['question_text'];
			$data['customer_email'] = $this->session->flashdata('customer_email');
		
		} else {
			$data['security_question'] = '';
		}

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			
			if ($this->_resetPassword()) { 
				
			}
				
		}
		
		$this->load->view('main/header', $data);
		$this->load->view('main/password_reset', $data);
		$this->load->view('main/footer');
	}

	/*public function _checkEmail() {
						
		if ($this->input->post('submit') === 'Check Email') {
			
			//validate form
  		
  			if ($this->form_validation->run() === TRUE) {
  		
				$customer_data = $this->Customers_model->getCustomersByEmail($email);

				if ($customer_data) {	

					$this->session->set_flashdata('customer_id', $customer_data['customer_id']);
					$this->session->set_flashdata('customer_email', $customer_data['email']);
					$this->session->set_flashdata('security_question_id', $customer_data['security_question_id']);
  				
				} else {
				
					$this->session->set_flashdata('alert', 'No Matching Email Address');

  				}
  			
				redirect('main/password_reset');	
			}
		}
	}*/

	public function _resetPassword() {
		
		//validate form
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('security_question', 'Security Question', 'trim|required|integer');
		$this->form_validation->set_rules('security_answer', 'Security Answer', 'trim|required');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[32]|matches[confirm_new_password]|md5');
		$this->form_validation->set_rules('confirm_new_password', 'Confirm New Password', 'trim|required');
	
  		if ($this->form_validation->run() === TRUE) {
			
			//$customer_id = $this->session->flashdata('customer_id');
			$email = $this->input->post('email');
			$security_question = $this->input->post('security_question');
			$security_answer = $this->input->post('security_answer');
			$password = $this->input->post('new_password');
			
			$customer_data = $this->Customers_model->getCustomersByEmail($email);

			if (!$customer_data) {				
				$this->session->set_flashdata('alert', 'No Matching Email Address');
			}
			
			if ($customer_data['security_question_id'] !== $security_question) {
				$this->session->set_flashdata('alert', 'Security Question Does Not Match');
			}
			
			if ($customer_data['security_answer'] !== $security_answer) {
				$this->session->set_flashdata('alert', 'Security Answer Does Not Match');
			}

			$reset_password = $this->Customers_model->resetPassword($customer_data['customer_id'], $email, $security_question, $security_answer, $password);
			
			if ($reset_password) {
				$this->session->set_flashdata('alert', 'Password Reset Successfully');
				
  				redirect('account/login');
			}
		
			redirect('main/password_reset');
		}
	}
}

/* End of file password_reset.php */
/* Location: ./application/controllers/password_reset.php */