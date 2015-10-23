<?php
class user extends Model {
	public $_primary_key = 'id';
	public $_table_name = 'user';
	public $_columns = array (
		'id',
		'openid',
		'username',
		'password',
		'levels',
		'name',
		'sex',
		'phone',
		'email',
		'headimgurl',
		'refreshtoken',
		'unionid',
		'iswechat',
		'memo',
		'status',
		'udate',
		'cdate',
		'isdelete'
	);
	public function countUsers() {
		$sql = "SELECT COUNT(id) AS num FROM $this->_table_name";
		return $this->findObject ( $sql );
	}
	public function findByOpenid($openid) {
		$sql = "SELECT * FROM $this->_table_name WHERE openid = ?";
		$param = array (
			$openid 
		);
		return $this->findObject ( $sql, $param );
	}
	public function findByUsername($username) {
		$sql = "SELECT * FROM $this->_table_name WHERE username = ?";
		$param = array (
			$username 
		);
		return $this->findObject ( $sql, $param );
	}
	public function findByUsernameLevels($username, $levels) {
		$sql = "SELECT * FROM $this->_table_name WHERE username = ? AND levels = ?";
		$param = array (
			$username,
			$levels 
		);
		return $this->findObject ( $sql, $param );
	}
	public function findByPassword($password) {
		$sql = "SELECT * FROM $this->_table_name WHERE password = ?";
		$param = array (
			$password 
		);
		return $this->findObject ( $sql, $param );
	}
	public function findPage($start, $rows) {
		$sql = "SELECT * FROM $this->_table_name LIMIT $start,$rows";
		$param = array (
			$start,
			$rows 
		);
		return $this->findList ( $sql, $param );
	}
	public function findPageCount() {
		$sql = "SELECT COUNT(id) total FROM $this->_table_name";
		$param = array ();
		return $this->findObject ( $sql, $param );
	}
}
?>