<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Address extends CI_Controller {

	public function __construct() {
		parent::__construct();
		//$this->load->library('customer');
		$this->load->model('Customers_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
		//check if file exists in views
		if ( !file_exists('application/views/main/address.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		$data['heading'] = 'Address Book';

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		if (!$this->customer->isLogged()) {  
  			redirect('account/login');
		}

		$data['no_address'] = 'You don\'t have any stored address(s)';

		$data['addresses'] = array();
		$results = $this->Customers_model->getAddresses($this->customer->getId());
		if ($results) {
			foreach ($results as $result) {
				$data['addresses'][] = array(
					'address_1' 	=> $result['address_1'],
					'address_2' 	=> $result['address_2'],
					'city' 			=> $result['city'],
					'postcode' 		=> $result['postcode'],
					'country' 		=> $result['country'],		
					'edit' 			=> $this->config->site_url('account/address/edit/' . $result['address_id']),
					'delete' 		=> $this->config->site_url('account/address/delete/' . $result['address_id'])
				);
			}
		}
		

		/*if (($this->input->post('submit') === 'Save Details') && ($this->_updateDetails() === TRUE)) {
		
			$this->session->set_flashdata('alert', 'Details Updated Sucessfully!');
				
			redirect('account/details');
		}

		if (($this->input->post('submit') === 'Change Password') && ($this->_changePassword() === TRUE)) {
		
			$this->session->set_flashdata('alert', 'Password Changed Sucessfully!');
				
			redirect('account/details');
		}*/

		$this->load->view('main/header', $data);
		$this->load->view('main/address', $data);
		$this->load->view('main/footer');
	}

	public function _updateDetails() {
						
		$update = array();

		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]|max_length[12]');
		$this->form_validation->set_rules('last_name', 'First Name', 'trim|required|min_length[2]|max_length[12]');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('telephone', 'Telephone', 'trim|required|integer');
		$this->form_validation->set_rules('security_question', 'Security Question', 'required');
		$this->form_validation->set_rules('security_answer', 'Security Answer', 'required');

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
					
			if ($this->input->post('email') !== $this->customer->getEmail()) {
				$update['email'] = $this->input->post('email');
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

			if (!empty($update)) {
				$this->Customers_model->updateCustomer($customer_id, $update);						
			}
			
			return TRUE;
		}
	}

	public function _changePassword() {
		$new_password = '';

		$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|min_length[6]|max_length[32]|callback_check_old_password');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[32]|matches[confirm_new_password]');
		$this->form_validation->set_rules('confirm_new_password', 'Confirm New Password', 'trim|required');

	  	if ($this->form_validation->run() === TRUE) {
			if ($this->customer->getId()) {  
				$customer_id = $this->customer->getId();
			}

 			if ($this->input->post('new_password') !== $this->customer->getPassword()) {
				$new_password = $this->input->post('new_password');
			}			 	

			if (!empty($new_password)) {
				$this->Customers_model->changePassword($customer_id, $new_password);						
			}

			return TRUE;
		}
	}

 	public function check_old_password($pwd) {
      		
		if (md5($pwd) !== $this->customer->getPassword()) {
        	$this->form_validation->set_message('check_old_password', 'The %s you entered is invalid.');
      		return FALSE;
    	} else {
        	return TRUE;        
      	}
    }
}
