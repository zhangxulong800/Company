<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);

$sql="select * from ".$pdo->sys_pre."api_user where `username`='".$_SESSION['monxin']['username']."' limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){
	$key=get_random(32);
	$sql="select `id` from ".$pdo->sys_pre."api_user where `key`='".$key."' limit 0,1";
	$e=$pdo->query($sql,2)->fetch(2);
	if($e['id']!=''){
		$key=get_random(32);
			$sql="select `id` from ".$pdo->sys_pre."api_user where `key`='".$key."' limit 0,1";
			$e=$pdo->query($sql,2)->fetch(2);
			if($e['id']!=''){
				$key=get_random(32);
				$sql="select `id` from ".$pdo->sys_pre."api_user where `key`='".$key."' limit 0,1";
				$e=$pdo->query($sql,2)->fetch(2);
				if($e['id']!=''){
					echo '<div class=return_false>key create fail</div>';return false;
				}
			}

	}
	
	$sql="insert into ".$pdo->sys_pre."api_user (`key`,`username`,`time`) values ('".$key."','".$_SESSION['monxin']['username']."','".time()."')";
	$pdo->exec($sql);
	$sql="select * from ".$pdo->sys_pre."api_user where `username`='".$_SESSION['monxin']['username']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
}
if($r['id']==''){echo '<div class=return_false>api_user null</div>';return false;}
$module['data']=$r;

$application=explode(',',$r['application']);
$api_power=explode(',',$r['api_power']);

$sql="select * from ".$pdo->sys_pre."api_list";

$where="";

if($_GET['search']!=''){$where=" and (`name` like '%".$_GET['search']."%' or `api` like '%".$_GET['search']."%')";}
if(@$_GET['order']==''){
	$order=" order by `sequence` desc,`id` asc";
}else{
	$_GET['order']=safe_str($_GET['order']);
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_api_list and","_api_list where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order;
$sql=str_replace("_api_list and","_api_list where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
$api_exist='';
$api_application='';
$api_other='';



foreach($r as $v){
	$v=de_safe_str($v);
	$v['api_a']='<a class=doc_url href='.$v['doc_url'].' target="_blank">'.$v['api'].'</a>';
	
	if(in_array($v['api'],$api_power)){
		$api_exist.="<tr id='tr_".$v['id']."'>
	<td>".$v['api_a']."</td>
	<td>".$v['name']."</td>
	<td>".self::$language['api_state']['api_exist']."</td>
</tr>";	
		continue;
	}
	if(in_array($v['api'],$application)){
		$api_application.="<tr id='tr_".$v['id']."'>
	<td>".$v['api_a']."</td>
	<td>".$v['name']."</td>
	<td>".self::$language['api_state']['api_application']."</td>
</tr>";	
		continue;
	}
	
	$api_other.="<tr id='tr_".$v['id']."'>
	<td>".$v['api_a']."</td>
	<td>".$v['name']."</td>
	<td>".self::$language['api_state']['api_other']." <a href=# class=apply d_id=".$v['id'].">".self::$language['apply_2']."</a> <span class=state id=state_".$v['id']."></span></td>
</tr>";	
	
}

$list=$api_exist.$api_application.$api_other;


if($list==''){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['class_name']=self::$config['class_name'];
$module['list']=$list;

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
