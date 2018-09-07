<?php

$program=@$_GET['program'];
if(program_permissions(self::$config,self::$language,$program,'./program/'.$program.'/')==false){
	echo(self::$language['illegal_use']);return false;	
}

$config=require('./program/'.$program.'/config.php');
$language=require('./program/'.$program.'/language/'.$config['program']['language'].'.php');

echo ' <div id="user_position_reset" style="display:none;"><a href="index.php"><span id=user_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href="index.php?monxin=index.user">'.self::$language['user_center'].'</a><a href="index.php?monxin=index.program_config">'.self::$language['program'].self::$language['admin'].'</a><span class=text>'.$language['program_name'].' '.self::$language['recover'].'</span></div>';	


$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&program=".$program;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$list='';

$dir=new Dir();	
$r=$dir->show_dir('./program_backup/'.$program.'/',$postfix=array('zip'),$sub=true,$require_dir=false);
if($r){
	$r=array_reverse($r);
	foreach($r as $v){
		$name=str_replace('./program_backup/'.$program.'/','',$v);
		//$name=substr($name,5);
		$name2=str_replace('/'.$program.'.zip','',$name);
		$name=substr($name,12);	
		$list.="<tr id='tr_".$name2."'>
		<td class=name><span class=name>$name</span></td>
		<td class=size>".formatSize(filesize($v))."</td>
		<td class=time>".get_time(self::$config['other']['date_style'].' H:i',self::$config['other']['timeoffset'],self::$language,filemtime($v))."</td>
		<td class=operation_td><a href='#' onclick='return recover(\"".$name2."\")'  class='recover'>".self::$language['recover']."</span><span class=b_end></span>&nbsp;</a><a href='#' onclick='return del(\"".$name2."\")'  class='del'>".self::$language['del']."</span><span class=b_end></span>&nbsp;</a> <span id=state_".$name2." class='state'></span></td>
	</tr>
	";	
	}

}
if($list!=''){
	$module['list']=$list;
}else{
	$module['list']='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';
}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

require "./plugin/html5Upfile/createHtml5.class.php";
$html5Upfile=new createHtml5();
$html5Upfile->echo_input(self::$language,"upfile",'auto','multiple','./temp/','true','true','zip',1024*get_upload_max_size(),'0');
//echo_input("house_model",'控件宽度(百分比或像素)','multiple','保存到文件夹','文件是否附加日期','是否原名保存','允许文件类型','文件最大值','文件最小值');			
