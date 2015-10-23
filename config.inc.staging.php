<?php
define ( 'ABSPATH', dirname ( __FILE__ ) . '/' );
define ( 'APP_URL', 'http://www.HHWechat.com/staging/' );
define ( 'WEB_TITLE', '(Test)HHWechat' );
define ( 'VERSION', time () );

define ( 'API_URL', '' );
define ( 'API_KEY', '' );
define ( 'API_SECRET', '' );

/* Wechat */
define ( 'WX_APP_ID', 'WX_APP_ID' );
define ( 'WX_APP_SECRET', 'WX_APP_SECRET' );
define ( 'WX_REDIRECT_URI', APP_URL . 'authorize.php' );
define ( 'WX_REDIRECT_URI2', APP_URL . 'oauth.php' );
define ( 'WX_SHARE_TITLE', '#HHWechat#' );
define ( 'WX_SHARE_DESC', '#HHWechat#' );
define ( 'WX_SHARE_URL', APP_URL . 'index.php' );
define ( 'WX_SHARE_IMG', APP_URL . 'images/share.jpg' );

define ( 'SESSION_LOGGED', 'logged' );
define ( 'SESSION_UID', 'uid' );
define ( 'SESSION_USERNAME', 'username' );
define ( 'SESSION_LEVELS', 'levels' );
define ( 'SESSION_OPENID', 'openid' );
define ( 'SESSION_USER', 'user' );

define ( 'SESSION_COOKIE', 'cookie' );
define ( 'SESSION_LOCALE', 'locale' );
define ( 'SESSION_REMEMBER', 'remember' );
define ( 'SESSION_MYGUID', 'myguid-' );

/* MySQL Connection */
define ( 'DB_NAME', 'DB_NAME' );
define ( 'DB_USER', 'DB_USER' );
define ( 'DB_PASSWORD', 'DB_PASSWORD' );
define ( 'DB_HOST', 'DB_HOST' );
define ( 'DB_TABLEPRE', 'hhwechat_' );
define ( 'BAIDU_HMT', '');

?>