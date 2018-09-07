<?php
		$act=@$_GET['act'];
		$id=intval(@$_GET['id']);
		if($act=='del'){
			$sql="select `content` from ".$pdo->index_pre."site_msg where `id`='$id'";
			$r=$pdo->query($sql,2)->fetch(2);
			$sql="delete from ".$pdo->index_pre."site_msg where `id`='$id'";
			if($pdo->exec($sql)){
				$sql="select count(id) as c from ".$pdo->index_pre."site_msg where `content`='".$r['content']."'";
				$r2=$pdo->query($sql,2)->fetch(2);
				if($r2['c']==0){
					$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
					$imgs=get_match_all($reg,$r['content']);
					reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);	
				}
							
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
				$sql="select `content` from ".$pdo->index_pre."site_msg where `id`='$id'";
				$r=$pdo->query($sql,2)->fetch(2);
				$sql="delete from ".$pdo->index_pre."site_msg where `id`='$id'";
				if($pdo->exec($sql)){
					$sql="select count(id) as c from ".$pdo->index_pre."site_msg where `content`='".$r['content']."'";
					$r2=$pdo->query($sql,2)->fetch(2);
					if($r2['c']==0){
						$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
						$imgs=get_match_all($reg,$r['content']);
						reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);	
					}
					$success.=$id."|";
				}
			}
			$success=trim($success,"|");			
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}
