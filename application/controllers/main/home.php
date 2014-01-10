<?php

class Home extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->model('Locations_model'); 													// loads the location model
		$this->load->library('location'); 														// load the location library
		$this->load->library('currency'); 														// load the currency library
	}

	public function index() {
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
		$this->lang->load('main/home');  														// loads home language file
					
		if ( !file_exists('application/views/main/home.php')) { 								//check if file exists in views
			show_404(); 																		// Whoops, we don't have a page for that!
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert'); 								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if ($this->session->userdata('user_postcode')) {
			$data['postcode'] = $this->session->userdata('user_postcode'); 						// retrieve session userdata variable if available
		} else {
			$data['postcode'] = '';
		}
		
		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_local'] 			= $this->lang->line('text_local');
		$data['text_postcode'] 			= $this->lang->line('text_postcode');
		$data['text_find'] 				= $this->lang->line('text_find');
		$data['text_delivery_charge'] 	= $this->lang->line('text_delivery_charge');
		$data['text_reviews'] 			= $this->lang->line('text_reviews');
		$data['text_opening_hours'] 	= $this->lang->line('text_opening_hours');
		$data['text_close'] 			= $this->lang->line('text_close');
		$data['text_distance'] 			= $this->lang->line('text_distance');		
		$data['button_view_menu'] 		= $this->lang->line('button_view_menu');
		// END of retrieving lines from language file to send to view.

		$data['local_location'] = $this->location->local(); 									//retrieve local restaurant data from location library
		
		if ($data['local_location']) { 															//if local restaurant data is available
			$data['location_name'] 			= $data['local_location']['location_name'];
			$data['location_address_1'] 	= $data['local_location']['location_address_1'];
			$data['location_city'] 			= $data['local_location']['location_city'];
			$data['location_postcode'] 		= $data['local_location']['location_postcode'];
			$data['location_telephone'] 	= $data['local_location']['location_telephone'];
			$data['distance'] 				= number_format($data['local_location']['distance'],2) .' '. $this->lang->line('text_miles'); //format diatance to 2 decimal place
			$data['delivery_charge']		= ($data['local_location']['delivery_charge'] > 0) ? $this->currency->format($data['local_location']['delivery_charge']) : $this->lang->line('text_free');
			$data['reviews']				= '2 reviews';
		}
		
		$data['opening_hours'] = $this->location->openingHours(); 								//retrieve local restaurant opening hours from location library
		
		if ($this->location->isOpened()) { 														// check if local restaurant is open
			$data['text_open_or_close'] = $this->lang->line('text_opened');						// display we are open
		} else {
			$data['text_open_or_close'] = $this->lang->line('text_closed');						// display we are closed
		}
			
		if ($this->location->offerDelivery()) { 														// checks if cart contents is empty  
			$data['text_delivery'] = $this->lang->line('text_delivery_y');						// display we are open
		} else {
			$data['text_delivery'] = $this->lang->line('text_delivery_n');						// display we are closed
		}

		if ($this->location->offerCollection()) { 														// checks if cart contents is empty  
			$data['text_collection'] = $this->lang->line('text_collection_y');						// display we are open
		} else {
			$data['text_collection'] = $this->lang->line('text_collection_n');						// display we are closed
		}

		//load view files and pass $data array
		$this->load->view('main/header', $data);
		$this->load->view('main/home', $data);
		$this->load->view('main/footer', $data);
	}
	
	public function aboutus() {
		$this->lang->load('main/aboutus');  													// loads home language file
		
		if ( !file_exists('application/views/main/aboutus.php')) { 								// check if file exists in views
			show_404(); 																		// Whoops, we don't have a page for that!
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert'); 								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 		= $this->lang->line('text_heading');
		$data['text_description'] 	= $this->lang->line('text_description');
		// END of retrieving lines from language file to send to view.

		//load view files and pass $data array
		$this->load->view('main/header', $data);
		$this->load->view('main/aboutus', $data);
		$this->load->view('main/footer', $data);
	}

	public function autocomplete() {
		$json = array();
		
		if ($this->input->get('postcode')) {
			$postcode = urldecode($this->input->get('postcode'));
		}
				
		$output = $this->getLatLng($postcode);													// validate $_POST postcode data using getLatLng() method and return latitude and longitude if successful
			
		if ($output['status'] === 'OK') {														// check if geocoding is successful
			$filter_data = array(
				'lat' => $output['lat'],
				'lng' => $output['lng']
			);
	
			$results = $this->Locations_model->getAutoComplete($filter_data);

			if ($results) {
				foreach ($results as $result) {
					$json[] = array (
						'location_id' 		=> $result['location_id'],
						'location_name' 	=> $result['location_name'] .' - '. number_format($result['distance'],2) .' miles'
					);
				}
			}
		}
				
		$this->output->set_output(json_encode($json));
	}
}

/* End of file myfile.php */