<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Group_model');
	}

	public function index2() {
//		$data = $this->Group_model->get_group_ids_by_uid(1);
		$data = $this->Group_model->get_groups_by_uid(1);
//		$data = $this->Group_model->get_groups();
		header('Content-Type: text/html; charset=UTF-8');
		echo "this is test controller" . print_r($data, TRUE);
	}

	public function index() {
		$data['name'] = 'test/index';
		$this->load->view('templates/main_header', $data);
		$this->load->view('templates/main_footer', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
