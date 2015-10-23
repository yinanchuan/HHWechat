<?php
class JSSDK {
	
	private $appId;
	private $appSecret;
	private $savedDb = true;
	
	public function __construct() {
		$this->appId = WX_APP_ID;
		$this->appSecret = WX_APP_SECRET;
	}
	
	public function getSignPackage() {
		$jsapiTicket = $this->getJsApiTicket ();
		
		// 注意 URL 一定要动态获取，不能 hardcode.
		$protocol = (! empty ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] !== 'off' || $_SERVER ['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		
		$timestamp = time ();
		$nonceStr = $this->createNonceStr ();
		
		// 这里参数的顺序要按照 key 值 ASCII 码升序排序
		$string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
		
		$signature = sha1 ( $string );
		
		$signPackage = array (
			"appId" => $this->appId,
			"nonceStr" => $nonceStr,
			"timestamp" => $timestamp,
			"url" => $url,
			"signature" => $signature,
			"rawString" => $string 
		);
		return $signPackage;
	}
	
	private function createNonceStr($length = 16) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for($i = 0; $i < $length; $i ++) {
			$str .= substr ( $chars, mt_rand ( 0, strlen ( $chars ) - 1 ), 1 );
		}
		return $str;
	}
	
	private function getJsApiTicket() {
		if($this->savedDb == true){
			$ticket = $this->getJsApiTicket_db ();
		}
		else{
			$jsapi_ticket_file = "jsapi_ticket.json"; // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
			$data = json_decode ( file_get_contents ( $jsapi_ticket_file ) );
			if ($data->expire_time < time ()) {
				$ticket = $this->getJsApiTicket_http();
				if ($ticket) {
					$data->expire_time = time () + 7000;
					$data->jsapi_ticket = $ticket;
					$fp = fopen ( $jsapi_ticket_file, "w" );
					fwrite ( $fp, json_encode ( $data ) );
					fclose ( $fp );
				}
			} else {
				$ticket = $data->jsapi_ticket;
			}
		}
		return $ticket;
	}
	
	private function getJsApiTicket_db() {
		$_setting = new setting();
		$setting = $_setting->findByName('jsapi_ticket');
	
		if(isset($setting) && isset($setting['value']) && !empty($setting['value']) && isset($setting['udate']) && intval($setting['udate']) > time()){
			$ticket = $setting['value'];
		}else{
			$ticket = $this->getJsApiTicket_http();
			$_setting->updateValue('jsapi_ticket', $ticket, (time() + 7000));
		}
	
		return $ticket;
	}
	
	private function getJsApiTicket_http() {
		$accessToken = $this->getAccessToken ();
		// 如果是企业号用以下 URL 获取 ticket
		// $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
		$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
		$response = json_decode ( $this->httpGet ( $url ), true );
		//if(isset($response['errcode'])){
		//	die('getJsApiTicket_http - ' . $response['errmsg']);
		//}
		$ticket = $response['ticket'];
		
		return $ticket;
	}
	
	private function getAccessToken() {
		if($this->savedDb == true){
			$access_token = $this->getAccessToken_db ();
		}
		else{
			$access_token_file = "access_token.json"; // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
			$data = json_decode ( file_get_contents ( $access_token_file ) );
			if ($data->expire_time < time ()) {
				$access_token = $this->getAccessToken_http();
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
	
	private function getAccessToken_db() {
		$_setting = new setting();
		$setting = $_setting->findByName('access_token');
	
		if(isset($setting) && isset($setting['value']) && !empty($setting['value']) && isset($setting['udate']) && intval($setting['udate']) > time()){
			$access_token = $setting['value'];
		}else{
			$access_token = $this->getAccessToken_http();
			$_setting->updateValue('access_token', $access_token, (time() + 7000));
		}
		
		return $access_token;
	}
	
	private function getAccessToken_http() {
		// 如果是企业号用以下URL获取access_token
		// $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
		$response = json_decode ( $this->httpGet ( $url ), true );
		//if(isset($response['errcode'])){
		//	die('getAccessToken_http - ' . $response['errmsg']);
		//}
		$access_token = $response['access_token'];
		return $access_token;
	}
	
	private function httpGet($url) {
		/* $curl = curl_init ();
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $curl, CURLOPT_TIMEOUT, 500 );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt ( $curl, CURLOPT_URL, $url );
		
		$res = curl_exec ( $curl );
		curl_close ( $curl ); */
		
		$res = file_get_contents($url);
		
		return $res;
	}
}
