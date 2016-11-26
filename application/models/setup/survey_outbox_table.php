<?php

/**
 * 설문조사 발신 정보를 담는 survey_outbox 테이블에 대한 DB 셋업 클래스
 *
 * id 		INT (PK)	: 설문 수신 ID
 * survey_id 	INT (FK)	: 설문 조사 ID (surveys.id)
 * user_id	INT (FK)	: 설문 참여자 ID (user.id)
 * status	INT		: 설문지 상태
 *
 * @author dgkim
 */
class Survey_outbox_table extends CI_Model {

	private $table_name = 'survey_outbox';

	public function __construct() {
		parent::__construct();
	}

	public function create_table() {

		$this->dbforge->add_field('id INT NOT NULL AUTO_INCREMENT PRIMARY KEY');
		$this->dbforge->add_field('survey_id INT');
		$this->dbforge->add_field('user_id INT');
		$this->dbforge->add_field('status INT');

		$this->dbforge->create_table($this->table_name, FALSE);
	}

	public function fulfill_table() {
	}

	public function drop_table() {
		$this->dbforge->drop_table($this->table_name);
	}
}
