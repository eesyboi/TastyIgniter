<?php
class Locations_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}
	
	public function getLocations($name = FALSE) {
		if ($name === FALSE) {
			$query = $this->db->get('locations');
			return $query->result_array();
		}
	}
}
