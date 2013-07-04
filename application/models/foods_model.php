<?php
class Foods_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function getFoods($category_id = FALSE) {
		if ($category_id === FALSE) {
        //selecting all records from the foods and categories tables.
			$this->db->select('*');
			$this->db->from('foods');
			$this->db->join('categories', 'categories.category_id = foods.food_category', 'left');
			//$this->db->join('quantities', 'quantities.quantity_id = foods.food_quantity', 'left');
			$this->db->order_by('category_id', "asc");
		
			$query = $this->db->get();
			return $query->result_array();
		}

        //selecting all records from the foods and categories tables based on food_category.
		$this->db->select('*');
		$this->db->from('foods');
		$this->db->join('categories', 'categories.category_id = foods.food_category', 'left');
		$this->db->join('quantities', 'quantities.quantity_id = foods.food_quantity', 'left');

		$query = $this->db->get_where('', array('food_category' => $category_id));
		return $query->result_array();
	}

	public function getCategories($category_name = FALSE) {
	        //selecting all records from categories tables.
			$query = $this->db->get('categories');
			return $query->result_array();
	}

	public function getFoodsByFoodId($food_id = FALSE) {
	        //selecting all records from the foods and categories tables based on food_id.
			$this->db->select('*');
			$this->db->from('foods');
			$this->db->join('categories', 'categories.category_id = foods.food_category', 'left');
		
			$query = $this->db->get_where('', array('food_id' => $food_id));
			return $query->row_array();
	}
}