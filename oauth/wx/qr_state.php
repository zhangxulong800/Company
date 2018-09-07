<?php 
header('Content-Type:text/html;charset=utf-8');
//echo @file_get_contents('./state_txt/'.str_replace('..','',@$_GET['state']).'.txt');
echo @file_get_contents('./state_txt/'.@$_GET['state'].'.txt');
?>