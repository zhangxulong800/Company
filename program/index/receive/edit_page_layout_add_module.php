<?php
$act=@$_GET['act'];
if($act=='show_edit_button'){
	echo "<a href=# class=edit_page_layout_button title=".self::$language['edit'].self::$language['this_page'].">&nbsp;</a>";
	exit;	
}

if($act=='add_module'){
	//echo $_POST['module_name'];
	$url=@$_GET['url'];
	$area=@$_GET['area'];
	$module_name=@$_POST['module_name'];
	if($area=='layout'){
		$sql="select `layout` from ".$pdo->index_pre."page where `url`='$url'";
		$r=$pdo->query($sql,2)->fetch(2);
		$area=$r['layout'];	
	}
	
	if(!in_array($area,array('head','bottom','full','left','right'))){exit("{'state':'fail','info':'<span class=fail>area err</span>'}");}
	$sql="update ".$pdo->index_pre."page set `$area`=CONCAT(`$area`,',".$module_name."') where `url`='".$url."'";
	if($_COOKIE['monxin_device']=='phone'){
		$sql="update ".$pdo->index_pre."page set `phone`=CONCAT(`phone`,',".$module_name."') where `url`='".$url."'";
	}
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
	
	exit;	
}
	