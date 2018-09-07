<?php

		foreach($_GET as $key=>$v){
			if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
		}
		
		$name=safe_str(@$_GET['name']);
		$url=safe_str(@$_GET['url']);
		$open_target=safe_str(@$_GET['open_target']);
		$sequence=intval(@$_GET['sequence']);
		$visible=intval(@$_GET['visible']);
		$id=intval(@$_GET['id']);
		$parent_id=intval(@$_GET['parent_id']);
		$act=@$_GET['act'];
		$ids=@$_GET['ids'];

		if($act=='add'){
			$sql="insert into ".$pdo->sys_pre."menu_menu (`name`,`url`,`sequence`,`parent_id`,`open_target`,`visible`) values ('$name','$url','$sequence','$parent_id','$open_target','$visible')";
			if($pdo->exec($sql)){
				
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','id':'".$pdo->lastInsertId()."'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		}
		if($act=='update'){
			$sql="update ".$pdo->sys_pre."menu_menu set `parent_id`='$parent_id',`name`='$name',`url`='$url',`sequence`='$sequence',`open_target`='$open_target',`visible`='$visible' where `id`='$id'";
			if($pdo->exec($sql)){
				
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
			}
		}
		if($act=='update_visible'){
			$sql="update ".$pdo->sys_pre."menu_menu set `visible`='$visible' where `id`='$id'";	
			$pdo->exec($sql);
			
			exit();
		}
		if($act=='del'){
			if(!is_numeric($id)){exit();}
			$sql="select count(id) as c from ".$pdo->sys_pre."menu_menu where `parent_id`='$id'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['have_sub']."'}");}
			$sql="delete from ".$pdo->sys_pre."menu_menu where `id`='$id'";
			if($pdo->exec($sql)){
				
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		
		}
		if($act=='del_select'){
			if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
			$ids=explode("|",$ids);
			$ids=array_filter($ids);
			$success='';
			foreach($ids as $id){
				$sql="select count(id) as c from ".$pdo->sys_pre."menu_menu where `parent_id`='$id'";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['c']==0){
					$sql="delete from ".$pdo->sys_pre."menu_menu where `id`='$id'";
					if($pdo->exec($sql)){$success.=$id."|";}
				}
			}
			$success=trim($success,"|");
						
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}
		if($act=='operation_visible'){
			if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
			$ids=str_replace("|",",",$ids);
			$ids=trim($ids,",");
			$sql="update ".$pdo->sys_pre."menu_menu set `visible`='$visible' where `id` in ($ids)";
			$pdo->exec($sql);
			
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>'}");
		}
		
		if($act=='submit_select'){
			
			$success='';
			foreach($_POST as $v){
				//var_dump($v);
				$v['id']=intval($v['id']);
				$v['parent_id']=intval($v['parent_id']);
				$v['sequence']=intval($v['sequence']);
				$v['open_target']=safe_str($v['open_target']);
				//echo $v['id'];
				$v['name']=safe_str($v['name']);
				$v['url']=safe_str($v['url']);
				
				$sql="update ".$pdo->sys_pre."menu_menu set `parent_id`='".$v['parent_id']."',`name`='".$v['name']."',`url`='".$v['url']."',`open_target`='".$v['open_target']."',`sequence`='".$v['sequence']."' where `id`='".$v['id']."'";
				if($pdo->exec($sql)){$success.=$v['id']."|";}
			}
			$success=trim($success,"|");	
					
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}