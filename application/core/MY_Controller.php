<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 로그인한 상태에서만 사용하는 컨트롤러
 */
class In_Session_Controller extends CI_Controller {

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
		return $this->session->userdata('login');
	}
}
