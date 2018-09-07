<?php
if(date("d",time())!=file_get_contents("./program/ci/update_task/day.txt")){self::exe_day_task($pdo);}


$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['visible']=@$_GET['visible'];
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select `id`,`type`,`title`,`icon`,`visit`,`reflash`,`sequence`,`state`,`username`,`tag` from ".self::$table_pre."content where `username`='".$_SESSION['monxin']['username']."' and `state`<3";

$where="";
if(intval(@$_GET['id'])!=0){
	$where=" and `id`=".intval($_GET['id']);
	echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=ci.info_admin">'.self::$language['pages']['ci.info_admin']['name'].'</a><span class=text>'.$_GET['id'].'</span></div>';
}
$_GET['type']=intval(@$_GET['type']);
if($_GET['type']>0){
	$type_ids=$this->get_type_ids($pdo,$_GET['type']);
	$where.=" and `type` in (".$type_ids.")";
}
$_GET['tag']=intval(@$_GET['tag']);
if($_GET['tag']>0){
	$where.=" and `tag` like '%|".$_GET['tag']."|%'";
}

if($_GET['search']!=''){$where=" and (`title` like '%".$_GET['search']."%' or `content` like '%".$_GET['search']."%' or `linkman` like '%".$_GET['search']."%' or `contact` like '%".$_GET['search']."%')";}
$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" `id`,`type`,`title`,`icon`,`visit`,`reflash`,`sequence`,`state`,`username`,`tag` "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_content and","_content where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_content and","_content where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';


foreach($r as $v){
	$v=de_safe_str($v);
		$act='';
	if($v['state']==0){
		$act="";
	}
	if($v['state']==1){
		$act="<a href='index.php?monxin=ci.reflash&id=".$v['id']."' class=set>".self::$language['refresh']."</a> <a href='index.php?monxin=ci.top&id=".$v['id']."' class=set>".self::$language['spread']."</a> <a href='#' onclick='return set_state(".$v['id'].",2)'  class='m_close'>".self::$language['close']."</a> <br /><a href='index.php?monxin=".$class.".edit&id=".$v['id']."&type=".$v['type']."'  target=_blank class=edit>".self::$language['edit']."</a> ";
	}
	if($v['state']==2){
		$act="<a href='#' onclick='return set_state(".$v['id'].",1)'  class='m_open'>".self::$language['open']."</a> ";
	}
	$act.="<a href='#' onclick='return set_state(".$v['id'].",3)'  class='del'>".self::$language['del']."</a> ";
	
	if($_COOKIE['monxin_device']=='pc'){
		$list.="<tr id='tr_".$v['id']."'>
	<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
	<td><a href='./index.php?monxin=ci.detail&id=".$v['id']."' target=_blank class=icon><img wsrc=./program/ci/img_thumb/".$v['icon']." /></a></td>
	<td><div class=title><a href='./index.php?monxin=ci.detail&id=".$v['id']."' target=_blank>".$v['title']."</a></div><div class=type_tag><span class=type>".self::get_type_position($pdo,$v['type'])."</span><span class=tag>".self::get_tags_name($pdo,$v['tag'])."</span></div></td>
  <td><span class=visit>".$v['visit']."</span></td>
  <td><span class=time>".get_time('m-d H:i',self::$config['other']['timeoffset'],self::$language,$v['reflash'])."</span></td>
  <td><span class=data_state><span class=s_".$v['state'].">".self::$language['info_state'][$v['state']]."</span></span></td>
  <td class=operation_td>".$act."
  <span id=state_".$v['id']." class='state'></span></td>
</tr>
";
	}else{
		$list.="<div class=info  id='tr_".$v['id']."'>
        	<a href='./index.php?monxin=ci.detail&id=".$v['id']."' target=_blank class=icon><img wsrc=./program/ci/img_thumb/".$v['icon']." /></a><div class=info_other>
            	<div class=title><a href='./index.php?monxin=ci.detail&id=".$v['id']."' target=_blank>".$v['title']."</a></div><div class=type_tag><span class=type>".self::get_type_position($pdo,$v['type'])."</span><span class=tag>".self::get_tags_name($pdo,$v['tag'])."</span></div>
				<span class=visit>".$v['visit']."</span>
				<span class=time>".get_time('m-d H:i',self::$config['other']['timeoffset'],self::$language,$v['reflash'])."</span>
				<span class=data_state><span class=s_".$v['state'].">".self::$language['info_state'][$v['state']]."</span></span>
				<a href='#' class=show_act></a>
            </div>
            <div class=operation_td>".$act." <span id=state_".$v['id']." class='state'></span></div>
        </div>
		";
	}
	
	
		
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

function get_type_filter($pdo,$language,$list){
$list2="<option value='-1'>".$language['belong']."</option>";
$list2.="<option value='' selected>".$language['all'].$language['type']."</option>";
$_GET['type']=@$_GET['type']?@$_GET['type']:0;
$list2.=$list;
$list="<select name='type_filter' id='type_filter'>{$list2}</select>";
return $list;
}

$list=$this->get_parent($pdo);
$module['filter']=get_type_filter($pdo,self::$language,$list);


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);