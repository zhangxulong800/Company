<?php
$_GET['type']=intval(@$_GET['type']);
$manager='';
if($_GET['type']!=0){
	$sql="select `manager`,`read_power` from ".self::$table_pre."type where `id`=".$_GET['type'];
	$r2=$pdo->query($sql,2)->fetch(2);
	$manager=$r2['manager'];
	if($r2['read_power']==''){echo '<div align="center" style=" line-height:100px;"><span class=fail>'.self::$language['no_power_read'].'</span></div>';return false;}
	$read_power=explode('|',$r2['read_power']);
	if(!in_array(0,$read_power)){
		if(!in_array(@$_SESSION['monxin']['group_id'],$read_power)){echo self::$language['no_power_read'];return false;}
	}
}else{
	echo self::$language['need_params'].':type';return false;	
}
$attribute=format_attribute($args[1]);
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=$attribute['quantity'];
$sql="select ".$attribute['field'].",`id`,`title`,`sequence`,`visible` from ".self::$table_pre."title where `visible`=1";
if($manager==@$_SESSION['monxin']['username']){
	$sql="select ".$attribute['field'].",`id`,`title`,`sequence`,`visible` from ".self::$table_pre."title";
}



$where="";
$_GET['type']=intval(@$_GET['type']);
if($_GET['type']>0){
	//$type_ids=$this->get_type_ids($pdo,$_GET['type']);
	//$where.=" and `type` in (".$type_ids.")";
	$where.=" and `type`=".$_GET['type'];
	
}
$module['type']=$_GET['type'];
if(self::$config['liveupdate']){$module['liveupdate']=1;}else{$module['liveupdate']=0;}

if($_GET['search']!=''){$where=" and (`title` like '%".$_GET['search']."%')";}
$_GET['order']=safe_str(@$_GET['order']);
$order=" order by `sequence` desc,`".$attribute['sequence_field']."` ".$attribute['sequence_type']."";
if($_GET['order']!=''){
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" ".$attribute['field'].",`id`,`title`,`sequence`,`visible` "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_title and","_title where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_title and","_title where",$sql);
//echo $sql;
//exit();
$r=$pdo->query($sql,2);
$list='';
$field_array=get_field_array($attribute['field']);
$module['head_td']='<td class=thead_title><span>'.self::$language['title'].'</span></td>';
$f_td='';
$e_td='';
$module['batch_operation']='';
	if($manager==@$_SESSION['monxin']['username']){
		$f_td="<td>&nbsp;</td>";
		$e_td="
		<td ><a href=# title='".self::$language['order']."' desc='sequence|desc' asc='sequence|asc'>".self::$language['sequence']."</a></td>
		<td ><a href=# title='".self::$language['order']."' desc='visible|desc' asc='visible|asc'>".self::$language['visible']."</a></td>
		<td  style='width:270px;text-align:left;'><span class=operation_icon>&nbsp;</span>".self::$language['operation']."</td>";
		$module['batch_operation']='<div class=monxin_table_batch_operation_div>
    			<span class="corner">&nbsp;</span>
                <a href="#" class="select_all" onclick="return select_all();">'.self::$language['select_all'].'</a>
                <a href="#" class="reverse_select" onclick="return reverse_select();">'.self::$language['reverse_select'].'</a>
                 '.self::$language['selected'].':
                 <a href="#" class="submit" onclick="return subimt_select();">'.self::$language['submit'].'</a> 
                 <a href="#" class="del" onclick="return del_select();">'.self::$language['del'].'</a> 
                 <a href="#"  onclick="return show_select(1);" class=m_show>'.self::$language['show'].'</a> <a href="#" onclick="return show_select(0);" class=m_hide>'.self::$language['hide'].'</a>
                  
				 &nbsp;  &nbsp; <span class=edit_type>'.self::$language['move_to'].':<select id="type" name="type">'.self::get_parent($pdo,-1,3).'</select>  <a href="#"  onclick="return move_to();" class=submit>'.self::$language['execute'].'</a></span> <span id="state_select"></span>
     </div>
';	
	}	
	if(in_array('username',$field_array)){$module['head_td'].='<td>'.self::$language['author'].'</td>';}
	if(in_array('time',$field_array)){$module['head_td'].='<td><a href=# title="'.self::$language['order'].'" desc="time|desc" asc="time|asc">'.self::$language['title_time'].'</a></td>';}
	if(in_array('contents',$field_array)){$module['head_td'].='<td><a href=# title="'.self::$language['order'].'" desc="contents|desc" asc="contents|asc">'.self::$language['content_sum'].'</a></td>';}
	if(in_array('visit',$field_array)){$module['head_td'].='<td><a href=# title="'.self::$language['order'].'" desc="visit|desc" asc="visit|asc">'.self::$language['visit'].'</a></td>';}

$module['head_td']=$f_td.$module['head_td'].$e_td;


foreach($r as $v){
	$f_td='';
	$e_td='';
	$v=de_safe_str($v);
	if($manager==@$_SESSION['monxin']['username']){
		$f_td="<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>";
		$e_td="
  <td><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."' class='sequence' /></td>
  <td><input type='checkbox' name='visible_".$v['id']."' id='visible_".$v['id']."' value=".$v['visible']."  class='visible' /></td>
		<td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>";	
	}
	
	
	
	$title='<td><a href="./index.php?monxin=talk.content&id='.$v['id'].'" target="'.$attribute['target'].'" class=title>'.$v['title'].'</a></td>';
	$username='';
	$contents='';
	$visit='';
	$time='';
	if(in_array('username',$field_array)){$username='<td><span class=username>'.$v['username'].'</span></td>';}
	if(in_array('contents',$field_array)){$contents='<td><span class=contents>'.$v['contents'].'</span></td>';}
	if(in_array('visit',$field_array)){$visit='<td><span class=visit>'.$v['visit'].'</span></td>';}
	if(in_array('time',$field_array)){$time='<td><span class=time>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time']).'</span></td>';}
	
	$list.="<tr id='tr_".$v['id']."'>".$f_td.$title.$username.$time.$contents.$visit.$e_td."</tr>";
		
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&type='.$_GET['type'];
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);


$module['module_save_name']=str_replace("::","_",$method.$args[1]);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
echo '<div id="visitor_position_reset" style="display:none;"><span id=current_position_text>'.self::$language['current_position'].'</span><a href="./index.php"><span id=visitor_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href=./index.php?monxin=talk.type>'.self::$language['program_name'].'</a>'.$this->get_type_position($pdo,$_GET['type']).'</div>';
