<?php
//echo $args[1];
self::update_top_price($pdo,self::$table_pre);

$attribute=format_attribute($args[1]);
$id=$attribute['id'];
if($attribute['follow_type']=='true' && intval(@$_GET['type'])!=0){$id=intval($_GET['type']);}

$ids=$this->get_type_ids($pdo,$id);
if($attribute['tag']!=''){
	$tag=explode('/',$attribute['tag']);
	$sub_where='';
	foreach($tag as $v){
		if(is_numeric($v)){
			$sub_where.="`tag` like '%|".$v."|%' or ";	
		}	
	}
	$sub_where=trim($sub_where,'or ');
	$tag_where=' and ('.$sub_where.')';	
}else{
	$tag_where='';	
}
$c_field='';
$attribute['field']=str_replace('`','',$attribute['field']);
$field_array=explode(',',$attribute['field']);

foreach($field_array as $v){
	if($v==''){continue;}
	if(is_numeric($v)){
		
	}else{
		$c_field.='`'.$v.'`,';	
	}	
}
$c_field=trim($c_field,',');

if($id>0){
	$t_sql="select * from ".self::$table_pre."type where `id`=".$id;
	$type_r=$pdo->query($t_sql,2)->fetch(2);
	$unit=$type_r['unit'];
}else{
	$unit='';
}
$start=0;
$attribute['quantity']=intval($attribute['quantity']);
$current_page=intval(@$_GET['current_page']);
if($attribute['follow_page']=='true' && $current_page>0){$start=$current_page*$attribute['quantity'];}
$sql="select `id`,".$c_field." from ".self::$table_pre."content where `state`=1 and `type` in(".$ids.") ".$tag_where." order by `".$attribute['sequence_field']."` ".$attribute['sequence_type']." limit ".$start.",".$attribute['quantity'];
	//echo $sql;
	$r=$pdo->query($sql,2);
	$list='';
	$time=time();
	
	
	foreach($r as $v){
		$v=de_safe_str($v);
		$width=100;
		$icon='';
		$price='';
		$reflash='';
		$title='';
		$attributes='';
		$other='';
		$linkman='';
		$contact='';
		if(in_array('icon',$field_array)){
			$width-=35;
			$icon='<a href=./index.php?monxin=ci.detail&id='.$v['id'].' target='.self::$config['target'].' class=icon><img wsrc=./program/ci/img_thumb/'.$v['icon'].' /></a>';	
		}
		if(in_array('price',$field_array)){
			
		if($v['price']>0){
			$other='<span class=price>'.self::format_price($v['price'],self::$language['yuan'],self::$language['million_yuan']).'<span class=unit>'.$unit.'</span></span>';	
		}else{
			$other='<span class=price>'.self::$language['negotiable'].'</span>';
		}
		}
		if(in_array('reflash',$field_array)){
			$other.="<span class=reflash>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['reflash'])."</span>";	
		}
		if(in_array('title',$field_array)){
			$title='<a href=./index.php?monxin=ci.detail&id='.$v['id'].' target='.self::$config['target'].' class=title>'.$v['title'].'</a>';	
		}
		if(in_array('content',$field_array)){
			$content='<div class=content>'.mb_substr(strip_tags($v['content']),0,100,'utf-8').'...</div>';	
		}
		if(in_array('linkman',$field_array)){
			$linkman='<span class=linkman>'.$v['linkman'].'</span>';	
		}
		if(in_array('contact',$field_array)){
			$contact='<span class=contact>'.$v['contact'].'</span>';	
		}
		if($linkman!='' || $contact!=''){$other.=$linkman.$contact;}
		if($id!=0){
			$a_ids='';
			foreach($field_array as $v3){
				if(is_numeric($v3)){$a_ids.=$v3.',';}	
			}
			//var_dump($a_ids);
			if($a_ids!=''){
				$a_ids=trim($a_ids,',');
				$sql="select `a_id`,`content` from ".self::$table_pre."attribute_value where `c_id`=".$v['id']." and `a_id` in (".$a_ids.")";
				$r2=$pdo->query($sql,2);
				$at=array();
				foreach($r2 as $v2){
					$at[$v2['a_id']]=trim($v2['content'],'/');	
				}
				$sql="select `id`,`postfix` from ".self::$table_pre."type_attribute where `id` in (".$a_ids.") order by `sequence` desc";
				$r2=$pdo->query($sql,2);
				foreach($r2 as $v2){
					//var_dump($v2);
					$attributes.='<span>'.@$at[$v2['id']].'<postfix>'.$v2['postfix'].'</postfix></span>';	
				}
			}
			
		}
		
		if($other!=''){
			$other='<div class=other>'.$other.'</div>';	
		}
		//var_dump($other);
		$list.="<div class=line id=i_".$v['id'].">".$icon."<div class=middle style='width:".$width."%;'>".$title.'<div class="attributes">'.$attributes.'</div>'.$other."</div></div>";
			
	}
		
	
	
	if($list==''){$list='<a href="#">'.self::$language['no_content'].'</a>';}
	$module['list']=$list;
	
	
	$module['target']=$attribute['target'];
	$module['module_diy']=@$attribute['module_diy'];
	$module['title_link']='./index.php?monxin=ci.list&type='.$id.'&tag='.$attribute['tag'];
	$module['title']=$attribute['title'];
	if($module['title']==''){$module['title_show']='none';}else{$module['title_show']='block';}
	$module['i_width']=$attribute['i_width'];
	$module['module_width']=$attribute['width'];
	$module['module_height']=$attribute['height'];
	$module['module_name']=str_replace("::","_",$method.'_'.$id.'_append_'.str_replace('/','_',$attribute['tag']).'_'.$attribute['sequence_field'].'_'.$attribute['sequence_type']);
	$module['module_name']='id'.md5(serialize($attribute));
	$module['module_save_name']=str_replace("::","_",$method.$args[1]);
	
	$module['cover_image']='';
	if($attribute['img']!=''){
		$link=str_replace('*','.',@$attribute['img_link']);
		$link=str_replace('!',':',$link);
		$module['cover_image']='<a href="'.$link.'" class=cover_image  target='.$attribute['target'].'><img src="./program/ci/img/'.str_replace('*','.',$attribute['img']).'" /></a>';	
		$module['img_width']=$attribute['img_width'];
	}
	

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
