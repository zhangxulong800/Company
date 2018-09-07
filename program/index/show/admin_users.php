<?php
/*
$sql="SHOW FULL COLUMNS FROM ".$pdo->index_pre."user";
$r=$pdo->query($sql,2);
$thead='<thead><tr><td>参数名</td><td>类型</td><td>必填</td><td>说明</td></tr></thead>';
$tr='';
foreach($r as $v){
	$tr.='<tr><td>'.$v['Field'].'</td><td>'.$v['Type'].'</td><td>'.$v['Null'].'</td><td>'.$v['Comment'].'</td></tr>';
}
if($tr!=''){$tr='<body>'.$tr.'</tbody>';}
$table='<table class="table table-striped table-bordered table-hover dataTable no-footer" role="grid">'.$thead.$tr.'</table>';
echo $table;
*/
if(isset($_GET['set_introducer'])){
	//设置推荐人，前推荐人:被推荐人 手机号
	if(!is_file('introducer.txt')){return false;}
	$list=file_get_contents('introducer.txt');
	$r=explode("\r\n",$list);
	foreach($r as $v){
		$v=explode(',',$v);
		$sql="select `username` from ".$pdo->index_pre."user where `phone`='".$v[0]."' limit 0,1";
		$r2=$pdo->query($sql,2)->fetch(2);
		if($r2['username']!=''){
			$sql="update ".$pdo->index_pre."user set `introducer`='".$r2['username']."' where `phone`='".$v[1]."'";
			$pdo->exec($sql);
		}
	}	
}

if(isset($_GET['set_py'])){
	require('plugin/py/py_class.php');
	$py_class=new py_class();  
	$sql="select `username`,`id` from ".$pdo->index_pre."user where `username_py` is NULL";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		echo $v['username'];
		try { $py=$py_class->str2py($v['username']); } catch(Exception $e) { $py='';}
		$sql="update ".$pdo->index_pre."user set `username_py`='".$py."' where `id`=".$v['id'];
		$pdo->exec($sql);
	}
}


if(isset($_GET['wx_oauth'])){
	$sql="select `openid`,`id` from ".$pdo->index_pre."user where `openid`!=''";
	$r=$pdo->query($sql,2);
	$time=time();
	foreach($r as $v){
		$sql="select `id` from ".$pdo->index_pre."oauth where `user_id`='".$v['id']."' and `open_id`='wx:".$v['openid']."' limit 0,1";
		$r2=$pdo->query($sql,2)->fetch(2);
		if($r2['id']==''){
			$sql="insert into ".$pdo->index_pre."oauth (`user_id`,`open_id`,`time`) values ('".$v['id']."','wx:".$v['openid']."','".$time."')";
			$pdo->exec($sql);	
		}	
	}	
}

$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$sql="select `id`,`icon`,`nickname`,`username`,`real_name`,`email`,`gender`,`birthday`,`education`,`married`,`annual_income`,`reg_time`,`last_time`,`login_num`,`money`,`introducer`,`group`,`state`,`profession`,`blood_type`,`height`,`weight`,`phone`,`home_area`,`current_area`,`manager`,`address`,`credits`,`geolocation`,`openid` from ".$pdo->index_pre."user";

$where="";
$order="";
$limit="";

if(@$_GET['start_time']!=''){
	$start_t=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);
	$where.=" and `reg_time`>$start_t";	
}
if(@$_GET['end_time']!=''){
	$end_t=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86400;
	$where.=" and `reg_time`<$end_t";	
}


