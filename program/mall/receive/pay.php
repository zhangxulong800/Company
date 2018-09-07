<?php
$id=intval(@$_GET['id']);
if($id==0 && @$_SESSION['monxin_mall_order_id']==''){exit("{'state':'fail','info':'id err'}");}
$ids=array();
$for_id=$id;
if($id==0){
	$for_id=trim($_SESSION['monxin_mall_order_id'],'|');
	$ids=explode('|',trim(@$_SESSION['monxin_mall_order_id'],'|'));
	$id=intval($ids[0]);
}
if($id==0){echo 'id err';return false;}

$sql="select * from ".self::$table_pre."order where `id`='".$id."' limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
$r['actual_money']-=$r['web_credits_money'];
//$r['actual_money']-=$r['shop_credits_money'];
if($r['id']==''){exit("{'state':'fail','info':'id err'}");}
if(isset($_SESSION['monxin']['username'])){
	if($_SESSION['monxin']['username']!=$r['buyer']){exit("{'state':'fail','info':'<span class=fail>".self::$language['act_noPower']."</span>'}");}	
}else{
	if($r['buyer']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['act_noPower']."</span>'}");}	
}
if($r['state']!=0 && $r['state']!=11 && $r['state']!=13 ){
	exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].':'.self::$language['order_state'][$r['state']]." ".self::$language['inoperable']."</span>'}");	
}

$act=@$_GET['act'];



//==================================================================================================================================【获取支付验证码】
if($act=='get_verification_code'){
	authcode_push($pdo,self::$config,self::$language,$_SESSION['monxin']['username']);
	
	/*
	$sql="select `phone` from ".$pdo->index_pre."user where `username`='".$_SESSION['monxin']['username']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$phone=$r['phone'];
	$_SESSION['verification_code']=get_verification_code(6);
	
	if(!is_match(self::$config['other']['reg_phone'],$phone)){exit("{'state':'fail','info':'".self::$language['phone'].self::$language['pattern_err']."','key':'phone'}");}
	if(sms_frequency($pdo,$phone,self::$config['sms']['frequency_limit'])==false){exit("{'state':'fail','info':'".self::$language['sms_frequent']."'}");}
	if(sms(self::$config,self::$language,$pdo,'monxin',$phone,$_SESSION['verification_code'])){
		$success=str_replace('{device}',self::$language['phone'],self::$language['verification_code_sent_notice']);
		exit("{'state':'success','info':'".$success."'}");

	}else{
		exit("{'state':'fail','info':'".self::$language['fail']."'}"); 
	}
	*/
}


$pay_method=@$_GET['pay_method'];




//==================================================================================================================================【在线支付跳转】
if($pay_method=='online_payment'){
	if(count($ids)>1){
		$sql="select `id`,`actual_money`,`web_credits_money`,`shop_credits_money`,`out_id`,`pre_sale`,`state` from ".self::$table_pre."order where `id` in (".implode(',',$ids).")";
		//echo $sql;
		$r2=$pdo->query($sql,2);
		$r['actual_money']=0;
		$r['id']='';
		$r['id_html']='';
		foreach($r2 as $v){
			$v['actual_money']-=$v['web_credits_money'];
			//$v['actual_money']-=$v['shop_credits_money'];
			$r['actual_money']+=$v['actual_money'];
			$r['id'].=$v['id'].',';
			$r['id_html'].='<a href="./index.php?monxin=mall.my_order&id='.$v['id'].'" target=_blank >'.$v['id'].'</a>,';
		}
		$r['id']=trim($r['id'],',');
		$id=0;
	}
		if($r['pre_sale']==1){
			$sql="select * from ".self::$table_pre."order_pre_sale where `order_id`=".$r['id']." limit 0,1";
			$pre=$pdo->query($sql,2)->fetch(2);
			if($r['state']==11){
				$r['actual_money']=$pre['deposit'];
			}else{
				$r['actual_money']-=$pre['deposit'];
			}
			
		}
	
	$sql="select `name` from ".self::$table_pre."receiver where `id`='".$r['receiver_id']."'";
	$r2=$pdo->query($sql,2)->fetch(2);
	$_POST['title']=str_replace('{order_id}',$r['out_id'],self::$language['recharge_order_money_template']).$r2['name'];
	if($r['pre_sale']==1){
		$_POST['title']=$r['out_id'].self::$language['order_postfix'].self::$language['order_step_1'];
	}
	$return_url='http://'.self::$config['web']['domain'].'/index.php?monxin=mall.pay&id='.$id.'&act=online_payment&re='.time();
	$return_function='mall.update_order_state';
	$sql="insert into ".$pdo->index_pre."recharge (`username`,`money`,`time`,`state`,`title`,`return_url`,`pay_info`,`pay_photo`,`method`,`for_id`,`type`,`return_function`) values ('".@$_SESSION['monxin']['username']."','".$r['actual_money']."','".time()."','2','".$_POST['title']."','".$return_url."','','','online_payment','".$for_id."','".safe_str($_POST['payment'])."','".$return_function."')";
	if($pdo->exec($sql)){
		$new_id=$pdo->lastInsertId();
		$in_id=date('Ymdh',time()).$new_id;
		$sql="update ".$pdo->index_pre."recharge set `in_id`='".$in_id."' where `id`=".$new_id;
		$pdo->exec($sql);
		
		echo '<form id="payment_form" name="payment_form" method="POST" action="./payment/'.@$_POST['payment'].'/">
	  <input type="hidden" name="id" id="id" value="'.$in_id.'" />
	  <input type="hidden" name="money" id="money" value="'.$r['actual_money'].'" />
	  <input type="hidden" name="title" id="title" value="'.$_POST['title'].'" />
	  <input type="hidden" name="notify_url" id="notify_url" value="" />
	  <input type="hidden" name="return_url" id="return_url" value="'.$return_url.'" />
	</form>';
		exit;	
	}else{
		exit( 'insert into recharge'.self::$language['fail']);
	}
}

