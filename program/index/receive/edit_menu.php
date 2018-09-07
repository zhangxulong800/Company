<?php
		$id=intval(@$_GET['id']);
		$visible=intval(@$_POST['visible']);
		$url=safe_str(@$_POST['url']);
		$sql="select count(id) as c from ".$pdo->index_pre."group_menu where `group_id`='$id' and `url`='$url'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']==0){
			$sql="insert into ".$pdo->index_pre."group_menu (`url`,`group_id`,`visible`) values ('$url','$id','$visible')";
		}else{
			$sql="update ".$pdo->index_pre."group_menu set `visible`='$visible' where `url`='$url' and `group_id`='$id'";
		}
		if($pdo->exec($sql)){
			$pages=array();
			$pages[]=$url;
			$temp=explode('.',$url);
			$menu=require('./program/'.$temp[0].'/menu.php');
			foreach($menu[$url] as $key=>$v){
				$pages[]=$key;
				if(is_array($v)){
					foreach($v as $key2=>$v2){
						if(is_array($v2)){
							$pages[]=$key2;
							foreach($v2 as $key3=>$v3){
								if(is_array($v3)){
									$pages[]=$key3;
									foreach($v3 as $key4=>$v4){
										$pages[]=$v4;
									}
								}else{
									$pages[]=$v3;
								}
							}
						}else{
							$pages[]=$v2;
						}
					}
				}else{
					$pages[]=$v;
				}
	
			}
			//print_r($pages);
			foreach($pages as $v){
				$this->set_power($pdo,$id,$visible,$v);
			}
			self::update_admin_nv($pdo,$id);
			self::sum_modules($pdo);
			exit("{'state':'success','info':'<span class=success>&nbsp;</span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}