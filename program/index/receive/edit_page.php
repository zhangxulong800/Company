<?php
		
		
		$id=intval(@$_GET['id']);
		$visible=intval(@$_POST['visible']);
		$url=safe_str(@$_POST['url']);
		echo $this->set_power($pdo,$id,$visible,$url);