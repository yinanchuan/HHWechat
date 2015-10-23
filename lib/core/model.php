<?php
class Model {
	
	public $new_record = true;
	public $pid = null;
	public $profix = DB_TABLEPRE;
	public static $dbx = null;
	
	public function __construct($pid = null) {
		$this->_table_name = $this->profix . $this->_table_name;
		
		if (! isset ( self::$dbx )) {
			$dbdsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
			self::$dbx = new dbx ( $dbdsn, DB_USER, DB_PASSWORD );
		}
		
		if (isset($pid)) {
			$this->pid = $pid;
			
			$sql = "SELECT * FROM {$this->_table_name} WHERE {$this->_primary_key} = ?";
			$result = $this->runObject($sql, array (
				$pid
			));
			
			if (isset($result)) {
				$this->data = new stdClass();
				$this->populate($result);
				$this->new_record = false;
			}
		}
	}
	
	public function save($data) {
		$this->checkTableFields($data);
		$this->escapeDataValue($data);
		$this->setUpdateDefaultValue($data);
		
		$param = array();
		$fieldArray = array();
		$resultId = 0;
		
		if ($this->new_record) {
			$this->setInsertDefaultValue($data);
			
			foreach ($data as $key => $val) {
				$fieldArray[] = "?";
				$param[] = $val;
			}
			$sql = "INSERT INTO {$this->_table_name} (" . implode(', ', array_keys($data)) . ") VALUES (" . implode(",", $fieldArray) . ")";
			$result = self::$dbx->run($sql, $param);
			$this->lastInsertId = self::$dbx->lastInsertId();
			$resultId = $this->lastInsertId;
		} else {
			$sql = "UPDATE {$this->_table_name} SET ";
			foreach ($data as $key => $val) {
				$fieldArray[] = " $key = ?";
				$param[] = $val;
			}
			$sql .= implode(",", $fieldArray);
			$sql .= " WHERE {$this->_primary_key} = ?";
			$param[] = $this->data->{$this->_primary_key};
			$result = self::$dbx->run($sql, $param);
			$resultId = $this->data->{$this->_primary_key};
		}
		
		unset($param);
		unset($fieldArray);
		
		return $resultId;
	}
	
	public function setInsertDefaultValue(&$data) {
		foreach ($this->_columns as $column) {
			if('cdate' === $column){
				$data['cdate'] = date('Y-m-d H:i:s');
				break;
			}
		}
	}
	
	public function setUpdateDefaultValue(&$data) {
		foreach ($this->_columns as $column) {
			if('udate' === $column){
				$data['udate'] = date('Y-m-d H:i:s');
				break;
			}
		}
	}
	
	public function checkTableFields($data) {
		foreach ($data as $key => $val) {
			$isColumn = false;
			foreach ($this->_columns as $column) {
				if($key === $column){
					$isColumn = true;
					break;
				}
			}
			if($isColumn === false){
				throw new Exception ( 'Field ' . $key . ' is not in table ' . $this->_table_name );
			}
		}
	}
	
	public function escapeDataValue(&$data) {
		foreach ($data as $key => $val) {
			//$data[$key] = mysql_real_escape_string($val);
			$data[$key] = stripslashes($val);
		}
	}
	
	public function populate($row_data) {
		foreach ($row_data as $field => $value) {
			$this->data-> { $field } = $value;
			$this->new_record = false;
		}
	}

	public function getField($field) {
		if (isset ($this->data)){
			return $this->data-> { $field };
		}
	}
	
	public function setField($field, $value) {
		if (isset ($this->data) && isset ($this->data-> { $field })){
			$this->data-> { $field } = $value;
		}
	}
	
	public function deleteById($id) {
		$sql = "DELETE FROM $this->_table_name WHERE id = ?";
		$param = array($id);
		$this->run($sql, $param);
	}
	
	public function findAll() {
		$sql = "SELECT * FROM $this->_table_name";
		$param = array();
		return $this->findList($sql, $param);
	}
	
	public function findByField($field, $value) {
		$sql = "SELECT * FROM $this->_table_name WHERE $field = ?";
		$param = array($value);
		return $this->findList($sql, $param);
	}
	
	public function findById($id) {
		$sql = "SELECT * FROM $this->_table_name WHERE id = ?";
		$param = array($id);
		return $this->findObject($sql, $param);
	}
	
	public function findObject($sql, $param = array()) {
		$result = $this->runObject($sql, $param);
		return $this->populateArray($result);
	}
	
	public function findList($sql, $param = array()) {
		$results = $this->runList($sql, $param);
		$list = array ();
		foreach ($results as $key => $result) {
			$list[] = $this->populateArray($result);
		}
		return $list;
	}
	
	public function populateArray($result) {
		if(isset($result)){
			$row = array();
			foreach ($result as $field => $value) {
				$row[$field] = $value;
			}
			return $row;
		}
		return null;
	}
	
	public function run($sql, $param = array()) {
		$result = self::$dbx->run($sql, $param);
	}
	
	public function runObject($sql, $param = array()) {
		$results = $this->runList($sql, $param);
		if(isset($results) && count($results) > 0){
			return $results[0];
		}
		return null;
	}
	
	public function runList($sql, $param = array()) {
		try {
			$results = self::$dbx->run($sql, $param)->fetchall(PDO :: FETCH_OBJ);
			return $results;
		} catch (Exception $e) {
			print($e);die();
		}
	}
	
}
?>