$manager_list='<option value="">'.self::$language['all'].'</option><option value="0">'.self::$language['none'].self::$language['parent'].'</option>';
if(@$_GET['group']!=''){
	$where.=" and `group`='".intval($_GET['group'])."'";
	$sql2="select `parent` from ".$pdo->index_pre."group where `id`='".intval($_GET['group'])."'";
	$r2=$pdo->query($sql2,2)->fetch(2);
	
	$sql2="select `id`,`name` from ".$pdo->index_pre."group where `id`='".$r2['parent']."'";
	$r2=$pdo->query($sql2,2)->fetch(2);
	//echo $sql2;
	if($r2){
	$manager_name=$r2['name'];
	$sql2="select `id`,`username`,`real_name` from ".$pdo->index_pre."user where `group`='".$r2['id']."'";
	if($r2['id']==$_SESSION['monxin']['group_id']){$sql2.=" and `id`='".$_SESSION['monxin']['id']."'";$manager_list='';}
	//echo $sql2;
	$r2=$pdo->query($sql2,2);
	foreach($r2 as $v){
		$manager_list.='<option value="'.$v['id'].'">'.$manager_name.':'.$v['username'].'('.$v['real_name'].')'.'</option>';		
	}
	}
}
if(@$_GET['manager']!=''){$where.=" and `manager`='".intval($_GET['manager'])."'";}
if(@$_GET['state']!=''){$where.=" and `state`='".intval($_GET['state'])."'";}

//home_area=============================================================================================================
if(intval(@$_GET['home_area_province'])!=0){
	$home_area=intval($_GET['home_area_province']);
	$home_city=get_area_option($pdo,$home_area);
	if($home_city!=''){$home_city='<select id=home_area_city name=home_area_city><option value="">'.self::$language['all'].'</option>'.$home_city.'</select>';}			
}
if(intval(@$_GET['home_area_city'])!=0){
	$home_area=intval($_GET['home_area_city']);
	$home_county=get_area_option($pdo,$home_area);
	if($home_county!=''){$home_county='<select id=home_area_county name=home_area_county><option value="">'.self::$language['all'].'</option>'.$home_county.'</select>';}
}
if(intval(@$_GET['home_area_county'])!=0){
	$home_area=intval($_GET['home_area_county']);
	$home_twon=get_area_option($pdo,$home_area);
	if($home_twon!=''){$home_twon='<select id=home_area_twon name=home_area_twon><option value="">'.self::$language['all'].'</option>'.$home_twon.'</select>';}
}
if(intval(@$_GET['home_area_twon'])!=0){
	$home_area=intval($_GET['home_area_twon']);
	$home_village=get_area_option($pdo,$home_area);
	if($home_village!=''){$home_village='<select id=home_area_village name=home_area_village><option value="">'.self::$language['all'].'</option>'.$home_village.'</select>';}
}
if(intval(@$_GET['home_area_village'])!=0){
	$home_area=intval($_GET['home_area_village']);
	$home_group=get_area_option($pdo,$home_area);
	if($home_group!=''){$home_group='<select id=home_area_group name=home_area_group><option value="">'.self::$language['all'].'</option>'.$home_group.'</select>';}
}
if(intval(@$_GET['home_area_group'])!=0){$home_area=intval($_GET['home_area_group']);}
if(isset($home_area)){
	$home_area=get_area_ids($pdo,$home_area);
	$home_area=trim($home_area,',');
	$sql.=" and `home_area` in (".$home_area.")";
	//echo $home_area;
}
//current_area=============================================================================================================
if(intval(@$_GET['current_area_province'])!=0){
	$current_area=intval($_GET['current_area_province']);
	$current_city=get_area_option($pdo,$current_area);
	if($current_city!=''){$current_city='<select id=current_area_city name=current_area_city><option value="">'.self::$language['all'].'</option>'.$current_city.'</select>';}			
}
if(intval(@$_GET['current_area_city'])!=0){
	$current_area=intval($_GET['current_area_city']);
	$current_county=get_area_option($pdo,$current_area);
	if($current_county!=''){$current_county='<select id=current_area_county name=current_area_county><option value="">'.self::$language['all'].'</option>'.$current_county.'</select>';}
}
if(intval(@$_GET['current_area_county'])!=0){
	$current_area=intval($_GET['current_area_county']);
	$current_twon=get_area_option($pdo,$current_area);
	if($current_twon!=''){$current_twon='<select id=current_area_twon name=current_area_twon><option value="">'.self::$language['all'].'</option>'.$current_twon.'</select>';}
}
if(intval(@$_GET['current_area_twon'])!=0){
	$current_area=intval($_GET['current_area_twon']);
	$current_village=get_area_option($pdo,$current_area);
	if($current_village!=''){$current_village='<select id=current_area_village name=current_area_village><option value="">'.self::$language['all'].'</option>'.$current_village.'</select>';}
}
if(intval(@$_GET['current_area_village'])!=0){
	$current_area=intval($_GET['current_area_village']);
	$current_group=get_area_option($pdo,$current_area);
	if($current_group!=''){$current_group='<select id=current_area_group name=current_area_group><option value="">'.self::$language['all'].'</option>'.$current_group.'</select>';}
}
if(intval(@$_GET['current_area_group'])!=0){$current_area=intval($_GET['current_area_group']);}
if(isset($current_area)){
	$current_area=get_area_ids($pdo,$current_area);
	$current_area=trim($current_area,',');
	$sql.=" and `current_area` in (".$current_area.")";
	//echo $current_area;
}

