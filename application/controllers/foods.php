<?php
class Foods extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Foods_model');
	}

	public function index() {
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['title'] = 'Food Zone';
		$data['categories'] = $this->Foods_model->getCategories();
		
		if ($this->input->post('category')) {
			$this->form_validation->set_rules('category', 'Category', 'required');
			
			if ($this->form_validation->run() === TRUE) {
				$data['foods'] = $this->Foods_model->getFoods($this->input->post('category'));
			}
		} else {
			$data['foods'] = $this->Foods_model->getFoods();
		}
		
		$this->load->view('templates/header', $data);
		$this->load->view('foods/index', $data);
		$this->load->view('templates/footer');
	}

}