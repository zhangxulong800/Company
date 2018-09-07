<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$current_page=intval(isset($_GET['current_page'])?$_GET['current_page']:1);
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

if(isset($_SESSION['monxin']['id'])){
	$sql="select `credits` from ".$pdo->index_pre."user where `id`=".$_SESSION['monxin']['id'];
	$r=$pdo->query($sql,2)->fetch(2);
	$module['credits']=intval($r['credits']);
}else{
	$module['credits']=0;
}


$sql="select `id`,`name`,`money`,`url` from ".self::$table_pre."prize where `state`=1 and `quantity`>0";

$where="";
$order=" order by `sequence` desc";
$limit=" limit ".($current_page-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" `id`,`name`,`money`,`url` "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_prize and","_prize where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_prize and","_prize where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
	if($v['url']!=''){$v['name'].=" <a href=".$v['url']." target=_blank>".self::$language['detail']."</a>";}
	if($_COOKIE['monxin_device']=='pc'){
		$list.="<div class=prize id=prize_".$v['id']."><div class=icon_div><img src='./program/credit/img/".$v['id'].".jpg' /></div><div class=name>".$v['name']."</div><div class=other><span class=credit>".self::$language['needed'].self::$language['credit'].":<span class=v>".$v['money']."</span></span><span class=act><a href=# class=exchange user_color=button d_id=".$v['id'].">".self::$language['exchange']."</a> <span class=state></span></span></div></div>";
	}else{
		$list.="<div class=prize id=prize_".$v['id']."><div class=icon_div><img src='./program/credit/img/".$v['id'].".jpg' /></div><div class=name>".$v['name']."</div><div class=other><span class=credit>".self::$language['credit'].":<span class=v>".$v['money']."</span></span><span class=act><a href=# class=exchange user_color=button d_id=".$v['id'].">".self::$language['exchange']."</a> <span class=state></span></span></div></div>";
	}	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['class_name']=self::$config['class_name'];
$module['page']=MonxinDigitPage($sum,$current_page,$page_size,'#'.$module['module_name']);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
echo '<div style="display:none;" id="visitor_position_append">'.self::$language['pages']['credit.use']['name'].'</div>';