if(intval(@$_GET['annual_income'])!=0){$where.=" and `annual_income`='".intval(@$_GET['annual_income'])."'";}
if(intval(@$_GET['education'])!=0){$where.=" and `education`='".intval(@$_GET['education'])."'";}
if(intval(@$_GET['gender'])!=0){$where.=" and `gender`='".intval(@$_GET['gender'])."'";}
if(intval(@$_GET['married'])!=0){$where.=" and `married`='".intval(@$_GET['married'])."'";}
if(intval(@$_GET['blood_type'])!=0){$where.=" and `blood_type`='".intval(@$_GET['blood_type'])."'";}
if(intval(@$_GET['birthday_year'])!=0 && intval(@$_GET['birthday_month'])!=0 && intval(@$_GET['birthday_day'])!=0){
	$start_time=mktime(0,0,0,$_GET['birthday_month'],$_GET['birthday_day'],$_GET['birthday_year']);
	$end_time=mktime(23,59,59,$_GET['birthday_month'],$_GET['birthday_day'],$_GET['birthday_year']);
	$month_option='<select id=birthday_month name=birthday_month><option value="">'.self::$language['all'].'</option>'.get_month_option().'</select>';
	$day_option='<select id=birthday_day name=birthday_day><option value="">'.self::$language['all'].'</option>'.get_day_option($_GET['birthday_year'],$_GET['birthday_month']).'</select>';
}elseif(intval(@$_GET['birthday_year'])!=0 && intval(@$_GET['birthday_month'])!=0 && intval(@$_GET['birthday_day'])==0){
	$start_time=mktime(0,0,0,$_GET['birthday_month'],0,$_GET['birthday_year']);
	$end_time=mktime(23,59,59,$_GET['birthday_month'],get_days($_GET['birthday_year'],$_GET['birthday_month']),$_GET['birthday_year']);
	$month_option='<select id=birthday_month name=birthday_month><option value="">'.self::$language['all'].'</option>'.get_month_option().'</select>';
	$day_option='<select id=birthday_day name=birthday_day><option value="">'.self::$language['all'].'</option>'.get_day_option($_GET['birthday_year'],$_GET['birthday_month']).'</select>';
}elseif(intval(@$_GET['birthday_year'])!=0 && intval(@$_GET['birthday_month'])==0){
	$start_time=mktime(0,0,0,1,0,$_GET['birthday_year']);
	$end_time=mktime(23,59,59,12,31,$_GET['birthday_year']);
	$month_option='<select id=birthday_month name=birthday_month><option value="">'.self::$language['all'].'</option>'.get_month_option().'</select>';
}


if(isset($start_time) && isset($end_time)){
	$start_time--;
	$end_time++;
	$where.=" and `birthday`>$start_time and `birthday`<$end_time";
	}




if($_GET['search']!=''){$where=" and (`username` like '%".$_GET['search']."%' or `nickname` like '%".$_GET['search']."%' or `email` like '%".$_GET['search']."%' or `tel` like '%".$_GET['search']."%' or `phone` like '%".$_GET['search']."%' or `address` like '%".$_GET['search']."%' or `real_name` like '%".$_GET['search']."%' or `chat` like '%".$_GET['search']."%' or `license_id` like '%".$_GET['search']."%' or `height` like '%".$_GET['search']."%' or `weight` like '%".$_GET['search']."%' or `domain` like '%".$_GET['search']."%' or `homepage` like '%".$_GET['search']."%' or `chip` like '%".$_GET['search']."%' or `profession` like '%".$_GET['search']."%')";
//echo $where;
}

