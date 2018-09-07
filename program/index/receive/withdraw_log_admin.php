<?php
$act=@$_GET['act'];
$id=intval(@$_GET['id']);

if($act=='export'){
	header("Content-Type: text/csv");
	header("Content-Disposition: attachment; filename=".self::$language['withdraw'].'-'.self::$language['withdraw_state'][$_GET['state']].".csv");
	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
	header('Expires:0');
	header('Pragma:public');	
	$list=self::$language['username'].','.self::$language['time'].','.self::$language['amount'].','.self::$language['real_name'].','.self::$language['billing_info'].','.self::$language['state']."\r\n";	
	$sql="select * from ".$pdo->index_pre."withdraw where `state`='".intval($_GET['state'])."'";
	
	
	//echo $sql;
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$v=de_safe_str($v);
		$sql="select `real_name` from ".$pdo->index_pre."user where `username`='".$v['username']."' limit 0,1";
		$rr=$pdo->query($sql,2)->fetch(2);
		$list.=str_replace(',',' ',$v['username'])."\t,".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."\t,".self::$language['money_symbol'].$v['money'].",".$rr['real_name'].",".strip_tags($v['billing_info']).','.self::$language['withdraw_state'][$v['state']].','."\r\n";	
	}	
	$list=iconv("UTF-8",self::$config['other']['export_csv_charset'].'//IGNORE',$list);
	echo $list;
	exit;

}

