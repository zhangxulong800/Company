<?php
	$act=@$_GET['act'];
	if($act=='submit'){
		$id=intval(@$_POST['id']);	
		$parent=intval(@$_POST['parent']);
		if($id!=0 && $parent!=0){
			$ids=$this->get_group_sub_ids($pdo,$id);
			$ids=trim($ids,",");
			$ids=explode(",",$ids);
			$ids[]=$id;
			$sql="select `parent`,`deep` from ".$pdo->index_pre."group where `id`='".$id."'";
			$r=$pdo->query($sql,2)->fetch(2);
			$old_deep=$r['deep'];
			if($r['parent']==$parent){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['you_do_not_choose_a_new'].self::$language['parent']."'}");}
			if($id==$parent){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['forbid_choose_self'].self::$language['parent']."'}");}
			if(in_array($parent,$ids)){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['forbid_choose_sub'].self::$language['parent']."'}");}
			
			$sql="update ".$pdo->index_pre."group set `parent`='$parent' where `id`='$id'";
			if($pdo->exec($sql)){
				foreach($ids as $v){
					$new_deep=$this->get_group_deep($pdo,$v);
					$new_deep--;
					$sql="update ".$pdo->index_pre."group set `deep`=$new_deep where `id`='$v'";
					$pdo->exec($sql);
						
				}
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		}	
	}