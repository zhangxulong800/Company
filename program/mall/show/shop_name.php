<?php
$module['shop_master']=0;
if(isset($_SESSION['monxin']['username'])){
	if($_SESSION['monxin']['username']==SHOP_MASTER){
		$module['shop_master']=1;	
	}else{
		$module['shop_master']=0;
	}
		
}
if(SHOP_ID==0){return false;}
if($_GET['monxin']=='mall.shop_index' && !isset($_GET['shop_id'])){header('location:./index.php?monxin=mall.shop_index&shop_id='.SHOP_ID);exit;}

$sql="select `state` from ".self::$table_pre."shop where `id`=".SHOP_ID;
$r=$pdo->query($sql,2)->fetch(2);
if($r['state']==''){echo '<div style="line-height:100px;text-align:center;font-size:30px; font-weight:bold;">'.self::$language['shop'].self::$language['not_exist'].'</div>';exit();}
if($r['state']!=2){echo '<div style="line-height:100px;text-align:center;font-size:30px; font-weight:bold;">'.self::$language['shop'].self::$language['shop_state'][$r['state']].'</div>';exit();}

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$sql="select `id`,`name`,`domain`,`evaluation_0`,`evaluation_1`,`evaluation_2`,`talk_type`,`talk_account`,`deposit`,`position`,`username`,`credits_rate`,`return_credits`,`pay_money` from ".self::$table_pre."shop where `id`=".SHOP_ID;
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){echo 'no shop';return false;}
$module['name']=$r['name'];
$module['credits_rate']=str_replace('{v}',$r['credits_rate'],self::$language['shop_credits_rate']);
if($r['return_credits']>0){$module['credits_rate'].=','.$r['pay_money'].self::$language['yuan_2'].self::$language['give'].$r['return_credits'].self::$language['credits'];}


$_POST['shop_name']=$r['name'];
$_POST['shop_position']=$r['position'];
$temp=explode(',',$r['position']);
$_POST['shop_latlng']=@$temp[1].','.$temp[0];

if($r['evaluation_2']==0 && $r['evaluation_0']==0){
	$module['satisfaction']=100;
}elseif($r['evaluation_0']==0 && $r['evaluation_2']!=0){
	$module['satisfaction']=0;
}else{
	$module['satisfaction']=intval($r['evaluation_0']/($r['evaluation_0']+$r['evaluation_2'])*100);
}
$module['talk']='';
if($r['talk_account']!=''){
	$sql="select `code` from ".self::$table_pre."talk where `id`=".$r['talk_type'];
	$r2=$pdo->query($sql,2)->fetch(2);
	$r2=de_safe_str($r2);
	$account=explode(',',$r['talk_account']);
	//echo $r['talk_type'];
	foreach($account as $v){
		if($v==''){continue;}
		$module['talk'].=str_replace('{account}',$v,@$r2['code']);	
	}
	
}
$module['talk'].='<a talk="'.$r['username'].'" title="'.self::$language['site_msg'].'" class=talk></a>';

$module['deposit']=intval($r['deposit']);
$module['shop_id']=SHOP_ID;

$sql="select `id` from ".self::$table_pre."coupon where `shop_id`=".SHOP_ID." and `open`=1 and `draws`<`sum_quantity` limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
$module['coupon']='';
if($r['id']!=''){$module['coupon']='<a class="draws_coupon" href="./index.php?monxin=mall.coupon&shop_id='.SHOP_ID.'" title="'.self::$language['draws_coupon'].'"><img src=./templates/0/mall_shop/default/phone/img/coupon.png /></a>';}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);