<?php

class BaseLibrary {
	protected $CI;

	public function __construct() {
		$this->CI =& get_instance();
	}
}
