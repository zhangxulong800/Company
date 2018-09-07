<?php
		$name_count=0;
		$last_width=100;
		$program=safe_str(@$_GET['program']);
		$module['groups']=index::get_groups($pdo,0,"index.php?monxin=index.view_page&program=".$program."&id=");
		
		$id=intval(@$_GET['id']);
		
		
		if($id==0){
			$sql="select `id` from ".$pdo->index_pre."group where `parent`=0 order by `sequence` desc limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			header("location:index.php?monxin=index.view_page&id=".$r['id']);	
		}
		
		$sql="select `page_power` from ".$pdo->index_pre."group where `id`='$id'";
		$r=$pdo->query($sql,2)->fetch(2);
		//echo $r['page_power'];
		//exit();
		$page_power=explode(",",trim($r['page_power'],","));		
		
		$sql="select `name` from ".$pdo->index_pre."program  order by `id` asc";
		if($program!=''){$sql="select `name` from ".$pdo->index_pre."program  where `name`='$program'";}
		//echo $sql;
		$stmt=$pdo->query($sql,2);
		
		$module['list2']='';
		foreach($stmt as $v){
			$module['list']='';
			$pages=require("program/".$v['name']."/pages.php");
			$config=require("program/".$v['name']."/config.php");
			$language=require("program/".$v['name']."/language/".$config['program']['language'].".php");
			foreach($pages as $key=>$v2){
				if($pages[$key]['require_login']==1){
					$temp=explode("&",$key);
					if(in_array($temp[0],$page_power)){
					$module['list'].="<li><a href=index.php?monxin={$key} target=_blank>".$language['pages'][$key]['name']."</a></li>";
					}

				}
				
			}
		$module['list2'].=" <fieldset><legend>".$language['program_name']."</legend><ul class=icons>{$module['list']}<div style='clear:both;'></div></ul></fieldset>";
		}
		$module['list']=$module['list2'];
		$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id;
		$module['act']='view';
		$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
		$module['program_option']=index::get_program_option($pdo);
		
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);