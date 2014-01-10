<?php
class Account_module extends MX_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Extensions_model');	    
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
			
		//check if file exists in views
		if ( !file_exists('application/views/admin/account_module.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/account_module')) {
  			redirect('admin/permission');
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		
				
		$data['heading'] 			= 'Account';
		$data['sub_menu_update'] 	= 'Update';
		$data['sub_menu_back'] 		= $this->config->site_url('admin/extensions');

		if ($this->input->post('modules')) {
			$modules = $this->input->post('modules');
		} else if ($this->config->item('account_module')) {
			$modules = unserialize($this->config->item('account_module'));
		} else {
			$modules = array();
		}
		
		$data['modules'] = array();
		foreach ($modules as $module) {
	
			$data['modules'][] = array(
				'uri_route'		=> $module['uri_route'],
				'position' 		=> $module['position'],
				'priority' 		=> $module['priority'],
				'status' 		=> $module['status']
			);
		}

		if ($this->input->post() && $this->_updateModule() === TRUE){
						
			redirect('admin/extensions');
		}
		
		$this->load->view('admin/header', $data);
		$this->load->view('admin/account_module', $data);
		$this->load->view('admin/footer');
	}

	public function _updateModule() {
						
    	if (!$this->user->hasPermissions('modify', 'admin/account_module')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
			return TRUE;
    	
    	} else if ($this->input->post('modules')) { 
			
			$update = array();
			
			$update = $this->input->post('modules');

			if ($this->Settings_model->updateSettings('account', array('account_module' => serialize($update)))) {
		
				$this->session->set_flashdata('alert', '<p class="success">Account Module Updated Sucessfully!</p>');
			} else {
		
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
			}
		
			return TRUE;
		}
	}
}