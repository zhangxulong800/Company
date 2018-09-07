<?php
	$act=@$_GET['act'];
	$id=$_POST['id'];
	$t=explode("__",$id);
	if($t[0]!='os_language'){
		function language_file($program,$new_key,$value,$old_key=''){
			$config=require('./program/'.$program.'/config.php');
			$r=scandir('./program/'.$program.'/language/');
			foreach($r as $v){
				if(is_file('./program/'.$program.'/language/'.$v)){
					$language=require('./program/'.$program.'/language/'.$v);
					$vv=str_replace(".php",'',$v);
					$vv=str_replace(".PHP",'',$vv);
					if($vv!=$config['program']['language']){
						$language['language_dir'][$new_key]=@$language['language_dir'][$old_key];	
					}else{
						$language['language_dir'][$new_key]=$value;	
					}
					//var_dump($language['language_dir']);
					if($old_key!='' && $old_key!=$new_key){unset($language['language_dir'][$old_key]);}
					file_put_contents('./program/'.$program.'/language/'.$v,'<?php return '.var_export($language,true).'?>');
				}	
			}
		}
		
		if($act=='save'){
			$id=$_POST['id'];
			$t=explode("__",$id);
			//var_dump($t);	
			$old_url='./program/'.$t[0].'/language/'.$t[1].'.php';	
			$new_url='./program/'.$t[0].'/language/'.$_POST['file_name'].'.php';	
			if(is_file($new_url) && $t[1]!=$_POST['file_name']){exit(self::$language['exist_same'].self::$language['file_name']);}
			if(safe_rename($old_url,$new_url)){
				language_file($t[0],$_POST['file_name'],$_POST['name'],$t[1]);
				$program_config=require('./program/'.$t[0].'/config.php');
				if($_POST['file_name']!=$t[1] && $t[1]==$program_config['program']['language']){
					$program_config['program']['language']=$_POST['file_name'];
					file_put_contents('./program/'.$t[0].'/config.php','<?php return '.var_export($program_config,true).'?>');
				}
				echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
			}else{
				echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
			}	
		}

		if($act=='add'){
			$id=$_POST['id'];
			$t=explode("__",$id);
			//var_dump($t);	
			$program_config=require('./program/'.$t[0].'/config.php');
			$new_url='./program/'.$t[0].'/language/'.$_POST['file_name'].'.php';	
			$now_url='./program/'.$t[0].'/language/'.$program_config['program']['language'].'.php';	
			if(is_file($new_url)){exit(self::$language['exist_same'].self::$language['file_name']);}
			if(file_put_contents($new_url,file_get_contents($now_url))){
				language_file($t[0],$_POST['file_name'],$_POST['name'],'');
				echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>'}";
			}else{
				echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
			}	
		}


		function del_language_key($program,$key){
			$r=scandir('./program/'.$program.'/language/');
			foreach($r as $v){
				if(is_file('./program/'.$program.'/language/'.$v)){
					$language=require('./program/'.$program.'/language/'.$v);
					unset($language['language_dir'][$key]);
					file_put_contents('./program/'.$program.'/language/'.$v,'<?php return '.var_export($language,true).'?>');
				}	
			}
		}

		if($act=='del'){
			$id=$_POST['id'];
			$t=explode("__",$id);
			$old_url='./program/'.$t[0].'/language/'.$t[1].'.php';	
			if(!is_file($old_url)){exit(self::$language['not_exist_file']);}
			$program_config=require('./program/'.$t[0].'/config.php');
			if($t[1]==$program_config['program']['language']){exit(self::$language['being_used']);}
			if(safe_unlink($old_url)){
				del_language_key($t[0],$t[1]);				
				echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
			}else{
				echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
			}	
		}
		
	}else{
		
		function os_language_file($program,$new_key,$value,$old_key=''){
			$config=require('./config.php');
			$r=scandir('./language/');
			foreach($r as $v){
				if(is_file('./language/'.$v)){
					$language=require('./language/'.$v);
					$vv=str_replace(".php",'',$v);
					$vv=str_replace(".PHP",'',$vv);
					if($vv!=$config['web']['language']){
						$language['language_dir'][$new_key]=@$language['language_dir'][$old_key];	
					}else{
						$language['language_dir'][$new_key]=$value;	
					}
					//var_dump($language['language_dir']);
					if($old_key!='' && $old_key!=$new_key){unset($language['language_dir'][$old_key]);}
					file_put_contents('./language/'.$v,'<?php return '.var_export($language,true).'?>');
				}	
			}
		}
		
		if($act=='save'){
			$id=$_POST['id'];
			$t=explode("__",$id);
			//var_dump($t);	
			$old_url='./language/'.$t[1].'.php';	
			$new_url='./language/'.$_POST['file_name'].'.php';	
			if(is_file($new_url) && $t[1]!=$_POST['file_name']){exit(self::$language['exist_same'].self::$language['file_name']);}
			if(safe_rename($old_url,$new_url)){
				os_language_file($t[0],$_POST['file_name'],$_POST['name'],$t[1]);
				if($_POST['file_name']!=$t[1] && $t[1]==self::$config['web']['language']){
					self::$config['web']['language']=$_POST['file_name'];
					file_put_contents('./config.php','<?php return '.var_export(self::$config,true).'?>');
				}
				echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
			}else{
				echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
			}	
		}

		if($act=='add'){
			$id=$_POST['id'];
			$t=explode("__",$id);
			//var_dump($t);	
			$new_url='./language/'.$_POST['file_name'].'.php';	
			$now_url='./language/'.self::$config['web']['language'].'.php';	
			if(is_file($new_url)){exit(self::$language['exist_same'].self::$language['file_name']);}
			if(file_put_contents($new_url,file_get_contents($now_url))){
				os_language_file($t[0],$_POST['file_name'],$_POST['name'],'');
				echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>'}";
			}else{
				echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
			}	
		}


		function os_del_language_key($program,$key){
			$r=scandir('./language/');
			foreach($r as $v){
				if(is_file('./language/'.$v)){
					$language=require('./language/'.$v);
					unset($language['language_dir'][$key]);
					file_put_contents('./language/'.$v,'<?php return '.var_export($language,true).'?>');
				}	
			}
		}

		if($act=='del'){
			$id=$_POST['id'];
			$t=explode("__",$id);
			$old_url='./language/'.$t[1].'.php';	
			if(!is_file($old_url)){exit(self::$language['not_exist_file']);}
			if($t[1]==self::$config['web']['language']){exit(self::$language['being_used']);}
			if(safe_unlink($old_url)){
				os_del_language_key($t[0],$t[1]);				
				echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
			}else{
				echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
			}	
		}
		
	}


