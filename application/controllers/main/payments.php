<?php
class Payments extends MX_Controller {
	
	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->library('cart'); 															// load the cart library
		$this->load->library('location'); 														// load the location library
		$this->load->library('currency'); 														// load the currency library
		$this->load->model('Orders_model'); 													// load the orders model
		$this->load->model('Payments_model'); 													// load the payments model
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
		$this->lang->load('main/payments');  													// loads language file
		
		if ( !file_exists('application/views/main/payments.php')) { 							//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

		if ( ! $this->cart->contents()) { 														// checks if cart contents is empty  
			$this->session->set_flashdata('alert', $this->lang->line('warning_no_cart'));
		  	redirect('menus');																	// redirect to menus page and display error
		} else if ( ! $this->location->local()) { 												// else if local restaurant is not selected
			$this->session->set_flashdata('alert', $this->lang->line('warning_no_local'));
  			redirect('home');																	// redirect to home page and display error
		} else if ( ! $this->location->isOpened()) { 											// else if local restaurant is not open
			$this->session->set_flashdata('alert', $this->lang->line('warning_is_closed'));
  			redirect('menus');																	// redirect to menus page and display error
		} else if ( ! $this->customer->islogged()) { 											// else if customer is not logged in
			//$this->session->set_flashdata('alert', $this->lang->line('warning_not_logged'));
  			redirect('account/login');														// redirect to account register page and display error
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_payments'] 			= $this->lang->line('text_payments');
		$data['text_local'] 			= $this->lang->line('text_local');
		$data['text_find'] 				= $this->lang->line('text_find');
		$data['text_postcode_warning'] 	= $this->lang->line('text_postcode_warning');
		$data['text_delivery_charge'] 	= $this->lang->line('text_delivery_charge');
		$data['text_delivery'] 			= $this->lang->line('text_delivery');
		$data['text_collection'] 		= $this->lang->line('text_collection');
		$data['text_cod'] 				= $this->lang->line('text_cod');
		$data['text_paypal'] 			= $this->lang->line('text_paypal');
		$data['text_ip_warning'] 		= $this->lang->line('text_ip_warning');
		$data['entry_payment_method'] 	= $this->lang->line('entry_payment_method');
		$data['entry_ip'] 				= $this->lang->line('entry_ip');
		$data['button_check_postcode'] 	= $this->lang->line('button_check_postcode');
		$data['button_back'] 			= $this->lang->line('button_back');
		$data['button_order'] 			= $this->lang->line('button_order');

		$content_data['button_left'] 	= '<a class="button" href='. $this->config->site_url("checkout") .'>'. $this->lang->line('button_back') .'</a>';
		$content_data['button_right'] 	= '<a class="button" onclick="$(\'#payment-form\').submit();">'. $this->lang->line('button_continue') .'</a>';
		// END of retrieving lines from language file to send to view.
		
		if ($this->input->post('payment')) {
			$data['payment'] = $this->input->post('payment'); 									// retrieve payment value from $_POST data if set
		} else {
			$data['payment'] = '';
		}
						
		if ($this->input->ip_address()) {
			$data['ip_address'] = $this->input->ip_address(); 									// retrieve ip_address value if set
		}
		
		if ($this->input->post() && $this->_validatePayment() === TRUE) { 						// check if post data and validate checkout is successful
			redirect('payments');				
		}
		
		// pass array $data and load view files
		$this->load->view('main/header', $data);
		$this->load->view('main/content_right', $content_data);
		$this->load->view('main/payments', $data);
		$this->load->view('main/footer');
	}

	public function paypal() {
		
		if ($this->customer->islogged()) { 														// if customer is logged in
			$customer_id = $this->customer->getId(); 											// retrieve customer id
		}

		if ($this->input->get('token') && $this->input->get('PayerID')) { 						// check if token and PayerID is in $_GET data

			$token = $this->input->get('token'); 												// retrieve token from $_GET data
			$payer_id = $this->input->get('PayerID'); 											// retrieve PayerID from $_GET data

			$order_details = $this->session->userdata('order_details'); 						// retrieve order details from session userdata
			
			//create name-value pairs data to be sent to paypal
			$nvp_data  = '&TOKEN='. urlencode($token);
			$nvp_data .= '&PAYERID='. urlencode($payer_id);
			$nvp_data .= '&PAYMENTREQUEST_0_AMT='. urlencode($this->cart->total());

			// execute the "DoExpressCheckoutPayment" method to obtain paypal transaction id
			$result = $this->Payments_model->paypalPayment('DoExpressCheckoutPayment', $nvp_data);

			// check if paypal response status message is SUCCESS or SUCCESSWITHWARNING
			if (strtoupper($result['ACK']) === 'SUCCESS' OR strtoupper($result['ACK']) === 'SUCCESSWITHWARNING') {
				
				//create name-value pairs data to be sent to paypal
				$nvp_data = '&TRANSACTIONID='. urlencode($result['PAYMENTINFO_0_TRANSACTIONID']);
				
				// execute the "GetTransactionDetails" method to obtain paypal transaction details
				$transaction_details = $this->Payments_model->paypalPayment('GetTransactionDetails', $nvp_data);

				if (!empty($result['PAYMENTINFO_0_TRANSACTIONID'])) { 							// check if PAYMENTINFO_0_TRANSACTIONID is not empty
				
					$order_details['payment'] = 'paypal';

					// send order details and cart contents to orders model to be added to database and to obtain order id
					$order_id = $this->Orders_model->addOrder($order_details, $this->cart->contents());

					// send transaction details to payments model to be added to database
					$this->Payments_model->addPaypalOrder($result['PAYMENTINFO_0_TRANSACTIONID'], $order_id, $customer_id, $transaction_details);

					// redirect to checkout success page with returned order id
					redirect('checkout/success?order_id='. $order_id);
		
				} else { 																				// else if no $_GET data redirect to checkout page
					log_message('info', urldecode($result['L_LONGMESSAGE0']));			
				}	
					
			} else { 																			// if payment response status message is not SUCCESS display error.
				log_message('info', urldecode($result['L_LONGMESSAGE0']));			
			}
		}

		redirect('payments');
		//$this->load->view('main/payments', $data);
	}

	public function _validatePayment() {
		$order_details = $this->session->userdata('order_details'); 							// retrieve order details from session userdata
		$cart_details = $this->cart->contents(); 												// retrieve cart contents
		
		$this->form_validation->set_rules('payment', 'Payment Method', 'trim|required');
		
		if ($this->form_validation->run() === TRUE) {
			if ($this->input->post('payment') === 'cod') { 											// else if payment method is cash on delivery
			
				$order_details['payment'] = 'cod';
				$order_id = $this->Orders_model->addOrder($order_details, $cart_details); 
			
				redirect('checkout/success?order_id='. $order_id);									// redirect to checkout success page with returned order id

			}
		
			if ($this->input->post('payment') === 'paypal') { 								// check if payment method is equal to paypal
			
				//create name-value pairs data to be sent to paypal
				$nvp_data  = '&ALLOWNOTE=0';
				$nvp_data .= '&NOSHIPPING=2';
				$nvp_data .= '&LOCALECODE=GB';
				$nvp_data .= '&RETURNURL='. urlencode(site_url('payments/paypal'));
				$nvp_data .= '&CANCELURL='. urlencode(site_url('payments/cancel'));	

				$nvp_data .= '&PAYMENTREQUEST_0_CURRENCYCODE='. urlencode($this->currency->getCurrencyCode());
				$nvp_data .= '&PAYMENTREQUEST_0_AMT='. urlencode($this->cart->total());
				$nvp_data .= '&PAYMENTREQUEST_0_ITEMAMT='. urlencode($this->cart->total());

				foreach (array_keys($cart_details) as $key => $rowid) {							// loop through cart items to create items name-value pairs data to be sent to paypal
	
					foreach ($cart_details as $cart_item) {
		
						if (!empty($cart_item['options']['With'])) {
							$options = $cart_item['options']['With'];
						} else {
							$options = '';
						}
	
						if ($rowid === $cart_item['rowid']) {
							$nvp_data .= '&L_PAYMENTREQUEST_0_NUMBER'. $key .'='. urlencode($cart_item['id']);
							$nvp_data .= '&L_PAYMENTREQUEST_0_NAME'. $key .'='. urlencode($cart_item['name']);
							$nvp_data .= '&L_PAYMENTREQUEST_0_DESC'. $key .'='. urlencode($options);
							$nvp_data .= '&L_PAYMENTREQUEST_0_QTY'. $key .'='. urlencode($cart_item['qty']);
							$nvp_data .= '&L_PAYMENTREQUEST_0_AMT'. $key .'='. urlencode($cart_item['price']);
						}
					}
				}
	
				// execute the "SetExpressCheckOut" method to obtain paypal token
				$result = $this->Payments_model->paypalPayment('SetExpressCheckout', $nvp_data);
			
				// check if paypal response status message is SUCCESS or SUCCESSWITHWARNING
				if (strtoupper($result['ACK']) === 'SUCCESS' OR strtoupper($result['ACK']) === 'SUCCESSWITHWARNING') {
				
					if ($this->config->item('config_paypal_mode') === 'sandbox') {				// check if setting paypal mode is sandbox
						$api_mode = '.sandbox';
					} else {
						$api_mode = '';
					}

					// redirect to paypal payment page with token received
					redirect('https://www'. $api_mode .'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='. $result['TOKEN'] .'');

				} else { 																		// else payment response status message is not SUCCESS display error message.
					log_message('info', urldecode($result['L_LONGMESSAGE0']));			
				}
			}
		}

		return FALSE;
	}
}