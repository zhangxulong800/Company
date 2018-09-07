<?php
set_time_limit(600);
header('Content-Type:text/html;charset=utf-8');
require_once './config/functions.php';
session_start();
if(!in_array('index.program_config',$_SESSION['monxin']['page'])){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>Illegal operation'}");}
$program=@$_GET['program'];
if($program==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>program null'}");}
if(!is_dir('./program/'.$program)){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>Illegal operation'}");}

$config=require_once './config.php';
$config['server_url']="http://localhost/monxin/";
$timeoffset=($config['other']['timeoffset']>0)? "-".$config['other']['timeoffset']:str_replace("-","+",$config['other']['timeoffset']);
date_default_timezone_set("Etc/GMT$timeoffset");
$language=require_once './language/'.$config['web']['language'].'.php';

$act=@$_GET['act'];



if($act=='install'){
	$r=program_permissions($config,$language,$program,'./program/'.$program.'/');
	//var_dump($r);
	if($r==false){
		exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".$language['illegal_use']."'}");	
	}
	
	$pdo=new  ConnectPDO();
	$pdo2=new  ConnectPDO();
	$pdo3=new  ConnectPDO();
	$dir=new Dir();
	if(!file_exists('./program/'.$program.'/install.php')){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>install.php does not exist'}");}
	
	require('./program/'.$program.'/install.php');
	$p_config=require('./program/'.$program.'/config.php');
	
	$sql="select `id` from ".$pdo->index_pre."program where `name`='".$p_config['class_name']."' limit 0,1";
	$temp=$pdo->query($sql,2)->fetch(2);
	if($temp['id']!=''){exit("{'state':'fail','info':'<span class=fail>config.php class_name exitst</span>'}");}
	
	$result=install($pdo,$language);
	if($result===true){	
		$sql="insert into ".$pdo2->index_pre."program (`name`) values ('$program')";
		if($pdo2->exec($sql)){
			$sql=$dir->show_dir('./program/'.$program.'/install_sql/',array('sql'),false,false);
			$r=input_table($pdo3,@$sql[0]);	
			//update template	
			@mkdir('./templates/0/'.$program.'/');	
			@mkdir('./templates/1/'.$program.'/');	
			$dir->copy_dir('./program/'.$program.'/install_templates/0/'.$p_config['program']['template_0'],'./templates/0/'.$program.'/'.$p_config['program']['template_0']);	
			$dir->copy_dir('./program/'.$program.'/install_templates/1/'.$p_config['program']['template_1'],'./templates/1/'.$program.'/'.$p_config['program']['template_1']);	
			$dir->del_dir('./program/'.$program.'/install_templates/');
						
			//update page
			$pages=require('./program/'.$program.'/pages.php');
			foreach($pages as $v){
				$sql="select `id` from ".$pdo->index_pre."page where `url`='".$v['url']."'";
				$r=$pdo2->query($sql,2)->fetch(2);
				if($r['id']==''){
					$sql="insert into ".$pdo2->index_pre."page (`url`,`layout`,`head`,`left`,`right`,`full`,`bottom`,`require_login`,`target`,`tutorial`) values ('".$v['url']."','".$v['layout']."','".$v['head']."','".$v['left']."','".$v['right']."','".$v['full']."','".$v['bottom']."','".$v['require_login']."','".$v['target']."','".$v['tutorial']."')";	
				}else{
					$sql="update ".$pdo2->index_pre."page set `layout`='".$v['layout']."',`head`='".$v['head']."',`left`='".$v['left']."',`right`='".$v['right']."',`full`='".$v['full']."',`bottom`='".$v['bottom']."',`require_login`='".$v['require_login']."',`target`='".$v['target']."',`tutorial`='".$v['tutorial']."' where `url`='".$v['url']."'";	
				}
				$pdo2->exec($sql);	
			}
			
			//update unlogin_function_power
			$config=require('./program/'.$program.'/config.php');
			$sys_config=require('./config.php');
			foreach($config['program_unlogin_function_power'] as $v){
				if(!in_array($v,$sys_config['unlogin_function_power'])){
					$sys_config['unlogin_function_power'][]=$v;	
				}	
			}
			file_put_contents('./config.php','<?php return '.var_export($sys_config,true).'?>');
			
			
			
			exit("{'state':'success','info':'<span class=success>&nbsp;</span>".$language['success']."'}");		
		}else{
			exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".$language['fail']."'}");		
		}
		
	}else{
		exit($result);
	}
		
}


if($act=='uninstall'){
	if($program=='index'){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".$language['illegal']."'}");}	
	$pdo=new  ConnectPDO();	
	if(!file_exists('./program/'.$program.'/uninstall.php')){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>uninstall.php does not exist'}");}
	
	require('./program/'.$program.'/uninstall.php');
	
	$result=uninstall($pdo,$language);
	if($result===true){
		$sql="delete from ".$pdo->index_pre."program where `name`='$program'";
		if($pdo->exec($sql)){
			del_program_table($pdo,$program);
			$pdo2=new  ConnectPDO();
			//delete group_menu
			$sql="delete from ".$pdo->index_pre."group_menu where `url` like '".$program.".%'";
			$pdo->exec($sql);
			
			//update page
			$pages=require('./program/'.$program.'/pages.php');
			foreach($pages as $v){
				$sql="delete from ".$pdo->index_pre."page where `url`='".$v['url']."'";
				$pdo2->exec($sql);	
			}
			//remove module
			$fields=array('left','right','full','head','bottom','phone');
			foreach($fields as $field){
				$sql="select `$field`,`id` from ".$pdo2->index_pre."page where `$field` like '%".$program.".%'";
				$r=$pdo2->query($sql,2);
				foreach($r as $v){
					$new_field=preg_replace("/".$program."\..*,/iU",",",$v[$field].',');
					$sql2="update ".$pdo2->index_pre."page set `$field`='$new_field' where `id`='".$v['id']."'";
					$pdo2->exec($sql2);
				}
			}

			//update unlogin_function_power
			$config=require('./program/'.$program.'/config.php');
			$sys_config=require('./config.php');
			foreach($config['program_unlogin_function_power'] as $v){
				if(in_array($v,$sys_config['unlogin_function_power'])){
					unset($sys_config['unlogin_function_power'][array_search($v,$sys_config['unlogin_function_power'])]);	
				}	
			}
			
			//remove user_sum_card
			$sql="select `user_sum`,`id` from ".$pdo->index_pre."group";
			$r=$pdo->query($sql,2);
			foreach($r as $v){
				if($v['user_sum']==''){continue;}
				$temp=explode(',',$v['user_sum']);
				$user_sum='';
				foreach($temp as $t2){
					$t3=explode('.',$t2);
					if($t3[0]!=$program){$user_sum.=$t2.',';}
				}	
				$sql="update ".$pdo->index_pre."group set `user_sum`='".$user_sum."' where `id`=".$v['id'];
				$pdo->exec($sql);
			}
			
			file_put_contents('./config.php','<?php return '.var_export($sys_config,true).'?>');
			
			
			$dir=new Dir();
			if(is_dir('./program/'.$program)){$dir->del_dir('./program/'.$program);}
			//if(is_dir('./templates/'.$program)){$dir->del_dir('./templates/'.$program);}
			
			
			exit("{'state':'success','info':'<span class=success>&nbsp;</span>".$language['success']."'}");		
		}else{
			exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".$language['fail']."'}");		
		}
		
	}else{
		exit($result);
	}
}





?>