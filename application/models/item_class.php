<?php

/**
 * 설문 문항 종류
 */
class Item_class extends CI_Model {

	/**
	 * 문항 종류 ID
	 */
	var $class_id = NULL;

	/**
	 * 문항 종류 이름
	 * 
	 *  - 양자택일형
	 *  - 다항선택형
	 *  - 서열형
	 *  - 평정형
	 *  - 개방형
	 */
	var $class_name = NULL;

	function __construct($type = NULL) {
		parent::__construct();
		if ( $type === NULL ) {
			throw new Exception('in construct');
		}
	}

	public function name() {
		return $this->class_name;
	}
}
