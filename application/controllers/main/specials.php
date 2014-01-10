<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Specials extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->model('Menus_model'); 														// load the menus model
		$this->load->model('Specials_model'); 													// load the specials model
	}

	public function index() {
		$this->load->library('currency'); 														// load the currency library
		$this->load->model('Reviews_model'); 													// load the reviews model
		$this->load->library('location'); 														// load the location library
		$this->load->model('Locations_model'); 													// load the locations model
		$this->lang->load('main/specials');  													// loads language file

		if ( !file_exists('application/views/main/specials.php')) { 							//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}
		
		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 				= $this->lang->line('text_heading');
		$data['text_empty'] 				= $this->lang->line('text_empty');
		$data['text_categories'] 			= $this->lang->line('text_categories');
		$data['text_category'] 				= $this->lang->line('text_category');
		$data['text_clear'] 				= $this->lang->line('text_clear');
		$data['text_specials'] 				= $this->lang->line('text_specials');
		$data['text_local'] 				= $this->lang->line('text_local');
		$data['text_find'] 					= $this->lang->line('text_find');
		$data['button_check_postcode'] 		= $this->lang->line('button_check_postcode');
		$data['button_checkout'] 			= $this->lang->line('button_checkout');
		$data['button_add'] 				= $this->lang->line('button_add');
		$data['button_review'] 				= $this->lang->line('button_review');
		$data['text_postcode'] 				= $this->lang->line('text_postcode');
		$data['text_postcode_warning'] 		= $this->lang->line('text_postcode_warning');
		$data['text_delivery_charge'] 		= $this->lang->line('text_delivery_charge');
		$data['text_filter'] 				= $this->lang->line('text_filter');
		$data['text_reviews'] 				= $this->lang->line('text_reviews');
		$data['column_id'] 					= $this->lang->line('column_id');
		$data['column_photo']	 			= $this->lang->line('column_photo');
		$data['column_menu'] 				= $this->lang->line('column_menu');
		$data['column_price'] 				= $this->lang->line('column_price');
		$data['column_action'] 				= $this->lang->line('column_action');
		// END of retrieving lines from language file to send to view.
				
		$data['continue'] 					= $this->config->site_url('menus');
		$data['checkout'] 					= $this->config->site_url('checkout');
				
		$data['local_location'] = $this->location->local(); 									// retrieve local location data from location library
		
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
		
		$data['quantities'] = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10');

		$data['menu_reviews'] = $this->Reviews_model->getTotalReviews(); 						// retrieve total reviews of each menus from getTotalReviews() in Reviews model.

		//load menus data into array	
		$data['specials'] = array();		
		$results = $this->Specials_model->getMainSpecials(); 									// retrieve specials array from getMainSpecials method in Specials model
		foreach ($results as $result) {															// loop through specials array

			if ($result['menu_photo']) {
				$menu_photo_src = $this->config->base_url('assets/img/' . $result['menu_photo']);	// create menu photo full path based on config base_url
			} else {
				$menu_photo_src = $this->config->base_url('assets/img/no_menu_photo.png');		// create no photo full path based on config base_url
			}

			$daydiff = '';
			if (!empty($result['end_date'])) { 													// checks if end_date is set
				// calculate days difference between current time and end date then round number to whole number
				$daydiff = floor((strtotime($result['end_date']) - strtotime($this->location->currentTime())) / 86400 );
				
				if ($daydiff < 0) { 															// check if day difference is less than zero
					$end_date = sprintf($this->lang->line('text_end_today'));					// display: Ends today
				} else {
					$end_date = sprintf($this->lang->line('text_end_days'), $daydiff);			// display: Ends in x days
				}
			}
			
			$data['specials'][] = array( 														// create array of menu data to pass to view
				'menu_id'			=>	$result['menu_id'],
				'menu_name'			=>	$result['menu_name'],
				'menu_description'	=>	$result['menu_description'],
				'menu_price'		=>	$this->currency->format($result['menu_price']), 		// add currency symbol and format price to two decimal places
				'special_price'		=>	$this->currency->format($result['special_price']), 		// add currency symbol and format price to two decimal places
				'start_date'		=>	$result['start_date'],
				'end_date'			=>	$result['end_date'],
				'end_days'			=>	$end_date,
				'menu_photo'		=>	$menu_photo_src,
			);
		}	

		$data['categories'] = array();
		$results = $this->Menus_model->getCategories(); 										// retrieve all available menu categories from getCategories() method in Menus model
		foreach ($results as $result) {					
			$data['categories'][] = array( 														// create array of category data to pass to view
				'category_id'	=>	$result['category_id'],
				'category_name'	=>	$result['category_name'],
				'href'			=>	$this->config->site_url('menus/category/' . $result['category_id'])
			);
		}
		
		// pass array $data and load view files
		$this->load->view('main/header', $data);
		$this->load->view('main/specials', $data);
		$this->load->view('main/footer');
	}

}