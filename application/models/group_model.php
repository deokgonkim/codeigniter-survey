<?php

/**
 * 그룹 모델
 *
 * @author dgkim
 */
class Group_model extends CI_Model {

	private $table_name = 'group';

	private $group_columns = 'id, name, type, description, can_admin, can_read, can_create, can_modify';

	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('Setup_model');
	}

	public function get_groups() {
		$groups = array();
		foreach ($this->Setup_model->get_realms('Group') as $realm) {
			if ( $realm->type == 'Internal' ) {
				$this->db->select($this->group_columns);
				$this->db->from($this->table_name);
				$query = $this->db->get();
				$this->logger->debug('retrived group : ' . $query->result());
				array_push($groups, $query->result());
				break;
			}
			if ( $realm->type == 'LDAP' ) {
				$this->logger->log('Attempting LDAP group process.');
				throw new Exception('Not Implemented yet.');
				break;
			}
			if ( $realm->type == 'SQL' ) {
				$this->logger->log('Attempting SQL login process.');
				throw new Exception('Not Implemented yet.');
				break;
			}
		}
		$this->logger->debug('All groups : ' . $groups);
		return $groups;
	}

	/**
	 * 그룹 ID를 받아 해당 그룹을 반환한다.
	 */
	public function get_group_by_gid($gid) {
		$this->db->select($this->group_columns);
		$this->db->from($this->table_name);
		$this->db->where('id', $gid);
		$query = $this->db->get();
		return $query->row();
	}

	/**
	 * 그룹 이름을 받아 해당 그룹을 반환한다.
	 */
	public function get_group_by_name($name) {
		$this->db->select($this->group_columns);
		$this->db->from($this->table_name);
		$this->db->where('name', $name);
		$query = $this->db->get();
		return $query->row();
	}

	/**
	 * 그룹 ID를 받아, 해당 그룹의 맴버 목록을 반환한다.
	 */
	public function get_group_members_by_gid($gid) {
		$this->db->select('user_id');
		$this->db->from('group_member');
		$this->db->where('group_id', $gid);
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * 사용자 ID를 받아, 해당 사용자가 속한 그룹 목록을 반환한다.
	 */
	public function get_groups_by_uid($uid) {
		$groups = array();
		$group_ids = $this->get_group_ids_by_uid($uid);

		foreach ($group_ids as $group) {
			$group = $this->get_group_by_gid($group->group_id);
			array_push($groups, $group);
		}
		// @TODO LDAP, SQL 방식일 경우에 대한 구현 요망.
		// @TODO 현재, 기본 사용자 그룹은 항상 속하는 것으로 한다. (gid: 2)
		$users = $this->get_group_by_gid(2);
		array_push($groups, $users);

		return $groups;
	}

	/**
	 * 사용자 ID로 속한 그룹의 ID들 목록을 반환한다.
	 *
	 * 아래와 같은 형태로 활용.
	 * $group_ids = get_group_ids_by_uid($uid);
	 * foreach($group_ids as $row) {
	 *     echo $row['group_id'];
	 * }
	 */
	public function get_group_ids_by_uid($uid) {
		$this->db->select('group_id');
		$this->db->from('group_member');
		$this->db->where('user_id', $uid);
		$query = $this->db->get();
		return $query->result();
	}
}
