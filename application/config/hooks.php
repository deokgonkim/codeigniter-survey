<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

// dgkim 2016/11/18
// pre_controller훅에서는 CI->session이 안 보임.
// post_controller_constructor 방식을 사용할 수도 있다.
// 대신, MY_Controller.php의 In_Session_Controller 클래스를 상속하는 형태로 바꾸었다.
////$hook['pre_controller'] = array(
//$hook['post_controller_constructor'] = array(
//	'class'    => 'SessionCheck',
//	'function' => 'check_session',
//	'filename' => 'SessionCheck.php',
//	'filepath' => 'hooks',
//	'params'   => array('beer', 'wine', 'snacks')
//);

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */
