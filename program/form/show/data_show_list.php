<?php
$table_id=intval(@$_GET['table_id']);
if($table_id==0){exit('table_id err');}

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);


$sql="select `name`,`read_state`,`description` from ".self::$table_pre."table where `id`=$table_id";
$r=$pdo->query($sql,2)->fetch(2);
$table_name=$r['name'];
echo '<div style="display:none;" id="visitor_position_append">'.$r['description'].'</div>';

if($r['read_state']!=1){echo $r['description'].self::$language['read_able_is_off'];return false;}

$sql="select `name`,`search_able`,`description`,`input_type`,`input_args`,`fore_list_show` from ".self::$table_pre."field where `table_id`=$table_id order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$where="";
if(@$_GET['publish']!=''){if($_GET['publish']==0 || $_GET['publish']==1){$where.=" and `publish` ='".intval($_GET['publish'])."'";}}

$fields='';
$search_able='';
$input_type=array();
$input_args=array();
$module['head_field']='';
$module['body_field']='';
$module['search_placeholder']=self::$language['writer'].'ID';

$module['filter']='';
$i=0;
foreach($r as $v){
	$input_type[$v['name']]=$v['input_type'];
	$input_args[$v['name']]=$v['input_args'];
	$fields.='`'.$v['name'].'`,';
	if($v['fore_list_show']){
		$module['head_field'].="<td><a href=# title=".self::$language['order']." class='sorting'  desc='".$v['name']."|desc' asc='".$v['name']."|asc'>".$v['description']."</a></td>";
		$module['body_field'].=$v['name'].",";
	}	
	if($v['search_able']){$module['search_placeholder'].='/'.$v['description'];$search_able.="`".$v['name']."` like '%".$_GET['search']."%' or ";}	
	if($v['input_type']=='select' || $v['input_type']=='radio' || $v['input_type']=='checkbox'){
		$options='';
		$args=format_attribute($v['input_args']);
		$temp=explode('/',$args[$v['input_type'].'_option']);
		foreach($temp as $vv){
			if(@$_GET[$v['name']]==$vv){$selected='selected';}else{$selected='';}
			$options.='<option value="'.$vv.'" '.$selected.'>'.$vv.'</option>';
		}
		$module['filter'].=' <span class="filter_label">'.$v['description'].'</span><select id='.$v['name'].'><option value="" selected>'.self::$language['all'].'</option>'.$options.'</select> ';		if(@$_GET[$v['name']]!=''){
			if($v['input_type']=='checkbox'){
				$where.=" and `".$v['name']."` like '%".$_GET[$v['name']]."|%'";
			}else{
				$where.=" and `".$v['name']."` ='".$_GET[$v['name']]."'";
			}	
		}
	}
	$i++;
}
if($module['filter']!=''){$module['filter']=self::$language['content_filter'].'：'.$module['filter'].'<br /><br />';}
$fields=trim($fields,',');
$search_able=trim($search_able,'or ');
$sql="select `publish`,`id`,`write_time`,`writer`,`sequence`,".$fields." from ".self::$table_pre.$table_name;



if($_GET['search']!=''){
	$where=" and (`writer` like '%".$_GET['search']."%' or `editor` like '%".$_GET['search']."%' or ".$search_able.")";	
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
	$sum_sql=str_replace(" `publish`,`id`,`write_time`,`writer`,`sequence`,".$fields." "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_".$table_name." and","_".$table_name." where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_".$table_name." and","_".$table_name." where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$filed_data='';
	$v=de_safe_str($v);
	$temp=explode(',',$module['body_field']);
	$temp=array_filter($temp);
	foreach($temp as $vv){
		//echo $vv.'<br />';
		if(in_array($vv,self::$config['sys_field'])){
			switch ($vv){
				case 'write_time':
					$data=get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['write_time']);
					break;
				case 'writer':
					if($v['writer']>0){$data=get_username($pdo,$v['writer']);}else{$data=self::$language['unlogin_user'];}
					break;
				case 'edit_time':
					$data=get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['edit_time']);
					break;
				case 'editor':
					if($v['editor']>0){$data=get_username($pdo,$v['writer']);}else{$data='';}
					break;
				case 'publish':
					$data=($v['publish'])?self::$language['yes']:self::$language['no'];
					break;
				default:
					$data=$v[$vv];	
			}
			$filed_data.='<td><span class='.$v['name'].'>&nbsp;'.$data.'</span></td>';
			continue;	
		}
		
		$args=format_attribute($input_args[$vv]);
		$data='';
		switch ($input_type[$vv]) {
			case 'img':
				if(is_file('./program/form/img_thumb/'.$v[$vv])){
					$data='<a href="./program/form/img/'.$v[$vv].'" target="_blank"><img src="./program/form/img_thumb/'.$v[$vv].'" style="width:'.$args['img_width'].'px;border:0px;"></a>';
				}else{
					$data='<a href="./program/form/img/'.$v[$vv].'" target="_blank">'.substr($v[$vv],11).'</a>';
				}
				break;
			case 'imgs':
				if($v[$vv]!=''){
					$temp3=explode('|',$v[$vv]);
					$temp3=array_filter($temp3);
					$temp4='';	
					foreach($temp3 as $v3){
						$temp4.='<a href="./program/form/imgs/'.$v3.'" target="_blank">'.substr($v3,11).'</a><br />';
					}
					$data=$temp4;
				}
				break;
			case 'file':
				$data='<a href="./program/form/file/'.$v[$vv].'" target="_blank">'.substr($v[$vv],11).'</a>';
				break;
			case 'files':
				if($v[$vv]!=''){
					$temp3=explode('|',$v[$vv]);
					$temp3=array_filter($temp3);
					$temp4='';	
					foreach($temp3 as $v3){
						$temp4.='<a href="./program/form/files/'.$v3.'" target="_blank">'.substr($v3,11).'</a><br />';
					}
					$data=$temp4;
				}
				break;
			case 'time':
				$data=get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v[$vv]);
				break;
			case 'area':
				$data="<span class=load_js_span  src='area_js.php?callback=set_area&input_id=".$vv."&id=".$v[$vv]."&output=text2' id='home_area_".$v[$vv]."'></span>";
				break;
			case 'map':
				if($v[$vv]!==''){
					$data='<a href="'.$v[$vv].'" target="_blank" class=map title="'.self::$language['view'].'">&nbsp;</a>';
				}
				break;
			default:
				$data=$v[$vv];
		}
		
		$filed_data.='<td><span class='.$vv.'>&nbsp;'.$data.'</span></td>';
	}
	
	
	
	$list.="<tr id='tr_".$v['id']."'>
	".$filed_data."
  <td class=operation_td><a href='index.php?monxin=".$class.".data_show_detail&table_id=".$table_id."&id=".$v['id']."' target=_blank  class='view'>".self::$language['detail']."</a></td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&table_id=".$table_id;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);


		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);