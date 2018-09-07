<?php
		$name_count=0;
		$last_width=100;
		$program=safe_str(@$_GET['program']);
		$module['groups']=index::get_groups($pdo,0,"index.php?monxin=index.view_menu&program=$program&id=");
		
		$id=intval(@$_GET['id']);
		
		
		if($id==0){
			$sql="select `id` from ".$pdo->index_pre."group where `parent`=0 order by `sequence` desc limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			header("location:index.php?monxin=index.view_menu&id=".$r['id']);	
		}
		
		$sql="select * from ".$pdo->index_pre."group_menu where `group_id`='$id' and `visible`=1 order by sequence desc";
		
		if($program!=''){$sql="select * from ".$pdo->index_pre."group_menu where `group_id`='$id' and `visible`=1 and `url` like '".$program.".%' order by sequence desc";}
		$stmt=$pdo->query($sql,2);
		$module['list']='';
		foreach($stmt as $v){
			
			$t=explode(".",$v['url']);
			if(!is_file("./program/".$t[0]."/config.php")){continue;}
			$program_config=require("./program/".$t[0]."/config.php");
			$v['icon_path']='./templates/1/'.$t[0].'/'.$program_config['program']['template_1'].'/page_icon/'.$v['url'].'.png';
			$language=require("./program/".$t[0]."/language/".$program_config['program']['language'].".php");
			if(!isset($language['pages'][$v['url']]['name'])){continue;}
			$module['list'].="<li><a href=index.php?monxin={$v['url']}  target=_blank><img src={$v['icon_path']}><br/><span>".$language['pages'][$v['url']]['name']."</span></a><div><input type='text' id='sequence_".$v['id']."' name='sequence_".$v['id']."' value='".$v['sequence']."' class='menu_sequence' /></div></li>";
		}
		$module['list']="<ul id=icons>{$module['list']}<div style='clear:both;'></div></ul>";
		$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
		$module['act']='view';
		$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
		$module['program_option']=index::get_program_option($pdo);
		
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);