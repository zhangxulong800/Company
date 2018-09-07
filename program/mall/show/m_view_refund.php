<?php
$id=intval(@$_GET['id']);
if($id==0){echo 'id err';return false;}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token']['mall::order_admin']=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token']['mall::order_admin']."&target=mall::order_admin&act=agree_return&id=".$id;
$module['cancel_option']='';
foreach(self::$language['order_return_option'] as $v){
	$module['cancel_option'].='<option value="'.$v.'">'.$v.'</option>';	
}
$sql="select `actual_money`,`express_cost_buyer`,`express_cost_seller`,`refund_reason`,`refund_amount`,`refund_remark`,`refund_voucher`,`shop_id`,`id`,`state`,`express_voucher`,`add_time`,`send_time`,`receipt_time` from ".self::$table_pre."order where `id`=".$id;
$r=$pdo->query($sql,2)->fetch(2);
$r=de_safe_str($r);
if(@$r['id']==''){echo self::$language['inoperable']; return false;}
$module['add_time']=get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$r['add_time']);
$module['send_time']=get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$r['send_time']);
$module['receipt_time']=get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$r['receipt_time']);
$module['refund_reason']=$r['refund_reason'];
$module['refund_amount']=$r['refund_amount'];
$module['refund_remark']=rn_to_br($r['refund_remark']);
$module['refund_voucher']=$r['refund_voucher'];
$module['express_voucher']=$r['express_voucher'];
$module['actual_money']=$r['actual_money'];
$module['state']=$r['state'];
if($r['refund_amount']==0){$module['refund_amount']=$r['actual_money'];}
if($module['refund_voucher']!=''){$module['refund_voucher']='<a href="./program/mall/img/'.$module['refund_voucher'].'" target="_blank"><img class=voucher_img src="./program/mall/img/'.$module['refund_voucher'].'" /></a>';}

if($module['express_voucher']!=''){$module['express_voucher']='<a href="./program/mall/img/'.$module['express_voucher'].'" target="_blank"><img class=voucher_img src="./program/mall/img/'.$module['express_voucher'].'" /></a>';}
$module['express_cost']=$r['express_cost_buyer']+$r['express_cost_seller'];


		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
