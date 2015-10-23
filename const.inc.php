<?php
/**
 * 字典常量
 */
final class DicConst {
	
	/**
	 * 日志类型
	 */
	public static $TYPE_LOG = array (
		10 => '默认类型',
		20 => '表单提交',
		30 => '后台登录'
	);
	/** 默认类型 */
	public static $TYPE_LOG_DEFAULT = 10;
	/** 表单提交 */
	public static $TYPE_LOG_PROFILE = 20;
	/** 后台登录 */
	public static $TYPE_LOG_LOGIN = 30;
	/** 微信授权获取用户信息 */
	public static $TYPE_LOG_WXUSERINFO = 40;
	/** 微信分享记录 */
	public static $TYPE_LOG_WXSHARE = 50;
	
	/**
	 * 用户类型
	 */
	public static $TYPE_USER_LEVELS = array (
		99 => 'admin',
		10 => '后台用户',
		20 => '微信用户'
	);
	/** admin */
	public static $TYPE_USER_LEVELS_ADMIN = 99;
	/** 后台用户 */
	public static $TYPE_USER_LEVELS_MANAGER = 10;
	/** 微信用户 */
	public static $TYPE_USER_LEVELS_WECHAT = 20;
}
?>
