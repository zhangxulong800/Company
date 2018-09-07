<?php
$act=@$_GET['act'];
if($act=='get_shops'){	
	
	$sql="select `id`,`name`,`position` from ".self::$table_pre."shop where `state`=2 and `is_head`=0";
	
	$circle=intval($_COOKIE['circle']);
	if($circle>0){
		$circle=get_circle_ids($pdo,$circle);
		$sql.=" and (`circle` in (".$circle.") || `span_circle`=1)";	
	}
	$tag=intval(@$_GET['tag']);
	if($tag>0){
		$sql.=" and `tag` like '%|".$tag."|%'";	
	}
	$geo=safe_str($_POST['latlng']);
	$zoom=intval($_POST['zoom']);
	if(isset($geo)){		
		if($zoom<2){$zoom=2;}
		$geohash=new Geohash;
		$temp=explode(',',$geo);
		$module['point']=$temp[1].','.$temp[0];
		//$geohash_str=$geohash->encode( sprintf("%.1f",$temp[0]), sprintf("%.1f",$temp[1]));
		$geohash_str=$geohash->encode( $temp[0],$temp[1]);
		$geohash_str=substr($geohash_str,0,self::$config['map_zoom_geo'][$zoom]);
		$neighbors=$geohash->neighbors(substr($geohash_str,0,$zoom));
		$neighbors_sql='';
		foreach($neighbors as $v){
			$neighbors_sql.=" or `geohash` like '".$v."%'";
		}
		$sql.=" and (`geohash` like '".$geohash_str."%' ".$neighbors_sql.")";	
			
	}
	$page_size=100;
	$where="";
	
	if($_GET['search']!=''){$_GET['search']=safe_str($_GET['search']);$where=" and (`username` like '%".$_GET['search']."%' or `reg_username` like '%".$_GET['search']."%' or `name` like '%".$_GET['search']."%' or `main_business` like '%".$_GET['search']."%' or `address` like '%".$_GET['search']."%' or `name_log` like '%".$_GET['search']."%' or `phone` like '%".$_GET['search']."%' or `email` like '%".$_GET['search']."%')";}
	
	$_GET['order']=safe_str(@$_GET['order']);
	$order=" order by `sequence` desc,`order` desc";
	$limit=" limit 0,".$page_size;
	$sql=$sql.$where.$order.$limit;
	$sql=str_replace("_shop and","_shop where",$sql);
	//echo($sql);
	//exit();
	$r=get_sql_cache(self::$config,$sql);
	if(!$r){$r=$pdo->query($sql,2);$sql_a_create=true;}else{$sql_a_create=false;}
	$sql_cache_a=array();
	$sql_a=$sql;
	
	$list='';
	foreach($r as $v){
		$sql_cache_a[]=$v;
		$v=de_safe_str($v);
		$sql="select `id`,`icon` from ".self::$table_pre."goods where `shop_id`='".$v['id']."' and `state`!=0 and `mall_state`=1 and `online_forbid`=0 order by `sold` desc limit 0,3";
		$r2=$pdo->query($sql,2);
		$goods='';
		foreach($r2 as $v2){
			$goods.='<a href=./index.php?monxin=mall.goods&id='.$v2['id'].' target="_blank"><img src=./program/mall/img_thumb/'.$v2['icon'].' /></a>';
		}
		$my_latlng=$_GET['my_latlng'];
		$temp=explode(',',$v['position']);
		$icon='./program/mall/shop_icon/'.$v['id'].'.png';
		$list.="{title:'".$v['name']."',content:'<div class=shop_window><b class=shop_name >".$v['name']."</b><div class=shop_content><div class=goods_div>".$goods."</div><div class=bottom_div><a class=more href=./index.php?monxin=mall.shop_index&shop_id=".$v['id']." target=_blank>".self::$language['visit_shop_home']."</a><a target=_blank class=go_shop  href=http://api.map.baidu.com/direction?origin=latlng:".$my_latlng."|name:".self::$language['my_position']."&destination=latlng:".$temp[1].','.$temp[0]."|name:".$v['name']."&mode=driving&region=".$v['name']."&output=html&src=yourCompanyName|yourAppName>".self::$language['to_store_navigation']."</a></div></div></div>',point:'".$temp[0].'|'.$temp[1]."',isOpen:0,icon:'".$icon."'},
		
		";	
		
	
	}
	if($sql_a_create){set_sql_cache(self::$config,$sql_a,$sql_cache_a);}
	exit($list);	
	exit('['.$list.']');	
}