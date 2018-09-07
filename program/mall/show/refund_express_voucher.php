<?php
$id=intval(@$_GET['id']);
if($id==0){echo 'id err';return false;}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token']['mall::my_order']=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token']['mall::my_order']."&target=mall::my_order&act=express_voucher&id=".$id;
$sql="select `express_voucher`,`buyer`,`id` from ".self::$table_pre."order where `id`=".$id;
$r=$pdo->query($sql,2)->fetch(2);
$r=de_safe_str($r);
if(@$r['id']==''){echo self::$language['inoperable']; return false;}
if($r['buyer']!=$_SESSION['monxin']['username']){echo self::$language['inoperable']; return false;}
$module['express_voucher']=$r['express_voucher'];
if($module['express_voucher']!=''){$module['express_voucher']='<a href="./program/mall/img/'.$module['express_voucher'].'" target="_blank"><img class=voucher_img src="./program/mall/img/'.$module['express_voucher'].'" /></a>';}


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
