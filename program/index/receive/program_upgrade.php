<?php
		$act=@$_GET['act'];
		$program=safe_str(@$_GET['program']);
		$config=require('./program/'.$program.'/config.php');
		$language=require('./program/'.$program.'/language/'.$config['program']['language'].'.php');
		
		
		if($act=='up_patch'){	
			$v=@$_POST['v'];
			$v=explode("|",$v);
			$v=$v[count($v)-1];
			if($v==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['is_null']."'}");}
			$path=extract_zip('./temp/'.$v);
			if($path==false){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['extract_fail']."'}");}
			
			$r=scandir($path);
			if(program_permissions(self::$config,self::$language,$program,'./program/'.$program.'/')==false){
				exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['illegal_use']."'}");	
			}
			
			$lack=check_patch_files($path,$program);
			if($lack!=''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span><fieldset><legend>".self::$language['lack']."</legend>".$lack."</fieldset>','id':'patch'}");}
			
			if($_POST['get_txt_info']['program']!=$program){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['program'].self::$language['incompatible']."'}");}
			if($_POST['get_txt_info']['for']!=$config['version']){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['version'].self::$language['incompatible']."'}");}
			if($_POST['get_txt_info']['version']<=$config['version']){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['version'].self::$language['is_too_old']."'}");}
			
			
			$dir=new Dir();
			if($dir->copy_dir($path.'/patch','./program/'.$program.'/patch/')){$dir->del_dir($path);}				
			
			exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['upload'].self::$language['success']."'}");
		}
		
		
		if($act=='upgrade'){
			if($program==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['is_null']."'}");}	
			if($program=='index'){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['illegal']."'}");}

			$lack=check_patch_files("./program/".$program,$program);
			if($lack!=''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span><fieldset><legend>".self::$language['lack']."</legend>".$lack."</fieldset>','id':'patch'}");}
			$config=require('./program/'.$program.'/config.php');

			if($_POST['get_txt_info']['program']!=$program){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['program'].self::$language['incompatible']."'}");}
			if($_POST['get_txt_info']['for']!=$config['version']){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['version'].self::$language['incompatible']."'}");}
			if($_POST['get_txt_info']['version']<=$config['version']){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['version'].self::$language['is_too_old']."'}");}
			



			$info=get_txt_info("./program/$program/patch/info.txt");
			//var_dump($info);
			if(floatval($info['for'])!=floatval($config['version'])){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['version'].self::$language['err']."'}");}
			
			require("./program/$program/patch/upgrade.php");
			$r=upgrade($pdo,self::$language);
			if($r===true){
				$config['version']=$info['version'];
				$compatible_template_version=explode(',',$info['compatible_template_version']);
				$template_info=$info=get_txt_info("./templates/$program/".$config['program']['template_1']."/info.txt");
				if(!in_array($template_info['version'],$compatible_template_version)){$config['program']['template_1']='default';}
				file_put_contents('./program/'.$program.'/config.php','<?php return '.var_export($config,true).'?>');
				copy("./program/$program/patch/uninstall.php","./program/$program/uninstall.php");
				$dir=new Dir();
				$dir->copy_dir('./program/'.$program.'/default/','./templates/'.$program.'/default/');
				$dir->del_dir("./program/$program/patch/");
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span> <a href=./index.php?monxin=index.program_config class=return>".self::$language['return']."</a>'}");
			}else{
				if($r!=''){exit($r);}else{exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
			}
		exit;		
		}
