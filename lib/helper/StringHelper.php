<?php
class StringHelper {
	
	/**
	 * 只保留字符串首尾字符，隐藏中间用*代替（两个字符时只显示第一个）
	 * 
	 * @param string $user_name 姓名
	 * @return string 格式化后的姓名
	 */
	static function substr_cut($user_name) {
		$strlen = mb_strlen ( $user_name, 'utf-8' );
		
		if ($strlen > 1) {
			$firstStr = mb_substr ( $user_name, 0, 1, 'utf-8' );
			// $lastStr = mb_substr($user_name, -1, 1, 'utf-8');
			// return $strlen == 2 ? $firstStr . str_repeat('*', mb_strlen($user_name, 'utf-8') - 1) : $firstStr . str_repeat("*", $strlen - 2) . $lastStr;
			return $firstStr . str_repeat ( '*', $strlen - 1 );
		} else {
			return $user_name;
		}
	}
	
	/**
	 * 获取唯一ID
	 */
	static function getGUID() {
		if (function_exists ( 'com_create_guid' )) {
			return strtolower ( trim ( com_create_guid (), '{}' ) );
		} else {
			mt_srand ( ( double ) microtime () * 10000 ); // optional for php 4.2.0 and up.
			$charid = strtolower ( md5 ( uniqid ( rand (), true ) ) );
			$hyphen = chr ( 45 ); // "-"
			$uuid = substr ( $charid, 0, 8 ) . $hyphen . substr ( $charid, 8, 4 ) . $hyphen . substr ( $charid, 12, 4 ) . $hyphen . substr ( $charid, 16, 4 ) . $hyphen . substr ( $charid, 20, 12 );
			return $uuid;
		}
	}
}