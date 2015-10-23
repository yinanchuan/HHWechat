<?php
/**
 * web: a microframework for managing web requests.
 *
 * web maps url patterns to classes and allows you to install middleware objects
 * that perform interrequest opertaions. Here is the general lifecycle of a
 * reqeust according to web:
 *
 * 1. request received;
 * 2. middleware objects instantiated,
 * 3. handler class instantiated,
 * 4. middleware 'run_before' event triggered,
 * 5. handler method called,
 * 6. middleware 'run_after' event triggered,
 * 7. handler class destroyed,
 * 8. middleware destroyed,
 * 9. response flushed.
 *
 * Here is a simple use case: new web(array('$' => 'index'));
 *
 * Here is another one:
 *
 *   $web = new web;
 *   $web->middleware['logger'] = new LoggerMiddleware;
 *   $urls = array(
 *      '$'             => 'index',
 *      '\?add'         => 'add',
 *      '\?id=([0-9]+)' => 'item',
 *      );
 *   $web->run($urls);
 *
 * web was written with an intentionally dumb api to encourage extension. The
 * best place to start is at the dispatch() method. Code made blow up if not
 * used with caution...
 *
 * @author  eric diep <ediep@uwaterloo.ca>
 *          han xu <h8xu@uwaterloo.ca>
 * @since   php 5.2
 */
class web {
	
	/**
	 * Heterogeneous list of middleware objects.
	 *
	 * These are standard classes that can have 'run_before' and/or 'run_after'
	 * methods that are called before and after the request handler method is
	 * triggered.
	 */
	public $middleware = array ();
	
	/**
	 * The result as returned by the handler method.
	 */
	public $result = null;
	
	function __construct($map = array(), $middleware = array()) {
		foreach ( $middleware as $a ) {
			$this->middleware [] = $a;
		}
		if (! empty ( $map )) {
			$this->run ( $map );
		}
	}
	
	function run($map = array(), $uri = null) {
		$params = array ();
		$action = '';
		
		if (is_null ( $uri )) {
			$uri = $_SERVER ['REQUEST_URI'];
			
			if(('http://' . $_SERVER['SERVER_NAME'] . $uri) === APP_URL){ //$_SERVER['SERVER_PORT']
				//print_r($uri);exit;
				header ( 'Location: ' . APP_URL . 'index.php' );
				exit;
			}
			
			$uri = substr($uri, 1); //去除开始/
			
			$__temp = explode ( '?', $uri );
			if(count($__temp) == 2){
				//get参数
				$_matches = explode ( '&', $__temp[1] );
				foreach ( $_matches as $key => $val ) {
					$__p = explode ( '=', $val );
					if (count ( $__p ) == 2) {
						$params [$__p [0]] = $__p [1];
					} else {
						$params [$__p [0]] = '';
					}
				}
			}
			
			$actionPos = 0;
			$__temp2 = explode ( '/', $__temp[0] );
			for ($i = 0; $i < count($__temp2); $i++) {
				if(substr($__temp2[$i], -4) == '.php'){
					$actionPos = $i;
					break;
				}
			}
			
			if(count($__temp2) > ($actionPos + 1)){
				$action = $__temp2[$actionPos + 1];
			}else{
				$action = '*';
			}
		}
		
		$isUrl = false;
		$val = '';
		
		foreach ( array_reverse ( $map ) as $key => $val ) {
			if ($key == '.' . $action) {
				$isUrl = true;
				break;
			}
		}
		
		if ($isUrl == false) {
			header("Content-Type:text/html;charset=utf-8");
			echo '无效的URL参数';
			return false;
		}
		
		$client = new $val ( $this );
		$this->trigger ( 'run_before' );
		$this->result = $this->dispatch ( $client, $params );
		$this->trigger ( 'run_after' );
		
		unset ( $client );
		
		return true;
	}
	
	function dispatch($client, $params = array()) {
		return call_user_func_array ( array ($client, $_SERVER ['REQUEST_METHOD']), $params );
	}
	
	function trigger($name, $args = array()) {
		array_unshift ( $args, $this );
		foreach ( $this->middleware as $i ) {
			if (method_exists ( $i, $name )) {
				if (intval ( PHP_VERSION ) <= 4.1) {
					call_user_method_array ( $name, $i, $args );
				} else {
					call_user_func_array ( array ($i, $name), $args );
				}
			}
		}
	}
}
?>