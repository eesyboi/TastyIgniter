<?php
class Customer {
	private $customer_id;
	//private $firstname;
	//private $lastname;
	private $email;
	//private $telephone;
	//private $fax;
	//private $newsletter;
	//private $customer_group_id;
	//private $address_id;
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->database();
		
		if ($this->CI->session->userdata('customer_id')) { 
			$this->CI->db->select('*');
			$this->CI->db->from('customers');	
			$this->CI->db->where('customer_id', $this->CI->session->userdata('customer_id'));
			$query = $this->CI->db->get();
			$result = $query->row_array();

			if ($query->num_rows() === 1) {
				$this->CI->customer_id = $result['customer_id'];
			} else {
				$this->logout();
			}
		} else {
			$this->logout();
		}
	}

	public function login($email, $password) {

		$this->CI->db->select('*');
		$this->CI->db->from('customers');	
		$this->CI->db->where('email', $email);
		$this->CI->db->where('password', md5($password));
		$login_query = $this->CI->db->get();
		$login_result = $login_query->row_array();
		//Login Successful 
		if ($login_query->num_rows() === 1) {

			//add customer id into session
			$sess_customer_data = array(
				'customer_id'  => $login_result['customer_id'],
			);
			$this->CI->session->set_userdata($sess_customer_data);
			
			$this->CI->customer_id = $login_result['customer_id'];
			$this->CI->email = $login_result['email'];

	  		return TRUE;
		//Login failed and field empty
		}else {
      		return FALSE;
		}
	}

  	public function logout() {		
		$sess_customer_data = array(
			'customer_id' => '',
		);
		$this->CI->session->set_userdata($sess_customer_data);

		$this->CI->customer_id = '';
		//$this->firstname = '';
		//$this->lastname = '';
		$this->CI->email = '';
		//$this->telephone = '';
		//$this->fax = '';
		//$this->newsletter = '';
		//$this->customer_group_id = '';
		//$this->address_id = '';
	}

  	public function isLogged() {
	    return $this->CI->customer_id;
	}

  	public function getEmail() {
		return $this->CI->email;
  	}
}