<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;

$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select `goods_id`,`time` from ".self::$table_pre."favorite where `username`='".$_SESSION['monxin']['username']."' order by `id` desc limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql="select count(id) as c  from ".self::$table_pre."favorite where `username`='".$_SESSION['monxin']['username']."'";
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$r=$pdo->query($sql,2);
$ids='';
$index=array();
$time=array();
foreach($r as $v){
	$ids.=$v['goods_id'].',';
	$index[]=$v['goods_id'];
	$time[$v['goods_id']]=$v['time'];	
}
$ids=trim($ids,',');
if($ids==''){echo '<div align="center"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></div>'; return false;}
$sql="select `id`,`icon`,`title` from ".self::$table_pre."goods where `id` in(".$ids.")";
$r=$pdo->query($sql,2);
$goods=array();
foreach($r as $v){
	$v=de_safe_str($v);	
	$goods[$v['id']]="<div class=goods id=".$v['id']."><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank class=goods_a><img src='./program/mall/img_thumb/".$v['icon']."' /><span class=title>".$v['title']."</span></a><div class=sub_div><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$time[$v['id']])."</span><a href=# class=del>&nbsp;</a></div></div>";
	
		
}
$list='';
foreach($index as $v){
	if(isset($goods[$v])){$list.=$goods[$v];}
}
if($sum==0){$list='<div align="center"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></div>';}		
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);


		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);