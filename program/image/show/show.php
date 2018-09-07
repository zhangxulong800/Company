<?php
$id=intval(@$_GET['id']);
$type=intval(@$_GET['type']);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);

if($id==0){echo (self::$language['need_params']);return false;}else{

	$sql="select * from ".self::$table_pre."img where `id`=$id";			
	$v=$pdo->query($sql,2)->fetch(2);
	$v['src']="./program/image/img/".$v['src'];
	$v['content']=de_safe_str($v['content']);
	$_GET['type']=$v['type'];
	
	$sql="select `title`,`src`,`id` from ".self::$table_pre."img where `visible`=1";
	$where="";
	
	if($type>0){
		$type_ids=$this->get_type_ids($pdo,$_GET['type']);
		$where.=" and `type` in (".$type_ids.")";
	}
	if($_GET['search']!=''){$where=" and (`title` like '%".$_GET['search']."%' or `src` like '%".$_GET['search']."%' or `content` like '%".$_GET['search']."%')";}
	$_GET['order']=@$_GET['order'];
	if($_GET['order']==''){
		$order=" order by `sequence` desc,`id` desc";
	}else{
		$_GET['order']=safe_str($_GET['order']);
		$temp=safe_order_by($_GET['order']);
		$temp[1]=@$temp[1];
		if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}		
	}
	//echo $order;
	$limit=' limit 0,1000';
	$sql=$sql.$where.$order.$limit;
	//echo $sql;
	$r=$pdo->query($sql,2);			
	$list='';
	$module['img_list']='';
	foreach($r as $vv){
		$list.="<a id=".$vv['id']." href='./index.php?monxin=image.show&id=".$vv['id']."&type=$type&search=".urlencode($_GET['search'])."&order=".$_GET['order']."'><img osrc=./program/image/img_thumb/".$vv['src']."  title=\"".$vv['title']."\"  ></a>";	
		$module['img_list'].="<li><img osrc=./program/image/img/".$vv['src']." id=i_".$vv['id']." title=".$vv['title']." /></li>";	
	}
$module['go_url']="./index.php?monxin=image.show&type=$type&search=".urlencode($_GET['search'])."&order=".$_GET['order']."&id=";
$module['count_url']="receive.php?target=".$method."&id=".$id;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['thumbs']=$list;


if(@$_COOKIE['touch']){
	$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'_touch.php';
	if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'_touch.php';}
	require($t_path);
}else{
	$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
	if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
	require($t_path);
}
	

}
echo '<div id="visitor_position_reset" style="display:none;"><span id=current_position_text>'.self::$language['current_position'].'</span><a href="./index.php"><span id=visitor_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a>'.$this->get_type_position($pdo,$v['type']).'</div>';
