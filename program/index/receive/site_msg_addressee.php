<?php
		$act=@$_GET['act'];
		$id=intval(@$_GET['id']);
		if($act=='del'){
			$sql="select `addressee` from ".$pdo->index_pre."site_msg where `id`='$id'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['addressee']!=$_SESSION['monxin']['username']){exit('noPower');}
			
			$sql="update ".$pdo->index_pre."site_msg set `addressee_state`='3' where `id`='$id'";
				if($pdo->exec($sql)){
					echo("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
				}else{
					echo("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
				}


			
			$sql="select `sender_state` from ".$pdo->index_pre."site_msg where `id`='$id'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['sender_state']==3){
				$sql="update ".$pdo->index_pre."site_msg set `state`='4' where `id`='$id'";
				$pdo->exec($sql);
			}
		}
		
		if($act=='del_select'){
			$ids=safe_str(@$_GET['ids']);
			if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
			$ids=explode("|",$ids);
			$ids=array_filter($ids);
			$success='';
			foreach($ids as $id){
				$sql="select `addressee` from ".$pdo->index_pre."site_msg where `id`='$id'";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['addressee']!=$_SESSION['monxin']['username']){continue;}
				
				$id=intval($id);
				$sql="update ".$pdo->index_pre."site_msg set `addressee_state`='3' where `id`='$id'";
				if($pdo->exec($sql)){
					$success.=$id."|";
				}
				$sql="select `sender_state` from ".$pdo->index_pre."site_msg where `id`='$id'";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['sender_state']==3){
					$sql="update ".$pdo->index_pre."site_msg set `state`='4' where `id`='$id'";
					$pdo->exec($sql);
				}
			}
			$success=trim($success,"|");			
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}
