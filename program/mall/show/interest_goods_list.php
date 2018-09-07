<?php
if(!isset($_SESSION['monxin']['username'])){echo "<script>window.location.href='./index.php?monxin=index.login';</script>";return false;}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;

$owe=0;
$list='';
$module['credits_rate']=self::$config['credits_set']['rate'];


$sql="select `word_id` from ".self::$table_pre."interest_word_user where `username`='".$_SESSION['monxin']['username']."' order by `last_time` desc";
	$sum_sql=$sql;
	$sum_sql=str_replace(" `word_id` "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_interest_word_user and","_interest_word_user where",$sum_sql);
	$r=get_sql_cache(self::$config,$sum_sql);
	if(!$r){$r=$pdo->query($sum_sql,2)->fetch(2);set_sql_cache(self::$config,$sum_sql,$r);}
	$sum=$r['c'];

$sql=$sql.$limit;	
$sql=str_replace("_interest_word_user and","_interest_word_user where",$sql);
//echo $sql;
$r=get_sql_cache(self::$config,$sql);
if(!$r){$r=$pdo->query($sql,2);$sql_a_create=true;}else{$sql_a_create=false;}
$sql_cache_a=array();
$sql_a=$sql;

$i=1;
$time=time();
$goods_ids='0';
//$r=array(0=>array('word_id'=>5),1=>array('word_id'=>5),);
foreach($r as $v){
	$sql_cache_a[]=$v;
	$sql="select `name`,`type_id` from ".self::$table_pre."interest_word where `id`=".$v['word_id'];
	$v=$pdo->query($sql,2)->fetch(2);
	if($v['name']==''){continue;}
	$sql="select `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`satisfaction`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`shop_id`,`unit` from ".self::$table_pre."goods where `state`!=0 and `share`=0 and `mall_state`=1 and `online_forbid`=0 and (`title` like '%".$v['name']."%' or type=".$v['type_id']." ) and `id` not in (".$goods_ids.") order by `monthly` desc,`sold` desc limit 0,".(1+$owe);
	/////echo $sql.'<br />';	
	$r2=get_sql_cache(self::$config,$sql);
	if(!$r2){$r2=$pdo->query($sql,2);$sql_b_create=true;}else{$sql_b_create=false;}
	$sql_cache_b=array();
	$sql_b=$sql;
	$i2=0;
	//var_dump($r2);
	foreach($r2 as $v){
		
		$goods_ids.=','.$v['id'];
		$sql_cache_b[]=$v;
		$shop_discount=self::get_shop_discount($pdo,$v['shop_id']);
	
		$v=de_safe_str($v);
		if($v['discount']<10 && $time>$v['discount_start_time'] && $time<$v['discount_end_time']){
			$discount=$v['discount'];$goods_discount=$v['discount'];
		}else{
			if($_POST['discount_join_goods'] || $v['sales_promotion']){$discount=$shop_discount;}else{$discount=10;}
		}
		if(($shop_discount<10  && ($_POST['discount_join_goods'] || $v['sales_promotion'])) || isset($goods_discount)){
			if($v['option_enable']==0){
				$v['w_price']=sprintf("%.2f",$v['w_price']*$discount/10);
			}else{
				$v['min_price']=sprintf("%.2f",$v['min_price']*$discount/10);
				$v['max_price']=sprintf("%.2f",$v['max_price']*$discount/10);
			}
		}
		
		if($v['option_enable']==0){
			$v['w_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['w_price']);
			$w_price='<span class=money_value>'.$v['w_price'].'<span class=money_symbol>'.self::$language['yuan'].'</span></span>';
		}else{
			if($v['min_price']==$v['max_price']){
				$v['min_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['min_price']);
				$w_price='<span class=money_value>'.$v['min_price'].'<span class=money_symbol>'.self::$language['yuan'].'</span></span>';
			}else{
				$v['min_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['min_price']);
				$v['max_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['max_price']);
				$w_price='<span class=money_value>'.$v['min_price'].'-'.$v['max_price'].'<span class=money_symbol>'.self::$language['yuan'].'</span></span>';
			}
		}
		
		$list.="<div class=goods id=g_".$v['id']."><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank class=goods_a><img src='./program/mall/img_thumb/".$v['icon']."' /><span class=title>".$v['title']."</span><span class=price_span>".$w_price."/".self::get_mall_unit_name($pdo,$v['unit'])."</span></a></div>";
		$i2++;
		if($i2>1){$owe--;}
	}
	////////echo $i2.'<hr />';
	if($sql_b_create){set_sql_cache(self::$config,$sql_b,$sql_cache_b);}
	
	$i++;
	$owe+=max(0,1-$i2);
}
if($sql_a_create){set_sql_cache(self::$config,$sql_a,$sql_cache_a);}

//=======================================================================================================================================补缺 start
if($owe>0){
	$sql="select `word_id` from ".self::$table_pre."interest_word_user where `username`='".$_SESSION['monxin']['username']."' order by `last_time` desc";
	$sql=$sql.$limit;	
	$sql=str_replace("_interest_word_user and","_interest_word_user where",$sql);
	//echo $sql;
	$r=get_sql_cache(self::$config,$sql);
	if(!$r){$r=$pdo->query($sql,2);$sql_a_create=true;}else{$sql_a_create=false;}
	$sql_cache_a=array();
	$sql_a=$sql;
	
	$i=1;
	//$r=array(0=>array('word_id'=>5),1=>array('word_id'=>5),);
	foreach($r as $v){
		if($owe<1){break;}
		$sql_cache_a[]=$v;
		$sql="select `name`,`type_id` from ".self::$table_pre."interest_word where `id`=".$v['word_id'];
		$v=$pdo->query($sql,2)->fetch(2);
		if($v['name']==''){continue;}
		$sql="select `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`satisfaction`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`shop_id`,`unit` from ".self::$table_pre."goods where (`title` like '%".$v['name']."%' or type=".$v['type_id']." ) and `id` not in (".$goods_ids.") order by `monthly` desc,`sold` desc limit 0,".(1+$owe);
		/////echo $sql.'<br />';	
		$r2=get_sql_cache(self::$config,$sql);
		if(!$r2){$r2=$pdo->query($sql,2);$sql_b_create=true;}else{$sql_b_create=false;}
		$sql_cache_b=array();
		$sql_b=$sql;
		$i2=0;
		//var_dump($r2);
		foreach($r2 as $v){
			if($owe<1){break;}
			$goods_ids.=','.$v['id'];
			$sql_cache_b[]=$v;
			$shop_discount=self::get_shop_discount($pdo,$v['shop_id']);
		
			$v=de_safe_str($v);
			if($v['discount']<10 && $time>$v['discount_start_time'] && $time<$v['discount_end_time']){
				$discount=$v['discount'];$goods_discount=$v['discount'];
			}else{
				if($_POST['discount_join_goods'] || $v['sales_promotion']){$discount=$shop_discount;}else{$discount=10;}
			}
			if(($shop_discount<10  && ($_POST['discount_join_goods'] || $v['sales_promotion'])) || isset($goods_discount)){
				if($v['option_enable']==0){
					$v['w_price']=sprintf("%.2f",$v['w_price']*$discount/10);
				}else{
					$v['min_price']=sprintf("%.2f",$v['min_price']*$discount/10);
					$v['max_price']=sprintf("%.2f",$v['max_price']*$discount/10);
				}
			}
			
			if($v['option_enable']==0){
				$v['w_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['w_price']);
				$w_price='<span class=money_value>'.$v['w_price'].'<span class=money_symbol>'.self::$language['yuan'].'</span></span>';
			}else{
				if($v['min_price']==$v['max_price']){
					$v['min_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['min_price']);
					$w_price='<span class=money_value>'.$v['min_price'].'<span class=money_symbol>'.self::$language['yuan'].'</span></span>';
				}else{
					$v['min_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['min_price']);
					$v['max_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['max_price']);
					$w_price='<span class=money_value>'.$v['min_price'].'-'.$v['max_price'].'<span class=money_symbol>'.self::$language['yuan'].'</span></span>';
				}
			}
				
			$list.="<div class=goods id=g_".$v['id']."><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank class=goods_a><img src='./program/mall/img_thumb/".$v['icon']."' /><span class=title>".$v['title']."</span><span class=price_span>".$w_price."/".self::get_mall_unit_name($pdo,$v['unit'])."</span></a></div>";
			$i2++;
			$owe--;
		}
		////////echo $i2.'<hr />';
		if($sql_b_create){set_sql_cache(self::$config,$sql_b,$sql_cache_b);}
	}
	if($sql_a_create){set_sql_cache(self::$config,$sql_a,$sql_cache_a);}
	
	
}
//=======================================================================================================================================补缺 end

if($sum==0){
	$list='<div align="center"><span class=no_related_content_span>'.self::$language['can_not_guess'].'</span></div>';
}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
echo '<div style="display:none;" id="visitor_position_append">'.self::$language['pages']['mall.interest_goods_list']['name'].'</div>';