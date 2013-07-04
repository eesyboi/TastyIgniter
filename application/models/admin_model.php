<?php
class Admin_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}


	public function getFoods($food_id = FALSE) {
		if ($food_id === FALSE) {
        	//selecting all records from the foods and categories tables.
			$this->db->select('*');
			$this->db->from('foods');
			$this->db->join('categories', 'categories.category_id = foods.food_category', 'left');
			
			$query = $this->db->get();
			return $query->result_array();
		}
	}

	public function addFood($food_name, $food_description, $food_price, $category_id, $food_photo) {
    	//$qry = "INSERT INTO food_details(food_name, food_description, food_price, food_photo, food_category) VALUES('$name','$description','$price','$photo','$category')";
		$food_data = array(
			'food_name' 		=> $food_name,
			'food_description' 	=> $food_description,
			'food_price' 		=> $food_price,
			'food_category' 	=> $category_id,
			'food_photo' 		=> $food_photo
		);
		return $this->db->insert('foods', $food_data);
	}

	public function removeFood($food_id) {
        //$result = mysql_query("DELETE FROM food_details WHERE food_id='$id'")
		$food_data = array(
			'food_id' => $food_id
		);
		return $this->db->delete('foods', $food_data);
	}

	public function getCategories() {
		$this->db->from('categories');
		//$this->db->join('food_options', 'food_options.option_name = categories.option_name', 'left');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function addCategory($category_name, $option_name) {
		//$query = $this->db->query("INSERT INTO categories(category_name) VALUES('$name')");
		$category_data = array(
			'category_name' => $category_name,
			'option_name' => $option_name
		);
		return $this->db->insert('categories', $category_data);
	}

	public function removeCategory($category_id) {
		//$query = $this->db->query("INSERT INTO categories(category_name) VALUES('$name')");
		$category_data = array(
			'category_id' => $category_id
		);
		return $this->db->delete('categories', $category_data);
	}
	
	public function getCategoryOptions() {
        $query = $this->db->query("SELECT DISTINCT option_name FROM category_options");
		return $query->result_array();
	}

}