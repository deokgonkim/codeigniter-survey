<?php

/**
 * session 생성 여부를 체크하는 클래스
 * @author dgkim
 */
class SessionCheck {

	var $CI;

	var $logger;

	public function __construct() {
		$this->CI =& get_instance();
		$this->logger =& $this->CI->logger;
		$this->CI->load->helper('url');
	}

	public function check_session($arg) {
		if ( $this->CI->router->fetch_class() == 'welcome' ) {
			$this->logger->log('requesting welcome page');
			$this->check_and_redirect();
		}
	}

	public function check_and_redirect($login_page = 'login') {
		$login = $this->CI->session->userdata('login');
		if ( !$login ) {
			redirect($login_page);
		}
	}
}
