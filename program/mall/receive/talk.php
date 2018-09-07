<?php
		foreach($_GET as $key=>$v){
			if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
		}
		$act=@$_GET['act'];
		if($act=='add'){
			$_GET['name']=safe_str($_GET['name']);
			$_GET['code']=safe_str($_GET['code']);
			$_GET['sequence']=intval($_GET['sequence']);
			$sql="insert into ".self::$table_pre."talk (`name`,`code`,`sequence`) values ('".$_GET['name']."','".$_GET['code']."','".$_GET['sequence']."')";
			if($pdo->exec($sql)){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		}
		
		
		if($act=='update'){
			$_GET['name']=safe_str($_GET['name']);
			$_GET['code']=safe_str($_GET['code']);
			$_GET['sequence']=intval($_GET['sequence']);
			$_GET['id']=intval(@$_GET['id']);
			$sql="update ".self::$table_pre."talk set `name`='".$_GET['name']."',`code`='".$_GET['code']."',`sequence`='".$_GET['sequence']."' where `id`='".$_GET['id']."'";
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
			$sql="select count(id) as c from ".self::$table_pre."shop where `talk_type`=".$id;
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['c']>0){exit("{'state':'fail','info':'<span class=fail>".self::$language['have_been_in_use_cannot_be_deleted']."</span>'}");}
			$sql="delete from ".self::$table_pre."talk where `id`='$id'";
			if($pdo->exec($sql)){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		
		}
		
