<<<<<<< HEAD
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Currency {
	private $currency_symbol;
	private $currency_code;
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->database();
		
		if ($this->CI->config->item('config_currency')) {
			$this->CI->db->from('currencies');	
			$this->CI->db->where('currency_id', $this->CI->config->item('config_currency'));
			$query = $this->CI->db->get();

			if ($query->num_rows() === 1) {
			
				$row = $query->row_array();
								
				$this->CI->currency_symbol 	= $row['currency_symbol'];
				$this->CI->currency_code 	= $row['currency_code'];
			
			}

		} else {
			
			$this->CI->currency_symbol = '';
			$this->CI->currency_code = '';
		
		}
	}
	
	public function getCurrencyCode() {
		return $this->CI->currency_code;
	}
	
	public function format($num) {
		if (empty($num)) {
			$num = '0';	
		}

		return $this->CI->currency_symbol . number_format($num, 2, '.', ',');	
	}
=======
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
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
}