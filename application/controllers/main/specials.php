<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Specials extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Foods_model');
		$this->load->model('Specials_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
		//check if file exists in views
		if ( !file_exists('application/views/main/specials.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}
		
		$data['heading'] = 'Special Deals';
		$data['text_no_deals'] = 'There are no deals in the selected category.';
				
		$data['continue'] = $this->config->site_url('foods');
		$data['checkout'] = $this->config->site_url('checkout');
		
		$this->load->library('currency');
		
		//load foods data into array	
		$data['deals'] = array();		
		$results = $this->Specials_model->getDeals();
		foreach ($results as $result) {

			if ($result['deal_photo']) {
				$deal_photo_src = $this->config->base_url('assets/img/' . $result['deal_photo']);
			} else {
				$deal_photo_src = $this->config->base_url('assets/img/no_deal_photo.png');
			}

			$data['deals'][] = array(
				'deal_id'			=>	$result['deal_id'],
				'deal_name'			=>	$result['deal_name'],
				'deal_description'	=>	$result['deal_description'],
				'deal_price'		=>	$this->currency->symbol() . $result['deal_price'],
				'start_date'		=>	$result['start_date'],
				'end_date'			=>	$result['end_date'],
				'deal_photo'		=>	$deal_photo_src,
			);
		}	

		//load category data into array
		$data['categories'] = array();
		$results = $this->Foods_model->getCategories();
		foreach ($results as $result) {					
			$data['categories'][] = array(
				'category_id'	=>	$result['category_id'],
				'category_name'	=>	$result['category_name'],
				'href'			=>	$this->config->site_url('foods/category/' . $result['category_id'])
			);
		}
		
		$this->load->model('Reviews_model');
		//load ratings data into array
		$data['ratings'] = array();
		$results = $this->Reviews_model->getRatings();
		foreach ($results as $result) {					
			$data['ratings'][] = array(
				'rating_id'		=>	$result['rating_id'],
				'rating_name'	=>	$result['rating_name']
			);
		}

		//Location Settings
		$this->load->library('location');
		$data['nearest_location'] = $this->location->nearest();

		$this->load->model('Locations_model');

		$data['locations'] = array();

		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {					
			$data['locations'][] = array(
				'location_id'			=>	$result['location_id'],
				'location_name'			=>	$result['location_name'],
				'location_address'		=>	$result['location_address'],
				'location_region'		=>	$result['location_region'],
				'location_postcode'		=>	$result['location_postcode'],
				'location_phone_number'	=>	$result['location_phone_number']
			);
		}

		$this->load->view('main/header', $data);
		$this->load->view('main/specials', $data);
		$this->load->view('main/footer');
	}

}