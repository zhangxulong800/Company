<?php 
$re=array('err_code'=>'0','err_msg'=>$language['err_msg'][0]);

$need=array('code','money','reason',);
foreach($need as $v){
	if(!isset($_POST[$v])){
		$re['api_state']='fail';
		$re['api_msg']=$language['lack_params'].':'.$v;
		return_api($re);
	}

}

	$pre=mb_substr($_POST['code'],0,5,'utf-8');
	$postfix=mb_substr($_POST['code'],5);
	
	if($pre=='6666_' && strlen($postfix)==8){
		$qr_info=get_qr_pay_info($pdo,$postfix);
		if($qr_info['id']!=''){
			
		}else{
			exit('{"state":"fail","info":"<span class=fail>'.$language['pay_code_err'].'</span>"}');
			$re['api_state']='fail';
			$re['api_msg']=$language['fail'].' '.$language['pay_code_err'];
			return_api($re);		
		}
	}else{
		$re['api_state']='fail';
		$re['api_msg']=$language['fail'].' '.$language['pay_code_err'];	
		return_api($re);
	}



$sql="select `id`,`username` from ".$pdo->index_pre."user where `username`='".$qr_info['username']."' limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){
	$re['api_state']='fail';
	$re['api_msg']='user'.$language['not_exist'];
	return_api($re);			
}
$r=operator_money($config,$language,$pdo,$r['username'],'-'.$_POST['money'],$_POST['reason'],'API qr_pay',1);
if($r===true){
	index_qr_pay_update($pdo,$qr_info['id'],$_POST['money'],'API');
	$re['api_state']='success';
	$re['api_msg']=$language['success'];
}else{
	$re['api_state']='fail';
	$re['api_msg']=$language['fail'].@$_POST['operator_money_err_info'];
}
return_api($re);


