<?php
/*$sql="select * from ".self::$table_pre."title";
$r=$pdo->query($sql,2);
foreach($r as $v){
	$sql="update ".self::$table_pre."title set `key`='".$v['key'].",' where `id`=".$v['id'];
	$pdo->exec($sql);	
}
*/
$id=intval(@$_GET['id']);
if($id==0){
	$key=safe_str(@$_GET['key']);
	if($key==''){echo self::$language['need_params'].' id or key'; return false;}
	$sql="select `id` from ".self::$table_pre."title where `key` like '%".$key.",%' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){return  not_find();}
	$id=$r['id'];
}
$sql="select * from ".self::$table_pre."title where `id`=".$id;
$t=$pdo->query($sql,2)->fetch(2);
if($t['visible']!=1){return  not_find();}
$module['type']=$t['type'];
if(self::$config['liveupdate']){$module['liveupdate']=1;}else{$module['liveupdate']=0;}

$manager='';
$sql="select `manager`,`read_power` from ".self::$table_pre."type where `id`=".$t['type'];
$r2=$pdo->query($sql,2)->fetch(2);
$manager=$r2['manager'];
if($r2['read_power']==''){echo self::$language['no_power_read'];return false;}
$read_power=explode('|',$r2['read_power']);
if(!in_array('0',$read_power)){
	if(!in_array(@$_SESSION['monxin']['group_id'],$read_power)){echo '<div align="center" style=" line-height:100px;"><span class=fail>'.self::$language['no_power_read'].'</span></div>';return false;}
}
//$module['title']='<span class=username>'.$t['username'].'</span><span class=time>'.get_time(self::$config['other']['date_style']." H:i",self::$config['other']['timeoffset'],self::$language,$t['time']).'</span>'."<br /><span class=title_show><span class=s>&nbsp;</span><span class=b>".$t['title']."</span><span class=e>&nbsp;</span></span>";
$module['title']='<span class=username>'.$t['username'].'</span><span class=time>'.get_time(self::$config['other']['date_style']." H:i",self::$config['other']['timeoffset'],self::$language,$t['time']).'</span>'."<br /><div class=title><div class=v>".$t['title']."</div></div>";

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."content where `title_id`='".$t['id']."' and `for`=0 and `visible`=1";
if($manager==@$_SESSION['monxin']['username']){
	$sql="select * from ".self::$table_pre."content where `title_id`='".$t['id']."' and `for`=0";
}

$where="";
$order=" order by `id` asc";
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_content and","_content where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_content and","_content where",$sql);
//echo $sql;
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
	$operation='';
	if($manager==@$_SESSION['monxin']['username']){
		if($v['visible']){
			$operation="<a href='#' class='m_hide' cid=".$v['id'].">".self::$language['hide']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span>";	
		}else{
			$operation="<a href='#' class='m_show' cid=".$v['id'].">".self::$language['show']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span>";	
		}
	}
	
	$sql="select * from ".self::$table_pre."content where `title_id`='".$t['id']."' and `for`='".$v['id']."'";
	$r2=$pdo->query($sql,2);
	$for='';
	foreach($r2 as $v2){
		$operation2='';
		if($manager==@$_SESSION['monxin']['username']){
			if($v2['visible']){
				$operation2="<a href='#' class='m_hide' cid=".$v2['id'].">".self::$language['hide']."</a> <a href='#' onclick='return del(".$v2['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v2['id']." class='state'></span>";	
			}else{
				$operation2="<a href='#' class='m_show' cid=".$v2['id'].">".self::$language['show']."</a> <a href='#' onclick='return del(".$v2['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v2['id']." class='state'></span>";	
			}
		}
		
		//$for.="<div class=comment_div id=content_".$v2['id']."><div class=buttons2>".$operation2."</div><div class=comment_content><span class=s>&nbsp;</span><span class=b>".$v2['content']."</span><span class=e>&nbsp;</span></div>".'<span class=username>'.$v2['username'].'</span><span class=time>'.get_time(self::$config['other']['date_style']." H:i",self::$config['other']['timeoffset'],self::$language,$v2['time']).'</span></div>';
		$for.="<div class=comment_div id=content_".$v2['id'].">".'<span class=username>'.$v2['username'].'</span><span class=time>'.get_time(self::$config['other']['date_style']." H:i",self::$config['other']['timeoffset'],self::$language,$v2['time']).'</span><div class=comemnt><div class=v>'.$v2['content'].'</div> <div class=buttons2>'.$operation2.'</div></div></div>';
	}
	$list.='<div class=content_div id=content_'.$v['id'].'><div class=content_author><span class=username>'.$v['username'].'</span><span class=time>'.get_time(self::$config['other']['date_style']." H:i",self::$config['other']['timeoffset'],self::$language,$v['time']).'</span>'."</div><div class=content_content><div class=answer><div class=v>".$v['content']."</div></div><div class=buttons>".$operation."<a href=# class=comment_button click_id=".$v['id'].">".self::$language['comment']."</a></div></div>".$for."</div>";
	
			
}
$module['count_url']="receive.php?target=".$method."&act=count&id=".$id;
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&id='.$id;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);


$module['module_save_name']=str_replace("::","_",$method.$args[1]);
$module['class_name']=self::$config['class_name'];
$module['web_language']=self::$config['web']['language'];



$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
echo '<div id="visitor_position_reset" style="display:none;"><span id=current_position_text>'.self::$language['current_position'].'</span><a href="./index.php"><span id=visitor_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href=./index.php?monxin=talk.type>'.self::$language['program_name'].'</a>'.$this->get_type_position($pdo,$t['type']).'</div>';
