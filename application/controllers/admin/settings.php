<?php
class Settings extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->library('currency');
	    $this->load->helper('date');
		$this->load->model('Locations_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
			
		//check if file exists in views
		if ( !file_exists('application/views/admin/settings.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

		$data['title'] = 'Settings';

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

				
		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {					
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
			);
		}

		$data['currencies'] = array();
		$currencies = $this->currency->getCurrencies();
		foreach ($currencies as $currency) {					
			$data['currencies'][] = array(
				'currency_id'	=>	$currency['currency_id'],
				'currency_code'	=>	$currency['currency_code'],
			);
		}

		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/settings', $data);
		$this->load->view('admin/footer');
	}
}
