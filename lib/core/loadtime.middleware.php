<?php
class LoadTimeMiddleware {
	private $db = null;
	private $startTime;
	private $endTime;
	private $loadTime;
	private $url;
	function __construct() {
	}
	function run_before() {
		$this->startTime = microtime ( true );
		$url = $_SERVER ['REQUEST_URI'];
		$urls = explode ( "/", $url );
		$this->url = $urls [2];
		if (strpos ( $this->url, "&" )) {
			$this->url = substr ( $this->url, 0, strpos ( $this->url, "&" ) );
		}
	}
	function run_after() {
		$this->endTime = microtime ( true );
		$this->loadTime = round ( ($this->endTime - $this->startTime) * 1000, 2 );
		$db = db ();
		$sql = "INSERT INTO loadtime (page_name, load_time) VALUES (?,?) ON DUPLICATE KEY UPDATE load_time=load_time+?, hits=hits+1";
		$result = $db->run ( $sql, array (
			$this->url,
			$this->loadTime,
			$this->loadTime 
		) );
		$sql = "SELECT * FROM loadtime WHERE page_name = ?";
		$page_load_time = $db->run ( $sql, $this->url )->fetch ( PDO::FETCH_ASSOC );
		$average_load_time = round ( $page_load_time ['load_time'] / $page_load_time ['hits'], 2 );
		// print
		// "<div class='clearfix'>
		// load time: {$this->loadTime}ms | hits: {$page_load_time['hits']} | average load time: {$average_load_time}ms
		// </div>
		// ";
	}
}
?>