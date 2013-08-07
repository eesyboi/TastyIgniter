<?php
class Specials_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function getList($limit = FALSE, $start = FALSE) {
	}
	
	public function getDeals($deals = FALSE) {
		if ($deals === FALSE) {
			$this->db->from('specials');

			$query = $this->db->get();
			return $query->result_array();
		}
	}

	public function getDeal($deal_id) {
		
		$this->db->from('specials');
		$this->db->where('deal_id', $deal_id);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function addDeal($deal_name, $deal_description, $deal_price, $start_date, $end_date, $deal_photo) {
		$add_data = array(
			'deal_name' 		=> $deal_name,
			'deal_description' 	=> $deal_description,
			'deal_price' 		=> $deal_price,
			'start_date' 		=> $start_date,
			'end_date' 			=> $end_date,
			'deal_photo' 		=> $deal_photo
		);
		
		return $this->db->insert('specials', $add_data);
	}

	public function updateDeal($deal_id, $deal_name, $deal_description, $deal_price, $start_date, $end_date, $deal_photo) {
		if ($deal_photo !== '') {
			$update_data['deal_photo'] = $deal_photo;
		}
		
		$update_data['deal_name'] 		= $deal_name;
		$update_data['deal_description'] = $deal_description;
		$update_data['deal_price'] 		= $deal_price;
		$update_data['start_date'] 		= $start_date;
		$update_data['end_date'] 		= $end_date;
		
		$this->db->where('deal_id', $deal_id);
		return $this->db->update('specials', $update_data);
	}
	public function deleteDeal($deal_id) {
		$remove_data = array(
			'deal_id' => $deal_id
		);
			
		return $this->db->delete('specials', $remove_data);
	}
}