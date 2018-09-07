<?php
$act=@$_GET['act'];
$id=intval(@$_POST['id']);
//echo $id;
require("./program/index/index.class.php");

if($act=='get_managers'){
	if(index::check_user_power($pdo,$id)){	
		$group=intval(@$_POST['group']);
		if($id!=0 && $group!=0){
			$sql="select `manager` from ".$pdo->index_pre."user where `id`='$id'";
			$r=$pdo->query($sql,2)->fetch(2);
			$manager=$r['manager'];
			$sql="select `parent` from ".$pdo->index_pre."group where `id`='$group'";
			$r=$pdo->query($sql,2)->fetch(2);
			$group=$r['parent'];
			$sql="select `name` from ".$pdo->index_pre."group where `id`='$group'";
			$r=$pdo->query($sql,2)->fetch(2);
			$group_name=$r['name'];
			$sql="select `id`,`username`,`real_name` from ".$pdo->index_pre."user where `group`='$group' and `id`!='$id' ";
			$r=$pdo->query($sql,2);
			$list='';
			foreach($r as $v){
				if($manager==$v['id']){$selected='selected';}else{$selected='';}
				$list.='<option value="'.$v['id'].'" '.$selected.'>'.$group_name.':'.$v['username'].'('.$v['real_name'].')</option>';	
			}
			if($list==''){$list='<option value="0">'.$group_name.':'.self::$language['none'].'</option>';}
			exit("{'state':'success','info':'".$list."'}");
		}	
	}
}

if($act=='set_manager'){
	$manager=intval(@$_POST['manager']);
	if($manager==0){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['parent'].self::$language['is_null']."'}");}
	$group=intval(@$_POST['group']);
	$sql="select `username` from ".$pdo->index_pre."user where `id`=".$_POST['id'];
	$user=$pdo->query($sql,2)->fetch(2);
	if(is_numeric(@$_POST['id']) && $group!=0){
		
		if($_POST['id']==$manager || index::check_user_power($pdo,$_POST['id'])==0){exit();}
		$sql="update ".$pdo->index_pre."user set `manager`='$manager',`group`='$group' where `id`='".$_POST['id']."' and `id`!='$manager'";
	}else{
		$_POST['id']=explode(',',$_POST['id']);
		$ids='';
		foreach($_POST['id'] as $v){
			if(is_numeric($v)){
				if(index::check_user_power($pdo,$v)){$ids.=$v.',';}
			}
		}
		$ids=trim($ids,',');
		$sql="update ".$pdo->index_pre."user set `manager`='$manager',`group`='$group' where `id` in ($ids)";
	}
	$old=get_user_group_name($pdo,$user['username']);
	if($pdo->exec($sql)){
		$new=get_user_group_name($pdo,$user['username']);
		push_group_change($pdo,self::$config,self::$language,$user['username'],$old,$new);
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
		
}
