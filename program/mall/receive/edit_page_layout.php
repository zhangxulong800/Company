<?php
$act=@$_GET['act'];
if($act=='update_attribute'){
	$_GET['url']=safe_str(@$_GET['url']);
	$_GET['old_module']=@$_GET['old_module'];
	$_GET['new_module']=@$_GET['new_module'];
	if($_GET['url']=='' || $_GET['old_module']=='' || $_GET['new_module']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	$sql="select * from ".self::$table_pre."page where `shop_id`='".SHOP_ID."' and `url`='".$_GET['url']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['url']==''){exit("{'state':'fail','info':'<span class=fail>url err</span>'}");}
	if(!(strpos($r['head'],$_GET['old_module'])===false)){
		$r['head']=str_replace($_GET['old_module'],$_GET['new_module'],$r['head']);
	}	
	if(!(strpos($r['left'],$_GET['old_module'])===false)){
		$r['left']=str_replace($_GET['old_module'],$_GET['new_module'],$r['left']);
	}	
	if(!(strpos($r['right'],$_GET['old_module'])===false)){
		$r['right']=str_replace($_GET['old_module'],$_GET['new_module'],$r['right']);
	}	
	if(!(strpos($r['full'],$_GET['old_module'])===false)){
		$r['full']=str_replace($_GET['old_module'],$_GET['new_module'],$r['full']);
	}	
	if(!(strpos($r['bottom'],$_GET['old_module'])===false)){
		$r['bottom']=str_replace($_GET['old_module'],$_GET['new_module'],$r['bottom']);
	}	
	
	$sql="update ".self::$table_pre."page set `head`='".$r['head']."',`left`='".$r['left']."',`right`='".$r['right']."',`full`='".$r['full']."',`bottom`='".$r['bottom']."' where `shop_id`='".SHOP_ID."' and `id`='".$r['id']."'";
	//echo $sql;
	if($_COOKIE['monxin_device']=='phone'){
		if(!(strpos($r['phone'],$_GET['old_module'])===false)){
			$r['phone']=str_replace($_GET['old_module'],$_GET['new_module'],$r['phone']);
		}
		$sql="update ".self::$table_pre."page set `phone`='".$r['phone']."' where `id`='".$r['id']."'";
	}
	
	
	if($pdo->exec($sql)){
		update_pages_file($pdo,$r['url']);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}
	

}



if($act=='update'){
	$id=$_POST['id'];
	$sql="select `url`,`layout` from ".self::$table_pre."page where `shop_id`='".SHOP_ID."' and `id`=$id";	
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="update ".self::$table_pre."page set `head`='".$_POST['head']."',`left`='".$_POST['left']."',`right`='".$_POST['right']."',`full`='".$_POST['full']."',`bottom`='".$_POST['bottom']."',`phone`='".$_POST['phone']."',`layout`='".$_POST['layout']."' where  `shop_id`='".SHOP_ID."' and `id`=$id";
	if($pdo->exec($sql)){
		update_pages_file($pdo,$r['url']);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}
	
	
}





if($act=='show_edit_button'){
	echo "<a href=# class=edit_page_layout_button title=".self::$language['edit'].self::$language['this_page'].">&nbsp;</a>";
	exit;	
}
if($act=='go_module_content'){
	$module=@$_GET['module'];
	$module=explode('_append_',$module);
	$module=$module[0];
	$module=preg_replace('/_/','.',$module,1);
	$id=get_match_single('/_(\d{1,})/',$module);
	if(is_numeric($id)){
		$module2=str_replace('_'.$id,'',$module);
	}else{
		$args=get_match_single('/(\(.*\))/',$module);
		if($args!=''){
			$attribute=format_attribute($args);
			$id=$attribute['id'];
			$module2=preg_replace('/(\(.*\))/','',$module);
		}else{
			$module2=$module;
			if(isset($_GET['id'])){$id=$_GET['id'];}
		}
		
		
	}
	
	//exit($id);
	$temp=explode('.',$module);
	if(!file_exists('./program/'.$temp[0].'/module_config.php')){exit('module_config.php '.self::$language['not_exist_file']);}
	
	$m_config=require('./program/'.$temp[0].'/module_config.php');
	//echo $module.'='.$module2;
	//var_dump($m_config);
	foreach($m_config as $key=>$v){
		$key=preg_replace('/(\(.*\))/','',$key);
		if($module==$key || $module2==$key){
			if($v['edit_url']!=''){
				//exit($v['edit_url'].$id);
				header('location:'.$v['edit_url'].$id);exit;	
			}	
		}	
	}
	
	
	exit(self::$language['inoperable']);
}



