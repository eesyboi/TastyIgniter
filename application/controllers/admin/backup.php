<?php
class Backup extends MX_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
			
		if ( !file_exists('application/views/admin/backup.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/backup')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$data['heading'] 			= 'Backup/Restore';
		$data['sub_menu_list'] 		= '<li><a class="update_button" onclick="$(\'#backup\').submit();">Backup</a></li><li><a class="update_button" onclick="$(\'#restore\').submit();">Restore</a></li>';
		$data['text_empty'] 		= 'There are no department(s) added in your database.';

		$data['db_tables'] = $this->db->list_tables();

		// check POST submit, validate fields and send quantity data to model
		if ($this->input->post('backup') && $this->_backup() === TRUE) {
		
		    redirect('admin/backup');
		}

		//check if POST submit then remove quantity_id
		if ($this->input->post('restore') && $this->_restore() === TRUE) {
			
		    redirect('admin/backup');
		}	

		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/backup', $data);
		$this->load->view('admin/footer');
	}

	public function _backup() {

    	if (!$this->user->hasPermissions('modify', 'admin/backup')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else { 
								
			//form validation

			$this->form_validation->set_rules('backup[]', 'Backup', 'trim');

			//if validation is true
			if ($this->form_validation->run() === TRUE) {

				// Load the DB utility class
				$this->load->dbutil();
				$this->load->helper('file');
				$this->load->helper('download');

				$prefs = array(
					'tables'      => $this->input->post('backup'),  // Array of tables to backup.
					'format'      => 'txt',             // gzip, zip, txt
					'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
					'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
					'newline'     => "\n"               // Newline character used in backup file
				);

				$backup =& $this->dbutil->backup($prefs);
				
				force_download('tastyigniter.sql', $backup); 
				return TRUE;
			}	
		}
	}

	public function _restore() {
    	if (!$this->user->hasPermissions('modify', 'admin/backup')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else if (isset($_FILES['restore']) && !empty($_FILES['restore']['name'])) {
			
			if (is_uploaded_file($_FILES['restore']['name'])) {
				$content = file_get_contents($_FILES['restore']['name']);
			} else {
				$content = FALSE;
			}


			if ($this->Settings_model->restoreDatabase($content)) { // calls model to save data to SQL
			
				$this->session->set_flashdata('alert', '<p class="success">Department Updated Sucessfully!</p>');
		
			} else {
		
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');
		
			}
		
			return TRUE;
		}
	}	
}