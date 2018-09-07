<?php
$act=@$_GET['act'];
if($act=='submit'){
	$sql="select `day_reflash` from  ".self::$table_pre."user where `username`='".$_SESSION['monxin']['username']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['day_reflash']==''){
		$sql="insert into ".self::$table_pre."user (`username`) values ('".$_SESSION['monxin']['username']."')";
		$pdo->exec($sql);	
		$r['day_reflash']=0;
	}
	$balance=-1;
	if($r['day_reflash']>=self::$config['day_reflash_max']){
		$sql="select `money` from ".$pdo->index_pre."user where `username`='".$_SESSION['monxin']['username']."'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['money']<self::$config['reflash_price']){exit("{'state':'fail','info':'<span class=fail>".self::$language['insufficient_balance']."</span>'}");}
		$balance=$r['money']-self::$config['reflash_price'];
	}

	
	$id=intval(@$_GET['id']);
	$time=time()-1;
	$sql="update ".self::$table_pre."content set `reflash`='".time()."',`sum_cost`=`sum_cost`+".self::$config['reflash_price']." where `id`=".$id." and `username`='".$_SESSION['monxin']['username']."'";	
	//file_put_contents('./test.txt',$sql);
	if($pdo->exec($sql)){
		$sql="update ".self::$table_pre."user set `day_reflash`=`day_reflash`+1 where `username`='".$_SESSION['monxin']['username']."'";
		$pdo->exec($sql);
		$sql="select `title` from ".self::$table_pre."content where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$reason=self::$language['refresh'].self::$language['deduction_money'].','.$r['title'];
		if(operator_money(self::$config,self::$language,$pdo,$_SESSION['monxin']['username'],'-'.self::$config['reflash_price'],$reason,'ci')===true){
			
		}else{
			
		}
		
		$html=get_time('m-d H:i',self::$config['other']['timeoffset'],self::$language,$time);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','html':'".$html."','balance':'".$balance."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}