if($act=='set_2'){
	$ids=@$_GET['ids'];
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$_GET['reason']=safe_str(@$_GET['reason']);
	if($_GET['reason']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}

	$ids=explode("|",$ids);
	$ids=array_filter($ids);
	$success='';
	foreach($ids as $id){
		$sql="select * from ".$pdo->index_pre."withdraw where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="update ".$pdo->index_pre."withdraw set `state`='2',`operator`='".$_SESSION['monxin']['username']."',`reason`='".$_GET['reason']."' where `id`='$id' and `state`='1'";
		if($pdo->exec($sql)){
			if($r['deduction']==1){
				$rate_money=$r['money']*$r['rate']/100;
				$reason=self::$language['return'].self::$language['withdraw'].'+'.self::$language['withdraw_rate'].'('.self::$config['withdraw_set']['rate'].'% '.self::$language['money_symbol'].$rate_money.')';
				if(operator_money(self::$config,self::$language,$pdo,$r['username'],'+'.($r['money']+$rate_money),$reason,self::$config['class_name'])){
					$sql="update ".$pdo->index_pre."withdraw set `deduction`='2' where `id`='$id'";
					$pdo->exec($sql);
				}			
			}
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
	
	
		
}

if($act=='set_3'){
	$ids=@$_GET['ids'];
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=explode("|",$ids);
	$ids=array_filter($ids);
	$success='';
	foreach($ids as $id){
		$sql="select * from ".$pdo->index_pre."withdraw where `id`='$id'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['state']!=1){continue;}
		$rate_money=$r['money']*$r['rate']/100;
		if($r['deduction']==0){
			$sql="select `money` from ".$pdo->index_pre."user where `username`='".$r['username']."'";
			$user=$pdo->query($sql,2)->fetch(2);
			if($user['money']<($r['money']+$rate_money)){continue;}
		}
		
		$sql="update ".$pdo->index_pre."withdraw set `state`='3',`operator`='".$_SESSION['monxin']['username']."',`pay_time`='".time()."' where `id`='$id' and `state`='1'";
		if($pdo->exec($sql)){
			if($r['deduction']==0){
				$reason=self::$language['withdraw'].'+'.self::$language['withdraw_rate'].'('.self::$config['withdraw_set']['rate'].'% '.self::$language['money_symbol'].$rate_money.')';
				if(operator_money(self::$config,self::$language,$pdo,$r['username'],'-'.($r['money']+$rate_money),$reason,self::$config['class_name'])){
					$sql="update ".$pdo->index_pre."withdraw set `deduction`='1' where `id`='$id'";
					$pdo->exec($sql);
				}else{
					$sql="update ".$pdo->index_pre."withdraw set `state`='1',`operator`='' where `id`='$id'";
					$pdo->exec($sql);
					continue;
				}
			}
				
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
	
	
		
}

if($act=='paid'){
	$sql="select * from ".$pdo->index_pre."withdraw where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['state']!=1){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>state !=1'}");}
	$rate_money=$r['money']*$r['rate']/100;

	if($r['deduction']==0){
		$sql="select `money` from ".$pdo->index_pre."user where `username`='".$r['username']."'";
		$user=$pdo->query($sql,2)->fetch(2);
		if($user['money']<($r['money']+$rate_money)){
			exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['user'].self::$language['insufficient_balance']."'}");
		}
	}
	
	
	if($r['method']==1){
		
		if(self::$config['web']['wid']==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['no_web_weixin']."'}");}
		//$r3=wexin_transfers($pdo,$r['username'],self::$config['web']['name'].' '.self::$language['withdraw'],$r['money'],'index');
		$r3=wexin_red_pack($pdo,$r['username'],self::$config['web']['name'].' '.self::$language['withdraw'],self::$config['web']['name'],$r['money'],'index');
		if(!$r3){exit("{'state':'fail','info':'<span class=fail>".$_POST['err_code_des']."</span>'}");}
	}


	$sql="update ".$pdo->index_pre."withdraw set `state`='3',`operator`='".$_SESSION['monxin']['username']."',`pay_time`='".time()."' where `id`='$id' and `state`='1'";
	if($pdo->exec($sql)){
		//var_dump($r);
		if($r['deduction']==0){
			$reason=self::$language['withdraw'].'+'.self::$language['withdraw_rate'].'('.self::$config['withdraw_set']['rate'].'% '.self::$language['money_symbol'].$rate_money.')';
			if(operator_money(self::$config,self::$language,$pdo,$r['username'],'-'.($r['money']+$rate_money),$reason,self::$config['class_name'])){
				$sql="update ".$pdo->index_pre."withdraw set `deduction`='1' where `id`='$id'";
				$pdo->exec($sql);
			}else{
				$sql="update ".$pdo->index_pre."withdraw set `state`='1',`operator`='' where `id`='$id'";
				$pdo->exec($sql);
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		}
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='refuse'){
	$_GET['reason']=safe_str(@$_GET['reason']);
	if($_GET['reason']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
	$sql="select * from ".$pdo->index_pre."withdraw where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="update ".$pdo->index_pre."withdraw set `state`='2',`operator`='".$_SESSION['monxin']['username']."',`reason`='".$_GET['reason']."' where `id`='$id' and `state`='1'";
	if($pdo->exec($sql)){
		if($r['deduction']==1){
			$rate_money=$r['money']*$r['rate']/100;
			$reason=self::$language['return'].self::$language['withdraw'].'+'.self::$language['withdraw_rate'].'('.self::$config['withdraw_set']['rate'].'% '.self::$language['money_symbol'].$rate_money.')';
			if(operator_money(self::$config,self::$language,$pdo,$r['username'],'+'.($r['money']+$rate_money),$reason,self::$config['class_name'])){
				$sql="update ".$pdo->index_pre."withdraw set `deduction`='2' where `id`='$id'";
				$pdo->exec($sql);
			}			
		}
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='del'){
	$sql="delete from ".$pdo->index_pre."withdraw where `id`='$id' and `state`='2'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}


if($act=='del_select'){
	$ids=@$_GET['ids'];
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=explode("|",$ids);
	$ids=array_filter($ids);
	$success='';
	foreach($ids as $id){
		$sql="delete from ".$pdo->index_pre."withdraw where `id`='$id' and `state`='2'";
		if($pdo->exec($sql)){
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
