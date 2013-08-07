<?php
class Locations extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->library('location');
		$this->load->library('pagination');
		$this->load->model('Locations_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
			
		//check if file exists in views
		if ( !file_exists('application/views/admin/locations.php')) {
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
		
		$config['base_url'] = $this->config->site_url('admin/locations');
		$config['total_rows'] = $this->Locations_model->record_count();
		$config['per_page'] = 20;
		$config['uri_segment'] = 3;
		$choice = $config['total_rows'] / $config['per_page'];
		$config['num_links'] = round($choice);
		$config['use_page_numbers'] = TRUE;
		
		$this->pagination->initialize($config);

		$data['title'] = 'Manage Restaurant Locations';
		$data['text_no_locations'] = 'There are no restaurant location(s).';

		//load category data into array
		$data['locations'] = array();
		$results = $this->Locations_model->getList($config['per_page'], $page);
		foreach ($results as $result) {					
			$data['locations'][] = array(
				'location_id'			=> $result['location_id'],
				'location_name'			=> $result['location_name'],
				'location_address'		=> $result['location_address'],
				'location_region'		=> $result['location_region'],
				'location_city'			=> $result['location_city'],
				'location_postcode'		=> $result['location_postcode'],
				'location_phone_number'	=> $result['location_phone_number'],
				'location_lat'			=> $result['location_lat'],
				'location_lng'			=> $result['location_lng'],
				'edit' 					=> $this->config->site_url('admin/locations/edit/' . $result['location_id'])
			);
		}
				
		$data['pagination'] = array(
			'info'		=> '(Showing: ' . $config['per_page'] . ' of ' . $config['total_rows'] . ')',
			'links'		=> $this->pagination->create_links()
		);

		// check if POST add_location, validate fields and add Locations to model
		if (($this->input->post('submit') === 'Add') && ($this->_addLocation() === TRUE)) {
		
			$this->session->set_flashdata('alert', 'Location Added Sucessfully!');
			redirect('/admin/locations');
		}

		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/locations', $data);
		$this->load->view('admin/footer');
	}

	public function edit() {
		//check if file exists in views
		if ( !file_exists('application/views/admin/location_edit.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

		$data['title'] = 'Edit Restaurant Location';

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		

		//check if /location_id is set in uri string
		if (is_numeric($this->uri->segment(4))) {
			$location_id = (int)$this->uri->segment(4);
		} else {
		    redirect('admin/locations');
		}
		
		$data['action'] = $this->config->site_url('admin/locations/edit/' . $location_id);

		$data['location_info'] = $this->Locations_model->getLocation($location_id);
		if ($data['location_info']) {
			$data['location_id'] 			= $data['location_info']['location_id'];
			$data['location_name'] 			= $data['location_info']['location_name'];
			$data['location_address'] 		= $data['location_info']['location_address'];
			$data['location_region'] 		= $data['location_info']['location_region'];
			$data['location_city'] 			= $data['location_info']['location_city'];
			$data['location_postcode'] 		= $data['location_info']['location_postcode'];
			$data['location_phone_number'] 	= $data['location_info']['location_phone_number'];
			$data['location_lat'] 			= $data['location_info']['location_lat'];
			$data['location_lng'] 			= $data['location_info']['location_lng'];
		}

		// check if POST add_food, validate fields and add Food to model
		if (($this->input->post('submit') === 'Update') && ( ! $this->input->post('remove')) && ($this->_updateLocation($location_id) === TRUE)) {
		
			$this->session->set_flashdata('alert', 'Location Updated Sucessfully!');
				
			redirect('admin/locations');
		}
								
		//Remove Food
		if ($this->input->post('remove')) {
					
			$this->Locations_model->removeLocation($location_id);
					
			$this->session->set_flashdata('alert', 'Location Removed Sucessfully!');

			redirect('admin/locations');
		}
		
		$this->load->view('admin/header', $data);
		$this->load->view('admin/location_edit', $data);
		$this->load->view('admin/footer');
	}

	public function _addLocation() {
									
		//form validation
		$this->form_validation->set_rules('location_name', 'Location Name', 'trim|required|min_length[2]|max_length[45]');
		$this->form_validation->set_rules('address[address_1]', 'Location Address', 'trim|required|min_length[2]|max_length[45]');
		$this->form_validation->set_rules('address[region]', 'Location Region', 'trim|required|min_length[2]|max_length[45]');
		$this->form_validation->set_rules('address[city]', 'Location City', 'trim|required|min_length[2]|max_length[45]');
		$this->form_validation->set_rules('address[postcode]', 'Location Postcode', 'trim|required|min_length[2]|max_length[45]|callback_get_lat_lag');
		$this->form_validation->set_rules('location_phone_number', 'Location Phone Number', 'trim|required|min_length[2]|max_length[15]');

		//if validation is true
  		if ($this->form_validation->run() === TRUE) {
  		    	
  		    //Sanitizing the POST values
			$location_name 		= $this->input->post('location_name');
			$address 			= $this->input->post('address');
			$location_phone_number 	= $this->input->post('location_phone_number');			
			$location_lat 		= $this->input->post('location_lat');			
			$location_lng 		= $this->input->post('location_lng');					
				
			$this->Locations_model->addLocation($location_name, $address['address_1'], $address['region'], $address['city'], $address['postcode'], $location_phone_number, $location_lat, $location_lng);
					
			return TRUE;
		}	
	}

	public function _updateLocation($location_id) {
									
		//form validation
		$this->form_validation->set_rules('location_name', 'Location Name', 'trim|required|min_length[2]|max_length[45]');
		$this->form_validation->set_rules('address[address_1]', 'Location Address', 'trim|required|min_length[2]|max_length[45]');
		$this->form_validation->set_rules('address[region]', 'Location Region', 'trim|required|min_length[2]|max_length[45]');
		$this->form_validation->set_rules('address[city]', 'Location City', 'trim|required|min_length[2]|max_length[45]');
		$this->form_validation->set_rules('address[postcode]', 'Location Postcode', 'trim|required|min_length[2]|max_length[45]|callback_get_lat_lag');
		$this->form_validation->set_rules('location_phone_number', 'Location Phone Number', 'trim|required|min_length[2]|max_length[15]');

		//if validation is true
  		if ($this->form_validation->run() === TRUE) {
  		    	
  		    //Sanitizing the POST values
			$location_name 		= $this->input->post('location_name');
			$address 			= $this->input->post('address');
			$location_phone_number 	= $this->input->post('location_phone_number');			
			$location_lat 		= $this->input->post('location_lat');			
			$location_lng 		= $this->input->post('location_lng');					
				
			if ($this->input->post('default') === 'SET') {
					
				$this->location->setDefault($location_id);
			}

			$this->Locations_model->updateLocation($location_id, $location_name, $address['address_1'], $address['region'], $address['city'], $address['postcode'], $location_phone_number, $location_lat, $location_lng);
					
			return TRUE;
		}	
	}

	public function get_lat_lag() {
		if (isset($_POST['address']) && is_array($_POST['address']) && !empty($_POST['address']['postcode'])) {			 

			$address_string =  implode(", ", $_POST['address']);
			
			$address = urlencode($address_string);
        	        
			$geocode = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='. $address .'&sensor=false');
        	
    		$output = json_decode($geocode);
    		
    		$status = $output->status;
    		
    		if ($status === 'OK') {
				$_POST['location_lat'] = $output->results[0]->geometry->location->lat;
				$_POST['location_lng'] = $output->results[0]->geometry->location->lng;
			    return TRUE;
    		} else {
        		$this->form_validation->set_message('get_lat_lag', 'The Address you entered failed Geocoding, please enter a different address!');
        		return FALSE;
    		}
        }
	}
}
