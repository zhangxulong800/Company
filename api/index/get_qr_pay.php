<?php 
$re=array('err_code'=>'0','err_msg'=>$language['err_msg'][0]);

$need=array('username','password');
foreach($need as $v){
	if(!isset($_POST[$v])){
		$re['api_state']='fail';
		$re['api_msg']=$language['lack_params'].':'.$v;
		return_api($re);
	}

}



$sql="select `id`,`password` from ".$pdo->index_pre."user where `username`='".$_POST['username']."' limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){
	$re['api_state']='fail';
	$re['api_msg']='username'.$language['not_exist'];
	return_api($re);			
}
if(de_safe_str($r['password'])!=$_POST['password']){
	$re['api_state']='fail';
	$re['api_msg']='password'.$language['err'];
	return_api($re);			
}

$code=index_create_qr_pay($pdo,$_POST['username']);
if($code==''){
	$re['api_state']='fail';
	$re['api_msg']='code crate fail';	
}else{
	$re['code']='6666_'.$code;
	$re['bar_img']='http://'.$config['web']['domain'].'/plugin/barcode/buildcode.php?codebar=BCGcode128&text=6666_'.$code;
	$re['qr_img']='http://'.$config['web']['domain'].'/plugin/qrcode/index.php?text=6666_'.$code;
	$re['api_state']='success';
	$re['api_msg']=$language['success'];
}
return_api($re);


