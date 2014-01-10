<?php
class Payments_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function getPayments() {
		$this->db->from('payments');
		
		$query = $this->db->get();
		
		return $query->result_array();
	}

	public function getPayment($payment_id) {
		$this->db->from('payments');
		
		$this->db->where('payment_id', $payment_id);
		$query = $this->db->get();
		
		return $query->row_array();
	}

	public function getPaypalDetails($order_id, $customer_id) {
		$this->db->from('pp_payments');
		$this->db->where('order_id', $order_id);
		$this->db->where('customer_id', $customer_id);
			
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			
			return unserialize($row['serialized']);
		}	
	}
	
	public function updatePayment($update = array()) {
		
		if (!empty($update['payment_name'])) {
			$this->db->set('payment_name', $update['payment_name']);
		}

		if (!empty($update['payment_desc'])) {
			$this->db->set('payment_desc', $update['payment_desc']);
		}

		if (!empty($update['payment_id'])) {
			$this->db->where('payment_id', $update['payment_id']);
			$this->db->update('payments'); 
		}
				
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function addPayment($add = array()) {
		
		if (!empty($add['payment_name'])) {
			$this->db->set('payment_name', $add['payment_name']);
		}

		if (!empty($add['payment_desc'])) {
			$this->db->set('payment_desc', $add['payment_desc']);
		}

		$this->db->insert('payments'); 
		
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function deletePayment($payment_id) {

		$this->db->where('payment_id', $payment_id);
		
		$this->db->delete('payments');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
	
	public function paypalPayment($method, $nvp_data) {

		if ($this->config->item('config_paypal_mode') === 'sandbox') {
			$api_mode = '.sandbox';
		} else {
			$api_mode = '';
		}

		$api_end_point = 'https://api-3t'. $api_mode .'.paypal.com/nvp';
		
		// Set the API operation, version, and API signature in the request.
		$nvp_string  = 'VERSION=76.0';

		if ($this->config->item('config_paypal_action') === 'sale') {
			$nvp_string .= '&PAYMENTREQUEST_0_PAYMENTACTION=SALE';
		} else {
			$nvp_string .= '&PAYMENTREQUEST_0_PAYMENTACTION=AUTHORIZATION';		
		}
	
		$nvp_string .= '&USER='. urlencode($this->config->item('config_paypal_user'));
		$nvp_string .= '&PWD='. urlencode($this->config->item('config_paypal_pass'));
		$nvp_string .= '&SIGNATURE='. urlencode($this->config->item('config_paypal_sign'));
		$nvp_string .= '&PAYMENTREQUEST_0_CURRENCYCODE='. urlencode($this->currency->getCurrencyCode());
		$nvp_string .= '&METHOD='. urlencode($method);
		$nvp_string .= $nvp_data;

		// Set the curl parameters.
		$curl = curl_init();
			curl_setopt($curl, CURLOPT_VERBOSE, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			curl_setopt($curl, CURLOPT_URL, $api_end_point);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);
	
		// Get response from the server.
		$output = curl_exec($curl);
		curl_close($curl);
		
		$result = array();
		$parse_str = parse_str($output, $result);
		
		return $result;
	}
	
	public function addPaypalOrder($transaction_id, $order_id, $customer_id, $response_data) {
		if (!empty($order_id)) {
			$this->db->set('order_id', $order_id);
		}

		if (!empty($customer_id)) {
			$this->db->set('customer_id', $customer_id);
		}
		
		if (!empty($response_data)) {
			$this->db->set('serialized', serialize($response_data));
		}
		
		if (!empty($transaction_id)) {
			$this->db->set('transaction_id', $transaction_id);
			$this->db->insert('pp_payments'); 
		}

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
}