<?php
$act=@$_GET['act'];

if($act=='del'){
	$id=intval(@$_GET['id']);
	if($id==0){exit('id err');}
	$sql="delete from ".self::$table_pre."receiver where `id`='".$id."' and `username`='".$_SESSION['monxin']['username']."'";
	var_dump($pdo->exec($sql));
	exit;	
}

if($act=='get_receiver'){
	$id=intval(@$_GET['id']);
	if($id==0){exit('id err');}
	$sql="select * from ".self::$table_pre."receiver where `id`='".$id."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit('id err');}
	$power=false;
	if($r['username']==''){
		if($_SESSION['receiver_id']==$r['id']){$power=true;}
	}else{
		if(@$_SESSION['monxin']['username']==$r['username']){$power=true;}
	}
	$r=de_safe_str($r);
	if($r['post_code']!=''){$r['post_code']='('.$r['post_code'].')';}
	if($r['tag']!=''){$r['tag']='<span class=tag ><span>'.$r['tag'].'</span></span>';}
	echo '<div class=receiver_head><span class=name>'.$r['name'].'</span>'.$r['tag'].'</div>
                        <div class=phone>'.$r['phone'].'</div>
                        <div class=area_id>'.get_area_name($pdo,$r['area_id']).'</div>
                        <div class=detail>'.$r['detail'].$r['post_code'].'</div>
						<div class=button_div><span class=edit>'.self::$language['edit'].'</span><span class=del>'.self::$language['del'].'</span><span class=go_left title="'.self::$language['go_left'].'">&nbsp;</span><span class=go_right title="'.self::$language['go_right'].'">&nbsp;</span></div>
						';
	exit;	
}

if($act=='set_sequence'){
	$temp=safe_str(@$_POST['data']);
	if($temp==''){echo 'data is null';exit;}
	$temp=trim($temp,',');
	$temp=explode(',',$temp);
	foreach($temp as $k=>$v){
		$v=explode(':',$v);
		$v[0]=intval($v[0]);
		$v[1]=intval($v[1]);
		if($v[0]!=0){
			$sql="update ".self::$table_pre."receiver set `sequence`='".$v[1]."' where `id`='".$v[0]."' and `username`='".$_SESSION['monxin']['username']."'";
			$pdo->exec($sql);	
		}	
	}
	echo 'done';
	exit;	
}