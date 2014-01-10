<?php
class Tables_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

    public function record_count() {
        return $this->db->count_all('tables');
    }
	
	public function getList($filter = array()) {
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
		
        if ($this->db->limit($filter['limit'], $filter['page'])) {	
			$this->db->from('tables');
			//$this->db->join('locations', 'locations.location_id = tables.location_id', 'left');

			$query = $this->db->get();
			return $query->result_array();
		}
	}
	
	public function getTables() {
		$this->db->from('tables');
		//$this->db->join('locations', 'locations.location_id = tables.location_id', 'left');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function getTable($table_id) {		
		$this->db->from('tables');
		$this->db->where('table_id', $table_id);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getTablesByLocation($location_id = FALSE) {		
		$this->db->from('location_tables');

		$this->db->where('location_id', $location_id);
		
		$query = $this->db->get();
		
		$location_tables = array();
		
		if ($query->num_rows() > 0) {
			
			foreach ($query->result_array() as $row) {
				$location_tables[] = $row['table_id'];
			}
		}
	
		return $location_tables;
	}

	public function getAutoComplete($filter_data = array()) {
		if (is_array($filter_data) && !empty($filter_data)) {

			if (!empty($filter_data['table_name'])) {
				$this->db->from('tables');
				$this->db->where('table_status >', '0');	
				$this->db->like('table_name', $filter_data['table_name']);		
			}
	
			$query = $this->db->get();
			return $query->result_array();
		}
	}

	public function updateTable($update = array()) {

		if (!empty($update['table_name'])) {
			$this->db->set('table_name', $update['table_name']);
		}

		if (!empty($update['min_capacity'])) {
			$this->db->set('min_capacity', $update['min_capacity']);
		}

		if (!empty($update['max_capacity'])) {
			$this->db->set('max_capacity', $update['max_capacity']);
		}

		if ($update['table_status'] === '1') {
			$this->db->set('table_status', $update['table_status']);
		} else {
			$this->db->set('table_status', '0');
		}

		if (!empty($update['table_id'])) {
			$this->db->where('table_id', $update['table_id']);
			$this->db->update('tables'); 
		}
		
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function addTable($add = array()) {
		
		if (!empty($add['table_name'])) {
			$this->db->set('table_name', $add['table_name']);
		}

		if (!empty($add['min_capacity'])) {
			$this->db->set('min_capacity', $add['min_capacity']);
		}

		if (!empty($add['max_capacity'])) {
			$this->db->set('max_capacity', $add['max_capacity']);
		}

		if ($add['table_status'] === '1') {
			$this->db->set('table_status', $add['table_status']);
		} else {
			$this->db->set('table_status', '0');
		}

		$this->db->insert('tables');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function deleteTable($table_id) {

		$this->db->where('table_id', $table_id);

		$this->db->delete('tables');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
}