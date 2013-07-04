<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Foods extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Foods_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
		//check if file exists in views
		if ( !file_exists('application/views/main/foods.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}
		
		//check if /category and /category_id is set in uri string
		if (($this->uri->segment(2) === 'category') && ($this->uri->segment(3))) {
			$category_id = (int)$this->uri->segment(3);
		} else {
		    $category_id = FALSE;
		}
		
		$data['heading'] = 'Food Menu';
		$data['text_no_foods'] = 'There are no foods added to your cart.';
				
		//load category data into array
		$data['categories'] = array();
		$results = $this->Foods_model->getCategories();
		foreach ($results as $result) {					
			$data['categories'][] = array(
				'category_name'	=>	$result['category_name'],
				'href'	=>	$this->config->site_url('foods/category/' . $result['category_id'])
			);
		}
		
		//load foods data into array	
		$data['foods'] = array();		
		$results = $this->Foods_model->getFoods($category_id);
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
								
		$this->load->view('main/header', $data);
		$this->load->view('main/foods', $data);
		$this->load->view('main/footer');
	}

}