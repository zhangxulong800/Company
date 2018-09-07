<?php
//======================================================================================================= 获取 平台商品分类 上级ID
	function get_type_ids($pdo,$id){
		$sql="select `id` from ".$pdo->sys_pre."mall_type where `parent`=$id";
		$r=$pdo->query($sql,2);
		$ids=$id.',';
		foreach($r as $v){
			$ids.=$v['id'].',';
			$sql2="select `id` from ".$pdo->sys_pre."mall_type where `parent`=".$v['id']."";
			$r2=$pdo->query($sql2,2);
			foreach($r2 as $v2){
				$ids.=$v2['id'].',';
				$sql3="select `id` from ".$pdo->sys_pre."mall_type where `parent`=".$v2['id']."";
				$r3=$pdo->query($sql3,2);
				foreach($r3 as $v3){
					$ids.=$v3['id'].',';
				}
			}
			
		}
		return trim($ids,',');
	}



function search_mall_goods($account,$pdo,$language,$key,$openid){
	if($openid==''){$openid=@$_GET['openid'];}
	
	$sql="select `id` from ".$pdo->sys_pre."mall_type where `visible`=1 and (`url`='' or `url` is null) and `name`='".$key."' order by `parent` asc,`sequence` desc limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']=='' && strlen($key)>5){
		$sql="select `id` from ".$pdo->sys_pre."mall_type where `visible`=1 and (`url`='' or `url` is null) and  `name` like '%".$key."%' order by `parent` asc,`sequence` desc  limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
	}
	if($r['id']!=''){
		$type_ids=get_type_ids($pdo,$r['id']);
		$sql="select `title`,`id`,`icon` from ".$pdo->sys_pre."mall_goods where `type` in (".$type_ids.") and `state`=2 and `mall_state`=1 and `online_forbid`=0 order by `bidding_show` desc,`sequence` desc,`monthly` desc limit 0,8";
		
	}else{
		$sql="select `title`,`id`,`icon` from ".$pdo->sys_pre."mall_goods where (`title` like '%".$key."%') and `state`=2 and `mall_state`=1 and `online_forbid`=0 order by `bidding_show` desc,`sequence` desc,`monthly` desc limit 0,8";
	
	}
	
	
	
	//echo $sql;
	$r=$pdo->query($sql,2);
	$data=array();
	$i=0;
	foreach($r as $v){
		if($i==7){
			$data[$i]['title']=$language['click_show_all'];
			$data[$i]['url']=get_monxin_path().'index.php?monxin=mall.goods_list&current_page=2&search='.urlencode($key);
			$data[$i]['picurl']='';
			break;
		}
		$data[$i]['title']=$v['title'];
		$data[$i]['url']=get_monxin_path().'index.php?monxin=mall.goods&id='.$v['id'];
		$data[$i]['url']=get_monxin_path().'index.php?monxin=mall.goods&id='.$v['id'];
		$data[$i]['picurl']='';
		if($v['icon']!=''){$data[$i]['picurl']=get_monxin_path().'program/mall/img_thumb/'.$v['icon'];}
		if($i==0){
			$data[$i]['picurl']=get_monxin_path().'logo.png';	
			if($v['icon']!=''){$data[$i]['picurl']=get_monxin_path().'program/mall/img/'.$v['icon'];}
		}
		$i++;	
	}
	//file_put_contents('wx.txt',serialize($data));
	if($i==0){return '';}
	return $data;
}
