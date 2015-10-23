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
		die();
		log_access(DicConst::$TYPE_LOG_PROFILE, 'profile', json_encode($_POST)); //log
		
		$guid = stripslashes($_POST ['guid']);
		$name = stripslashes($_POST ['name']);
		$phone = stripslashes($_POST ['phone']);
		$num1 = intval($_POST['duration']);
		
		$sguid = $this->getMyguid();
		if($sguid != $guid){
			ajax_return ( ajax_failure('GUID validation failure.') );
		}
		
		//user
		$user = getUserByGuid($guid);
		$uid = isset($user) ? intval($user['id']) : 0;
		
		$_profile = new profile ();
		
		//Validation phone number has been used
		$profile = $_profile->findByPhone($phone);
		if(isset($profile) && count($profile) > 0){
			ajax_return ( ajax_failure('The phone number has been used.') );
		}
		
		$data = array (
			'uid' => $uid,
			'name' => $name,
			'phone' => $phone,
			'num1' => $num1
		);
		$_profile->save ( $data );
		
		ajax_return ( ajax_success () );
	}
}

run ( $urls );
?>
