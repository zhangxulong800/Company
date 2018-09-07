<?php
$act=@$_GET['act'];
if($act=='update'){
	$_GET['id']=intval(@$_GET['id']);
	if($_GET['id']==0){exit('id err');}
	$_GET['name']=@$_GET['name'];
	$_GET['description']=@$_GET['description'];
	if($_GET['description']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['name'].self::$language['is_null']."</span>','id':'description'}");}
	if($_GET['name']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['table_name'].self::$language['is_null']."</span>'}");}
	if(!is_passwd($_GET['name'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['table_name'].self::$language['only_letters_numbers_underscores']."</span>','id':'name''}");}
	
	if($_GET['inform_user']!=''){
		$_GET['inform_user']=safe_str($_GET['inform_user']);
		if(get_user_id($pdo,$_GET['inform_user'])==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['username_err']."</span>'}");}	
	}
	
	$sql="select `name` from ".self::$table_pre."table where `id`='".$_GET['id']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['name']!=$_GET['name']){
		if(field_exist($pdo,$pdo->sys_pre.'form_'.$_GET['name'],'id')){exit("{'state':'fail','info':'<span class=fail>".self::$language['table_name'].self::$language['already_exists']."</span>','id':'name'}");}
		$sql="RENAME TABLE  `".self::$table_pre.$r['name']."` TO  `".self::$table_pre.$_GET['name']."`";
		$pdo->exec($sql);
		if(!field_exist($pdo,$pdo->sys_pre.'form_'.$_GET['name'],'id')){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
	}
	
	
	$sql = "update ".self::$table_pre."table set `name`='".$_GET['name']."',`description`='".$_GET['description']."',`write_state`='".intval($_GET['write_state'])."',`read_state`='".intval($_GET['read_state'])."',`default_publish`='".intval($_GET['default_publish'])."',`authcode`='".intval($_GET['authcode'])."',`weixin_inform`='".intval($_GET['weixin_inform'])."',`email_inform`='".intval($_GET['email_inform'])."',`inform_user`='".$_GET['inform_user']."',`pay_money`='".intval($_GET['pay_money'])."' where `id`='".$_GET['id']."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}
		
		
}

if($act=='del'){
	$_GET['id']=intval(@$_GET['id']);
	if($_GET['id']==0){exit('id err');}
	$sql="select `name` from ".self::$table_pre."table where `id`='".$_GET['id']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['name']==''){exit("{'state':'fail','info':'<span class=fail>table is not exist</span>'}");}
	$name=$r['name'];
	$sql="select count(id) as c from ".self::$table_pre.$r['name']."";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']>0){exit("{'state':'fail','info':'<span class=fail>".self::$language['refuse_del_table']."</span>'}");}
	$sql="DROP TABLE `".self::$table_pre.$name."`";
	$pdo->exec($sql);
	if(field_exist($pdo,self::$table_pre.$name,'id')){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}else{
		$sql="delete from ".self::$table_pre."table where `id`='".$_GET['id']."'";
		$pdo->exec($sql);
		$sql="delete from ".self::$table_pre."field where `table_id`='".$_GET['id']."'";
		$pdo->exec($sql);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}
	
}
