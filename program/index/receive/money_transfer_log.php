<?php
		$act=@$_GET['act'];
		$id=intval(@$_GET['id']);
		if($act=='del'){
			$sql="delete from ".$pdo->index_pre."money_transfer where `id`='$id' and `username`='".$_SESSION['monxin']['username']."'";
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
				$sql="delete from ".$pdo->index_pre."money_transfer where `id`='$id' and `username`='".$_SESSION['monxin']['username']."'";
				if($pdo->exec($sql)){
					$success.=$id."|";
				}
			}
			$success=trim($success,"|");			
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}
