<?php
class Staffs extends MX_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Staffs_model');
		$this->load->model('Locations_model'); // load the locations model
		$this->load->model('Departments_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
			
		if ( !file_exists('application/views/admin/staffs.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/staffs')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = 1;
		}
		
		if ($this->config->item('config_page_limit')) {
			$filter['limit'] = $this->config->item('config_page_limit');
		}
				
		$data['heading'] 			= 'Staffs';
		$data['sub_menu_add'] 		= 'Add';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['sub_menu_list'] 		= '<li><a id="menu-add">Add new staff</a></li>';
		$data['text_empty'] 		= 'There are no staff(s).';

		$data['staffs'] = array();				
		$results = $this->Staffs_model->getList($filter);
		foreach ($results as $result) {
			
			$data['staffs'][] = array(
				'staff_id' 			=> $result['staff_id'],
				'staff_name' 		=> $result['staff_name'],
				'staff_email' 		=> $result['staff_email'],
				'staff_department' 	=> $result['department_name'],
				'staff_location' 	=> $result['location_name'],
				'date_added' 		=> mdate('%d-%m-%Y', strtotime($result['date_added'])),
				'staff_status' 		=> $result['staff_status'],
				'edit' 				=> $this->config->site_url('admin/staffs/edit/' . $result['staff_id'])
			);
		}
				
		$data['departments'] = array();
		$results = $this->Departments_model->getDepartments();
		foreach ($results as $result) {					
			$data['departments'][] = array(
				'department_id'		=>	$result['department_id'],
				'department_name'	=>	$result['department_name']
			);
		}

		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {					
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
			);
		}

		$config['base_url'] 		= $this->config->site_url('admin/staffs');
		$config['total_rows'] 		= $this->Staffs_model->record_count();
		$config['per_page'] 		= $filter['limit'];
		$config['num_links'] 		= round($config['total_rows'] / $config['per_page']);
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		// check if POST, validate fields and add Staff to model
		if ($this->input->post() && $this->_addStaff() === TRUE) {
		
			redirect('admin/staffs');
		}

		//check if POST update_deal then remove deal_id
		if ($this->input->post('delete') && $this->_deleteStaff() === TRUE) {
			
			redirect('admin/staffs');  			
		}	

		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/staffs', $data);
		$this->load->view('admin/footer');
	}

	public function edit() {
		
		if ( !file_exists('application/views/admin/staffs_edit.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/staffs')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		//check if customer_id is set in uri string
		if ($this->uri->segment(4)) {
			$staff_id = (int)$this->uri->segment(4);
		} else {
		    redirect('admin/staffs');
		}

		$staff_info = $this->Staffs_model->getStaff($staff_id);
		
		if ($staff_info) {
			$data['heading'] 			= 'Staffs';
			$data['sub_menu_update'] 	= 'Update';
			$data['sub_menu_back'] 		= $this->config->site_url('admin/staffs');

			//$question_staff_info = $this->Customers_model->getSecurityQuestions($staff_info['security_question_id']); 

			$data['staff_name'] 		= $staff_info['staff_name'];
			$data['staff_email'] 		= $staff_info['staff_email'];
			$data['staff_department'] 	= $staff_info['staff_department'];
			$data['staff_location'] 	= $staff_info['staff_location'];
			$data['staff_status'] 		= $staff_info['staff_status'];

			$result = $this->Staffs_model->getStaffUser($staff_id);
			$data['username'] 			= $result['username'];
			//$data['department'] 		= $result['department'];

			$data['departments'] = array();
			$results = $this->Departments_model->getDepartments();
			foreach ($results as $result) {					
				$data['departments'][] = array(
					'department_id'		=>	$result['department_id'],
					'department_name'	=>	$result['department_name']
				);
			}

			$data['locations'] = array();
			$results = $this->Locations_model->getLocations();
			foreach ($results as $result) {					
				$data['locations'][] = array(
					'location_id'	=>	$result['location_id'],
					'location_name'	=>	$result['location_name'],
				);
			}
		
			if ($this->input->post() && $this->_updateStaff($staff_id, $data['staff_email'], $data['username']) === TRUE) {
		
				redirect('admin/staffs');
	
			}

			//Remove Customer
			if ($this->input->post('delete') && $this->_deleteStaff($staff_id)) {
					
				redirect('admin/staffs');
			}
		}
		
		//load customer_edit page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/staffs_edit', $data);
		$this->load->view('admin/footer');
	}

	public function _addStaff() {
									
    	if (!$this->user->hasPermissions('modify', 'admin/staffs')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else if ( ! $this->input->post('delete')) { 

			$add = array();

			//form validation
			$this->form_validation->set_rules('staff_name', 'Staff Name', 'trim|required|min_length[2]|max_length[128]');
			$this->form_validation->set_rules('staff_email', 'Staff Email', 'trim|required|valid_email|is_unique[staffs.staff_email]|max_length[96]');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[users.username]|min_length[2]|max_length[32]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[32]|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', 'Password Confirm', 'trim|required');
			$this->form_validation->set_rules('department', 'Staff Department', 'trim|required|integer');
			$this->form_validation->set_rules('staff_location', 'Location Name', 'trim|required|integer');
			$this->form_validation->set_rules('staff_status', 'Status', 'trim|integer');

			//if validation is true
			if ($this->form_validation->run() === TRUE) {

				//Sanitizing the POST values
				$add['staff_name']			= $this->input->post('staff_name');
				$add['staff_email']			= $this->input->post('staff_email');
				$add['username']			= $this->input->post('username');
				$add['password']			= $this->input->post('password');
				//$add['user_id']			= $this->input->post('staff_user');
				$add['staff_department']	= $this->input->post('department');
				$add['staff_location']		= $this->input->post('staff_location');
				$add['staff_status']		= $this->input->post('staff_status');
				
				if ($this->Staffs_model->addStaff($add)) {
				
					$this->session->set_flashdata('alert', '<p class="success">Staff Added Sucessfully!</p>');
			
				} else {
			
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
				}
			
				return TRUE;
			}	
		}
	}
	
	public function _updateStaff($staff_id, $staff_email, $username) {
    	if (!$this->user->hasPermissions('modify', 'admin/staffs')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else if ( ! $this->input->post('delete')) { 
								

			$this->form_validation->set_rules('staff_name', 'Staff Name', 'trim|required|min_length[2]|max_length[128]');
		
			if ($staff_email !== $this->input->post('staff_email')) {
				$this->form_validation->set_rules('staff_email', 'Staff Email', 'trim|required|valid_email|is_unique[staffs.staff_email]|max_length[96]');
			}
		
			if ($username !== $this->input->post('username')) {
				$this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[users.username]|min_length[2]|max_length[32]');
			}
		
			$this->form_validation->set_rules('department', 'Staff Department', 'trim|required|integer');
			$this->form_validation->set_rules('staff_location', 'Location Name', 'trim|required|integer');
			$this->form_validation->set_rules('staff_status', 'Status', 'trim|integer');
			
			if ($this->form_validation->run() === TRUE) {				
				$update = array();
				
				//Sanitizing the POST values
				$update['staff_id']		= $staff_id;
				$update['staff_name']	= $this->input->post('staff_name');
			
				if ($staff_email !== $this->input->post('staff_email')) {
					$update['staff_email']	= $this->input->post('staff_email');
				} else {
					$update['staff_email']	= $staff_email;
				}
			
				if ($username !== $this->input->post('username')) {
					$update['username']	= $this->input->post('username');
				}
			
				$update['staff_department']	= $this->input->post('department');
				$update['staff_location']	= $this->input->post('staff_location');
				$update['staff_status']		= $this->input->post('staff_status');
				
				if ($this->Staffs_model->updateStaff($update)) {
				
					$this->session->set_flashdata('alert', '<p class="success">Staff Updated Sucessfully!</p>');
			
				} else {
			
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
				}
			
				return TRUE;
			}
		}
	}

	public function _deleteStaff($staff_id = FALSE) {
    	if (!$this->user->hasPermissions('modify', 'admin/staffs')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
    	} else { 
		
			if (is_array($this->input->post('delete'))) {

				//sorting the post[remove_deal] array to rowid and qty.
				foreach ($this->input->post('delete') as $key => $value) {
					$staff_id = $value;
				
					$this->Staffs_model->deleteStaff($staff_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Staff(s) Deleted Sucessfully!</p>');

			}
		}
				
		return TRUE;
	}
}