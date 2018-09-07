<?php

$act=@$_GET['act'];
$id=intval(@$_GET['id']);
if($act!='del_select' && $id==0){exit("{'state':'fail','info':'id err'}");}

if($act=='go_express'){
	$sql="select `url` from ".self::$table_pre."express where `id`='".$id."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['url']==''){exit(sef::$language['query_url'].self::$language['is_null']);}
	header("location:".$r['url'].@$_GET['code']);	
}


if($id!=0){
	$sql="select * from ".self::$table_pre."order where `id`='".$id."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit("{'state':'fail','info':'id err'}");}	
}
switch ($act){
	case 'del':
		if(!in_array($r['state'],self::$config['order_del_able_master'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].':'.self::$language['order_state'][$r['state']]." ".self::$language['inoperable']."</span>'}");}
		if(self::del_order($pdo,self::$table_pre,$id)){
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
		break;	
		
	case 'del_select':
		$ids=@$_GET['ids'];
		if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
		$ids=explode("|",$ids);
		$ids=array_filter($ids);
		$success='';
		foreach($ids as $id){
			$id=intval($id);
			$sql="select `state` from ".self::$table_pre."order where `id`='$id'";
			$r=$pdo->query($sql,2)->fetch(2);
			if(in_array($r['state'],self::$config['order_del_able_master'])){
				if(self::del_order($pdo,self::$table_pre,$id)){
					$success.=$id."|";
				}
			}
		}
		$success=trim($success,"|");			
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
		break;	
		
	case 'force_refund':
		if($r['state']!=7 && $r['state']!=9 ){exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].':'.self::$language['order_state'][$r['state']]." ".self::$language['inoperable']."</span>'}");}
		$sql="select `name`,`username` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
		$r2=$pdo->query($sql,2)->fetch(2);
		
		if($r['receipt']==1 || $r['cashier']!='monxin'){
			self::introducer_return_fees($pdo,$r);	
		}

		//店家已到款，扣除款项 
		if($r['receipt']==1  && ($r['pay_method']=='balance' || $r['pay_method']=='online_payment') ){
			$sql="select `money` from ".$pdo->index_pre."user where `username`='".$r2['username']."' and `state`=1 limit 0,1";
			$r3=$pdo->query($sql,2)->fetch(2);
			if($r3['money']<$r['refund_amount']){exit("{'state':'fail','info':'<span class=fail>".self::$language['insufficient_balance'].":".$r['refund_amount']."<br />".self::$language['inoperable']."</span>'}");}
			if($r['actual_money']==$r['refund_amount']){$reason=self::$language['refund_money_template_all'];}else{$reason=self::$language['refund_money_template_part'];}
			$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.order_admin&search='.$r['out_id'].' target=_blank>'.$r['out_id'].'</a>',$reason);
			$reason=str_replace('{sum_money}',$r['refund_amount'],$reason);
			if(!operator_money(self::$config,self::$language,$pdo,$r2['username'],'-'.$r['refund_amount'],$reason,'mall')){
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." operator_money seller</span>'}");
			}
		}
		
		//店家没已到款，给店家补回未退部分款项 
		if($r['receipt']==0  && ($r['pay_method']=='balance' || $r['pay_method']=='online_payment') && $r['actual_money']>$r['refund_amount']){
			$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.order_admin&search='.$r['out_id'].' target=_blank>'.$r['out_id'].'</a>',self::$language['add_order_money_template']);
			$reason=str_replace('{sum_money}',$r['actual_money']-$r['refund_amount'],$reason);
			if(!operator_money(self::$config,self::$language,$pdo,$r2['username'],$r['actual_money']-$r['refund_amount'],$reason,'mall')){
				exit("{'state':'success','info':'<span class=success>".self::$language['fail']."  add_money seller</span>'}");
			}
		}
		
		//退款给买家
		if($r['pay_method']=='balance' || $r['pay_method']=='online_payment' ){
			if($r['actual_money']==$r['refund_amount']){$reason=self::$language['refund_money_template_all'];}else{$reason=self::$language['refund_money_template_part'];}
			$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.my_order&search='.$r['out_id'].' target=_blank>'.$r['out_id'].'</a>',$reason);
			$reason=str_replace('{sum_money}',$r['refund_amount'],$reason);
			if(!operator_money(self::$config,self::$language,$pdo,$r['buyer'],$r['refund_amount'],$reason,'mall')){
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." operator_money buyer</span>'}");
			}
		}
		
		
		$sql="update ".self::$table_pre."order set `state`='10',`actual_money`='".($r['actual_money']-$r['refund_amount'])."',`change_price_reason`='".$r['change_price_reason']." ".self::$language['refund']."' where `id`=".$id;
		if($pdo->exec($sql)){
			if($r['pay_method']=='balance' || $r['pay_method']=='online_payment' ){
				$shop_name=$r2['name'];
				$title=str_replace('{web_name}',self::$config['web']['name'],self::$language['force_return_order_success_template']);
				$title=str_replace('{shop_name}',$shop_name,$title);
				$sql="select `email` from ".$pdo->index_pre."user where `username`='".$r['buyer']."' limit 0,1";
				$r2=$pdo->query($sql,2)->fetch(2);
				$content=self::$language['view'].' <a href="http://'.self::$config['web']['domain'].'/index.php?monxin=mall.index.php?monxin=index.money_log"  target=_blank>http://'.self::$config['web']['domain'].'/index.php?monxin=index.money_log</a>';
				email(self::$config,self::$language,$pdo,'monxin',$r2['email'],$title,$content);	
			}
			self::update_shop_order_sum($pdo,self::$table_pre,SHOP_ID);
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
		break;	
		
}