<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 설문조사 관리 컨트롤러
 * 
 * @author dgkim
 */
class Surveys_manage extends Subpage_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Survey_model');
	}

	/**
	 * 설문조사 관리 > 설문조사 목록
	 *
	 * 본인이 실시한 설문조사 목록이 보여진다.
	 *
	 */
	public function index() {
		$data = array();
		if ( $this->session->userdata('admin') || $this->session->userdata('modify') ) {
			$data['surveys'] = $this->Survey_model->get_surveys();
		} else {
			$data['surveys'] = $this->Survey_model->get_surveys_by_owner($this->session->userdata('uid'));
		}
		$this->load->view('templates/main_header', $data);
		$this->load->view('surveys_manage/index', $data);
		$this->load->view('templates/main_footer', $data);
	}

	/**
	 * 설문조사 관리 > 설문조사 작성
	 */
	public function create() {

		$data = array();

		$this->form_validation->set_rules('title', '설문제목', 'required');
		$this->form_validation->set_rules('surveyor_name', '조사기관', 'required');
		$this->form_validation->set_rules('surveyor_mail', '조사기관 메일주소', 'required');
		$this->form_validation->set_rules('surveyor_phone', '조사기관 연락처', 'required');
		$this->form_validation->set_rules('content', '설문내용', 'required');
		$this->form_validation->set_rules('notbefore', '설문기간 시작', 'required|callback_date_valid');
		$this->form_validation->set_rules('notafter', '설문기간 종료', 'required|callback_date_valid');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/main_header', $data);
			$this->load->view('surveys_manage/create_form', $data);
			$this->load->view('templates/main_footer', $data);
		} else {
			$data = array(
				'title' => $this->input->post('title'),
				'surveyor_name' => $this->input->post('surveyor_name'),
				'surveyor_mail' => $this->input->post('surveyor_mail'),
				'content' => $this->input->post('content'),
				'notbefore' => $this->input->post('notbefore'),
				'notafter' => $this->input->post('notafter')
			);
			$survey_id = $this->Survey_model->create($data);
			$this->logger->debug('survey created : ' . $survey_id);
			redirect('surveys_manage/add_items/' . $survey_id, 'refresh');
		}
	}

	/**
	 * 설문조사 관리 > 설문조사 작성 > (설문 문항 작성 화면)
	 */
	public function add_items($survey_id = 0) {
		$data = array();
		$data['survey'] = $this->Survey_model->get_survey($survey_id);
		$this->load->view('templates/main_header', $data);
		$this->load->view('surveys_manage/add_items', $data);
		$this->load->view('templates/main_footer', $data);
	}

	public function date_valid($date) {
		$parts = explode("/", $date);
		if (count($parts) == 3) {
			$this->logger->debug(print_r($parts, TRUE));
			if (checkdate($parts[1], $parts[2], $parts[0])) {
				return TRUE;
			}
		}
		$this->form_validation->set_message('date_valid', '날짜는 년/월/일 형태여야 합니다.');
		return FALSE;
	}
}
