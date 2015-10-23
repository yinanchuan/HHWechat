<?php
require_once ('lib/core/common_run.inc.php');

$urls = array (
	'.*' => 'indexAction',
);

class indexAction extends Common {
	function __construct($web) {
		$web->middleware ['session']->require_login = false;
	}
	function POST() {
		$uid = intval($_SESSION[SESSION_UID]); //uid
		
		$type = isset($_POST ['type']) ? intval($_POST['type']) : 0;
		$url = isset($_POST ['url']) ? stripslashes($_POST['url']) : '';
		$memo = isset($_POST ['memo']) ? stripslashes($_POST['memo']) : '';
		$data = array (
			'uid' => $uid,
			'type' => $type,
			'url' => $url,
			'memo' => $memo
		);
		
		log_access(DicConst::$TYPE_LOG_WXSHARE, 'share', json_encode($data));
		ajax_return ( ajax_success () );
		exit;
		
		$_share = new share ();
		$_share->save ( $data );
		
		ajax_return ( ajax_success () );
	}
}

run ( $urls );
?>