$sql2="select count(id) as c from ".$pdo->index_pre."user where `group`='".$_SESSION['monxin']['group_id']."'";
$r2=$pdo->query($sql2,2)->fetch(2);
if($r2['c']==1 || $_SESSION['monxin']['group_id']==1){
	$groups=index::get_group_sub_ids($pdo,$_SESSION['monxin']['group_id']);	
	$groups=trim($groups,",");
	if($groups==''){$groups=0;}
	$where.=" and `group` in ($groups)";
	//echo $groups;
}else{
	$ids=index::get_user_sub_ids($pdo,$_SESSION['monxin']['id']);	
	$ids=trim($ids,",");
	if($ids==''){$ids=0;}
	$where.=" and `id` in ($ids)";
	//echo $managers;
}




if(@$_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$_GET['order']=safe_str($_GET['order']);
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" `id`,`icon`,`nickname`,`username`,`real_name`,`email`,`gender`,`birthday`,`education`,`married`,`annual_income`,`reg_time`,`last_time`,`login_num`,`money`,`introducer`,`group`,`state`,`profession`,`blood_type`,`height`,`weight`,`phone`,`home_area`,`current_area`,`manager`,`address`,`credits`,`geolocation`,`openid` "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_user and","_user where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
	
	$_SESSION['bulk_action']['sql']=$sum_sql.$order;
	$_SESSION['bulk_action']['url']='http://'.$_SERVER['HTTP_HOST'].GetCurUrl();
	//echo $_SESSION['admin_users']['url'];
	
	
	
			
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_user and","_user where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
$phone_list='';
foreach($r as $v){
	if($v['geolocation']!=''){
		$temp=explode(',',$v['geolocation']);
		$v['geolocation']='<a class="fa fa-map-marker" href="http://'.self::$config['web']['map_api'].'.monxin.com/get_point.php?id=position&point='.$temp[1].','.$temp[0].'" target="_blank"></a>';	
	}
	if($v['openid']!=''){	
		$v['openid']='<a href="./index.php?monxin=weixin.dialog&wid='.self::$config['web']['wid'].'&openid='.$v['openid'].'" target=_blank class=openid></a>';
	}
	if(!is_url($v['icon'])){$v['icon']="./program/index/user_icon/".$v['icon'];}
	if($_COOKIE['monxin_device']=='pc'){
		$list.="<tr id='tr_".$v['id']."'>
		<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
		<td><a class=icon href='".$v['icon']."'><img wsrc='".$v['icon']."' /></a></td>
		<td><a talk='".$v['username']."'>".$v['username'].'</a>'.$v['geolocation'].$v['openid']."<br />".$v['real_name']."<br />".$v['email']."<br />".$v['phone']."</td>
		
		<td><a href='index.php?monxin=index.edit_user_group&id=".$v['id']."' target=_blank>".self::get_group_name($pdo,$v['group'])."</a></td>
		<td><a href=./index.php?monxin=index.credits_admin&search=".urlencode($v['username'])." target=_blank>".$v['credits']."</a><br /><a href=./index.php?monxin=index.user_recharge_credits&id=".$v['id']." target=_blank>".self::$language['recharge']."</a><br /><a href=./index.php?monxin=index.user_debit_credits&id=".$v['id']." target=_blank>".self::$language['debit']."</a></td>
		<td><a href=./index.php?monxin=index.money_log_admin&username=".urlencode($v['username'])." target=_blank>".$v['money']."</a><br />
			<a href=./index.php?monxin=index.user_recharge&id=".$v['id']." target=_blank>".self::$language['recharge']."</a><br />
			<a href=./index.php?monxin=index.user_debit&id=".$v['id']." target=_blank>".self::$language['debit']."</a>
		</td>
		<td>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['reg_time'])." <a href=./index.php?monxin=index.login_log&id=".$v['id']." target=_blank class=login_num>".$v['login_num']."</a></td>
		<td><select id='user_state_".$v['id']."' name='user_state_".$v['id']."'>".get_user_state(self::$language,$v['state'])."</select></td>
		<td class=operation_td>	<a href='#' class=submit onclick='return update(".$v['id'].")'>".self::$language['submit']."</a> 
	<a href='index.php?monxin=index.admin_edit_user&id=".$v['id']."' class=edit target='_blank'>".self::$language['edit']."</a> 
	<a href='#' onclick='return del(".$v['id'].")' class=del>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
	</td>
	</tr>
";	
	}else{
		$list.="<tr id='tr_".$v['id']."'>
		<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
		<td><a class=icon href='./program/index/user_icon/".$v['icon']."'><img wsrc='./program/index/user_icon/".$v['icon']."' /></a></td>
		<td class=u_info>
		<div><span class=u_label>".self::$language['username'].":</span><span class=u_value><a talk='".$v['username']."'>".$v['username'].'</a> '.$v['geolocation'].$v['openid']."</span></div>
		<div><span class=u_label>".self::$language['real_name'].":</span><span class=u_value>".$v['real_name']."</span></div>
		<div><span class=u_label>".self::$language['user_group'].":</span><span class=u_value><a href='index.php?monxin=index.edit_user_group&id=".$v['id']."' target=_blank>".self::get_group_name($pdo,$v['group'])."</a></span></div>
		<div><span class=u_label>".self::$language['phone'].":</span><span class=u_value>".$v['phone']."</span></div>
		<div><span class=u_label>".self::$language['email'].":</span><span class=u_value>".$v['email']."</span></div>
		</td>
		<td><a href=./index.php?monxin=index.credits_admin&search=".urlencode($v['username'])." target=_blank>".$v['credits']."</a><br /><a href=./index.php?monxin=index.user_recharge_credits&id=".$v['id']." target=_blank>".self::$language['recharge']."</a><br /><a href=./index.php?monxin=index.user_debit_credits&id=".$v['id']." target=_blank>".self::$language['debit']."</a></td>
		
		<td><a href=./index.php?monxin=index.money_log_admin&username=".urlencode($v['username'])." target=_blank>".$v['money']."</a><br /><a href=./index.php?monxin=index.user_recharge&id=".$v['id']." target=_blank>".self::$language['recharge']."</a><br /><a href=./index.php?monxin=index.user_debit&id=".$v['id']." target=_blank>".self::$language['debit']."</a></td>
		<td>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['reg_time'])." <a href=./index.php?monxin=index.login_log&id=".$v['id']." target=_blank class=login_num>".$v['login_num']."</a></td>
		<td><select id='user_state_".$v['id']."' name='user_state_".$v['id']."'>".get_user_state(self::$language,$v['state'])."</select></td>
		<td class=operation_td>	<a href='#' class=submit onclick='return update(".$v['id'].")'>".self::$language['submit']."</a> 
	<a href='index.php?monxin=index.admin_edit_user&id=".$v['id']."' class=edit target='_blank'>".self::$language['edit']."</a> 
	<a href='#' onclick='return del(".$v['id'].")' class=del>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
	</td>
	</tr>
";	
	}
}
if($sum==0){$phone_list=$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}
$module['sequence']='';
$module['sequence'].='<option value="cumulative_credits|desc">'.self::$language['contribution'].'↑</option>';	
$module['sequence'].='<option value="cumulative_credits|asc">'.self::$language['contribution'].'↓</option>';	
$module['sequence'].='<option value="id|desc">'.self::$language['reg_user'].self::$language['time'].'↑</option>';	
$module['sequence'].='<option value="id|asc">'.self::$language['reg_user'].self::$language['time'].'↓</option>';	
$module['sequence'].='<option value="last_time|desc">'.self::$language['login'].self::$language['time'].'↑</option>';	
$module['sequence'].='<option value="last_time|asc">'.self::$language['login'].self::$language['time'].'↓</option>';	
$module['sequence'].='<option value="login_num|desc">'.self::$language['login_num'].'↑</option>';	
$module['sequence'].='<option value="login_num|asc">'.self::$language['login_num'].'↓</option>';	
$module['sequence'].='<option value="money|desc">'.self::$language['user_money'].'↑</option>';	
$module['sequence'].='<option value="money|asc">'.self::$language['user_money'].'↓</option>';	
$module['sequence'].='<option value="birthday|desc">'.self::$language['age'].'↑</option>';	
$module['sequence'].='<option value="birthday|asc">'.self::$language['age'].'↓</option>';	
$module['sequence'].='<option value="education|desc">'.self::$language['education'].'↑</option>';	
$module['sequence'].='<option value="education|asc">'.self::$language['education'].'↓</option>';	
$module['sequence'].='<option value="annual_income|desc">'.self::$language['annual_income'].'↑</option>';	
$module['sequence'].='<option value="annual_income|asc">'.self::$language['annual_income'].'↓</option>';	
$module['sequence'].='<option value="weight|desc">'.self::$language['weight'].'↑</option>';	
$module['sequence'].='<option value="weight|asc">'.self::$language['weight'].'↓</option>';	
$module['sequence'].='<option value="height|desc">'.self::$language['height'].'↑</option>';	
$module['sequence'].='<option value="height|asc">'.self::$language['height'].'↓</option>';	
$module['list']=$list;
$module['phone_list']=$phone_list;
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['filter']='';
$module['filter'].='<span class="m_label">'.self::$language['state'].'</span><span class="option"><select id=state name=state><option value="">'.self::$language['all'].'</option>'.get_user_state(self::$language,-1).'</select></span>';
$module['filter'].='<br/><span class="m_label">'.self::$language['user_group'].'</span><span class="option"><select id=group name=group><option value="">'.self::$language['all'].'</option>'.index::get_group_select($pdo,'-1',$_SESSION['monxin']['group_id']).'</select> &nbsp; &nbsp; &nbsp; '.self::$language['parent'].'<select id=manager name=manager>'.$manager_list.'</select> </span>';
$province=get_area_option($pdo,0);
$module['filter'].='<br/><span class="m_label">'.self::$language['home_area'].'</span><span class="option"><select id=home_area_province name=home_area_province><option value="">'.self::$language['all'].'</option>'.$province.'</select>'.@$home_city.@$home_county.@$home_twon.@$home_village.@$home_group.' </span>';
$module['filter'].='<br/><span class="m_label">'.self::$language['current_area'].'</span><span class="option"><select id=current_area_province name=current_area_province><option value="">'.self::$language['all'].'</option>'.$province.'</select>'.@$current_city.@$current_county.@$current_twon.@$current_village.@$current_group.' </span>';

