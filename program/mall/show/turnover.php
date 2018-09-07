<?php
//echo get_unixtime('2015-09-17',self::$config['other']['date_style']);
if(!SHOP_ID){header('location:./index.php?monxin=mall.apply_shop');exit;}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$time=time();
$today=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);
if(!isset($_GET['start_time']) || !isset($_GET['end_time'])){header('location:./index.php?monxin=mall.turnover&start_time='.$today.'&end_time='.$today.'');exit;}

$time=get_unixtime($today,'y-m-d')-86400;
$yesterday=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);

$time=get_unixtime($yesterday,'y-m-d')-86400;
$before_yesterday=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);

$time=get_unixtime($today,'y-m-d')-(86400*6);
$days_7=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);

$time=get_unixtime($today,'y-m-d')-(86400*29);
$days_30=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);

$module['days']='<a href="./index.php?monxin=mall.turnover&start_time='.$today.'&end_time='.$today.'">'.self::$language['today'].'</a>';
$module['days'].='<a href="./index.php?monxin=mall.turnover&start_time='.$yesterday.'&end_time='.$yesterday.'">'.self::$language['yesterday'].'</a>';
$module['days'].='<a href="./index.php?monxin=mall.turnover&start_time='.$before_yesterday.'&end_time='.$before_yesterday.'">'.self::$language['before_yesterday'].'</a>';
$module['days'].='<a href="./index.php?monxin=mall.turnover&start_time='.$days_7.'&end_time='.$today.'">'.self::$language['days_7'].'</a>';
$module['days'].='<a href="./index.php?monxin=mall.turnover&start_time='.$days_30.'&end_time='.$today.'">'.self::$language['days_30'].'</a>';


$start_time=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);
$end_time=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86400;
$time_limit=" `add_time`>$start_time and `add_time`<$end_time ";

$sql="select sum(actual_money) as c from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and ".$time_limit." and `state` in (1,2,6)";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['sum_turnover']=$r['c'];

$sql="select sum(goods_cost) as c from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and ".$time_limit." and `state` in (1,2,6)";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['goods_cost']=$r['c'];

$sql="select sum(express_cost_seller) as c from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and ".$time_limit." and `state` in(1,2,6)";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['express_charge']=$r['c'];


$module['profit']=$module['sum_turnover']-$module['goods_cost']-$module['express_charge'];
$module['profit']=sprintf("%.2f",$module['profit']);


$sql="select count(id) as c from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and ".$time_limit." and `state` in (1,2,6)";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['order_count']=$r['c'];

$sql="select sum(goods_count) as c from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and ".$time_limit." and `state` in (1,2,6)";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['goods_count']=self::format_quantity($r['c']);

$sql="select count(t.id) as c from (select `id` from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and ".$time_limit." and `buyer`!=''  and  `state` in (1,2,6) group by `buyer`) t";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
//$r['c']--;
if($r['c']==-1){$r['c']=0;}
$module['user_count']=$r['c'];


//===============================================================================================================================sum_info

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);