<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Database 초기화, 초기 데이터 적재 역할을 담당하는 컨트롤러
 *
 * @author dgkim
 */
class Setup extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->load->dbforge();

		$this->load->model('setup/Setup_table');
		$this->load->model('setup/Realm_table');
		$this->load->model('setup/User_table');
		$this->load->model('setup/Group_table');
		$this->load->model('setup/Group_member_table');
		$this->load->model('setup/Surveys_table');
		$this->load->model('setup/Survey_item_table');
		$this->load->model('setup/Survey_item_answer_table');
		$this->load->model('setup/Survey_inbox_table');
		$this->load->model('setup/Survey_outbox_table');
		$this->load->model('setup/Notices_table');
	}

	public function index()
	{
		$data['title'] = 'SETUP';
		if ( $this->db->table_exists('setup') ) {
			$this->db->select('version, system_name');
			$this->db->from('setup');
			$query = $this->db->get();
			$data['version'] = $query->row()->version;
			$data['system_name'] = $query->row()->system_name;
		} else {
			$data['version'] = 'no setup table';
			$data['system_name'] = 'no setup table';
		}
		$this->load->view('templates/setup_header', $data);
		$this->load->view('setup/index', $data);
		$this->load->view('templates/setup_footer', $data);
	}

	public function install() {
		$data['title'] = 'SETUP&gt;INSTALL';

		$i = 0;
		$table_name = 'setup';
		$data['tables'][$i]['name'] = $table_name;
		if ( !$this->db->table_exists($table_name) ) {
			$this->Setup_table->create_table();
			$this->Setup_table->fulfill_table();
			$data['tables'][$i]['status'] = 'OK';
		} else {
			$data['tables'][$i]['status'] = 'Already exists';
		}
		$i ++;

		$table_name = 'realm';
		$data['tables'][$i]['name'] = $table_name;
		if ( !$this->db->table_exists($table_name) ) {
			$this->Realm_table->create_table();
			$this->Realm_table->fulfill_table();
			$data['tables'][$i]['status'] = 'OK';
		} else {
			$data['tables'][$i]['status'] = 'Already exists';
		}
		$i ++;

		$table_name = 'user';
		$data['tables'][$i]['name'] = $table_name;
		if ( !$this->db->table_exists($table_name) ) {
			$this->User_table->create_table();
			$this->User_table->fulfill_table();
			$data['tables'][$i]['status'] = 'OK';
		} else {
			$data['tables'][$i]['status'] = 'Already exists';
		}
		$i ++;

		$table_name = 'group';
		$data['tables'][$i]['name'] = $table_name;
		if ( !$this->db->table_exists($table_name) ) {
			$this->Group_table->create_table();
			$this->Group_table->fulfill_table();
			$data['tables'][$i]['status'] = 'OK';
		} else {
			$data['tables'][$i]['status'] = 'Already exists';
		}
		$i ++;

		$table_name = 'group_member';
		$data['tables'][$i]['name'] = $table_name;
		if ( !$this->db->table_exists($table_name) ) {
			$this->Group_member_table->create_table();
			$this->Group_member_table->fulfill_table();
			$data['tables'][$i]['status'] = 'OK';
		} else {
			$data['tables'][$i]['status'] = 'Already exists';
		}
		$i ++;

		$table_name = 'surveys';
		$data['tables'][$i]['name'] = $table_name;
		if ( !$this->db->table_exists($table_name) ) {
			$this->Surveys_table->create_table();
			$this->Surveys_table->fulfill_table();
			$data['tables'][$i]['status'] = 'OK';
		} else {
			$data['tables'][$i]['status'] = 'Already exists';
		}
		$i ++;

		$table_name = 'survey_item';
		$data['tables'][$i]['name'] = $table_name;
		if ( !$this->db->table_exists($table_name) ) {
			$this->Survey_item_table->create_table();
			$this->Survey_item_table->fulfill_table();
			$data['tables'][$i]['status'] = 'OK';
		} else {
			$data['tables'][$i]['status'] = 'Already exists';
		}
		$i ++;

		$table_name = 'survey_item_answer';
		$data['tables'][$i]['name'] = $table_name;
		if ( !$this->db->table_exists($table_name) ) {
			$this->Survey_item_answer_table->create_table();
			$this->Survey_item_answer_table->fulfill_table();
			$data['tables'][$i]['status'] = 'OK';
		} else {
			$data['tables'][$i]['status'] = 'Already exists';
		}
		$i ++;

		$table_name = 'survey_inbox';
		$data['tables'][$i]['name'] = $table_name;
		if ( !$this->db->table_exists($table_name) ) {
			$this->Survey_inbox_table->create_table();
			$this->Survey_inbox_table->fulfill_table();
			$data['tables'][$i]['status'] = 'OK';
		} else {
			$data['tables'][$i]['status'] = 'Already exists';
		}
		$i ++;

		$table_name = 'survey_outbox';
		$data['tables'][$i]['name'] = $table_name;
		if ( !$this->db->table_exists($table_name) ) {
			$this->Survey_outbox_table->create_table();
			$this->Survey_outbox_table->fulfill_table();
			$data['tables'][$i]['status'] = 'OK';
		} else {
			$data['tables'][$i]['status'] = 'Already exists';
		}
		$i ++;

		$table_name = 'notices';
		$data['tables'][$i]['name'] = $table_name;
		if ( !$this->db->table_exists($table_name) ) {
			$this->Notices_table->create_table();
			$this->Notices_table->fulfill_table();
			$data['tables'][$i]['status'] = 'OK';
		} else {
			$data['tables'][$i]['status'] = 'Already exists';
		}
		$i ++;

//		$data['tables'][$i]['name'] = 'user';
//		$this->User_table->create_user_table();
//		$this->User_table->fulfill_user_table();
//		$data['tables'][$i]['status'] = 'OK';
//		$i ++;


		$this->load->view('templates/setup_header', $data);
		$this->load->view('setup/install', $data);
		$this->load->view('templates/setup_footer', $data);
	}

	public function uninstall() {
		$data['title'] = 'SETUP&gt;UNINSTALL';

		$i = 0;
		$data['tables'][$i]['name'] = 'setup';
		$this->Setup_table->drop_table();
		$data['tables'][$i]['status'] = 'OK';
		$i ++;

		$data['tables'][$i]['name'] = 'realm';
		$this->Realm_table->drop_table();
		$data['tables'][$i]['status'] = 'OK';
		$i ++;

		$data['tables'][$i]['name'] = 'user';
		$this->User_table->drop_table();
		$data['tables'][$i]['status'] = 'OK';
		$i ++;

		$data['tables'][$i]['name'] = 'group';
		$this->Group_table->drop_table();
		$data['tables'][$i]['status'] = 'OK';
		$i ++;

		$data['tables'][$i]['name'] = 'group_member';
		$this->Group_member_table->drop_table();
		$data['tables'][$i]['status'] = 'OK';
		$i ++;

		$data['tables'][$i]['name'] = 'surveys';
		$this->Surveys_table->drop_table();
		$data['tables'][$i]['status'] = 'OK';
		$i ++;

		$data['tables'][$i]['name'] = 'survey_item';
		$this->Survey_item_table->drop_table();
		$data['tables'][$i]['status'] = 'OK';
		$i ++;

		$data['tables'][$i]['name'] = 'survey_item_answer';
		$this->Survey_item_answer_table->drop_table();
		$data['tables'][$i]['status'] = 'OK';
		$i ++;

		$data['tables'][$i]['name'] = 'survey_inbox';
		$this->Survey_inbox_table->drop_table();
		$data['tables'][$i]['status'] = 'OK';
		$i ++;

		$data['tables'][$i]['name'] = 'survey_outbox';
		$this->Survey_outbox_table->drop_table();
		$data['tables'][$i]['status'] = 'OK';
		$i ++;

		$data['tables'][$i]['name'] = 'notices';
		$this->Notices_table->drop_table();
		$data['tables'][$i]['status'] = 'OK';
		$i ++;

//		$data['tables'][$i]['name'] = 'user';
//		$this->User_table->create_user_table();
//		$this->User_table->fulfill_user_table();
//		$data['tables'][$i]['status'] = 'OK';
//		$i ++;


		$this->load->view('templates/setup_header', $data);
		$this->load->view('setup/install', $data);
		$this->load->view('templates/setup_footer', $data);
	}

	public function preventDirectExecution() {
	        // can only be called from the command line
		if (!$this->input->is_cli_request()) {
			exit('Direct access is not allowed');
		}
		
		// can only be run in the development environment
		if (ENVIRONMENT !== 'development') {
			exit('Wowsers! You don\'t want to do that!');
		}
	}
}
