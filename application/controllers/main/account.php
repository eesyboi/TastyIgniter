<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Account extends CI_Controller {

	public function __construct() {
		parent::__construct();
		//$this->load->library('customer');
		$this->load->model('Customers_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
			
		//check if file exists in views
		if ( !file_exists('application/views/main/account.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		$data['heading'] = 'My Account';
		$data['no_default_address'] = 'You don\'t have a default address';

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		if (!$this->customer->isLogged()) {  
  			redirect('account/login');
		}
		
		$this->load->library('cart');
		$this->load->library('currency');
		$data['cart_items'] = $this->cart->total_items();
		$data['cart_total'] = $this->currency->symbol() . $this->cart->format_number($this->cart->total());

		//store customer data in array
		$data['customer_info'] = array();
		$result = $this->Customers_model->getCustomer($this->customer->getId());

		$question_result = $this->Customers_model->getSecurityQuestions($result['security_question_id']); 
		
		$data['customer_info'] = array(
			'first_name' 		=> $result['first_name'],
			'last_name' 		=> $result['last_name'],
			'email' 			=> $result['email'],
			'telephone' 		=> $result['telephone'],
			'security_question' => $question_result['question_text'],
			'security_answer' 	=> $result['security_answer']
		);

		//store address data in array
		$data['address_info'] = array();
		$result = $this->Customers_model->getAddress($this->customer->getAddressId());
		if ($result) {
			$data['address_info'] = array(
				'address_1' 	=> $result['address_1'],
				'address_2' 	=> $result['address_2'],
				'city' 			=> $result['city'],
				'postcode' 		=> $result['postcode'],
				'country' 		=> $result['country']		
			);
		}

			
		$this->load->view('main/header', $data);
		$this->load->view('main/account', $data);
		$this->load->view('main/footer');
	}
}