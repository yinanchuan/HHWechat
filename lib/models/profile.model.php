<?php
class profile extends Model {
	public $_primary_key = 'id';
	public $_table_name = 'profile';
	public $_columns = array (
		'id',
		'uid',
		'name',
		'phone',
		'email',
		'address',
		'postcode',
		'num1',
		'temp1',
		'memo',
		'status',
		'udate',
		'cdate',
		'isdelete'
	);
	public function findByUid($uid) {
		$sql = "SELECT * FROM $this->_table_name WHERE uid = ?";
		$param = array (
			$uid 
		);
		return $this->findObject ( $sql, $param );
	}
	public function findByPhone($phone) {
		$sql = "SELECT * FROM $this->_table_name WHERE phone = ?";
		$param = array (
			$phone
		);
		return $this->findList($sql, $param);
	}
}
?>