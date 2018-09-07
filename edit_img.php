<?php 
header('Content-Type:text/html;charset=utf-8');
require_once './config/functions.php';
$image=new image();

//$image->thumb('./test.jpg','./test2.jpg',1339,0,true);
//phpinfo();

$dir=new Dir();
$list=$dir->show_dir('./php_edit_img/',array('jpg','JPG'),true,false);
foreach($list as $v){
	$image->thumb($v,$v,1339,9999999,true,false);	
	echo $v.' '.date('H:i:s',time()).'<br >';
}
?>