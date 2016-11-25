<?php

/**
 * 설문조사 문항 정보를 담는 survey_item 테이블에 대한 DB 셋업 클래스
 *
 * id 		INT (PK)	: 설문 id값.
 * survey_id	INT (FK)	: 설문조사 id (surveys.id)
 * title 	VARCHAR(256)	: 문항 제목 
 * class	INT		: 문항 종류
 *   (10 - 다항선택형(양자택일, 평정형), 20 - 서열형, 30 - 개방형)
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
		$this->dbforge->add_field('survey_id INT NOT NULL');
		$this->dbforge->add_field('title VARCHAR(256)');
		$this->dbforge->add_field('class INT NOT NULL');

		$this->dbforge->create_table($this->table_name, FALSE);
	}

	public function fulfill_table() {
	}

	public function drop_table() {
		$this->dbforge->drop_table($this->table_name);
	}
}
