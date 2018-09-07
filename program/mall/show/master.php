<?php

function update_mall_goods_monthly($pdo,$table_pre){
	$sql="select `id` from ".$table_pre."goods where `state`!=0";
	$r=$pdo->query($sql,2);
	$start_time=time()-(86400*30);
	foreach($r as $v){
		$sql="select sum(quantity) as c from ".$table_pre."order_goods where `goods_id`=".$v['id']." and `time`>".$start_time;
		$v2=$pdo->query($sql,2)->fetch(2);
		$sql="update ".$table_pre."goods set `monthly`=".$v2['c']." where `id`=".$v['id'];
		$pdo->exec($sql);	
	}
	
}


if(date("Y",time())!=file_get_contents("./program/mall/update_task/year.txt")){
	file_put_contents("./program/mall/update_task/year.txt",date("Y",time()));	
}
if(date("m",time())!=file_get_contents("./program/mall/update_task/month.txt")){
	
	file_put_contents("./program/mall/update_task/month.txt",date("m",time()));	
}
if(date("w",time())!=file_get_contents("./program/mall/update_task/week.txt")){
	file_put_contents("./program/mall/update_task/week.txt",date("w",time()));	
}
if(date("d",time())!=file_get_contents("./program/mall/update_task/day.txt")){
	update_mall_goods_monthly($pdo,self::$table_pre);
	file_put_contents("./program/mall/update_task/day.txt",date("d",time()));	
	
	$sql="select `id` from ".self::$table_pre."type where `visible`=1 and (`url`='' or `url` is null)";
	$r=$pdo->query($sql,2);
	foreach($r as $v){				
		$color=array();
		$sql="select `id` from ".self::$table_pre."goods where `type`=".$v['id']." and `option_enable`=1";
		$r2=$pdo->query($sql,2);
		$ids='';
		foreach($r2 as $v2){
			$ids.=$v2['id'].',';	
		}
		$ids=trim($ids,',');
		if($ids!=''){
			$sql="select `color_id` from ".self::$table_pre."goods_specifications where `color_id`!=0 and `goods_id` in (".$ids.")";
			$r3=$pdo->query($sql,2);
			
			foreach($r3 as $v3){
				if(!isset($color[$v3['color_id']])){$color[$v3['color_id']]=0;}
				$color[$v3['color_id']]++;	
			}			
		}
		asort($color);
		$colors='';
		foreach($color as $k=>$v4){$colors=$k.','.$colors;}
		$colors=trim($colors,',');
		$sql="update ".self::$table_pre."type set `contain_color`='".$colors."' where `id`=".$v['id'];
		$pdo->exec($sql);
	}
	
	$sql="select `contain_color`,`id` from ".self::$table_pre."type where `parent`=0 and `visible`=1";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$color2='';
		$sql="select `contain_color`,`id` from ".self::$table_pre."type where `parent`=".$v['id']." and `visible`=1 and (`url`='' or `url` is null)";
		$r2=$pdo->query($sql,2);
		foreach($r2 as $v2){
			$color3='';
			$sql="select `contain_color`,`id` from ".self::$table_pre."type where `parent`=".$v2['id']." and `visible`=1 and (`url`='' or `url` is null)";
			$r3=$pdo->query($sql,2);
			foreach($r3 as $v3){
				$color3.=$v3['contain_color'].',';	
			}
			$color3.=$v2['contain_color'].',';	
			$color3=explode(',',$color3);
			$color3=array_unique($color3);
			$color3=array_filter($color3);
			$color3=implode(',',$color3);
			$v2['contain_color']=$color3;
			$sql="update ".self::$table_pre."type set `contain_color`='".trim($v2['contain_color'],',')."' where `id`=".$v2['id'];
			$pdo->exec($sql);
			$color2.=$v2['contain_color'].',';	
		}
		$color2.=$v['contain_color'].',';	
		$color2=explode(',',$color2);
		$color2=array_unique($color2);
		$color2=array_filter($color2);
		$color2=implode(',',$color2);
		$v['contain_color']=$color2;
		$sql="update ".self::$table_pre."type set `contain_color`='".trim($v['contain_color'],',')."' where `id`=".$v['id'];
		//echo $sql;
		$pdo->exec($sql);

	}
	
}






$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);	
$menu=require("./program/".$class."/menu.php");
$pages=require("./program/".$class."/pages.php");
$list='';
foreach($menu[str_replace("::",".",$method)] as $key=>$v){
	if(is_array($v)){$v=$key;}
	$t=explode(".",$pages[$v]['url']);
		if(!in_array($pages[$v]['url'],$_SESSION['monxin']['page'])){continue;}
	$v2['icon_path']="./templates/1/".$class."/".self::$config['program']['template_1']."/page_icon/".$pages[$v]['url'].".png";

	$list.="<li><a href=index.php?monxin={$pages[$v]['url']}  target='".$pages[$v]['target']."'><img src='".$v2['icon_path']."' /><br><span>".self::$language['pages'][$v]['name']."</span></a></li>";
	
}
$module['list']="<ul id=icons>{$list}<div style='clear:both;'></div></ul>";

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
