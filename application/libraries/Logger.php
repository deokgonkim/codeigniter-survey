<?php

/**
 * 로깅 클래스
 * 
 * @author dgkim
 */
class Logger extends BaseLibrary {

	var $logLevel = 'error';
	var $debugLevel = 'error';
 
	public function __construct() {
		parent::__construct();
	}
 
	public function debug($msg = '') {
		$trace = debug_backtrace();

		$strMessage = '';
		$strMessage .= '/' . $this->CI->router->fetch_class();
		$strMessage .= '/' . $this->CI->router->fetch_method();
		$strMessage .= ' (' . $trace[1]['class'] . '::' . $trace[1]['function'] . ')';
		$strMessage .= ' : ';
 
		$strMessage .= $msg;

		log_message($this->debugLevel, $strMessage);
	}

	public function log($msg = '') {
		$trace = debug_backtrace();

		$strMessage = '';
		$strMessage .= '/' . $this->CI->router->fetch_class();
		$strMessage .= '/' . $this->CI->router->fetch_method();
		$strMessage .= ' : ';
 
		$strMessage .= $msg;

		log_message($this->logLevel, $strMessage);
	}
 
	/**
	 * Logs exception to log file as 'error'
	 * Requires $config['log_threshold'] to be >= 1 (application/config/config.php)
	 * @param Exception $oException
	 */
	public function logException(Exception $oException) {
		$strMessage = '';
		$strMessage .= $oException->getMessage() . ' ';
		$strMessage .= $oException->getCode() . ' ';
		$strMessage .= $oException->getFile() . ' ';
		$strMessage .= $oException->getLine();
		$strMessage .= "\n" .  $oException->getTraceAsString();
		
		log_message('error', $strMessage);
	}
}
