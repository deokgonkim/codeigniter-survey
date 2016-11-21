<?php

/**
 * 설문조사
 * 
 * @author dgkim
 */
class Survey_model extends CI_Model {

	var $table_name = 'surveys';

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function get_surveys() {
		$this->db->select('id, title');
		$this->db->from($this->table_name);
		//$this->db->where('login_name', $username);
		//$this->db->limit(1);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_survey($survey_id) {
		$this->db->select('id, title');
		$this->db->from($this->table_name);
		$this->db->where('id', $survey_id);
		//$this->db->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}
}
