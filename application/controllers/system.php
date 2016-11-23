<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 시스템 관리 페이지를 처리하는 컨트롤러
 *
 * @author dgkim
 */
class System extends Base_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Notice_model');
		$this->load->model('Survey_model');
		//$this->load->model('Survey_archive_model');
		
		// 1. 권한을 체크하여 admin 권한이 없으면, home으로 보낸다.
		if ( ! $this->session->userdata('admin') ) {
			redirect('home', 'refresh');
		}
	}

	public function index() {
		$data = array();

		$data['notices'] = $this->Notice_model->get_notices(5);
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

	/**
	 * 시스템관리 - 이용안내 관리
	 * 이용안내 목록 페이지
	 */
	public function notices() {
		$data = array();
		$data['notices'] = $this->Notice_model->get_notices(20);
		$this->load->view('templates/main_header', $data);
		$this->load->view('system/notices', $data);
		$this->load->view('templates/main_footer', $data);
	}

	/**
	 * 시스템관리 - 이용안내 관리 - 이용안내 보기
	 */
	public function notice_view($notice_id = 0) {
		if ( ! $notice_id ) {
			redirect('system/notices', 'refresh');
			return;
		}
		$data['notice'] = $this->Notice_model->get_notice_by_id($notice_id);
		if ( $data['notice'] ) {
			$this->load->view('templates/main_header', $data);
			$this->load->view('system/notice_view', $data);
			$this->load->view('templates/main_footer', $data);
		} else {
			redirect('system/notices', 'refresh');
		}
	}

	/**
	 * 시스템관리 - 이용안내 관리 - 이용안내 보기 - 이용안내 수정
	 * @TODO 파일타입이 잘 안 먹음, ppt, pptx, xls 같은 파일 업로드 안되고, png txt만 테스트 됨.
	 */
	public function notice_edit($notice_id = 0) {
		if ( ! $notice_id ) {
			redirect('system/notices', 'refresh');
			return;
		}

		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('writer', 'Writer', 'trim|required');
		$this->form_validation->set_rules('content', 'Content', 'required');

		if ( $this->form_validation->run() == FALSE ) {
			$this->logger->debug("validation failed");
		} else {
			// @TODO save 구현
			$attach1 = array(
				'orig_name' => NULL,
				'file_rel_path' => NULL
			);
			$attach2 = array(
				'orig_name' => NULL,
				'file_rel_path' => NULL
			);
			$attach3 = array(
				'orig_name' => NULL,
				'file_rel_path' => NULL
			);
			foreach ($_FILES as $fieldname => $fileObject) { //fieldname is the form field name
				if (!empty($fileObject['name'])) {
					if ( $fieldname == 'userfile1' ) {
						$this->logger->debug('file type : ' . $fileObject['type']);
						$this->logger->debug('userfile1 exists');
						$attach1 = $this->Notice_model->upload_file('userfile1');
					}
					if ( $fieldname == 'userfile2' ) {
						$this->logger->debug('userfile2 exists');
						$attach2 = $this->Notice_model->upload_file('userfile2');
					}
					if ( $fieldname == 'userfile3' ) {
						$this->logger->debug('userfile3 exists');
						$attach3 = $this->Notice_model->upload_file('userfile3');
					}
				}
			}

			$title = $this->input->post('title');
			$writer = $this->input->post('writer');
			$content = $this->input->post('content');

			$this->Notice_model->update_notice($notice_id, $title, $writer, $content, $attach1['orig_name'], $attach2['orig_name'], $attach3['orig_name'], $attach1['file_rel_path'], $attach2['file_rel_path'], $attach3['file_rel_path']);
			redirect('system/notice_view/' . $notice_id, 'refresh');
		}

		$data['notice'] = $this->Notice_model->get_notice_by_id($notice_id);
		if ( $data['notice'] ) {
			$this->load->view('templates/main_header', $data);
			$this->load->view('system/notice_edit', $data);
			$this->load->view('templates/main_footer', $data);
		} else {
			redirect('system/notices', 'refresh');
		}
	}

	/**
	 * 이용 안내 첨부 파일 다운로드
	 * @TODO 구현이 너무 복잡한데, 개선이 가능할까?
	 */
	public function notice_file($notice_id = 0, $file_name = 0) {
		if ( !$notice_id || !$file_name ) {
			redirect('system/notices', 'refresh');
			return;
		}
		$this->logger->debug('notice_file : ' . $notice_id . ' / ' . $file_name);
		$this->load->helper('download');

		$notice = $this->Notice_model->get_notice_by_id($notice_id);

		if ( $notice ) {
			$file_rel_path = NULL;
			$file_name = urldecode($file_name);
			$this->logger->debug('user_file_name : ' . $file_name);
			$this->logger->debug('db_file_name : ' . $notice->attach1_name);
			if ( $file_name == $notice->attach1_name ) {
				$this->logger->debug($file_name . ' is first attachment file');
				$file_rel_path = $notice->attach1_path;
			}
			if ( $file_name == $notice->attach2_name ) {
				$this->logger->debug($file_name . ' is second attachment file');
				$file_rel_path = $notice->attach2_path;
			}
			if ( $file_name == $notice->attach3_name ) {
				$this->logger->debug($file_name . ' is third attachment file');
				$file_rel_path = $notice->attach3_path;
			}
			if ( $file_rel_path ) {
				$data = file_get_contents(FCPATH  . $file_rel_path);
				if ( $data ) {
		                	force_download($file_name, $data);
				} else {
					$this->logger->debug('failed to read file : ' . $file_rel_path);
					redirect('/system/notices', 'refresh');
				}
			} else {
				$this->logger->debug('file_rel_path not found. notice_id : ' . $notice_id . ' file_name : ' . $file_name);
				redirect('/system/notices', 'refresh');
			}
		} else {
			redirect('system/notices', 'refresh');
		}
	}
}
