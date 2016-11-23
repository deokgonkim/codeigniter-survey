<?php

/**
 * 이용안내
 * 
 * @author dgkim
 */
class Notice_model extends CI_Model {

	private $table_name = 'notices';

	private $upload_config = array(
		'upload_path' => './files/',
		'allowed_types' => 'gif|jpg|jpeg|png|doc|docx|xls|xlsx|ppt|pptx|pdf|txt',
		'max_size' => '102400', // in Kilo bytes
		'encrypt_name' => TRUE
	);

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	/**
	 * 전체 이용안내 목록을 반환한다.
	 */
	public function get_notices($count = 5) {
		$this->db->select('id, title, writer, create_datetime, modify_datetime, content');
		$this->db->from($this->table_name);
		//$this->db->where('login_name', $username);
		$this->db->limit($count);
		$this->db->order_by("create_datetime", "desc");
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * 이용안내 ID를 통해 설문조사를 반환한다.
	 */
	public function get_notice_by_id($notice_id) {
		$this->db->select('id, title, writer, create_datetime, modify_datetime, content, attach1_name, attach2_name, attach3_name, attach1_path, attach2_path, attach3_path');
		$this->db->from($this->table_name);
		$this->db->where('id', $notice_id);
		//$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}

	public function create_notice($title, $writer, $content, $attach1_name, $attach2_name, $attach3_name, $attach1_path, $attach2_path, $attach3_path) {
		$data = array(
			'title' => $title,
			'writer' => $writer,
			'content' => $content,
			'attach1_name' => $attach1_name,
			'attach2_name' => $attach2_name,
			'attach3_name' => $attach3_name,
			'attach1_path' => $attach1_path,
			'attach2_path' => $attach2_path,
			'attach3_path' => $attach3_path
		);
		$this->db->insert($this->table_name, $data);
	}

	public function update_notice($id, $title, $writer, $content, $attach1_name, $attach2_name, $attach3_name, $attach1_path, $attach2_path, $attach3_path) {
		$data = array(
			'title' => $title,
			'writer' => $writer,
			'content' => $content,
			'attach1_name' => $attach1_name,
			'attach2_name' => $attach2_name,
			'attach3_name' => $attach3_name,
			'attach1_path' => $attach1_path,
			'attach2_path' => $attach2_path,
			'attach3_path' => $attach3_path
		);
		$this->db->where('id', $id);
		$this->db->update($this->table_name, $data);
	}

	/**
	 * @return array( 'orig_name' => , 'file_name' => , 'file_rel_path' => )
	 */
	public function upload_file($element_name = 'file') {
		$this->load->library('upload');
		$this->upload->initialize($this->upload_config);
		$file_info = array();
		if (!$this->upload->do_upload($element_name)) {
			throw new Exception('error while saving file');
		} else {
			$data = $this->upload->data();
			$this->logger->debug(print_r($data, TRUE));
			$file_info['orig_name'] = $data['orig_name'];
			$file_info['file_name'] = $data['file_name'];
			$file_info['file_rel_path'] = str_replace(FCPATH, '', $data['full_path']);
			$this->logger->debug('file_info : ' . print_r($file_info, TRUE));
		}
		return $file_info;
	}
}
