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
	}

	public function index()
	{
		$this->load->view('templates/header');
		$this->load->view('login/login');
		$this->load->view('templates/footer');
	}

	public function login_check() {

		$this->form_validation->set_rules('login_name', 'Login Name', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ( $this->form_validation->run() == FALSE ) {
			$this->load->view('templates/header');
			$this->load->view('login/login');
			$this->load->view('templates/footer');
		} else {
			$login_name = $this->input->post('login_name');
			$password = $this->input->post('password');

			$data = $this->User_model->login($login_name, $password);

			if ( $data ) {
				$this->session->set_userdata('login', $data->login_name);
			} else {
				$this->form_validation->set_message('check_database', 'Invalid Login Name or Password');
			}
			redirect('welcome', 'refresh');
		}

	}

	public function logout() {

		$this->session->unset_userdata('login');
		redirect('welcome', 'refresh');
	}

	function info() {
		$this->logger->debug('login ? ', $this->session->userdata('login'));
		$data['login'] = $this->session->userdata('login');
		$data['name'] = 'string name';
		$this->load->view('templates/header', $data);
		$this->load->view('login/info', $data);
		$this->load->view('templates/footer', $data);
	}
}
