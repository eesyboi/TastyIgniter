<?php
class Staffs extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Staffs_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
			
		//check if file exists in views
		if ( !file_exists('application/views/admin/staffs.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

		$data['title'] = 'Staffs Management';
		$data['text_no_staffs'] = 'There are no staff(s).';
		$data['error'] = '';

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}


		$this->load->model('Locations_model');
		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {					
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
			);
		}

		$staffs = array();				
		$results = $this->Staffs_model->getStaffs();
		//check if sql query was successful and create variables
		if ($results) {
			foreach ($results as $result) {
				
				//load categories data into array
				$data['staffs'][] = array(
					'staff_id' 			=> $result['staff_id'],
					'staff_name' 		=> $result['staff_name'],
					'staff_email' 		=> $result['staff_email'],
					'staff_location' 	=> $result['location_name'],
					'staff_status' 			=> $result['staff_status'],
					'permission_level' 	=> $result['permission_level'],
					'edit' 				=> $this->config->site_url('admin/staffs/edit/' . $result['staff_id'])
				);
			}
		}
				
		// check if POST, validate fields and add Staff to model
		if (($this->input->post('submit') === 'Add') && ($this->_addStaff() === TRUE)) {
		
			$this->session->set_flashdata('alert', 'Staff Added Sucessfully!');
			redirect('/admin/staffs');
		}

		//check if POST update_deal then remove deal_id
		if (($this->input->post('submit') === 'Remove') && $this->input->post('remove')) {
			
			//sorting the post[remove_deal] array to rowid and qty.
			foreach ($this->input->post('remove') as $key => $value) {
            	$deal_id = $key;
            	
				$this->Staffs_model->removeStaff($staff_id);
			}			
			
			$this->session->set_flashdata('alert', 'Staff(s) Removed Sucessfully!');

			redirect('admin/staffs');  			
		}	

		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/staffs', $data);
		$this->load->view('admin/footer');
	}

	public function edit() {
		//check if file exists in views
		if ( !file_exists('application/views/admin/staffs_edit.php')) {
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

		//check if customer_id is set in uri string
		if ($this->uri->segment(4)) {
			$staff_id = (int)$this->uri->segment(4);
		} else {
		    redirect('admin/staffs');
		}

		$data['title'] = 'Staffs Management';
		$data['action'] = $this->config->site_url('admin/staffs/edit/' . $staff_id);

		$result = $this->Staffs_model->getStaff($staff_id);
		//$question_result = $this->Customers_model->getSecurityQuestions($result['security_question_id']); 

		$data['staff_name'] 		= $result['staff_name'];
		$data['staff_email'] 		= $result['staff_email'];
		$data['staff_location'] 	= $result['staff_location'];
		$data['user'] 				= $result['user_id'];
		$data['permission'] 		= $result['permission_level'];
		$data['staff_status'] 		= $result['staff_status'];

		$this->load->model('Locations_model');
		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {					
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
			);
		}
		
		if (($this->input->post('submit') === 'Update') && ( ! $this->input->post('delete')) && ($this->_updateStaff($staff_id) === TRUE)) {
		
			$this->session->set_flashdata('alert', 'Staff Updated Sucessfully!');
	
			redirect('admin/staffs');
	
		}

		//Remove Customer
		if (($this->input->post('submit') === 'Update') && $this->input->post('delete')) {
					
			$this->Customers_model->deleteStaff($staff_id);
					
			$this->session->set_flashdata('alert', 'Staff Removed Sucessfully!');

			redirect('admin/staffs');
		}

		//load customer_edit page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/staffs_edit', $data);
		$this->load->view('admin/footer');
	}

	public function _addStaff() {
									
		$staff_details = array();

		//form validation
		$this->form_validation->set_rules('staff_name', 'Staff Name', 'trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('staff_email', 'Staff Email', 'trim|required|valid_email|is_unique[staffs.staff_email]|max_length[128]');
		$this->form_validation->set_rules('staff_location', 'Location Name', 'trim|required|numeric');
		$this->form_validation->set_rules('user', 'User ID', 'trim|numeric');
		$this->form_validation->set_rules('staff_status', 'Status', 'trim|numeric');
		$this->form_validation->set_rules('permission', 'Permission Level', 'trim|numeric');

		//if validation is true
  		if ($this->form_validation->run() === TRUE) {

 		    //Sanitizing the POST values
			$staff_details['staff_name']		= $this->input->post('staff_name');
			$staff_details['staff_email']		= $this->input->post('staff_email');
			$staff_details['staff_location']	= $this->input->post('staff_location');
			$staff_details['user_id']			= $this->input->post('user');
			$staff_details['staff_status']		= $this->input->post('staff_status');
			$staff_details['permission_level']	= $this->input->post('permission');			
				
			if (!empty($staff_details)) {
				$this->Staffs_model->addStaff($staff_details);
				return TRUE;
			}
		}	
	}
	
	public function _updateStaff($staff_id) {
						
		$staff_details = array();

		$this->form_validation->set_rules('staff_name', 'Staff Name', 'trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('staff_location', 'Location Name', 'trim|required|numeric');
		$this->form_validation->set_rules('user', 'User ID', 'trim|numeric');
		$this->form_validation->set_rules('staff_status', 'Status', 'trim|numeric');
		$this->form_validation->set_rules('permission', 'Permission Level', 'trim|numeric');
			
  		if ($this->form_validation->run() === TRUE) {
				
 		    //Sanitizing the POST values
			$staff_details['staff_name']		= $this->input->post('staff_name');
			$staff_details['staff_location']	= $this->input->post('staff_location');
			$staff_details['user_id']			= $this->input->post('user');
			$staff_details['staff_status']		= $this->input->post('staff_status');
			$staff_details['permission_level']	= $this->input->post('permission');			
				
			if (!empty($staff_details)) {
				$this->Staffs_model->updateStaff($staff_id, $staff_details);						
				
				return TRUE;
			}
		}
	}
}