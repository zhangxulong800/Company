<?php
$act=@$_GET['act'];
if($act=='submit'){
	//var_dump($_POST);
	if(self::$config['web']['wid']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['no_web_weixin']."</span> <a href=./index.php?monxin=index.config#div_web__wid>".self::$language['set']."</a>'}");}
	
	$_POST=safe_str($_POST);
	foreach($_POST as $k=>$v){
		if($v==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'".$k."'}");}	
	}
	
	$pack_min=floatval($_POST['pack_min']);
	$pack_max=floatval($_POST['pack_max']);
	
	if($pack_min<1){exit("{'state':'fail','info':'<span class=fail>".self::$language['less_than']." 1</span>','id':'pack_min'}");}
	if($pack_max>200){exit("{'state':'fail','info':'<span class=fail>".self::$language['greater_than']." 200</span>','id':'pack_max'}");}
	if($pack_max<$pack_min){exit("{'state':'fail','info':'<span class=fail>".self::$language['less_than']." ".$pack_min."</span>','id':'pack_max'}");}
	
	$_POST['addressee']=explode(',',$_POST['addressee']);
	$_POST['addressee']=array_unique($_POST['addressee']);
	$ignore='';
	$success=0;
	$fail=0;
	foreach($_POST['addressee'] as $addressee){
		if($addressee==''){continue;}
		$addressee=trim($addressee,',');
		$sql="select `id`,`openid` from ".$pdo->index_pre."user where `username`='".$addressee."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		
		
		if($r['id']==''){
			$info="{'state':'fail','info':'<span class=fail>".self::$language['username'].':'.$addressee." ".self::$language['not_exist']."</span>','id':'addressee'}";	
			exit($info);
		}
		if($r['openid']==''){
			$ignore.=$addressee.',';
		}else{
			if($pack_min==$pack_max){$money=$pack_min;}else{$money=rand($pack_min*100,$pack_max*100)/100;}
			$result=wexin_red_pack($pdo,$addressee,$_POST['sender'],$_POST['wishing'],$money,'prize');
			if(!$result){
				$fail++;
			}else{
				$success++;
			}
				
		}	
	}
	if($ignore!=''){$ignore=self::$language['no_openid_ignore'].'<br >'.$ignore;}
	
	if($success>0){
		exit("{'state':'success','info':'<span class=success>".self::$language['success'].":".$success." ".self::$language['fail'].":".$fail."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail'].' '.$ignore."</span>'}");	
	}
}