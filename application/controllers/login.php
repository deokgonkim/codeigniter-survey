<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 로그인 관련 기능을 담당하는 컨트롤러
 *
 * @author dgkim
 */
class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('User_model');
		$this->load->model('Group_model');
	}

	public function index()
	{
		$this->form_validation->set_rules('login_name', 'Login Name', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_authenticate');

		if ( $this->form_validation->run() == FALSE ) {
			$this->load->view('templates/header');
			$this->load->view('login/login');
			$this->load->view('templates/footer');
		} else {
			redirect('welcome', 'refresh');
		}
	}

	function authenticate($password) {
		$login_name = $this->input->post('login_name');
		if ( !$login_name ) {
			return TRUE;
		}
		try {
			$data = $this->User_model->login($login_name, $password);
			if ( $data ) {
				$this->session->set_userdata('uid', $data->login_name);
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

	public function logout() {

		$this->session->unset_userdata('uid');
		redirect('welcome', 'refresh');
	}

	function info() {
		$this->logger->debug('uid ? ', $this->session->userdata('uid'));
		$data['uid'] = $this->session->userdata('uid');
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
