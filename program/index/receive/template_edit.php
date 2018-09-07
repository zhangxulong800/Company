<?php
$act=@$_GET['act'];

$dir=trim(@$_GET['dir'],'/');
$dir=str_replace('//','/',$dir.'/');
$path=str_replace('..','.','./templates/'.$dir);

if($act=='up_new'){
	$v=safe_str(@$_POST['v']);
	if($v==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['is_null']."'}");}
	$arr=explode("|",$v);
	$imgs=array();
	foreach($arr as $v){
		if(is_file("./temp/".$v)){
			if(is_file($path.$v)){@safe_unlink($path.$v);}
			safe_rename('./temp/'.$v,$path.$v);
		}	
	}
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
}

if($act=='del'){
	$temp=explode('/',$dir);
	//var_dump($dir);
	if(!is_file('./program/'.$temp[1].'/config.php')){
		if($temp[1]==''){
			if(is_file('./templates/'.$_GET['id'])){safe_unlink('./templates/'.$_GET['id']);exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");}	
		}
		exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['forbidden_del']."'}");				
	}
	
	$info=get_txt_info('./templates/'.$dir.'/info.txt');
	$config=require('./program/'.$temp[1].'/config.php');
	if($config['program']['template_'.$info['type']]==$temp[1]){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['being_used']."'}");}
	
	$id=@$_GET['id'];
	$path=str_replace('//','/',$path.'/'.$id);
	//exit($path);
	if(is_file($path)){
		$r=@safe_unlink($path);
	}else{
		if($config['program']['template_'.$info['type']]==$id){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['being_used']."'}");}
		$obj=new Dir();
		$r=$obj->del_dir($path);	
	}
	if($r){
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
