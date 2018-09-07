<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);


if(!isset($_GET['geo'])){
	if(isset($_SESSION['monxin']['id'])){
		$sql="select `geolocation` from ".$pdo->index_pre."user where `id`=".$_SESSION['monxin']['id'];
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['geolocation']!=''){
			$temp=explode(',',$r['geolocation']);
			$geo=$temp[0].','.$temp[1];
		}
	}
}else{$geo=safe_str($_GET['geo']);}

if(!isset($geo)){
	$ip=get_ip();
	$sql="select `latlng` from ".$pdo->index_pre."ip_latlng where `ip`='".$ip."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['latlng']!=''){
		$geo=$r['latlng'];
	}else{
		$r=file_get_contents('http://api.map.baidu.com/location/ip?ak='.self::$config['web']['map_secret'].'&ip='.$ip.'&coor=bd09ll');
		$r=(json_decode($r,1));
		if(isset($r['content']['point'])){
			$geo=$r['content']['point']['y'].','.$r['content']['point']['x'];
			$sql="insert into ".$pdo->index_pre."ip_latlng (`ip`,`latlng`,`time`) values ('".$ip."','".$geo."','".time()."')";
			$pdo->exec($sql);
		}
	}
}
$module['my_latlng']=@$geo;




$sql="select `id`,`name`,`main_business`,`area`,`address`,`goods`,`order`,`position`,`evaluation_0`,`evaluation_1`,`evaluation_2`,`credits_rate`,`average`,`return_credits`,`pay_money` from ".self::$table_pre."shop where `state`=2 and `is_head`=0";

//area=============================================================================================================
/*$province=get_area_option($pdo,0);
if(intval(@$_GET['area_province'])!=0){
	$area=intval($_GET['area_province']);
	$city=get_area_option($pdo,$area);
	if($city!=''){$city='<select id=area_city name=area_city><option value="">'.self::$language['all'].'</option>'.$city.'</select>';}			
}
if(intval(@$_GET['area_city'])!=0){
	$area=intval($_GET['area_city']);
	$county=get_area_option($pdo,$area);
	if($county!=''){$county='<select id=area_county name=area_county><option value="">'.self::$language['all'].'</option>'.$county.'</select>';}
}
if(intval(@$_GET['area_county'])!=0){
	$area=intval($_GET['area_county']);
	$twon=get_area_option($pdo,$area);
	if($twon!=''){$twon='<select id=area_twon name=area_twon><option value="">'.self::$language['all'].'</option>'.$twon.'</select>';}
}
if(intval(@$_GET['area_twon'])!=0){
	$area=intval($_GET['area_twon']);
	$village=get_area_option($pdo,$area);
	if($village!=''){$village='<select id=area_village name=area_village><option value="">'.self::$language['all'].'</option>'.$village.'</select>';}
}
if(intval(@$_GET['area_village'])!=0){
	$area=intval($_GET['area_village']);
	$group=get_area_option($pdo,$area);
	if($group!=''){$group='<select id=area_group name=area_group><option value="">'.self::$language['all'].'</option>'.$group.'</select>';}
}
if(intval(@$_GET['area_group'])!=0){$area=intval($_GET['area_group']);}
if(isset($area)){
	$area=get_area_ids($pdo,$area);
	$area=trim($area,',');
	$sql.=" and `area` in (".$area.")";
	//echo $area;
}
*/

$circle=intval($_COOKIE['circle']);
if($circle>0){
	
	$circle=get_circle_ids($pdo,$circle);
	$sql.=" and (`circle` in (".$circle.") || `span_circle`=1)";	
}
$tag=intval(@$_GET['tag']);
if($tag>0){
	$sql.=" and `tag` like '%|".$tag."|%'";	
}
if(@$_GET['geo']!=''){
	$near=self::$config['near_default'];
	if(isset($_GET['near'])){$near=intval($_GET['near']);}
	if($near>0 && $near!=100){
		$geohash=new Geohash;
		$temp=explode(',',$_GET['geo']);
		//$geohash_str=$geohash->encode( sprintf("%.1f",$temp[0]), sprintf("%.1f",$temp[1]));
		$geohash_str=$geohash->encode( $temp[0],$temp[1]);
		$geohash_str=substr($geohash_str,0,$near);
		$neighbors=$geohash->neighbors(substr($geohash_str,0,$near));
		$neighbors_sql='';
		foreach($neighbors as $v){
			$neighbors_sql.=" or `geohash` like '".$v."%'";
		}
		$sql.=" and (`geohash` like '".$geohash_str."%' ".$neighbors_sql.")";	
	}
	
}

