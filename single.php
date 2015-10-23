<?php
require_once ('lib/core/common_run.inc.php');

$urls = array (
	'.gameover' => 'gameoverAction',
	'.*' => 'indexAction'
);

class indexAction extends Common {
	function __construct($web) {
		$web->middleware ['session']->require_login = false;
	}
	function GET() {
		if(MobileHelper::isWeixin()){
			HttpHelper::location('index.php');
		}
		$this->render_sub ("pc");
	}
}

class gameoverAction extends Common {
	function __construct($web) {
		$web->middleware ['session']->require_login = false;
	}
	function GET() {
		if (time() < strtotime(DEADLINE)) {
			location('index.php');
		}
		$this->render ( "over_campaign");
	}
}

run ( $urls );
?>
