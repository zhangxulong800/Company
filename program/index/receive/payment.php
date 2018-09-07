<?php
if(@$_GET['act']=='offline'){
	$offline=@$_POST['offline'];
	$offline=str_replace('<','< ',$offline);
	$offline_state=@$_POST['offline_state'];
	$offline_state=str_replace('<','< ',$offline_state);
	$pay_info=@$_POST['pay_info'];
	$pay_info=str_replace('<','< ',$pay_info);
	if(file_put_contents('./payment/offline.php',$offline)){
		file_put_contents('./payment/pay_info.php',$pay_info);
		file_put_contents('./payment/offline_state.php',$offline_state);
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>成功'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>失败'}");	
	}
		
}