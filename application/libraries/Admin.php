<?php
class Admin {
	private $admin_id;
	//private $firstname;
	//private $lastname;
	//private $username;
	//private $telephone;
	//private $fax;
	//private $newsletter;
	//private $customer_group_id;
	//private $address_id;
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->database();
		
		if ($this->CI->session->userdata('admin_id')) { 
			$this->CI->db->select('*');
			$this->CI->db->from('food_admin');	
			$this->CI->db->where('Admin_ID', $this->CI->session->userdata('admin_id'));
			$query = $this->CI->db->get();
			$result = $query->row_array();

			if ($query->num_rows() === 1) {
				$this->CI->admin_id = $result['Admin_ID'];
			} else {
				$this->logout();
			}
		} else {
			$this->logout();
		}
	}

	public function login($login, $password) {

		$this->CI->db->select('*');
		$this->CI->db->from('food_admin');	
		$this->CI->db->where('Username', $login);
		$this->CI->db->where('Password', $password);
		$login_query = $this->CI->db->get();
		$login_result = $login_query->row_array();
		//Login Successful 
		if ($login_query->num_rows() === 1) {

			//add login into session
			$admin_data = array(
				'admin_id'  => $login_result['Admin_ID'],
				'admin_name'     => $login_result['Username']
			);
			$this->CI->session->set_userdata($admin_data);
			
			$this->CI->admin_id = $login_result['Admin_ID'];

	  		return TRUE;
		//Login failed and field empty
		}else {
      		return FALSE;
		}
	}

  	public function logout() {		
		$sess_admin_data = array(
			'admin_id' => '',
			'admin_name' => ''
		);
		$this->CI->session->set_userdata($sess_admin_data);

		$this->CI->admin_id = '';
		//$this->firstname = '';
		//$this->lastname = '';
		//$this->email = '';
		//$this->telephone = '';
		//$this->fax = '';
		//$this->newsletter = '';
		//$this->customer_group_id = '';
		//$this->address_id = '';
	}

  	public function isLogged() {
	    return $this->CI->admin_id;
	}
}