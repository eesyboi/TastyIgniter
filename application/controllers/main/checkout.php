<?php
class Checkout extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('cart');
		$this->load->model('Customers_model');
		$this->load->model('Orders_model');
		//$this->load->vars($data);
	}

	public function index() {
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
		//check if file exists in views
		if ( !file_exists('application/views/main/checkout.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		if (!$this->customer->islogged()) {
			$this->session->set_flashdata('alert', 'Almost there, Please login or register.');
  			redirect('account/login');
		}

		if (!$this->cart->contents()) {  
			$this->session->set_flashdata('alert', 'Please, add some foods before you checkout!');
		  	redirect('foods');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		$data['action'] = $this->config->site_url('checkout');
		
		$data['heading'] = 'Checkout';
		$data['text_no_cart_items'] = 'There are no foods added in your cart.';
		$data['continue'] = $this->config->site_url('foods');
		$data['checkout'] = $this->config->site_url('checkout');

		//$customer_info = $this->Customers_model->getCustomer($this->customer->getId());
					
		$data['first_name'] 	= $this->customer->getFirstName();
		$data['last_name'] 		= $this->customer->getLastName();
		$data['email'] 			= $this->customer->getEmail();
		$data['telephone'] 		= $this->customer->getTelephone();
						
     	$data['addresses'] = array();
		$addresses = $this->Customers_model->getAddresses($this->customer->getId());
		if ($addresses) {
      		foreach ($addresses as $address) {
				$data['addresses'][] = array(
					'address_id'	=> $address['address_id'],
					'address_1'		=> $address['address_1'],
					'address_2' 	=> $address['address_2'],
					'city' 			=> $address['city'],			
					'postcode' 		=> $address['postcode'],	
					'country' 		=> $address['country']
				);
			}
		}
		
		$data['delivery_times'] = $this->delivery_times('5:00am', '10:00pm', '30');
		
		if ($this->input->post() && $this->_confirmCheckout() === TRUE) {
			
			redirect('checkout');		
		
		}
			
		$order_details = $this->session->userdata('order_details');
		if ($order_details['customer_id'] === $this->customer->getId()) {
				
			$order_id = $this->Orders_model->addOrder($order_details);
				
			if (is_numeric($order_id)) {
										
				$this->session->unset_userdata('order_details');
	
				$this->session->set_flashdata('order_id', $order_id);

				$this->cart->destroy();
				
				redirect('checkout/success');		
	
			}
		}
		
		//Location Settings
		$this->load->library('location');
		$data['nearest_location'] = $this->location->nearest();
		$data['location_id'] = (int)$this->session->userdata('location_id');

		$this->load->model('Locations_model');

		$data['locations'] = array();

		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {					
			$data['locations'][] = array(
				'location_id'			=> $result['location_id'],
				'location_name'			=> $result['location_name'],
				'location_address'		=> $result['location_address'],
				'location_region'		=> $result['location_region'],
				'location_postcode'		=> $result['location_postcode'],
				'location_phone_number'	=> $result['location_phone_number']
			);
		}

		$this->load->view('main/header', $data);
		$this->load->view('main/checkout', $data);
		$this->load->view('main/footer');
	}
	
	public function success() {
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
		//check if file exists in views
		if ( !file_exists('application/views/main/success.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		if ($this->session->flashdata('order_id')) {
			$this->session->keep_flashdata('order_id');
			$order_id = $this->session->flashdata('order_id');
			$customer_id = $this->customer->getId();
		} else {
			redirect('checkout');		
		}

		$data['heading'] = 'Order Successful';

		$order_info = $this->Orders_model->getOrder($order_id, $customer_id);
		$this->lang->load('main/checkout');
		$data['message'] = sprintf($this->lang->line('text_success_message'), $order_info['order_id'], $this->config->site_url('orders/' . $order_info['order_id']));

		$this->load->view('main/header', $data);
		$this->load->view('main/success', $data);
		$this->load->view('main/footer');
	}
	
	public function _addAddress() {
										
		//validate POST address value
		$this->form_validation->set_rules('address_1', 'Address 1', 'trim|required|min_length[3]|max_length[128]');
		$this->form_validation->set_rules('city', 'City', 'trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('postcode', 'Postcode', 'trim|required|min_length[2]|max_length[10]');
		$this->form_validation->set_rules('country', 'Country', 'trim|required|min_length[2]|max_length[128]');

  		if ($this->form_validation->run() === TRUE) {
			
			$customer_id = $this->customer->getId();
			$address_1 	= $this->input->post('address_1');
			$address_2 	= $this->input->post('address_2');
			$city 		= $this->input->post('city');
			$postcode 	= $this->input->post('postcode');
			$country 	= $this->input->post('country');
	
			if ($this->Customers_model->addAddress($customer_id, $address_1, $address_2, $city, $postcode, $country)) {	
				
		        return TRUE;
			}
		}
	}	
	
	public function _confirmCheckout() {
		
 		$this->load->library('cart');
		$this->load->helper('date');
		$date_format = "%Y/%m/%d";
		$time_format = "%h:%i%a";
		$current_date_time = time();
	
		$order_details = array();
		
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|callback_validate_checkout');
		$this->form_validation->set_rules('telephone', 'Telephone', 'trim|required|integer');
		$this->form_validation->set_rules('order_type', 'Order Type', 'trim|required');
		$this->form_validation->set_rules('payment_method', 'Payment Method', 'trim|required|integer');
		$this->form_validation->set_rules('comment', 'Comment', 'trim|max_length[520]');
		
		if (($this->input->post('order_type') === 'delivery') && ($this->input->post('new-address') === '1')) {
			$this->form_validation->set_rules('address[address_1]', 'Address 1', 'trim|required|min_length[3]|max_length[128]');
			$this->form_validation->set_rules('address[city]', 'City', 'trim|required|min_length[2]|max_length[128]');
			$this->form_validation->set_rules('address[postcode]', 'Postcode', 'trim|required|min_length[2]|max_length[10]');
			$this->form_validation->set_rules('address[country]', 'Country', 'trim|required|min_length[2]|max_length[128]');
		} else if ($this->input->post('order_type') === 'delivery') {
			$this->form_validation->set_rules('existing_address', 'Delivery Address', 'trim|required');
		}

  		if ($this->form_validation->run() === TRUE) {
		
			$order_details['customer_id'] 		= $this->customer->getId();
			$order_details['first_name'] 		= $this->input->post('first_name');
			$order_details['last_name'] 		= $this->input->post('last_name');
			$order_details['email'] 			= $this->input->post('email');
			$order_details['telephone'] 		= $this->input->post('telephone');
	 		$order_details['comment']	 		= $this->input->post('comment');
		 	$order_details['order_type']	 	= $this->input->post('order_type');
			$order_details['order_time'] 		= $this->input->post('order_time');
			$order_details['order_date']	 	= mdate($date_format, $current_date_time);
		 	$order_details['payment_method']	= $this->input->post('payment_method');
			$order_details['order_total']	 	= $this->cart->format_number($this->cart->total());
			$order_details['order_location'] 	= (int)$this->session->userdata('location_id');

			if ($this->input->post('order_type') === 'delivery') {
			
				if ($this->input->post('new-address') === '1') {
					$order_details['address_id'] = $this->Customers_model->addAddress($this->customer->getId(), $this->input->post('address'));
				} else {
					$order_details['address_id'] = $this->input->post('existing_address');
				}
			}
						
			$order_details['cart'] = serialize($this->cart->contents());
		
			if ( ! $this->session->userdata('order_details') && (!empty($order_details))) {
				$this->session->set_userdata('order_details', $order_details);
	
				return TRUE;
			}
		}
	}

 	public function validate_checkout() {
      		
		if ($_POST['email'] !== $this->customer->getEmail()) {

        	$this->form_validation->set_message('validate_checkout', 'Please provide the email address you registered with us or register a new account here!');
      		return FALSE;

		} else if ( ! $this->session->userdata('location_id')) {

        	$this->form_validation->set_message('validate_checkout', 'Please select your nearest restaurant!');
      		return FALSE;

		} else if (empty($_POST['order_time'])) {
		
        	$this->form_validation->set_message('validate_checkout', 'The Delivery or Collection Time field is required!');
      		return FALSE;

    	} else {
        	return TRUE;        
      	}
    }

	public function delivery_times($opening_time, $closing_time, $interval) {
  		$start_formatted = strtotime($opening_time);
  		$end_formatted = strtotime($closing_time);
  		$interval = $interval * 60;
  		$times = array();
 
  		for ($i = $start_formatted; $i < ($end_formatted); $i += $interval) {
    		$key = date('H:i:s', $i);
    		//$seconds = $i - strtotime(date('Y-m-d'));
    		$times[$key] = date('g:i a', $i);
  		}
 
  		return $times;
	}
}