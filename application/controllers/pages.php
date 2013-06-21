<?php
class Pages extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Locations_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function view($page = 'home') {
		$this->load->helper('form');
		$this->load->library('form_validation');
			
		if ( !file_exists('application/views/pages/'.$page.'.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}
	
		$data['title'] = ucfirst($page); // Capitalize the first letter
		$data['locations'] = $this->Locations_model->getLocations();

		$this->form_validation->set_rules('locations', 'Locations', 'callback_locations_check');
		//validate location drop-down
		//if validation is FALSE
		if ($this->form_validation->run() === FALSE)	{
			//load home page content
			$this->load->view('templates/header', $data);
			$this->load->view('pages/'.$page, $data);
			$this->load->view('templates/footer', $data);
		} else {
			//$newdata = array('location' => $locations);
			//$this->session->set_userdata('location', $locations);
			//set location data to session
			//$this->session->set_userdata('location', '$this->input->post('locations')');
			//load food page content
			$this->load->view('templates/header', $data);
			$this->load->view('foods/index', $data);
			$this->load->view('templates/footer');
		}	
	}
	
	public function locations_check($locations) {
		if ($locations === '0') {
			$this->form_validation->set_message('locations_check', 'Please select your nearest restaurant.');
			return FALSE;
		} else {
			return TRUE;
		}
	}
}