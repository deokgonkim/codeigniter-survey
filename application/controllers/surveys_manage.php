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
		$this->load->model('Survey_item_model');
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
	 * 설문조사 관리 > 설문조사 목록 > (설문조사 보기)
	 */
	public function view($survey_id) {
		$data = array();
		$data['survey'] = $this->Survey_model->get_survey($survey_id);
		$this->load->view('templates/main_header', $data);
		$this->load->view('surveys_manage/view', $data);
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

	/**
	 * 설문조사 관리 > 설문조사 작성 > (설문 문항 작성 화면) > (설문 문항 가져오기)
	 */
	public function get_items($survey_id = 0) {
		$items = $this->Survey_item_model->get_survey_item_with_answers($survey_id);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($items));
	}

	/**
	 * 설문조사 관리 > 설문조사 작성 > (설문 문항 작성 화면) > (문항 저장)
	 *
	 * 문항 저장시 호출된다. (ajax)
	 */
	public function save_item() {
		$this->logger->debug('survey_id : ' . $this->input->post('survey_id'));
		$this->logger->debug('item_id : ' . $this->input->post('item_id'));
		$this->logger->debug('title : ' . $this->input->post('title'));
		$this->logger->debug('class : ' . $this->input->post('class'));
		$this->logger->debug('val1 : ' . print_r($this->input->post('values'), TRUE));
		$survey = $this->Survey_model->get_survey($this->input->post('survey_id'));
		if ( ! $survey ) {
			$this->logger->debug('No survey found : ' . $this->input->post('survey_id'));
			throw new Exception('No survey found');
		}
		$survey_item = $this->Survey_item_model->get_survey_item($this->input->post('item_id'));
		if ( ! $survey_item ) {
			$data['survey_id'] = $this->input->post('survey_id');
			$data['id'] = $this->input->post('item_id');
			$data['title'] = $this->input->post('title');
			$data['class'] = $this->input->post('class');
			$this->Survey_item_model->create($data);
		} else {
			$data['survey_id'] = $this->input->post('survey_id');
			$data['id'] = $this->input->post('item_id');
			$data['title'] = $this->input->post('title');
			$data['class'] = $this->input->post('class');
			$this->Survey_item_model->modify($this->input->post('item_id'), $data);
		}
		$this->Survey_item_model->delete_answers($this->input->post('item_id'));
		$this->Survey_item_model->create_answers($this->input->post('item_id'), $this->input->post('values'));
	}

	/**
	 * (설문 수신 대상자 선택 화면)
	 */
	public function select_recipient() {
		$data = array();
		$data['preset'] = array(
			0 => '--선택--',
			1 => '신규',
			2 => '재학생'
		);
		$data['criteria'] = array(
			0 => '이름',
			1 => '그룹',
			3 => '속성1',
			4 => '속성2'
		);
		$this->load->view('templates/header', $data);
		$this->load->view('surveys_manage/select_recipient', $data);
		$this->load->view('templates/footer', $data);
	}

	/**
	 * (설문 대상자 조회)
	 */
	public function filter_recipients() {
		$type = $this->input->post('type');
	}

	/**
	 * 날짜 형식을 검증한다.
	 *
	 * yyyy/mm/dd 형식으로 입력되었는지 확인한다.
	 */
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
