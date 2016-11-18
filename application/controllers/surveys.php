<?php

/**
 * 설문조사 컨트롤러
 */
class Surveys extends CI_Controller {

	/**
	 */
	public function index() {
		$this->load->view('surveys/index', NULL);
	}

	/*
	 * 설문조사 - 진행중인 설문 - 설문 보기
	 */
	public function view($survey_id = '0') {
		if ( $survey_id == '0' ) {
			show_404();
		}
		$this->load->view('surveys/view', NULL);
	}

	/**
	 * 설문조사 - 진행중인 설문 - 설문 작성
	 */
	public function application_form($survey_id = 0) {
		if ( $survey_id == 0 ) {
			show_404();
		}
		$this->load->view('surveys/application_form', NULL);
	}

	public function viewOld($page = 'home') {
		if (! file_exists(APPPATH.'/views/pages/'.$page.'.php')) {
			show_404();
		}

		$data['title'] = ucfirst($page);

		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}
}
