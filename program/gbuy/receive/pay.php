<?php
$id=intval(@$_GET['id']);
if($id==0){exit("{'state':'fail','info':'id err'}");}
$sql="select * from ".self::$table_pre."order where `id`='".$id."' limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){exit("{'state':'fail','info':'id err'}");}
if($_SESSION['monxin']['username']!=$r['username']){exit("{'state':'fail','info':'<span class=fail>".self::$language['act_noPower']."</span>'}");}	
$act=@$_GET['act'];



$pay_method=@$_GET['pay_method'];




//==================================================================================================================================【在线支付跳转】
if($pay_method=='online_payment'){
		
	$return_url='http://'.self::$config['web']['domain'].'/index.php?monxin=gbuy.pay&id='.$id.'&act=online_payment&re='.time();
	$return_function='gbuy.update_order_state';
	
	$sql="select * from ".self::$table_pre."order where `id`=".$id;
	$order=$pdo->query($sql,2)->fetch(2);
	$order['g_title']=self::$language['recharge_order_money_template'];
	$order['g_title']=str_replace("{order_id}",$order['out_id'],$order['g_title']);
		
	$sql="insert into ".$pdo->index_pre."recharge (`username`,`money`,`time`,`state`,`title`,`return_url`,`pay_info`,`pay_photo`,`method`,`for_id`,`type`,`return_function`) values ('".@$_SESSION['monxin']['username']."','".$order['price']."','".time()."','2','".$order['g_title']."','".$return_url."','','','online_payment','".$order['id']."','".safe_str($_POST['payment'])."','".$return_function."')";
	if($pdo->exec($sql)){
		$new_id=$pdo->lastInsertId();
		$in_id=date('Ymdh',time()).$new_id;
		$sql="update ".$pdo->index_pre."recharge set `in_id`='".$in_id."' where `id`=".$new_id;
		$pdo->exec($sql);
		
		echo '<form id="payment_form" name="payment_form" method="POST" action="./payment/'.@$_POST['payment'].'/">
	  <input type="hidden" name="id" id="id" value="'.$in_id.'" />
	  <input type="hidden" name="money" id="money" value="'.$order['price'].'" />
	  <input type="hidden" name="title" id="title" value="'.$order['g_title'].'" />
	  <input type="hidden" name="notify_url" id="notify_url" value="" />
	  <input type="hidden" name="return_url" id="return_url" value="'.$return_url.'" />
	</form>';
		exit;	
	}else{
		exit( 'insert into recharge'.self::$language['fail']);
	}
}
