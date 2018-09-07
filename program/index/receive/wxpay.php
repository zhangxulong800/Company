<?php
$act=@$_GET['act'];
$id=intval(@$_GET['id']);

if($act=='inquiry'){
	$sql="select `type` from ".$pdo->index_pre."wxpay where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['type']==0){
		$state=wexin_red_pack_inquiry($pdo,$id);
	}else{
		$state=wexin_transfers_inquiry($pdo,$id);
	}
	
	if($state!==false){
		$info=@$_POST['err_code_des'];
		foreach(self::$language['wxpay_state'] as $k=>$v){
			if($state==$k){$info=self::$language['wxpay_state'][$k];}
		}
		
		$sql="select `receive_state` from ".$pdo->index_pre."wxpay where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		
		exit("{'state':'success','info':'<span class=success>".$info."</span>','receive_state':'".self::$language['wxpay_receive_state'][$r['receive_state']]."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='del'){
	$sql="delete from ".$pdo->index_pre."wxpay where `id`='$id'";
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
		$sql="delete from ".$pdo->index_pre."wxpay where `id`='$id'";
		if($pdo->exec($sql)){
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
