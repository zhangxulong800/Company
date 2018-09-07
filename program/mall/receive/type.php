<?php
self::update_config_file('type_update_time',time());

		foreach($_GET as $key=>$v){
			if($key=='url'){continue;}
			if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
		}
		$act=@$_GET['act'];
		if($act=='add'){
			$_GET['parent']=intval(@$_GET['parent']);
			if($_GET['parent']>0){
				$sql="select count(id) as c from ".self::$table_pre."type where `id`='".$_GET['parent']."'";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['c']==0){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['parent_not_exist']."'}");}
			}
			$_GET['sequence']=intval(@$_GET['sequence']);
			$_GET['visible']=intval(@$_GET['visible']);
			$_GET['name']=safe_str(@$_GET['name']);
			$_GET['url']=safe_str(@$_GET['url']);
			$sql="insert into ".self::$table_pre."type (`parent`,`name`,`url`,`sequence`,`visible`,`t_cid`) values ('".$_GET['parent']."','".$_GET['name']."','".$_GET['url']."','".$_GET['sequence']."','".$_GET['visible']."','".intval($_GET['t_cid'])."')";
			//file_put_contents('t.txt',$sql);
			if($pdo->exec($sql)){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','id':'".$pdo->lastInsertId()."'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		}
		if($act=='update'){
			$_GET['id']=intval(@$_GET['id']);
			$_GET['parent']=intval(@$_GET['parent']);
			$_GET['sequence']=intval(@$_GET['sequence']);
			$_GET['visible']=intval(@$_GET['visible']);
			$_GET['name']=safe_str(@$_GET['name']);
			$_GET['url']=safe_str(@$_GET['url']);
			$_GET['t_cid']=intval(@$_GET['t_cid']);
			$sql="update ".self::$table_pre."type set `parent`='".$_GET['parent']."',`name`='".$_GET['name']."',`url`='".$_GET['url']."',`sequence`='".$_GET['sequence']."',`visible`='".$_GET['visible']."',`t_cid`='".$_GET['t_cid']."' where `id`='".$_GET['id']."'";
			if($pdo->exec($sql)){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
			}
		}
		if($act=='update_visible'){
			$_GET['id']=intval(@$_GET['id']);
			$_GET['visible']=intval(@$_GET['visible']);
			$sql="update ".self::$table_pre."type set `visible`='".$_GET['visible']."' where `id`='".$_GET['id']."'";	
			$pdo->exec($sql);
			exit();
		}
		if($act=='del'){
			$id=intval(@$_GET['id']);
			if($id<1){exit();}
			$sql="select `id` from ".self::$table_pre."type where `parent`='$id' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['have_sub']."'}");}
			
			$sql="select `id` from ".self::$table_pre."goods where `type`='$id' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['have_sub']."'}");}
			
			$sql="delete from ".self::$table_pre."type where `id`='$id'";
			if($pdo->exec($sql)){
				@safe_unlink('./program/mall/type_icon/'.$id.'.png');
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
				$sql="select `id` from ".self::$table_pre."type where `parent`='$id' limit 0,1";
				$r=$pdo->query($sql,2)->fetch(2);
				
				$sql="select `id` from ".self::$table_pre."goods where `type`='$id' limit 0,1";
				$r2=$pdo->query($sql,2)->fetch(2);
				
				if($r['id']=='' && $r2['id']==''){
					$sql="delete from ".self::$table_pre."type where `id`='$id'";
					if($pdo->exec($sql)){@safe_unlink('./program/mall/type_icon/'.$id.'.png');$success.=$id."|";}
				}
			}
			$success=trim($success,"|");			
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}
		if($act=='operation_visible'){
			$ids=@$_GET['ids'];
			if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
			$ids=str_replace("|",",",$ids);
			$ids=trim($ids,",");
			$ids=explode(",",$ids);
			$ids=array_map('intval',$ids);
			$temp='';
			foreach($ids as $id){
				$temp.=$id.",";	
			}
			$ids=trim($temp,","); 
			$_GET['visible']=intval(@$_GET['visible']);
			$sql="update ".self::$table_pre."type set `visible`='".$_GET['visible']."' where `id` in ($ids)";
			$pdo->exec($sql);
			
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>'}");
		}
		
		if($act=='submit_select'){
			$success='';
			foreach($_POST as $v){
				$v['id']=intval($v['id']);
				$v['parent']=intval($v['parent']);
				$v['sequence']=intval($v['sequence']);
				$v['name']=safe_str($v['name']);
				$v['url']=safe_str($v['url']);
				$v['t_cid']=intval($v['t_cid']);
				$sql="update ".self::$table_pre."type set `parent`='".$v['parent']."',`name`='".$v['name']."',`url`='".$v['url']."',`sequence`='".$v['sequence']."',`t_cid`='".$v['t_cid']."' where `id`='".$v['id']."'";
				if($pdo->exec($sql)){$success.=$v['id']."|";}
			}
			$success=trim($success,"|");			
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}
		
