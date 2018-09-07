<?php
		$act=@$_GET['act'];
		
		if($act=='backup'){
			$r=output_table($pdo,'./data/');
			if($r){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
			}
		}
		if($act=='repair'){
			$r=repair_db($pdo);
			if($r){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
			}
		}
		if($act=='optimize'){
			$r=optimize_db($pdo);
			if($r){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
			}
		}
		
		
		if($act=='download'){
			$file=@$_GET['file'];
			if(is_file($file)){file_download($file,$filename='');}
			exit;
		}
		if($act=='del'){
			$file=@$_GET['id'];
			$path='./data/'.$file.'.sql';
			
			if(!is_file($path)){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
			$r=safe_unlink($path);
			if($r){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
			}
		}
		
		
		
		if($act=='recover'){			
			$file=@$_GET['id'];
			$path='./data/'.$file.'.sql';
			
			if(!is_file($path)){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
			output_table($pdo,'./data/');
			$r=input_table($pdo,$path);
			if($r){
				
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				foreach($_POST['output_table'] as $v){safe_unlink($v);}
				if(isset($_POST['err_info'])){exit("{'state':'fail','info':'<span class=fail>".self::$language[$_POST['err_info']]."</span>'}");}
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
			}
		}
				
		
		if($act=='upload'){			
			if($pdo->exec($sql)){
				@mkdir('./program/server/template_zip/'.date("Y").'_'.date('m'));
				@mkdir('./program/server/template_zip/'.date("Y").'_'.date('m').'/'.date('d'));
				safe_rename('./temp/'.safe_path($_POST['upfile']),'./program/server/template_zip/'.safe_path($_POST['upfile']));				
				if(isset($del_path)){@safe_unlink($del_path);}
				//header("location:index.php?monxin=server.program_list");
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		}
				
		