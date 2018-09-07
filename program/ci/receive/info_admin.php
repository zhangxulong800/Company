<?php
$act=@$_GET['act'];
$id=intval(@$_GET['id']);
if(isset($_GET['export'])){
	$type=intval($_GET['export']);
	$sql="select `contact` from ".self::$table_pre."content";
	$where='';
	$file_name=self::$language['mobile_number'].'('.self::$language['all'].')';
	if($type>0){
		$type_ids=$this->get_type_ids($pdo,$type);
		$where.=" where `type` in (".$type_ids.")";
		$sql2="select `name` from ".self::$table_pre."type where `id`=".$type;
		$r=$pdo->query($sql2,2)->fetch(2);
		$file_name=self::$language['mobile_number'].'('.$r['name'].')';
	}
	$sql=$sql.$where;
	$r=$pdo->query($sql);
	$phones=array();
	foreach($r as $v){
		if(is_match(self::$config['other']['reg_phone'],$v['contact'])){$phones[]=$v['contact'];}	
	}
	$phones=array_unique($phones);
	$sum=count($phones);
	$phones=implode(",\r\n",$phones);
	
	header("Content-Type: text/txt");
	header("Content-Disposition: attachment; filename=".$file_name.$sum.".txt");
	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
	header('Expires:0');
	header('Pragma:public');
	echo $phones;
	exit;
}


function delete_info_relevant($pdo,$table_pre,$id){	
	$sql="select * from ".$table_pre."attribute_value where `c_id`=".$id."";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$sql="select `input_type` from ".$table_pre."type_attribute where `id`=".$v['a_id'];
		$r2=$pdo->query($sql,2)->fetch(2);
		switch($r2['input_type']){
			case 'editor':
				$reg='#<img.*src=&\#34;(program/ci/attachd/.*)&\#34;.*>#iU';
				$imgs=get_match_all($reg,$v['content']);
				//var_dump($imgs);
				reg_attachd_img("del",'ci',$imgs,$pdo);	
				break;
			case 'img':
				@safe_unlink("./program/ci/img_thumb/".$v['content']);
				@safe_unlink("./program/ci/img/".$v['content']);
				break;
			case 'imgs':
				$temp=explode('|',$v['content']);
				foreach($temp as $v2){
					@safe_unlink("./program/ci/imgs_thumb/".$v2);
					@safe_unlink("./program/ci/imgs/".$v2);
				}
				break;
			case 'file':
				@safe_unlink("./program/ci/file/".$v['content']);
				break;
			case 'files':
				$temp=explode('|',$v['content']);
				foreach($temp as $v2){
					@safe_unlink("./program/ci/files/".$v2);
				}
				break;
		}
	}
	$sql="delete from ".$table_pre."attribute_value where `c_id`=".$id."";
	$pdo->exec($sql);
}


if($act=='update_state'){
	$_GET['state']=intval(@$_GET['state']);
	$sql="update ".self::$table_pre."content set `state`='".$_GET['state']."' where `id`='$id'";	
	$pdo->exec($sql);
	exit();
}
if($act=='del'){
	$sql="select `icon`,`content` from ".self::$table_pre."content where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="delete from ".self::$table_pre."content where `id`='$id'";
	if($pdo->exec($sql)){
		@safe_unlink("./program/ci/img_thumb/".$r['icon']);
		@safe_unlink("./program/ci/img/".$r['icon']);
		$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
		$imgs=get_match_all($reg,$r['content']);
		//var_dump($imgs);
		reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);	
		delete_info_relevant($pdo,self::$table_pre,$id);
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
		$sql="select `icon`,`content` from ".self::$table_pre."content where `id`='$id'";
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="delete from ".self::$table_pre."content where `id`='$id'";
		if($pdo->exec($sql)){
			@safe_unlink("./program/ci/img_thumb/".$r['icon']);
			@safe_unlink("./program/ci/img/".$r['icon']);
			$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
			$imgs=get_match_all($reg,$r['content']);
			//var_dump($imgs);
			reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);	
			delete_info_relevant($pdo,self::$table_pre,$id);
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
if($act=='operation_visible'){
	$ids=@$_GET['ids'];
	$_GET['visible']=intval(@$_GET['visible']);
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
	$sql="update ".self::$table_pre."content set `state`='".$_GET['visible']."' where `id` in ($ids)";
	$pdo->exec($sql);
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>'}");
}

if($act=='update'){
	$time=time();
	$editor=$_SESSION['monxin']['id'];
	$_GET['state']=intval(@$_GET['state']);
	$_GET['sequence']=intval(@$_GET['sequence']);
	$sql="update ".self::$table_pre."content set `state`='".$_GET['state']."',`sequence`='".$_GET['sequence']."' where `id`='$id'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='submit_select'){
	//var_dump($_POST);	
	$time=time();
	$editor=$_SESSION['monxin']['id'];
	$success='';
	foreach($_POST as $v){
		$v['id']=intval($v['id']);
		$v['state']=intval($v['state']);
		$v['sequence']=intval($v['sequence']);
		$sql="update ".self::$table_pre."content set `state`='".$v['state']."',`sequence`='".$v['sequence']."' where `id`='".$v['id']."'";
		if($pdo->exec($sql)){$success.=$v['id']."|";}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}