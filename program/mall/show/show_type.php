<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$sql="select `id`,`name`,`remark`,`url` from ".self::$table_pre."type where `parent`=0 and visible=1   order by `sequence` desc";
$r=$pdo->query($sql,2);
$module['data']='';
foreach($r as $v){
	$v=de_safe_str($v);
	if($v['url']==''){$v['url']='./index.php?monxin=mall.goods_list&type='.$v['id'];}
	$module['data'].='<a href="'.$v['url'].'" class=parent p_id='.$v['id'].'><span class=icon><img src="./program/mall/type_icon/'.$v['id'].'.png" /></span><span class=name>'.$v['name'].'</span><span class=symbol>&nbsp;</span></a>';	
	$sql="select `id`,`name`,`remark`,`url` from ".self::$table_pre."type where `parent`='".$v['id']."' and visible=1   order by `sequence` desc";
	$r2=$pdo->query($sql,2);
	$sub2='';
	foreach($r2 as $v2){
		$v2=de_safe_str($v2);
		if(self::$config['show_type_deep']==3){
			$sql="select `id`,`name`,`remark`,`url` from ".self::$table_pre."type where `parent`='".$v2['id']."' and visible=1   order by `sequence` desc";
			if($_COOKIE['monxin_device']=='phone'){
				$sql="select `id`,`name`,`remark`,`url` from ".self::$table_pre."type where `parent`='".$v2['id']."' and visible=1   order by `sequence` desc limit 0,12";
			}
			$r3=$pdo->query($sql,2);
			$sub3='';
			foreach($r3 as $v3){
				$v3=de_safe_str($v3);
				if($v3['url']==''){$v3['url']='./index.php?monxin=mall.goods_list&type='.$v3['id'];}
	
				$sub3.='<a href="'.$v3['url'].'" class=sub3_a><img wsrc="./program/mall/type_icon/'.$v3['id'].'.png" />'.$v3['name'].'</a>';
			}
			if($sub3==''){
				if($v2['url']==''){$v2['url']='./index.php?monxin=mall.goods_list&type='.$v2['id'];}
				$sub3='<a href="'.$v2['url'].'" class=sub3_a><img wsrc="./program/mall/type_icon/'.$v2['id'].'.png" /></a>';	
			}
			if($v2['url']==''){$v2['url']='./index.php?monxin=mall.goods_list&type='.$v2['id'];}
			$sub2.='<div class=sub_2><a href="'.$v2['url'].'" class=sub2_a>'.$v2['name'].'</a><div class=sub_3>'.$sub3.'</div></div>';
		}else{
			if($v2['url']==''){$v2['url']='./index.php?monxin=mall.goods_list&type='.$v2['id'];}
			$sub2.='<div class=sub_2_2><a href="'.$v2['url'].'" class=sub2_a_2><img wsrc="./program/mall/type_icon/'.$v2['id'].'.png" />'.$v2['name'].'</a></div>';
		}
		
	}
	
	$module['data'].='<div class=sub_div><div class=remark>'.$v['remark'].'</div>'.$sub2.'</div>';

}
echo '<div style="display:none;" id="visitor_position_append">'.self::$language['pages']['mall.show_type']['title'].'</div>';

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
