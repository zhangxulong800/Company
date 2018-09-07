<?php
		$id=intval(@$_GET['id']);
		if($id>0){
			$sql="update ".self::$table_pre."article set `visit`=visit+1 where `id`='$id'";
			$pdo->exec($sql);
		}