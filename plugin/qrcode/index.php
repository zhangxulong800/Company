<?php 
require('./qrcode.php');
$_GET['text']=str_replace('|||','&',@$_GET['text']);
if(intval(@$_GET['logo']==1)){
	QRcode::png($_GET['text'],'./temp.png');
	ob_end_clean();
	
	header("Content-type: image/png");
	require('../../lib/image.class.php');
	$image=new image();
	$image->thumb('./temp.png','./temp.png',200,200);
	
	if(!isset($_GET['logo_path'])){$logo_path='./qr_logo.png';}else{
		$logo_path=$_GET['logo_path'];
		$image->thumb($logo_path,'./temp2.png',30,30);
		$logo_path='./temp2.png';
	}
	
	$image->imageMark('./temp.png','./temp.png',$logo_path,5,100,1);
	echo file_get_contents('./temp.png');
	unlink('./temp.png');
}else{
	QRcode::png($_GET['text']);
}
?>