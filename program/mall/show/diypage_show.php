<?php
$id=intval(@$_GET['id']);
if($id>0){
	$sql="select `title`,`content`,`phone_content`,`time`,`visit`,`id` from ".self::$table_pre."diypage where `id`='$id' and `visible`=1";
	$module=$pdo->query($sql,2)->fetch(2);
	if($module['id']==''){return  not_find();}

	if($_COOKIE['monxin_device']=='phone' && $module['phone_content']!=''){
		$module['content']=de_safe_str($module['phone_content']);
	}else{
		$module['content']=de_safe_str($module['content']);
	}
	
	$module['content']=str_replace('{shop_name}',$_POST['shop_name'],$module['content']);
	$module['content']=str_replace('{shopName}',$_POST['shop_name'],$module['content']);
	$module['content']=str_replace('{shop_position}',$_POST['shop_position'],$module['content']);
	$module['content']=str_replace('{shop_latlng}',$_POST['shop_latlng'],$module['content']);
	$module['content']=str_replace('{map_api}',self::$config['web']['map_api'],$module['content']);
	
	$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
	$module['count_url']="receive.php?target=".$method."&id=".$id;
	
	$module['position']="<span id=current_position_text>".self::$language['current_position']."</span><a href='./index.php?monxin=mall.shop_index&shop_id=".SHOP_ID."'><span id=visitor_position_icon>&nbsp;</span>".self::$config['shop_name']."</a>".$module['title'];

	require('./templates/0/'.$class.'_shop/'.self::$config['shop_template'].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php');	
}else{
	echo (self::$language['need_params']);
}
	echo '<div id="visitor_position_reset" style="display:none;"><span id=current_position_text>'.self::$language['current_position'].'</span><a href="./index.php"><span id=visitor_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a>'.$module['title'].'</div>';
			