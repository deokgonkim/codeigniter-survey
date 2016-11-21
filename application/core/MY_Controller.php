<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 모든 컨트롤러가 상속하는 컨트롤러
 *
 * 1. database가 준비되지 않았으면, setup 페이지로 이동한다.
 * 2. database에서 시스템 정보를 로딩한다.
 *
 * @author dgkim
 */
class MY_Controller extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('Setup_model');
		$this->load->helper('url');
		if ( ! $this->_is_database_ready() ) {
			redirect('setup');
			return;
		}
		$data['system_name'] = $this->Setup_model->get_system_name();
		$data['system_version'] = $this->Setup_model->get_version();
		$this->load->vars($data);
	}

	public function _is_database_ready() {
		if ( ! $this->db->table_exists('setup') ) {
			return FALSE;
		}
		if ( ! $this->Setup_model->get_version() ) {
			return FALSE;
		}
		return TRUE;
	}
}

/**
 * 로그인한 상태에서만 사용하는 컨트롤러
 */
class In_Session_Controller extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		if ( !$this->is_logged_in() ) {
			$this->logger->debug('is not logged in');
			redirect('login', 'refresh');
		} else {
			$this->logger->debug('is logged in');
		}
	}

	public function is_logged_in() {
		return $this->session->userdata('uid');
	}
}
