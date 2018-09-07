<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;


$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select `coupon_id` from ".self::$table_pre."my_coupon where `username`='".$_SESSION['monxin']['username']."' and `use_time`=0 order by `id` desc limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql="select count(id) as c  from ".self::$table_pre."my_coupon where `username`='".$_SESSION['monxin']['username']."' and `use_time`=0";
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$r=$pdo->query($sql,2);
$list='';
$goods_ids='';
foreach($r as $v){
	
	$sql="select * from ".self::$table_pre."coupon where `id`=".$v['coupon_id'];
	$r2=$pdo->query($sql,2)->fetch(2);
	if($r2['id']==''){continue;}
	if($r2['end_time']<time()){continue;}
	
	$sql="select `id`,`icon`,`min_price` from ".self::$table_pre."goods where `shop_id`=".$r2['shop_id']." order by `monthly` desc limit 0,3";
	if($goods_ids!=''){
		$sql="select `id`,`icon`,`min_price` from ".self::$table_pre."goods where `shop_id`=".$r2['shop_id']." and `id` not in (".trim($goods_ids,',').") order by `monthly` desc limit 0,3";
	}
	$r3=$pdo->query($sql,2);
	$goods='';
	foreach($r3 as $v3){
		$goods_ids.=$v3['id'].',';		
		$goods.='<a href="./index.php?monxin=mall.goods&id='.$v3['id'].'" target="_blank"><img src="./program/mall/img_thumb/'.$v3['icon'].'"><span class=price>'.$v3['min_price'].'</span></a>';	
	}
	if($r2['join_goods']==0){$join_goods=self::$language['shop_whole'].self::$language['join_goods_front'][0];}
	if($r2['join_goods']==1){$join_goods=self::$language['join_goods_front'][1].self::$language['general'];}
	if($r2['join_goods']==2){$join_goods=self::$language['shop_whole'].self::$language['join_goods_front'][2];}
	
	$list.='<div class=coupon d_id='.$v['coupon_id'].'>
            	<div class=info>
                	<div class=i_head>
                    	<span class=amount>¥<span class="v">'.$r2['amount'].'</span></span><span class="join_goods">'.$join_goods.'</span>
                    </div>
                    <div class="i_body">
                    	<div class=shop_name><span class=m_label>'.self::$language['distribution_shop'].'：</span><span class=m_value><a href="./index.php?monxin=mall.shop_index&shop_id='.$r2['shop_id'].'" target=_blank>'.$r2['shop_name'].'</a></span></div>
                    	<div class=shop_name><span class=m_label>'.self::$language['condition_of_use'].'：</span><span class=m_value>'.self::$language['full'].$r2['min_money'].self::$language['yuan'].'</span></div>
                    	<div class=shop_name><span class=m_label>'.self::$language['effective_time'].'：</span><span class=m_value>'.date('Y-m-d',$r2['start_time']).' '.self::$language['to'].' '.date('Y-m-d',$r2['end_time']).'</span></div>
                    </div>
                </div>
                <div class=goods>'.$goods.'</div>
                <div class=act><a href="./index.php?monxin=mall.shop_index&shop_id='.$r2['shop_id'].'"  target="_blank" class=go_shop></a><a href="#" class=del></a></div>
            </div>';
	
}
if($sum==0){$list='<div align="center"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></div>';}		
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);






$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
