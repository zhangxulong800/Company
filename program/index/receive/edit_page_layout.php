<?php
$act=@$_GET['act'];

if($act=='del'){
	$sql="delete from ".$pdo->index_pre."page where `id`='".intval(@$_GET['id'])."' and `made`='user'";
	if($pdo->exec($sql)){
		update_pages_file($pdo,$_GET['id']);
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}
}

if($act=='add'){
	$temp=explode('.',$_POST['url']);
	if(!is_dir('./program/'.$temp[0])){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." url err</span>'}");}
	$sql="select `id` from ".$pdo->index_pre."page where `url`='".$_POST['url']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." url ".self::$language['already_exists']."</span>'}");}
	//var_dump($_POST);
	//$_POST=safe_str($_POST);
	$sql="insert into ".$pdo->index_pre."page (`require_login`,`head`,`left`,`right`,`full`,`bottom`,`layout`,`target`,`url`,`tutorial`,`made`) values ('0','".$_POST['head']."','".$_POST['left']."','".$_POST['right']."','".$_POST['full']."','".$_POST['bottom']."','".$_POST['layout']."','".$_POST['target']."','".$_POST['url']."','".$_POST['tutorial']."','user')";
	if($pdo->exec($sql)){
		
		$dir=scandir('./program/'.$temp[0].'/language/');
		foreach($dir as $v){
			if(is_file('./program/'.$temp[0].'/language/'.$v)){
				//echo './program/'.$temp[0].'/language/'.$v.'<br />';
				$language=require('./program/'.$temp[0].'/language/'.$v);
				$language['pages'][$_POST['url']]['power_suggest']=$_POST['name'];
				$language['pages'][$_POST['url']]['name']=$_POST['name'];
				$language['pages'][$_POST['url']]['title']=$_POST['name'];
				$language['pages'][$_POST['url']]['keywords']=$_POST['name'];
				$language['pages'][$_POST['url']]['description']=$_POST['name'];
				file_put_contents('./program/'.$temp[0].'/language/'.$v,'<?php return '.var_export($language,true).'?>');
			}	
		}
		update_pages_file($pdo,$_POST['url']);
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}
	
}

