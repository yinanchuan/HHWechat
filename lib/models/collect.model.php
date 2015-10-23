<?php
class collect extends Model {
	public $_primary_key = 'id';
	public $_table_name = 'collect';
	public $_columns = array (
		'id',
		'uid',
		'codes',
		'collects',
		'complete',
		'memo',
		'ip',
		'useragent',
		'status',
		'type',
		'udate',
		'cdate',
		'isdelete'
	);
	function findByUid($uid) {
		$sql = "SELECT id, codes, cdate, status FROM $this->_table_name WHERE uid = ?";
		$param = array (
			$uid 
		);
		return $this->findList ( $sql, $param );
	}
	function findByUidStatus($uid, $status) {
		$sql = "SELECT id, codes, cdate, status FROM $this->_table_name WHERE uid = ? AND status = ? ORDER BY cdate DESC";
		$param = array (
			$uid,
			$status 
		);
		return $this->findList ( $sql, $param );
	}

}
?>