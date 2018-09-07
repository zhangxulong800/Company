<?php
//var_dump($_POST);exit;
$id=intval(@$_GET['id']);
if($id==0){exit("{'state':'fail','info':'id err'}");}
//var_dump($_POST);

$sql="select * from ".self::$table_pre."account where `id`='".$id."'";
$account=$pdo->query($sql,2)->fetch(2);
if($account['state']!=1){exit("{'state':'fail','info':'".self::$language['state'].' '.self::$language['account_state'][$account['state']]."'}");}
if(!self::check_pay_power($pdo,$account)){exit("{'state':'fail','info':'".self::$language['unauthorized_operation']."'}");}
$time=time();
$_POST=safe_str($_POST);
$money=floatval($_POST['money']);
$barcode=$_POST['barcode'];
if($money==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'money'}");}
if(strlen($barcode)<16){exit("{'state':'fail','info':'<span class=fail>".self::$language['less_than']."16".self::$language['digit']."</span>','id':'barcode'}");}
if($account['is_web']){$settlement=2;}else{$settlement=0;}

$sql="insert into ".self::$table_pre."pay (`a_id`,`operator`,`money`,`barcode`,`time`,`payer`,`reason`,`success_fun`,`settlement`) values ('".$id."','".$_SESSION['monxin']['username']."','".$money."','".$barcode."','".$time."','".$_POST['payer']."','".$_POST['reason']."','".$_POST['success_fun']."','".$settlement."')";
if($pdo->exec($sql)){
	$insert_id=$pdo->lastInsertId();
	$out_id=date('Ymd',$time).$insert_id;
	$sql="update ".self::$table_pre."pay set `out_id`='".$out_id."' where `id`=".$insert_id;
	$pdo->exec($sql);
 		$url = './scanpay_type/'.$account['type'].'/index.php?id='.$id.'&p_id='.$insert_id;
        $form='<form style="display:none;" name=pay_form id=pay_form action="'.$url.'" method=post target="_self">
		<input type="hidden" name="pay_id" value="'.$out_id.'" />
		<input type="hidden" name="barcode" value="'.$barcode.'" />
		<input type="hidden" name="money" value="'.$money.'" />
		<input type="hidden" name="title" value="'.$out_id.'" />
		</form>';

	//exit($form);
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','data_id':'".$id."','url':'".$url."'}");
}else{
	exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
}
	
