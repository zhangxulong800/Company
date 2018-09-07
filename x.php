<?php 
$cfg_dbname='kkk';
$cfg_dbuser='root';
$cfg_dbpwd='root';
// 设置SQL文件保存文件名 
$filename=date("Y-m-d_H-i-s")."-".$cfg_dbname.".sql"; 
// 所保存的文件名 
header("Content-disposition:filename=".$filename); 
header("Content-type:application/octetstream"); 
header("Pragma:no-cache"); 
header("Expires:0"); 
// 获取当前页面文件路径，SQL文件就导出到此文件夹内 
$tmpFile = (dirname(__FILE__))."\\".$filename; 
// 用MySQLDump命令导出数据库 
exec("mysqldump -u$cfg_dbuser -p$cfg_dbpwd --default-character-set=utf8 $cfg_dbname > ".$tmpFile); 
$file = fopen($tmpFile, "r"); // 打开文件 
echo fread($file,filesize($tmpFile)); 
fclose($file); 
exit; 
?>