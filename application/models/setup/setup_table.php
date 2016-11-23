<?php

/**
 * 시스템 셋업 정보를 담는 setup 테이블 클래스
 *
 * id(PK)	INT		: 현재는 하나의 레코드만 저장하므로 의미 없음.
 * version	VARCHAR(16)	: 시스템 버전 문자열을 가짐. 버전정보를 통해 스키마의 업그레이드 여부 판단
 * system_name	VARCHAR(40)	: 시스템 명칭
 * allow_register BOOL		: 회원 가입 허용여부
 * register_link VARCHAR(256)	: 회원 가입 링크
 * recovery_link VARCHAR(256)	: 아이디/비밀번호 찾기 링크
 * attr1_enabled BOOL		: 사용자 속성1 사용여부
 * attr2_enabled BOOL		: 사용자 속성1 사용여부
 * attr3_enabled BOOL		: 사용자 속성1 사용여부
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
		$this->dbforge->add_field('allow_register BOOL NOT NULL DEFAULT TRUE');
		$this->dbforge->add_field('register_link VARCHAR(256)');
		$this->dbforge->add_field('recovery_link VARCHAR(256)');
		$this->dbforge->add_field('attr1_enabled BOOL');
		$this->dbforge->add_field('attr2_enabled BOOL');
		$this->dbforge->add_field('attr3_enabled BOOL');
		$this->dbforge->create_table($this->table_name, FALSE);
	}

	public function fulfill_table() {
		$data = array(
				'version' => '0.1',
				'system_name' => '설문조사시스템',
				'allow_register' => TRUE,
				'attr1_enabled' => FALSE,
				'attr2_enabled' => FALSE,
				'attr3_enabled' => FALSE
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
