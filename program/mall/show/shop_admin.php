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


	function get_checkout_payment($arr){
		$list='';
		foreach($arr as $k=>$v){
			if($k=='cash_on_delivery' || $k=='online_payment' ){continue;}
			$list.='<span><input type=checkbox value="'.$k.'" />'.$v.'</span>';
		}
		return $list;
	}
$payment=get_checkout_payment(self::$language['pay_method']);

$sql="select * from ".self::$table_pre."shop";

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

if(isset($_GET['state'])){
	if($_GET['state']!=''){$where.=" and `state` ='".intval($_GET['state'])."'";}	
}


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
	if($v['agent_pay']==0){
		$agent_pay="<a href=# class=pay_agent>".self::$language['pay2'].self::$language['finance_type_agent'][0]."</a>";
	}else{
		$agent_pay=self::$language['have_pay_2'];
	}
	
	$sql="select `id` from ".self::$table_pre."shop_order_set where `shop_id`=".$v['id']." limit 0,1";
	$r2=$pdo->query($sql,2)->fetch(2);
	if($r2['id']==''){
				$sql="insert into ".self::$table_pre."shop_order_set (`shop_id`,`decrease_quantity`,`order_notice_when`,`order_notice_email`,`send_notice_email`,`send_notice_sms`,`checkout_order_notice_email`,`checkout_order_notice_sms`,`phone_goods_list_show_buy_button`,`cash_on_delivery`,`credit`,`pay_ad_fees`,`pay_ad_fees_open_time`) values('".$v['id']."','6','1','".$v['email']."','1','1','1','1','1','1','0','0','0')";
				$pdo->exec($sql);

	}
	
	$sql="select `id` from ".self::$table_pre."diypage where `shop_id`=".$v['id']." and `title`='关于我们' limit 0,1";
	$t=$pdo->query($sql,2)->fetch(2);
	if($t['id']==''){
		$sql="insert into ".self::$table_pre."diypage (`title`,`content`,`phone_content`,`shop_id`,`time`,`creater`) values ('关于我们','关于我们...','','".$v['id']."','".time()."','monxin')";
		$pdo->exec($sql);
		$insret_id=$pdo->lastInsertId();
		$sql="insert into ".self::$table_pre."navigation (`name`,`url`,`sequence`,`parent_id`,`open_target`,`visible`,`shop_id`) values ('关于我们','./index.php?monxin=mall.diypage_show&shop_id=".$v['id']."&id=".$insret_id."','1','0','_self','1',".$v['id'].")";
		if($pdo->exec($sql)){
		}		
		
	}
	
	
	$list.="<div id='tr_".$v['id']."'><div class=s_left>
			<a class=icon_logo href=./index.php?monxin=mall.shop_index&shop_id=".$v['id']." target=_blank><img src=./program/mall/shop_icon/".$v['id'].".png /></a><div class=icon_right>
			<a href=./index.php?monxin=mall.shop_index&shop_id=".$v['id']." target=_blank class=name>".$v['name']."</a>
			<div class=username>".self::$language['shop_master'].": <a href=./index.php?monxin=index.admin_users&search=".urlencode($v['username'])."#index_admin_users_table target=_blank>".$v['username']."</a></div>
			<div class=reg_time>".self::$language['reg_time'].": ".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['reg_time'])."</div>
			<div>".self::$language['annual_time_limit'].": ".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['annual_fees'])."</div>
	
		</div>
	</div><div class=s_right>
			
			<div class=main_business>".self::$language['main_business'].": ".$v['main_business']."</div>
			<div class=agent>".self::$language['agent'].": ".$v['agent']."(".$agent_pay.")<span class=pay_state></span></div>
			<span class=tag>".self::$language['tag'].": ".self::get_store_tags_name($pdo,$v['tag'])." <a href=./index.php?monxin=mall.shop_tag_set&c_id=".$v['id']."&id=".$v['tag']." class=set>&nbsp;</a></span>
			
			<div class=area>".self::$language['area_s'].": <span class=load_js_span  src='area_js.php?callback=set_area&input_id=current_area&id=".$v['area']."&output=text2' id='area_".$v['id']."'></span></div>
			<div class=address>".self::$language['position_s'].": ".$v['address']."</div>
			
			
			
			<div class=all_user_div>".self::$language['checkout_all_user'].": <input type=checkbox class=all_user value=".$v['all_user']." /></div>
			<div class=web_c_password_div>".self::$language['web_c_password'].": <input type=checkbox class=web_c_password value=".$v['web_c_password']." /></div>
		<div class=item>
			<span>".self::$language['goods'].":".$v['goods']."</span>
			<span>".self::$language['order'].":<a href='./index.php?monxin=mall.m_order_admin&seller=".urlencode($v['username'])."&state=6&#mall_m_order_admin_table' target=_blank >".$v['order']."</a></span>
			<span>".self::$language['sum_turnover'].":".$v['money']."</span>
			<span>".self::$language['evaluation'][2].":".$v['evaluation_2']."</span>
			<span>".self::$language['evaluation'][1].":".$v['evaluation_1']."</span>
			<span>".self::$language['evaluation'][0].":".$v['evaluation_0']."</span>
		
		</div>  
		  <div class=payment id=py_".$v['id']." values='".$v['payment']."'>
		  ".self::$language['checkout_payment']."<br />".$payment."
		  </div>
		<div class=input_act>
		
		
		<span>".self::$language['sequence'].":<input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."'  class='sequence' /></span>
		<span>".self::$language['state'].":<select class=data_state id='data_state_".$v['id']."'  monxin_value=".$v['state']."><option value=0>".self::$language['shop_state'][0]."</option><option value=1>".self::$language['shop_state'][1]."</option><option value=2>".self::$language['shop_state'][2]."</option><option value=3>".self::$language['shop_state'][3]."</option><option value=4>".self::$language['shop_state'][4]."</option><option value=5>".self::$language['shop_state'][5]."</option></select><input type=text class=cause placeholder=".self::$language['cause'].": /></span>
		<span>".self::$language['trusteeship'].":<select class=trusteeship id='trusteeship_".$v['id']."'  monxin_value=".$v['trusteeship']."><option value=0>".self::$language['no']."</option><option value=1>".self::$language['yes']."</option></select></span>
		
		<span>".str_replace("{v}"," <input type=text class=credits_rate id=credits_rate_".$v['id']." name=credits_rate_".$v['id']." value=".$v['credits_rate']." /> ",self::$language['shop_credits_rate'])."</span>	
		
		<div class=c_txt><span>".self::$language['pay_money']."<input type=text class=pay_money id=pay_money_".$v['id']." name=pay_money_".$v['id']." value=".$v['pay_money']." />".self::$language['yuan_2']."</span>	
		<span>".self::$language['return_credits']."<input type=text class=return_credits id=return_credits_".$v['id']." name=return_credits_".$v['id']." value=".$v['return_credits']." />".self::$language['credits']."</span></div>	
		
		<span>".self::$language['average'].": <input type=text value=".$v['average']."  class=average id=average_".$v['id']." name=average_".$v['id']."  />".self::$language['yuan_2']."</span>
		<br /><span>".self::$language['rate_3'].": <input type=text value=".$v['rate']." class=rate id=rate_".$v['id']." name=rate_".$v['id']."  />%</span>
		<span>".self::$language['annual_shop_tag_rate'].": <input type=text value=".$v['annual_rate']."  class=annual_rate id=annual_rate_".$v['id']." name=annual_rate_".$v['id']."  />%</span>
		
		<div class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a><a href='./index.php?monxin=mall.shop_edit&id=".$v['id']."' class='edit'>".self::$language['view'].' '.self::$language['edit']."</a><a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span>
		</div>	
		</div>	
			
		
			
	</div></div>";
	

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


