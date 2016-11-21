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

	/**
	 * 전체 설문조사 목록을 반환한다.
	 */
	public function get_surveys() {
		$this->db->select('id, title');
		$this->db->from($this->table_name);
		//$this->db->where('login_name', $username);
		//$this->db->limit(1);
		$query = $this->db->get();
		return $query->result_array();
	}

	/**
	 * 설문조사 ID를 통해 설문조사를 반환한다.
	 */
	public function get_survey($survey_id) {
		$this->db->select('id, title');
		$this->db->from($this->table_name);
		$this->db->where('id', $survey_id);
		//$this->db->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}

	/**
	 * 사용자에게 도착한 설문조사 목록을 반환한다.
	 *
	 * $uid = 설문조사 수신 대상자의 ID
	 * $with_anonymous = 익명 설문조사 포함 여부
	 */
	public function get_surveys_received($uid, $with_anonymous = FALSE) {
		$this->db->select('surveys.id, title, notbefore, notafter, surveyor_name, surveyor_mail, surveyor_phone, surveys.status, content');
		$this->db->from('surveys');
		$this->db->join('survey_inbox', 'survey_inbox.survey_id = surveys.id');
		if ( $with_anonymous ) {
			$this->db->where('survey_inbox.user_id = ' . $uid . ' OR survey_inbox.user_id = -1');
		} else {
			$this->db->where('survey_inbox.user_id', $uid);
		}
		$query = $this->db->get();
		return $query->result();
	}
}
