<?php
class Security_questions extends MX_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->model('Security_questions_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
			
		if ( !file_exists('application/views/admin/security_questions.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/security_questions')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$data['heading'] = 'Security Questions';
		$data['sub_menu_add'] 		= 'Add';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['sub_menu_list'] 	= '<li><a id="menu-add">Add new security question</a></li>';
		$data['text_empty'] = 'There are no security questions, please add!.';

		//load questions data into array
		$data['questions'] = array();
		$results = $this->Security_questions_model->getSecurityQuestions();
		foreach ($results as $result) {
			$data['questions'][] = array(
				'question_id'	=> $result['question_id'],
				'question_text'	=> $result['question_text'],
				'edit' 			=> $this->config->site_url('admin/security_questions/edit/' . $result['question_id'])
			);
		}

		// check POST submit, validate fields and send quantity data to model
		if ($this->input->post() && $this->_addSecurityQuestion() === TRUE) {
		
			redirect('admin/security_questions');  			
		}

		//check if POST submit then remove quantity_id
		if ($this->input->post('delete') && $this->_deleteSecurityQuestion() === TRUE) {
			
			redirect('admin/security_questions');  			
		}	

		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/security_questions', $data);
		$this->load->view('admin/footer');
	}

	public function edit() {
		
		if ( !file_exists('application/views/admin/security_questions_edit.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/security_questions')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		
		
		//check if /rating_id is set in uri string
		if (is_numeric($this->uri->segment(4))) {
			$question_id = $this->uri->segment(4);
		} else {
		    redirect('admin/security_questions');
		}
		
		$question_info = $this->Security_questions_model->getSecurityQuestion($question_id);

		if ($question_info) {
			$data['heading'] 			= 'Security Questions';
			$data['sub_menu_update'] 	= 'Update';
			$data['sub_menu_back'] 		= $this->config->site_url('admin/security_questions');

			$data['question_id'] 	= $question_info['question_id'];
			$data['question_text'] 	= $question_info['question_text'];

			//check if POST add_security_questions, validate fields and add security_questions to model
			if ($this->input->post() && $this->_updateSecurityQuestion($question_id) === TRUE){
						
				redirect('admin/security_questions');
			}
						
			//Remove security_questions
			if ($this->input->post('delete') && $this->_deleteSecurityQuestion($question_id) === TRUE) {
					
				redirect('admin/security_questions');
			}
		}
				
		$this->load->view('admin/header', $data);
		$this->load->view('admin/security_questions_edit', $data);
		$this->load->view('admin/footer');
	}

	public function _addSecurityQuestion() {
									
    	if (!$this->user->hasPermissions('modify', 'admin/security_questions')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
			return TRUE;
    	
    	} else if ( ! $this->input->post('delete')) { 
			
			//validate category value
			$this->form_validation->set_rules('question_text', 'Security Question', 'trim|required||min_length[2]|max_length[128]');

			if ($this->form_validation->run() === TRUE) {
				$add = array();
			
				$add['question_text'] = $this->input->post('question_text');
	
				if ($this->Security_questions_model->addSecurityQuestion($add)) {	
				
					$this->session->set_flashdata('alert', '<p class="success">Security Question Added Sucessfully!</p>');
				} else {

					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
				}
				
				return TRUE;
			}
		}
	}	

	public function _updateSecurityQuestion($question_id) {
						
    	if (!$this->user->hasPermissions('modify', 'admin/security_questions')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
			return TRUE;
    	
    	} else if ( ! $this->input->post('delete')) { 
			
			$this->form_validation->set_rules('question_text', 'Security Question', 'trim|required||min_length[2]|max_length[128]');

			if ($this->form_validation->run() === TRUE) {
				$update = array();
			
				//Sanitizing the POST values
				$update['question_id'] 		= $question_id;
				$update['question_text'] 	= $this->input->post('question_text');

				if ($this->Security_questions_model->updateSecurityQuestion($update)) {						
			
					$this->session->set_flashdata('alert', '<p class="success">Security Question Updated Sucessfully!</p>');
				} else {
			
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
				}
			
				return TRUE;
			}
		}
	}

	public function _deleteSecurityQuestion($question_id = FALSE) {
    	if (!$this->user->hasPermissions('modify', 'admin/security_questions')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
    	} else { 
		
			if (is_array($this->input->post('delete'))) {

				foreach ($this->input->post('delete') as $key => $value) {
					$quantity_id = $value;
				
					$this->Security_questions_model->deleteSecurityQuestion($quantity_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Security Question(s) Deleted Sucessfully!</p>');

			}
		}
				
		return TRUE;
	}
}