$where="";

if($_GET['search']!=''){$where=" and (`username` like '%".$_GET['search']."%' or `reg_username` like '%".$_GET['search']."%' or `name` like '%".$_GET['search']."%' or `main_business` like '%".$_GET['search']."%' or `address` like '%".$_GET['search']."%' or `name_log` like '%".$_GET['search']."%' or `phone` like '%".$_GET['search']."%' or `email` like '%".$_GET['search']."%')";}

$_GET['order']=safe_str(@$_GET['order']);
$order=" order by `sequence` desc,`id` desc";
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" `id`,`name`,`main_business`,`area`,`address`,`goods`,`order`,`position`,`evaluation_0`,`evaluation_1`,`evaluation_2`,`credits_rate`,`average`,`return_credits`,`pay_money` "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_shop and","_shop where",$sum_sql);
	$r=get_sql_cache(self::$config,$sum_sql);
	if(!$r){$r=$pdo->query($sum_sql,2)->fetch(2);set_sql_cache(self::$config,$sum_sql,$r);}

	$sum=$r['c'];
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
	$shop_position=explode(',',$v['position']);
	if(@$_GET['geo']!=''){
		$user_position=explode(',',$_GET['geo']);
		
		$distance=get_distance($user_position[1], $user_position[0], $shop_position[0], $shop_position[1]);
		$distance='<span class=distance>'.format_distance($distance).'</span>';
	}else{
		$distance='';
	}
	$destination=@$shop_position[1].','.@$shop_position[0];
	$satisfaction=self::get_satisfaction($v);
	$shop_credits_rate=str_replace('{v}',$v['credits_rate'],self::$language['shop_credits_rate']);
	$shop_credits_rate='';
	if($v['return_credits']>0){$shop_credits_rate.=$v['pay_money'].self::$language['yuan_2'].self::$language['give'].$v['return_credits'].self::$language['credits'];}
	
	
	if($_COOKIE['monxin_device']=='pc'){
		$sql="select `id`,`icon` from ".self::$table_pre."goods where `shop_id`='".$v['id']."' and `state`!=0 and `mall_state`=1 and `online_forbid`=0 order by `sold` desc limit 0,5";
		$r2=$pdo->query($sql,2);
		$goods='';
		foreach($r2 as $v2){
			$goods.='<a href=./index.php?monxin=mall.goods&id='.$v2['id'].' target="_blank"><img src=./program/mall/img_thumb/'.$v2['icon'].' /></a>';
		}
		$list.="<div class=shop_div>
			<div class=info>
				<a href=./index.php?monxin=mall.shop_index&shop_id=".$v['id']." class=icon target=_blank><img src=./program/mall/shop_icon/".$v['id'].".png /></a><div class=other>
					<a href=./index.php?monxin=mall.shop_index&shop_id=".$v['id']." target=_blank class=name>".$v['name']." <span class=shop_credits_rate>".$shop_credits_rate."</span>".$distance."</a>
					<div class=satisfaction value=".$satisfaction.">".self::$language['average'].":".$v['average'].self::$language['yuan_2']."</div>
					<div class=area><a href=# target=_blank class=navigate destination='".$destination."'>".$v['address']."</a></div>
					<div class=main_business><span class=m_label>".self::$language['the_main']." : </span>".$v['main_business']."</div>
				</div>
			</div><div class=goods>
			".$goods."
			</div>
		</div>";	
	
	}else{
		$sql="select `id`,`icon` from ".self::$table_pre."goods where `shop_id`='".$v['id']."' and `state`!=0 order by `sold` desc limit 0,4";
		$r2=$pdo->query($sql,2);
		$goods='';
		foreach($r2 as $v2){
			$goods.='<a href=./index.php?monxin=mall.goods&id='.$v2['id'].' target="_blank"><img src=./program/mall/img_thumb/'.$v2['icon'].' /></a>';
		}
		$list.="<div class=shop_div>
			<div class=info>
				<a href=./index.php?monxin=mall.shop_index&shop_id=".$v['id']." class=icon target=_blank><img src=./program/mall/shop_icon/".$v['id'].".png /></a><div class=other>
					<a href=./index.php?monxin=mall.shop_index&shop_id=".$v['id']." target=_blank class=name>".$v['name']."  </a>
					<div class=satisfaction value=".$satisfaction.">".$shop_credits_rate.",".self::$language['average'].":".$v['average'].self::$language['yuan_2']."</div>
					<div class=sum><span class=m_label>".self::$language['goods']." : </span><b>".$v['goods']."</b> ".self::$language['a_jian']."</div>
					<div class=area><a href=# target=_blank class=navigate destination='".$destination."'><span class=m_label>".self::$language['address']." : </span><span class=address>".$v['address']."</span> ".$distance."</a></div>
					<div class=main_business><span class=m_label>".self::$language['the_main']." : </span>".$v['main_business']."</div>
				</div>
			</div><div class=goods>
			".$goods."
			</div>
		</div>";	
	}

}
if($sql_a_create){set_sql_cache(self::$config,$sql_a,$sql_cache_a);}

