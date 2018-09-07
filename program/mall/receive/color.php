<?php
		foreach($_GET as $key=>$v){
			if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
		}
		$act=@$_GET['act'];
		if($act=='add'){
			$_GET['name']=safe_str($_GET['name']);
			$_GET['sequence']=intval($_GET['sequence']);
			$sql="insert into ".self::$table_pre."color (`name`,`sequence`) values ('".$_GET['name']."','".$_GET['sequence']."')";
			if($pdo->exec($sql)){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		}
		
		
		if($act=='update'){
			$_GET['name']=safe_str($_GET['name']);
			$_GET['sequence']=intval($_GET['sequence']);
			$_GET['id']=intval(@$_GET['id']);
			$sql="update ".self::$table_pre."color set `name`='".$_GET['name']."',`sequence`='".$_GET['sequence']."' where `id`='".$_GET['id']."'";
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
			$sql="delete from ".self::$table_pre."color where `id`='$id'";
			if($pdo->exec($sql)){
				@safe_unlink('./program/mall/color_icon/'.$id.'.png');
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		
		}
		
