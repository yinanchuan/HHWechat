<?php
class share extends Model {
	public $_primary_key = 'id';
	public $_table_name = 'share';
	public $_columns = array (
		'id',
		'uid',
		'cid',
		'sid',
		'url',
		'memo',
		'status',
		'type',
		'cdate' 
	);
}
?>