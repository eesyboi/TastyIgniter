<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

<<<<<<< HEAD
class Address extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->model('Customers_model');													// load the customers model
		$this->load->model('Locations_model'); 													// load the locations model
		$this->load->model('Countries_model');
	}

	public function index() {
		$this->lang->load('main/address');  													// loads language file
		
		if ( !file_exists('application/views/main/address.php')) { 								//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
=======
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
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
		} else {
			$data['alert'] = '';
		}

<<<<<<< HEAD
		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		}

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_edit_address'] 		= $this->lang->line('text_edit_address');
		$data['text_no_address'] 		= $this->lang->line('text_no_address');
		$data['text_edit'] 				= $this->lang->line('text_edit');

		$data['entry_address_1'] 		= $this->lang->line('entry_address_1');
		$data['entry_address_2'] 		= $this->lang->line('entry_address_2');
		$data['entry_city'] 			= $this->lang->line('entry_city');
		$data['entry_postcode'] 		= $this->lang->line('entry_postcode');
		$data['entry_country'] 			= $this->lang->line('entry_country');
		
		$data['button_back'] 			= $this->lang->line('button_back');
		$data['button_add'] 			= $this->lang->line('button_add');
		// END of retrieving lines from language file to pass to view.
		
		$data['continue'] 				= $this->config->site_url('account/address/edit');
		$data['back'] 					= $this->config->site_url('account');


		$data['addresses'] = array();
		$results = $this->Customers_model->getCustomerAddresses($this->customer->getId());								// retrieve customer address data from getCustomerAddresses method in Customers model
		if ($results) {
			foreach ($results as $result) {														// loop through the customer address data
				$data['addresses'][] = array(													// create array of customer address data to pass to view
					'address_id'	=> $result['address_id'],
=======
		if (!$this->customer->isLogged()) {  
  			redirect('account/login');
		}

		$data['no_address'] = 'You don\'t have any stored address(s)';

		$data['addresses'] = array();
		$results = $this->Customers_model->getAddresses($this->customer->getId());
		if ($results) {
			foreach ($results as $result) {
				$data['addresses'][] = array(
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
					'address_1' 	=> $result['address_1'],
					'address_2' 	=> $result['address_2'],
					'city' 			=> $result['city'],
					'postcode' 		=> $result['postcode'],
					'country' 		=> $result['country'],		
<<<<<<< HEAD
					'edit' 			=> $this->config->site_url('account/address/edit/' . $result['address_id'])
=======
					'edit' 			=> $this->config->site_url('account/address/edit/' . $result['address_id']),
					'delete' 		=> $this->config->site_url('account/address/delete/' . $result['address_id'])
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
				);
			}
		}
		
<<<<<<< HEAD
		// pass array $data and load view files
		$this->load->view('main/header', $data);
		$this->load->view('main/content_left');
		$this->load->view('main/address', $data);
		$this->load->view('main/footer');
	}

	public function edit() {																	// method to edit customer address
		$this->lang->load('main/address');  													// loads language file
		
		if ( !file_exists('application/views/main/address_edit.php')) { 						//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		} else {																				// else if customer is logged in retrieve customer id from customer library
			$customer_id = $this->customer->getId();
		}

		$this->load->model('Messages_model');													// load the customers model
		$inbox_total = $this->Messages_model->getMainInboxTotal();					// retrieve total number of customer messages from getMainInboxTotal method in Messages model

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_edit_heading');
		$data['text_edit_address'] 		= $this->lang->line('text_edit_address');
		$data['text_new_address'] 		= $this->lang->line('text_new_address');
		$data['text_delete'] 			= $this->lang->line('text_delete');
		
		$data['text_order_now'] 		= $this->lang->line('text_order_now');
		$data['text_edit_details'] 		= $this->lang->line('text_edit_details');
		$data['text_address'] 			= $this->lang->line('text_address');
		$data['text_orders'] 			= $this->lang->line('text_orders');
		$data['text_reservations'] 		= $this->lang->line('text_reservations');
		$data['text_inbox'] 			= sprintf($this->lang->line('text_inbox'), $inbox_total);
		$data['text_logout'] 			= $this->lang->line('text_logout');

		$data['entry_address_1'] 		= $this->lang->line('entry_address_1');
		$data['entry_address_2'] 		= $this->lang->line('entry_address_2');
		$data['entry_city'] 			= $this->lang->line('entry_city');
		$data['entry_postcode'] 		= $this->lang->line('entry_postcode');
		$data['entry_country'] 			= $this->lang->line('entry_country');
		
		$data['button_address'] 		= $this->lang->line('button_address');
		$data['button_update'] 			= $this->lang->line('button_update');
		// END of retrieving lines from language file to pass to view.

		$data['back'] 					= $this->config->site_url('account/address');
		$data['country_id'] 			= $this->config->item('config_country');
		
		$data['address'] = array();
		
		if (is_numeric($this->uri->segment(4))) {												// retrieve if available and check if fouth uri segment is numeric
			$address_id = (int)$this->uri->segment(4);

			$result = $this->Customers_model->getCustomerAddress($customer_id, $address_id);	// if uri segment is available and numeric, retrieve customer address based on uri segment and customer id
			if ($result) {
				$data['address'] = array(														// create array of customer address data to pass to view
					'address_id'	=> $result['address_id'],
					'address_1' 	=> $result['address_1'],
					'address_2' 	=> $result['address_2'],
					'city' 			=> $result['city'],
					'postcode' 		=> $result['postcode'],
					'country_id' 	=> $result['country_id']	
				);
			}		
		}
		
		$data['countries'] = array();
		$results = $this->Countries_model->getCountries();										// retrieve countries data from getCountries method in Locations model
		foreach ($results as $result) {					
			$data['countries'][] = array(														// create array of countries to pass to view
				'country_id'	=>	$result['country_id'],
				'name'			=>	$result['country_name'],
			);
		}
		
		// check if $_POST is set and if update address validation was successful then redirect
		if ($this->input->post() && $this->_updateAddress() === TRUE) {
						
			redirect('account/address');
		}
						
		// Delete Customer Address
		if ($this->input->post() && $this->input->post('delete')) {
				
			$this->Customers_model->deleteAddress($customer_id, $address_id);
				
			$this->session->set_flashdata('alert', $this->lang->line('text_deleted_msg'));

			redirect('account/address');
		}

		// pass array $data and load view files
		$this->load->view('main/header', $data);
		$this->load->view('main/address_edit', $data);
		$this->load->view('main/footer');
	}
	
	public function _updateAddress() {
		
		// START of form validation rules
		$this->form_validation->set_rules('address[address_1]', 'Address 1', 'trim|required|min_length[3]|max_length[128]');
		$this->form_validation->set_rules('address[address_2]', 'Address 2', 'trim|max_length[128]');
		$this->form_validation->set_rules('address[city]', 'City', 'trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('address[postcode]', 'Postcode', 'trim|required|min_length[2]|max_length[10]');
		$this->form_validation->set_rules('address[country]', 'Country', 'trim|required|integer');
		// END of form validation rules

  		if ($this->form_validation->run() === TRUE) {											// checks if form validation routines ran successfully
			$update = array();
			
			if ($this->customer->getId()) {  
				$update['customer_id'] = $this->customer->getId();								// retrieve customer id from customer library and add to update array
			}
		
			if (is_numeric($this->uri->segment(4))) {
				$update['address_id'] = (int)$this->uri->segment(4);							// retrieve address id from fourth uri segment and add to update array
			}

			if ($address_data = $this->input->post('address')) {								// retrieve $_POST address value and add to update array
				$update['address_1'] 	= $address_data['address_1'];
				$update['address_2'] 	= $address_data['address_2'];
				$update['city'] 		= $address_data['city'];
				$update['postcode'] 	= $address_data['postcode'];
				$update['country'] 		= $address_data['country'];
			}
		
			if ($this->Customers_model->updateAddress($update)) {								// check if address updated successfully then display success message else error message
		
				$this->session->set_flashdata('alert', $this->lang->line('text_added_msg'));
		
			} else {
		
				$this->session->set_flashdata('alert', $this->lang->line('text_nothing_msg'));				
		
			}
		
			return TRUE;
		}
	}
=======

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
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
}
