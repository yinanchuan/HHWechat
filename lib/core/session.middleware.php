<?php
class SessionMiddleware {
	public $require_login;
	function __construct() {
		$sessionPath = ABSPATH . 'tmp/';
		if (! file_exists ( $sessionPath )) {
			mkdir ( $sessionPath, 0777, true );
		}
		session_save_path ( $sessionPath );
		session_start ();
		if (! isset ( $_SESSION [SESSION_UID] )) {
			$this->session_defaults ();
		}
		$this->require_login = true;
	}
	function session_defaults() {
		$_SESSION [SESSION_LOGGED] = false;
		$_SESSION [SESSION_UID] = 0;
		$_SESSION [SESSION_USERNAME] = '';
		$_SESSION [SESSION_COOKIE] = 0;
		$_SESSION [SESSION_REMEMBER] = false;
		$_SESSION [SESSION_LOCALE] = "cn_CN";
		$_SESSION [SESSION_LEVELS] = 0;
	}
	function run_before() {
		$uri = $_SERVER ["REQUEST_URI"]; // $_SERVER['PHP_SELF'];
		$uri_arr = explode ( '/', $uri );
		$filename = end ( $uri_arr );
		$_SESSION ["action"] = $filename;
		if ($this->require_login && (! isset ( $_SESSION [SESSION_LOGGED] ) || $_SESSION [SESSION_LOGGED] != true)) {
			header ( 'Location: ' . APP_URL . 'admin.php' );
			die ();
		}
	}
	function run_after() {
	}
}
?>