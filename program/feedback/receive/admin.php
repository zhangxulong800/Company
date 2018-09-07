<?php
		$act=@$_GET['act'];
		$id=intval(@$_POST['id']);
		if($act=='update'){
			$time=time();
			$answer_user=$_SESSION['monxin']['id'];
			$_POST['answer']=safe_str(@$_POST['answer']);
			$_POST['sequence']=intval(@$_POST['sequence']);
			$_POST['msg_state']=intval(@$_POST['msg_state']);
			if($_POST['answer']!=''){
				$sql="select `receive`,`content`,`answer` from ".self::$table_pre."msg where `id`=$id";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['receive']!='' && $r['answer']!=$_POST['answer']){
					if(self::$config['alert']['email_msg']){
						$email=get_email_account($r['receive']);
						if(is_array($email)){$email=@$email[0];}
						if(is_email($email)){
							$content=self::$language['feedback'].':'.$r['content'].'<hr />'.self::$language['reply'].':<b>'.$_POST['answer'].'</b>';
							email(self::$config,self::$language,$pdo,'monxin',self::$config['alert']['admin_email_account'],self::$config['web']['name'].' '.$_SERVER['HTTP_HOST'].self::$language['feedback_email_to_sender_title'],$content);
						}
					}
					if(self::$config['alert']['phone_msg']){
						$phone=get_phone_account($r['receive']);
						if(is_array($phone)){$phone=@$phone[0];}
						if(preg_match(self::$config['other']['reg_phone'],$phone)){
							//sms(self::$config,self::$language,$pdo,'monxin',self::$config['alert']['admin_phone_account'],self::$config['web']['name'].' '.$_SERVER['HTTP_HOST'].self::$language['feedback_email_to_sender_title'].':'.$_POST['answer']);
						}
					}
					
				}
				
				$sql="update ".self::$table_pre."msg set `answer`='".$_POST['answer']."',`sequence`='".$_POST['sequence']."',`state`='".$_POST['msg_state']."',`answer_time`='$time',`answer_user`='$answer_user' where `id`='$id'";	
			}else{
				$sql="update ".self::$table_pre."msg set `sequence`='".$_POST['sequence']."',`state`='".$_POST['msg_state']."' where `id`='$id'";
			}
  			//echo $sql;
			if($pdo->exec($sql)){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		}
		if($act=='del'){
			$sql="delete from ".self::$table_pre."msg where `id`='$id'";
			if($pdo->exec($sql)){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		}
		
		if($act=='del_select'){
			$ids=@$_POST['ids'];
			if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
			$ids=explode("|",$ids);
			$ids=array_filter($ids);
			$success='';
			foreach($ids as $id){
				$id=intval($id);
				$sql="delete from ".self::$table_pre."msg where `id`='$id'";
				if($pdo->exec($sql)){
					$success.=$id."|";
				}
			}
			$success=trim($success,"|");			
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}
