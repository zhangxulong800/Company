<?php
$act=@$_GET['act'];
if($act=='get_sub'){
	$parent=intval(@$_GET['parent']);
	if($parent==0){exit('<option value="-1">'.self::$language['no_sub_type'].'</option>');}	
	$sql="select `id`,`name` from ".self::$table_pre."type where `parent`=".$parent." order by `sequence` desc,`id` asc";
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$list.="<option value='".$v['id']."'>".$v['name']."</option>";	
	}
	if($list==''){$list='<option value="-1">'.self::$language['no_sub_type'].'</option>';}
	exit($list);
}

if($act=='save'){
	$_GET['c_id']=intval(@$_GET['c_id']);
	$type=intval($_GET['type']);
	$sql="update ".self::$table_pre."content set `type`='".$type."' where `id`=".$_GET['c_id'];	
	if($pdo->exec($sql)){
		$html=str_replace(' <','> <',self::get_type_position($pdo,$type)).' <a href=./index.php?monxin=ci.set_type&c_id='.$_GET['c_id'].'&id='.$type.' class=set>&nbsp;</a>';
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','html':'".$html."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}