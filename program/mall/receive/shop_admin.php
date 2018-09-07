<?php
$act=@$_GET['act'];
if($act=='pay_agent'){
	$id=intval(@$_POST['id']);
	$sql="select `agent`,`agent_pay`,`name` from ".self::$table_pre."shop where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['agent']==''){exit("{'state':'fail','info':'<span class=fail>agent ".self::$language['is_null']."</span>'}");}
	if($r['agent_pay']==1){exit("{'state':'fail','info':'<span class=fail>".self::$language['have_pay']."</span>'}");}
	
	$reason='<a href=./index.php?monxin=mall.shop_index&shop_id='.$id.' target=_blank>'.$r['name'].'</a> '.self::$language['finance_type_agent'][0];
	$money=self::$config['agent_add_shop_fedds'];
	if(operator_money(self::$config,self::$language,$pdo,$r['agent'],$money,$reason,'mall')){
		$sql="update ".self::$table_pre."shop set `agent_pay`=1 where `id`=".$id;
		if(!$pdo->exec($sql)){$pdo->exec($sql);}
		self::operation_agent_finance(self::$language,$pdo,self::$table_pre,$id,$money,0,$reason,$r['name'],$r['agent']);
		self::operation_finance(self::$language,$pdo,self::$table_pre,$id,'-'.$money,6,$r['agent'].' '.$reason);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if(intval(@$_GET['id'])==0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
$id=intval(@$_GET['id']);

if($act=='del'){
	$sql="select * from ".self::$table_pre."shop where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['state']!=5){
		$temp=self::$language['only_the_state_was_n_remove'];
		$temp=str_replace("{state}",self::$language['shop_state'][5],$temp);
		exit("{'state':'fail','info':'<span class=fail>".$temp."</span>'}");
	}
	
	$sql="delete from ".self::$table_pre."shop where `id`=".$id;
	if($pdo->exec($sql)){
		@safe_unlink('./program/mall/shop_icon/'.$id.'.png');
		@safe_unlink('./program/mall/certificate/'.$id.'.png');
		@safe_unlink('./program/mall/certificate/self_'.$id.'.png');
		self::delete_shop_relevant($pdo,$id);
		$old=get_user_group_name($pdo,$r['username']);
		$sql="update ".$pdo->index_pre."user set `group`='".self::$config['reg_set']['default_group_id']."' where `username`='".$r['username']."' limit 1";
		$pdo->exec($sql);
		$new=get_user_group_name($pdo,$r['username']);
		push_group_change($pdo,self::$config,self::$language,$r['username'],$old,$new);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='update'){	
	$sql="select `id` from ".self::$table_pre."shop";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		self::update_shop_navigation($pdo,self::$language,$v['id']);
	}
	
	
	$url=self::update_shop_qr_path($pdo,$id);
	self::create_qr($url,'./program/mall/shop_icon/'.$id.'.png','./program/mall/shop_qr/'.$id.'.png',300);
	
	$state=intval(@$_GET['state']);	
	$sequence=intval(@$_GET['sequence']);
	$trusteeship=intval(@$_GET['trusteeship']);
	$sql="select * from ".self::$table_pre."shop where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	
	
	$sql="update ".self::$table_pre."shop set `state`='".$state."',`sequence`='".$sequence."',`trusteeship`='".$trusteeship."',`payment`='".safe_str($_GET['payment'])."',`all_user`=".intval(@$_GET['all_user']).",`web_c_password`=".intval(@$_GET['web_c_password']).",`credits_rate`=".floatval(@$_GET['credits_rate']).",`rate`=".floatval(@$_GET['rate']).",`annual_fees`=".floatval(@$_GET['annual_fees']).",`average`=".floatval(@$_GET['average']).",`pay_money`=".floatval(@$_GET['pay_money']).",`return_credits`=".floatval(@$_GET['return_credits'])." where `id`=".$id;
	if($pdo->exec($sql)){
		
		if($r['state']==0 && $state==1){
			$title=self::$language['shop_state_0_1'];
			$title=str_replace('{cause}',$_GET['cause'],$title);
		}
		if($r['state']==0 && $state==2){
			$old=get_user_group_name($pdo,$r['username']);
			
			$title=self::$language['shop_state_0_2'];
			$sql="update ".$pdo->index_pre."user set `group`='".self::$config['shopkeeper_group_id']."' where `username`='".$r['username']."'";
			$pdo->exec($sql);
			$new=get_user_group_name($pdo,$r['username']);
			//创建店铺初始化数据
			self::crate_shop_default_data($pdo,$r['id']);
			
			push_group_change($pdo,self::$config,self::$language,$r['username'],$old,$new);
			
		}
		if($r['state']==2 && $state>2){
			$title=self::$language['shop_state_2_b'];
			$title=str_replace('{cause}',$_GET['cause'],$title);
			$title=str_replace('{state}',self::$language['shop_state'][$state],$title);
		}
		if($r['state']>2 && $state==2){
			$title=self::$language['shop_state_b_2'];
			$title=str_replace('{state}',self::$language['shop_state'][$state],$title);
		}
		
		if($state!=2){
			$sql="select `id` from ".self::$table_pre."goods where `shop_id`=".$id;
			$r2=$pdo->query($sql,2);
			foreach($r2 as $v){
				$sql="delete from ".self::$table_pre."cart where `key`='".$v['id']."' or `key` like '".$v['id']."\_%'";
				$pdo->exec($sql);
			}
			$sql="update ".self::$table_pre."goods  set `mall_state`=0 where `shop_id`=".$id;
			$pdo->exec($sql);
				
		}
		if($r['state']!=$state){
			push_audit($pdo,self::$config,self::$language,$r['username'],self::$language['shop'].": ".$r['name'],self::$language['shop_state'][$state].' '.$_GET['cause']);
		}
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}