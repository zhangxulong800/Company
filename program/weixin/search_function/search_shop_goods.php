<?php
function search_shop_goods($account,$pdo,$language,$key,$openid){
	if($openid==''){$openid=@$_GET['openid'];}
	$sql="select `title`,`id`,`icon` from ".$pdo->sys_pre."shop_goods where (`title` like '%".$key."%') and `state`=1 order by `sequence` desc,`monthly` desc limit 0,9";
	file_put_contents('wx.txt',$sql);
	//echo $sql;
	$r=$pdo->query($sql,2);
	$data=array();
	$i=0;
	foreach($r as $v){
		if($i==9){
			$data[$i]['title']=$language['click_show_all'];
			$data[$i]['url']=get_monxin_path().'index.php?monxin=shop.goods_list&current_page=2&search='.urlencode($key);
			$data[$i]['picurl']='';
			break;
		}
		$data[$i]['title']=$v['title'];
		$data[$i]['url']=get_monxin_path().'index.php?monxin=shop.goods&id='.$v['id'];
		$data[$i]['url']=get_monxin_path().'index.php?monxin=shop.goods&id='.$v['id'];
		$data[$i]['picurl']='';
		if($v['icon']!=''){$data[$i]['picurl']=get_monxin_path().'program/shop/img_thumb/'.$v['icon'];}
		if($i==0){
			$data[$i]['picurl']=get_monxin_path().'logo.png';	
			if($v['icon']!=''){$data[$i]['picurl']=get_monxin_path().'program/shop/img/'.$v['icon'];}
		}
		$i++;	
	}
	if($i==0){return '';}
	return $data;
}
