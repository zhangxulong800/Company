<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$dir=@$_GET['dir'];
$dir=str_replace('//','/',$dir.'/');
$path=str_replace('..','.','./templates/'.$dir);
if(!is_dir($path)){ echo(self::$language['dir'].self::$language['not_exist']);return false;}
$module['dir']=get_dir_link($dir,'./index.php?monxin=index.template_edit&dir=');
$r=scandir($path);
$list='';

//clearstatcache();
foreach($r as $v){
	
	if($v=='.' || $v=='..'){continue;}
	if(is_dir($path.$v)){
		$style='file_icon_dir';
		$href='./index.php?monxin=index.template_edit&dir='.$dir.$v;
		$file_size="<td class=size>&nbsp;</td>";
		//$colspan='colspan=2';
		$replace='';
	}else{
		$colspan='';
		$file_size="<td class=size>".formatSize(filesize($path.$v))."</td>";
		$temp=explode('.',$v);
		$postfix=$temp[count($temp)-1];
		$style='file_icon_'.$postfix;
		if($postfix=='php' || $postfix=='txt' || $postfix=='js' || $postfix=='css'){
			$href='./index.php?monxin=index.template_edit_file&path='.$dir.$v.'&refresh='.time().' target=_blank ';
		}else{
			$href=$path.$v.' target=_blank ';
		}	
		$replace="<a href='./index.php?monxin=index.template_replace_file&path=".$dir.$v."&refresh=".time()."' target=_blank class='replace'>".self::$language['replace']."</span><span class=b_end></span>&nbsp;</a>";
	}
	$list.="<tr id='tr_".str_replace('.','__',$v)."'>
	<td class=name ><a class=$style href=$href>$v</a></td>
	".$file_size."
	<td class=time>".get_time(self::$config['other']['date_style'].' H:i',self::$config['other']['timeoffset'],self::$language,filemtime($path.$v))."</td>
	<td class=operation_td><a href='#' onclick='return del(\"".$v."\")'  class='del'>".self::$language['del']."</span><span class=b_end></span>&nbsp;</a> $replace<span id=state_".$v." class='state'></span></td>
</tr>
";	
}
if($list==''){$list='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;

require "./plugin/html5Upfile/createHtml5.class.php";
$html5Upfile=new createHtml5();
$html5Upfile->echo_input(self::$language,"up_new",'auto','','./temp/','false','true','txt|jpg|jpeg|png|gif|css',1024*get_upload_max_size(),'0');
//echo_input("house_model",'控件宽度(百分比或像素)','multiple','保存到文件夹','文件是否附加日期','是否原名保存','允许文件类型','文件最大值','文件最小值');			



$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);	