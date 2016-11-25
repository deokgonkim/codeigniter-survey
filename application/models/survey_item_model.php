<?php

/**
 * 설문 문항
 * 
 * @author dgkim
 */
class Survey_item_model extends CI_Model {

	var $table_name = 'survey_item';

	function __construct() {
		parent::__construct();
		$this->load->helper('date');
	}

	public function get_survey_item_with_answers($survey_id) {
		$result = array();
		$this->db->select('id, survey_id, title, class');
		$this->db->from($this->table_name);
		$this->db->where('survey_id', $survey_id);
		$query = $this->db->get();
		$items = $query->result();
		$i = 0;
		foreach ( $items as $item ) {
			$i ++;
			$result[$i]['item_id'] = $item->id;
			$result[$i]['title'] = $item->title;
			$result[$i]['class'] = $item->class;
			$this->db->select('val_id, val_text');
			$this->db->from('survey_item_answer');
			$this->db->where('item_id', $item->id);
			$query = $this->db->get();
			foreach ( $query->result() as $ans ) {
				$result[$i]['answer'][$ans->val_id] = $ans->val_text;
			}
		}
		return $result;
	}

	/**
	 * 설문 문항 ID를 통해 설문조사를 반환한다.
	 */
	public function get_survey_item($item_id) {
		$this->db->select('id, survey_id, title, class');
		$this->db->from($this->table_name);
		$this->db->where('id', $item_id);
		$query = $this->db->get();
		return $query->row();
	}

	/**
	 * 설문 문항 ID를 통해 답변목록을 반환한다.
	 */
	public function get_survey_item_answers($item_id) {
		$this->db->select('id, item_id, val_id, val_text');
		$this->db->from('survey_item_answers');
		$this->db->where('item_id', $item_id);
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * 문항 작성
	 */
	public function create($data) {
		if ( ! $data ) {
			throw new Exception('No data provided');
		}
		$this->db->insert('survey_item', $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	/**
	 * 문항 수정
	 */
	public function modify($item_id, $data) {
		if ( ! $data ) {
			throw new Exception('No data provided');
		}
		$this->db->where('id', $item_id);
		$this->db->update('survey_item', $data);
	}


	public function create_answers($item_id, $data) {
		if ( ! $data ) {
			throw new Exception('No data provided');
		}
		$i = 0;
		foreach( $data as $item ) {
			$i ++;
			$ins_data['item_id'] = $item_id;
			$ins_data['val_id'] = $i;
			$ins_data['val_text'] = $item;
			$this->db->insert('survey_item_answer', $ins_data);
		}
	}

	public function delete_answers($item_id) {
		$this->db->delete('survey_item_answer', array('item_id' => $item_id)); 
	}
}
