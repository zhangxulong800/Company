<?php
echo " <script>
$(document).ready(function(){
$('#edit_page_layout_div').attr('id','').css('display','none');
	
});
</script>

";
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$path=@$_GET['path'];
if($path==''){echo '<div align="left" style="padding:20px;">'.self::$language['is_null'].'</div>';return false;}
$file_name=trim((strrchr($path,'/')),'/');
$dir=str_replace($file_name,'',$path);
$postfix=trim((strrchr($file_name,'.')),'.');

if(in_array($postfix,array('png','jpg','gif',))){$postfix='png|jpg|gif';}

$max_size=(isset($_GET['max_size']))?$_GET['max_size']:500;
$min_size=(isset($_GET['min_size']))?$_GET['min_size']:1;
$_SESSION['replace_file']=true;		
require "./plugin/html4Upfile/createHtml4.class.php";
$html4Upfile=new createHtml4();
$html4Upfile->echo_input("new_file",'50%',$dir,'false','true',$postfix,$max_size,$min_size,$file_name);
//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');
	
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);	
