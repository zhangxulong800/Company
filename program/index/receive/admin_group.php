<?php
		foreach($_GET as $key=>$v){
			if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
		}
		$_GET['id']=intval(@$_GET['id']);
		$_GET['parent']=intval(@$_GET['parent']);
		$_GET['sequence']=intval(@$_GET['sequence']);
		$_GET['credits']=intval(@$_GET['credits']);
		$_GET['reg_able']=intval(@$_GET['reg_able']);
		$_GET['require_check']=intval(@$_GET['require_check']);
		$_GET['require_login']=intval(@$_GET['require_login']);
		$_GET['name']=safe_str(@$_GET['name']);
		$act=$_GET['act'];
		if($act=='add'){
			if($_GET['parent']>0){
				$sql="select count(id) as c from ".$pdo->index_pre."group where `id`='".$_GET['parent']."'";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['c']==0){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['parent_not_exist']."'}");}
			}else{exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['parent_not_exist']."'}");}
			$sql="insert into ".$pdo->index_pre."group (`parent`,`name`,`sequence`,`reg_able`,`require_check`,`require_login`,`credits`) values ('".$_GET['parent']."','".$_GET['name']."','".$_GET['sequence']."','".$_GET['reg_able']."','".$_GET['require_check']."','".$_GET['require_login']."','".$_GET['credits']."')";
			if($pdo->exec($sql)){
				$sql="update ".$pdo->index_pre."group set `deep`='".$this->get_group_deep($pdo,$_GET['parent'])."' where `id`='".$pdo->lastInsertId()."'";
				$pdo->exec($sql);
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','id':'".$pdo->lastInsertId()."'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		}
		if($act=='update'){
			$sql="update ".$pdo->index_pre."group set `name`='".$_GET['name']."',`sequence`='".$_GET['sequence']."',`credits`='".$_GET['credits']."',`reg_able`='".$_GET['reg_able']."',`require_check`='".$_GET['require_check']."',`require_login`='".$_GET['require_login']."' where `id`='".$_GET['id']."'";
			//echo $sql;
			if($pdo->exec($sql)){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
			}
		}
		if($act=='del'){
			if(!is_numeric($_GET['id'])){exit();}
			$sql="select count(id) as c from ".$pdo->index_pre."group where `parent`='".$_GET['id']."'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['have_sub']."'}");}
			
			$sql="select count(id) as c from ".$pdo->index_pre."user where `group`='".$_GET['id']."'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['have_user']."'}");}
			
			$sql="delete from ".$pdo->index_pre."group where `id`='".$_GET['id']."'";
			if($pdo->exec($sql)){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		
		}
		if($act=='del_select'){
			$ids=@$_GET['ids'];
			if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
			$ids=explode("|",$ids);
			$ids=array_filter($ids);
			$success='';
			foreach($ids as $id){
				$id=intval($id);
				$sql="select count(id) as c from ".$pdo->index_pre."group where `parent`='$id'";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['c']==0){
					$sql="select count(id) as c from ".$pdo->index_pre."user where `group`='$id'";
					$r=$pdo->query($sql,2)->fetch(2);
					if($r['c']==0){
						$sql="delete from ".$pdo->index_pre."group where `id`='$id'";
						if($pdo->exec($sql)){$success.=$id."|";}
					}
				}
			}
			$success=trim($success,"|");	
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}
		if($act=='submit_select'){
			//var_dump($_POST);	
			$success='';
			foreach($_POST as $v){
				$v['id']=intval($v['id']);
				$v['sequence']=intval($v['sequence']);
				$v['credits']=intval($v['credits']);
				$v['reg_able']=intval($v['reg_able']);
				$v['require_check']=intval($v['require_check']);
				$v['require_login']=intval($v['require_login']);
				$v['name']=safe_str($v['name']);
				$sql="update ".$pdo->index_pre."group set `name`='".$v['name']."',`sequence`='".$v['sequence']."',`credits`='".$v['credits']."',`reg_able`='".$v['reg_able']."',`require_check`='".$v['require_check']."',`require_login`='".$v['require_login']."' where `id`='".$v['id']."'";
				if($pdo->exec($sql)){$success.=$v['id']."|";}
			}
			$success=trim($success,"|");	
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}