$module['filter'].='<br/><span class="m_label">'.self::$language['annual_income'].'</span><span class="option"><select id=annual_income name=annual_income><option value="">'.self::$language['all'].'</option>'.get_select_id($pdo,'annual_income',0).'</select></span>';
$module['filter'].='<br/><span class="m_label">'.self::$language['education'].'</span><span class="option"><select id=education name=education><option value="">'.self::$language['all'].'</option>'.get_select_id($pdo,'education',0).'</select></span>';
$module['filter'].='<br/><span class="m_label">'.self::$language['gender'].'</span><span class="option"><select id=gender name=gender><option value="">'.self::$language['all'].'</option>'.get_select_id($pdo,'gender',0).'</select></span>';
$module['filter'].='<br/><span class="m_label">'.self::$language['married'].'</span><span class="option"><select id=married name=married><option value="">'.self::$language['all'].'</option>'.get_select_id($pdo,'married',0).'</select></span>';
$module['filter'].='<br/><span class="m_label">'.self::$language['blood_type'].'</span><span class="option"><select id=blood_type name=blood_type><option value="">'.self::$language['all'].'</option>'.get_select_id($pdo,'blood_type',0).'</select></span>';

$module['filter'].='<br/><span class="m_label">'.self::$language['birthday'].'</span><span class="option"><select id=birthday_year name=birthday_year><option value="">'.self::$language['all'].'</option>'.get_year_option(self::$config['other']['optional_year_range']).'</select>'.@$month_option.@$day_option.'</span>';


