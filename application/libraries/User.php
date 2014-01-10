<<<<<<< HEAD
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User {
	private $user_id;
	private $username;
	private $staff_id;
	private $permissions = array();
	private $staff_name;
	private $department;
	private $department_id;
	private $location_id;
	private $location_name;
=======
<?php
class User {
	private $user_id;
	private $username;
	private $permission;
	private $location_id;
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->database();
		
		if ( ! $this->CI->session->userdata('user_id')) { 
<<<<<<< HEAD
	
			$this->logout();
	
		} else {
	
			$this->CI->db->from('users');	
			$this->CI->db->join('staffs', 'staffs.staff_id = users.staff_id', 'left');
			$this->CI->db->join('departments', 'departments.department_id = staffs.staff_department', 'left');
			$this->CI->db->join('locations', 'locations.location_id = staffs.staff_location', 'left');

			$this->CI->db->where('user_id', $this->CI->session->userdata('user_id'));
			$this->CI->db->where('username', $this->CI->session->userdata('username'));

			$query = $this->CI->db->get();

			$row = $query->row_array();
			
			if ($query->num_rows() === 1) {

				$this->CI->user_id 			= $row['user_id'];
				$this->CI->username			= $row['username'];
				$this->CI->staff_id 		= $row['staff_id'];
				$this->CI->staff_name 		= $row['staff_name'];
				$this->CI->location_id 		= $row['location_id'];
				$this->CI->location_name 	= $row['location_name'];

				$this->CI->department_id 	= $row['department_id'];
				$this->CI->department 		= $row['department_name'];
			
				if (!empty($row['permission'])) {
					$permission = unserialize($row['permission']);

					if (is_array($permission)) {
						foreach ($permission as $key => $value) {
							$this->CI->permissions[$key] = $value;
						}
					}
				}

=======
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
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
			} else {
				$this->logout();
			}
		}
<<<<<<< HEAD
		
		if ($this->CI->session->userdata('staff_department')) { 

		
		}
=======
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
	}

	public function login($user, $password) {

<<<<<<< HEAD
		$this->CI->db->from('users');	
		$this->CI->db->join('staffs', 'staffs.staff_id = users.staff_id', 'left');
		
		$this->CI->db->where('username', $user);
		$this->CI->db->where('password', sha1($password));
		$this->CI->db->where('staff_status', '1');
		
		$query = $this->CI->db->get();
		
		$row = $query->row_array();
		
=======
		$this->CI->db->select('*');
		$this->CI->db->from('users');	
		$this->CI->db->where('username', $user);
		$this->CI->db->where('password', $password);
		$query = $this->CI->db->get();
		$result = $query->row_array();
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
		//Login Successful 
		if ($query->num_rows() === 1) {

			//add login into session
			$admin_data = array(
<<<<<<< HEAD
				'user_id'  			=> $row['user_id'],
				'username'     		=> $row['username']
			);
			$this->CI->session->set_userdata($admin_data);
			
			$this->CI->user_id 		= $row['user_id'];
			$this->CI->username 	= $row['username'];
			$this->CI->staff_id 	= $row['staff_id'];
			$this->CI->staff_name 	= $row['staff_name'];
=======
				'user_id'  		=> $result['user_id'],
				'username'     	=> $result['username']
			);
			$this->CI->session->set_userdata($admin_data);
			
			$this->CI->user_id 		= $result['user_id'];
			$this->CI->username 	= $result['username'];
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e

	  		return TRUE;
		//Login failed and field empty
		}else {
      		return FALSE;
		}
	}

  	public function logout() {		
		$sess_admin_data = array(
<<<<<<< HEAD
			'user_id' 			=> '',
			'staff_department'	=> '',
			'username' 			=> ''
		);
		
		$this->CI->session->unset_userdata($sess_admin_data);
=======
			'user_id' => '',
			'username' => ''
		);
		$this->CI->session->set_userdata($sess_admin_data);
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e

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
<<<<<<< HEAD
    	return $this->CI->username;
  	}	

  	public function getStaffId() {
    	return $this->CI->staff_id;
  	}	

  	public function getStaffName() {
    	return $this->CI->staff_name;
  	}	

  	public function getLocationId() {
    	return $this->CI->location_id;
  	}	

  	public function getLocationName() {
    	return $this->CI->location_name;
  	}	

  	public function department() {
    	return $this->CI->department;
  	}	

  	public function getDepartmentId() {
    	return $this->CI->department_id;
  	}	

  	public function getPaths() {
		$ignore_path = array(
			'admin/login',
			'admin/logout',
			'admin/dashboard',
			'common/forgotten'
		);

		$paths = array();
	
		$files = glob('application/controllers/admin/*.php');
	
		foreach ($files as $file) {
			$path = explode('/', dirname($file));
		
			$file_names = end($path) .'/'. basename($file, '.php');

			if (!in_array($file_names, $ignore_path)) {
				$paths[] = $file_names;
			}
		}
		
		return $paths;
	}

  	public function hasPermissions($key, $value) {
    	if (isset($this->CI->permissions[$key])) {
	  		return in_array($value, $this->CI->permissions[$key]);
		} else {
	  		return FALSE;
		}
  	}
=======
    	return $this->username;
  	}	

  	//public function defaultLocationId() {
	//	return $this->CI->location_id;
  	//}
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
}