//==================================================================================================================================【余额支付】
if($pay_method=='balance'){
	switch(self::$config['web']['balance_pay_check']){
		case 'code':
			if($_POST['authcode']=='' || @$_SESSION['verification_code']!=$_POST['authcode']){
				exit("{'state':'fail','info':'<span class=fail>".self::$language['authcode'].self::$language['err']."</span>','key':'authcode'}");
			}
			break;
		case 'password':
			if($_POST['authcode']==''){
				exit("{'state':'fail','info':'<span class=fail>".self::$language['transaction_password'].self::$language['is_null']."</span>','key':'authcode'}");
			}
			$password=md5(trim($_POST['authcode']));
			$sql="select `transaction_password` from ".$pdo->index_pre."user where `id`=".$_SESSION['monxin']['id'];
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['transaction_password']!=$password){
				exit("{'state':'fail','info':'<span class=fail>".self::$language['transaction_password'].self::$language['err']."</span>','key':'authcode'}");	
			}
			break;
				
	}
	
	$sql="select * from ".self::$table_pre."order where id=".$id;
	if(count($ids)>1){
		$sql="select * from ".self::$table_pre."order where `id` in (".implode(',',$ids).")";
	}
	$r=$pdo->query($sql,2);
	$success_sum=0;
	$automatic_delivery=0;
	foreach($r as $v){
		$v['actual_money']-=$v['web_credits_money'];
		//$v['actual_money']-=$v['shop_credits_money'];
		$id=$v['id'];
		
		$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.my_order&search='.$v['out_id'].' target=_blank>'.$v['out_id'].'</a>',self::$language['deduction_order_money_template']);
		
		if($v['pre_sale']==1){
			$sql="select * from ".self::$table_pre."order_pre_sale where `order_id`=".$v['id']." limit 0,1";
			$pre=$pdo->query($sql,2)->fetch(2);
			if($v['state']==11){
				$v['actual_money']=$pre['deposit'];
				$reason.=self::$language['order_step_1'];
			}else{
				$v['actual_money']-=$pre['deposit'];
				$reason.=self::$language['order_step_2'];
			}
		}
				
		
		$reason=str_replace('{sum_money}',$v['actual_money'],$reason);
		if(operator_money(self::$config,self::$language,$pdo,$_SESSION['monxin']['username'],'-'.$v['actual_money'],$reason,'mall')){
				
			if($v['state']==0){$v['state']=1;}
			if($v['state']==11){$v['state']=12;}
			if($v['state']==13){$v['state']=14;}
			
			$sql="update ".self::$table_pre."order set `state`='".$v['state']."',`pay_method`='balance' where `id`=".$id;
			
			if($pdo->exec($sql)){
				$sql="update ".self::$table_pre."order_goods set `order_state`='".$v['state']."' where `order_id`=".$id;
				$pdo->exec($sql);
				self::add_shop_buyer($pdo,$v['buyer'],$v['shop_id']);
				$v['pay_method']='balance';
				self::decrease_goods_quantity($pdo,self::$table_pre,$v);
				self::order_notice(self::$language,self::$config,$pdo,self::$table_pre,$v);	
				if(self::virtual_auto_delivery(self::$config,self::$language,$pdo,self::$table_pre,$v)){
					$sql="update ".self::$table_pre."order set `state`='2' where `id`=".$id;
					$pdo->exec($sql);
					$sql="update ".self::$table_pre."order_goods set `order_state`='2' where `order_id`=".$id;
					$pdo->exec($sql);
					$v['state']=2;
					self::decrease_goods_quantity($pdo,self::$table_pre,$v);
					$automatic_delivery++;
				}
				if(self::$config['agency']){
					if(!isset($agency) && is_file('./program/agency/agency.class.php')){
						require('./program/agency/agency.class.php');
						$agency=new agency($pdo);		
					}
					if(isset($agency)){$agency->order_complete_pay($pdo,$id);}
					
				}
				if(self::$config['distribution'] && is_file('./program/distribution/distribution.class.php')){
					if(!isset($distribution)){
						require('./program/distribution/distribution.class.php');
						$distribution=new distribution($pdo);		
					}
					if(isset($distribution)){$distribution->order_complete_pay($pdo,$id);}
					
				}
				
				self::update_card_state($pdo,$_SESSION['monxin']['username']);

				$sql="select `username`,`name` from ".self::$table_pre."shop where `id`=".$v['shop_id'];
				$r=$pdo->query($sql,2)->fetch(2);
				$msg=self::$language['im_order_state_1'];
				$msg=str_replace('{shopname}',$r['name'],$msg);
				$msg.='<a href=http://'.self::$config['web']['domain'].'/index.php?monxin=mall.order_admin&search='.$v['out_id'].' target=_blank>http://'.self::$config['web']['domain'].'/index.php?monxin=mall.order_admin&search='.$v['out_id'].'</a>';
				send_im_msg(self::$config,self::$language,$pdo,$v['buyer'],$r['username'],$msg);

				$success_sum++;
			}
		}		
	}
	if($success_sum>0){
		if($automatic_delivery>0){exit("{'state':'success','info':'<span class=success>".self::$language['success'].",".self::$language['have_automatic_delivery']."</span>  <a href=./index.php?monxin=mall.my_order class=view style=\'color:#000;\'>".self::$language['view']."</a>'}");	}
		$_SESSION['verification_code']='';
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span> <a href=./index.php?monxin=mall.my_order class=view>".self::$language['view']."</a>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

//==================================================================================================================================【积分支付】
if($pay_method=='credits'){
	switch(self::$config['web']['balance_pay_check']){
		case 'code':
			if($_POST['authcode']=='' || @$_SESSION['verification_code']!=$_POST['authcode']){
				exit("{'state':'fail','info':'<span class=fail>".self::$language['authcode'].self::$language['err']."</span>','key':'authcode'}");
			}
			break;
		case 'password':
			if($_POST['authcode']==''){
				exit("{'state':'fail','info':'<span class=fail>".self::$language['transaction_password'].self::$language['is_null']."</span>','key':'authcode'}");
			}
			$password=md5(trim($_POST['authcode']));
			$sql="select `transaction_password` from ".$pdo->index_pre."user where `id`=".$_SESSION['monxin']['id'];
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['transaction_password']!=$password){
				exit("{'state':'fail','info':'<span class=fail>".self::$language['transaction_password'].self::$language['err']."</span>','key':'authcode'}");	
			}
			break;
				
	}
	
	$sql="select * from ".self::$table_pre."order where id=".$id;
	if(count($ids)>1){
		$sql="select * from ".self::$table_pre."order where `id` in (".implode(',',$ids).")";
	}
	$r=$pdo->query($sql,2);
	$success_sum=0;
	$automatic_delivery=0;
	foreach($r as $v){
		$v['actual_money']-=$v['web_credits_money'];
		//$v['actual_money']-=$v['shop_credits_money'];
		$id=$v['id'];
		
		$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.my_order&search='.$v['out_id'].' target=_blank>'.$v['out_id'].'</a>',self::$language['deduction_order_money_template']);
		
		if($v['pre_sale']==1){
			$sql="select * from ".self::$table_pre."order_pre_sale where `order_id`=".$v['id']." limit 0,1";
			$pre=$pdo->query($sql,2)->fetch(2);
			if($v['state']==11){
				$v['actual_money']=$pre['deposit'];
				$reason.=self::$language['order_step_1'];
			}else{
				$v['actual_money']-=$pre['deposit'];
				$reason.=self::$language['order_step_2'];
			}
		}
				
		$v['actual_money']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['actual_money']);
		$reason=str_replace('{sum_money}',$v['actual_money'],$reason);
		if(operation_credits($pdo,self::$config,self::$language,$_SESSION['monxin']['username'],'-'.$v['actual_money'],$reason,'mall_buy')){				
			if($v['state']==0){$v['state']=1;}
			if($v['state']==11){$v['state']=12;}
			if($v['state']==13){$v['state']=14;}
			
			$sql="update ".self::$table_pre."order set `state`='".$v['state']."',`pay_method`='credits' where `id`=".$id;
			
			if($pdo->exec($sql)){
				$sql="update ".self::$table_pre."order_goods set `order_state`='".$v['state']."' where `order_id`=".$id;
				$pdo->exec($sql);
				self::add_shop_buyer($pdo,$v['buyer'],$v['shop_id']);
				$v['pay_method']='balance';
				self::decrease_goods_quantity($pdo,self::$table_pre,$v);
				self::order_notice(self::$language,self::$config,$pdo,self::$table_pre,$v);	
				if(self::virtual_auto_delivery(self::$config,self::$language,$pdo,self::$table_pre,$v)){
					$sql="update ".self::$table_pre."order set `state`='2' where `id`=".$id;
					$pdo->exec($sql);
					$sql="update ".self::$table_pre."order_goods set `order_state`='2' where `order_id`=".$id;
					$pdo->exec($sql);
					$v['state']=2;
					self::decrease_goods_quantity($pdo,self::$table_pre,$v);
					$automatic_delivery++;
				}
				if(self::$config['agency']){
					if(!isset($agency) && is_file('./program/agency/agency.class.php')){
						require('./program/agency/agency.class.php');
						$agency=new agency($pdo);		
					}
					if(isset($agency)){$agency->order_complete_pay($pdo,$id);}
					
				}
				if(self::$config['distribution'] && is_file('./program/distribution/distribution.class.php')){
					if(!isset($distribution)){
						require('./program/distribution/distribution.class.php');
						$distribution=new distribution($pdo);		
					}
					if(isset($distribution)){$distribution->order_complete_pay($pdo,$id);}
					
				}
				
				self::update_card_state($pdo,$_SESSION['monxin']['username']);

				$sql="select `username`,`name` from ".self::$table_pre."shop where `id`=".$v['shop_id'];
				$r=$pdo->query($sql,2)->fetch(2);
				$msg=self::$language['im_order_state_1'];
				$msg=str_replace('{shopname}',$r['name'],$msg);
				$msg.='<a href=http://'.self::$config['web']['domain'].'/index.php?monxin=mall.order_admin&search='.$v['out_id'].' target=_blank>http://'.self::$config['web']['domain'].'/index.php?monxin=mall.order_admin&search='.$v['out_id'].'</a>';
				send_im_msg(self::$config,self::$language,$pdo,$v['buyer'],$r['username'],$msg);

				$success_sum++;
			}
		}		
	}
	if($success_sum>0){
		if($automatic_delivery>0){exit("{'state':'success','info':'<span class=success>".self::$language['success'].",".self::$language['have_automatic_delivery']."</span>  <a href=./index.php?monxin=mall.my_order class=view style=\'color:#000;\'>".self::$language['view']."</a>'}");	}
		$_SESSION['verification_code']='';
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span> <a href=./index.php?monxin=mall.my_order class=view>".self::$language['view']."</a>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

//==================================================================================================================================【货到付款】
if($pay_method=='cash_on_delivery'){
	
	$sql="select * from ".self::$table_pre."order where id=".$id;
	if(count($ids)>1){
		$sql="select * from ".self::$table_pre."order where `id` in (".implode(',',$ids).")";
	}
	$r=$pdo->query($sql,2);
	$success_sum=0;
	foreach($r as $v){
		if($v['state']==0){$v['state']=1;}
		if($v['state']==11){$v['state']=12;}
		if($v['state']==13){$v['state']=14;}
		
		$id=$v['id'];
		$sql="update ".self::$table_pre."order set `state`='".$v['state']."',`pay_method`='cash_on_delivery' where `id`=".$id;
		if($pdo->exec($sql)){
			$sql="update ".self::$table_pre."order_goods set `order_state`='".$v['state']."' where `order_id`=".$id;
			$pdo->exec($sql);
			self::add_shop_buyer($pdo,$v['buyer'],$v['shop_id']);		
			
			$v['pay_method']='cash_on_delivery';
			self::decrease_goods_quantity($pdo,self::$table_pre,$v);
			self::order_notice(self::$language,self::$config,$pdo,self::$table_pre,$v);
			$success_sum++;
			if(self::$config['distribution']){
				if(!isset($distribution)){
					require('./program/distribution/distribution.class.php');
					$distribution=new distribution($pdo);		
				}
				$distribution->order_complete_pay($pdo,$id);
			}
			
		}
	}
	if($success_sum>0){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>  <a href=./index.php?monxin=mall.my_order class=view>".self::$language['view']."</a>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}	
}
