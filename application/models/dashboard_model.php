<?php
class Dashboard_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function getSummaries($flag = 1) {

		$summaries = array();
		$members_query = $this->db->query("SELECT * FROM customers");
		$foods_query = $this->db->query("SELECT * FROM foods");
		$orders_query = $this->db->query("SELECT * FROM orders_details");
		$orders_processed_query = $this->db->query("SELECT * FROM orders_details WHERE flag = '$flag'");
		$tables_reserved_query = $this->db->query("SELECT * FROM reservations_details WHERE table_flag = '$flag'");
		$tables_allocated_query = $this->db->query("SELECT * FROM reservations_details WHERE flag = '$flag' AND table_flag = '$flag'");
		$partyhalls_reserved_query = $this->db->query("SELECT * FROM reservations_details WHERE partyhall_flag = '$flag'");
		$partyhalls_allocated_query = $this->db->query("SELECT * FROM reservations_details WHERE flag = '$flag' AND partyhall_flag = '$flag'");

		$summaries[] = array(
			'foods_query'	=>	$foods_query,
			'members_query'	=>	$members_query,
			'orders_query'	=>	$orders_query,		
			'orders_processed_query'	=>	$orders_processed_query,	
			'tables_reserved_query'	=>	$tables_reserved_query,		
			'tables_allocated_query'	=>	$tables_allocated_query,	
			'partyhalls_reserved_query'	=>	$partyhalls_reserved_query,	
			'partyhalls_allocated_query'	=>	$partyhalls_allocated_query		
		);
		
		return $summaries;
	}

	public function getRatings($food_id) {
		$query = $this->db->query("SELECT * FROM foods, polls_details WHERE polls_details.food_id = '$food_id' AND foods.food_id = '$food_id'");
	
        $ratings_query = $this->db->query("SELECT * FROM ratings");
        if ($ratings_query->num_rows() > 0) {
        	$excellent = $ratings_query->row(0);
        	$good = $ratings_query->row(1);
        	$average = $ratings_query->row(2);
        	$bad = $ratings_query->row(3);
        	$worse = $ratings_query->row(4);

        	$excellent_qry = $this->db->query("SELECT * FROM foods, polls_details WHERE polls_details.food_id = '$food_id' AND foods.food_id='$food_id' AND polls_details.rate_id='$excellent->rate_id'");
	        $good_qry = $this->db->query("SELECT * FROM foods, polls_details WHERE polls_details.food_id = '$food_id' AND foods.food_id = '$food_id' AND polls_details.rate_id = '$good->rate_id'");
        	$average_qry = $this->db->query("SELECT * FROM foods, polls_details WHERE polls_details.food_id = '$food_id' AND foods.food_id = '$food_id' AND polls_details.rate_id = '$average->rate_id'");
        	$bad_qry=$this->db->query("SELECT * FROM foods, polls_details WHERE polls_details.food_id = '$food_id' AND foods.food_id = '$food_id' AND polls_details.rate_id = '$bad->rate_id'");
        	$worse_qry=$this->db->query("SELECT * FROM foods, polls_details WHERE polls_details.food_id = '$food_id' AND foods.food_id = '$food_id' AND polls_details.rate_id = '$worse->rate_id'");

        }

		$get_ratings[] = array(
			'ratings'	=>	$query,
			'excellent_query'	=>	$excellent_qry,
			'good_query'	=>	$good_qry,		
			'average_query'	=>	$average_qry,		
			'bad_query'	=>	$bad_qry,		
			'worse_query'	=>	$worse_qry		
		);
		
		return $get_ratings;
	}


}