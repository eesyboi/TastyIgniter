<?php
class Customers_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

    public function record_count() {
        return $this->db->count_all('customers');
    }
    
	public function getList($limit = FALSE, $start = FALSE) {
		if ($start !== 0) {
			$start = ($start - 1) * $limit;
		}
			
		if ($this->db->limit($limit, $start)) {
			$this->db->from('customers');

			$query = $this->db->get();
			return $query->result_array();
		}
	}

	public function getCustomers() {
		$this->db->from('customers');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function getCustomer($customer_id) {
		$this->db->from('customers');		
		$this->db->where('customer_id', $customer_id);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getCustomersByEmail($email) {
		$this->db->from('customers');		
		$this->db->where('email', $email);
		
		$query = $this->db->get();

		if ($query->num_rows() === 1) {
			$row = $query->row_array();
			
			return $row;
		}
	}

	public function getAddress($address_id) {
		if ($address_id !== '0') {
			$this->db->from('address');
			$this->db->where('address_id', $address_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function getAddresses($customer_id = FALSE) {
		$this->db->from('address');
		$this->db->where('customer_id', $customer_id);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function getCustomerDefaultAddress($address_id, $customer_id) {
		if (($address_id !== '0') && ($customer_id !== '0')) {
			$this->db->from('address');
			$this->db->where('address_id', $address_id);
			$this->db->where('customer_id', $customer_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function getSecurityQuestions($question_id = FALSE) {
		if ($question_id === FALSE) {
			$this->db->from('security_questions');

			$query = $this->db->get();
			return $query->result_array();
		}

		$this->db->from('security_questions');
		$this->db->where('question_id', $question_id);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}
	
	public function updateCustomer($customer_id, $update = array()) {
		if (!empty($update)) {
			$this->db->where('customer_id', $customer_id);
			
			$this->db->update('customers', $update);
			if ($this->db->affected_rows() > 0) {
				$customer_id = $this->db->insert_id();			
				return $customer_id;
			}
		}
	}	

	public function changePassword($customer_id, $password) {
		if (!empty($password)) {
			$update_data = array('password' => $password);
				
			$this->db->where('customer_id', $customer_id);
			return $this->db->update('customers', $update_data);
		}
	}	

	public function resetPassword($customer_id, $email, $security_question_id, $security_answer, $password) {
		$reset_data = array(
			'password' 				=> $password,
			'security_question_id' 	=> $security_question_id,
			'security_answer' 		=> $security_answer
		);
		
		$this->db->where('customer_id', $customer_id);
		$this->db->where('email', $email);
		return $this->db->update('customers', $reset_data);
	}

	public function addCustomer($first_name, $last_name, $email, $password, $telephone, $security_question_id, $security_answer) {
		$customer_data = array(
			'first_name' 			=> $first_name,
			'last_name' 			=> $last_name,
			'email' 				=> $email,
			'password' 				=> $password,
			'telephone' 			=> $telephone,
			'security_question_id' 	=> $security_question_id,
			'security_answer' 		=> $security_answer
		);
		
		return $this->db->insert('customers', $customer_data);
	}

	public function addAddress($customer_id, $address) {

		if ($customer_id !== '') {
		
			$add_data = array(
				'customer_id' 	=> $customer_id,
				'address_1' 	=> $address['address_1'],
				'address_2' 	=> $address['address_2'],
				'city' 			=> $address['city'],
				'postcode' 		=> $address['postcode'],
				'country' 		=> $address['country']
			);
			
			$this->db->insert('address', $add_data);
			if ($this->db->affected_rows() > 0) {
				$address_id = $this->db->insert_id();			
				return $address_id;
			}
		}
	}
	
	public function deleteCustomer($customer_id) {
        //$result = mysql_query("DELETE FROM food_details WHERE food_id='$id'")
		$delete_data = array(
			'customer_id' => $customer_id
		);
		
		return $this->db->delete('customers', $delete_data);
	}
}