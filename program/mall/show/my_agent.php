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

$sql="select * from ".self::$table_pre."shop where `agent`='".$_SESSION['monxin']['username']."'";

//area=============================================================================================================
$province=get_area_option($pdo,0);
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



$where="";
if(intval(@$_GET['id'])!=0){
	$where=" and `id`=".intval($_GET['id']);
	echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=mall.goods_admin">'.self::$language['pages']['mall.shop_admin']['name'].'</a><span class=text>'.$_GET['id'].'</span></div>';
}
$_GET['state']=intval(@$_GET['state']);
if($_GET['state']>0){$where.=" and `state` ='".$_GET['state']."'";}


if($_GET['search']!=''){$where=" and (`username` like '%".$_GET['search']."%' or `reg_username` like '%".$_GET['search']."%' or `name` like '%".$_GET['search']."%' or `main_business` like '%".$_GET['search']."%' or `address` like '%".$_GET['search']."%' or `name_log` like '%".$_GET['search']."%' or `phone` like '%".$_GET['search']."%' or `email` like '%".$_GET['search']."%')";}
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
	$sum_sql=str_replace("_shop and","_shop where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_shop and","_shop where",$sql);
//echo($sql);
//exit();

$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
	
	$sql="select sum(actual_money) as c from ".self::$table_pre."order where `shop_id`=".$v['id']." and `cashier`='monxin' and `state`=6";
	$r2=$pdo->query($sql,2)->fetch(2);
	$money=abs($r2['c']);
	
	$sql="select sum(money) as c from ".self::$table_pre."shop_finance where `shop_id`=".$v['id']." and `type`=1";
	$r2=$pdo->query($sql,2)->fetch(2);
	$annual_sun=abs($r2['c']);
	
	$sql="select sum(money) as c from ".self::$table_pre."agent_finance where `shop_id`=".$v['id']." and `username`='".$_SESSION['monxin']['username']."'";
	$r2=$pdo->query($sql,2)->fetch(2);
	$my_earning=abs($r2['c']);
	
	$list.="<tr id='tr_".$v['id']."'>
	  <td><div class=info>
	  	<br /><div class=icon><a href=./index.php?monxin=mall.shop_index&shop_id=".$v['id']." target=_blank><img src=./program/mall/shop_icon/".$v['id'].".png /></a></div><div class=other>
			<a href=./index.php?monxin=mall.shop_index&shop_id=".$v['id']." target=_blank class=name>".$v['name']."</a>
			<div class=main_business>".$v['main_business']."</div>
			<div class=username>".self::$language['shop_master'].": <a href=./index.php?monxin=index.admin_users&search=".urlencode($v['username'])."#index_admin_users_table target=_blank>".$v['username']."</a></div>
			<div class=area>".self::$language['area_s'].": <span class=load_js_span  src='area_js.php?callback=set_area&input_id=current_area&id=".$v['area']."&output=text2' id='area_".$v['id']."'></span></div>
			<div class=address>".self::$language['position_s'].": ".$v['address']."</div>
		</div>
	  </div></td>
	  <td class=goods>".$v['goods']."</td>
	  <td class=money>".$money."</td>
	  <td class=annual_sun>".$annual_sun."</td>
	  <td class=my_earning><a href='./index.php?monxin=mall.agent_finance&shop_id=".$v['id']."' target=_blank>".$my_earning."</a></td>
	  <td class=reg_time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['reg_time'])."</td>
	  <td>".self::$language['shop_state'][$v['state']]."</td>
	</tr>
";	

}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

$list='';
foreach(self::$language['shop_state'] as $k=>$v){
	$list.='<option value='.$k.'>'.$v.'</option>';	
}

$module['filter']="<select name='state_filter' id='state_filter'><option value='-1'>".self::$language['visible_state']."</option><option value='' selected>".self::$language['all'].self::$language['state']."</option>{$list}</select>";

$module['area']='<br/><span class="m_label">'.self::$language['location'].'</span><span class="option"><select id=area_province name=area_province><option value="">'.self::$language['all'].'</option>'.$province.'</select>'.@$city.@$county.@$twon.@$village.@$group.' </span>';


$module['batch_msg']='<a href=./index.php?monxin=index.admin_users&group='.self::$config['shopkeeper_group_id'].'#state_select target=_blank class=submit>'.self::$language['batch_msg'].'</a>';

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
