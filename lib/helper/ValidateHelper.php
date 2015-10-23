<?php 
class ValidateHelper {
	/**
	* 验证是否是手机号
	*/
	public static function validatePhone($phone)
	{
		$result = FALSE;
		if( !empty ( $phone ) && preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#',$phone))
		{
			$result = TRUE;
		}
		
		return $result;
	}
}