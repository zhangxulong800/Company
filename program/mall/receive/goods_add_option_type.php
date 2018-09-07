<?php
$act=@$_GET['act'];
if($act=='get_sub'){
	$parent=intval(@$_GET['parent']);
	if($parent==0){exit('<option value="-1">'.self::$language['no_sub_type'].'</option>');}	
	$sql="select `id`,`name` from ".self::$table_pre."type where `parent`=".$parent."  and `visible`=1 order by `sequence` desc,`id` asc";
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$list.="<option value='".$v['id']."'>".$v['name']."</option>";	
	}
	if($list==''){$list='<option value="-1">'.self::$language['no_sub_type'].'</option>';}
	exit($list);
}
