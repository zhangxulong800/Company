<?php 
$re=array('err_code'=>'0','err_msg'=>$language['err_msg'][0]);

$need=array('username','money','reason',);
foreach($need as $v){
	if(!isset($_POST[$v])){
		$re['api_state']='fail';
		$re['api_msg']=$language['lack_params'].':'.$v;
		return_api($re);
	}

}

$sql="select `id` from ".$pdo->index_pre."user where `username`='".$_POST['username']."' limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){
	$re['api_state']='fail';
	$re['api_msg']='username'.$language['not_exist'];
	return_api($re);			
}
$r=operator_money($config,$language,$pdo,$_POST['username'],$_POST['money'],$_POST['reason'],'API',1);
if($r===true){
	$re['api_state']='success';
	$re['api_msg']=$language['success'];
}else{
	$re['api_state']='fail';
	$re['api_msg']=$language['fail'].@$_POST['operator_money_err_info'];
}
return_api($re);


