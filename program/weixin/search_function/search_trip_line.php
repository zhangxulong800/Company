<?php
//======================================================================================================= 获取 平台商品分类 上级ID
	function trip_get_type_ids($pdo,$id){
		$sql="select `id` from ".$pdo->sys_pre."trip_type where `parent`=$id";
		$r=$pdo->query($sql,2);
		$ids=$id.',';
		foreach($r as $v){
			$ids.=$v['id'].',';
			$sql2="select `id` from ".$pdo->sys_pre."trip_type where `parent`=".$v['id']."";
			$r2=$pdo->query($sql2,2);
			foreach($r2 as $v2){
				$ids.=$v2['id'].',';
				$sql3="select `id` from ".$pdo->sys_pre."trip_type where `parent`=".$v2['id']."";
				$r3=$pdo->query($sql3,2);
				foreach($r3 as $v3){
					$ids.=$v3['id'].',';
				}
			}
			
		}
		return trim($ids,',');
	}

	function trip_get_shop_type_ids($pdo,$id){
		$sql="select `id` from ".$pdo->sys_pre."trip_shop_type where `parent`=$id";
		$r=$pdo->query($sql,2);
		$ids=$id.',';
		foreach($r as $v){
			$ids.=$v['id'].',';
			$sql2="select `id` from ".$pdo->sys_pre."trip_shop_type where `parent`=".$v['id']."";
			$r2=$pdo->query($sql2,2);
			foreach($r2 as $v2){
				$ids.=$v2['id'].',';
				$sql3="select `id` from ".$pdo->sys_pre."trip_shop_type where `parent`=".$v2['id']."";
				$r3=$pdo->query($sql3,2);
				foreach($r3 as $v3){
					$ids.=$v3['id'].',';
				}
			}
			
		}
		return trim($ids,',');
	}



function search_trip_line($account,$pdo,$language,$key,$openid){
	
	if($openid==''){$openid=@$_GET['openid'];}
	$sql="select `username` from ".$pdo->sys_pre."weixin_account where `wid`='".$openid."' and `state`=1 limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="select `id` from ".$pdo->sys_pre."trip_shop where `username`='".$r['username']."' and `state`=2 limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$shop_where='';
	if($r['id']!=''){
		$shop_where=" and `shop_id`=".$r['id']."";
		$shop_id=$r['id'];
	}
	
	if($shop_where!=''){
		
		$sql="select `id` from ".$pdo->sys_pre."trip_shop_type where `visible`=1 and `shop_id`=".$shop_id." and `name`='".$key."' order by `parent` asc,`sequence` desc limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']=='' && strlen($key)>5){
			$sql="select `id` from ".$pdo->sys_pre."trip_shop_type where `visible`=1 and `shop_id`=".$shop_id." and  `name` like '%".$key."%' order by `parent` asc,`sequence` desc  limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
		}
		if($r['id']!=''){
			$type_ids=trip_get_shop_type_ids($pdo,$r['id']);
			$sql="select `title`,`id`,`icon` from ".$pdo->sys_pre."trip_line where `shop_type` in (".$type_ids.") and `visible`=1 and `web_state`=1 order by `bidding_show` desc,`sequence` desc,`monthly` desc limit 0,8";
			
		}else{
			$sql="select `title`,`id`,`icon` from ".$pdo->sys_pre."trip_line where (`title` like '%".$key."%') ".$shop_where." and `visible`=1 and `web_state`=1 order by `bidding_show` desc,`sequence` desc,`monthly` desc limit 0,8";
		
		}
			
			
	}else{
		
		$sql="select `id` from ".$pdo->sys_pre."trip_type where `visible`=1 and (`url`='' or `url` is null) and `name`='".$key."' order by `parent` asc,`sequence` desc limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']=='' && strlen($key)>5){
			$sql="select `id` from ".$pdo->sys_pre."trip_type where `visible`=1 and (`url`='' or `url` is null) and  `name` like '%".$key."%' order by `parent` asc,`sequence` desc  limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
		}
		if($r['id']!=''){
			$type_ids=trip_get_type_ids($pdo,$r['id']);
			$sql="select `title`,`id`,`icon` from ".$pdo->sys_pre."trip_line where `type` in (".$type_ids.") and `visible`=1 and `web_state`=1 order by `bidding_show` desc,`sequence` desc,`monthly` desc limit 0,8";
			
		}else{
			$sql="select `title`,`id`,`icon` from ".$pdo->sys_pre."trip_line where (`title` like '%".$key."%') and `visible`=1 and `web_state`=1 order by `bidding_show` desc,`sequence` desc,`monthly` desc limit 0,8";
		
		}
			
	}
	
	//echo $sql;
	$r=$pdo->query($sql,2);
	$data=array();
	$i=0;
	foreach($r as $v){
		if($i==7){
			$data[$i]['title']=$language['click_show_all'];
			$data[$i]['url']=get_monxin_path().'index.php?monxin=trip.line_list&current_page=2&search='.urlencode($key);
			$data[$i]['picurl']='';
			break;
		}
		$data[$i]['title']=$v['title'];
		$data[$i]['url']=get_monxin_path().'index.php?monxin=trip.line&id='.$v['id'];
		$data[$i]['url']=get_monxin_path().'index.php?monxin=trip.line&id='.$v['id'];
		$data[$i]['picurl']='';
		if($v['icon']!=''){$data[$i]['picurl']=get_monxin_path().'program/trip/img_thumb/'.$v['icon'];}
		if($i==0){
			$data[$i]['picurl']=get_monxin_path().'logo.png';	
			if($v['icon']!=''){$data[$i]['picurl']=get_monxin_path().'program/trip/img/'.$v['icon'];}
		}
		$i++;	
	}
	//file_put_contents('wx.txt',serialize($data));
	if($i==0){return '';}
	return $data;
}
