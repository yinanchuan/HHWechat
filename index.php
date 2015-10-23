<?php
require_once ('lib/core/common_run.inc.php');

$urls = array (
	'.ranking' => 'rankingAction',
	'.*' => 'indexAction'
);

class indexAction extends Common {
	function __construct($web) {
		$web->middleware ['session']->require_login = false;
	}
	function GET() {
		if((isset($_GET['debug']) && intval($_GET['debug']) == 1)|| isLocal() == true){}
		else{
			//wechat
			/*$openid = getWxOpenid();
			$user = GetUserByOpenid($openid);
			if(!isset($user) || !isset($user['iswechat']) || intval($user['iswechat']) != 1){
				$user = getWxSnsapiUserinfo();
			}*/
			
			//other
			$openid = getWxOpenidFromSession();
			$user = GetUserByOpenid($openid);
			if(!isset($user) || !isset($user['iswechat']) || intval($user['iswechat']) != 1){
				$user = getWxSnsapiUserinfo_2();
			}
		}
		
		//Preload images
		$images = FileHelper::getImagesUrl("images/");
		
		$p = array();
		$p['images'] = implode(",", $images);
		
		$onlyWechat = false;
		if (MobileHelper::isWeixin() == true || $onlyWechat == false) {
			$this->render_sub ( "views", $p );
		} else {
			die('Please open the link in the WeChat client.');
		}
	}
}

run ( $urls );
?>
