<?php
libxml_disable_entity_loader(true); 
header('Content-Type:text/html;charset=utf-8');
header("Set-Cookie: hidden=value; httpOnly");
require_once './config/functions.php';
$config=require_once './config.php';
$pdo=new  ConnectPDO();

$sql="select `url` from ".$pdo->index_pre."surl order by `id` desc limit 0,50000";
$r=$pdo->query($sql,2);
$list='';
$pre='http://'.$config['web']['domain'].'/index.php?monxin=';
foreach($r as $v){
	$list.=$pre. de_safe_str($v['url']) ."\r\n";
}
echo $list;
file_put_contents('./sitemap.txt',$list);
?>