<?php
$id=intval(@$_GET['id']);
$act=@$_GET['act'];
function encryption_username($v){
	return mb_substr($v,0,1,'utf-8').'**'.mb_substr($v,mb_strlen($v,'utf-8')-1,1,'utf-8');
}

if($act=='add_favorite'){
	
	if(!isset($_SESSION['monxin']['username'])){
		if($_COOKIE['monxin_device']=='pc'){
			exit("{'state':'fail','info':'<a href=./index.php?monxin=index.login class=fail>".self::$language['please_login']."</a>'}");
		}else{
			exit("{'state':'fail','info':'login'}");	
		}
	}	
	
	$sql="select `id` from ".self::$table_pre."favorite where `goods_id`='".$id."' and `username`='".$_SESSION['monxin']['username']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){
		$sql="update ".self::$table_pre."favorite set `time`='".time()."' where `id`=".$r['id'];
	}else{
		$sql="insert into ".self::$table_pre."favorite (`username`,`goods_id`,`time`) values ('".$_SESSION['monxin']['username']."','".$id."','".time()."')";	
	}
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
	}
}

if($act=='get_sold'){
	$last_id=intval(@$_GET['last_id']);
	$start_time=time()-(86400*30);
	$sql="select `id`,`title`,`quantity`,`time`,`price`,`buyer`,`order_id` from ".self::$table_pre."order_goods where `goods_id`='".$id."' and `time`>".$start_time." and `id`<".$last_id." order by `id` desc limit 0,".self::$config['monthly_sold_page_size'];
	$r=$pdo->query($sql,2);
	$temp='';
	foreach($r as $v){
		$v=de_safe_str($v);
		if(mb_strlen($v['title'],'utf-8')>18){
			$v['title']=mb_substr($v['title'],0,8,'utf-8').'**'.mb_substr($v['title'],mb_strlen($v['title'],'utf-8')-8,8,'utf-8');
		}
		
		if($v['buyer']==''){
			$v['buyer']=self::$language['tourist'];
			$sql="select `cashier` from ".self::$table_pre."order where `id`=".$v['order_id'];
			$b=$pdo->query($sql,2)->fetch(2);
			if($b['cashier']!=''){$v['buyer']=self::$language['offline_sales'];}
		}else{$v['buyer']=encryption_str($v['buyer']);}

		if($_COOKIE['monxin_device']!='pc'){
			$temp.='<tr id='.$v['id'].'><td><span class=username>'.encryption_username($v['buyer']).'</span></td><td>'.$v['title'].'</td><td>'.date('Y-m-d',$v['time']).'</td></tr>';
		}else{
			$temp.='<tr id='.$v['id'].'><td><span class=username>'.encryption_username($v['buyer']).'</span></td><td>'.$v['price'].'</td><td>'.$v['title'].'</td><td>'.self::format_quantity($v['quantity']).'</td><td>'.date('Y-m-d',$v['time']).'</td></tr>';
		}
		
	}
	exit($temp);
}

if($act=='get_comment'){
	$last_id=intval(@$_GET['last_id']);
	$level=@$_GET['level'];
	if($level=='all'){
		$sql="select * from ".self::$table_pre."comment where `goods_id`='".$id."' and `state`=1 and `id`<".$last_id." order by `id` desc limit 0,".self::$config['comment_page_size'];
	}else{
		$sql="select * from ".self::$table_pre."comment where `goods_id`='".$id."' and `state`=1 and `id`<".$last_id." and `level`=".intval($level)." order by `id` desc limit 0,".self::$config['comment_page_size'];
	}	
	//echo $sql;
	$r=$pdo->query($sql,2);
	$html='';
	foreach($r as $v){
		$v=de_safe_str($v);
		if($v['answer']!=''){
			$answer="<div class=seller><span class=username>".self::$language['seller_answer'].": </span><span class=answer>".$v['answer']."</span><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['answer_time'])."</span></div>";
		}else{
			$answer='';	
		}
		$html.="<div class=cooment_line id=".$v['id']."><div class=buyer><span class=username>".encryption_username($v['buyer'])."</span><span class=point></span><span class=content>".$v['content'].$answer."</span><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</span></div></div>";	
			
		
	}
	$json=array();
	$json['level']=$level;
	$json['html']=$html;
	//var_dump($json);
	$json=json_encode($json);
	
	exit($json);
	
}


if($id>0){
	$sql="update ".self::$table_pre."goods set `visit`=visit+1 where `id`='$id'";
	$pdo->exec($sql);
	//add_visit
	
	if(isset($_SESSION['monxin']['username'])){
		$sql="select `id` from ".self::$table_pre."visit where `goods_id`='".$id."' and `username`='".$_SESSION['monxin']['username']."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){
			$sql="insert into ".self::$table_pre."visit (`goods_id`,`username`,`time`) values ('".$id."','".$_SESSION['monxin']['username']."','".time()."')";	
		}else{
			$sql="update ".self::$table_pre."visit set `time`='".time()."' where `id`=".$r['id'];
		}
		$pdo->exec($sql);	
	}
}