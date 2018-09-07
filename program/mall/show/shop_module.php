<?php
//echo $args[1];
//return false;
$attribute=format_attribute($args[1]);
$attribute['quantity']=intval($attribute['quantity']);
if($attribute['store_tag']!=''){
	$store_tag=explode('/',$attribute['store_tag']);
	$shop_ids='';
	foreach($store_tag as $v){
		if(is_numeric($v)){
			$shop_ids.=self::get_store_tag_shop_ids($pdo,$v).',';
		}	
	}
	$shop_ids=trim($shop_ids,',');
	$temp=explode(',',$shop_ids);
	$temp=array_unique($temp);
	$temp=array_filter($temp);
	$shop_ids='';
	foreach($temp as $v){
		if(is_numeric($v)){$shop_ids.=$v.',';}	
	}
	$shop_ids=trim($shop_ids,',');
	if($shop_ids==''){$shop_ids='0';}
	
	$store_tag_where=' and `id` in ('.$shop_ids.')';	
}else{
	$store_tag_where='';	
}


if($attribute['circle']>0){
	$circle=get_circle_ids($pdo,$attribute['circle']);
	$shop_ids=self::get_circle_shop_ids($pdo,$circle);
	if($shop_ids==''){$shop_ids='0';}
	$circle_where=' and `id` in ('.$shop_ids.')';	
}else{
	$circle_where='';	
}


$sql="select `id`,`name` from ".self::$table_pre."shop where `state`=2 and  `is_head`=0 ".$store_tag_where." ".$circle_where." order by `".$attribute['sequence_field']."` ".$attribute['sequence_type']." limit 0,".$attribute['quantity'];
//echo $sql;

$r=get_sql_cache(self::$config,$sql);
if(!$r){$r=$pdo->query($sql,2);$sql_a_create=true;}else{$sql_a_create=false;}
$sql_cache_a=array();
$sql_a=$sql;
//echo $sql;
$list='';
foreach($r as $v){
	$sql_cache_a[]=$v;
	$v=de_safe_str($v);
	$list.="<a href=./index.php?monxin=mall.shop_index&shop_id=".$v['id']." class=icon target=".$attribute['target']."><img src=./program/mall/shop_icon/".$v['id'].".png /><span>".$v['name']."</span></a>";
	
	

}
if($list==''){$list='<span class=no_related_content_span>'.self::$language['no_related_content'].'</span>';}		
$module['list']=$list;
if($sql_a_create){set_sql_cache(self::$config,$sql_a,$sql_cache_a);}



$module['target']=$attribute['target'];
$module['module_diy']=@$attribute['module_diy'];
$module['title_link']='./index.php?monxin=mall.shop_list&circle='.$attribute['circle'].'&tag='.$attribute['store_tag'];
$module['title']=$attribute['title'];
if($module['title']==''){$module['title_show']='none';}else{$module['title_show']='block';}
$module['module_width']=$attribute['width'];
$module['module_height']=$attribute['height'];
$module['module_name']=str_replace("::","_",$method.'_append_'.$attribute['circle'].'_'.$attribute['sequence_field'].'_'.$attribute['sequence_type'].'_'.str_replace('/','_',$attribute['store_tag']));
$module['module_name']='id'.md5(serialize($attribute));
$module['module_save_name']=str_replace("::","_",$method.$args[1]);
$module['count_url']="receive.php?target=".$method."";
	


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
