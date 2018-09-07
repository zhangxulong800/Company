<?php
function install($pdo,$language){
	safe_rename('./program/scanpay/scanpay_type','./scanpay_type/');
	return true;
}
?>