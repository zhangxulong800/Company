<?php
$act=@$_GET['act'];
if($act=='get_shops'){	
	exit($list);	
	exit('['.$list.']');	
}