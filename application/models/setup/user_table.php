<?php

/**
 * 사용자 정보를 담는 user 테이블에 대한 DB 셋업 클래스
 *
 * id(PK)	INT		: 시스템에서 사용하는 사용자 id값.
 * login_name	VARCHAR(80)	: 사용자 로그인명. ex. admin
 * name		VARCHAR(80)	: 사용자 이름
 * password	VARCHAR(40)	: 사용자 비밀번호(sha1 hex encoded 40byte)
 * email	VARCHAR(80)	: 사용자 이메일주소
 * attr1	VARCHAR(80)	: 사용자 속성1
 * attr2	VARCHAR(80)	: 사용자 속성2
 * attr3	VARCHAR(80)	: 사용자 속성3
 *
 * @author dgkim
 */
class User_table extends CI_Model {

	var $table_name = 'user';

	public function __construct() {
		parent::__construct();
	}

	public function create_table() {

		$this->dbforge->add_field('id INT NOT NULL AUTO_INCREMENT PRIMARY KEY');
		$this->dbforge->add_field('login_name VARCHAR(80) NOT NULL');
		$this->dbforge->add_field('name VARCHAR(80) NOT NULL');
		$this->dbforge->add_field('password VARCHAR(40)');
		$this->dbforge->add_field('email VARCHAR(80)');
		$this->dbforge->add_field('attr1 VARCHAR(80)');
		$this->dbforge->add_field('attr2 VARCHAR(80)');
		$this->dbforge->add_field('attr3 VARCHAR(80)');
		$this->dbforge->create_table($this->table_name, FALSE);
	}

	public function fulfill_table() {
		$data = array(
				'login_name' => 'admin',
				'name' => '관리자',
				'password' => hash('sha1', 'nimda'),
				'email' => 'admin@example.com'
			);

		$query = $this->db->get_where('user', array('login_name' => 'admin'), 1, 0);
		if ( $query->result() )	{
			throw new Exception('admin user exists');
		}
		$this->db->insert($this->table_name, $data);
	}

	public function drop_table() {
		$this->dbforge->drop_table($this->table_name);
	}
}
