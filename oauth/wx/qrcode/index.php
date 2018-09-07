<?php 
require('./qrcode.php');
$_GET['text']=str_replace('|||','&',@$_GET['text']);
if(intval(@$_GET['logo']==1)){
	QRcode::png($_GET['text'],'./temp.png');
	ob_end_clean();
	
	header("Content-type: image/png");
	require('../../../lib/image.class.php');
	$image=new image();
	$image->thumb('./temp.png','./temp.png',600,600);
	$image->imageMark('./temp.png','./temp.png','./qr_logo.png',5,100);
	echo file_get_contents('./temp.png');
}else{
	QRcode::png($_GET['text']);
}
?>