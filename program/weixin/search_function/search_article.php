<?php
function search_article($account,$pdo,$language,$key,$openid){
	if($openid==''){$openid=@$_GET['openid'];}
	$sql="select `title`,`id`,`src` from ".$pdo->sys_pre."article_article where (`title` like '%".$key."%' or `content` like '%".$key."%') and `visible`=1 order by `sequence` desc,`visit` desc limit 0,8";
	$r=$pdo->query($sql,2);
	$data=array();
	$i=0;
	foreach($r as $v){
		if($i==7){
			$data[$i]['title']=$language['click_show_all'];
			$data[$i]['url']=get_monxin_path().'index.php?monxin=article.show_article_list&current_page=2&search='.urlencode($key);
			$data[$i]['picurl']='';
			break;
		}
		$data[$i]['title']=$v['title'];
		$data[$i]['url']=get_monxin_path().'index.php?monxin=article.show&id='.$v['id'];
		$data[$i]['picurl']='';
		if($v['src']!=''){$data[$i]['picurl']=get_monxin_path().'program/article/img_thumb/'.$v['src'];}
		if($i==0){
			$data[$i]['picurl']=get_monxin_path().'logo.png';	
			if($v['src']!=''){$data[$i]['picurl']=get_monxin_path().'program/article/img/'.$v['src'];}
		}
		$i++;	
	}
	if($i==0){return '';}
	return $data;
}
