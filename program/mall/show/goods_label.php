<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$ids=safe_str(@$_GET['ids']);
$ids=str_replace('|',',',$ids);
$ids=trim($ids,',');
$module['shop_id']=SHOP_ID;

if(!isset($_GET['min'])){$_GET['min']=1;}
if(!isset($_GET['max'])){$_GET['max']=7;}

$min=$_GET['min'];
$max=$_GET['max'];

$sql="select `id`,`title`,`bar_code`,`option_enable` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and `state`=2 and `id` in (".$ids.")";

if($ids==''){$sql="select `id`,`title`,`bar_code`,`option_enable` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and `state`=2";}

$_GET['type']=intval(@$_GET['type']);
if($_GET['type']>0){
	$type_ids=$this->get_shop_type_ids($pdo,$_GET['type']);
	$sql.=" and `shop_type` in (".$type_ids.")";
}
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
if($_GET['search']!=''){$sql.=" and (`title` like '%".$_GET['search']."%' or `advantage` like '%".$_GET['search']."%' or `bar_code` like '%".$_GET['search']."%' or `speci_bar_code` like '%".$_GET['search']."%' or `store_code` like '%".$_GET['search']."%' or `speci_store_code` like '%".$_GET['search']."%' or `detail` like '%".$_GET['search']."%')";}


$r=$pdo->query($sql,2);
$pages=array();
$page=1;
$i=1;
$pages[$page]='';
$list='';
foreach($r as $v){
	$v['title']=de_safe_str($v['title']);
	if($v['option_enable']==1){
		$sql="select `color_name`,`option_id`,`barcode`,`e_price` from ".self::$table_pre."goods_specifications where `goods_id`=".$v['id'];
		$r2=$pdo->query($sql,2);
		foreach($r2 as $v2){
			if($v2['barcode']==0){continue;}
			if(strlen($v2['barcode'])>=$min && strlen($v2['barcode'])<$max ){
				$list.='<div class=goods><img src="http://'.self::$config['web']['domain'].'/plugin/barcode/buildcode.php?codebar=BCGcode128&text='.$v2['barcode'].'" /><span>'.self::get_type_option_name($pdo,$v2['option_id']).' '.$v2['color_name'].' '.$v['title'].'</span></div>';
				$i++;
			}
		}
	}else{
		if($v['bar_code']==0){continue;}
		if(strlen($v['bar_code'])>=$min && strlen($v['bar_code'])<=$max ){
			$list.='<div class=goods><img src="http://'.self::$config['web']['domain'].'/plugin/barcode/buildcode.php?codebar=BCGcode128&text='.$v['bar_code'].'" /><span>'.$v['title'].'</span></div>';
			$i++;
		}
	}
	
	
}

$module['list']=$list;


function get_type_filter($pdo,$language,$list){
$list2="<option value='-1'>".$language['belong']."</option>";
$list2.="<option value='' selected>".$language['all'].$language['type']."</option>";
$_GET['type']=@$_GET['type']?@$_GET['type']:0;
$list2.=$list;
$list="<select name='type_filter' id='type_filter'>{$list2}</select>";
return $list;
}

$list=$this->get_shop_parent($pdo,0,3);
$module['filter']=get_type_filter($pdo,self::$language,$list);


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