if($act=='update_attribute'){
	$_GET['url']=@$_GET['url'];
	$_GET['old_module']=@$_GET['old_module'];
	$_GET['new_module']=@$_GET['new_module'];
	$_GET['new_module']=clear_attribute_dot($_GET['new_module']);
	if($_GET['url']=='' || $_GET['old_module']=='' || $_GET['new_module']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	$sql="select * from ".$pdo->index_pre."page where `url`='".$_GET['url']."'";
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
	
	$sql="update ".$pdo->index_pre."page set `head`='".$r['head']."',`left`='".$r['left']."',`right`='".$r['right']."',`full`='".$r['full']."',`bottom`='".$r['bottom']."' where `id`='".$r['id']."'";
	//echo $sql;
	if($_COOKIE['monxin_device']=='phone'){
		if(!(strpos($r['phone'],$_GET['old_module'])===false)){
			$r['phone']=str_replace($_GET['old_module'],$_GET['new_module'],$r['phone']);
		}
		$sql="update ".$pdo->index_pre."page set `phone`='".$r['phone']."' where `id`='".$r['id']."'";
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
	$sql="select `url`,`layout` from ".$pdo->index_pre."page where `id`=$id";	
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="update ".$pdo->index_pre."page set `head`='".$_POST['head']."',`left`='".$_POST['left']."',`right`='".$_POST['right']."',`full`='".$_POST['full']."',`bottom`='".$_POST['bottom']."',`phone`='".$_POST['phone']."',`layout`='".$_POST['layout']."',`target`='".$_POST['target']."',`tutorial`='".$_POST['tutorial']."',`authorize`='".$_POST['authorize']."' where `id`=$id";
	if($pdo->exec($sql)){
		update_pages_file($pdo,$r['url']);
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}
	
	
}





if($act=='show_edit_button'){
	echo "ok";
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
	$module_name=$module;
	$module=explode('.',$module);
	if(!file_exists('./program/'.$module[0].'/config.php')){exit('program '.self::$language['not_exist_file']);}
	$program_config=require('./program/'.$module[0].'/config.php');
	if(in_array($module_name,$program_config['program_unlogin_function_power'])){$require_login=0;}else{$require_login=1;}
	$path='./templates/'.$require_login.'/'.$module[0].'/'.$program_config['program']['template_'.$require_login].'/'.$_COOKIE['monxin_device'].'/'.$module[1].'.php';
	if(!file_exists($path)){exit('template '.self::$language['not_exist_file']);}
	header('location:./index.php?monxin=index.template_edit_file&path='.$path);
	exit();
}

if($act=='show_edit_button2'){
echo "<a href=# id=save_composing>".self::$language['save'].self::$composing."</a><span id=save_composing_state></span><br /><a href=# id=cancel_composing>".self::$language['cancel'].self::$language['composing']."</a>";
exit;	
}



if($act=='switch_composing'){
	$page=@$_GET['monxin'];
	if($page==''){$page='index.index';}
	$to=@$_GET['to'];
	$to=explode('_',$to);
	$layout=@$to[2];
	if(!in_array($layout,array('full','right','left'))){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
	$sql="select `layout`,`id` from ".$pdo->index_pre."page where `url`='$page'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['layout']==$layout){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
	$sql="update ".$pdo->index_pre."page set `layout`='$layout',`$layout`=`".$r['layout']."`,`".$r['layout']."`=`$layout` where `url`='$page'";
	//echo $sql;
	if($pdo->exec($sql)){
		if($layout!='full'){
			if($layout=='left'){$layout2='right';}else{$layout2='left';}
			$sql="update ".$pdo->index_pre."page set `$layout2`='' where `url`='$page' and `$layout`=`$layout2`";
			$pdo->exec($sql);
		}
		update_pages_file($pdo,$r['id']);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}
	
}

if($act=='save_composing'){
	//var_dump($_GET);
	//var_dump($_POST);
	$page=@$_GET['monxin'];
	if($page==''){$page='index.index';}
	//echo $page;
	$layout=@$_GET['layout'];
	if($layout!='full' && $layout!='left' && $layout!='right'){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
	foreach($_POST as $key=>$v){
		$temp=explode(',',$v);
		$temp=array_unique($temp);
		$temp=array_filter($temp);
		foreach($temp as $key2=>$v2){$temp[$key2]=preg_replace('/_/','.',$v2,1);}
		$v=implode($temp,',');
		$_POST[$key]=$v;		
	}	
	
	//var_dump($_POST);
	$_POST['m_head']=str_replace('index.circle_module,','',$_POST['m_head']);
	if($layout=='full'){
		if(in_array($page,array('mall.shop_index','mall.diypage_show','mall.shop_goods_list','mall.goods','mall.coupon',))){$_POST['m_full']='mall.layout';}
		$sql="update ".$pdo->index_pre."page set `head`='".$_POST['m_head']."',`bottom`='".$_POST['m_bottom']."',`full`='".$_POST['m_full']."' where `url`='".$page."'";
	}else{
		$sql="update ".$pdo->index_pre."page set `head`='".$_POST['m_head']."',`bottom`='".$_POST['m_bottom']."',`left`='".$_POST['m_left']."',`right`='".$_POST['m_right']."' where `url`='".$page."'";
	}
	
	if($_COOKIE['monxin_device']=='phone'){
		if(in_array($page,array('mall.shop_index','mall.diypage_show','mall.shop_goods_list','mall.goods','mall.coupon',))){$_POST['m_full']='mall.layout';}
		$sql="update ".$pdo->index_pre."page set `phone`='".$_POST['m_full']."' where `url`='".$page."'";
	}
	//echo $sql;
	if($pdo->exec($sql)){
		update_pages_file($pdo,$page);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}
	
	
		
}

		