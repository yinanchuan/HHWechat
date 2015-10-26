<?php

function getWxOpenidFromSession() {
	$openid = null;
	if(isset($_SESSION[SESSION_OPENID])){
		$openid = $_SESSION[SESSION_OPENID];
	}
	return $openid;
}

/**
 * 根据guid获取用户记录,没有则创建用户
 */
function getUserByGuid($guid) {
	if(empty($guid)){
		return null;
	}

	$_user = new user ();
	$user = $_user->findByOpenid($guid);
	if(isset($user)){
		return $user;
	}
	
	$now = time();
	$uid = $_user->save ( array (
		'openid' 	=> $guid,
		'levels' 	=> DicConst::$TYPE_USER_LEVELS_WECHAT,
		'username' 	=> 'username_' . $now,
		'name' 		=> 'name_' . $now,
		'password' 	=> time(),
		'memo' 		=> $_SERVER['HTTP_USER_AGENT'],
		'headimgurl'=> HttpHelper::getRealIp()
	) );
	
	$user = $_user->findById($uid);
	
	return $user;
}

function getWxSnsapiUserinfo($code = null, $state = null) {

	$appId = WX_APP_ID;
	$appSecret = WX_APP_SECRET;
	$redirectUri = WX_REDIRECT_URI2;
	
	if(isset($code)){
		//获取openid
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token";
		$url .= "?appid=$appId";
		$url .= "&secret=$appSecret";
		$url .= "&code=$code";
		$url .= "&grant_type=authorization_code";
		$response = json_decode ( HttpHelper::httpGet ( $url ), true );
		if(isset($response['errcode'])){
			die('getWxSnsapiUserinfo - ' . $response['errmsg']);
		}
		
		$access_token = $response['access_token'];
		$refresh_token = $response['refresh_token'];
		$openid = $response['openid'];
		//$unionid = $response['unionid'];
		
		//保存到session
		$_SESSION[SESSION_OPENID] = $openid;
		
		//通过access_token和openid拉取用户信息
		$url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
		$response = json_decode ( HttpHelper::httpGet ( $url ), true );
		if(isset($response['errcode'])){
			die('getWxSnsapiUserinfo2 - ' . $response['errmsg']);
		}
		
		$response['refresh_token'] = $refresh_token;
		//$response['unionid'] = $unionid;
		saveWxSnsapiUserinfo($openid, $response);
		
		//跳转之前的url
		if(isset($state)){
			header ( 'Location: ' . $state );exit;
		}
		else{
			header ( 'Location: ' . APP_URL . 'index.php' );exit;
		}
	}
	
	$url = "https://open.weixin.qq.com/connect/oauth2/authorize";
	$url .= "?appid=" . $appId;
	$url .= "&redirect_uri=" . urlencode($redirectUri);
	$url .= "&response_type=code";
	$url .= "&scope=snsapi_userinfo";
	$url .= "&state=" . urlencode($_SERVER['REQUEST_URI']);
	$url .= "#wechat_redirect";

	header ( 'Location: ' . $url );
}

function saveWxSnsapiUserinfo($openid, $userinfo) {
	log_access(DicConst::$TYPE_LOG_WXUSERINFO, 'WxSnsapiUserinfo', json_encode($userinfo));
	
	$user = GetUserByOpenid($openid); //记录新用户(只有openid)
	if(isset($user)){
		$_SESSION[SESSION_UID] = $user['id'];
	}
	
	if(isset($userinfo)){
		$uid = (isset($user) && isset($user['id'])) ? $user['id'] : 0;
		$_user = new user ($uid);
		
		$data = array (
			'iswechat' => 1, //已获取到资料
			'name' => isset($userinfo['nickname']) ? $userinfo['nickname'] : '',
			'sex' => isset($userinfo['sex']) ? $userinfo['sex'] : '',
			'headimgurl' => isset($userinfo['headimgurl']) ? $userinfo['headimgurl'] : '',
			
			'phone' => isset($userinfo['province']) ? $userinfo['province'] : '',
			'email' => isset($userinfo['city']) ? $userinfo['city'] : '',
			'memo' => isset($userinfo['country']) ? $userinfo['country'] : '',
			
			'refreshtoken' => isset($userinfo['refresh_token']) ? $userinfo['refresh_token'] : '',
			'unionid' => isset($userinfo['unionid']) ? $userinfo['unionid'] : ''
		);
		
		$_user->save ( $data );
	}
}

