<?php
$act=@$_GET['act'];
if($act=='add'){
	$_POST['reason']=safe_str(@$_POST['reason']);
	$_POST['money']=floatval(@$_POST['money']);
	$_POST['type']=intval(@$_POST['type']);
	$_POST['method']=intval(@$_POST['method']);
	if($_POST['method']==0){$_POST['money']='-'.$_POST['money'];}
	
	if(self::operation_finance(self::$language,$pdo,self::$table_pre,0,$_POST['money'],$_POST['type'],$_POST['reason'])){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
