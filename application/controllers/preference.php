<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 환경설정 페이지를 처리하는 컨트롤러
 *
 * @author dgkim
 */
class Preference extends Subpage_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Setup_model');
		$this->load->model('Notice_model');
		//$this->load->model('Survey_archive_model');
	}

	public function index() {
		$data = array();

		$this->load->view('templates/main_header', $data);
		$this->load->view('preference/preference', $data);
		$this->load->view('templates/main_footer', $data);
	}

	/**
	 * 환경설정 - 이용안내
	 * 이용안내 목록 페이지
	 */
	public function notices() {
		$data = array();
		$data['notices'] = $this->Notice_model->get_notices(20);
		$this->load->view('templates/main_header', $data);
		$this->load->view('preference/notices', $data);
		$this->load->view('templates/main_footer', $data);
	}

	/**
	 * 환경설정 - 이용안내 - 이용안내 보기
	 */
	public function notice_view($notice_id = 0) {
		if ( ! $notice_id ) {
			redirect('preference/notices', 'refresh');
			return;
		}
		$data['notice'] = $this->Notice_model->get_notice_by_id($notice_id);
		if ( $data['notice'] ) {
			$this->load->view('templates/main_header', $data);
			$this->load->view('preference/notice_view', $data);
			$this->load->view('templates/main_footer', $data);
		} else {
			redirect('preference/notices', 'refresh');
		}
	}

	/**
	 * 이용 안내 첨부 파일 다운로드
	 * @TODO 구현이 너무 복잡한데, 개선이 가능할까?
	 */
	public function notice_file($notice_id = 0, $file_name = 0) {
		if ( !$notice_id || !$file_name ) {
			redirect('preference/notices', 'refresh');
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
					redirect('/preference/notices', 'refresh');
				}
			} else {
				$this->logger->debug('file_rel_path not found. notice_id : ' . $notice_id . ' file_name : ' . $file_name);
				redirect('/preference/notices', 'refresh');
			}
		} else {
			redirect('preference/notices', 'refresh');
		}
	}
}
