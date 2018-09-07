<?php
$act=@$_GET['act'];

if($act=='export_led'){
	$sql="select `id`,`title`,`e_price`,`option_enable`,`min_price`,`max_price` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID."  and `state`!=0 order by `sequence` desc,`sold` desc";
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$v['title']=str_replace(',',' ',$v['title']);
		if($v['option_enable']!=0 ){
			if($v['min_price']!=$v['max_price']){$v['e_price']=$v['min_price'].'-'.$v['max_price'];}else{$v['e_price']=$v['min_price'];}
			
		}
		$list.=$v['title'].''.$v['e_price'].self::$language['yuan']." ";	
		
	}
	echo '<textarea style="width:100%;min-height:600px;">'.$list.'</textarea>';
	exit;
		
}


if($act=='export_weight_goods'){
	$sql="select `id`,`title`,`e_price`,`bar_code`,`speci_bar_code`,`option_enable`,`shelf_life` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID."  order by `sequence` desc,`id` asc";
	$r=$pdo->query($sql,2);
	$list='';
	$i=1;
	foreach($r as $v){
		$v['title']=str_replace(',',' ',$v['title']);
		if($v['option_enable']==0){
			if(strlen($v['bar_code'])!=5){continue;}
			$list.=$i.','.mb_substr($v['title'],0,15,'utf-8').','.$v['e_price'].',,'.$v['bar_code'].','.$v['shelf_life'].','."\r\n";	
			$i++;
		}else{
			if($v['speci_bar_code']==''){continue;}
			$temp=explode('|',$v['speci_bar_code']);
			foreach($temp as $t2){
				if(strlen($t2)!=5){continue;}
				$sql="select `e_price`,`id`,`option_id`,`color_name` from ".self::$table_pre."goods_specifications where `goods_id`='".$v['id']."' and `barcode`='".$t2."' limit 0,1";
				$r2=$pdo->query($sql,2)->fetch(2);
				$list.=$i.','.mb_substr($v['title'],0,8,'utf-8').' '.str_replace(',',' ',$r2['color_name']).' '.str_replace(',',' ',self::get_type_option_name($pdo,$r2['option_id'])).','.$r2['e_price'].',,'.$t2.','.$v['shelf_life'].','."\r\n";	
				$i++;
			}
		}
		
	}
	
	header("Content-Type: text/txt");
	header("Content-Disposition: attachment; filename=export_goods_".date("Y-m-d H_i_s").".txt");
	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
	header('Expires:0');
	header('Pragma:public');
	$list=str_replace('  ',' ',$list);
	$list=mb_convert_encoding($list,self::$config['other']['export_csv_charset'],"UTF-8");
	//$list=iconv("UTF-8",self::$config['other']['export_csv_charset'],$list);
	echo $list;
	exit;
		
}

self::update_config_file('goods_update_time',time());
$id=intval(@$_GET['id']);


if($act=='update_sequence'){
	$_GET['sequence']=intval(@$_GET['sequence']);
	$sql="update ".self::$table_pre."goods set `shop_sequence`='".$_GET['sequence']."' where `id`='$id' and `shop_id`=".SHOP_ID;	
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='update_bidding_show'){
	$_GET['bidding_show']=floatval(@$_GET['bidding_show']);
	if($_GET['bidding_show']<0){exit("{'state':'fail','info':'<span class=fail>".self::$language['less_than']."0</span>'}");}
	if($_GET['bidding_show']>999){exit("{'state':'fail','info':'<span class=fail>".self::$language['must_be_less_than']."999</span>'}");}
	
	$sql="select `money` from ".$pdo->index_pre."user where `username`='".$_SESSION['monxin']['username']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['money']<$_GET['bidding_show']){exit("{'state':'fail','info':'<span class=fail>".self::$language['insufficient_balance'].",".self::$language['please'].' <a href=./index.php?monxin=index.recharge target=_blank>'.self::$language['recharge']."</a> </span>'}");}
	$sql="update ".self::$table_pre."goods set `bidding_show`='".$_GET['bidding_show']."' where `id`='$id' and `shop_id`=".SHOP_ID;	
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='update_state'){
	$_GET['state']=intval(@$_GET['state']);
	$sql="update ".self::$table_pre."goods set `state`='".$_GET['state']."' where `id`='$id' and `shop_id`=".SHOP_ID;	
	$pdo->exec($sql);
	if($_GET['state']==0){
		$sql="delete from ".self::$table_pre."cart where `key`='".$id."' or `key` like '".$id."\_%'";
		$pdo->exec($sql);
	}
	exit();
}
if($act=='del'){
	if(self::delete_goods($pdo,$id,SHOP_ID)){
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
		if(self::delete_goods($pdo,$id,SHOP_ID)){
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");	
	self::update_shop_goods($pdo,self::$table_pre,SHOP_ID);		
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
		if($_GET['visible']==0){
			$sql="delete from ".self::$table_pre."cart where `key`='".$id."' or `key` like '".$id."\_%'";
			$pdo->exec($sql);
		}
	}
	$ids=trim($temp,","); 
	if($_GET['visible']==0){
		$sql="update ".self::$table_pre."goods set `state`='".$_GET['visible']."' where `id` in ($ids) and `shop_id`=".SHOP_ID;
	}else{
		$sql="update ".self::$table_pre."goods set `state`='".$_GET['visible']."' where `id` in ($ids) and `state`=0 and `shop_id`=".SHOP_ID;
	}
	
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