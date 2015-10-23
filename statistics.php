<?php
require_once ('lib/common_run.inc.php');

$urls = array (
	'.*' => 'indexAction' 
);

class indexAction extends Common {
	function __construct($web) {
		$web->middleware ['session']->require_login = false;
	}
	function GET() {
		if(!isset($_GET['token']) || intval($_GET['token']) !== 1990){
			die('Authorization error');
		}
		
		$_share = new share();
		$list = $_share->findStatisticsList2();
		
		foreach($list as $key => $value){
			if(isset($value['type'])){
				$value['type_name'] = DicConst::$TYPE_SHARE[intval($value['type'])];
			}
			$list[$key] = $value;
		}
		
		$p = array();
		$p['list'] = $list;
		
		render_admin ( 'statistics', $p );
	}
}

run ( $urls );
?>
