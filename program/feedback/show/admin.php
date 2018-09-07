<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['state']=@$_GET['state'];
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."msg";

$where="";
if(is_numeric($_GET['state'])){
	$where=" and `state`='".$_GET['state']."'";
	if($_GET['state']==2){$where=" and `answer_user`>0";}
	if($_GET['state']==3){$where=" and `answer_user`=0";}
}
if($_GET['search']!=''){$where=" and (`sender` like '%".$_GET['search']."%' or `content` like '%".$_GET['search']."%' or `ip` like '%".$_GET['search']."%' or `answer` like '%".$_GET['search']."%' or `receive` like '%".$_GET['search']."%')";}
if(@$_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$_GET['order']=safe_str($_GET['order']);
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_msg and","_msg where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_msg and","_msg where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
	$group_id=get_username($pdo,$v['answer_user']);
	$list.="<tr id='tr_".$v['id']."'>
	<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
	<td>
	<div class=msg_div>
		<div class=sender_info><span class=sender>".$v['sender']."</span><span class=time>".get_time(self::$config['other']['date_style']." H:i",self::$config['other']['timeoffset'],self::$language,$v['time'])."</span><span class=ip>".$v['ip']."</span><span class=receive>".$v['receive']."</span></div>
		<div class=content_div><div class=v>".str_replace("\r\n",'<br />',$v['content'])."</div></div>
		<div class=answer_div  align=right><div class=answer><textarea name=answer_".$v['id']." id=answer_".$v['id']." >".$v['answer']."</textarea></div></div>
		<div class=answer_info><span class=time>".get_time(self::$config['other']['date_style']." H:i",self::$config['other']['timeoffset'],self::$language,$v['answer_time'])."</span><span class=answer_user>".get_user_group_name($pdo,$group_id).'('.get_nickname($pdo,$v['answer_user']).")</span></div>
		<div class=operation_div>
			<span>".self::$language['sequence'].":<input type=text id=sequence_".$v['id']." value=".$v['sequence']." class=sequence /></span> 
			<span>".self::$language['open_feedback'].":<input type=checkbox id=msg_state_".$v['id']." value=".$v['state']." class=msg_state /></span> 
			<a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span>
		</div>
	</div>
	</td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);