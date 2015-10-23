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
		$code = isset ( $_GET ['wxcode'] ) ? $_GET ['wxcode'] : null;
		$state = isset ( $_GET ['state'] ) ? $_GET ['state'] : null;
		return getWxOpenid_2 ( $code, $state );
	}
}

run ( $urls );
?>
