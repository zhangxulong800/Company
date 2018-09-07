<?php
//output_table($pdo,'./data/');
//input_table($pdo,'./data/2013-11-28 23-52_19331__3.sql');

if(@$_GET['act']=='add_index'){
	$add_index=array('username','shop_id','goods_id','key','seller','buyer','user_id','bar_code','store_code','barcode');
	$sql="SHOW TABLES";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$s=serialize($v);
		$s=unserialize($s);
		foreach($s as $k=>$ss){$table_key=$k;}
		$sql="SHOW COLUMNS FROM ".$v[$table_key]."";
		//echo $sql.'<br />';
		$c=$pdo->query($sql,2);
		foreach($c as $kk=>$vv){
			if(in_array($vv['Field'],$add_index) && $vv['Key']!='MUL'){
				$sql="ALTER TABLE  `".$v[$table_key]."` ADD INDEX (  `".$vv['Field']."` );";
				$pdo->exec($sql);
				echo $sql.'<br />';	
			}
		}
		
	}
}


$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;

$list='';

$dir=new Dir();	
$r=$dir->show_dir('./data/',$postfix=array('sql'),$sub=false,$require_dir=false);
$r=array_reverse($r);
foreach($r as $v){
	$name=str_replace('./data/','',$v);
	$name2=str_replace('.sql','',$name);
	
	$list.="<tr id='tr_".$name2."'>
	<td class=name>$name</td>
	<td class=size>".formatSize(filesize($v))."</td>
	<td class=time>".get_time(self::$config['other']['date_style'].' H:i',self::$config['other']['timeoffset'],self::$language,filemtime($v))."</td>
	<td class=operation_td><a href='#' onclick='return recover(\"".$name2."\")'  class='recover'>".self::$language['recover']."</span><span class=b_end></span>&nbsp;</a><a href='".$module['action_url']."&act=download&file=".$v."' target=_blank class='download'>".self::$language['download']."</span><span class=b_end></span>&nbsp;</a><a href='#' onclick='return del(\"".$name2."\")'  class='del'>".self::$language['del']."</span><span class=b_end></span>&nbsp;</a> <span id=state_".$name2." class='state'></span></td>
</tr>
";	
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
$html5Upfile->echo_input(self::$language,"upfile",'385px','multiple','./data/','false','true','sql',1024*get_upload_max_size(),'0');
//echo_input("house_model",'控件宽度(百分比或像素)','multiple','保存到文件夹','文件是否附加日期','是否原名保存','允许文件类型','文件最大值','文件最小值');			
