<?php

/**
 * 완료된 설문조사 컨트롤러
 */
class SurveysExpired extends CI_Controller {

	/**
	 */
	public function index() {
		$this->load->view('surveys_expired/index', NULL);
	}

	/*
	 * 설문조사 - 완료된 설문 - 설문 보기
	 */
	public function view($survey_id = '0') {
		if ( $survey_id == '0' ) {
			show_404();
		}
		$this->load->view('surveys_expired/view', NULL);
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
