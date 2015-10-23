<?php
class FileHelper {
	
	/**
	 * 遍历文件夹
	 */
	static function ergodicDir($dir, &$files = array()){
		//$files = array();
		$dir_list = @scandir($dir);
		foreach($dir_list as $file){
			if ( $file != ".." && $file != "." ){
				if ( is_dir($dir . $file) ){
					self::ergodicDir($dir . $file . '/', $files);
				}
				else{
					$files[] = $dir .  $file;
				}
			}
		}
	}
	
	/**
	 * 获取图片文件夹路径(单级)
	 */
	static function getImagesUrl($dir){
		$files = array();
		$dir_list = @scandir($dir);
		foreach($dir_list as $file){
			if ( $file != ".." && $file != "." ){
				if ( !is_dir($dir . $file) ){
					$files[] = "'" . APP_URL . $dir .  $file . "'";
				}
			}
		}
		return $files;
	}
	
	/**
	 * 获取views文件title
	 */
	static function getViewsTitle($filePath) {
		$title = '';
		try {
			@ $fp = fopen ( $filePath, 'r' );
			if ($fp) {
				$content = fread ( $fp, 1024 );
				$_pos2 = strpos ( $content, "<title>" );
				$_pos3 = strpos ( $content, "</title>" );
				if ($_pos3 > $_pos2) {
					$title = substr ( $content, $_pos2 + 7, $_pos3 - $_pos2 - 7 );
					$title .= ' - ';
				}
				fclose ( $fp );
			}
		} catch ( Exception $e ) {
		}
		return $title;
	}
}