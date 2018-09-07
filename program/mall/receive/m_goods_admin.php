<?php
self::update_config_file('goods_update_time',time());
$act=@$_GET['act'];
$id=intval(@$_GET['id']);

function delete_goods_relevant($pdo,$table_pre,$id){
	$sql="delete from ".$table_pre."goods_attribute where `goods_id`=".$id;
	$pdo->exec($sql);
	$sql="delete from ".$table_pre."goods_inventory_log where `goods_id`=".$id;
	$pdo->exec($sql);
	
	$sql="select `color_img` from ".$table_pre."goods_specifications where `goods_id`=".$id." and `color_img`!=''";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		@safe_unlink('./program/mall/img/'.$v['color_img']);
		@safe_unlink('./program/mall/img_thumb/'.$v['color_img']);
	}
	$sql="delete from ".$table_pre."goods_specifications where `goods_id`=".$id;
	$pdo->exec($sql);
}


if($act=='update_sequence'){
	$_GET['sequence']=intval(@$_GET['sequence']);
	$sql="update ".self::$table_pre."goods set `sequence`='".$_GET['sequence']."' where `id`='$id'";	
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='update_mall_state'){
	$_GET['sequence']=intval(@$_GET['sequence']);
	$sql="update ".self::$table_pre."goods set `mall_state`='".$_GET['state']."' where `id`='$id'";	
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='del'){
	$sql="select `detail`,`icon`,`multi_angle_img` from ".self::$table_pre."goods where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="delete from ".self::$table_pre."goods where `id`='$id'";
	if($pdo->exec($sql)){
		@safe_unlink("./program/mall/img_thumb/".$r['icon']);
		@safe_unlink("./program/mall/img/".$r['icon']);
		if($r['multi_angle_img']!=''){
			$temp=explode('|',$r['multi_angle_img']);
			foreach($temp as $v){
				@safe_unlink("./program/mall/img_thumb/".$v);
				@safe_unlink("./program/mall/img/".$v);
			}	
		}
		$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
		$imgs=get_match_all($reg,$r['detail']);
		//var_dump($imgs);
		reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);	
		delete_goods_relevant($pdo,self::$table_pre,$id);
		self::update_shop_goods($pdo,self::$table_pre,SHOP_ID);
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
		$sql="select `detail`,`icon`,`multi_angle_img` from ".self::$table_pre."goods where `id`='$id'";
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="delete from ".self::$table_pre."goods where `id`='$id'";
		if($pdo->exec($sql)){
			@safe_unlink("./program/mall/img_thumb/".$r['icon']);
			@safe_unlink("./program/mall/img/".$r['icon']);
			if($r['multi_angle_img']!=''){
				$temp=explode('|',$r['multi_angle_img']);
				foreach($temp as $v){
					@safe_unlink("./program/mall/img_thumb/".$v);
					@safe_unlink("./program/mall/img/".$v);
				}	
			}
			$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
			$imgs=get_match_all($reg,$r['detail']);
			//var_dump($imgs);
			reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);	
			delete_goods_relevant($pdo,self::$table_pre,$id);
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");	
	self::update_shop_goods($pdo,self::$table_pre,SHOP_ID);		
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
if($act=='set_mall_state'){
	$ids=@$_GET['ids'];
	$_GET['v']=intval(@$_GET['v']);
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=str_replace("|",",",$ids);
	$ids=trim($ids,",");
	$ids=explode(",",$ids);
	$ids=array_map('intval',$ids);
	$temp='';
	foreach($ids as $id){
		$temp.=$id.",";	
	}
	$ids=trim($temp,","); 
	$sql="update ".self::$table_pre."goods set `mall_state`='".$_GET['v']."' where `id` in ($ids)";
	$pdo->exec($sql);
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>'}");
}

if($act=='mass_select'){
	$ids=safe_str($_GET['ids']);
	$ids=str_replace('|',',',$ids);
	$ids=trim($ids,',');
	if($ids==''){echo self::$language['is_null'];exit;}
	$sql="select `id`,`icon`,`title` from ".self::$table_pre."goods where `id` in (".$ids.")";
	$r=$pdo->query($sql,2);
	$array=array();
	foreach($r as $v){
		$v=de_safe_str($v);
		$array[$v['id']]=array();
		$array[$v['id']]['icon']='./program/mall/img/'.$v['icon'];	
		$array[$v['id']]['title']=$v['title'];	
		$array[$v['id']]['url']='./index.php?monxin=mall.goods&id='.$v['id'];	
	}
	
	$value=json_encode($array);
	echo '<script type="text/javascript">
function autoSubmit(){
 document.getElementById("myForm").submit();
}
</script><body onload="autoSubmit();" ><form id=myForm action="./index.php?monxin=weixin.mass&wid='.self::$config['web']['wid'].'" method="post"><input type=hidden id=new name=new value=\''.$value.'\'  /><input type="submit" value="Submit" /></form></body>';
	exit;
}