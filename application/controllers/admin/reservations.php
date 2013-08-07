<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reservations extends CI_Controller {

	private $error = array();

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Admin_model');
		//$this->load->library('upload');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
		//check if file exists in views
		if ( !file_exists('application/views/admin/reservations.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}
		
		$data['title'] = 'Reservations Management';
		$data['text_no_reservations'] = 'There are no reservation(s).';
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}

		//load category data into array
		$data['reservations'] = array();
		$results = $this->Admin_model->getReservations();
		foreach ($results as $result) {					
			$data['reservations'][] = array(
				'reservation_id'	=>	$result['reservation_id'],
				'full_name'			=>	$result['full_name'],
				'reservation_date_time'	=>	$result['reservation_date_time'],
				'email'				=>	$result['email'],
				'telephone'			=>	$result['telephone'],
				'location'			=>	$result['location'],
				'edit'				=>	$result['edit']
			);
		}
				

		$this->load->view('admin/header', $data);
		$this->load->view('admin/reservations', $data);
		$this->load->view('admin/footer');
	}	
}