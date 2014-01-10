<?php
class Extensions_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function getList() {
		$this->db->from('extensions');
		
		$query = $this->db->get();
		
		$extensions = array();
		
		foreach ($query->result_array() as $row) {
			$extensions[] = $row['name'];
		}
		
		return $extensions;
	}

	public function getExtensions() {
		$this->db->from('extensions');
		
		$query = $this->db->get();
		
		return $query->result_array();
	}

	public function install($module, $extension) {
		$this->db->set('type', $module);
		$this->db->set('name', $extension);

		$this->db->insert('extensions');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function uninstall($module, $extension) {
		$this->db->where('type', $module);
		$this->db->where('name', $extension);

		$this->db->delete('extensions');
	}
}