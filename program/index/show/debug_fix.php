<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".$pdo->index_pre."debug";

$where="";
$_GET['state']=@$_GET['state'];
if(is_numeric($_GET['state'])){$where=" and `state`='".$_GET['state']."'";}
if($_GET['search']!=''){$where=" and (`path` like  '%".$_GET['search']."%')";}
$order=" order by `id` desc";
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_debug and","_debug where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_debug and","_debug where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	if($v['state']==0){
		$text=($v['change'])?self::$language['force_fix']:self::$language['fix'];
		$edit="<a href='#' onclick='return set_1(".$v['id'].")'  id=set_1_".$v['id']." class='set_1'>".$text."</a>";	
	}else{
		$edit="";	
	}
	$list.="<tr id='tr_".$v['id']."'>
	<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
	<td ><span class=path>".$v['path']."</span></td>
	<td><span  class=data_state>".self::$language['debug_state'][$v['state']]."</span></td>
	<td><span class=username>&nbsp;".$v['username']."</span></td>
	<td><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</span></td>
	<td class=operation_td>".$edit."<a href='".self::$config['server_url'].'index.php?monxin=server.debug_detail&id='.$v['debug_id']."'  class='view' target=_blank>".self::$language['view']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['filter']="<select id='state' name='state'><option value='-1'>".self::$language['state']."</option><option value='' selected>".self::$language['all']."</option><option value='0'>".self::$language['debug_state'][0]."</option><option value='1'>".self::$language['debug_state'][1]."</option></select>";
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);


		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);