<?php

/**
 * 설문조사 관리 컨트롤러
 */
class Surveys_manage extends CI_Controller {

	/**
	 */
	public function index() {
		$this->load->view('surveys/index', NULL);
	}

	public function create() {
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['title'] = 'Create a survey item';

		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('text', 'text', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('surveys_manage/create_form');
			$this->load->view('templates/footer');
		} else {
			$this->news_model->set_news();
			$this->load->view('news/success');
		}
	}
}