$module['placeholder']=self::$language['can'].self::$language['search'].':'.self::$language['username'].' '.self::$language['nickname'].' '.self::$language['real_name'].' '.self::$language['phone'].' '.self::$language['email'].' '.self::$language['tel'].' '.self::$language['profession'].' '.self::$language['height'].' '.self::$language['weight'].' '.self::$language['address'].'';
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);
$module['selected_action']='';
$module['bulk_action']='';
if($sum>0){
	$module['bulk_action']=self::$language['bulk_action'].$sum.self::$language['a'].self::$language['user'].':<a href="'.$module['action_url'].'&act=import_im_all" target="_blank" class=import_im_all>'.self::$language['import_im'].'</a> <a href="'.$module['action_url'].'&act=export_csv" target="_blank" class=export>'.self::$language['export'].'csv</a>  <a href="'.$module['action_url'].'&act=site_msg" target="_blank" class=site_msg>'.self::$language['send'].self::$language['site_msg'].'</a> <a href="'.$module['action_url'].'&act=email_msg" target="_blank" class=email_msg>'.self::$language['send'].self::$language['email_msg'].'</a>';
	
	$module['selected_action']='<li><a href="'.$module['action_url'].'&act=send_wxmoney" target="_blank" class=send_wxmoney>'.self::$language['pages']['index.send_wxmoney']['name'].'</a></li> <li><a href="'.$module['action_url'].'&act=export_csv_selected" target="_blank" class=export>'.self::$language['export'].'csv</a></li> <li><a href="'.$module['action_url'].'&act=site_msg_selected" target="_blank" class=site_msg>'.self::$language['send'].self::$language['site_msg'].'</a></li> <li><a href="'.$module['action_url'].'&act=email_msg_selected" target="_blank" class=email_msg>'.self::$language['send'].self::$language['email_msg'].'</a></li><li><a href="'.$module['action_url'].'&act=import_im" target="_blank" class=import_im>'.self::$language['import_im'].'</a></li>';
	
	if(intval(@$_GET['group'])>0){
		$module['bulk_action'].=' <a href="'.$module['action_url'].'&act=change_group" target="_blank" class=change_group>'.self::$language['change'].self::$language['user_group'].'</a> <a href="'.$module['action_url'].'&act=change_manager&group='.$_GET['group'].'" target="_blank" class=change_manager>'.self::$language['change'].self::$language['parent'].'</a>';
		$module['selected_action'].=' <span class=selected_action><a href="'.$module['action_url'].'&act=change_group_selected" target="_blank" class=change_group_selected>'.self::$language['change'].self::$language['user_group'].'</a> <a href="'.$module['action_url'].'&act=change_manager_selected&group='.$_GET['group'].'" target="_blank" class=change_manager_selected>'.self::$language['change'].self::$language['parent'].'</a></span>';
	}
	$module['bulk_action'].=' &nbsp; &nbsp;'.self::$language['state'].self::$language['change_to'].'<select id=bulk_action_state name=bulk_action_state>'.get_user_state(self::$language,-1).'</select><a href="'.$module['action_url'].'&act=bulk_action_state" id=bulk_action_state_a class=set>'.self::$language['set'].'</a><span id="bulk_action_state_state"></span>';
	
	$list='';
	foreach(self::$language['user_state'] as $key=>$v){
		$list.='<li><a href="'.$module['action_url'].'&act=bulk_action_state_selected&state='.$key.'" class=set_selected_state value='.$key.' >'.self::$language['state'].self::$language['set_to']." : ".$v.'</a></li>';	
	}

	
	$module['selected_action'].=$list;
	
}

require "./plugin/html5Upfile/createHtml5.class.php";
$html5Upfile=new createHtml5();
$html5Upfile->echo_input(self::$language,"import_file",'100%','','./temp/','true','false','csv|txt',1024*10,'0');
//echo_input(语言数组,"house_model",'控件宽度(百分比或像素)','multiple','保存到文件夹','文件夹是否附加日期','是否原名保存','允许文件类型','文件最大值','文件最小值');

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

