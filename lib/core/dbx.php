<?php
/**
 * Extended db wrapper for php's native pdo library.
 */
class dbx extends PDO {
	const DEBUG_NONE = 0;
	const DEBUG_QUERY = 32;
	const DEBUG_ALL = 128;
	
	/**
	 * Default fetch mode, used by run().
	 */
	public $fetch_mode = PDO::FETCH_OBJ;
	/**
	 * Debug level, used by run().
	 */
	public $debug = self::DEBUG_QUERY;
	
	/**
	 * Default constructor override to catch connection exception.
	 */
	function __construct($dsn, $user, $passwd) {
		try {
			parent::__construct ( $dsn, $user, $passwd );
		} catch ( Exception $e ) {
			//throw new Exception ( 'dbx: dude, where\'s my db?' );
			print_r($e);
		}
	}
	
	/**
	 * Helper method to quickly query and get access to db result set.
	 *
	 * Multiple usage patterns:
	 *
	 * <pre>
	 * $db->q($sql)
	 * $db->q($sql, $array_of_params)
	 * $db->q($sql, $p1, $p2, $p3, ...)
	 * </pre>
	 */
	function run() {
		$params = func_get_args ();
		$sql = array_shift ( $params );
		// for chinese characters
		$sqlx = "SET character_set_client=utf8";
		$this->query ( $sqlx );
		$sqlx = "SET character_set_connection=utf8";
		$this->query ( $sqlx );
		$sqlx = "SET character_set_results=utf8";
		$this->query ( $sqlx );
		
		if (empty ( $params )) {
			$ok = $this->query ( $sql );
			if (! $ok && $this->debug & self::DEBUG_QUERY) {
				$err = $this->errorInfo ();
				throw new Exception ( "dbx: bad query [{$err[2]}][$sql]" );
			}
			return $ok;
		}
		if (is_array ( $params [0] )) {
			$params = $params [0];
		}
		$st = $this->prepare ( $sql );
		$st->setFetchMode ( $this->fetch_mode );
		$ok = $st->execute ( $params );
		if (! $ok && $this->debug & self::DEBUG_QUERY) {
			$err = $st->errorInfo ();
			throw new Exception ( "dbx: bad query [{$err[2]}][$sql]" );
		}
		return $st;
	}
}
?>
