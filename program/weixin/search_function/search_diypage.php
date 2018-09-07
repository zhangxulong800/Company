<?php
function search_diypage($account,$pdo,$language,$key,$openid){
	if($openid==''){$openid=@$_GET['openid'];}
	$sql="select `title`,`id` from ".$pdo->sys_pre."diypage_page where (`title` like '%".$key."%' or `content` like '%".$key."%') and `visible`=1 order by `sequence` desc,`visit` desc limit 0,8";
	$r=$pdo->query($sql,2);
	$data=array();
	$i=0;
	foreach($r as $v){
		if($i==7){
			$data[$i]['title']=$language['click_show_all'];
			$data[$i]['url']=get_monxin_path().'index.php?monxin=diypage.show_page_list&current_page=2&search='.urlencode($key);
			$data[$i]['picurl']='';
			break;
		}
		$data[$i]['title']=$v['title'];
		$data[$i]['url']=get_monxin_path().'index.php?monxin=diypage.show&id='.$v['id'];
		$data[$i]['picurl']='';
		if($i==0){
			$data[$i]['picurl']=get_monxin_path().'logo.png';	
		}
		$i++;	
	}
	if($i==0){return '';}
	return $data;
}
