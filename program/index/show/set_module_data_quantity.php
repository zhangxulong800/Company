<?php
$module_name=@$_GET['module'];
echo " <script>
$(document).ready(function(){
$('#edit_page_layout_div').attr('id','').css('display','none');
	
});
</script>

";
if($module_name==''){
	echo self::$language['need_params'];
	return false;
}
$module_name=preg_replace('/_/','.',$module_name,1);
//echo $module_name;
$t=explode('.',$module_name);
if(!file_exists('./program/'.$t[0].'/module_config.php')){return false;}
$module_config=require('./program/'.$t[0].'/module_config.php');
if(!isset($module_config[$module_name])){echo '<div style="width:500px; height:100px; margin-top:30px; text-align:center; float:left; "><span class="inoperable">'.self::$language['inoperable'].'</span></div>'; return false;}
if(!is_numeric($module_config[$module_name]['pagesize'])){echo '<div style="width:500px; height:100px; margin-top:30px; text-align:center; float:left; "><span class="inoperable">'.self::$language['inoperable'].'</span></div>';   return false;}
$module['pagesize']=$module_config[$module_name]['pagesize'];
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&module_name=".$module_name;
$module['module_name']=str_replace("::","_",$method);




$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);	
