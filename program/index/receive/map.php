<?php
$act=@$_GET['act'];
if($act=='update_stop'){
	///file_put_contents('./map.txt',$_POST['htmls']);
	$htmls=$_POST['htmls'];
	if($htmls!=''){
		$sql="select `id`,`page_power`,`map`,`map_update_token` from ".$pdo->index_pre."group where `id`='".$_SESSION['monxin']['group_id']."'";
//echo $sql;
		$v=$pdo->query($sql,2)->fetch(2);
		if($v['map_update_token']!=md5($v['page_power'])){
			$map_update_token=md5($v['page_power']);
		}else{
			exit('err');
		}
		$sum=0;
		$map='';
		$composite='';
		$t1=explode('mmm*aaa*ppp:',$htmls);
		foreach($t1 as $k=>$v){
			if($v!=''){
				//var_dump($v);
				$sum++;
				$parent_url=get_match_single("#uuurrrr{(.*)}lll:#iU",$v);
				if($parent_url=='' || $parent_url=='index.map' || $parent_url=="'+url[i]+'"){continue;}
				$parent_name=get_match_single('#<div id="user_position">.*<span class="text">(.*)</span></div>#iUs',$v);
				if($parent_name==''){continue;}
				//file_put_contents('./map'.$k.'.txt',$v);
				preg_match_all('#<li><a href="index\.php\?monxin=(.*)" target="_self"><img src="\./templates/.*/page_icon/.*\.png"><br><span>(.*)</span></a></li>#iUs',$v,$match);
				$sub='';
			
				foreach($match[0] as $k2=>$v2){
					$sub.='<a href="index.php?monxin='.$match[1][$k2].'">'.$match[2][$k2].'</a>';
				}
				if($sub==''){
					$composite.='<a href="index.php?monxin='.$parent_url.'">'.$parent_name.'</a>';
				}else{
					$map.='<div class=line><div class=parent><a href="index.php?monxin='.$parent_url.'">'.$parent_name.'</a></div><div class=sub>'.$sub.'</div></div>';
				}
			}			
		}
		if($map==''){exit('map is null');}
		$map='<div class=line><div class=parent><a href="#">'.self::$language['composite'].'</a></div><div class=sub>'.$composite.'</div></div>'.$map;
		$sql="select count(id) as c from ".$pdo->index_pre."group_menu where `group_id`=".$_SESSION['monxin']['group_id'];
		$r=$pdo->query($sql,2)->fetch(2);
		if($sum<$r['c']){exit('submit:'.$sum.'< sum:'.$r['c'].' '.self::$language['fail']);}
		
		$sql="update ".$pdo->index_pre."group set `map`='".safe_str($map)."',`map_update_token`='".$map_update_token."' where `id`=".$_SESSION['monxin']['group_id'];
		$pdo->exec($sql);
		
		echo self::$language['update'].self::$language['success'];
		
		
	}
}