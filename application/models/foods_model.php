<?php
class Foods_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function getFoods($food_category = FALSE) {
		if ($food_category === FALSE) {
			$this->db->select('*');
			$this->db->from('foods');
			$this->db->join('categories', 'categories.category_id = foods.food_category', 'left');
			$query = $this->db->get();
			return $query->result_array();
		}

		$this->db->select('*');
		$this->db->from('foods');
		$this->db->join('categories', 'categories.category_id = foods.food_category', 'left');

		$query = $this->db->get_where('', array('food_category' => $food_category));
		return $query->result_array();
	}

	public function getCategories($category_name = FALSE) {
		if ($category_name === FALSE) {
			$query = $this->db->get('categories');
			return $query->result_array();
		}
	}

}