<?php
class Reviews_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function getRatings() {
		$this->db->from('ratings');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function getReviews() {
		$this->db->from('reviews');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function checkReview($food_id, $customer_id) {
		$this->db->from('reviews');

		$this->db->where('food_id', $food_id);
		$this->db->where('customer_id', $customer_id);
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
		
			return $query->row_array();
		
		} else {
		 	
		 	return FALSE;
		
		}
	}

	public function foodReview($food_id, $customer_id, $rating_id) {
	
		$review_data = $this->checkReview($food_id, $customer_id);
		
		if ($review_data) {
 					
			$this->db->where('review_id', $review_data['review_id']);
			$this->db->where('customer_id', $review_data['customer_id']);
			$this->db->where('food_id', $review_data['food_id']);
			return $this->db->update('reviews', $update = array('food_rating' => $rating_id));

		}
		
		if ( ! $review_data && $customer_id !== FALSE) {
			
			$update['customer_id'] = $customer_id;
			$update['food_id'] = $food_id;
			$update['food_rating'] = $rating_id;

			return $this->db->insert('reviews', $update);
					
		}
	}
}