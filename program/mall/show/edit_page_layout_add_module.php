<?php

$program='mall';
if(@$_GET['area']==''){echo ('area is null');return false;}
$_GET['params']=str_replace('|||','&',@$_GET['params']);
$_POST['share_module']='';
$p_language=self::$language;

function get_modules($program,$p_language,$modules){
	$m=require('./program/mall/module_config.php');
	$list='';
	foreach($m as $key=>$v){
		$key2=preg_replace('/(\(.*\))/','',$key);
		if($key=='mall.diymodule_show' || $key=='mall.diypage_show' ||  $key=='mall.slider_show' ){continue;}
		if(in_array($key2,$modules)){
			if($key2=='mall.goods' && $_GET['url']!=$key2){continue;}
			if($key2=='mall.shop_goods_list' && $_GET['url']!=$key2){continue;}
			if(isset($p_language['functions'][$key2]['description'])){$name=$p_language['functions'][$key2]['description'];}elseif(isset($p_language['pages'][$key2]['name'])){$name=$p_language['pages'][$key2]['name'];}else{$name=$key;}
			$module_name=preg_replace('/\./','_',$key);
			if($_GET['url']==$key){$view_page=$key;}else{$_POST['share_module'].=$key.',';$view_page='mall.edit_page_layout_view_module';}
			$url='./index.php?monxin='.$view_page.'&edit_page_layout=true&edit_page_malllayout_view_module='.$module_name.'&#'.$module_name;
			$list.="<a href='".$url."' target=_blank module_name='".$key."' class=module_a>".$name."</a>";	
		}
	}
	return $list;
}


$c='';

$p_config=require('./program/mall/config.php');
$p_language=require('./program/mall/language/'.$p_config['program']['language'].'.php');
$list=get_modules($program,$p_language,self::$config['mall_layout_modules']);

$sql="select `id`,`title` from ".self::$table_pre."module where `shop_id`='".SHOP_ID."' order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
foreach($r as $v){
	$url='./index.php?monxin=mall.edit_page_layout_view_module&edit_page_layout=true&edit_page_malllayout_view_module=mall_diymodule_show_'.$v['id'].'&#mall_diymodule_show_'.$v['id'];
	$list.="<a href='".$url."' target=_blank module_name='mall.diymodule_show_".$v['id']."' class=module_a>".$v['title']."</a>";		
}

$sql="select `id`,`title` from ".self::$table_pre."slider where `shop_id`='".SHOP_ID."' order by `id` asc";
$r=$pdo->query($sql,2);
foreach($r as $v){
	$url='./index.php?monxin=mall.edit_page_layout_view_module&edit_page_layout=true&edit_page_malllayout_view_module=mall_slider_show_'.$v['id'].'&#mall_slider_show_'.$v['id'];
	$list.="<a href='".$url."' target=_blank module_name='mall.slider_show_".$v['id']."' class=module_a>".$v['title']."</a>";		
}


$c.="<fieldset><legend>".$p_language['program_name']."</legend>".$list."</fieldset>";

	
$module['list']=$c;



$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&url=".$_GET['url'].'&area='.$_GET['area'];
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);


		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);


