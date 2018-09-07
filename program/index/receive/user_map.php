<?php
$act=@$_GET['act'];
if($act=='get_shops'){	
	$sql="select `id`,`username`,`icon`,`geolocation` from ".$pdo->index_pre."user where `geohash`!=''";
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
	
	
	$_GET['order']=safe_str(@$_GET['order']);
	$order=" order by `cumulative_credits` desc";
	$limit=" limit 0,".$page_size;
	$sql=$sql.$where.$order.$limit;
	$sql=str_replace("_user and","_user where",$sql);
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
		$my_latlng=$_GET['my_latlng'];
		$temp=explode(',',$v['geolocation']);
		$icon='./program/index/user_icon/'.$v['icon'];
		$list.="{title:'".$v['username']."',content:'<div class=user_window><b >".$v['username']."</b><div class=content><img src=".$icon." /><div class=bottom_div><a class=edit href=index.php?monxin=index.admin_edit_user&id=".$v['id']." target=_blank>".self::$language['edit']."</a><a target=_blank class=go_shop  href=http://api.map.baidu.com/direction?origin=latlng:".$my_latlng."|name:".self::$language['my_position']."&destination=latlng:".$temp[0].','.$temp[1]."|name:".$v['username']."&mode=driving&region=".$v['username']."&output=html&src=yourCompanyName|yourAppName>".self::$language['line_navigation']."</a></div></div></div>',point:'".$temp[1].'|'.$temp[0]."',isOpen:0,icon:'".$icon."'},
		
		";	
		
	
	}
	if($sql_a_create){set_sql_cache(self::$config,$sql_a,$sql_cache_a);}
	exit($list);	
	exit('['.$list.']');	
}