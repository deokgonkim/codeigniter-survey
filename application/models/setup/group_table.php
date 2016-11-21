<?php

/**
 * 그룹 정보를 담는 group 테이블에 대한 DB 셋업 클래스
 *
 * id(PK)	INT		: 시스템에서 사용하는 그룹 id값.
 * realm_id(FK)	INT		: Realm ID (realm.id)
 * name		VARCHAR(80)	: 그룹명 ex. Administrators
 * type		VARCHAR(32)	: 그룹 구분 (Internal, LDAP, SQL, User)
 * description	VARCHAR(256)	: 그룹 설명
 * can_admin	BOOL		: 관리자 사용 권한 ( 이 권한은 다른 권한을 초월합니다. )
 * can_read	BOOL		: 설문조사 참여 권한
 * can_create	BOOL		: 설문조사 생성 권한
 * can_modify	BOOL		: 설문조사 관리 권한 ( 이 권한은 설문조사 생성 권한을 초월합니다. )
 *
 * @author dgkim
 */
class Group_table extends CI_Model {

	private $table_name = 'group';

	public function __construct() {
		parent::__construct();
	}

	public function create_table() {

		$this->dbforge->add_field('id INT NOT NULL AUTO_INCREMENT PRIMARY KEY');
		$this->dbforge->add_field('realm_id INT NOT NULL');
		$this->dbforge->add_field('name VARCHAR(80) NOT NULL');
		$this->dbforge->add_field('type VARCHAR(32) NOT NULL');
		$this->dbforge->add_field('description VARCHAR(256)');
		$this->dbforge->add_field('can_admin VARCHAR(80) NOT NULL DEFAULT FALSE');
		$this->dbforge->add_field('can_read BOOL NOT NULL DEFAULT FALSE');
		$this->dbforge->add_field('can_create BOOL NOT NULL DEFAULT FALSE');
		$this->dbforge->add_field('can_modify BOOL NOT NULL DEFAULT FALSE');
		$this->dbforge->create_table($this->table_name, FALSE);
	}

	public function fulfill_table() {
		$query = $this->db->get_where($this->table_name, array('name' => '관리자'), 1, 0);
		if ( $query->result() )	{
			throw new Exception('Administrators group exists');
		}
		$data = array(
				'realm_id' => 2,
				'name' => '관리자',
				'type' => 'Internal',
				'description' => '관리자 권한 사용자',
				'can_admin' => TRUE
			);
		$this->db->insert($this->table_name, $data);
		$data = array(
				'realm_id' => 2,
				'name' => '사용자',
				'type' => 'Internal',
				'description' => '일반 사용자(설문 참여 권한)',
				'can_read' => TRUE
			);
		$this->db->insert($this->table_name, $data);
	}

	public function drop_table() {
		$this->dbforge->drop_table($this->table_name);
	}
}
