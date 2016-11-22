<?php

/**
 * 이용안내
 * 
 * @author dgkim
 */
class Notice_model extends CI_Model {

	var $table_name = 'notices';

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	/**
	 * 전체 이용안내 목록을 반환한다.
	 */
	public function get_notices($count = 5) {
		$this->db->select('id, title, writer, create_datetime, modify_datetime, content');
		$this->db->from($this->table_name);
		//$this->db->where('login_name', $username);
		$this->db->limit(5);
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * 이용안내 ID를 통해 설문조사를 반환한다.
	 */
	public function get_notice($notice_id) {
		$this->db->select('id, title, writer, create_datetime, modify_datetime, content');
		$this->db->from($this->table_name);
		$this->db->where('id', $notice_id);
		//$this->db->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}
}
