<?php

/**
 * 설정 모델
 *
 * @author dgkim
 */
class Setup_model extends CI_Model {

	private $table_name = 'setup';

	private $realm_classes = array('User', 'Group');

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function is_attr1_enabled() {
		$this->db->select('attr1_enabled');
		$this->db->from($this->table_name);
		$query = $this->db->get();
		$this->logger->debug('attr1 enabled ? ' . $query->row()->attr1_enabled);
		return $query->row()->attr1_enabled;
	}

	public function is_attr2_enabled() {
		$this->db->select('attr2_enabled');
		$this->db->from($this->table_name);
		$query = $this->db->get();
		$this->logger->debug('attr2 enabled ? ' . $query->row()->attr2_enabled);
		return $query->row()->attr2_enabled;
	}

	public function is_attr3_enabled() {
		$this->db->select('attr3_enabled');
		$this->db->from($this->table_name);
		$query = $this->db->get();
		$this->logger->debug('attr3 enabled ? ' . $query->row()->attr3_enabled);
		return $query->row()->attr3_enabled;
	}

	/**
	 * 시스템에 등록된 Realm 목록을 반환한다.
	 *
	 * @param $class : User, Group
	 * @return array
	 */
	public function get_realms($class = 'User') {
		if ( ! in_array($class, $this->realm_classes ) ) {
			throw new Exception('Internal Error : Not supported realm class(' . $class . ')');
		}
		$this->db->select('class, name, type');
		$this->db->from('realm');
		$this->db->where('class', $class);
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * 시스템 이름을 반환한다.
	 */
	public function get_system_name() {
		$this->db->select('system_name');
		$this->db->from($this->table_name);
		$query = $this->db->get();
		$this->logger->debug($query->row()->system_name);
		return $query->row()->system_name;
	}

	/**
	 * 시스템 버전을 반환한다.
	 */
	public function get_version() {
		$this->db->select('version');
		$this->db->from($this->table_name);
		$query = $this->db->get();
		$this->logger->debug($query->row()->version);
		return $query->row()->version;
	}

	/**
	 * 회원 가입 허용 여부를 반환한다.
	 */
	public function get_allow_register() {
		$this->db->select('allow_register');
		$this->db->from($this->table_name);
		$query = $this->db->get();
		$this->logger->debug($query->row()->allow_register);
		return $query->row()->allow_register;
	}
}
