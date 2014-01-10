<?php
class Settings_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function getAll() {
		$this->db->from('settings');
		
		$query = $this->db->get();
		return $query->result();
	}

	public function updateSettings($sort, $update = array()) {
 
 		if (!empty($update) && !empty($sort)) {
			$this->db->where('sort', $sort);
			$this->db->delete('settings');

			foreach ($update as $key => $value) {

				$this->db->set('sort', $sort);
				$this->db->set('key', $key);
				$this->db->set('value', $value);
				$this->db->insert('settings');
			}
		
			return TRUE;
		}
 	}

	public function deleteSettings($sort) {
		$this->db->where('sort', $sort);
			
		return $this->db->delete('settings');
	}

	function getTimezones() {
		$timezoneIdentifiers = DateTimeZone::listIdentifiers();
		$utcTime = new DateTime('now', new DateTimeZone('UTC'));
 
		$tempTimezones = array();
		foreach ($timezoneIdentifiers as $timezoneIdentifier) {
			$currentTimezone = new DateTimeZone($timezoneIdentifier);
 
			$tempTimezones[] = array(
				'offset' => (int)$currentTimezone->getOffset($utcTime),
				'identifier' => $timezoneIdentifier
			);
		}
 
		// Sort the array by offset,identifier ascending
		usort($tempTimezones, function($a, $b) {
			return ($a['offset'] == $b['offset'])
				? strcmp($a['identifier'], $b['identifier'])
				: $a['offset'] - $b['offset'];
		});
 
		$timezoneList = array();
		foreach ($tempTimezones as $tz) {
			$sign = ($tz['offset'] > 0) ? '+' : '-';
			$offset = gmdate('H:i', abs($tz['offset']));
			$timezoneList[$tz['identifier']] = '(UTC ' . $sign . $offset .') '. $tz['identifier'];
		}
 
		return $timezoneList;
	}

	public function restoreDatabase($sql) {
		foreach (explode(";\n", $sql) as $sql) {
    		$sql = trim($sql);
    		
			if ($sql) {
      			$this->db->query($sql);
    		}
  		}
  		
  		return TRUE;
	}
}
