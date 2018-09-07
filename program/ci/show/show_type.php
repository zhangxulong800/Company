<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

if($_COOKIE['monxin_device']=='pc'){

	
	$sql="select `column` from ".self::$table_pre."type  where `parent`=0 and visible=1 order by `column` desc limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$max=$r['column'];
	$sql="select `column` from ".self::$table_pre."type  where `parent`=0 and visible=1 order by `column` asc limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$min=$r['column'];
	
	$module['data']='';
	$column=array();
	$count=0;
	for($i=$min;$i<=$max;$i++){
		$sql="select `id`,`name`,`url`,`line_column`,`show_attribute` from ".self::$table_pre."type where `parent`=0 and visible=1  and `column`=".$i." order by `sequence` desc";
		$r=$pdo->query($sql,2);
		$column[$i]='';
		foreach($r as $v){
			$v=de_safe_str($v);
			if($v['url']!=''){$url=$v['url'];}else{$url='./index.php?monxin=ci.list&type='.$v['id'].'';}
			$parent='<a class=parent href="'.$url.'" target="'.self::$config['target'].'"><span class=icon><img src=./program/ci/type_icon/'.$v['id'].'.png /></span><span class=text>'.$v['name'].'</span></a>';
			if($v['show_attribute']==0){
				$sql2="select `id`,`name`,`url`,`line_column` from ".self::$table_pre."type where `parent`=".$v['id']." and `visible`=1 order by `sequence` desc";
				$r2=$pdo->query($sql2,2);
				$sub='';
				foreach($r2 as $v2){
					$v2=de_safe_str($v2);
					if($v2['url']!=''){$url=$v2['url'];}else{$url='./index.php?monxin=ci.list&type='.$v2['id'].'';}
					$sub.='<a href="'.$url.'" target="'.self::$config['target'].'">'.$v2['name'].'</a>';	
				}
			}else{
				$sql2="select `input_args`,`type_id` from ".self::$table_pre."type_attribute where `id`=".$v['show_attribute'];
				$r2=$pdo->query($sql2,2)->fetch(2);
				$args=format_attribute($r2['input_args']);
				$sub='';
				$temp='';
				if(isset($args['select_option'])){				
					$temp=trim($args['select_option'],'/');
				}elseif(isset($args['radio_option'])){
					$temp=trim($args['radio_option'],'/');
				}elseif(isset($args['checkbox_option'])){
					$temp=trim($args['checkbox_option'],'/');
				}
				$temp=explode('/',$temp);
				foreach($temp as $v2){
					$v2=de_safe_str($v2);
					$url='./index.php?monxin=ci.list&type='.$r2['type_id'].'&a_'.$v['show_attribute'].'='.urlencode($v2);
					$sub.='<a href="'.$url.'" target="'.self::$config['target'].'">'.$v2.'</a>';	
				}
			}
			if($sub!=''){$sub='<div class="sub line_column_'.$v['line_column'].'">'.$sub.'</div>';}
			$column[$i].='<div class=type_div ci_type='.$v['id'].'>'.$parent.$sub.'</div>';
		}
		if(isset($column[$i])){
			$module['data'].='<div class=column id=column_'.$i.'>'.$column[$i].'</div>';
			$count++;	
		}
		
	}
	$module['width']=(100/$count)-2;
	
}else{

	$sql="select `id`,`name`,`url`,`show_attribute` from ".self::$table_pre."type where `parent`=0 and visible=1 order by `sequence` desc";
	$r=$pdo->query($sql,2);
	$module['data']='';
	foreach($r as $v){
		$v=de_safe_str($v);
		if($v['url']!=''){$url=$v['url'];}else{$url='./index.php?monxin=ci.list&type='.$v['id'].'';}
		$parent='<a class=parent href="'.$url.'" target="'.self::$config['target'].'"><span class=icon><img src=./program/ci/type_icon/'.$v['id'].'.png /></span><span class=text>'.$v['name'].'</span></a>';

			if($v['show_attribute']==0){
				$sql2="select `id`,`name`,`url`,`line_column` from ".self::$table_pre."type where `parent`=".$v['id']." and `visible`=1 order by `sequence` desc";
				$r2=$pdo->query($sql2,2);
				$sub='';
				foreach($r2 as $v2){
					$v2=de_safe_str($v2);
					if($v2['url']!=''){$url=$v2['url'];}else{$url='./index.php?monxin=ci.list&type='.$v2['id'].'';}
					$sub.='<a href="'.$url.'" target="'.self::$config['target'].'">'.$v2['name'].'</a>';	
				}
			}else{
				$sql2="select `input_args`,`type_id` from ".self::$table_pre."type_attribute where `id`=".$v['show_attribute'];
				$r2=$pdo->query($sql2,2)->fetch(2);
				$args=format_attribute($r2['input_args']);
				$sub='';
				$temp='';
				if(isset($args['select_option'])){				
					$temp=trim($args['select_option'],'/');
				}elseif(isset($args['radio_option'])){
					$temp=trim($args['radio_option'],'/');
				}elseif(isset($args['checkbox_option'])){
					$temp=trim($args['checkbox_option'],'/');
				}
				$temp=explode('/',$temp);
				foreach($temp as $v2){
					$v2=de_safe_str($v2);
					$url='./index.php?monxin=ci.list&type='.$r2['type_id'].'&a_'.$v['show_attribute'].'='.urlencode($v2);
					$sub.='<a href="'.$url.'" target="'.self::$config['target'].'">'.$v2.'</a>';	
				}
			}

		if($sub!=''){$sub='<div class="sub">'.$sub.'</div>';}
		$module['data'].='<div class=type_div  ci_type='.$v['id'].'>'.$parent.$sub.'</div>';
	}
	
}

echo '<div style="display:none;" id="visitor_position_append">'.self::$language['pages']['ci.show_type']['title'].'</div>';

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
