<?php

/**
 * 설문조사 수신 정보를 담는 survey_inbox 테이블에 대한 DB 셋업 클래스
 * (술문에 참여하는 사람은, survey_inbox 테이블을 참조하여 해당 설문을 참여한다)
 *
 * id 		INT (PK)	: 설문 수신 ID
 * survey_id 	INT (FK)	: 설문 조사 ID (surveys.id)
 * user_id	INT (FK)	: 설문 참여자 ID (user.id)
 * status	INT		: 설문지 상태
 *   (1 - 수신, 2 - 확인, 3 - 완료, 4 - 거부)
 * create_datetime DATETIME	: 설문지 도착 일시
 * modify_datetime DATETIME	: 설문지 변경 일시
 *
 * @author dgkim
 */
class Survey_inbox_table extends CI_Model {

	var $table_name = 'survey_inbox';

	public function __construct() {
		parent::__construct();
	}

	public function create_table() {

		$this->dbforge->add_field('id INT NOT NULL AUTO_INCREMENT PRIMARY KEY');
		$this->dbforge->add_field('survey_id INT');
		$this->dbforge->add_field('user_id INT');
		$this->dbforge->add_field('status INT');
		$this->dbforge->add_field('create_datetime DATETIME');
		$this->dbforge->add_field('modify_datetime DATETIME');

		$this->dbforge->create_table($this->table_name, FALSE);
	}

	public function fulfill_table() {
		$data = array(
				'survey_id' => 1,
				'user_id' => 1,
				'create_datetime' => date_create()->format('Y-m-d H:i:s')
			);

		$query = $this->db->get_where($this->table_name, array('id' => '1'), 1, 0);
		if ( $query->result() )	{
			throw new Exception('default data exists');
		}
		$this->db->insert($this->table_name, $data);
	}

	public function drop_table() {
		$this->dbforge->drop_table($this->table_name);
	}
}
