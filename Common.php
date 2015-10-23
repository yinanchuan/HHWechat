<?php
class Common {
	
	function __construct($web) {
		
	}
	
	function render($file_name, $params = array ()) {
		if(MobileHelper::isWeixin()){
			getWxJssdk ( $params );
		}
		extract ( $params );
		$file_name .= '.html';
		$__title = FileHelper::getViewsTitle(ABSPATH . 'views/' . $file_name);
		
		include 'views/header.html';
		include 'views/' . $file_name;
		include 'views/footer.html';
	}
	
	function render_sub($file_name, $params = array ()) {
		if(MobileHelper::isWeixin()){
			getWxJssdk ( $params );
		}
		extract ( $params );
		$file_name .= '.html';
		include 'views/' . $file_name;
	}
	
	function render_mobile($view = "homepage", $param = array()) {
		if (! MobileHelper::isIpad () && MobileHelper::isMobile ()) {
			$this->render_sub ( $view, $param );
		} else {
			$this->render_sub ( "landing_pc", $param );
		}
	}
	
	function render_admin($file_name, $params = array ()) {
		extract ( $params );
		$file_name .= '.html';
		$__title = FileHelper::getViewsTitle(ABSPATH . 'views/admin/' . $file_name);
		
		include 'views/admin/header.html';
		include 'views/admin/' . $file_name;
		include 'views/admin/footer.html';
	}
	
	function getMyguid() {
		$guid = '';
		if(isset($_COOKIE[SESSION_MYGUID]) && !empty($_COOKIE[SESSION_MYGUID])){
			$guid = $_COOKIE[SESSION_MYGUID];
		}
		else{
			$guid = StringHelper::getGUID();
			setcookie(SESSION_MYGUID, $guid, time() + (3600 * 24 * 60)); //24h * 60
		}
		return $guid;
	}
	
	/**
	 * 分页数据处理
	 */
	function listPages(){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$page = $page < 1 ? 1 : $page;
		$limitstart = ($page - 1) * 20; //pageSize
	
		$pages = array();
		$pages['page'] = $page;
		$pages['limitstart'] = $limitstart;
	
		return $pages;
	}
	
	
	/**
	 * 判断是否登录
	 */
	function isLogin() {
		if (!isset($_SESSION[SESSION_USER]) || !isset($_SESSION[SESSION_UID])) {
			$result = array ();
			$result["success"] = false;
			$result["msg"] = 'Please login.';
			return $result;
		}
		return true;
	}
	
	/**
	 * 登录信息记录
	 */
	function session_user($user) {
		global $_SESSION;
	
		$_SESSION [SESSION_UID] = $user['id'];
		$_SESSION [SESSION_USERNAME] = $user['username'];
		$_SESSION [SESSION_LEVELS] = $user['levels'];
	
		$_SESSION [SESSION_LOGGED] = true;
		$_SESSION [SESSION_USER] = $user;
	}
}
