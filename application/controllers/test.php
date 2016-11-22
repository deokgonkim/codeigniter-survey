<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends Base_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Setup_model');
		$this->load->model('User_model');
		$this->load->model('Group_model');
		$this->load->model('Survey_model');
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

	public function index() {
		$data['name'] = 'test/index';
		$this->load->view('templates/main_header', $data);
		$this->load->view('templates/main_footer', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
