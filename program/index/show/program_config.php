<?php
function echo_html($sys_language,$language,$program,$key,$v){
	$config_language=$sys_language['program_config_language'];
	
	$div='';
	switch ($key){
		case ($key=='language'):
			$option='';
			$r=scandir('./program/'.$program.'/language/');
			foreach($r as $vv){
				if(!is_dir('./program/'.$program.'/language/'.$vv)){
					$vv=str_replace(".php",'',$vv);
					$vv=str_replace(".PHP",'',$vv);
					//echo $v.'='.$vv.'<br/>';
					if($v==$vv){$selected='selected';}else{$selected='';}
					if(!isset($language['language_dir'][$vv])){$language['language_dir'][$vv]=$vv;}
					$option.='<option value="'.$vv.'" '.$selected.'>'.$language['language_dir'][$vv].'</option>';	
				}	
			}
			$div='<div id=div_'.$key.'><span class="m_label2">'.$config_language[$key].'</span><span class="content"><select id='.$key.' name='.$key.'>'.$option.'</select><span id='.$key.'_state ></span> <a href="./index.php?monxin=index.language_list&program='.$program.'">'.$sys_language['edit'].'</a></span></div>';
			break;
			
		case ($key=='template_0'):
			$option='';
			$path='./templates/0/'.$program.'/';
			$r=scandir($path);
			foreach($r as $vv){
				if(is_dir($path.$vv) && $vv!='.' && $vv!='..'){
					if($v==$vv){$selected='selected';}else{$selected='';}
					$i=get_txt_info($path.$vv.'/info.txt');
					$option.='<option value="'.$vv.'" '.$selected.'>'.$i["name"].'</option>';	
				}	
			}
			$div='<div id=div_'.$key.'><span class="m_label2">'.$config_language[$key].'</span><span class="content"><select id='.$key.' name='.$key.'>'.$option.'</select> <a href=./index.php?monxin=index.template_admin&program='.$program.'>'.$sys_language['edit'].'</a><span id='.$key.'_state ></span></span></div>';
			break;
			
		case ($key=='template_1'):
			$option='';
			$path='./templates/1/'.$program.'/';
			$r=scandir($path);
			foreach($r as $vv){
				if(is_dir($path.$vv) && $vv!='.' && $vv!='..'){
					if($v==$vv){$selected='selected';}else{$selected='';}
					$i=get_txt_info($path.$vv.'/info.txt');
					$option.='<option value="'.$vv.'" '.$selected.'>'.$i["name"].'</option>';	
				}	
			}
			$div='<div id=div_'.$key.'><span class="m_label2">'.$config_language[$key].'</span><span class="content"><select id='.$key.' name='.$key.'>'.$option.'</select> <a href=./index.php?monxin=index.template_admin&program='.$program.'>'.$sys_language['edit'].'</a><span id='.$key.'_state ></span></span></div>';
			break;
			
		case ($key=='state'):
			$option='';
			$option.='<option value="opening" '.return_selected('opening',$v).'>'.$sys_language['program_state']['opening'].'</option>';	
			$option.='<option value="closed" '.return_selected('closed',$v).'>'.$sys_language['program_state']['closed'].'</option>';	
			
			$div='<div id=div_'.$key.'><span class="m_label2">'.$config_language[$key].'</span><span class="content"><select id='.$key.' name='.$key.'>'.$option.'</select><span id='.$key.'_state ></span></span></div>';
			break;
		default:
			if($v===true || $v===false){
				if($v==true){$false='';$true='selected';}else{$true='';$false='selected';}
				$div='<div id=div_'.$key.'><span class="m_label2">'.$config_language[$key].'</span><span class="content"><select id='.$key.' name='.$key.'><option value="true" '.$true.'>'.$sys_language['true'].'</option><option value="false" '.$false.'>'.$sys_language['false'].'</option></select><span id='.$key.'_state ></span></span></div>';
			}else{
				//var_dump($v);
				$div='<div id=div_'.$key.'><span class="m_label2">'.$config_language[$key].'</span><span class="content"><input type="text" id="'.$key.'" name="'.$key.'" value=\''.$v.'\' /><span id='.$key.'_state ></span></span></div>';
			}
			break;

	}
	return $div;
}

