<?php
$id=intval(@$_GET['id']);
if($id==0){exit("{'state':'fail','info':'id err'}");}

$act=@$_GET['act'];





if($act=='get_page_task'){
	if(intval(@$_GET['page'])==0){exit;}
	$sql="select * from ".self::$table_pre."regular where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r==''){exit("{'state':'fail','info':'id err'}");}
	$r=de_safe_str($r);
	$r['list_url']=str_replace('{var}',$_GET['page'],$r['list_url']);
	$result=self::gat_task_list($pdo,$r,$id,$r['list_url']);	
	//var_dump($result);
	exit("$('#task_page_".$_GET['page']."').html('<b class=task_page>".$_GET['page']."</b> ".self::$language['match'].":".$result['sum']." ".self::$language['new_task'].":".$result['new']."');");		
}

if($act=='get_frist_page_task'){
	$sql="select * from ".self::$table_pre."regular where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r==''){exit("{'state':'fail','info':'id err'}");}
	$r=de_safe_str($r);
	$r['list_url']=str_replace('{var}','1',$r['list_url']);
	$result=self::gat_task_list($pdo,$r,$id,$r['list_url']);	
	//var_dump($result);
	exit("{'sum':'".$result['sum']."','add':'".$result['new']."'}");		
}

if($act=='get_all_task'){
	$sql="select * from ".self::$table_pre."regular where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r==''){exit("{'state':'fail','info':'id err'}");}
	$r=de_safe_str($r);
	$span='';
	for($i=$r['start_number'];$i<=$r['end_number'];$i+=$r['add_step']){
		$span.='<span id=task_page_'.$i.'><b class=task_page>'.$i.'</b><span class=\'fa fa-spinner fa-spin\'></span> <script src="./receive.php?target=copy::task_list&id='.$id.'&act=get_page_task&page='.$i.'"></script></span>';	
	}
	exit($span);
}



if($act=='all_re_copy'){
	$time=time();
	$_GET['sequence']=intval(@$_GET['sequence']);
	$_GET['state']=intval(@$_GET['state']);
	$sql="update ".self::$table_pre."task set `state`='0' where `regular_id`='$id'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success'].' '.self::$language['state']."=".self::$language['task_state'][0]." <a href=\"./index.php?monxin=copy.task_list&id=".$id."\" class=refresh>".self::$language['refresh']."</a></span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}
}
if($act=='update'){
	$time=time();
	$_GET['sequence']=intval(@$_GET['sequence']);
	$_GET['state']=intval(@$_GET['state']);
	$sql="update ".self::$table_pre."task set `sequence`='".$_GET['sequence']."',`state`='".$_GET['state']."' where `id`='$id'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='del'){
	$sql="delete from ".self::$table_pre."task where `id`='$id'";
	if($pdo->exec($sql)){
		$sql="delete from ".self::$table_pre."file where `task_id`=".$id;
		$pdo->exec($sql);	
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
		$id=intval($id);
		$sql="delete from ".self::$table_pre."task where `id`='$id'";
		if($pdo->exec($sql)){
			$sql="delete from ".self::$table_pre."file where `task_id`=".$id;
			$pdo->exec($sql);	
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

if($act=='submit_select'){
	//var_dump($_POST);	
	$time=time();
	$editor=$_SESSION['monxin']['id'];
	$success='';
	foreach($_POST as $v){
		$v['id']=intval($v['id']);
		$v['sequence']=intval($v['sequence']);
		$v['state']=intval($v['state']);
		$sql="update ".self::$table_pre."task set `sequence`='".$v['sequence']."',`state`='".$v['state']."' where `id`='".$v['id']."'";
		if($pdo->exec($sql)){$success.=$v['id']."|";}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}