<?php
require_once ('lib/core/common_run.inc.php');

$urls = array (
	'.*' => 'indexAction' 
);

class indexAction extends Common {
	function __construct($web) {
		$web->middleware ['session']->require_login = false;
	}
	function GET() {
		$code = isset ( $_GET ['code'] ) ? $_GET ['code'] : null;
		$state = isset ( $_GET ['state'] ) ? $_GET ['state'] : null;
		getWxSnsapiUserinfo ( $code, $state );
	}
}

run ( $urls );
?>
