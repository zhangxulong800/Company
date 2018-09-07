<?php 
function index_recharge_credits_back($config,$language,$pdo,$for_id,$in_id){
	//file_put_contents('re.txt','3');
	$program='index';
	$sql="select * from ".$pdo->sys_pre."index_recharge where `in_id`=".$in_id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['for_id']!=$for_id || $r['state']!=4){return false;}
	$ids=explode(',',$r['for_id']);
	$re=$r;
	
	$sql="select * from ".$pdo->sys_pre."index_recharge_credits where id=".$for_id;
	//file_put_contents('re.txt',$sql);
	$v=$pdo->query($sql,2)->fetch(2);
	if($v['state']==3 || $v['state']==4 || $v['state']==5){return false;}
	$deduction=false;
	$reason=$language['recharge_credits'];
	$deduction=operator_money($config,$language,$pdo,$re['username'],'-'.$re['money'],$reason,'index');
	if(!$deduction){echo $_POST['operator_money_err_info'];file_put_contents('re.txt','17');}
	
	if($deduction===true){//如扣款成功，更新订单状态
		
		$sql="update ".$pdo->sys_pre."index_recharge_credits set `state`='4' where `id`=".$v['id'];
		if($pdo->exec($sql)){
			if(operation_credits($pdo,$config,$language,$re['username'],$v['money'],$reason,'recharge')){
				
				
				
				return true;
			}else{
				
			}
		}
	}		
	
	return false;
}
