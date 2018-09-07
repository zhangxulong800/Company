<?php
		$id=intval(@$_GET['id']);
		if($id==0){exit('group id err');}
		$list='';
		foreach($_POST as $key=>$v){
			if(@$_POST[$key]){
				$list.=safe_str(@$_POST[$key]).",";
				}	
		}
		$sql="update ".$pdo->index_pre."group set `require_info`='$list' where `id`='$id'";
		$affected_rows=$pdo->exec($sql);
		if($affected_rows==0){
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}else{
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
		}