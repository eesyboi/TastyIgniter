<?php
class Pages extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Locations_model');
	}

	public function view($page = 'home') {
			
		if ( !file_exists('application/views/pages/'.$page.'.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}
	
		$data['title'] = ucfirst($page); // Capitalize the first letter
		$data['locations'] = $this->Locations_model->getLocations();

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('locations', 'Locations', 'callback_locations_check');
	
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('templates/header', $data);
				$this->load->view('pages/home', $data);
				$this->load->view('templates/footer');
			}
			
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);

	}
	
	public function locations_check($location)
	{
		if ($location == '0') {
			$this->form_validation->set_message('locations_check', 'The %s field is required');
			return FALSE;
		} else {
			return TRUE;
		}
	}
}