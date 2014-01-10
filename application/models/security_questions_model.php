<?php
class Security_questions_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function getSecurityQuestions($question_id = FALSE) {
		if ($question_id === FALSE) {
			$this->db->from('security_questions');

			$query = $this->db->get();
			return $query->result_array();
		}

		$this->db->from('security_questions');
		$this->db->where('question_id', $question_id);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getSecurityQuestion($question_id) {
		$this->db->from('security_questions');

		$this->db->where('question_id', $question_id);
		$query = $this->db->get();
		
		return $query->row_array();
	}

	public function updateSecurityQuestion($update = array()) {

		if (!empty($update['question_text'])) {
			$this->db->set('question_text', $update['question_text']);
		}

		if (!empty($update['question_id'])) {
			$this->db->where('question_id', $update['question_id']);
			$this->db->update('security_questions'); 
		}
				
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function addSecurityQuestion($add = array()) {

		if (!empty($add['question_text'])) {
			$this->db->set('question_text', $add['question_text']);
		}
			
		$this->db->insert('security_questions');
		
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function deleteSecurityQuestion($question_id) {

		$this->db->where('question_id', $question_id);
		
		$this->db->delete('security_questions');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
}