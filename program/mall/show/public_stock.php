<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$ps_id=intval(@$_GET['ps_id']);
$goods_id=intval(@$_GET['goods_id']);

if($goods_id!=0){
	$act=@$_GET['act'];
	$allow=array('big','small');
	if(!in_array($act,$allow)){echo 'act err';return false;}	
	
	if($ps_id==0){
		if($act=='big'){
			$sql="insert into ".self::$table_pre."public_stock (`shop_id`,`big`,`small`,`quantity`) values ('".SHOP_ID."','".$goods_id."','0','0')";
			$pdo->exec($sql);
		}else{
			$sql="select `id` from ".self::$table_pre."public_stock where `small`='".$goods_id."' and `shop_id`=".SHOP_ID." limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']!=''){
				echo '<script>alert("'.self::$language['stock_small'].self::$language['already_exists'].'");</script>';
			}else{
				$sql="insert into ".self::$table_pre."public_stock (`shop_id`,`big`,`small`,`quantity`) values ('".SHOP_ID."','0','".$goods_id."','0')";
				$pdo->exec($sql);
			}
		}
	}else{
		$u_sql="update ".self::$table_pre."public_stock set `".$act."`='".$goods_id."' where `id`='".$ps_id."' and `shop_id`=".SHOP_ID;
		$sql="select * from ".self::$table_pre."public_stock where `id`='".$ps_id."' and `shop_id`=".SHOP_ID;
		$r=$pdo->query($sql,2)->fetch(2);
		if($act=='big'){
			if($r['small']==$goods_id){echo '<script>alert("'.self::$language['stock_big'].self::$language['stock_small'].self::$language['can_not_be_same'].'");</script>';$u_sql='';}
		}else{
			if($r['big']==$goods_id){echo '<script>alert("'.self::$language['stock_big'].self::$language['stock_small'].self::$language['can_not_be_same'].'");</script>';$u_sql='';}
		}
		if($u_sql!=''){$pdo->exec($u_sql);}
		
	}
}


$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."public_stock where `shop_id`=".SHOP_ID;

$where="";

$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_public_stock and","_public_stock where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_public_stock and","_public_stock where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';

foreach($r as $v){
	$big=array();
	$small=array();
	if($v['big']!=0){
		$sql="select `title`,`icon`,`id` from ".self::$table_pre."goods where `id`=".$v['big']." and `shop_id`=".SHOP_ID;
		$big=$pdo->query($sql,2)->fetch(2);
	}else{
		$big['icon']='default.png';
		$big['title']=self::$language['no_set'];
	}
	
	if($v['small']!=0){
		$sql="select `title`,`icon`,`id` from ".self::$table_pre."goods where `id`=".$v['small']." and `shop_id`=".SHOP_ID;
		$small=$pdo->query($sql,2)->fetch(2);
	}else{
		$small['icon']='default.png';
		$small['title']=self::$language['no_set'];
	}
	
	
	$list.='<div class="p_group" id="p_'.$v['id'].'">
        	<a class=stock_big href="./index.php?monxin=mall.goods&id='.$v['big'].'" target="_blank"><i>1'.self::$language['stock_big'].'<b href=./index.php?monxin=mall.goods_admin&act=stock_big&ps_id='.$v['id'].'>'.self::$language['set'].'</b></i><img src=./program/mall/img_thumb/'.$big['icon'].' /><span>'.$big['title'].'</span></a>
            <div class=equal ></div><input type="text" class=quantity value="'.$v['quantity'].'" />
        	<a class=stock_small href="./index.php?monxin=mall.goods&id='.$v['small'].'" target="_blank"><i>'.self::$language['stock_small'].'<b href=./index.php?monxin=mall.goods_admin&act=stock_small&ps_id='.$v['id'].'>'.self::$language['set'].'</b></i><img src=./program/mall/img_thumb/'.$small['icon'].' /><span>'.$small['title'].'</span><b class=del>'.self::$language['del'].'</b></a>            
        </div>';	
}
$module['list']=$list;
if($_GET['current_page']==1){$module['list']='<div class="p_group">
        	<a class=stock_big href=#><i>1'.self::$language['stock_big'].'<b href=./index.php?monxin=mall.goods_admin&act=stock_big&ps_id=0>'.self::$language['set'].'</b></i><img src=./program/mall/img/default.png /><span>'.self::$language['no_set'].'</span></a>
            <div class=equal ></div><input type="text" class=quantity />
        	<a class=stock_small href=#><i>'.self::$language['stock_small'].'<b href=./index.php?monxin=mall.goods_admin&act=stock_small&ps_id=0>'.self::$language['set'].'</b></i><img src=./program/mall/img/default.png /><span>'.self::$language['no_set'].'</span></a>            
        </div>'.$module['list'];}
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);



$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
