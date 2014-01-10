<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Local_mod extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->library('location'); 														// load the location library
	}

	public function index() {
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
		$this->lang->load('main/home');  														// loads language file
		
		if ( !file_exists('application/extensions/module/views/local_mod.php')) { 								//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_local'] 			= $this->lang->line('text_local');
		$data['text_find'] 				= $this->lang->line('text_find');
		$data['text_postcode'] 			= $this->lang->line('text_postcode');
		$data['text_postcode_warning'] 	= $this->lang->line('text_postcode_warning');
		$data['text_delivery_charge'] 	= $this->lang->line('text_delivery_charge');
		$data['text_min_total'] 		= $this->lang->line('text_min_total');

		$data['button_check_postcode'] 	= $this->lang->line('button_check_postcode');
		// END of retrieving lines from language file to send to view.

		$data['continue'] 			= $this->config->site_url('menus');
		$data['checkout'] 			= $this->config->site_url('checkout');


		$data['local_location'] = $this->location->local(); 									// retrieve local location data
		
		if ($this->location->isOpened()) { 														// check if local location is open
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
		
		if ($this->location->getDeliveryCharge() > 0) {
			$data['delivery_charge'] = $this->currency->format($this->location->getDeliveryCharge());
		} else {
			$data['delivery_charge'] = $this->lang->line('text_free');
		}
		
		if ($this->location->getMinTotal() > 0) {
			$data['min_total'] = $this->currency->format($this->location->getMinTotal());
		} else {
			$data['min_total'] = $this->lang->line('text_none');
		}
		
		// pass array $data and load view files
		$this->load->view('module/local_mod', $data);
	}		

	public function distance() {
		$this->load->library('user_agent');
		$this->lang->load('main/home');  														// loads home language file
		
		$this->session->unset_userdata('local_location');										// unset local_location session userdata to set later
		
		if ( ! $this->input->post('postcode')) {												// check if $_POST postcode is not available
			redirect($this->agent->referrer());													// redirect to home page
		}
		
		$output = $this->getLatLng($this->input->post('postcode'));								// validate $_POST postcode data using getLatLng() method and return latitude and longitude if successful
			
		if ($output['status'] === 'OK') {															// check if geocoding is successful
			
			$lat = $output['lat'];																// store the latitute from geocode data in variable
			$lng = $output['lng'];																// store the longitude from geocode data in variable
		
			if ( ! $this->Locations_model->getLocalRestaurant($lat, $lng)) {					// check if longitude and latitude doesnt have a nearest local restaurant from getLocalRestaurant() method in Locations model.
				
				$this->session->set_flashdata('alert', $this->lang->line('text_no_restaurant'));	// display error: no available restaurant
							
			}
		} else {																				// else if geocoding isn't successful and geocode data is not returned
			
			$this->session->set_flashdata('alert', $this->lang->line('text_invalid_postcode'));	// display error: invalid postcode
		
		} 					
		
		redirect($this->agent->referrer());														// redirect to home page
	}
	
	function getLatLng($postcode) {																// method to perform regular expression match on postcode string and return latitude and longitude
		$postcode = strtoupper(str_replace(' ', '', $postcode));								// strip spaces from postcode string and convert to uppercase
		
		if ($this->config->item('config_search_by') === 'postcode') {
	
			// checks if postcode string matches regular expression
			if (preg_match("/^[A-Z]{1,2}[0-9]{2,3}[A-Z]{2}$/", $postcode) || 
			preg_match("/^[A-Z]{1,2}[0-9]{1}[A-Z]{1}[0-9]{1}[A-Z]{2}$/", $postcode) || 
			preg_match("/^GIR0[A-Z]{2}$/", $postcode)) {

				$url  = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($postcode) .'&sensor=false&region=GB'; //encode $postcode string and construct the url query
		
				$geocode_data = file_get_contents($url);
		
			} else {
				$result['status'] = 'FAIL';
			}
		
		} else if ($this->config->item('config_search_by') === 'address') {
		
			$url  = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($postcode) .'&sensor=false&region=GB'; //encode $postcode string and construct the url query
	
			$geocode_data = file_get_contents($url);
		
		} else {
			$result['status'] = 'FAIL';
		}


		if (isset($geocode_data)) {																// Get content of the url and return the geocode data as json object
	
			$output = json_decode($geocode_data);											// decode the geocode data
			
			if ($output->status === 'OK') {														// create variable for geocode data status
				$result['status'] = 'OK';
				$result['lat'] = $output->results[0]->geometry->location->lat;
				$result['lng'] = $output->results[0]->geometry->location->lng;
			}
		} else {
			$result['status'] = 'FAIL';
		}
		
		return $result;																	// return postcode object if theres match
	}
}