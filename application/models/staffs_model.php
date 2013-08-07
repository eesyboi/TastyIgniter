<?php
class Staffs_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function getStaffs($staffs = FALSE) {
		if ($staffs === FALSE) {
			$this->db->from('staffs');
			$this->db->join('locations', 'locations.location_id = staffs.staff_location', 'left');

			$query = $this->db->get();
			return $query->result_array();
		}
	}

	public function getStaff($staff_id = FALSE) {
		$this->db->from('staffs');		
		
		$this->db->where('staff_id', $staff_id);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function updateStaff($staff_id, $update_data = array()) {
		if (!empty($update_data)) {
			
			$this->db->where('staff_id', $staff_id);
			return $this->db->update('staffs', $update_data);
		
		}
	}	

	public function addStaff($staff_details) {

		if (!empty($staff_details)) {
			$this->db->insert('staffs', $staff_details);
		
			if ($this->db->affected_rows() > 0) {
				$staff_id = $this->db->insert_id();
				
				return $staff_id;
			}
		}
	}
}