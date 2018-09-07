<?php
		
		$program=@$_GET['program'];
		$template=@$_GET['template'];
		if(template_permissions(self::$config,self::$language,$program,$template,'./templates/'.$program.'/'.$template.'/')==false){
			echo(self::$language['illegal_use']);return false;	
		}
		$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&program=".$program."&template=".$template;
		$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
		
		$config=require('./program/'.$program.'/config.php');
		$template_info=get_txt_info('./templates/'.$program.'/'.$template.'/info.txt');
		$url=self::$config['server_url'].'receive.php?target=server::template_server&act=template_upgrade&program='.$program.'&compatible='.$config['compatible_template_version'].'&template='.$template.'&version='.$template_info['version'];
		//echo $url;
		$module['download_url']=@file_get_contents($url);
		
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
		
		require "./plugin/html5Upfile/createHtml5.class.php";
		$html5Upfile=new createHtml5();
		$html5Upfile->echo_input(self::$language,"up_template",'auto','','./temp/','true','false','zip',1024*get_upload_max_size(),'0');
		//echo_input("house_model",'控件宽度(百分比或像素)','multiple','保存到文件夹','文件是否附加日期','是否原名保存','允许文件类型','文件最大值','文件最小值');			
