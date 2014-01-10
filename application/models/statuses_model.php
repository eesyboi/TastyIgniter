<?php
class Statuses_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function getStatuses() {
		$this->db->from('statuses');
		
		$query = $this->db->get();
		
		return $query->result_array();
	}

	public function getStatus($status_id) {
		$this->db->from('statuses');
		
		$this->db->where('status_id', $status_id);
		$query = $this->db->get();
		
		return $query->row_array();
	}

	public function updateStatus($update = array()) {
		if (!empty($update['status_name'])) {
			$this->db->set('status_name', $update['status_name']);
		}

		if (!empty($update['status_comment'])) {
			$this->db->set('status_comment', $update['status_comment']);
		}

		if (!empty($update['status_id'])) {
			$this->db->where('status_id', $update['status_id']);
			$this->db->update('statuses'); 
		}
		
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function addStatus($add = array()) {
		if (!empty($add['status_name'])) {
			$this->db->set('status_name', $add['status_name']);
		}

		if (!empty($add['status_comment'])) {
			$this->db->set('status_comment', $add['status_comment']);
		}

		$this->db->insert('statuses'); 
		
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function deleteStatus($status_id) {

		$this->db->where('status_id', $status_id);
		
		return $this->db->delete('statuses');
	}
}