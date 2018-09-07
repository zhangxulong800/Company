<?php
		$act=@$_GET['act'];
		$id=intval(@$_GET['id']);

		if($act=='resend'){
			$sql="select `state` from ".$pdo->index_pre."phone_msg where `id`='$id' and `sender`='".$_SESSION['monxin']['username']."'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['state']==1){send_sms(self::$config,$pdo,$id);}else{exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
			$sql="select `state` from ".$pdo->index_pre."phone_msg where `id`='$id' and `sender`='".$_SESSION['monxin']['username']."'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['state']==2){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		}
		if($act=='del'){
			$sql="update ".$pdo->index_pre."phone_msg set `state`='4' where `id`='$id' and `sender`='".$_SESSION['monxin']['username']."'";
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
				$sql="update ".$pdo->index_pre."phone_msg set `state`='4' where `id`='$id' and `sender`='".$_SESSION['monxin']['username']."'";
				if($pdo->exec($sql)){
					$success.=$id."|";
				}
			}
			$success=trim($success,"|");			
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}