function getWxOpenid($code = null, $state = null) {
	$openid = getWxOpenidFromSession();
	if(isset($openid) && $openid != null){
		return $openid;
	}
	
	$appId = WX_APP_ID;
	$appSecret = WX_APP_SECRET;
	$redirectUri = WX_REDIRECT_URI;
	
	if(isset($code)){
		//获取openid
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token";
		$url .= "?appid=$appId";
		$url .= "&secret=$appSecret";
		$url .= "&code=$code";
		$url .= "&grant_type=authorization_code";
		
		$response = json_decode ( HttpHelper::httpGet ( $url ), true );
		if(isset($response['errcode'])){
			die('getWxOpenid - ' . $response['errmsg']);
		}
		
		$openid = $response['openid'];
		
		//保存到session
		$_SESSION[SESSION_OPENID] = $openid;
		
		//跳转之前的url
		if(isset($state)){
			header ( 'Location: ' . $state );
			exit;
		}
		
		return $openid;
	}
	
	$url = "https://open.weixin.qq.com/connect/oauth2/authorize";
	$url .= "?appid=" . $appId;
	$url .= "&redirect_uri=" . urlencode($redirectUri);
	$url .= "&response_type=code";
	$url .= "&scope=snsapi_base"; //snsapi_base/snsapi_userinfo
	$url .= "&state=" . urlencode($_SERVER['REQUEST_URI']);
	$url .= "#wechat_redirect";
	
	header ( 'Location: ' . $url );
}

//根据openid构造用户
function GetUserByOpenid($openid) {
	if(empty($openid)){
		return null;
	}
	$_user = new user ();
	$user = $_user->findByOpenid($openid);
	if(!isset($user) || !isset($user['id'])){ //生成用户
		$__id = time();
		
		$data = array (
			'openid' => $openid,
			'levels' => DicConst::$TYPE_USER_LEVELS_WECHAT,
			'username' => 'username_' . $__id,
			'password' => $__id,
			'name' => 'name_' . $__id
		);
		$_user->save ( $data );
		$uid = $_user->lastInsertId;
		$user = $_user->findById($uid);
	}
	$_SESSION[SESSION_UID] = $user['id'];
	return $user;
}

function getWxAccessToken() {
	$savedDb = true;
	
	if($this->savedDb == true){
		$access_token = getWxAccessToken_db ();
	}
	else{
		$access_token_file = "access_token.json";
		$data = json_decode ( file_get_contents ( $access_token_file ) );
		if(isLocal()){
			$access_token = $data->access_token;
			return $access_token;
		}
		if ($data->expire_time < time ()) {
			$access_token = getWxAccessToken_http();
			if ($access_token) {
				$data->expire_time = time () + 7000;
				$data->access_token = $access_token;
				$fp = fopen ( $access_token_file, "w" );
				fwrite ( $fp, json_encode ( $data ) );
				fclose ( $fp );
			}
		} else {
			$access_token = $data->access_token;
		}
	}
	return $access_token;
}

function getWxAccessToken_db() {
	$_setting = new setting();
	$setting = $_setting->findByName('access_token');
	
	if(isset($setting) && isset($setting['value']) && !empty($setting['value']) && isset($setting['udate']) && intval($setting['udate']) > time()){
		$access_token = $setting['value'];
	}else{
		$access_token = getWxAccessToken_http();
		$_setting->updateValue('access_token', $access_token, (time() + 7000));
	}
	
	return $access_token;
}

function getWxAccessToken_http() {
	$appId = WX_APP_ID;
	$appSecret = WX_APP_SECRET;
	
	// 如果是企业号用以下URL获取access_token
	// $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$appId&corpsecret=$appSecret";
	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appId&secret=$appSecret";
	$res = json_decode ( HttpHelper::httpGet ( $url ) );
	$access_token = $res->access_token;
	
	return $access_token;
}

function updateWxUserinfo() {
	if(isLocal()){
		return;
	}
	$access_token = getWxAccessToken();
	$openid = getWxOpenid();
	
	getWxUserinfo($access_token, $openid, true);
}

function getWxUserinfo($access_token, $openid, $updateUser = false) {
	$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
	$userinfo = json_decode ( HttpHelper::httpGet ( $url ), true );
	if(isset($userinfo['errcode'])){
		die('GetWxUserinfo error [errcode:' . $userinfo['errcode'] . ']');
	}
	//die(print_r($userinfo));
	//更新user
	if(isset($updateUser) && $updateUser == true){
		updateUser($openid, $userinfo);
	}
	
	return $userinfo;
}

function updateUser($openid, $userinfo) {
	$user = GetUserByOpenid($openid); //记录新用户(只有openid)
	if(isset($user)){
		$_SESSION[SESSION_UID] = $user['id'];
	}
	
	if(isset($userinfo)){
		$subscribe = $userinfo['subscribe']; //0未关注，1已关注
		if($subscribe !== 1){
			return false;
		}
		$uid = (isset($user) && isset($user['id'])) ? $user['id'] : 0;
		$_user = new user ($uid);
		
		$data = array (
			'iswechat' => 1, //已获取到资料
			'name' => isset($userinfo['nickname']) ? $userinfo['nickname'] : '',
			'sex' => isset($userinfo['sex']) ? $userinfo['sex'] : '',
			'headimgurl' => isset($userinfo['headimgurl']) ? $userinfo['headimgurl'] : ''
		);
		
		$_user->save ( $data );
	}
}

function getWxJssdk(&$p) {
	$jssdk = new JSSDK();
	$signPackage = $jssdk->GetSignPackage();
	
	$p['signPackage'] = $signPackage;
}

?>