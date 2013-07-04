<?php
class Customer_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function register($first_name, $last_name, $email, $password, $telephone, $security_question_id, $security_answer) {
		$customer_data = array(
			'first_name' 			=> $first_name,
			'last_name' 			=> $last_name,
			'email' 				=> $email,
			'password' 				=> md5($password),
			'telephone' 			=> $telephone,
			'security_question_id' 	=> $security_question_id,
			'security_answer' 		=> $security_answer
		);
		return $this->db->insert('customers', $customer_data);
	}

	public function questions() {
		$query = $this->db->query("SELECT * FROM questions");

		return $query->result_array();
	}

	public function getCustomerByEmail($email) {
		$query = $this->db->query("SELECT * FROM customers WHERE email = '$email'");

		return $query->row();
	}
}