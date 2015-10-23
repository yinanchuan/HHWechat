<?php
class ListHelper {
	
	/**
	 * 翻译列表
	 * @param $list 待翻译列表  array(stdClass1, stdClass2, stdClass3 ...)
	 * @param $field 待翻译字段
	 * @param $dic_list 字典列表  array(stdClass1, stdClass2, stdClass3 ...)
	 * @param $div_key_field 字典字段,必须等于$field才能翻译
	 * @param $dic_value_field 字典值字段
	 * @return $list
	 */
	static function mapping_list($list, $field, $dic_list, $div_key_field, $dic_value_field) {
		if(empty($list) || count($list) == 0){
			return $list;
		}
		if(empty($dic_list) || count($dic_list) == 0){
			return $list;
		}
		$field_name = $field . '_name';
		foreach ($list as $value) {
			if(empty($value)){
				continue;
			}
			$field_value = $value->$field;
			if(empty($field_value)){
				continue;
			}
			foreach ($dic_list as $dic) {
				if(empty($dic)){
					continue;
				}
				if($field_value == $dic->$div_key_field){
					$value->$field_name = $dic->$dic_value_field;
					break;
				}
			}
		}
		return $list;
	}
	
	/**
	 * 翻译列表
	 * @param $list 待翻译列表 array(stdClass1, stdClass2, stdClass3 ...)
	 * @param $field 待翻译字段        	
	 * @param $dic_list 字典列表 array(stdClass1, stdClass2, stdClass3 ...)
	 * @param $div_key_field 字典字段,必须等于$field才能翻译        	
	 * @param $dic_value_field 字典值字段        	
	 * @param $dic_key_field 字典键字段        	
	 * @return $list
	 */
	static function mapping_list_3($list, $field, $dic_list, $div_key_field, $dic_value_field, $dic_key_field) {
		if (empty ( $list ) || count ( $list ) == 0) {
			return $list;
		}
		if (empty ( $dic_list ) || count ( $dic_list ) == 0) {
			return $list;
		}
		if (! isset ( $dic_key_field )) {
			$dic_key_field = $dic_value_field;
		}
		foreach ( $list as $value ) {
			if (empty ( $value )) {
				continue;
			}
			$field_value = $value->$field;
			if (empty ( $field_value )) {
				continue;
			}
			foreach ( $dic_list as $dic ) {
				if (empty ( $dic )) {
					continue;
				}
				if ($field_value == $dic->$div_key_field) {
					$value->$dic_key_field = $dic->$dic_value_field;
					break;
				}
			}
		}
		return $list;
	}
	
	/**
	 * 翻译列表
	 * @param $list
	 * @param $field
	 * @param $dic_array array (1 => '是', 0 => '否')
	 * @return $list
	 */
	static function mapping_list_2($list, $field, $dic_array) {
		if (empty ( $list ) || count ( $list ) == 0) {
			return $list;
		}
		if (empty ( $dic_array ) || count ( $dic_array ) == 0) {
			return $list;
		}
		$field_name = $field . '_name';
		foreach ( $list as $value ) {
			if (empty ( $value )) {
				continue;
			}
			$field_value = $value->$field;
			// if(empty($field_value)){ //需要考虑为0的情况
			// continue;
			// }
			$value->$field_name = $dic_array [$field_value];
		}
		return $list;
	}
	
	/**
	 * 翻译单个对象
	 */
	static function mapping_array($array, $field, $dic_array) {
		if (empty ( $array )) {
			return $array;
		}
		if (empty ( $dic_array ) || count ( $dic_array ) == 0) {
			return $array;
		}
		$field_name = $field . '_name';
		$array->$field_name = $dic_array [$array->$field];
		return $array;
	}
	
	/**
	 * object转Array
	 */
	static function object2array($object) {
		if (!is_object($object) && !is_array($object)) {
			return $object;
		}
		if (is_object($object)) {
			$object = get_object_vars($object);
		}
		return array_map('object2array', $object);
	}
}