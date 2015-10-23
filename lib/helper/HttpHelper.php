<?php
class HttpHelper {
	
	/**
	 * 数组转为url参数
	 */
	static function generatePostData($fields)
	{
		$postData = '';
		foreach($fields as $key=>$value) {
			$postData .= $key . '=' . $value . '&';
		}
		rtrim($postData, '&');
		return $postData;
	}
	
	/**
	 * header跳转
	 */
	static function location($url) {
		header ( 'Location: ' . APP_URL . $url );
		exit ();
	}
	
	/**
	 * 获取IP地址
	 * 注意服务器配置了cdn将无法正常获取,需要联系cdn供应商
	 */
	static function getRealIp() {
		$ip = 'UNKNOWN';
		if (isset ( $HTTP_SERVER_VARS ['HTTP_X_FORWARDED_FOR'] )) {
			$ip = $HTTP_SERVER_VARS ['HTTP_X_FORWARDED_FOR'];
		} elseif (isset ( $HTTP_SERVER_VARS ['HTTP_CLIENT_IP'] )) {
			$ip = $HTTP_SERVER_VARS ['HTTP_CLIENT_IP'];
		} elseif (isset ( $HTTP_SERVER_VARS ['REMOTE_ADDR'] )) {
			$ip = $HTTP_SERVER_VARS ['REMOTE_ADDR'];
		} elseif (getenv ( 'HTTP_X_FORWARDED_FOR' )) {
			$ip = getenv ( 'HTTP_X_FORWARDED_FOR' );
		} elseif (getenv ( 'HTTP_CLIENT_IP' )) {
			$ip = getenv ( 'HTTP_CLIENT_IP' );
		} elseif (getenv ( 'REMOTE_ADDR' )) {
			$ip = getenv ( 'REMOTE_ADDR' );
		} else {
		}
		return $ip;
	}
}