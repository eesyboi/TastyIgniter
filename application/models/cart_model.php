<?php

class Cart_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function getMenu($menu_id) {
		if (!empty($menu_id)) {					
			$this->db->select('menus.menu_id, menu_name, menu_description, menu_price, stock_qty, minimum_qty');
			$this->db->select('IF(start_date <= CURRENT_DATE(), IF(end_date >= CURRENT_DATE(), special_price, FALSE), FALSE) AS special_price', FALSE);
			$this->db->from('menus');
			$this->db->join('menus_specials', 'menus_specials.menu_id = menus.menu_id', 'left');
			$this->db->where('menu_status', '1');
			$this->db->where('menus.menu_id', $menu_id);
			
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function getMenuOption($menu_option_id) {		
		if (!empty($menu_option_id)) {					
			$this->db->from('menu_options');
			$this->db->where('option_id', $menu_option_id);

			$query = $this->db->get();
		
			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}
}