<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 로그인 관련 기능을 담당하는 컨트롤러
 *
 * @author dgkim
 */
class Login extends Base_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('User_model');
		$this->load->model('Group_model');
		$this->load->model('Setup_model');
	}

	/**
	 * 로그인 화면
	 */
	public function index()
	{
		$this->form_validation->set_rules('login_name', 'Login Name', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_authenticate');

		$data = array();
		$data = array(
			'register' => FALSE,
			'register_link' => 'login/register',
			'selfserv_link' => 'login/recovery'
		);

		if ( $this->Setup_model->get_allow_register() ) {
			$data['register'] = TRUE;
			$data['register_link'] = $this->Setup_model->get_register_link();
			if ( empty($data['register_link']) ) {
				$data['register_link'] = 'login/register';
			}
		}
		$data['recovery_link'] = $this->Setup_model->get_recovery_link();
		if ( empty($data['recovery_link']) ) {
			$data['recovery_link'] = 'login/recovery';
		}

		if ( $this->form_validation->run() == FALSE ) {
			$this->load->view('templates/header', $data);
			$this->load->view('login/login', $data);
			$this->load->view('templates/footer', $data);
		} else {
			redirect('home', 'refresh');
		}
	}

	/**
	 * 로그인 화면 > 인증 처리부분
	 */
	function authenticate($password) {
		$login_name = $this->input->post('login_name');
		if ( !$login_name ) {
			return TRUE;
		}
		try {
			$data = $this->User_model->login($login_name, $password);
			if ( $data ) {
				$this->session->set_userdata('uid', $data->id);
				$this->session->set_userdata('login', $data->login_name);
				$groups = $this->Group_model->get_groups_by_uid($data->id);
				$group_ids = array();
				foreach( $groups as $group ) {
					array_push($group_ids, $group->id);
					if ( $group->can_admin ) {
						$this->session->set_userdata('admin', TRUE);
					}
					if ( $group->can_modify ) {
						$this->session->set_userdata('modify', TRUE);
					}
					if ( $group->can_create ) {
						$this->session->set_userdata('create', TRUE);
					}
					$this->logger->debug('User ' . $data->id . ' is in ' . $group->id . ' ' . $group->name);
				}

				$this->session->set_userdata('grp_ids', $group_ids);
				return TRUE;
			}
		} catch (Exception $e) {
			$this->logger->log('error occured \'' . $e->getMessage() . '\'');
			$this->form_validation->set_message('authenticate', $e->getMessage());
			return FALSE;
		}
	}

	/**
	 * 로그아웃 처리 페이지
	 */
	public function logout() {
		$this->session->unset_userdata('uid');
		$this->session->sess_destroy();
		redirect('home', 'refresh');
	}

	/**
	 * 회원가입 화면
	 */
	public function register() {
		$this->form_validation->set_rules('login_name', 'Login Name', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('mail', 'Mail', 'trim|required');

		$data = array();

		if ( $this->form_validation->run() == FALSE ) {
			$this->load->view('templates/header', $data);
			$this->load->view('login/register', $data);
			$this->load->view('templates/footer', $data);
		} else {
			$login_name = $this->input->post('login_name');
			$password = $this->input->post('password');
			$name = $this->input->post('name');
			$mail = $this->input->post('mail');
			$this->User_model->create($login_name, $password, $name, $mail);
			redirect('login', 'refresh');
		}
	}

	/**
	 * 아이디/비밀번호 찾기 페이지
	 * @TODO 구현이 까다로와 나중에 작성
	 */
	public function recovery() {
		$this->form_validation->set_rules('login_name', 'Login Name', 'trim|callback_recover_id');
		$this->form_validation->set_rules('mail', 'Mail', 'trim|required|callback_recover_password');

		$data = array();

		if ( $this->form_validation->run() == FALSE ) {
			$this->load->view('templates/header', $data);
			$this->load->view('login/register', $data);
			$this->load->view('templates/footer', $data);
		} else {
			$login_name = $this->input->post('login_name');
			$password = $this->input->post('password');
			$name = $this->input->post('name');
			$mail = $this->input->post('mail');
			$this->User_model->create($login_name, $password, $name, $mail);
			redirect('login', 'refresh');
		}
	}

	/**
	 * 아이디/비밀번호 찾기 페이지 > 아이디 찾기 기능
	 */
	function recover_id($login) {
		$mail = $this->input->post('');
		if ( !$mail ) {
			return FALSE;
		}
		try {
			$user = $this->User_model->get_user_by_mail($mail);
			if ( $user ) {
				$this->session->set_userdata('uid', $data->id);
				$this->session->set_userdata('login', $data->login_name);
				$groups = $this->Group_model->get_groups_by_uid($data->id);
				$group_ids = array();
				foreach( $groups as $group ) {
					array_push($group_ids, $group->id);
					if ( $group->can_admin ) {
						$this->session->set_userdata('admin', TRUE);
					}
					if ( $group->can_modify ) {
						$this->session->set_userdata('modify', TRUE);
					}
					if ( $group->can_create ) {
						$this->session->set_userdata('create', TRUE);
					}
					$this->logger->debug('User ' . $data->id . ' is in ' . $group->id . ' ' . $group->name);
				}

				$this->session->set_userdata('grp_ids', $group_ids);
				return TRUE;
			} else {
				$this->form_validation->set_message('recover_id', 'No such user by ' . $mail);
				return FALSE;
			}
		} catch (Exception $e) {
			$this->logger->log('error occured \'' . $e->getMessage() . '\'');
			$this->form_validation->set_message('authenticate', $e->getMessage());
			return FALSE;
		}
	}

	/**
	 * (디버그) 사용자 세션 확인 페이지
	 */
	public function info() {
		$this->logger->debug('uid ? ', $this->session->userdata('uid'));
		$data['uid'] = $this->session->userdata('uid');
		$data['login'] = $this->session->userdata('login');
		$data['grp_ids'] = print_r($this->session->userdata('grp_ids'), TRUE);
		$data['can_admin'] = $this->session->userdata('admin');
		$data['can_modify'] = $this->session->userdata('modify');
		$data['can_create'] = $this->session->userdata('create');
		$data['all_userdata'] = print_r($this->session->all_userdata(), TRUE);
		$this->load->view('templates/header', $data);
		$this->load->view('login/info', $data);
		$this->load->view('templates/footer', $data);
	}
}
