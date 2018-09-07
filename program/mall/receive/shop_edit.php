<?php
$act=@$_GET['act'];
if($act=='update'){	
	//exit("{'state':'fail','info':'<span class=fail>xxx</span>'}"); 
	if(intval(@$_GET['id'])==0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	$id=intval(@$_GET['id']);
	$field=array('run_type','certificate_id','name','self_certificate_id','main_business','area','address','position','phone','email');
	foreach($field as $v){
		if(@$_POST[$v]==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','key':'".$v."'}");}
	}
	if($_POST['run_type']=='0'){
		if(!is_match(self::$config['certificate_reg'],$_POST['certificate_id'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['pattern_err']."</span>','key':'certificate_id'}");}
	}else{
		if(!is_match(self::$config['business_license_reg'],$_POST['certificate_id'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['pattern_err']."</span>','key':'certificate_id'}");}
	}
	if(!is_match(self::$config['certificate_reg'],$_POST['self_certificate_id'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['pattern_err']."</span>','key':'self_certificate_id'}");}
	if(!is_match(self::$config['other']['reg_phone'],$_POST['phone'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['pattern_err']."</span>','key':'phone'}");}
	if(!is_email($_POST['email'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['pattern_err']."</span>','key':'email'}");}
	$_POST=safe_str($_POST);
	
	$sql="select * from ".self::$table_pre."shop where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['state']==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].":".self::$language['shop_state'][0]." ".self::$language['forbidden_modify']."</span>'}");}
	$old=$r;
	
	$sql="select `id` from ".self::$table_pre."shop where `certificate_id`='".$_POST['certificate_id']."' and `state`!=1 and `id`!=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>','key':'certificate_id'}");}
	
	$sql="select `id` from ".self::$table_pre."shop where `name`='".$_POST['name']."' and `state`!=1 and `id`!=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>','key':'name'}");}
	
	$sql="select `id` from ".self::$table_pre."shop where `self_certificate_id`='".$_POST['self_certificate_id']."' and `state`!=1 and `id`!=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>','key':'self_certificate_id'}");}
	
	$sql="select `id` from ".self::$table_pre."shop where `email`='".$_POST['email']."' and `state`!=1 and `id`!=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>','key':'email'}");}
	
	$sql="select `id` from ".self::$table_pre."shop where `phone`='".$_POST['phone']."' and `state`!=1 and `id`!=".$id;;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>','key':'phone'}");}
		
	$time=time();
	$geohash=new Geohash;
	$temp=explode(',',$_POST['position']);
	$geohash_str=$geohash->encode($temp[1],$temp[0]);
	$sql="update ".self::$table_pre."shop set `username`='".$_POST['username']."',`name`='".$_POST['name']."',`main_business`='".$_POST['main_business']."',`address`='".$_POST['address']."',`run_type`='".$_POST['run_type']."',`certificate_id`='".$_POST['certificate_id']."',`position`='".$_POST['position']."',`area`='".$_POST['area']."',`self_certificate_id`='".$_POST['self_certificate_id']."',`phone`='".$_POST['phone']."',`email`='".$_POST['email']."',`last_time`=".$time.",`geohash`='".$geohash_str."' ";
	
	$sql.="where `id`=".$id;
	if($pdo->exec($sql)){
		if($_POST['certificate']!=''){
			safe_unlink('./program/mall/certificate/'.$id.'.png');
			safe_rename('./temp/'.$_POST['certificate'],'./program/mall/certificate/'.$id.'.png');
		}
		if($_POST['self_certificate']!=''){
			@safe_unlink('./program/mall/certificate/self_'.$id.'.png');
			safe_rename('./temp/'.$_POST['self_certificate'],'./program/mall/certificate/self_'.$id.'.png');
		}
		if($_POST['icon']!=''){
			@safe_unlink('./program/mall/shop_icon/'.$id.'.png');
			safe_rename('./temp/'.$_POST['icon'],'./program/mall/shop_icon/'.$id.'.png');
		}
		
		if($_POST['username']!=$old['username']){
			$old_group=get_user_group_name($pdo,$_POST['username']);
			$sql="update ".$pdo->index_pre."user set `group`='".self::$config['shopkeeper_group_id']."' where `username`='".$_POST['username']."'";
			$pdo->exec($sql);
			$new=get_user_group_name($pdo,$_POST['username']);
			push_group_change($pdo,self::$config,self::$language,$_POST['username'],$old_group,$new);
			
			$old_group=get_user_group_name($pdo,$old['username']);
			$sql="update ".$pdo->index_pre."user set `group`='".self::$config['reg_set']['default_group_id']."' where `username`='".$old['username']."'";
			$pdo->exec($sql);
			$new=get_user_group_name($pdo,$old['username']);
			push_group_change($pdo,self::$config,self::$language,$old['username'],$old_group,$new);
		}
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
		
}