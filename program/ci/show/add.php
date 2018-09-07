<?php
if(date("d",time())!=file_get_contents("./program/ci/update_task/day.txt")){self::exe_day_task($pdo);}
if(self::check_day_add_max($pdo,self::$table_pre,self::$config['day_add_max'])===false){
	echo '<div style="text-align:center;margin-top:30px;">'.str_replace('{v}',self::$config['day_add_max'],self::$language['published_daily_limit_has_been_reached_please_come_back_tomorrow_to_release']).'</div>';return false;
}
if(self::$config['visitor_add']==false && !isset($_SESSION['monxin']['username'])){header('location:./index.php?monxin=index.login');exit;}
$type=intval(@$_GET['type']);
if($type==0){header('location:./index.php?monxin=ci.add_option_type');exit;}
$sql="select * from ".self::$table_pre."type where `id`=".$type." and `visible`=1";
$module=$pdo->query($sql,2)->fetch(2);
if($module['name']='' || $module['url']!=''){echo 'type err';return false;}
$sql="select `id`,`unit` from ".self::$table_pre."type where `parent`=".$type." and `visible`=1 limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']!=''){echo 'type err';return false;}
$unit=$module['unit'];
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&type=".$type;

if($module['title_label']==''){$module['title_label']=self::$language['title'];}
if($module['icon_label']==''){$module['icon_label']=self::$language['cover_image'];}
if($module['content_label']==''){$module['content_label']=self::$language['detail'];}


$sql="select * from ".self::$table_pre."type_attribute where `type_id`='".$type."' order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$module['fields']='';
foreach($r as $v){
	$v=de_safe_str($v);
	$module['fields'].=$this->get_input_html(self::$language,$v,$pdo);
}
if($module['price']!=''){
	$module['fields'].='<div><span class=m_label><span class="required">*</span>'.self::$language['price'].'</span><span class=input_span><input type="text" id=price  class="monxin_input" monxin_required="1" /> <span class=postfix>'.$unit.'</span> <span id=price_state class=state></span>  <span class=set_negotiable><input type=checkbox id=set_negotiable_checkbox /><m_label for=set_negotiable_checkbox>'.self::$language['negotiable'].'</m_label></span></span></div>';	
}

$module['linkman']='';
$module['contact']='';
$module['authcode']='';
if(isset($_SESSION['monxin']['username'])){
	$sql="select `id`,`linkman`,`contact` from ".self::$table_pre."content where `username`='".$_SESSION['monxin']['username']."' order by `id` desc limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']){
		$module['linkman']=$r['linkman'];
		$module['contact']=$r['contact'];
	}
}else{
	$module['authcode']='<div id=authcode_div><span class=m_label><span class=required>*</span>'.self::$language['authcode'].'</span><span class=input_span><input type=text id=authcode   monxin_required="1"  class="monxin_input" size="8" style="vertical-align:middle;"  /> <span class=state id=authcode_state ></span> <a href="#" onclick="return change_authcode();" title="'.self::$language['click_change_authcode'].'"><img id="authcode_img" src="./lib/authCode.class.php" style="vertical-align:middle; border:0px;" /></a></span></div>';	
}

$module['circle']=get_circle_option($pdo);
$module['class_name']=self::$config['class_name'];
$module['web_language']=self::$config['web']['language'];
$module['map_api']=self::$config['web']['map_api'];

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);


require_once "./plugin/html4Upfile/createHtml4.class.php";
$html4Upfile=new createHtml4();
$html4Upfile->echo_input("icon",'100%','./temp/','true','false','jpg|gif|png|jpeg',1024*10,'1');
//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');
//指定保存名时，要先设置权限 $_SESSION['replace_file']=true;  ，否则将无效
echo '<div style="display:none;" id="visitor_position_append">'.self::get_type_position($pdo,$type).self::$language['pages']['ci.add']['name'].'</div>';

