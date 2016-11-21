<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 모든 컨트롤러가 상속하는 컨트롤러
 *
 * 1. database가 준비되지 않았으면, setup 페이지로 이동한다.
 * 2. database에서 시스템 정보를 로딩한다.
 * 3. 로그인 여부를 확인한다.
 * 4. 메인 메뉴를 준비한다.
 *
 * @author dgkim
 */
class Base_Controller extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('Setup_model');
		$this->load->model('User_model');
		$this->load->helper('url');
		if ( ! $this->_is_database_ready() ) {
			redirect('setup');
			return;
		}
		// 시스템 정보 가져오기 BEGIN
		$data['system_name'] = $this->Setup_model->get_system_name();
		$data['system_version'] = $this->Setup_model->get_version();
		// 시스템 정보 가져오기 END

		// 로그인 체크 BEGIN
		$uid = $this->session->userdata('uid');
		if ( $uid ) {
			$data['logged_in'] = TRUE;
			$data['name'] = $this->User_model->get_user_by_uid($uid)->name;
		} else {
			$data['logged_in'] = FALSE;
			$data['name'] = NULL;
		}
		// 로그인 체크 END

		// 메인메뉴 BEGIN
		$data['main_menus']['home'] = '시작하기';
		$data['main_menus']['survey'] = '설문조사';
		if ( $this->session->userdata('admin') || $this->session->userdata('create') || $this->session->userdata('modify') ) {
			$data['main_menus']['survey_manage'] = '설문조사 관리';
		}
		$data['main_menus']['preference'] = '환경설정';
		
		if ( $this->session->userdata('admin') || $this->session->userdata('create') || $this->session->userdata('modify') ) {
			$data['main_menus']['system_manage'] = '시스템 관리';
		}
		// 메인메뉴 END

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
 * 하위메뉴를 가지는 컨트롤러의 base 컨트롤러
 */
class Subpage_Controller extends Base_Controller {
	
	function __construct() {
		parent::__construct();

		$this->load->vars($data);
	}
}

/**
 * 로그인한 상태에서만 사용하는 컨트롤러
 */
class In_Session_Controller extends Base_Controller {

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
