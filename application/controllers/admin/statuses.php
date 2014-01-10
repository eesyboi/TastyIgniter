<?php
class Statuses extends MX_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->model('Statuses_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
			
		if ( !file_exists('application/views/admin/statuses.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/statuses')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$data['heading'] 			= 'Statuses';
		$data['sub_menu_add'] 		= 'Add';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['sub_menu_list'] 	= '<li><a id="menu-add">Add new status</a></li>';

		//load ratings data into array
		$data['statuses'] = array();
		$results = $this->Statuses_model->getStatuses();
		foreach ($results as $result) {					
			$data['statuses'][] = array(
				'status_id'			=> $result['status_id'],
				'status_name'		=> $result['status_name'],
				'status_comment'	=> $result['status_comment'],
				'edit' 				=> $this->config->site_url('admin/statuses/edit/' . $result['status_id'])				
			);
		}

		// check POST submit, validate fields and send rating data to model
		if ($this->input->post() && $this->_addStatuses() === TRUE) {
		
			redirect('admin/statuses');  			
		}

		//check if POST submit then remove Ratings_id
		if ($this->input->post('delete') && $this->_deleteStatuses() === TRUE) {
			
			redirect('admin/statuses');  			
		}	

		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/statuses', $data);
		$this->load->view('admin/footer');
	}

	public function edit() {
		
		if ( !file_exists('application/views/admin/statuses_edit.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/statuses')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		
		
		//check if /rating_id is set in uri string
		if (is_numeric($this->uri->segment(4))) {
			$status_id = $this->uri->segment(4);
		} else {
		    redirect('admin/statuses');
		}
		
		$status_info = $this->Statuses_model->getStatus($status_id);
		
		if ($status_info) {
			$data['heading'] 			= 'Statuses';
			$data['sub_menu_update'] 	= 'Update';
			$data['sub_menu_back'] 		= $this->config->site_url('admin/statuses');

			$data['status_id'] 		= $status_info['status_id'];
			$data['status_name'] 		= $status_info['status_name'];
			$data['status_comment'] 	= $status_info['status_comment'];

			//check if POST add_Ratings, validate fields and add Ratings to model
			if ($this->input->post() && $this->_updateStatus($status_id) === TRUE) {
						
				redirect('admin/statuses');
			}
						
			//Remove Ratings
			if ($this->input->post('delete') && $this->_deleteStatuses($status_id) === TRUE) {
					
				redirect('admin/statuses');
			}
		}
				
		$this->load->view('admin/header', $data);
		$this->load->view('admin/statuses_edit', $data);
		$this->load->view('admin/footer');
	}

	public function _addStatuses() {
									
    	if (!$this->user->hasPermissions('modify', 'admin/statuses')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
			return TRUE;
    	
    	} else if ( ! $this->input->post('delete')) { 
			
			//validate category value
			$this->form_validation->set_rules('status_name', 'Status Name', 'trim|required|min_length[2]|max_length[32]');
			$this->form_validation->set_rules('status_comment', 'Status Comment', 'trim|required|min_length[2]|max_length[1028]');

			if ($this->form_validation->run() === TRUE) {
				$add = array();
				
				$add['status_name'] = $this->input->post('status_name');
				$add['status_comment'] = $this->input->post('status_comment');
	
				if ($this->Statuses_model->addStatus($add)) {	
				
					$this->session->set_flashdata('alert', '<p class="success"> Status Added Sucessfully!</p>');
				} else {
			
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
				}
			
				return TRUE;
			}
		}
	}
	
	public function _updateStatus($status_id) {
    	
    	if (!$this->user->hasPermissions('modify', 'admin/statuses')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
			return TRUE;
    	
    	} else if ( ! $this->input->post('delete')) { 
			
			$this->form_validation->set_rules('status_name', 'Status Name', 'trim|required|min_length[2]|max_length[32]');
			$this->form_validation->set_rules('status_comment', 'Status Comment', 'trim|required|min_length[2]|max_length[1028]');

			if ($this->form_validation->run() === TRUE) {
				$update = array();
			
				//Sanitizing the POST values
				$update['status_id'] = $status_id;
				$update['status_name'] = $this->input->post('status_name');
				$update['status_comment'] = $this->input->post('status_comment');

				if ($this->Statuses_model->updateStatus($update)) {	
			
					$this->session->set_flashdata('alert', '<p class="success">Status Updated Sucessfully!</p>');
				} else {
			
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
				}
			
				return TRUE;
			}	
		}
	}	

	public function _deleteSecurityQuestion($status_id = FALSE) {
    	if (!$this->user->hasPermissions('modify', 'admin/statuses')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
    	} else { 
		
			if (is_array($this->input->post('delete'))) {

				//sorting the post[quantity] array to rowid and qty.
				foreach ($this->input->post('delete') as $key => $value) {
					$status_id = $value;
			
					$this->Statuses_model->deleteStatus($status_id);
				}			
		
				$this->session->set_flashdata('alert', '<p class="success">Status(es) Deleted Sucessfully!</p>');

			}
		}
				
		return TRUE;
	}
}