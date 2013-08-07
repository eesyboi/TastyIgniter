<?php
class User {
	private $user_id;
	private $username;
	private $permission;
	private $location_id;
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->database();
		
		if ( ! $this->CI->session->userdata('user_id')) { 
			$this->CI->user_id = '';
			$this->CI->username = '';
		} else {
			$this->CI->db->select('*');
			$this->CI->db->from('users');	
			$this->CI->db->where('user_id', $this->CI->session->userdata('user_id'));
			$this->CI->db->where('username', $this->CI->session->userdata('username'));
			$query = $this->CI->db->get();
			$result = $query->row_array();

			if ($query->num_rows() === 1) {
				$this->CI->user_id = $result['user_id'];
				$this->CI->username = $result['username'];
			} else {
				$this->logout();
			}
		}
	}

	public function login($user, $password) {

		$this->CI->db->select('*');
		$this->CI->db->from('users');	
		$this->CI->db->where('username', $user);
		$this->CI->db->where('password', $password);
		$query = $this->CI->db->get();
		$result = $query->row_array();
		//Login Successful 
		if ($query->num_rows() === 1) {

			//add login into session
			$admin_data = array(
				'user_id'  		=> $result['user_id'],
				'username'     	=> $result['username']
			);
			$this->CI->session->set_userdata($admin_data);
			
			$this->CI->user_id 		= $result['user_id'];
			$this->CI->username 	= $result['username'];

	  		return TRUE;
		//Login failed and field empty
		}else {
      		return FALSE;
		}
	}

  	public function logout() {		
		$sess_admin_data = array(
			'user_id' => '',
			'username' => ''
		);
		$this->CI->session->set_userdata($sess_admin_data);

		$this->CI->user_id = '';
		$this->CI->username = '';
	}

  	public function isLogged() {
	    return $this->CI->user_id;
	}

  	public function getId() {
		return $this->CI->user_id;
  	}

  	public function getUserName() {
    	return $this->username;
  	}	

  	//public function defaultLocationId() {
	//	return $this->CI->location_id;
  	//}
}