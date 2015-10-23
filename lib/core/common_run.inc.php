<?php
require_once (dirname ( dirname ( dirname ( __FILE__ ) ) ) . '/config.inc.php');
require_once ('const.inc.php');

require_once ('lib/core/model.php');
require_once ('lib/core/web.php');
require_once ('lib/core/dbx.php');

require_once ('lib/core/session.middleware.php');
require_once ('lib/core/jssdk.php');
require_once ('lib/core/fun_common.inc.php');
require_once ('lib/core/fun_wechat.inc.php');
require_once ('lib/core/fun_wechat2.inc.php');

require_once ('lib/helper/MobileHelper.php');
require_once ('lib/helper/ValidateHelper.php');
require_once ('lib/helper/StringHelper.php');
require_once ('lib/helper/HttpHelper.php');
require_once ('lib/helper/DateHelper.php');
require_once ('lib/helper/FileHelper.php');

require_once ('Common.php');

//error_reporting ( E_ALL & ~ E_NOTICE ); // 0 E_ALL
error_reporting(E_ALL);
date_default_timezone_set ( 'PRC' );

function __autoload($class) {
	$classpath = ABSPATH . 'lib/models/' . strtolower ( $class ) . '.model.php';
	if(file_exists($classpath)){
		//print_r($classpath);
		require_once($classpath);
	}
}

function run($urls) {
	$web = new web ();
	$web->middleware ['session'] = new SessionMiddleware ();
	// $web->middleware['i18n'] = new i18nMiddleware();
	// $web->middleware['loadtime'] = new LoadTimeMiddleware();
	// $web->middleware['request'] = new RequestMiddleware();
	$web->run ( $urls );
}

?>
