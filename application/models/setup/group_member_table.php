<?php

/**
 * 그룹 구성원 정보를 담는 group_member 테이블에 대한 DB 셋업 클래스
 *
 * id(PK)	INT		: 시스템에서 사용하는 그룹멤버 id값.
 * group_id(FK)	INT		: 그룹 ID값 ( group.id )
 * user_id(FK)	INT		: 사용자 ID ( user.id )
 *
 * @author dgkim
 */
class Group_member_table extends CI_Model {

	private $table_name = 'group_member';

	public function __construct() {
		parent::__construct();
	}

	public function create_table() {

		$this->dbforge->add_field('id INT NOT NULL AUTO_INCREMENT PRIMARY KEY');
		$this->dbforge->add_field('group_id INT NOT NULL');
		$this->dbforge->add_field('user_id INT NOT NULL');
		$this->dbforge->create_table($this->table_name, FALSE);
	}

	public function fulfill_table() {
		$query = $this->db->get_where($this->table_name, array('group_id' => 1), 1, 0);
		if ( $query->result() )	{
			throw new Exception('Administrators group exists');
		}
		$data = array(
				'group_id' => 1,
				'user_id' => 1
			);
		$this->db->insert($this->table_name, $data);
	}

	public function drop_table() {
		$this->dbforge->drop_table($this->table_name);
	}
}
