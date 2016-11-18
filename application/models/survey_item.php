<?php

/**
 * 설문조사 문항
 */
class SurveyItem extends CI_Model {


	/**
	 * 설문조사 ID
	 */
	var $survey_id = NULL;


	/**
	 * 문항 제목
	 */
	var $item_title = NULL;

	/**
	 * 문항 답변 형태
	 *
	 *  - 일항 선택
	 *  - 다항 선택
	 *  - 서술형
	 */
	var $item_class = NULL;

	function __construct() {
		parent::__construct();
	}
}
