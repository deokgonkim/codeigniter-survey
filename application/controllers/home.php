<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 시작하기 페이지를 처리하는 컨트롤러
 *
 * @author dgkim
 */
class Home extends Base_Controller {

	function __construct() {
		parent::__construct();
		//$this->load->model('Notice_model');
		$this->load->model('Survey_model');
		//$this->load->model('Survey_archive_model');
	}

	public function index() {
		$data = array();

		//$data['notices'] = $this->Notice_model->get_notice_list();
		$data['notices'] = array();
		$data['surveys_archived'] = array();
		$uid = $this->session->userdata('uid');
		if ( $uid ) {
			$data['surveys_received'] = $this->Survey_model->get_surveys_received($uid, TRUE);
		} else {
			$data['surveys_received'] = $this->Survey_model->get_surveys_received(0, TRUE);
		}
		$this->logger->debug('surveys_received : ' . print_r($data['surveys_received'], TRUE));
		$this->load->view('templates/home_header', $data);
		$this->load->view('home', $data);
		$this->load->view('templates/home_footer', $data);
	}
}
