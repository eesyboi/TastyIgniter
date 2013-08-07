<?php
class Customers extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Customers_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
			
		//check if file exists in views
		if ( !file_exists('application/views/admin/customers.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		if ($this->uri->segment(3)) {
			$page = $this->uri->segment(3);
		} else {
			$page = 0;
		}
				
		$config['base_url'] = $this->config->site_url('admin/customers');
		$config['total_rows'] = $this->Customers_model->record_count();
		$config['per_page'] = 20;
		$config['uri_segment'] = 3;
		$choice = $config['total_rows'] / $config['per_page'];
		$config['num_links'] = round($choice);
		$config['use_page_numbers'] = TRUE;
		
		$this->pagination->initialize($config);
		
		$data['title'] = 'Customers Management';
		$data['text_no_customers'] = 'There are no customer(s).';
		//$data['error'] = '';

		$results = $this->Customers_model->getList($config['per_page'], $page);

		if ($results) {
			foreach ($results as $result) {
				
				//load categories data into array
				$data['customers'][] = array(
					'customer_id' 		=> $result['customer_id'],
					'first_name' 		=> $result['first_name'],
					'last_name'			=> $result['last_name'],
					'email' 			=> $result['email'],
					'telephone' 		=> $result['telephone'],
					'security_question' => $result['security_question_id'],
					'security_answer' 	=> $result['security_answer'],
					'edit' 				=> $this->config->site_url('admin/customers/edit/' . $result['customer_id'])
				);
			}
		}

		//load category data into array
		$data['security_questions'] = array();
		$results = $this->Customers_model->getSecurityQuestions();
		foreach ($results as $result) {					
			$data['security_questions'][] = array(
				'question_id'	=>	$result['question_id'],
				'question_text'	=>	$result['question_text']
			);
		}

				
		$data['pagination'] = array(
			'info'		=> '(Showing: ' . $config['per_page'] . ' of ' . $config['total_rows'] . ')',
			'links'		=> $this->pagination->create_links()
		);

		//if POST sumbit is Register then call the _addCustomer method
		if (($this->input->post('submit') === 'Add') && ($this->_addCustomer() === TRUE)) {
		
			$this->session->set_flashdata('alert', 'Customer Added Sucessfully!');
			redirect('admin/customers');
		}

		//check if POST update_deal then remove deal_id
		if (($this->input->post('submit') === 'Delete') && $this->input->post('delete')) {
			
			//sorting the post[remove_deal] array to rowid and qty.
			foreach ($this->input->post('delete') as $key => $value) {
            	$customer_id = $key;
            	
				$this->Customers_model->deleteCustomer($customer_id);
			}			
			
			$this->session->set_flashdata('alert', 'Customer(s) Deleted Sucessfully!');

			redirect('admin/customers');  			
		}	

		//load customer page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/customers', $data);
		$this->load->view('admin/footer');
	}
	
	public function edit() {
		//check if file exists in views
		if ( !file_exists('application/views/admin/customers_edit.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

		//check if customer_id is set in uri string
		if ($this->uri->segment(4)) {
			$customer_id = (int)$this->uri->segment(4);
		} else {
		    redirect('admin/foods');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		$data['title'] = 'Customers Management';
		$data['action'] = $this->config->site_url('admin/customers/edit/' . $customer_id);

		$result = $this->Customers_model->getCustomer($customer_id);
		//$question_result = $this->Customers_model->getSecurityQuestions($result['security_question_id']); 

		$data['first_name'] 		= $result['first_name'];
		$data['last_name'] 			= $result['last_name'];
		$data['email'] 				= $result['email'];
		$data['telephone'] 			= $result['telephone'];
		$data['security_question'] 	= $result['security_question_id'];
		$data['security_answer'] 	= $result['security_answer'];

		$data['questions'] = array();
		$results = $this->Customers_model->getSecurityQuestions();
		foreach ($results as $result) {
			$data['questions'][] = array(
				'id'	=> $result['question_id'],
				'text'	=> $result['question_text']
			);
		}

		if (($this->input->post('submit') === 'Update') && ( ! $this->input->post('delete'))) {
		
			if ($this->_updateCustomer($customer_id) === TRUE) {
				$this->session->set_flashdata('alert', 'Customer Updated Sucessfully!');
	
				redirect('admin/customers');
	
			}
		}

		//Remove Customer
		if (($this->input->post('submit') === 'Update') && $this->input->post('delete')) {
					
			$this->Customers_model->deleteCustomer($customer_id);
					
			$this->session->set_flashdata('alert', 'Customer Removed Sucessfully!');

			redirect('admin/customers');
		}

		//load customer_edit page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/customers_edit', $data);
		$this->load->view('admin/footer');
	}

	public function _addCustomer() {
						
		//validate form
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]|max_length[12]');
		$this->form_validation->set_rules('last_name', 'First Name', 'trim|required|min_length[2]|max_length[12]');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|is_unqiue[customers.email]');
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
			$this->Customers_model->addCustomer($first_name, $last_name, $email, $password, $telephone, $security_question_id, $security_answer);	
  				
  			return TRUE;		
		}
	}

	public function _updateCustomer($customer_id) {
						
		$update = array();
		$new_password = '';

		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]|max_length[12]');
		$this->form_validation->set_rules('last_name', 'First Name', 'trim|required|min_length[2]|max_length[12]');
		$this->form_validation->set_rules('telephone', 'Telephone', 'trim|required|integer');
		$this->form_validation->set_rules('security_question', 'Security Question', 'required');
		$this->form_validation->set_rules('security_answer', 'Security Answer', 'required');

		if ($this->input->post('new_password')) {
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[32]|matches[confirm_new_password]|md5');
			$this->form_validation->set_rules('confirm_new_password', 'Confirm New Password', 'trim|required|md5');
		}
			
  		if ($this->form_validation->run() === TRUE) {
				
			$update['first_name'] = $this->input->post('first_name');
			$update['last_name'] = $this->input->post('last_name');
			$update['telephone'] = $this->input->post('telephone');
			$update['security_question_id'] = $this->input->post('security_question');
			$update['security_answer'] = $this->input->post('security_answer');
			$new_password = $this->input->post('new_password');

			if (!empty($update) || !empty($new_password)) {
				$this->Customers_model->updateCustomer($customer_id, $update);						
				$this->Customers_model->changePassword($customer_id, $new_password);						
				
				return TRUE;
			} else {
	
				return FALSE;
			}
		}
	}
}
