<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$package_id=intval(@$_GET['package_id']);
$relevance_new=intval(@$_GET['relevance_new']);

if($relevance_new!=0){
	if($package_id==0){
		$sql="select `id` from ".self::$table_pre."package where `goods_ids`='".$relevance_new."' and `shop_id`=".SHOP_ID." limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){
			$sql="insert into ".self::$table_pre."package (`shop_id`,`goods_ids`) values ('".SHOP_ID."','".$relevance_new."')";
			$pdo->exec($sql);
		}
	}else{
		$sql="select `goods_ids` from ".self::$table_pre."package where `id`=".$package_id." and `shop_id`=".SHOP_ID;
		$r=$pdo->query($sql,2)->fetch(2);
		$r['goods_ids'].=",".intval($_GET['relevance_new']);
		$temp=explode(',',$r['goods_ids']);
		$temp=array_filter($temp);
		$temp=array_unique($temp);
		$temp=implode(',',$temp);
		$sql="update ".self::$table_pre."package set `goods_ids`='".trim($temp,',')."' where `id`='".$package_id."' and `shop_id`=".SHOP_ID;
		$pdo->exec($sql);	
	}
}


$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."package where `shop_id`=".SHOP_ID;

$where="";
if($package_id!=0){
	$where=" and `id`=".$package_id;
	echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=mall.package_admin">'.self::$language['pages']['mall.package_admin']['name'].'</a><span class=text>'.$package_id.'</span></div>';
}
$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_package and","_package where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_package and","_package where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';

foreach($r as $v){
	if($v['goods_ids']==''){continue;}
	$sql="select `min_price`,`max_price`,`w_price`,`option_enable`,`title`,`icon`,`id` from ".self::$table_pre."goods where `id` in (".$v['goods_ids'].") and `shop_id`=".SHOP_ID;
	//echo $sql;
	$r2=$pdo->query($sql,2);
	$temp=array();
	foreach($r2 as $v2){
		if($v2['option_enable']==0){
			$w_price='<span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=money_value>'.$v2['w_price'].'</span>';
		}else{
			$w_price='<span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=money_value>'.$v2['min_price'].'-'.$v2['max_price'].'</span>';
		}
		$temp[$v2['id']]='<div class=goods_div id=goods_div_'.$v2['id'].'><a href="./index.php?monxin=mall.goods&id='.$v2['id'].'" target=_blank class=goods_a><img src="./program/mall/img_thumb/'.$v2['icon'].'" /><br />'.$w_price.'<br /><span class=goods_name>'.$v2['title'].'</span></a><a href=# class=move_to_left>&nbsp;</a><a href=# class=move_to_right>&nbsp;</a><a href=# class=delete_me>&nbsp;</a></div>';	
		
	}
	$temp2=explode(',',$v['goods_ids']);
	$temp3='';
	foreach($temp2 as $v2){
		$temp3.=@$temp[$v2];	
	}
	
	$list.='<div class=package_div id=package_div_'.$v['id'].'>'.$temp3.'<a href="./index.php?monxin=mall.goods_admin&package_id='.$v['id'].'&act=relevance_package&goods_ids='.$v['goods_ids'].'" class=goods_div id=add>&nbsp;</a><div class="equal_symbol">&nbsp;</div><div class=goods_div style="text-align:left; margin-bottom: -75px;">'.self::$language['free_shipping'].' <select class=free_shipping monxin_value='.$v['free_shipping'].'><option value=0>'.self::$language['no'].'</option><option value=1>'.self::$language['yes'].'</option></select><br /><input type=text class=discount value="'.$v['discount'].'" />'.self::$language['discount'].'<br /><br /><div class=operation_div><a href="#"  class="submit">'.self::$language['save'].'</a><br /><br /><a href="#" class="del">'.self::$language['del'].'</a><br /><span class="state"></span></a></div></div></div>';	
}
$module['list']=$list;
if($package_id==0 && $_GET['current_page']==1){$module['list']='<div class=package_div id=new><a href="./index.php?monxin=mall.goods_admin&act=relevance_package" class=goods_div id=add>&nbsp;</a></div>'.$module['list'];}
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);





		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
