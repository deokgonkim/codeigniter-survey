<?php

/**
 * 설문조사 컨트롤러
 * 
 * @author dgkim
 */
class Surveys extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Survey_model');
	}

	/**
	 */
	public function index() {
		$data['surveys'] = $this->Survey_model->get_surveys();
		$this->load->view('templates/header', $data);
		$this->load->view('surveys/index', $data);
		$this->load->view('templates/footer', $data);
	}

	/*
	 * 설문조사 - 진행중인 설문 - 설문 보기
	 */
	public function view($survey_id = '0') {
		if ( $survey_id == '0' ) {
			show_404();
		}
		$data['survey'] = $this->Survey_model->get_survey($survey_id);
		$this->load->view('templates/header', $data);
		$this->load->view('surveys/view', $data);
		$this->load->view('templates/footer', $data);
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
