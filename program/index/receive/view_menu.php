<?php
		$id=intval(@$_GET['id']);
		$sequence=intval(@$_GET['sequence']);
		if($id>0){
			$sql="update ".$pdo->index_pre."group_menu set `sequence`='$sequence' where `id`='$id'";
			if($pdo->exec($sql)){
				$sql="select `group_id` from ".$pdo->index_pre."group_menu where `id`=".$id;
				$r=$pdo->query($sql,2)->fetch(2);
				self::update_admin_nv($pdo,$r['group_id']);
				exit("{'state':'success','info':'<span class=success>&nbsp;</span>'}");
			}
		}