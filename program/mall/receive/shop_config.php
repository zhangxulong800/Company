<?php
$act=@$_GET['act'];
if($act=='update'){	
	//exit("{'state':'fail','info':'<span class=fail>xxx</span>'}"); 
	$field=array('name','main_business','area','address','position','phone','email','talk_account');
	foreach($field as $v){
		if(@$_POST[$v]==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','key':'".$v."'}");}
	}
	if(!is_match(self::$config['other']['reg_phone'],$_POST['phone'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['pattern_err']."</span>','key':'phone'}");}
	if(!is_email($_POST['email'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['pattern_err']."</span>','key':'email'}");}
	$_POST=safe_str($_POST);
	
	$head=$_POST['head'];
	if($head!=''){
		$sql="select `id` from ".self::$table_pre."headquarters where `name`='".$head."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".$head.self::$language['not_exist']."</span>'}");}
			
	}
	
	
	$sql="select * from ".self::$table_pre."shop where `username`='".$_SESSION['monxin']['username']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	
	$_POST['template']=de_safe_str($_POST['template']);
	$sql="select `dir` from ".self::$table_pre."template where `state`=1 and (`for_shop`='*' or `for_shop`='".$r['id']."') order by `sequence` desc";
	$r2=$pdo->query($sql,2);
	$allow_templates=array();
	foreach($r2 as $v){
		$allow_templates[]=$v['dir'];	
	}
	if(!in_array($_POST['template'],$allow_templates)){exit("{'state':'fail','info':'<span class=fail>".self::$language['illegal_use']."</span>','key':'template'}");}
	
	
	
	$old=de_safe_str($r);
	if($r['state']==1){exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].":".self::$language['shop_state'][0]." ".self::$language['forbidden_modify']."</span>'}");}
	$id=$r['id'];
	$sql="select `id` from ".self::$table_pre."shop where `name`='".$_POST['name']."' and `state`!=1 and `id`!=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>','key':'name'}");}
	
	$sql="select `id` from ".self::$table_pre."shop where `email`='".$_POST['email']."' and `state`!=1 and `id`!=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>','key':'email'}");}
	
	$sql="select `id` from ".self::$table_pre."shop where `phone`='".$_POST['phone']."' and `state`!=1 and `id`!=".$id;;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>','key':'phone'}");}
		
	$sql="select `id` from ".self::$table_pre."shop where `domain`='".$_POST['domain']."' and `state`!=1 and `id`!=".$id;;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>','key':'domain'}");}
	$time=time();
	
	$geohash=new Geohash;
	$temp=explode(',',$_POST['position']);
	$geohash_str=$geohash->encode($temp[1],$temp[0]);

	$sql="update ".self::$table_pre."shop set `name`='".$_POST['name']."',`head`='".$_POST['head']."',`main_business`='".$_POST['main_business']."',`address`='".$_POST['address']."',`position`='".$_POST['position']."',`area`='".$_POST['area']."',`phone`='".$_POST['phone']."',`email`='".$_POST['email']."',`last_time`=".$time.",`domain`='".$_POST['domain']."',`template`='".$_POST['template']."',`talk_type`='".intval($_POST['talk_type'])."',`talk_account`='".$_POST['talk_account']."',`expiration`='".intval($_POST['expiration'])."',`circle`='".intval($_POST['circle'])."',`barcode_repeat`='".intval($_POST['barcode_repeat'])."',`geohash`='".$geohash_str."',`shop_c_password`='".intval($_POST['shop_c_password'])."' ";
	
	$sql.="where `id`=".$id;
	if($pdo->exec($sql)){
		if($_POST['icon']!='' && file_exists('./temp/'.$_POST['icon'])){
			@safe_unlink('./program/mall/shop_icon/'.$id.'.png');
			safe_rename('./temp/'.$_POST['icon'],'./program/mall/shop_icon/'.$id.'.png');
		}
		if($_POST['ticket_logo']!='' && file_exists('./temp/'.$_POST['ticket_logo'])){
			@safe_unlink('./program/mall/ticket_logo/'.$id.'.png');
			safe_rename('./temp/'.$_POST['ticket_logo'],'./program/mall/ticket_logo/'.$id.'.png');
		}
		if($_POST['wxkf']!='' && file_exists('./temp/'.$_POST['wxkf'])){
			@safe_unlink('./program/mall/wxkf/'.$id.'.png');
			safe_rename('./temp/'.$_POST['wxkf'],'./program/mall/wxkf/'.$id.'.png');
		}
		
		if($old['name']!=$_POST['name']){
			$sql="update ".self::$table_pre."shop set `name_log`='".safe_str($old['name_log'])."<br />".$_POST['name']." ".date('Y-m-d H:i').""."' where `id`=".$id;
			$pdo->exec($sql);
		}
		
		if($_POST['domain']!=''){
			$url='http://'.$_POST['domain'].'.'.str_replace('www.','',self::$config['web']['domain']);
		}else{
			$url='http://'.self::$config['web']['domain'].'/index.php?monxin=mall.shop_index&shop_id='.$id;	
		}

		$url=self::update_shop_qr_path($pdo,$id);
		self::create_qr($url,'./program/mall/shop_icon/'.$id.'.png','./program/mall/shop_qr/'.$id.'.png',300);
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
		
}