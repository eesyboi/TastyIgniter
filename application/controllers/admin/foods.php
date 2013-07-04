<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Foods extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('admin');
		$this->load->model('Admin_model');
		//$this->load->library('upload');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
		//check if file exists in views
		if ( !file_exists('application/views/admin/foods.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		if (!$this->admin->islogged()) {  
  			redirect('admin/login');
		}
		
		$data['title'] = 'Foods Management';
		$data['text_heading'] = 'CHOOSE YOUR FOOD';
		$data['text_no_foods'] = 'There are no foods added to your cart.';
		$data['upload_error'] = '';
						
		//load category data into array
		$data['categories'] = array();
		$results = $this->Admin_model->getCategories();
		foreach ($results->result_array() as $result) {					
			$data['categories'][] = array(
				'category_id'	=>	$result['category_id'],
				'category_name'	=>	$result['category_name']
			);
		}
				
		//if ($this->input->post('food_category')) {
		//	$category_id = $this->input->post('food_category');
		//} else {
		//	$category_id = FALSE;
		//}
		
		$data['foods'] = array();
		$results = $this->Admin_model->getFoods();
		foreach ($results as $result) {

				//for ($i=$result['quantity_value']; $i<=10; $i+$i) {
					//$data['quantity_data'] = $i;
				//}			

			$data['foods'][] = array(
				'food_id'	=>	$result['food_id'],
				'food_name'	=>	$result['food_name'],
				'food_description'	=>	$result['food_description'],
				'category_name'	=>	$result['category_name'],
				//'quantity_value'	=>	$result['quantity_value'],
				'food_price'	=>	$result['food_price'],
				'food_photo'	=>	$this->config->base_url('assets/img/' . $result['food_photo'])
			);
		}	
								
		$this->load->view('admin/header', $data);
		$this->load->view('admin/foods', $data);
		$this->load->view('admin/footer');
	}

	public function add() {
		//add foods
		if ($this->input->post('add_food') === 'Add') {
			//setting upload preference
			$config['upload_path'] = './assets/img/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '300';
			$config['max_width'] = '2024';
			$config['max_height'] = '1468';

			$this->load->library('upload', $config);

    		//Sanitizing the POST values
			$food_name = $this->input->post('food_name');
			$food_description = $this->input->post('food_description');
			$food_price = $this->input->post('food_price');
			$category_id = $this->input->post('food_category');
			//$food_photo = $this->input->post('userfile');
			if ( ! $this->upload->do_upload()) {
				$data['upload_error'] = $this->upload->display_errors('<p>', '</p>');
			} else {
				$data['upload_error'] = 'Food Added Sucessfully';
				$upload_data = $this->upload->data();
				$food_photo = $upload_data['file_name'];				
				$insert_data = $this->Admin_model->addFood($food_name, $food_description, $food_price, $category_id, $food_photo);
			}
		}
	
	}
	public function remove() {
		$json = array();

		//remove food
		if ((!$json) && ($this->input->post('food_id'))) {
			$this->Admin_model->removeFood($this->input->post('food_id'));	
	
		}	

		$this->output->set_output(json_encode($json));
	}

}