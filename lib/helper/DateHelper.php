<?php
class DateHelper {
	static function getTimestamp($time = null, $format = 'Y-m-d H:i:s') {
		if ($time == null) {
			$time = time ();
		}
		return date ( $format, $time );
	}
}