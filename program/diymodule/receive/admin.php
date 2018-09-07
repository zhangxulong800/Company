<?php
		$id=intval(@$_GET['id']);
		$act=@$_GET['act'];
		if($act=='update'){
			$time=time();
			$editor=$_SESSION['monxin']['id'];
			$_GET['width']=safe_str(@$_GET['width']);
			$_GET['height']=safe_str(@$_GET['height']);
			$_GET['sequence']=intval(@$_GET['sequence']);
			$_GET['title']=safe_str(@$_GET['title']);
			$sql="update ".self::$table_pre."module set `width`='".$_GET['width']."',`height`='".$_GET['height']."',`title`='".$_GET['title']."',`sequence`='".$_GET['sequence']."',`time`='$time',`editor`='$editor' where `id`='".$id."'";
			if($pdo->exec($sql)){
				$this->update_module($pdo);
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		}
		if($act=='del'){
			$sql="select `content` from ".self::$table_pre."module where `id`='$id'";
			$r=$pdo->query($sql,2)->fetch(2);
			$sql="delete from ".self::$table_pre."module where `id`='$id'";
			if($pdo->exec($sql)){
				$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
				$imgs=get_match_all($reg,$r['content']);
				reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);	
				
				$fields=array('left','right','full','head','bottom');
				foreach($fields as $field){
					$sql="select `$field`,`id` from ".$pdo->index_pre."page where `$field` like '%diymodule.show_".$id.",%'";
					$r=$pdo->query($sql,2);
					foreach($r as $v){
						$new_field=str_replace("diymodule.show_".$id.",","",$v[$field]);
						$sql2="update ".$pdo->index_pre."page set `$field`='$new_field' where `id`='".$v['id']."'";
						$pdo->exec($sql2);	
					}
				}
				
				$this->update_module($pdo,$id);			
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
				$sql="select `content` from ".self::$table_pre."module where `id`='$id'";
				$r=$pdo->query($sql,2)->fetch(2);
				$sql="delete from ".self::$table_pre."module where `id`='$id'";
				if($pdo->exec($sql)){
					$this->update_module($pdo,$id);	
					$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
					$imgs=get_match_all($reg,$r['content']);
					reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);				
					$success.=$id."|";
					
					
					$fields=array('left','right','full','head','bottom');
					foreach($fields as $field){
						$sql="select `$field`,`id` from ".$pdo->index_pre."page where `$field` like '%diymodule.show_".$id.",%'";
						$r=$pdo->query($sql,2);
						foreach($r as $v){
							$new_field=str_replace("diymodule.show_".$id.",","",$v[$field]);
							$sql2="update ".$pdo->index_pre."page set `$field`='$new_field' where `id`='".$v['id']."'";
							$pdo->exec($sql2);	
						}
					}


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
				$v['width']=safe_str($v['width']);
				$v['height']=safe_str($v['height']);
				$v['sequence']=intval($v['sequence']);
				$v['title']=safe_str($v['title']);
				$sql="update ".self::$table_pre."module set `width`='".$v['width']."',`height`='".$v['height']."',`title`='".$v['title']."',`sequence`='".$v['sequence']."',`time`='$time',`editor`='$editor' where `id`='".$v['id']."'";
				if($pdo->exec($sql)){$success.=$v['id']."|";}
			}
			$success=trim($success,"|");	
			$this->update_module($pdo);		
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload(); class=refresh>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}
		