if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

//$module['area']='<span class="m_label">'.self::$language['location'].'：</span><span class="option"><select id=area_province name=area_province><option value="">'.self::$language['all'].'</option>'.$province.'</select>'.@$city.@$county.@$twon.@$village.@$group.' </span>';


$module['circle_list']='';
$module['circle_list_sub']='';
$sql="select `id`,`name` from ".$pdo->index_pre."circle where `parent_id`=0 and `visible`=1 order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$module['circle_list']='<a href="#" circle=0>'.self::$language['unlimited'].'</a>';
foreach($r as $v){
	$sub='';
	$sql="select `id`,`name` from ".$pdo->index_pre."circle where `parent_id`='".$v['id']."' and `visible`=1 order by `sequence` desc,`id` asc";
	$r2=$pdo->query($sql,2);
	foreach($r2 as $v2){
		$sub.='<a href="#" circle='.$v2['id'].'>'.de_safe_str($v2['name']).'</a>';	
	}
	if($sub!=''){$sub='<div upid='.$v['id'].' >'.$sub.'</div>';}
	$module['circle_list_sub'].=$sub;
	$module['circle_list'].='<a href="#"  circle='.$v['id'].'>'.de_safe_str($v['name']).'</a>';
}

$module['tag']='<a href="#" tag=0>'.self::$language['all_shops'].'</a>';
$module['tag_icon']='<a href="./index.php?monxin=mall.shop_list" tag=0><img src=./program/mall/tag_icon/0.png><span>'.self::$language['all_shops'].'</span></a>';
$sql="select `name`,`id` from ".self::$table_pre."store_tag order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
foreach($r as $v){
	$v['name']=de_safe_str($v['name']);
	$module['tag'].='<a href=# tag='.$v['id'].'>'.$v['name'].'</a>';
	$module['tag_icon'].='<a href="./index.php?monxin=mall.shop_list&tag='.$v['id'].'" tag='.$v['id'].'><img src=./program/mall/tag_icon/'.$v['id'].'.png><span>'.$v['name'].'</span></a>';
}

$module['near_option']='';
foreach(self::$language['near_option'] as $k=>$v){
	$module['near_option'].='<a href="#" near="'.$k.'">'.$v.'</a>';	
}
$module['near_default']=self::$config['near_default'];

$module['gps_x']=self::$config['web']['gps_x'];
$module['gps_y']=self::$config['web']['gps_y'];

$module['map_api']=self::$config['web']['map_api'];

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
echo '<div style="display:none;" id="visitor_position_append">'.self::$language['pages']['mall.shop_list']['name'].'</div>';

