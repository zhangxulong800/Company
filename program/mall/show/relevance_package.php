<?php

if(intval(@$_GET['goods_id'])==0){echo 'need goods_id';return false;}
$goods_id=intval(@$_GET['goods_id']);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&goods_id='.$goods_id;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);


if(isset($_GET['relevance_new'])){
	if($_GET['relevance_new']!=$goods_id){
		$sql="select `relevance_package` from ".self::$table_pre."goods where `id`=".$goods_id." and `shop_id`=".SHOP_ID;
		$r=$pdo->query($sql,2)->fetch(2);
		$r['relevance_package'].=",".intval($_GET['relevance_new']);
		$temp=explode(',',$r['relevance_package']);
		$temp=array_filter($temp);
		$temp=array_unique($temp);
		$temp=implode(',',$temp);
		$sql="update ".self::$table_pre."goods set `relevance_package`='".trim($temp,',')."' where `id`='".$goods_id."' and `shop_id`=".SHOP_ID;
		$pdo->exec($sql);	
	}
}

$sql="select `title`,`relevance_package` from ".self::$table_pre."goods where `id`=".$goods_id." and `shop_id`=".SHOP_ID;
$r=$pdo->query($sql,2)->fetch(2);
$relevance_package=$r['relevance_package'];
echo '<div  style="display:none;" id="user_position_append"><a href=./index.php?monxin=mall.goods_admin>'.self::$language['pages']['mall.goods_admin']['name'].'</a><a href="./index.php?monxin=mall.goods_admin&id='.$goods_id.'">'.mb_substr($r['title'],0,30,'utf-8').'</a><span class=text>'.self::$language['pages']['mall.relevance_package']['name'].'</span></div>';

//echo $r['relevance_package'];
if($r['relevance_package']==''){
	$module['data']='';
}else{
	$sql="select * from ".self::$table_pre."package where `id` in (".$r['relevance_package'].") and `shop_id`=".SHOP_ID;
	//echo $sql;
	$package_ids=$r['relevance_package'];
	$r=$pdo->query($sql,2);
	$list=array();
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
			$temp[$v2['id']]='<div class=goods_div id=goods_div_'.$v2['id'].'><a href="./index.php?monxin=mall.goods&id='.$v2['id'].'" target=_blank class=goods_a><img src="./program/mall/img_thumb/'.$v2['icon'].'" /><br />'.$w_price.'<br /><span class=goods_name>'.$v2['title'].'</span></a></div><div class="add_symbol">&nbsp;</div>';	
		}
		$temp2=explode(',',$v['goods_ids']);
		$temp3='';
		foreach($temp2 as $v2){
			$temp3.=@$temp[$v2];	
		}		
		$list[$v['id']]='<div class=package_div id=package_div_'.$v['id'].'>'.$temp3.'<div class=result_div><a href="./index.php?monxin=mall.package_admin&package_id='.$v['id'].'" target=_blank class=edit>'.self::$language['edit'].self::$language['package'].'</a><br /><span class=discount_value>'.str_replace('.00','',$v['discount']).self::$language['discount'].'</span><br /><a href=# class=move_to_left>&nbsp;</a><a href=# class=move_to_right>&nbsp;</a><a href=# class=delete_me>&nbsp;</a></div></div>';	
	}
	

	$temp2=explode(',',$relevance_package);
	$temp3='';
	foreach($temp2 as $v2){
		$temp3.=@$list[$v2];	
	}		
	$list=$temp3;
	$list=str_replace('<div class="add_symbol">&nbsp;</div><div class=result_div>','<div class="equal_symbol">&nbsp;</div><div class=result_div>',$list);
	$module['data']=$list;
	
	}
	$module['data']=$module['data'].'<div class=package_div id=new><a href="./index.php?monxin=mall.package_admin&goods_id='.$goods_id.'&act=relevance_package&package_ids='.@$package_ids.'" class=goods_div id=add>&nbsp;</a></div>';


		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
