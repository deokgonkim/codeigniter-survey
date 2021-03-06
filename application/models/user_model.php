<?php

/**
 * 사용자 모델
 *
 * @author dgkim
 */
class User_model extends CI_Model {

	protected $table_name = 'user';

	protected $attr1_enabled = FALSE;
	protected $attr2_enabled = FALSE;
	protected $attr3_enabled = FALSE;

	private $login_columns = 'id, login_name, password';

	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('Setup_model');
		$this->attr1_enabled = $this->Setup_model->is_attr1_enabled();
		$this->attr2_enabled = $this->Setup_model->is_attr2_enabled();
		$this->attr3_enabled = $this->Setup_model->is_attr3_enabled();

		if ( $this->attr1_enabled ) {
			$this->login_columns .= ', attr1';
		}
		if ( $this->attr2_enabled ) {
			$this->login_columns .= ', attr2';
		}
		if ( $this->attr3_enabled ) {
			$this->login_columns .= ', attr3';
		}
	}

	function login($username, $password) {
		$this->logger->debug('login columns : ' . $this->login_columns);

		foreach ($this->Setup_model->get_realms('User') as $realm) {
			if ( $realm->type == 'Internal' ) {
				log_message('error', 'Attempting Internal login process.');
				$this->db->select($this->login_columns);
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

	public function get_user_by_uid($uid) {
		$this->db->select('id, login_name, name, email, attr1, attr2, attr3');
		$this->db->from($this->table_name);
		$this->db->where('id', $uid);
		$query = $this->db->get();
		return $query->row();
	}

	public function get_user_by_login($login) {
		$this->db->select('id, login_name, name, email, attr1, attr2, attr3');
		$this->db->from($this->table_name);
		$this->db->where('login_name', $login);
		$query = $this->db->get();
		return $query->row();
	}

	public function get_user_by_mail($mail) {
		$this->db->select('id, login_name, name, email, attr1, attr2, attr3');
		$this->db->from($this->table_name);
		$this->db->where('email', $mail);
		$query = $this->db->get();
		return $query->row();
	}
	
	/**
	 * 회원 가입 처리
	 */
	public function create($login, $password, $name, $mail) {
		if ( ! $this->Setup_model->get_allow_register() ) {
			throw new Exception('Not allow register');
		}

		if ( $this->get_user_by_login($login) ) {
			throw new Exception('Already existing login');
		}
		$password_hashed = hash('sha1', $password);
		$data = array(
			'login_name' => $login,
			'name' => $name,
			'password' => $password_hashed,
			'email' => $mail
		);
		$this->db->insert($this->table_name, $data);
	}
}
