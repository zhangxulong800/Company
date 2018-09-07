<?php
		$act=@$_GET['act'];
		$program=safe_str(@$_GET['program']);
		$template=safe_str(@$_GET['template']);
		$config=require('./program/'.$program.'/config.php');
		$language=require('./program/'.$program.'/language/'.$config['program']['language'].'.php');
		
		
		if($act=='up_template'){	
			$v=@$_POST['v'];
			$v=explode("|",$v);
			$v=$v[count($v)-1];
			if($v==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['is_null']."'}");}
			$zip_path='./temp/'.$v;
			$path=extract_zip('./temp/'.$v);
			if($path==false){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['extract_fail']."'}");}
			
			$r=scandir($path);
			if(template_permissions(self::$config,self::$language,$program,$template,$path.'/'.$template.'/')==false){
				exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['illegal_use']."'}");	
			}
			
			$lack=check_template_files($path.'/',$template,$program);
			if($lack!=''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span><fieldset><legend>".self::$language['lack']."</legend>".$lack."</fieldset>','id':'patch'}");}
			if($_POST['get_txt_info']['dir']!=$template){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['template'].self::$language['incompatible']."'}");}
			if($_POST['get_txt_info']['for']!=$program){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['program'].self::$language['incompatible']."'}");}
			$template_info=get_txt_info('./templates/'.$program.'/'.$template.'/info.txt');
			$version=$template_info['version'];
			if($_POST['get_txt_info']['version']<=$version){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['version'].self::$language['is_too_old']."'}");}
			
			
			
			$dir=new Dir();
			if($dir->copy_dir($path,'./templates/'.$program.'/')){$dir->del_dir($path);}				
			
			exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['upgrade'].self::$language['success']."'}");
		}
		
		
