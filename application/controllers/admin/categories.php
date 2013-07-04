<?php
class Categories extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('admin');
		$this->load->model('Admin_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
			
		//check if file exists in views
		if ( !file_exists('application/views/admin/categories.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		if (!$this->admin->islogged()) {  
  			redirect('admin/login');
		}

		$data['title'] = 'Categories Management';
		$data['error'] = '';

		$categories = array();				
		$results = $this->Admin_model->getCategories();
		//check if sql query was successful and create variables
		if ($results) {
			foreach ($results as $result) {
				//load categories data into array
				$data['categories'][] = array(
					'category_id' => $result['category_id'],
					'category_name' => $result['category_name'],
					'option_name' => $result['option_name']
				);
			}
			
			$category_options = array();
			$results = $this->Admin_model->getCategoryOptions();
			//check if sql query was successful and create variables
			if ($results) {
				foreach ($results as $result) {
					//load food_options data into array
					$data['category_options'][] = array(
						'option_name' => $result['option_name']
					);
				}
			}
		}
		
		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/categories', $data);
		$this->load->view('admin/footer', $data);
	}
	
	//add category
	public function add() {
		if ($this->input->post('category_name')) {
			
			if ($this->input->post('option_name')) {
				$option_name = $this->input->post('option_name');
			} else {
				$option_name = '';
			}

			$category_name = $this->input->post('category_name');
						
			//validate category value
			$this->form_validation->set_rules('category_name', 'Category Name', 'required');

  			if ($this->form_validation->run() === TRUE) {
				$this->Admin_model->addCategory($category_name, $option_name);	
				$data['error'] = 'Category Added';				
		        redirect('/admin/categories');
			}	
		}
	}	
	
	public function remove() {
		$json = array();

		//remove category
		if ((!$json) && ($this->input->post('category_id'))) {
			$this->Admin_model->removeCategory($this->input->post('category_id'));	
	
		} else {
			redirect('admin/categories');		
		}
	
		$this->output->set_output(json_encode($json));
	}
}
