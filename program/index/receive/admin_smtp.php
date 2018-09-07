<?php
		foreach($_GET as $key=>$v){
			if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
		}
		
		$username=safe_str(@$_GET['username']);
		$password=safe_str(@$_GET['password']);
		$url=safe_str(@$_GET['url']);
		$act=@$_GET['act'];
		$ids=@$_GET['ids'];
		$id=intval(@$_GET['id']);
		
		if($act=='test'){
			
			$sql="select `email` from ".$pdo->index_pre."user where `id`='".$_SESSION['monxin']['id']."'";
			$r=$pdo->query($sql,2)->fetch(2);
			$mail_info=get_mail_info($pdo,$r['email'],$id);
			require("./plugin/mail/class.phpmailer.php"); 
			//var_dump(self::$config);
			$web_name=self::$config['web']['name'];
			//echo $r['email'];
			$title=self::$language['email'].self::$language['test'];
			$content=self::$language['email'].self::$language['content'].'....';
			$send_r=sendmail($web_name,$r['email'],$title,$content,$mail_info);
			ob_clean(); 
			ob_end_flush(); 
			if($send_r){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>,".self::$language['test'].self::$language['email_msg'].self::$language['sent'].self::$language['to'].$r['email']."'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		}

		if($act=='add'){
			$temp=explode('.',$url);
			$postfix=@$temp[count($temp)-2].'.'.@$temp[count($temp)-1];
			$sql="insert into ".$pdo->index_pre."smtp (`username`,`password`,`url`,`postfix`) values ('$username','$password','$url','$postfix')";
			if($pdo->exec($sql)){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','id':'".$pdo->lastInsertId()."'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		}
		if($act=='update'){
			$temp=explode('.',$url);
			$postfix=$temp[count($temp)-2].'.'.$temp[count($temp)-1];
			$sql="update ".$pdo->index_pre."smtp set `postfix`='$postfix',`username`='$username',`password`='$password',`url`='$url' where `id`='$id'";
			if($pdo->exec($sql)){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		}

		if($act=='del'){
			if(!is_numeric($id)){exit();}
			$sql="delete from ".$pdo->index_pre."smtp where `id`='$id'";
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
				$sql="delete from ".$pdo->index_pre."smtp where `id`='$id'";
				if($pdo->exec($sql)){$success.=$id."|";}
			}
			$success=trim($success,"|");			
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}
		
		if($act=='submit_select'){
			//var_dump($_POST);	
			$success='';
			foreach($_POST as $v){
				$v['id']=intval($v['id']);
				$v['username']=safe_str($v['username']);
				$v['password']=safe_str($v['password']);
				$v['url']=safe_str($v['url']);
				$temp=explode('.',$v['url']);
				$postfix=$temp[count($temp)-2].'.'.$temp[count($temp)-1];

				$sql="update ".$pdo->index_pre."smtp set `postfix`='$postfix',`username`='".$v['username']."',`password`='".$v['password']."',`url`='".$v['url']."' where `id`='".$v['id']."'";
				if($pdo->exec($sql)){$success.=$v['id']."|";}
			}
			$success=trim($success,"|");			
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}