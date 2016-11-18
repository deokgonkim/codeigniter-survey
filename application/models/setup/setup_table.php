<?php

/**
 * 시스템 셋업 정보를 담는 setup 테이블 클래스
 *
 * id(PK)	INT		: 현재는 하나의 레코드만 저장하므로 의미 없음.
 * version	VARCHAR(16)	: 시스템 버전 문자열을 가짐. 버전정보를 통해 스키마의 업그레이드 여부 판단
 * system_name	VARCHAR(40)	: 시스템 명칭
 *
 * @author dgkim
 */
class Setup_table extends CI_Model {

	var $table_name = 'setup';

	public function __construct() {
		parent::__construct();
	}

	public function create_table() {
		$this->dbforge->add_field('id INT NOT NULL AUTO_INCREMENT PRIMARY KEY');
		$this->dbforge->add_field('version VARCHAR(16) NOT NULL');
		$this->dbforge->add_field('system_name VARCHAR(40) NOT NULL');
		$this->dbforge->create_table($this->table_name, FALSE);
	}

	public function fulfill_table() {
		$data = array(
				'version' => '0.1',
				'system_name' => '설문조사시스템'
			);

		$query = $this->db->get('setup', 1, 0);
		if ( $query->result() )	{
			throw new Exception('setup data exists');
		}
		$this->db->insert($this->table_name, $data);
	}

	public function drop_table() {
		$this->dbforge->drop_table($this->table_name);
	}
}
