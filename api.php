<?php
//var_dump($_POST);
function arrayToXml($arr){
	$xml = "<xml>";
	foreach ($arr as $key=>$val){
		if (is_numeric($val)){
			$xml.="<".$key.">".$val."</".$key.">";
		}else{
			if(is_array($val)){
				if(is_numeric($key)){$key='id_'.$key;}
				$xml2='';
				foreach($val as $k2=>$v2){
					if(is_numeric($v2)){
						$xml2.='<'.$k2.'>'.$v2.'</'.$k2.'>';				
					}else{
						if(is_array($v2)){
							if(is_numeric($k2)){$k2='id_'.$k2;}
							$xml3='';
							foreach($v2 as $k3=>$v3){
								if(is_numeric($v2)){
									$xml3.='<'.$k3.'>'.$v3.'</'.$k3.'>';	
								}else{
									$xml3.="<".$k3."><![CDATA[".$v3."]]></".$k3.">";	
								}
							}
							$xml2.="<".$k2.">".$xml3."</".$k2.">";
						}else{
							$xml2.="<".$k2."><![CDATA[".$v2."]]></".$k2.">";		
						}
						
					}
					
				}
				 $xml.="<".$key.">".$xml2."</".$key.">";
			}else{
				
				 $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
			}
			
		}
	}
	$xml.="</xml>";
	return $xml;
}
function return_api($r){
	if(isset($_GET['api'])){
		if(@$_GET['return']=='json'){
			$r = json_encode($r);
		}else{
			$r= arrayToXml($r);
		}
		echo $r;		
	}
	exit;	
}
ob_start();
libxml_disable_entity_loader(true);
header('Content-Type:text/html;charset=utf-8');
require_once './config/functions.php';
session_start();
$_POST=monxin_trim($_POST);
$_POST=safe_str($_POST);
$_GET=monxin_trim($_GET);
$config=require_once './config.php';
$config['server_url']="http://www.monxin.com/";
$timeoffset=($config['other']['timeoffset']>0)? "-".$config['other']['timeoffset']:str_replace("-","+",$config['other']['timeoffset']);
date_default_timezone_set("Etc/GMT$timeoffset");
$language=require_once './language/'.$config['web']['language'].'.php';
$language['err_msg'][0]='请求成功';
$language['err_msg'][1]='密钥错误';
$language['err_msg'][2]='IP不在白名单内';
$language['err_msg'][3]='请求接口不存在';
$language['err_msg'][4]='请指定请求接口 api';
$language['err_msg'][5]='处理失败';
$language['err_msg'][6]='处理成功';
$language['err_msg'][7]='无权访问此API,请先申请。';
$language['err_msg'][8]='此apikey,已被禁用';
$language['err_msg'][9]='此API,已关闭';
$language['new_user_money']='新增会员，导入余额';
$language['new_user_credits']='新增会员，导入积分';
$language['order_detail_need_id']='id 或 out_id 必填一项';
$pdo=new  ConnectPDO();
if(!isset($_GET['api'])){
	$r=array('err_code'=>'1','err_msg'=>$language['err_msg'][4]);
	return_api($r);
}
$api=$_GET['api'];
$api=explode(".",$api);
$program=$api[0];

if(!isset($_POST['apikey'])){
	$r=array('err_code'=>'1','err_msg'=>$language['err_msg'][1]);
	return_api($r);
}
$sql="select * from ".$pdo->sys_pre."api_user where `key`='".safe_str($_POST['apikey'])."' limit 0,1";
$u=$pdo->query($sql,2)->fetch(2);
if($u['id']==''){
	$r=array('err_code'=>'1','err_msg'=>$language['err_msg'][1]);
	return_api($r);
}
if($u['state']==0){
	$r=array('err_code'=>'1','err_msg'=>$language['err_msg'][8]);
	return_api($r);
}

$api_power=explode(',',$u['api_power']);
if(!in_array($_GET['api'],$api_power)){
	$r=array('err_code'=>'1','err_msg'=>$language['err_msg'][7]);
	return_api($r);
}

$sql="select * from ".$pdo->sys_pre."api_list where `api`='".$_GET['api']."' limit 0,1";
$a=$pdo->query($sql,2)->fetch(2);
if($a['id']==''){
	$r=array('err_code'=>'1','err_msg'=>$language['err_msg'][3]);
	return_api($r);
}
if($a['state']==0){
	$r=array('err_code'=>'1','err_msg'=>$language['err_msg'][9]);
	return_api($r);
}

$path= "./api/{$api[0]}/{$api[1]}.php";
if(!is_file($path)){
	$r=array('err_code'=>'1','err_msg'=>$language['err_msg'][3]);
	return_api($r);
}

$sql="insert into ".$pdo->sys_pre."api_log (`key`,`ip`,`api`,`post`,`time`) values ('".safe_str($_POST['apikey'])."','".get_ip()."','".$_GET['api']."','".json_encode($_POST)."','".time()."')";
$pdo->exec($sql);

require $path;
?>