<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends Base_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Setup_model');
		$this->load->model('User_model');
		$this->load->model('Group_model');
		$this->load->model('Survey_model');
		$this->load->model('Notice_model');
	}

	public function index2() {
//		$data = $this->Group_model->get_group_ids_by_uid(1);
		$data = $this->Group_model->get_groups_by_uid(1);
//		$data = $this->Group_model->get_groups();
		header('Content-Type: text/html; charset=UTF-8');
		echo "this is test controller" . print_r($data, TRUE);
	}

	public function survey() {
		$data = $this->Survey_model->get_surveys_received(1, TRUE);
		header('Content-Type: text/html; charset=UTF-8');
		echo "this is test controller" . print_r($data, TRUE);
	}

	public function user_by_uid() {
		header('Content-Type: text/html; charset=UTF-8');
		echo print_r($this->User_model->get_user_by_uid(1), TRUE);
	}

	public function allow_register() {
		header('Content-Type: text/html; charset=UTF-8');
		echo 'allow_register?' . ($this->Setup_model->get_allow_register() ? 'allow' : 'deny');
	}

	public function notices() {
		header('Content-Type: text/html; charset=UTF-8');
		echo 'notice list?<br />' . print_r($this->Notice_model->get_notices(4), TRUE);
	}

	public function notice_view() {
		header('Content-Type: text/html; charset=UTF-8');
		echo 'notice view?<br />' . print_r($this->Notice_model->get_notice_by_id(1), TRUE);
	}

	/**
	 * 파일 업로드 테스트용 폼화면
	 */
	public function upload_form() {
		$this->load->helper('form');
		$data = array(
			'error' => ''
		);
		$this->load->view('templates/header', $data);
		$this->load->view('test/upload_form', $data);
		$this->load->view('templates/footer', $data);
	}

	/**
	 * 파일 업로드 테스트용 액션
	 *
	 * $config['upload_path'] = './files/'; // path is relative path to index.php
	 * upload->data() result
	 * (
	 *     [file_name] => 62acffe89b4bb78b51eafec3a4f84181.png
	 *     [file_type] => image/png
	 *     [file_path] => /var/www/html/survey/files/
	 *     [full_path] => /var/www/html/survey/files/62acffe89b4bb78b51eafec3a4f84181.png
	 *     [raw_name] => 62acffe89b4bb78b51eafec3a4f84181
	 *     [orig_name] => 2.png
	 *     [client_name] => /2.png
	 *     [file_ext] => .png
	 *     [file_size] => 503.89
	 *     [is_image] => 1
	 *     [image_width] => 800
	 *     [image_height] => 1280
	 *     [image_type] => png
	 *     [image_size_str] => width="800" height="1280"
	 * )
	 *
	 */
	public function upload() {
		$status = "";
		$msg = "";
		$file_element_name = 'userfile';
			     
		if (empty($_POST['title'])) {
			$status = "error";
			$msg = "Please enter a title";
		}
			         
		if ($status != "error") {
			$config['upload_path'] = './files/';
			$config['allowed_types'] = 'gif|jpg|png|doc|txt';
			$config['max_size'] = 1024 * 8;
			$config['encrypt_name'] = TRUE;
			
			$this->load->library('upload', $config);
			
			if (!$this->upload->do_upload($file_element_name)) {
				$status = 'error';
				$msg = $this->upload->display_errors('', '');
			} else {
				$data = $this->upload->data();
				$this->logger->debug(print_r($data, TRUE));
				$file_id = $this->files_model->insert_file($data['file_name'], $_POST['title']);
				if($file_id) {
					$status = "success";
					$msg = "File successfully uploaded";
				} else {
					unlink($data['full_path']);
					$status = "error";
					$msg = "Something went wrong when saving the file, please try again.";
				}
			}
			@unlink($_FILES[$file_element_name]);
		}
		echo json_encode(array('status' => $status, 'msg' => $msg));
	}

	public function filedownload($filename = '') {
		$this->load->helper('download');

		if ( empty($filename) ) {
			$filename = '62acffe89b4bb78b51eafec3a4f84181.png';
		}

		$data = file_get_contents(FCPATH  . 'files/' . $filename);

		force_download('2.png', $data);
	}

	public function fcpath() {
		echo FCPATH;
	}

	public function index() {
		$data['name'] = 'test/index';
		$this->load->view('templates/main_header', $data);
		$this->load->view('templates/main_footer', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
