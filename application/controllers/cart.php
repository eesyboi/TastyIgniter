<?php
class Cart extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Foods_model');
		$this->load->library('cart');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
		//check if file exists in views
		if ( !file_exists('application/views/main/cart.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}
	
		// Update Cart
		if ($this->input->post('quantity')) {
			//sorting the post[quantity] array to rowid and qty.
			foreach ($this->input->post('quantity') as $key => $value) {
				//send array to update()
				$update_data = array(
            	   'rowid' => $key,
        	       'qty'   => $value
    	        );
				$this->cart->update($update_data);
			}			
			//redirect('checkout/cart');  			
		}
		
		$data['heading'] = 'Shopping Cart';
		$data['text_no_foods'] = 'There are no foods added to your cart.';
     	$data['foods'] = array();

    	if ($this->cart->contents()) {
			$foods = $this->cart->contents();
      		foreach ($foods as $food) {
      			//$total = $food['price']*$food['qty'];
      			      		
				$data['foods'][] = array(
					'key'	=>	$food['rowid'],
					'food_id' => $food['id'],
					'food_name' => $food['name'],			
					'food_description' => $food['description'],			
					'category_name' => $food['category_name'],	
					'quantity_value' => $food['qty'],
					'food_price' => $food['price'],
					'sub_total' => $this->cart->format_number($food['subtotal']),
					'food_photo'	=>	$this->config->base_url('assets/img/' . $food['food_photo'])
				);
			}
			
			$data['total'] = $this->cart->format_number($this->cart->total());
		}
	
		$data['continue'] = $this->config->site_url('foods');
		$data['checkout'] = $this->config->site_url('checkout');

		$this->load->view('main/header', $data);
		$this->load->view('main/cart', $data);
		$this->load->view('main/footer');
	}

	public function add() {
		$json = array();
		
		//set food_id
		if ($this->input->post('food_id')) {
			$food_id = $this->input->post('food_id');
		} else {
			$food_id = 0;
		}

		//selecting food details based on food_id
		$food_data = $this->Foods_model->getFoodsByFoodId($food_id);
		
		if ($food_data) {
			//set food quantity
			if ($this->input->post('quantity')) {
				$quantity = $this->input->post('quantity');
			} else {
				$quantity = 1;
			}

			//set food size options
			//if ($this->input->post('food_options') === 'Size') {
			//	$quantity = $this->input->post('quantity');
			//} else {
			//	$quantity = 1;
			//}

			if (!$json) {
				//adding data to cart
				$cart_data = array(
        			'id'      => $this->input->post('food_id'),
               		'qty'     => $quantity,
               		'price'   => $food_data['food_price'],
               		'name'    => $food_data['food_name'],
               		'description'	=> $food_data['food_description'],
               		'category_name'	=> $food_data['category_name'],
                	'food_photo'	=> $food_data['food_photo']
                	//'food_options' => array('Size' => 'L', 'Color' => 'Red')
        		);
				$this->cart->insert($cart_data); 

			} else {
				redirect('cart');		
			}	
		}

		//$this->output->set_output(json_encode($json));
	}
	
}