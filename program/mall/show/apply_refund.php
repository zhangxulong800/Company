<?php
$id=intval(@$_GET['id']);
if($id==0){echo 'id err';return false;}
$sql="select `id` from ".self::$table_pre."refund where `order_id`=".$id;
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']!=''){echo '<div class=return_false>'.self::$language['part_refunded'].'</div>';return false;}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token']['mall::my_order']=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token']['mall::my_order']."&target=mall::my_order&act=apply_refund&id=".$id;
$module['cancel_option']='';
foreach(self::$language['order_return_option'] as $v){
	$module['cancel_option'].='<option value="'.$v.'">'.$v.'</option>';	
}
$sql="select `actual_money`,`express_cost_buyer`,`express_cost_seller`,`refund_reason`,`refund_amount`,`refund_remark`,`refund_voucher`,`buyer`,`id`,`state`,`pay_method`,`web_credits_money`,`cashier` from ".self::$table_pre."order where `id`=".$id;
$r=$pdo->query($sql,2)->fetch(2);
$r=de_safe_str($r);
if(@$r['id']==''){echo self::$language['inoperable']; return false;}
if($r['buyer']!=$_SESSION['monxin']['username']){echo self::$language['inoperable']; return false;}
if($r['pay_method']!='balance' && $r['pay_method']!='online_payment'){
	if($_COOKIE['monxin_device']=='pc'){
		echo self::$language['pay_method_str'].':<b>'.self::$language['pay_method'][$r['pay_method']].'</b>,'.self::$language['no_support_refund']; 
	}else{
		echo self::$language['pay_method_str'].':<b>'.self::$language['pay_method'][$r['pay_method']].'</b>,<br />'.self::$language['no_support_refund']; 
		echo '<style>#layout_top{display:none;}
	#layout_bottom{display:none;}
	#for_mall{display:none;}
	#index_user_position{display:none;}
	#mall_cart{display:none;}</style>';
	}
	return false;
}

if($r['cashier']!='monxin'){
	if($_COOKIE['monxin_device']=='pc'){
		echo '<b>'.self::$language['offline_purchase'].'</b>,'.self::$language['no_support_refund']; 
	}else{
		echo '<b>'.self::$language['offline_purchase'].'</b>,<br />'.self::$language['no_support_refund']; 
		echo '<style>#layout_top{display:none;}
	#layout_bottom{display:none;}
	#for_mall{display:none;}
	#index_user_position{display:none;}
	#mall_cart{display:none;}</style>';
	}
	return false;
}


$module['refund_reason']=$r['refund_reason'];
$module['refund_amount']=$r['refund_amount'];
$module['refund_remark']=$r['refund_remark'];
$module['refund_voucher']=$r['refund_voucher'];
$module['actual_money']=$r['actual_money']-$r['web_credits_money'];
$module['state']=$r['state'];
if($r['refund_amount']==0){$module['refund_amount']=$r['actual_money']-$r['web_credits_money'];}
if($module['refund_voucher']!=''){$module['refund_voucher']='<a href="./program/mall/img/'.$module['refund_voucher'].'" target="_blank"><img class=voucher_img src="./program/mall/img/'.$module['refund_voucher'].'" /></a>';}
$module['express_cost']=$r['express_cost_buyer']+$r['express_cost_seller'];


		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);

require "./plugin/html4Upfile/createHtml4.class.php";
$html4Upfile=new createHtml4();
echo '<div style="display:none;">';
$html4Upfile->echo_input("voucher",'100%','./temp/','true','false','jpg|gif|png|jpeg','2048','1');
echo '</div>';
//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');
//指定保存名时，要先设置权限 $_SESSION['replace_file']=true;  ，否则将无效
