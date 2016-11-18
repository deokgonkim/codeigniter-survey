<?php

/**
 * 사용자 모델
 *
 * @author dgkim
 */
class User_model extends CI_Model {

	var $table_name = 'user';

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	function login($username, $password) {
		foreach ($this->get_realms() as $realm) {
			if ( $realm->type == 'Internal' ) {
				log_message('error', 'Attempting Internal login process.');
				$this->db->select('id, login_name, password');
				$this->db->from($this->table_name);
				$this->db->where('login_name', $username);
				$this->db->limit(1);
				    
				$query = $this->db->get();
				if($query->num_rows() == 1) {
					if ( $query->row()->password !== hash('sha1', $password) ) {
						throw new Exception('Password invalid');
					}
					return $query->row();
				} else {
					throw new Exception('No such user');
				}

				$this->db->where('password', hash('sha1', $password));

				break;
			}
			if ( $realm->type == 'LDAP' ) {
				log_message('error', 'Attempting LDAP login process.');
				throw new Exception('Not Implemented yet.');
				break;
			}
			if ( $realm->type == 'SQL' ) {
				log_message('error', 'Attempting SQL login process.');
				throw new Exception('Not Implemented yet.');
				break;
			}
		}
	}

	private function get_realms() {
		$this->db->select('class, name, type');
		$this->db->from('realm');
		$this->db->where('class', 'User');
		$query = $this->db->get();
		return $query->result();
	}
}
