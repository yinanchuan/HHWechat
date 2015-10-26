<?php

function getWxOpenid_2($code = null, $state = null) {
	if(isLocal() == true){
		$openid = 'oxkwBj2qKhiQ2Spewqn4tq_YnpWU';
		return $openid;
	}

	//优先从session中获取
	if(isset($_SESSION[SESSION_OPENID])){
		$openid = $_SESSION[SESSION_OPENID];
		return $openid;
	}
	unset($_SESSION[SESSION_OPENID]);

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

		//TODO 不能直接使用ajax获取到openid,需要先URL重定向获取到openid或保存到session
		return $openid;
	}

	$timestamp = time();
	$sig = md5(API_KEY . API_SECRET . $timestamp);
	$fields = array(
		'a' => 'Check',
		'm' => 'index',
		'apiKey' => API_KEY,
		'timestamp' => $timestamp,
		'sig' => $sig,
		'url' => urlencode(APP_URL . 'authorize2.php')
	);
	$postData = HttpHelper::generatePostData($fields);

	$url = API_URL. "?" . $postData;

	header ( 'Location: ' . $url );
}

function getWxSnsapiUserinfo_2($code = null, $state = null) {

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

	$timestamp = time();
	$sig = md5(API_KEY . API_SECRET . $timestamp);
	$fields = array(
		'a' => 'Check',
		'm' => 'index',
		'apiKey' => API_KEY,
		'timestamp' => $timestamp,
		'sig' => $sig,
		'url' => urlencode(APP_URL . 'oauth2.php')
	);
	$postData = HttpHelper::generatePostData($fields);

	$url = API_URL. "?" . $postData;

	header ( 'Location: ' . $url );
}

?>