$module['sequence']='';
$module['sequence'].='<option value="reg_time|desc">'.self::$language['time'].'↑</option>';	
$module['sequence'].='<option value="reg_time|asc">'.self::$language['time'].'↓</option>';	
$module['sequence'].='<option value="goods|desc">'.self::$language['goods'].self::$language['quantity'].'↑</option>';	
$module['sequence'].='<option value="goods|asc">'.self::$language['goods'].self::$language['quantity'].'↓</option>';	
$module['sequence'].='<option value="order|desc">'.self::$language['order'].self::$language['quantity'].'↑</option>';	
$module['sequence'].='<option value="order|asc">'.self::$language['order'].self::$language['quantity'].'↓</option>';	
$module['sequence'].='<option value="money|desc">'.self::$language['sum_turnover'].'↑</option>';	
$module['sequence'].='<option value="money|asc">'.self::$language['sum_turnover'].'↓</option>';	
$module['sequence'].='<option value="evaluation_0|desc">'.self::$language['evaluation'][0].'↑</option>';	
$module['sequence'].='<option value="evaluation_0|asc">'.self::$language['evaluation'][0].'↓</option>';	
$module['sequence'].='<option value="evaluation_1|desc">'.self::$language['evaluation'][1].'↑</option>';	
$module['sequence'].='<option value="evaluation_1|asc">'.self::$language['evaluation'][1].'↓</option>';	
$module['sequence'].='<option value="evaluation_2|desc">'.self::$language['evaluation'][2].'↑</option>';	
$module['sequence'].='<option value="evaluation_2|asc">'.self::$language['evaluation'][2].'↓</option>';	


$module['sequence'].='<option value="sequence|desc">'.self::$language['sequence'].self::$language['values'].'↑</option>';	
$module['sequence'].='<option value="sequence|asc">'.self::$language['sequence'].self::$language['values'].'↓</option>';	
$module['sequence'].='<option value="state|desc">'.self::$language['state'].'↑</option>';	
$module['sequence'].='<option value="state|asc">'.self::$language['state'].'↓</option>';	
$module['sequence'].='<option value="trusteeship|desc">'.self::$language['trusteeship'].'↑</option>';	
$module['sequence'].='<option value="trusteeship|asc">'.self::$language['trusteeship'].'↓</option>';	




$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
