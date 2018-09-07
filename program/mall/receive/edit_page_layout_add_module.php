<?php
$act=@$_GET['act'];
if($act=='show_edit_button'){
	echo "<a href=# class=edit_page_layout_button title=".self::$language['edit'].self::$language['this_page'].">&nbsp;</a>";
	exit;	
}

if($act=='add_module'){
	//echo $_POST['module_name'];
	$url=safe_str(@$_GET['url']);
	$area=@$_GET['area'];
	$module_name=@$_POST['module_name'];
	if($area=='malllayout'){
		$sql="select `layout` from ".self::$table_pre."page where `shop_id`='".SHOP_ID."' and `url`='$url'";
		$r=$pdo->query($sql,2)->fetch(2);
		$area=$r['layout'];	
	}
	
	if(!in_array($area,array('head','full','left','right','bottom'))){exit("{'state':'fail','info':'<span class=fail>area err:".$area."</span>'}");}
	$sql="update ".self::$table_pre."page set `$area`=CONCAT(`$area`,',".$module_name."') where `shop_id`='".SHOP_ID."' and `url`='".$url."'";
	if($_COOKIE['monxin_device']=='phone'){
		$sql="update ".self::$table_pre."page set `phone`=CONCAT(`phone`,',".$module_name."') where `shop_id`='".SHOP_ID."' and `url`='".$url."'";
	}
	//file_put_contents('./test.txt',$sql);
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
	
	exit;	
}
	