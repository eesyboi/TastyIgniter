<?php
class Currency {
	private $currency_id;
	private $currency_list;
	private $currency_symbol;
	private $currency_status;
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->database();
		
		$this->CI->db->select('*');
		$this->CI->db->from('currencies');	
		$query = $this->CI->db->get();

		if ($query->num_rows() > 0) {
			
			$this->CI->currency_list = $query->result_array();
			
			foreach ($query->result_array() as $row) {
				
				if ($row['currency_status'] === '1') { 
				
					$this->CI->currency_symbol = $row['currency_symbol'];
				}
			}
		}
	}
	
	public function getCurrencies() {
		return $this->CI->currency_list;	
	}

	public function symbol() {
		return $this->CI->currency_symbol;	
	}
}