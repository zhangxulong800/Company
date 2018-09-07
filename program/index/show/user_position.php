<?php
if(!isset($_SESSION['monxin']['username'])){return false;}
$page=(isset($_GET['monxin']) && @$_GET['monxin']!='')?$_GET['monxin']:"index.index";
$t=explode(".",$page);
$menu=require("./program/".$t[0]."/menu.php");
//var_dump($menu);
$position=array();
//$position[]="<a href='index.php'><span id=user_position_icon>&nbsp;</span>".self::$config['web']['name']."</a>";
$position[]="<a href='index.php?monxin=index.user'>".self::$language['user_center']."</a>";

function user_position_get_name($key){
	if(!in_array($key,$_SESSION['monxin']['page'])){return false;}
	global $language;
	if(isset($language['pages'][$key]['name'])){return  "<a href='index.php?monxin=$key'>".$language['pages'][$key]['name'].'</a>';}	
	$temp=explode(".",$key);
	$program_config=require './program/'.$temp[0].'/config.php';
	$language=require './program/'.$temp[0].'/language/'.$program_config['program']['language'].'.php';
	unset($config);
	if(isset($language['pages'][$key]['name'])){return  "<a href='index.php?monxin=$key'>".$language['pages'][$key]['name'].'</a>';}	
	return $key;
}
function user_position_get_name2($key){
	if(!in_array($key,$_SESSION['monxin']['page'])){return false;}
	global $language;
	if(isset($language['pages'][$key]['name'])){return $language['pages'][$key]['name'];}	
	$temp=explode(".",$key);
	$program_config=require './program/'.$temp[0].'/config.php';
	$language=require './program/'.$temp[0].'/language/'.$program_config['program']['language'].'.php';
	unset($config);
	if(isset($language['pages'][$key]['name'])){return $language['pages'][$key]['name'];}	
	return $key;
}
$language=self::$language;
if($page!='index.user'){
	foreach($menu as $key=>$v){
		//echo 'key1='.$key.'<br/>';
		if(is_array($v)){
			if(in_array($page,$v)){
				$position[]=user_position_get_name($key);
			}else{
				
				foreach($v as $key2=>$v2){
					//echo '--key2='.$key2.'<br/>';
					if($page===$key2){$position[]=user_position_get_name($key);}
					if(is_array($v2)){
						if(in_array($page,$v2)){
							
							$position[]=user_position_get_name($key);
							$position[]=user_position_get_name($key2);
						}else{
							foreach($v2 as $key3=>$v3){
								//echo '----key3='.$key3.'<br/>';
								if($page===$key3){$position[]=user_position_get_name($key2);}
								if(is_array($v3)){
									if(in_array($page,$v3)){
										
										$position[]=user_position_get_name($key);
										$position[]=user_position_get_name($key2);
										$position[]=user_position_get_name($key3);
									}else{
										foreach($v3 as $key4=>$v4){
											//echo '----key4='.$key4.'<br/>';
											if($page===$key4){$position[]=user_position_get_name($key3);}
											if(is_array($v4)){
												
												if(in_array($page,$v4)){
													$position[]=user_position_get_name($key);
													$position[]=user_position_get_name($key2);
													$position[]=user_position_get_name($key3);
													$position[]=user_position_get_name($key4);
												}
											}	
										}
									}	
								}
							}
						}	
					}	
				}
			}
		}	
	}			
	$position[]='<span class=text>'.user_position_get_name2($page).'</span>';
}
$position= array_unique($position);
$list='';
foreach($position as $v){
	$list.=$v;	
}
$module['list']=str_replace("\r\n",'',$list);
$language=self::$language;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);