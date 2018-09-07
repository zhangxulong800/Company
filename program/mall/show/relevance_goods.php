<?php

if(intval(@$_GET['goods_id'])==0){echo 'need goods_id';return false;}
$goods_id=intval(@$_GET['goods_id']);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&goods_id='.$goods_id;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);


if(isset($_GET['relevance_new'])){
	if($_GET['relevance_new']!=$goods_id){
		$sql="select `relevance_goods` from ".self::$table_pre."goods where `id`=".$goods_id." and `shop_id`=".SHOP_ID;
		$r=$pdo->query($sql,2)->fetch(2);
		$r['relevance_goods'].=",".intval($_GET['relevance_new']);
		$temp=explode(',',$r['relevance_goods']);
		$temp=array_filter($temp);
		$temp=array_unique($temp);
		$temp=implode(',',$temp);
		$sql="update ".self::$table_pre."goods set `relevance_goods`='".trim($temp,',')."' where `id`='".$goods_id."' and `shop_id`=".SHOP_ID;
		$pdo->exec($sql);	
	}
}

$sql="select `title`,`relevance_goods` from ".self::$table_pre."goods where `id`=".$goods_id." and `shop_id`=".SHOP_ID;
$r=$pdo->query($sql,2)->fetch(2);
//echo $r['relevance_goods'];
if($r['relevance_goods']==''){
	$module['data']='';
}else{
	$sql="select `title`,`icon`,`id` from ".self::$table_pre."goods where `id` in (".$r['relevance_goods'].") and `shop_id`=".SHOP_ID;
	//echo $sql;
	$r2=$pdo->query($sql,2);
	$temp=array();
	foreach($r2 as $v){
		$temp[$v['id']]='<div class=goods_div id=goods_div_'.$v['id'].'><a href="./index.php?monxin=mall.goods&id='.$v['id'].'" target=_blank class=goods_a><img src="./program/mall/img_thumb/'.$v['icon'].'" /><br />'.$v['title'].'</a><br /><a href=# class=move_to_left>&nbsp;</a><a href=# class=move_to_right>&nbsp;</a><a href=# class=delete_me>&nbsp;</a></div>';	
	}
	$temp2=explode(',',$r['relevance_goods']);
	$module['data']='';
	foreach($temp2 as $v){
		$module['data'].=@$temp[$v];	
	}

}

echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=mall.goods_admin&id='.$goods_id.'">'.mb_substr($r['title'],0,30,'utf-8').'</a><span class=text>'.self::$language['pages']['mall.relevance_goods']['name'].'</span></div>';
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
