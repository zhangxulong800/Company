<?php

$act=@$_GET['act'];
$id=intval(@$_GET['id']);

if($act=='import'){
	//exit('import');
	if($_POST['v']==''){exit("{'state':'fail','info':'<span class=fail>import is null</span>'}");}
	if(!file_exists('./temp/'.$_POST['v'])){
		exit("{'state':'fail','info':'<span class=fail>import is fail</span>'}");
	}
	$v=file_get_contents('./temp/'.$_POST['v']);
	if($v==''){exit("{'state':'fail','info':'<span class=fail>import is null</span>'}");}
	$v=str_replace('{table_pre}',self::$table_pre,$v);
	$sql=explode(";m;o;n;\n\r",$v);
	$insert_id=0;
	//var_dump(count($sql));exit;
	
	foreach($sql as $v){
		if($v!=''){
			$v=trim($v);
			if($insert_id!=0){$v=str_replace('{regular_id}',$insert_id,$v);}
			$state=$pdo->exec($v);
			if($insert_id==0){$insert_id=$pdo->lastInsertId();}	
		}	
	}
	
	if($insert_id!=0){exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span><a href=\'javascript:window.location.reload();\'>".self::$language['refresh']."</a>'}");}
	exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	
}
if($act=='export'){
	if($id==0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	$sql="select * from ".self::$table_pre."regular where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	$save_sql='';
	
	$fields='';
	$values='';
	foreach($r as $k=>$v){
		if($k=='id'){continue;}
		$fields.='`'.$k.'`,';
		$values.="'".$v."',";
	}
	$fields=trim($fields,',');
	$values=trim($values,',');
	$save_sql.="insert into {table_pre}regular (".$fields.") values (".$values.");m;o;n;\n\r";
	
	$sql="select * from ".self::$table_pre."table where `regular_id`=".$id;
	$r=$pdo->query($sql,2);
	foreach($r as $k=>$v){
		$fields='';
		$values='';
		foreach($v as $k2=>$v2){
			if($k2=='id'){continue;}
			if($k2=='regular_id'){
				$fields.='`'.$k2.'`,';
				$values.="'{regular_id}',";
			}else{
				$fields.='`'.$k2.'`,';
				$values.="'".$v2."',";
			}
		}
		$fields=trim($fields,',');
		$values=trim($values,',');
		$save_sql.="insert into {table_pre}table (".$fields.") values (".$values.");m;o;n;\n\r";
	}
	
	$sql="select * from ".self::$table_pre."field where `regular_id`=".$id;
	$r=$pdo->query($sql,2);
	foreach($r as $k=>$v){
		$fields='';
		$values='';
		foreach($v as $k2=>$v2){
			if($k2=='id'){continue;}
			if($k2=='regular_id'){
				$fields.='`'.$k2.'`,';
				$values.="'{regular_id}',";
			}else{
				$fields.='`'.$k2.'`,';
				$values.="'".$v2."',";
			}
		}
		$fields=trim($fields,',');
		$values=trim($values,',');
		$save_sql.="insert into {table_pre}field (".$fields.") values (".$values.");m;o;n;\n\r";
	}
	
	header( "Content-type:   application/octet-stream "); 
	header( "Accept-Ranges:   bytes "); 
	header( "Content-Disposition:   attachment;   filename=regular_".$id.".txt "); 
	header( "Expires:   0 "); 
	header( "Cache-Control:   must-revalidate,   post-check=0,   pre-check=0 "); 
	header( "Pragma:   public "); 	
	echo $save_sql;
	
}


if($act=='update_visible'){
	$_GET['visible']=intval(@$_GET['visible']);
	$sql="update ".self::$table_pre."regular set `switch`='".$_GET['visible']."' where `id`='$id'";	
	$pdo->exec($sql);
	exit();
}
if($act=='del'){
	$sql="delete from ".self::$table_pre."regular where `id`='$id'";
	if($pdo->exec($sql)){
		$sql="delete from ".self::$table_pre."table where `regular_id`=".$id;
		$pdo->exec($sql);
		$sql="delete from ".self::$table_pre."field where `regular_id`=".$id;
		$pdo->exec($sql);
		$sql="select `id` from ".self::$table_pre."task where `regular_id`=".$id;
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$sql="delete from ".self::$table_pre."file where `task_id`=".$v['id'];
			$pdo->exec($sql);	
		}
		
		$sql="delete from ".self::$table_pre."task where `regular_id`=".$id;
		$pdo->exec($sql);
		
		
		
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
