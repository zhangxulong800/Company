<?php
$module['program_option']=index::get_program_option($pdo);
$program=@$_GET['program'];
$type=@$_GET['type'];
$type=($type=='1')?'1':'0';
$_GET['type']=$type;

function get_templates($program,$path,$language,$config){
	if(!is_dir($path)){return false;}
	$path2=str_replace('./templates/','',$path);
	$program_config=require('./program/'.$program.'/config.php');
	$program_language=require('./program/'.$program.'/language/'.$program_config['program']['language'].'.php');
	$r=scandir($path);
	$c='';
	foreach($r as $v){
		if($v!='.' && $v!='..' && is_dir($path.$v)){
			$i=get_txt_info($path.$v.'/info.txt');
			if($program_config['program']['template_'.$_GET['type']]==$v){$apply=$language['applied'];}else{$apply=" <a href='".$program.'__'.$v."' id='".$program.'__'.$v."_apply' class='apply'>".$language['apply']."</a>";}
			
			$time_limit=($v=='default')?$language['permanent']:"<script src='".$config['server_url']."receive.php?target=server::template_server&act=show_time_limit&program=".$program."&template=".$v."&site_id=".$config['web']['site_id']."&site_key=".$config['web']['site_key']."&domain=".$_SERVER['HTTP_HOST']."&language=".$config['web']['language']."'></script>";
			$del=($v=='default')?'':" <a href='".$program.'__'.$v."' id='".$program.'__'.$v."_del' class='del'>".$language['del']."</a>";				
			$c.="<li id='".$program.'__'.$v."_li'><div class='icon_div'><a href=".$config['server_url']."index.php?monxin=server.template_detail&path=".$program."/".$v." target=_blank><img src='".$path.$v."/icon.png' /><br><span>".$i['name']."</span></a></div><div class='info_div'>
		<span class='m_label'>".$language['author'].":</span><span class='info'><a href=".$i['author_url']."  target=_blank>".$i['author']."</a></span><br/>
		<span class='m_label'>".$language['version'].":</span><span class='info'>".$i['version']." <script src='".$config['server_url']."receive.php?target=server::template_server&act=show_upgrade&program=".$program."&template=".$v."&version=".$i['version']."&compatible=".$program_config['compatible_template_version']."&language=".$config['web']['language']."'></script></span><br/>
		<span class='m_label'>".$language['time_limit'].":</span><span class='info'>".$time_limit."</span><br/>
		<span class='m_label'>".$language['operation'].":</span><span class='info'>".$apply." <a href='./index.php?monxin=index.template_edit&dir=".$path2.'/'.$v."/' class='edit'>".$language['edit']."</a>".$del." </span><br/>
		</div></li>";	
		}	
	}
	$c="<fieldset><legend>".$program_language['program_name'].$program_config['version']." &nbsp; ".$language['compatible'].$language['template'].$language['version'].":".$program_config['compatible_template_version']."</legend><ul id=icons>".$c."<div style='clear:both;'></div></ul></fieldset>";

	return $c;		
}


$c='';
if($program==''){
	$path='./templates/'.$type."/";
	$r=scandir($path);
	foreach($r as $v){
		if(!(file_exists("program/".$v."/config.php"))){continue;}
		if($v!='.' && $v!='..' && is_dir($path.$v)){
			$path2=$path.$v.'/';
			$c.=get_templates($v,$path2,self::$language,self::$config);
		}	
	}			
}else{
	$c.=get_templates($program,'./templates/'.$type.'/'.$program.'/',self::$language,self::$config);
}

	
	$module['list']="<ul class='nav nav-tabs'><li role='presentation' type=0><a href=./index.php?monxin=index.template_admin&type=0&program=".@$_GET['program'].">".self::$language['reception'].self::$language['template']."</a></li><li role='presentation' type=1><a href=./index.php?monxin=index.template_admin&type=1&program=".@$_GET['program'].">".self::$language['backstage'].self::$language['template']."</a></li><li role='presentation'><a id=template_market href='".self::$config['server_url']."index.php?monxin=server.template_market&url=' target=_blank>".self::$language['templates_market']."</a></li></ul>
	<div id=program_option>".self::$language['current']."：<select id=program name=program><option value=''>".self::$language['all']."</option>".$module['program_option']."</select></div>".$c;

echo "<div id=up_div>".self::$language['upload'].self::$language['template']."<span id=up_new_state></span></div>";	


require "./plugin/html5Upfile/createHtml5.class.php";
$html5Upfile=new createHtml5();
$html5Upfile->echo_input(self::$language,"up_new",'auto','','./temp/','true','false','zip',1024*get_upload_max_size(),'5');
//echo_input("house_model",'控件宽度(百分比或像素)','multiple','保存到文件夹','文件是否附加日期','是否原名保存','允许文件类型','文件最大值','文件最小值');			




$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&program=".$program.'&type='.$type;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);


