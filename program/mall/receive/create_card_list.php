<?php
$act=@$_GET['act'];
$id=intval(@$_GET['id']);
if($act=='export'){
		header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=export_user".date("Y-m-d H_i_s").".csv");
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0');
		header('Pragma:public');
		
		$list=self::$language['username'].",".self::$language['money'].",".self::$language['chip'].",".self::$language['password'].",".self::$language['transaction_password']."\r\n";	

		$sql="select * from  ".self::$table_pre."create_card where `batch_id`=".$id;
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$list.=$v['username']."\t,".$v['money']."\t,".$v['chip'].",".$v['password']."\t,".$v['transaction_password']."";
			$list.="\r\n";	
		}
		
		$list=iconv("UTF-8",self::$config['other']['export_csv_charset']."//IGNORE",$list);
		echo $list;
		exit;
}

if($act=='del'){
	$sql="delete from ".self::$table_pre."create_card_batch  where `id`=".$id;
	if($pdo->exec($sql)){
		$sql="delete from ".self::$table_pre."create_card where `batch_id`=".$id;
		$pdo->exec($sql);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}	
}