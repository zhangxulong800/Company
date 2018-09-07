<?php 
header('Content-Type:text/html;charset=utf-8');
if(!is_file('./state_txt/'.$_REQUEST['state'].'.txt') || @$_GET['code']==''){
	exit('<script>window.location.href="./qr_login_result.php?r=fail";</script>');	
}else{
	if(file_put_contents('./state_txt/'.$_REQUEST['state'].'.txt',$_GET['code'])){
		exit('<script>window.location.href="./qr_login_result.php?r=success";</script>');
	}else{
		exit('<script>window.location.href="./qr_login_result.php?r=fail";</script>');		
	}
}
?>
