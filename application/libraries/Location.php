<?php
class Location {
	private $location_id;
	private $nearest_location;
	private $default_location;
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->database();
		
		if ($this->CI->session->userdata('location_id')) { 
			$this->CI->db->select('*');
			$this->CI->db->from('locations');	
			$this->CI->db->where('location_id', $this->CI->session->userdata('location_id'));
			$query = $this->CI->db->get();

			if ($query->num_rows() === 1) {
				$this->CI->nearest_location = $query->row_array();
			}		
		} else {
			$this->CI->nearest_location = '';
		}
	}
	
	public function getDefault() {
		$this->CI->db->select('*');
		$this->CI->db->from('locations');	
		$this->CI->db->where('status', 1);
		$query = $this->CI->db->get();
		
		if ($query->num_rows() === 1) {
			$this->CI->default_location = $query->row_array();
		} else {
			$this->CI->default_location = '';		
		}
		
		return $this->CI->default_location;
	}


	public function setDefault($id = FALSE) {
		if ($id !== FALSE) {
			$this->CI->db->update('locations', array('status' => '0'));

			$update_data = array(
				'status' => '1'
			);
		
			$this->CI->db->where('location_id', $id);
		
			$this->CI->db->update('locations', $update_data);
		}
	}

	//public function setNearest($id = FALSE) {
	//	if ($id !== FALSE) {
	//		$this->session->set_userdata('location_id', $id);
	//	}
	//}

	public function nearest() {
		return $this->CI->nearest_location;
	}
}