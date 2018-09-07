<?php
//echo $args[1];

$attribute=format_attribute($args[1]);
$id=$attribute['id'];
if($attribute['follow_type']=='true' && intval(@$_GET['type'])!=0){$id=intval($_GET['type']);}

$ids=$this->get_type_ids($pdo,$id);
$current_page=intval(@$_GET['current_page']);
if($attribute['follow_page']=='true' && $current_page>0){$start=$current_page*$attribute['quantity'];}else{$start=0;}
$sql="select ".$attribute['field'].",`id`,`title`,`link` from ".self::$table_pre."article where `visible`=1 and `type` in(".$ids.") order by `".$attribute['sequence_field']."` ".$attribute['sequence_type']." limit ".$start.",".$attribute['quantity'];
	//echo $sql;
	$r=$pdo->query($sql,2);
	$list='';
	$field_array=get_field_array($attribute['field']);
	foreach($r as $v){
		$v=de_safe_str($v);
		$title='';
		$content='';
		$src='';
		$visit='';
		$time='';
		if(in_array('content',$field_array)){
			$v['content']=strip_tags($v['content']);
			$v['content']=str_replace('&nbsp;','',$v['content']);
			$content='<span class=content>'.mb_substr($v['content'],0,$attribute['content_length'],'UTF-8').' ...</span>';
		}
		if(in_array('title',$field_array)){$title='<span class=title>'.$v['title'].'</span>';}
		if(in_array('src',$field_array) && $v['src']!=''){$src='<img src="./program/article/img_thumb/'.$v['src'].'" class=img_thumb alt="'.$v['title'].'" />';}
		if(in_array('visit',$field_array)){$visit='<span class=visit><span class="visit_symbol">&nbsp;</span>'.$v['visit'].'</span>';}
		if(in_array('time',$field_array)){$time='<span class=time>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time']).'</span>';}
		if($v['link']==''){$link='./index.php?monxin=article.show&id='.$v['id'];}else{$link=$v['link'];}
		
		$list.="<a href='".$link."' id='article_show_".$v['id']."' target='".$attribute['target']."'><span class=text>".$title.$content.$time.$visit."</span><span class=img>".$src."</span></a>";
		
	}
	if($list==''){$list='<a href="#">'.self::$language['no_content'].'</a>';}
	$module['list']=$list;
	
	
	
	$module['title']=$attribute['title'];
	$module['scroll']=$attribute['scroll'];
	$module['module_width']=$attribute['width'];
	$module['module_height']=$attribute['height'];
	$module['sub_module_width']=$attribute['sub_module_width'];
	//$module['module_name']=str_replace("::","_",$method.'_'.$id);
	$module['module_name']=str_replace("::","_",$method.'_'.$id.'_append_'.$attribute['sequence_field'].'_'.$attribute['sequence_type']);

	$module['module_save_name']=str_replace("::","_",$method.$args[1]);
	$module['count_url']="receive.php?target=".$method."&id=".$id;
			$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
