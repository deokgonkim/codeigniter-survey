<?php

/**
 * 설문조사 문항 답항 정보를 담는 survey_item_answer 테이블에 대한 DB 셋업 클래스
 *
 * id 		INT (PK)	: 답항 id값.
 * item_id	INT (FK)	: 설문 문항 id (survey_item.id)
 * val_id 	INT		: 답항 번호
 * val_text	VARCHAR(256)	: 답항 텍스트
 *
 * @author dgkim
 */
class Survey_item_answer_table extends CI_Model {

	var $table_name = 'survey_item_answer';

	public function __construct() {
		parent::__construct();
	}

	public function create_table() {

		$this->dbforge->add_field('id INT NOT NULL AUTO_INCREMENT PRIMARY KEY');
		$this->dbforge->add_field('item_id INT NOT NULL');
		$this->dbforge->add_field('val_id INT NOT NULL');
		$this->dbforge->add_field('val_text VARCHAR(256) NOT NULL');

		$this->dbforge->create_table($this->table_name, FALSE);
	}

	public function fulfill_table() {
	}

	public function drop_table() {
		$this->dbforge->drop_table($this->table_name);
	}
}
