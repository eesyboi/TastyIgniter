<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Details extends CI_Controller {

	public function __construct() {
		parent::__construct();
		//$this->load->library('customer');
		$this->load->model('Customers_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
		//check if file exists in views
		if ( !file_exists('application/views/main/details.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		$data['heading'] = 'My Details';

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		if (!$this->customer->isLogged()) {  
  			redirect('account/login');
		}

		$result = $this->Customers_model->getCustomer($this->customer->getId());
		if ($result) {		
			$data['first_name'] 		= $result['first_name'];
			$data['last_name'] 			= $result['last_name'];
			$data['email'] 				= $result['email'];
			$data['telephone'] 			= $result['telephone'];
			$data['security_question'] 	= $result['security_question_id'];
			$data['security_answer'] 	= $result['security_answer'];
		}

		$data['questions'] = array();
		$results = $this->Customers_model->getSecurityQuestions();
		foreach ($results as $result) {
			$data['questions'][] = array(
				'id'	=> $result['question_id'],
				'text'	=> $result['question_text']
			);
		}
		

		if (($this->input->post('submit') === 'Save Details') && ($this->_updateDetails() === TRUE)) {
						
			redirect('account/details');
		}

		$this->load->view('main/header', $data);
		$this->load->view('main/details', $data);
		$this->load->view('main/footer');
	}

	public function _updateDetails() {
						
		$update = array();
		$new_password = '';

		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]|max_length[12]');
		$this->form_validation->set_rules('last_name', 'First Name', 'trim|required|min_length[2]|max_length[12]');
		$this->form_validation->set_rules('telephone', 'Telephone', 'trim|required|integer');
		$this->form_validation->set_rules('security_question', 'Security Question', 'required');
		$this->form_validation->set_rules('security_answer', 'Security Answer', 'required');

		if ($this->input->post('old_password')) {
			$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|min_length[6]|max_length[32]|md5|callback_check_old_password');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[32]|matches[confirm_new_password]|md5');
			$this->form_validation->set_rules('confirm_new_password', 'Confirm New Password', 'trim|required|md5');
		}
			
  		if ($this->form_validation->run() === TRUE) {
				
			if ($this->customer->getId()) {  
				$customer_id = $this->customer->getId();
			}
 			
 			if ($this->input->post('first_name') !== $this->customer->getFirstName()) {
				$update['first_name'] = $this->input->post('first_name');
			}			 	

 			if ($this->input->post('last_name') !== $this->customer->getLastName()) {
				$update['last_name'] = $this->input->post('last_name');
			}			 	
					
 			if ($this->input->post('telephone') !== $this->customer->getTelephone()) {
				$update['telephone'] = $this->input->post('telephone');
			}			 	

 			if ($this->input->post('security_question') !== $this->customer->getSecurityQuestionId()) {
				$update['security_question_id'] = $this->input->post('security_question');
			}			 	

 			if ($this->input->post('security_answer') !== $this->customer->getSecurityAnswer()) {
				$update['security_answer'] = $this->input->post('security_answer');
			}			 	

 			if ($this->input->post('new_password') !== $this->customer->getPassword()) {
				$new_password = $this->input->post('new_password');
			}			 	

			if (!empty($update)) {
				$this->Customers_model->updateCustomer($customer_id, $update);						
				$this->Customers_model->changePassword($customer_id, $new_password);						

				$this->session->set_flashdata('alert', 'Details Updated Sucessfully!');
	
				return TRUE;
			
			} else if (!empty($new_password)) {
				$this->Customers_model->changePassword($customer_id, $new_password);						

				$this->session->set_flashdata('alert', 'Password Updated Sucessfully!');

				return TRUE;
			
			} else {
				$this->session->set_flashdata('alert', 'No Changes Made!');
	
				return TRUE;
			}
		}
	}

 	public function validate_email($email) {
		if ($this->Customers_model->getCustomersByEmail($email)) {
        	$this->form_validation->set_message('validate_email', 'The %s you entered already exist.');
      		return FALSE;
    	} else {
        	return TRUE;        
      	}
	}
	
 	public function check_old_password($pwd) {
      		
		if ($pwd !== $this->customer->getPassword()) {
        	$this->form_validation->set_message('check_old_password', 'The %s you entered is invalid.');
      		return FALSE;
    	} else {
        	return TRUE;        
      	}
    }
}
