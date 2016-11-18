<?php

/**
 * 사용자 정보에 대한 소스인 realm 정보를 담는 realm 테이블 클래스
 *
 * id(PK)	INT		: 렐름 ID
 * class	VARCHAR(32)	: Realm 구분 ( User, Group )
 * name		VARCHAR(80)	: 시스템 명칭
 * type		VARCHAR(32)	: 구분 (Internal, LDAP, SQL)
 * host		VARCHAR(80)	: 연동시스템 호스트 (LDAP, SQL)
 * port		VARCHAR(10)	: 연동시스템 포트 (LDAP, SQL)
 * username	VARCHAR(64)	: 연동시스템 로그인 (LDAP의 경우 Bind DN, SQL의 경우 로그인명)
 * password	VARCHAR(64)	: 연동시스템 비밀번호
 * ldap_basedn	VARCHAR(64)	: 연동시스템(LDAP) 찾기DN
 * ldap_tls	VARCHAR(10)	: 연동시스템(LDAP) TLS 및 SSL 사용여부. (Plain, STARTTLS, SSL)
 * ldap_scope	VARCHAR(10)	: 연동시스템(LDAP) Scope (onelevel, subtree)
 * ldap_binddn_pat VARCHAR(80)	: 연동시스템(LDAP) 로그인 DN형태 (uid=${uid}, ou=Users, o=ITSM, c=KR)
 * ldap_search_pat VARCHAR(80)	: 연동시스템(LDAP) 사용자 찾기 (objectClass=inetOrgPerson)
 * ldap_login_attr VARCHAR(32)	: 연동시스템(LDAP) 사용자 로그인 속성 (uid)
 * ldap_name_attr VARCHAR(32)	: 연동시스템(LDAP) 사용자 이름 속성 (cn)
 * ldap_email_attr VARCHAR(32)	: 연동시스템(LDAP) 사용자 이메일 속성명 (mail)
 * ldap_attr1	VARCHAR(32)	: 연동시스템(LDAP) 속성1 속성
 * ldap_attr2	VARCHAR(32)	: 연동시스템(LDAP) 속성2 속성
 * ldap_attr3	VARCHAR(32)	: 연동시스템(LDAP) 속성3 속성
 * sql_vendor	VARCHAR(16)	: 연동시스템(SQL) DB종류 (MySQL, PostgreSQL, Oracle)
 * sql_dbname	VARCHAR(32)	: 연동시스템(SQL) DB명 (MySQL DBName, PostgreSQL schemaname, Oracle ServiceName)
 * sql_query	TEXT		: 연동시스템(SQL) 쿼리
 *   (SELECT USERNAME, PASSWORD, EMAIL, DEPT_NAME, TITLE, MOBILE FROM V_USER)
 * sql_pwenc	VARCHAR(10)	: 연동시스템(SQL) 비밀번호 암호화 종류 (Plain, SHA1HEX, SHA1BASE64, Query)
 * sql_pwquery	TEXT		: 연동시스템(SQL) 비밀번호 검증 SQL
 *
 * @author dgkim
 */
class Realm_table extends CI_Model {

	var $table_name = 'realm';

	public function __construct() {
		parent::__construct();
	}

	public function create_table() {
		$this->dbforge->add_field('id INT NOT NULL AUTO_INCREMENT PRIMARY KEY');
		$this->dbforge->add_field('class VARCHAR(32) NOT NULL');
		$this->dbforge->add_field('name VARCHAR(80) NOT NULL');
		$this->dbforge->add_field('type VARCHAR(32) NOT NULL');
		$this->dbforge->add_field('host VARCHAR(80)');
		$this->dbforge->add_field('port VARCHAR(10)');
		$this->dbforge->add_field('username VARCHAR(64)');
		$this->dbforge->add_field('password VARCHAR(64)');
		$this->dbforge->add_field('ldap_basedn VARCHAR(64)');
		$this->dbforge->add_field('ldap_tls VARCHAR(10)');
		$this->dbforge->add_field('ldap_scope VARCHAR(10)');
		$this->dbforge->add_field('ldap_binddn_pat VARCHAR(80)');
		$this->dbforge->add_field('ldap_search_pat VARCHAR(80)');
		$this->dbforge->add_field('ldap_login_attr VARCHAR(32)');
		$this->dbforge->add_field('ldap_name_attr VARCHAR(32)');
		$this->dbforge->add_field('ldap_email_attr VARCHAR(32)');
		$this->dbforge->add_field('ldap_attr1 VARCHAR(32)');
		$this->dbforge->add_field('ldap_attr2 VARCHAR(32)');
		$this->dbforge->add_field('ldap_attr3 VARCHAR(32)');
		$this->dbforge->add_field('sql_vendor VARCHAR(16)');
		$this->dbforge->add_field('sql_dbname VARCHAR(32)');
		$this->dbforge->add_field('sql_query TEXT');
		$this->dbforge->add_field('sql_pwenc VARCHAR(10)');
		$this->dbforge->add_field('sql_pwquery TEXT');
		$this->dbforge->create_table($this->table_name, FALSE);
	}

	public function fulfill_table() {
		$query = $this->db->get($this->table_name, 1, 0);
		if ( $query->result() )	{
			throw new Exception('realm data exists');
		}
		$data = array(
				'class' => 'User',
				'name' => '로컬 인증',
				'type' => 'Internal'
			);
		$this->db->insert($this->table_name, $data);
		$data = array(
				'class' => 'Group',
				'name' => '로컬 그룹',
				'type' => 'Internal'
			);
		$this->db->insert($this->table_name, $data);
	}

	public function drop_table() {
		$this->dbforge->drop_table($this->table_name);
	}
}
