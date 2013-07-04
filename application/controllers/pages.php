<?php
class Pages extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Locations_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function home() {
			
		//check if file exists in views
		if ( !file_exists('application/views/main/home.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}
			
		$data['heading'] = 'Welcome To FoodIgniter!';
		
		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {					
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
				'location_address'	=>	$result['location_address'],
				'location_region'	=>	$result['location_region'],
				'location_postcode'	=>	$result['location_postcode'],
				'location_phone_number'	=>	$result['location_phone_number']
			);
		}
			
		//add location_id to sesssion
		if (!empty($this->input->post['locations'])) {
			$this->session->set_userdata('nearest_location', $this->input->post('locations'));
			$this->redirect('main/foods');  			
		}

		//validate location drop-down
		//$this->form_validation->set_rules('locations', 'Locations', 'callback_locations_check');

		//if validation is FALSE
		//if ($this->form_validation->run() === FALSE)	{
		//} else {
			//set location data to session
			//$this->session->set_userdata('nearest_location', $this->input->post('locations'));
		//}	
		//load home page content
		$this->load->view('main/header', $data);
		$this->load->view('main/home', $data);
		$this->load->view('main/footer', $data);
	}
	
	public function aboutus() {
		//check if file exists in views
		if ( !file_exists('application/views/main/aboutus.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		$data['heading'] = 'About FoodIgniter!';

		//load aboutus page content
		$this->load->view('main/header', $data);
		$this->load->view('main/aboutus', $data);
		$this->load->view('main/footer', $data);
	}
}