$module['program_option']=index::get_program_option($pdo);
$program=@$_GET['program'];
if($program!='' && is_dir("./program/".@$_GET['program']."/")){
	$program=@$_GET['program'];
	if(program_permissions(self::$config,self::$language,$program,'./program/'.$program.'/')==false){
		echo(self::$language['illegal_use']);return false;	
	}
	
	$program_config=require './program/'.$program.'/config.php';
	$program_language=require './program/'.$program.'/language/'.$program_config['program']['language'].'.php';
	
	$module['list']="<div id=program_option>".self::$language['current']."：<select id=program name=program><option value=''>".self::$language['all']."</option>".$module['program_option']."</select></div>";
	$module['list'].='<fieldset><legend>'.$program_language['program_name'].'</legend>';
	foreach($program_config['program'] as $key=>$v){
		if($key=='state' && $program=='index'){continue;}
		$module['list'].=echo_html(self::$language,$program_language,$program,$key,$v);
	}
	$module['list'].='</fieldset>';
	
	echo ' <div id="user_position_reset" style="display:none;"><a href="index.php"><span id=user_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href="index.php?monxin=index.user">'.self::$language['user_center'].'</a><a href="index.php?monxin=index.program_config">'.self::$language['program_name'].'</a><span class=text>'.$program_language['program_name'].'</span></div>';	
	
	
	
}else{
	$sql="select `name` from ".$pdo->index_pre."program order by `id` asc";
	$r=$pdo->query($sql,2);
	$module['list']='';
	$sql_data=array();
	foreach($r as $v){
		$sql_data[$v['name']]=$v['name'];
		if(!file_exists('./program/'.$v['name'].'/config.php')){continue;}
		$config=require('./program/'.$v['name'].'/config.php');
		$language=require('./program/'.$v['name'].'/language/'.$config['program']['language'].'.php');
		if($v['name']=='index'){$uninstall='';}else{$uninstall=" <a href='#' class='uninstall' id='".$v['name']."'>".self::$language['uninstall']."</a>";}
		$module['list'].="<li id='".$v['name']."_li'><div class='icon_div'><a href=".self::$config['server_url']."index.php?monxin=server.program_detail&program=".$v['name']." target=_blank ><img src='./program/".$v['name']."/icon.png' /><br><span>".$language['program_name']."</span></a></div><div class='info_div'>
		<span class='m_label'>".self::$language['author'].":</span><span class='info'><a href=".$config['author_url']." target=_blank>".$config['author']."</a></span><br/>
		<span class='m_label'>".self::$language['version'].":</span><span class='info'>".$config['version']." <script src='".self::$config['server_url']."receive.php?target=server::program_server&act=show_upgrade&program=".$v['name']."&version=".$config['version']."&language=".self::$config['web']['language']."'></script></span><br/>
		<span class='m_label'>".self::$language['time_limit'].":</span><span class='info'>"."<script src='".self::$config['server_url']."receive.php?target=server::program_server&act=show_time_limit&program=".$v['name']."&site_id=".self::$config['web']['site_id']."&site_key=".self::$config['web']['site_key']."&domain=".$_SERVER['HTTP_HOST']."&language=".self::$config['web']['language']."'></script></span><br/>
		<span class='m_label'>".self::$language['operation'].":</span><span class='info'><a href='index.php?monxin=index.program_config&program={$v['name']}' class=set>".self::$language['set']."</a><a href='index.php?monxin=index.program_backup&program={$v['name']}' class=set>".self::$language['backup']."</a><a href='index.php?monxin=index.program_recovery&program={$v['name']}' class=set>".self::$language['recover']."</a>".$uninstall."</span><br/>
		</div></li>";	
	}
	
	$r=scandir("./program/");
	$wait_installation='';
	foreach($r as $v){
		if(!is_dir("./program/".$v) || $v=='.' || $v=='..' || isset($sql_data[$v])){continue;}
		if(!is_file('./program/'.$v.'/config.php')){continue;}
		$config=require('./program/'.$v.'/config.php');
		$language=require('./program/'.$v.'/language/'.$config['program']['language'].'.php');
		$wait_installation.="<li id='".$v."_li'><div class='icon_div'><a href=".self::$config['server_url']."index.php?monxin=server.program_detail&program=".$v." target=_blank ><img src='./program/".$v."/icon.png' /><br><span>".$language['program_name']."</a></span><br/>
	</div><div class='info_div'><a href='$v' class=not_install_install >".self::$language['install']."</a> <span id='".$v."_install_state'></span><br><a href='$v' class=not_install_del >".self::$language['del']."</a>  <span id='".$v."_del_state'></span><br /><br /></div></li>";
	}


	if($wait_installation!=''){$wait_installation="<fieldset><legend>".self::$language['wait_installation']."</legend><div id='warning'>".self::$language['install'].self::$language['notice'].':'.self::$language['in_order_to_avoid_data_loss_caused_by_accidental_please_backup_the_database_and_website_files_and_then_execute_the_operation']."</div><ul id=icons>{$wait_installation}<div style='clear:both;'></div></ul></fieldset>";}
	
	$module['list']=$wait_installation."<div id=program_banner><span id=installed_programs>".self::$language['installed_programs']."</span> <a id=program_market href='".self::$config['server_url']."index.php?monxin=server.program_market&url=' target=_blank>".self::$language['programs_market']."</a></div><ul id=icons>{$module['list']}<div style='clear:both;'></div></ul>";

echo "<div id=up_div>".self::$language['upload'].self::$language['program']."<span id=up_new_state></span></div>";	
require "./plugin/html5Upfile/createHtml5.class.php";
$html5Upfile=new createHtml5();
$html5Upfile->echo_input(self::$language,"up_new",'auto','','./temp/','true','false','zip',1024*get_upload_max_size(),'5');
//echo_input("house_model",'控件宽度(百分比或像素)','multiple','保存到文件夹','文件是否附加日期','是否原名保存','允许文件类型','文件最大值','文件最小值');			
}




$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&program=".$program;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);


