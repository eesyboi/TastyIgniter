<?php
class Foods_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function getFoods($category = FALSE) {
		if ($category === FALSE) {
			$query = $this->db->get('foods');
			return $query->result_array();
		}

		$this->db->select('*');
		$this->db->from('foods');
		$this->db->join('categories', 'categories.id = foods.category', 'left');

		$query = $this->db->get_where('', array('category' => $category));
		return $query->result_array();
	}

	public function getCategories($name = FALSE) {
		if ($name === FALSE) {
			$query = $this->db->get('categories');
			return $query->result_array();
		}
	}

}