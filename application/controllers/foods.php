<?php
class Foods extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Foods_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['title'] = 'Food Zone';
		$data['categories'] = $this->Foods_model->getCategories();
		
		if ($this->input->post('food_category')) {
			$this->form_validation->set_rules('food_category', 'Category', 'required');
			
			if ($this->form_validation->run() === TRUE) {
				$data['foods'] = $this->Foods_model->getFoods($this->input->post('food_category'));
			}
		} else {
			$data['foods'] = $this->Foods_model->getFoods();
		}
		
		$this->load->view('templates/header', $data);
		$this->load->view('foods/index', $data);
		$this->load->view('templates/footer');
	}
}