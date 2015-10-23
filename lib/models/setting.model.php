<?php
class setting extends Model {
	public $_primary_key = 'id';
	public $_table_name = 'setting';
	public $_columns = array (
		'id',
		'name',
		'value',
		'status',
		'udate' 
	);
	
	public function findByName($name) {
		$sql = "SELECT * FROM $this->_table_name WHERE name = ?";
		$param = array (
			$name
		);
		$setting = $this->findObject ( $sql, $param );
		return $setting;
	}
	
	public function findValue($name) {
		$sql = "SELECT value FROM $this->_table_name WHERE name = ?";
		$param = array (
			$name 
		);
		$setting = $this->findObject ( $sql, $param );
		if(isset($setting) && isset($setting['value'])){
			return $setting['value'];
		}
		return null;
	}
	
	public function updateValue($name, $value, $udate = null) {
		if($udate == null){
			$udate = time();
		}
		$sql = "UPDATE $this->_table_name SET value = ?, udate = ? WHERE name = ?";
		$param = array (
			$value,
			$udate,
			$name
		);
		$this->run($sql, $param);
	}
	
}
?>