if($act=='go_module_template'){
	$module=@$_GET['module'];
	$module=explode('_append_',$module);
	$module=$module[0];
	$module=preg_replace('/_/','.',$module,1);
	$module=explode('.',$module);
	if(!file_exists('./program/'.$module[0].'/config.php')){exit('program '.self::$language['not_exist_file']);}
	$program_config=require('./program/'.$module[0].'/config.php');
	if(!file_exists('./templates/'.$module[0].'/'.$program_config['program']['template_1'].'/'.$_COOKIE['monxin_device'].'/'.$module[1].'.php')){exit('template '.self::$language['not_exist_file']);}
	header('location:./index.php?monxin=index.template_edit_file&path='.$module[0].'/'.$program_config['program']['template_1'].'/'.$_COOKIE['monxin_device'].'/'.$module[1].'.php&refresh=monxin');exit;
}

if($act=='show_edit_button2'){
echo "<a href=# id=save_composing>".self::$language['save'].self::$composing."</a><span id=save_composing_state></span><br /><a href=# id=cancel_composing>".self::$language['cancel'].self::$language['composing']."</a>";
exit;	
}



if($act=='switch_composing'){
	$to=@$_GET['to'];
	$to=explode('_',$to);
	$layout=@$to[2];
	$page=safe_str($_GET['monxin']);
	if(!in_array($layout,array('full','right','left'))){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
	$sql="select `layout`,`id` from ".self::$table_pre."page where `shop_id`='".SHOP_ID."' and  `url`='$page'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['layout']==$layout){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
	$sql="update ".self::$table_pre."page set `layout`='$layout',`$layout`=`".$r['layout']."`,`".$r['layout']."`=`$layout` where `shop_id`='".SHOP_ID."' and `url`='$page'";
	//echo $sql;
	if($pdo->exec($sql)){
		if($layout!='full'){
			if($layout=='left'){$layout2='right';}else{$layout2='left';}
			$sql="update ".self::$table_pre."page set `$layout2`='' where `shop_id`='".SHOP_ID."' and `url`='$page' and `$layout`=`$layout2`";
			$pdo->exec($sql);
		}
		update_pages_file($pdo,$r['id']);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}
	
}

if($act=='save_composing'){
	//var_dump($_POST);
	$page=@$_GET['monxin'];
	//echo $page;
	$layout=@$_GET['malllayout'];
	//var_dump($layout);
	if($layout!='full' && $layout!='left' && $layout!='right'){exit("{'state':'fail','info':'<span class=fail>".$layout.self::$language['fail']."</span>'}");}
	$_POST=safe_str($_POST);
	foreach($_POST as $key=>$v){
		$temp=explode(',',$v);
		$temp=array_unique($temp);
		$temp=array_filter($temp);
		foreach($temp as $key2=>$v2){$temp[$key2]=preg_replace('/_/','.',$v2,1);}
		$v=implode($temp,',');
		$_POST[$key]=$v;		
	}	
	
	//var_dump($_POST);
	if($layout=='full'){
		$sql="update ".self::$table_pre."page set `head`='".$_POST['m_head']."',`full`='".$_POST['m_full']."',`bottom`='".$_POST['m_bottom']."' where  `shop_id`='".SHOP_ID."' and `url`='$page' and `url`='".$page."'";
	}else{
		$sql="update ".self::$table_pre."page set `head`='".$_POST['m_head']."',`left`='".$_POST['m_left']."',`right`='".$_POST['m_right']."',`bottom`='".$_POST['m_bottom']."' where  `shop_id`='".SHOP_ID."' and `url`='$page' and `url`='".$page."'";
	}
	
	if($_COOKIE['monxin_device']=='phone'){
		$sql="update ".self::$table_pre."page set `phone`='".$_POST['m_full']."' where  `shop_id`='".SHOP_ID."' and `url`='$page' and `url`='".$page."'";
	}
	//echo $sql;
	if($pdo->exec($sql)){
		update_pages_file($pdo,$page);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}
	
	
		
}

		