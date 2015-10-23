<?php
define ( 'ABSPATH', dirname ( __FILE__ ) . '/' );
define ( 'APP_URL', 'http://hhwechat.localhost:8080/' );
define ( 'WEB_TITLE', '(Local)HHWechat' );
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
define ( 'DB_NAME', 'hhwechat' );
define ( 'DB_USER', 'root' );
define ( 'DB_PASSWORD', '123' );
define ( 'DB_HOST', 'localhost' );
define ( 'DB_TABLEPRE', 'hhwechat_' );
define ( 'BAIDU_HMT', '');

?>