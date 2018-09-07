<?php 
$re=array('err_code'=>'0','err_msg'=>$language['err_msg'][0]);

$need=array('username','start','quantity','sequence');
foreach($need as $v){
	if(!isset($_POST[$v])){
		$re['api_state']='fail';
		$re['api_msg']=$language['lack_params'].':'.$v;
		return_api($re);
	}

}
if($_POST['sequence']!='desc' && $_POST['sequence']!='asc'){$_POST['sequence']='desc';}

$sql="select * from ".$pdo->index_pre."money_log where `username`='".$_POST['username']."' order by `id` ".$_POST['sequence']." limit ".$_POST['start'].",".$_POST['quantity']."";
$r=$pdo->query($sql,2);
$re['data']=array();
foreach($r as $v){
	$re['data'][$v['id']]=de_safe_str($v);
	
}
$re['api_state']='success';
$re['api_msg']=$language['success'];

return_api($re);


