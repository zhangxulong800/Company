<?php
$act=@$_GET['act'];

if($act=='execute_bargain'){
	if(!isset($_SESSION['monxin']['username'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['bargain_before']."</span>','key':'weixin'}");}
	$sql="select `state`,`id`,`openid` from ".$pdo->index_pre."user where `username`='".$_SESSION['monxin']['username']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['bargain_before']."</span>','key':'weixin'}");}
	if($r['state']!=1){exit("{'state':'fail','info':'<span class=fail>user state err</span>'}");}
	if($r['openid']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['bargain_before']."</span>','key':'weixin'}");}
	
	
	
	
	
	$l=intval(@$_GET['l']);
	$sql="select * from ".self::$table_pre."log where `id`=".$l;
	$log=$pdo->query($sql,2)->fetch(2);
	if($log['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." l id err</span>'}");}
	if($log['state']!=1){exit("{'state':'fail','info':'<span class=fail>".self::$language['log_end']."</span>'}");}
	
	$sql="select * from ".self::$table_pre."goods where `id`=".$log['b_id'];
	$gb=$pdo->query($sql,2)->fetch(2);
	if($gb['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['bargain_end']."</span>'}");}
	if($gb['state']!=1){exit("{'state':'fail','info':'<span class=fail>".self::$language['bargain_end']."</span>'}");}
	
	$sql="select * from ".$pdo->sys_pre."mall_goods where `id`=".$gb['g_id'];
	$g=$pdo->query($sql,2)->fetch(2);
	if($g['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['bargain_end']."</span>'}");}
	$module=array();
	$module['bargain_times']=0;
	if($gb['new']==1){
		$sql="select `id` from ".self::$table_pre."detail where `username`='".$_SESSION['monxin']['username']."' and `l_username`!='".$_SESSION['monxin']['username']."' limit 0,1";
		
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){
			$module['bargain_times']=1;
			$module['bargain_err']=self::$language['just_new_user_bargain'];
		}
	}else{
		$start_time=time()-86400;
		$sql="select count(`id`) as c from ".self::$table_pre."detail where `username`='".$_SESSION['monxin']['username']."' and `l_username`!='".$_SESSION['monxin']['username']."' and `time`>".$start_time;
		file_put_contents('t.txt',$sql);
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']>self::$config['bargain_limit']){
			$module['bargain_times']=$r['c'];
			$module['bargain_err']=self::$language['day_bargain_overrun'];
			$module['bargain_err']=str_replace("{times}",$r['c'],$module['bargain_err']);
		}
		
	}
	if($module['bargain_times']>0){
		exit("{'state':'fail','info':'<span class=fail>".$module['bargain_err']."</span>'}");
	}

	
	
		
	$gb['normal']=self::get_goods_price($pdo,$g['id']);

	$bargain_money=self::get_bargain_money($pdo,$gb,$log);
	$bargain=$gb['normal']-$gb['final_price'];
	
	//var_dump($log['money']);var_dump($bargain);var_dump($bargain_money);exit;
	if($bargain_money==0 && $log['money']>=$bargain){
		$sql="update ".self::$table_pre."log set `state`=3 where `id`=".$log['id']." and `state`=1";
		$pdo->exec($sql);
		exit("{'state':'fail','info':'<span class=fail>".self::$language['bargain_end']."</span>'}");
	}
	
	$sql="insert into ".self::$table_pre."detail (`l_id`,`b_id`,`g_id`,`username`,`time`,`money`,`ip`,`l_username`) values ('".$log['id']."','".$gb['id']."','".$gb['g_id']."','".$_SESSION['monxin']['username']."','".time()."','".$bargain_money."','".get_ip()."','".$log['username']."')";
	
	if($pdo->exec($sql)){
		$sql="update ".self::$table_pre."log set `quantity`=`quantity`+1,`money`=`money`+".$bargain_money." where `id`=".$log['id'];
		if($log['money']+$bargain_money>=$bargain){
			$sql="update ".self::$table_pre."log set `quantity`=`quantity`+1,`money`=`money`+".$bargain_money.",`state`=3 where `id`=".$log['id'];		
		}
		//file_put_contents('bargain.txt',$sql);exit;
		if(!$pdo->exec($sql)){$pdo->exec($sql);}
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','bargain_money':'".$bargain_money."'}");
		
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

