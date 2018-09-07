<?php
		$group_id=intval(@$_GET['group_id']);
		$id=intval(@$_GET['id']);
		$act=@$_GET['act'];
		
		function update_table_group($pdo,$id){
			$time=time();
			$editor=$_SESSION['monxin']['id'];
			$sql="update ".$pdo->sys_pre."slider_group set `editor`='$editor',`time`=$time where `id`='".$id."'";
			return ($pdo->exec($sql));	
		}
		
		if($act=='add'){
			$_GET['name']=safe_str(@$_GET['name']);
			$_GET['url']=safe_str(@$_GET['url']);
			$sql="insert into ".self::$table_pre."img (`name`,`url`,`group_id`) values ('".$_GET['name']."','".$_GET['url']."','".$_GET['group_id']."')";
			//echo $sql;
			if($pdo->exec($sql)){
				//echo $_GET['img'];
				if(file_exists('./temp/'.$_GET['img'])){safe_rename('./temp/'.$_GET['img'],'./program/slider/img/'.$pdo->lastInsertId().'.jpg');}
				update_table_group($pdo,$group_id);
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','id':'".$pdo->lastInsertId()."'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		}
		
		
		if($act=='update'){
			$time=time();
			$editor=$_SESSION['monxin']['id'];
			$_GET['name']=safe_str(@$_GET['name']);
			$_GET['url']=safe_str(@$_GET['url']);
			$_GET['target']=safe_str(@$_GET['open_target']);
			$_GET['sequence']=intval(@$_GET['sequence']);
			$sql="update ".self::$table_pre."img set `name`='".$_GET['name']."',`url`='".$_GET['url']."',`target`='".$_GET['target']."',`sequence`='".$_GET['sequence']."' where `id`='".$_GET['id']."'";
			if($pdo->exec($sql)){
				update_table_group($pdo,$group_id);
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
			}
		}
		if($act=='del'){
			$sql="delete from ".self::$table_pre."img where `id`='$id'";
			if($pdo->exec($sql)){
				update_table_group($pdo,$group_id);
				@safe_unlink('./program/slider/img/'.$id.'.jpg');
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		}
		
		if($act=='del_select'){
			$ids=safe_str(@$_GET['ids']);
			if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
			$ids=explode("|",$ids);
			$ids=array_filter($ids);
			$success='';
			foreach($ids as $id){
				$id=intval($id);
				$sql="delete from ".self::$table_pre."img where `id`='$id'";
				if($pdo->exec($sql)){
					update_table_group($pdo,$group_id);
					@safe_unlink('./program/slider/img/'.$id.'.jpg');
					$success.=$id."|";
				}
			}
			$success=trim($success,"|");	
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload(); class=refresh>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}
		
		if($act=='submit_select'){
			//var_dump($_POST);	
			$time=time();
			$editor=$_SESSION['monxin']['id'];
			$success='';
			foreach($_POST as $v){
				$v['id']=intval($v['id']);
				$v['sequence']=intval($v['sequence']);
				$v['url']=safe_str($v['url']);
				$v['target']=safe_str($v['target']);
				$v['name']=safe_str($v['name']);
				$sql="update ".self::$table_pre."img set `name`='".$v['name']."',`url`='".$v['url']."',`target`='".$v['target']."',`sequence`='".$v['sequence']."' where `id`='".$v['id']."'";
				if($pdo->exec($sql)){$success.=$v['id']."|";}
			}
			$success=trim($success,"|");	
			update_table_group($pdo,$group_id);	
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload(); class=refresh>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}
		
