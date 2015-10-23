<?php

/**
 * 日志记录
 */
function log_file($msg){
	error_log(date('Y-m-d H:i:s') . "\t" . $msg . "\r\n", 3, ABSPATH . 'log.log');
}

/**
 * 日志记录
 */
function log_access($type, $name = null, $data = null) {
	if(empty($type)){
		$type = DicConst::$TYPE_LOG_DEFAULT;
	}
	try {
		$_accesslog = new accesslog ();
		$accesslog = array (
			'type' => $type,
			'name' => $name,
			'data' => $data,
			'ip' => HttpHelper::getRealIp(),
			'useragent' => $_SERVER['HTTP_USER_AGENT']
		);
		$_accesslog->save ( $accesslog );
	} catch ( Exception $e ) {
		log_file($e->getMessage());
	}
}

/**
 * ajax操作成功
 */
function ajax_success($msg = null, $data = array()) {
	$result = array ();
	$result ['success'] = true;
	$result ['msg'] = empty ( $msg ) ? 'success' : $msg;
	$result ['data'] = $data;
	return $result;
}

/**
 * ajax操作失败
 */
function ajax_failure($msg = null) {
	if(empty($msg)){
		$msg = 'failure';
	}
	$result = array ();
	$result ['success'] = false;
	$result ['msg'] = $msg;
	return $result;
}

/**
 * ajax数据返回
 */
function ajax_return($result = array ()) {
	if (! isset ( $result ) || count ( $result ) == 0) {
		$result = ajax_failure ();
	}
	die(json_encode ( $result ));
}

/**
 * ajax返回分页数据
 */
function ajax_page($list = array(), $total = 0) {
	$result = array ();
	$result['rows'] = $list;
	$result['total'] = $total->total;
	return $result;
}

?>
