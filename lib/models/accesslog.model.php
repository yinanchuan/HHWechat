<?php
class accesslog extends Model {
	public $_primary_key = 'id';
	public $_table_name = 'accesslog';
	public $_columns = array (
		'id',
		'name',
		'data',
		'memo',
		'type',
		'status',
		'ip',
		'useragent',
		'cdate' 
	);
}
?>