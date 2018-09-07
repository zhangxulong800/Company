<?php
function search_image($account,$pdo,$language,$key,$openid){
	if($openid==''){$openid=@$_GET['openid'];}
	$sql="select `title`,`id`,`src`,`link` from ".$pdo->sys_pre."image_img where (`title` like '%".$key."%' or `content` like '%".$key."%') and `visible`=1 order by `sequence` desc,`visit` desc limit 0,8";
	$r=$pdo->query($sql,2);
	$data=array();
	$i=0;
	foreach($r as $v){
		if($i==7){
			$data[$i]['title']=$language['click_show_all'];
			$data[$i]['url']=get_monxin_path().'index.php?monxin=image.show_thumb&current_page=2&search='.urlencode($key);
			$data[$i]['picurl']='';
			break;
		}
		$data[$i]['title']=$v['title'];
		if($v['link']!=''){
			$data[$i]['url']=$v['link'];
		}else{
			$data[$i]['url']=get_monxin_path().'index.php?monxin=image.show&id='.$v['id'];
		}
		$data[$i]['picurl']='';
		if($v['src']!=''){$data[$i]['picurl']=get_monxin_path().'program/image/img_thumb/'.$v['src'];}
		if($i==0){
			$data[$i]['picurl']=get_monxin_path().'logo.png';	
			if($v['src']!=''){$data[$i]['picurl']=get_monxin_path().'program/image/img/'.$v['src'];}
		}
		$i++;	
	}
	if($i==0){return '';}
	return $data;
}
