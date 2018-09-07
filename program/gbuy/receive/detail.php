<?php
$act=@$_GET['act'];

if($act=='execute_gbuy'){
	if(!isset($_SESSION['monxin']['username'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['gbuy_before']."</span>','key':'weixin'}");}
	$sql="select `state`,`id`,`openid` from ".$pdo->index_pre."user where `username`='".$_SESSION['monxin']['username']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['gbuy_before']."</span>','key':'weixin'}");}
	if($r['state']!=1){exit("{'state':'fail','info':'<span class=fail>user state err</span>'}");}
	//if($r['openid']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['gbuy_before']."</span>','key':'weixin'}");}
	
	
	
	
	
	$l=intval(@$_GET['l']);
	$sql="select * from ".self::$table_pre."log where `id`=".$l;
	$log=$pdo->query($sql,2)->fetch(2);
	if($log['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." l id err</span>'}");}
	if($log['state']!=1){exit("{'state':'fail','info':'<span class=fail>".self::$language['log_end']."</span>'}");}
	
	$sql="select * from ".self::$table_pre."goods where `id`=".$log['b_id'];
	$gb=$pdo->query($sql,2)->fetch(2);
	if($gb['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['gbuy_end']."</span>'}");}
	if($gb['state']!=1){exit("{'state':'fail','info':'<span class=fail>".self::$language['gbuy_end']."</span>'}");}
	
	$sql="select * from ".$pdo->sys_pre."mall_goods where `id`=".$gb['g_id'];
	$g=$pdo->query($sql,2)->fetch(2);
	if($g['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['gbuy_end']."</span>'}");}
	$module=array();
	$module['gbuy_times']=0;
	if($gb['new']==1){
		$sql="select `id` from ".self::$table_pre."detail where `username`='".$_SESSION['monxin']['username']."' and `l_username`!='".$_SESSION['monxin']['username']."' limit 0,1";
		
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){
			$module['gbuy_times']=1;
			$module['gbuy_err']=self::$language['just_new_user_gbuy'];
		}
	}else{
		$start_time=time()-86400;
		$sql="select count(`id`) as c from ".self::$table_pre."detail where `username`='".$_SESSION['monxin']['username']."' and `l_username`!='".$_SESSION['monxin']['username']."' and `time`>".$start_time;
		file_put_contents('t.txt',$sql);
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']>self::$config['gbuy_limit']){
			$module['gbuy_times']=$r['c'];
			$module['gbuy_err']=self::$language['day_gbuy_overrun'];
			$module['gbuy_err']=str_replace("{times}",$r['c'],$module['gbuy_err']);
		}
		
	}
	if($module['gbuy_times']>0){
		exit("{'state':'fail','info':'<span class=fail>".$module['gbuy_err']."</span>'}");
	}

	
	
		
	$gb['normal']=self::get_goods_price($pdo,$g['id']);

	$gbuy_money=self::get_gbuy_money($pdo,$gb,$log);
	
	$gbuy=$gb['normal']-$gb['final_price'];
	
	if($gbuy_money==0 && $log['money']>=$gbuy){
		$sql="update ".self::$table_pre."log set `state`=3 where `id`=".$log['id']." and `state`=1";
		$pdo->exec($sql);
		exit("{'state':'fail','info':'<span class=fail>".self::$language['gbuy_end']."</span>'}");
	}
	
	$sql="insert into ".self::$table_pre."detail (`l_id`,`b_id`,`g_id`,`username`,`time`,`money`,`ip`,`l_username`) values ('".$log['id']."','".$gb['id']."','".$gb['g_id']."','".$_SESSION['monxin']['username']."','".time()."','".$gbuy_money."','".get_ip()."','".$log['username']."')";
	
	if($pdo->exec($sql)){
		$sql="update ".self::$table_pre."log set `quantity`=`quantity`+1,`money`=`money`+".$gbuy_money." where `id`=".$log['id'];
		if($log['money']+$gbuy_money>=$gb['final_price']){
			$sql="update ".self::$table_pre."log set `quantity`=`quantity`+1,`money`=`money`+".$gbuy_money.",`state`=3 where `id`=".$log['id'];		
		}
		if(!$pdo->exec($sql)){$pdo->exec($sql);}
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

