<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."bidding";

$where='';

if(isset($_GET['shop_id'])){
	$shop_id=intval($_GET['shop_id']);	
	if($shop_id>0){
		$where.=' and `shop_id`='.$shop_id;
		$sql2="select `name` from ".self::$table_pre."shop where `id`=".$shop_id;
		$r2=$pdo->query($sql2,2)->fetch(2);
		$shop_name=$r2['name'];
		echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=mall.bidding_detail">'.self::$language['pages']['mall.bidding_detail']['name'].'</a><span class=text>'.$shop_name.'</span></div>';
	}
}

if(isset($_GET['gid'])){
	$gid=intval($_GET['gid']);	
	if($gid>0){
		$where.=' and `gid`='.$gid;
		$sql2="select `title` from ".self::$table_pre."goods where `id`=".$gid;
		$r2=$pdo->query($sql2,2)->fetch(2);
		$goods_name=$r2['title'];
		echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=mall.bidding_detail">'.self::$language['pages']['mall.bidding_detail']['name'].'</a><span class=text>'.$goods_name.'</span></div>';
	}
}


$order=' order by `id` desc';

$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_bidding and","_bidding where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_bidding and","_bidding where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';


foreach($r as $v){
	$v=de_safe_str($v);
	$sql="select `title` from ".self::$table_pre."goods where `id`=".$v['gid'];
	$r2=$pdo->query($sql,2)->fetch(2);
	$goods_name=$r2['title'];
	$sql="select `name` from ".self::$table_pre."shop where `id`=".$v['shop_id'];
	$r2=$pdo->query($sql,2)->fetch(2);
	$shop_name=$r2['name'];
	if($v['username']!=''){
		$click_man=$v['username'];	
	}else{
		$click_man=self::$language['tourist'];
	}
	$list.="<tr >
	<td>".$click_man."</td>
	<td>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</td>
	<td><a href=./index.php?monxin=mall.goods&id=".$v['gid']." target=_blank class=goods_name>".$goods_name."</a></td>
	<td><a href=./index.php?monxin=".$v['src_url']." target=_blank class=src_title>".$v['src_title']."</a></td>
	<td>".$v['money']."</td>
	<td><a href=./index.php?monxin=mall.bidding_detail&shop_id=".$v['shop_id']." target=_blank>".$shop_name."</a></td>
	<td><a href=http://www.baidu.com/s?wd=".$v['ip']." target=_blank>".$v['ip']."</a></td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

$module['hot_search']=self::$config['hot_search'];
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);