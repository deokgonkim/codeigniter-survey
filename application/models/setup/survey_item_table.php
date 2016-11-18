<?php

/**
 * 설문조사 문항 정보를 담는 survey_item 테이블에 대한 DB 셋업 클래스
 *
 * id 		INT (PK)	: 설문 id값.
 * survey_id	INT (FK)	: 설문조사 id (surveys.id)
 * item_title 	VARCHAR(256)	: 문항 제목 
 * item_class	INT		: 문항 종류
 *   (10 - 다항선택형(양자택일, 평정형), 20 - 서열형, 30 - 개방형)
 *  DATETIME	: 설문 작성일시
 * modifier	INT		: 설문 수정자
 * modify_datetime DATETIME	: 설문 수정일시
 * content	TEXT		: 설문 내용
 *
 * @author dgkim
 */
class Survey_item_table extends CI_Model {

	var $table_name = 'survey_item';

	public function __construct() {
		parent::__construct();
	}

	public function create_table() {

		$this->dbforge->add_field('id INT NOT NULL AUTO_INCREMENT PRIMARY KEY');
		$this->dbforge->add_field('title VARCHAR(256) NOT NULL');
		$this->dbforge->add_field('creator INT NOT NULL');
		$this->dbforge->add_field('create_datetime DATETIME');
		$this->dbforge->add_field('modifier INT');
		$this->dbforge->add_field('modify_datetime DATETIME');
		$this->dbforge->add_field('content TEXT');

		$this->dbforge->create_table($this->table_name, FALSE);
	}

	public function fulfill_table() {
		$data = array(
				'title' => '환영합니다.',
				'creator' => 1,
				'create_datetime' => date_create()->format('Y-m-d H:i:s'),
				'content' => '설문조사 시스템 사용을 환영합니다.'
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
