<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

function get_type_goods($pdo,$table_pre,$id,$money_symbol){
	$sql="select `title`,`id`,`w_price`,`min_price`,`max_price`,`option_enable` from ".$table_pre."goods where `type`=".$id." and `state`!=0 order by `sequence` desc,`id` asc";
	$r2=$pdo->query($sql,2);
	$temp='';
	foreach($r2 as $v2){
		if($v2['option_enable']){
			$price=$v2['min_price'].'-'.$v2['max_price'];
		}else{
			$price=$v2['w_price'];
		}
		$temp.='<a href=./index.php?monxin=mall.goods&id='.$v2['id'].' target=_blank><span class=title>'.$v2['title'].'</span><span class=price>'.$money_symbol.$price.'</span></a>';
	}
	return $temp;
}
$module['data']='';
$sql="select `id` from ".self::$table_pre."type where `parent`=0 and visible=1  and (`url`='' or `url` is null) order by `sequence` desc";
$r=$pdo->query($sql,2);
foreach($r as $v){
	$sql="select count(id) as c from ".self::$table_pre."type where `parent`=".$v['id']." limit 0,1";
	$temp=$pdo->query($sql,2)->fetch(2);
	if($temp['c']==0){
		$temp=get_type_goods($pdo,self::$table_pre,$v['id'],self::$language['money_symbol']);
		if($temp!=''){
			$module['data'].='<div class=type><div class=type_name>'.self::get_type_position($pdo,$v['id']).'</div><div class=goods>'.$temp.'</div></div>';	
		}	
	}else{
		$sql="select `id` from ".self::$table_pre."type where `parent`='".$v['id']."' and visible=1  and (`url`='' or `url` is null) order by `sequence` desc";
		$r2=$pdo->query($sql,2);
		foreach($r2 as $v2){
			
			$sql="select count(id) as c from ".self::$table_pre."type where `parent`=".$v2['id']." limit 0,1";
			$temp=$pdo->query($sql,2)->fetch(2);
			if($temp['c']==0){
				$temp=get_type_goods($pdo,self::$table_pre,$v2['id'],self::$language['money_symbol']);
				if($temp!=''){
					$module['data'].='<div class=type><div class=type_name>'.self::get_type_position($pdo,$v2['id']).'</div><div class=goods>'.$temp.'</div></div>';	
				}	
			}else{
				$sql="select `id` from ".self::$table_pre."type where `parent`='".$v2['id']."' and visible=1  and (`url`='' or `url` is null) order by `sequence` desc";
				$r3=$pdo->query($sql,2);
				foreach($r3 as $v3){
					$temp=get_type_goods($pdo,self::$table_pre,$v3['id'],self::$language['money_symbol']);
					if($temp!=''){
						$module['data'].='<div class=type><div class=type_name>'.self::get_type_position($pdo,$v3['id']).'</div><div class=goods>'.$temp.'</div><div class=bottom></div></div>';	
					}	
				}
			
			}
					
			
				
		}
	
	}
	
	
}

echo '<div style="display:none;" id="visitor_position_append">'.self::$language['pages']['mall.catalog']['title'].'</div>';

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
