<?php
function i18n($sId) {
	global $_LAN_PACK;
	if (isset ( $_LAN_PACK [$sId] )) {
		return $_LAN_PACK [$sId];
	} else {
		return "";
	}
}
function i18n_en($sId) {
	global $_LAN_PACK_EN;
	if (isset ( $_LAN_PACK_EN [$sId] )) {
		return $_LAN_PACK_EN [$sId];
	} else {
		return "";
	}
}
function i18n_cn($sId) {
	global $_LAN_PACK_CN;
	if (isset ( $_LAN_PACK_CN [$sId] )) {
		return $_LAN_PACK_CN [$sId];
	} else {
		return "";
	}
}
?>