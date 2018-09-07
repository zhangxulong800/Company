<?php
		foreach($_GET as $key=>$v){
			if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
		}
		$act=@$_GET['act'];
		if($act=='add'){
			$_GET['variable']=safe_str($_GET['variable']);
			$_GET['default_value']=safe_str($_GET['default_value']);
			$sql="insert into ".$pdo->index_pre."user_set_item (`name`,`options`,`default_value`,`program`,`sequence`,`variable`) values ('".$_GET['name']."','".$_GET['options']."','".$_GET['default_value']."','index','".$_GET['sequence']."','".$_GET['variable']."')";
			if($pdo->exec($sql)){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		}
		
		
		if($act=='update'){
			$_GET['variable']=safe_str($_GET['variable']);
			$_GET['default_value']=safe_str($_GET['default_value']);
			$_GET['id']=intval(@$_GET['id']);
			$sql="update ".$pdo->index_pre."user_set_item set `default_value`='".$_GET['default_value']."',`name`='".$_GET['name']."',`options`='".$_GET['options']."',`sequence`='".$_GET['sequence']."',`variable`='".$_GET['variable']."' where `id`='".$_GET['id']."'";
			//echo $sql;
			if($pdo->exec($sql)){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
			}
		}
		if($act=='del'){
			$id=intval(@$_GET['id']);
			if($id<1){exit();}
			$sql="delete from ".$pdo->index_pre."user_set_item where `id`='$id'";
			if($pdo->exec($sql)){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		
		}
		
