<?php
if(!isset($_SESSION['monxin']['username']) && self::$config['unlogin_buy']==false){
	echo '<a href=./index.php?monxin=index.login style=" display:inline-block; width:30%; margin:auto; margin-left:35%; text-align:center; line-height:40px; margin-top:40px;background-color: #83c44e; color:#fff; border-radius:3px;">'.self::$language['please_login'].'</a>';
	exit('<script>window.location.href="./index.php?monxin=index.login&relaod="+ Math.round(Math.random()*100);</script>');
}

$module['bargain']='0';
$pre_sale=false;
$recommendation=false;
$_GET['quantity']=floatval(@$_GET['quantity']);
if($_GET['quantity']<0){$_GET['quantity']=1;}
if(isset($_GET['bargain_log'])){$_GET['quantity']=1;}

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['buy_method']=@$_GET['buy_method'];
$module['current_url']=get_url();
$temp=explode('mall.confirm_order',$module['current_url']);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&goods_src='.$_GET['goods_src'].'&bargain_log='.@$_GET['bargain_log'].'&'.$temp[1];


$module['use_web_credits_div']='';
if(isset($_SESSION['monxin']['username'])){
	$sql="select `credits` from ".$pdo->index_pre."user where `username`='".$_SESSION['monxin']['username']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['credits']!='' && $r['credits']>0){
		$module['use_web_credits_div']='<div class="credits use_web_credits_div">
					<span class=s><input type="checkbox"  />'.self::$language['use_web_credits'].'</span>
					<span class=m><input type="text" rate="'.self::$config['credits_set']['rate'].'" /><span>('.self::$language['available'].'<span class=vv>'.$r['credits'].'</span>)</span></span>
					<span class=e>-'.self::$language['money_symbol'].'<span>0.00</span></span>
				</div>';
	}
	
}



//█████████████████████████████████████████████████████████████████████ 是否显示下单验证码
if(!isset($_SESSION['monxin']['username']) && @$_GET['buy_method']!='unlogin'){$module['buy_method_div_display']='block';$module['confirm_order_div_display']='none';}else{$module['buy_method_div_display']='none';$module['confirm_order_div_display']='block';}
if(!isset($_SESSION['mall_buy_quantity'])){$_SESSION['mall_buy_quantity']=0;}
if($_SESSION['mall_buy_quantity']>3){$module['authcode']='display';}else{$module['authcode']='none';}

//█████████████████████████████████████████████████████████████████████ 读出收货地址 start
$module['receiver']='';

$module['receiver'].='<a href="#" class="option" id=receiver_-1 style="display:inline-block;vertical-align:top;" top_id="0">
                    	<div class=receiver_head><span class=name>'.self::$language['no_delivery'].'</span></div>
                        <div class=area_id>'.self::$language['take_self'].'</div>
                    </a>';

$module['show_more']='';
if(isset($_SESSION['monxin']['username'])){
	$sql="select * from ".self::$table_pre."receiver where `username`='".$_SESSION['monxin']['username']."' order by `sequence` desc";
	$r=$pdo->query($sql,2);
	$temp='';
	$i=0;
	foreach($r as $v){
		if($v['post_code']!=''){$v['post_code']='('.$v['post_code'].')';}
		if($v['tag']!=''){$v['tag']='<span class=tag ><span>'.$v['tag'].'</span></span>';}
		$temp.='<a href="#" class="option" id=receiver_'.$v['id'].' style="display:inline-block;vertical-align:top;" top_id="'.self::get_area_top_id($pdo,$v['area_id']).'" ids="'.get_area_parent_ids($pdo,$v['area_id']).'">
                    	<div class=receiver_head><span class=name>'.$v['name'].'</span>'.$v['tag'].'</div>
                        <div class=phone>'.$v['phone'].'</div>
                        <div class=area_id>'.get_area_name($pdo,$v['area_id']).'</div>
                        <div class=detail>'.$v['detail'].$v['post_code'].'</div>
						<div class=edit>'.self::$language['edit'].'</div>
                    </a>';	
		$i++;
	}	
	$module['receiver'].=$temp;
	
	if($i>3){
		$module['show_more']='<div id=show_more class=m_hide><a href="#">&nbsp;</a></div>';	
	}
	
}
//█████████████████████████████████████████████████████████████████████ 读出收货地址 end

//███████████████████████████████████████████████████████████████████ 处理商品来源 start
$ids='';
$goods_info=array();
$shops=array();
$goods_src=@$_GET['goods_src'];
$module['use_method_display']='block';
if($goods_src=='goods_id'){//▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃ 如是单项购买
	$id=intval(@$_GET['id']);
	$s_id=intval(@$_GET['s_id']);
	if(floatval(@$_GET['quantity'])<=0 ){$quantity=1;}else{$quantity=floatval($_GET['quantity']);}
	if($id==0){echo 'goods id err'; return false;}
	$sql="select `id`,`state`,`option_enable`,`shop_id`,`limit`,`limit_cycle` from ".self::$table_pre."goods where `id`='".$id."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){echo 'goods id err'; return false;}
	if($r['state']==0){echo '<div align="center" style="height:200px; line-height:200px;">'.self::$language['not_for_sale'].'</div>'; return false;}
	if($r['option_enable'] && $s_id==0){echo '<div align="center" style="height:200px; line-height:200px;">'.self::$language['please_select'].self::$language['goods_spec'].'</div>'; return false;}
	if(isset($_SESSION['monxin']['username'])){
		$sql="select `username` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
		$r2=$pdo->query($sql,2)->fetch(2);
		if($r2['username']==$_SESSION['monxin']['username']){ echo '<div align="center" style="height:200px; line-height:200px;">'.self::$language['can_not_buy_your_goods'].'</div>'; return false;}
	}
	
	$ids=$id;
	$goods_info['s_'.$id]=$s_id;		
	$goods_info['q_'.$id]=$quantity;	
	$ids2=$id.'_'.$s_id;
	//┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅ 限购检测并提示 start
	if($r['limit']!=0 && $r['limit_cycle']!=''){
		if($quantity>$r['limit']){echo '<div align="center" style="height:200px; line-height:200px;">'.str_replace('{number}',$r['limit'],self::$language['everyone_buy_limit']).'</div>'; return false;}
		
		if(!isset($_SESSION['monxin']['username'])){exit('<script>window.location.href="./index.php?monxin=index.login";</script>');}
		if($r['limit_cycle']=='d'){
			$start_time=get_unixtime(date('Y-m-d',time()),self::$config['other']['date_style']);
		}
		if($r['limit_cycle']=='m'){
			$start_time=get_unixtime(date('Y-m-d',time()-(86400*30)),self::$config['other']['date_style']);
		}
		if($r['limit_cycle']=='y'){
			$start_time=get_unixtime(date('Y-m-d',time()-(86400*3600)),self::$config['other']['date_style']);
		}
		
		if($start_time){
			if($r['limit']==1){
				$sql="select `id` from ".self::$table_pre."order_goods where `goods_id`=".$id." and `buyer`='".$_SESSION['monxin']['username']."' and `order_state`>0 and `time`>".$start_time." limit 0,1";
				$r2=$pdo->query($sql,2)->fetch(2);
				if($r2['id']!=''){echo '<div align="center" style="height:200px; line-height:200px;">'.self::$language['per'].self::$language[$r['limit_cycle']].str_replace('{number}',$r['limit'],self::$language['everyone_buy_limit']).'</div>'; return false;}
			}else{
				$sql="select count(`quantity`) as c from ".self::$table_pre."order_goods where `goods_id`=".$id." and `buyer`='".$_SESSION['monxin']['username']."' and `order_state`>0 and `time`>".$start_time." limit 0,10";
				$r2=$pdo->query($sql,2)->fetch(2);
				if($r2['c']>=$r['limit']){echo '<div align="center" style="height:200px; line-height:200px;">'.self::$language['per'].self::$language[$r['limit_cycle']].str_replace('{number}',$r['limit'],self::$language['everyone_buy_limit']).'</div>'; return false;}
			}
		}
		
	}
	//┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅ 限购检测并提示 end
	
		
	
	//=============================================================================================================砍价 start
	if(isset($_GET['bargain_log'])){
			//========================================== 获取商品原 网售价
			function get_goods_price($pdo,$goods_id){
				$sql="select `w_price`,`min_price`,`max_price`,`option_enable` from ".$pdo->sys_pre."mall_goods where `id`=".$goods_id;
				$r=$pdo->query($sql,2)->fetch();
				if($r['option_enable']==1){
					if($r['min_price']==$r['max_price']){
						$r['w_price']=$r['min_price'];
					}else{
						$r['w_price']=$r['min_price'].'-'.$r['max_price'];
					}
				}
				return $r['w_price'];
			}
			
		$bargain_log=intval($_GET['bargain_log']);
		$sql="select * from ".$pdo->sys_pre."bargain_log where `id`=".$bargain_log;
		$log=$pdo->query($sql,2)->fetch(2);
		if($log['id']!=''){
			if(($log['state']==1 || $log['state']==3) && $log['username']){
				$sql="select * from ".$pdo->sys_pre."bargain_goods where `id`=".$log['b_id'];
				$gb=$pdo->query($sql,2)->fetch(2);
				if($gb['id']!=''){
					if($log['state']==1){
						$module['bargain']=get_goods_price($pdo,$log['g_id'])-$log['money'];
					}else{
						$module['bargain']=$gb['final_price'];
					}
						
					
				}	

			}
		}
		//var_dump($bargain);
	}
	//=============================================================================================================砍价 end
	
	
		
}elseif($goods_src=='package_id'){//▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃ 如是套餐购买
	$module['use_method_display']='none';
	$id=intval(@$_GET['id']);
	if($id==0){echo 'package id err'; return false;}
	if(floatval(@$_GET['quantity'])<=0 ){$quantity=1;}else{$quantity=floatval($_GET['quantity']);}
	$sql="select * from ".self::$table_pre."package where `id`='".$id."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){echo 'package id err'; return false;}
	if(!($r['discount']>0)){echo self::$language['not_set'].self::$language['discount_rate']; return false;}
	$package_discount=$r['discount'];
	$free_shipping=$r['free_shipping'];
	if($r['goods_ids']==''){echo self::$language['not_set'].self::$language['goods']; return false;}
	$ids=$r['goods_ids'];
	$temp=explode(',',$ids);
	$ids2='';
	foreach($temp as $v){
		$goods_info['s_'.$v]=intval(@$_GET['g_'.$v]);		
		$goods_info['q_'.$v]=$quantity;	
		if(isset($_GET['g_'.$v]) && $_GET['g_'.$v]!='' && $_GET['g_'.$v]!=0){
			$ids2.=$v.'_'.intval($_GET['g_'.$v]).',';
		}else{
			$ids2.=$v.',';
		}
	}
}elseif($goods_src=='selected_goods'){//▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃ 如是购物车选中商品
	if(@$_COOKIE['selected_goods']==''){echo self::$language['at_least_to_select_a_commodity_to_settlement'];return false;}
	$temp=json_decode($_COOKIE['selected_goods'],true);
	$temp=self::array_sort($temp,'time',$type='desc');
	//var_dump($temp);
	$ids='';
	$ids2='';
	foreach($temp as $k=>$v){
		//if($v==''){continue;}
		$v2=explode('_',$k);
		$goods_info['s_'.$k]=intval(@$v2[1]);		
		if(floatval($v['quantity'])<=0 ){$quantity=1;}else{$quantity=floatval($v['quantity']);}
		$goods_info['q_'.$k]=$quantity;	
		$ids.=intval($v2[0]).',';
		$ids2.=$k.',';
	}
	
}else{echo 'goods_src null';return false;}

if($ids==''){echo 'goods id err';return false;}
//███████████████████████████████████████████████████████████████████ 处理商品来源 end


//███████████████████████████████████████████████████████████████████ 读取商品基本信息 start


$ids=trim($ids,',');
$sql="select `id`,`title`,`icon`,`w_price`,`unit`,`sales_promotion`,`option_enable`,`state`,`logistics_weight`,`logistics_volume`,`free_shipping`,`shop_id`,`discount`,`discount_start_time`,`discount_end_time`,`state`,`pre_discount`,`limit`,`limit_cycle`,`recommendation`,`inventory` from ".self::$table_pre."goods where `id` in (".$ids.")";
$r=$pdo->query($sql,2);
$module['goods_html']='';
$money_count=0;
$promotion_money=0;
$module['goods_item']=0;
$module['weight']=0;
$module['weight_all']=0;
$goods=array();

$alone_buy='';
//$ids='';

foreach($r as $v){
	
	//▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃ 移除限购，预售,推荐码，商品 start
	if($_GET['goods_src']!='goods_id' &&  $v['recommendation']==1){$alone_buy.='<a href="./index.php?monxin=mall.goods&id='.$v['id'].'">'.$v['title'].'</a><br />';continue;}
	if($v['limit']!=0 && $v['limit_cycle']!=''){
		if($quantity>$v['limit']){$alone_buy.='<a href="./index.php?monxin=mall.goods&id='.$v['id'].'">'.$v['title'].'</a><br />';continue;}
		if(!isset($_SESSION['monxin']['username'])){exit('<script>window.location.href="./index.php?monxin=index.login";</script>');}
		if($v['limit_cycle']=='d'){
			$start_time=get_unixtime(date('Y-m-d',time()),self::$config['other']['date_style']);
		}
		if($v['limit_cycle']=='m'){
			$start_time=get_unixtime(date('Y-m-d',time()-(86400*30)),self::$config['other']['date_style']);
		}
		if($v['limit_cycle']=='y'){
			$start_time=get_unixtime(date('Y-m-d',time()-(86400*3600)),self::$config['other']['date_style']);
		}
		if($start_time){
			if($v['limit']==1){
				$sql="select `id` from ".self::$table_pre."order_goods where `goods_id`=".$v['id']." and `buyer`='".$_SESSION['monxin']['username']."' and `order_state`>0 and `time`>".$start_time." limit 0,1";
				$v2=$pdo->query($sql,2)->fetch(2);
				if($v2['id']!=''){$alone_buy.='<a href="./index.php?monxin=mall.goods&id='.$v['id'].'">'.$v['title'].'</a><br />';continue;}
			}else{
				$sql="select count(`quantity`) as c from ".self::$table_pre."order_goods where `goods_id`=".$v['id']." and `buyer`='".$_SESSION['monxin']['username']."' and `order_state`>0 and `time`>".$start_time." limit 0,10";
				$v2=$pdo->query($sql,2)->fetch(2);
				if($v2['c']>=$v['limit']){$alone_buy.='<a href="./index.php?monxin=mall.goods&id='.$v['id'].'">'.$v['title'].'</a><br />';continue;}
			}
		}
	}
	if($v['state']!=2 && $goods_src!='goods_id'){$alone_buy.='<a href="./index.php?monxin=mall.goods&id='.$v['id'].'">'.$v['title'].'</a><br />';continue;}
	//▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃ 移除限购，预售，商品 end
	
	
	$goods[$v['id']]=de_safe_str($v);
	$goods[$v['id']]['icon']='img_thumb/'.$v['icon'];
	$goods[$v['id']]['shop_id']=$v['shop_id'];
	$goods[$v['id']]['discount']=$v['discount'];
	$goods[$v['id']]['state']=$v['state'];
	$goods[$v['id']]['sales_promotion']=$v['sales_promotion'];
	//▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃ 如是预售商品 start
	if($v['state']==1){
		$sql="select * from ".self::$table_pre."pre_sale where `goods_id`=".$v['id']." limit 0,1";
		$r2=$pdo->query($sql,2)->fetch(2);
		$goods[$v['id']]['deposit']=$r2['deposit'];
		$goods[$v['id']]['reduction']=$r2['reduction'];
		if(time()>$r2['last_pay_start_time']){
			$sql="update ".self::$table_pre."goods set `state`=2 where `id`=".$v['id'];
			$pdo->exec($sql);
			exit('<script>window.location.href = window.location.href+"?&relaod="+ Math.round(Math.random()*100);</script>');
		}
		$pre_sale=true;
	}
	//▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃ 如是预售商品  end
	
	$goods[$v['id']]['pre_discount']=$v['pre_discount'];
	$goods[$v['id']]['discount_start_time']=$v['discount_start_time'];
	$goods[$v['id']]['discount_end_time']=$v['discount_end_time'];
	$goods[$v['id']]['inventory']=$v['inventory'];
	if($v['recommendation']){$recommendation=true;}
	
	//var_dump($goods[$v['id']]);
}
//███████████████████████████████████████████████████████████████████ 读取商品基本信息 end



//███████████████████████████████████████████████████████████████████ 按店整理商品信息 start
//var_dump($sql);
$goods_keys=explode(',',$ids);
if($goods_src=='selected_goods' || $goods_src=='goods_id' || $goods_src=='package_id'){$goods_keys=explode(',',$ids2);}
$time=time();
$index=0;
foreach($goods_keys as $v){
	if($v=='' ){continue;}
	//echo $v.'<hr >';
	$temp2=explode('_',$v);
	$v2=$temp2[0];
	if(!isset($goods[$v2])){continue;}
	$key=$v;
	if($goods_src=='selected_goods'){
		$goods_info['s_'.$v2]=$goods_info['s_'.$v];
		$goods_info['q_'.$v2]=$goods_info['q_'.$v];
	}
	$v=$v2;
	if($goods[$v]['option_enable']){//如是有选项商品
		$sql="select * from ".self::$table_pre."goods_specifications where `id`='".$goods_info['s_'.$goods[$v]['id']]."' limit 0,1";
		$v2=$pdo->query($sql,2)->fetch(2);
		if($v2['id']==''){continue;}
		$goods[$v]['w_price']=$v2['w_price'];	
		if($v2['color_img']!=''){$goods[$v]['icon']='img/'.$v2['color_img'];}
		$goods[$v]['title']=$goods[$v]['title'];
		$goods[$v]['spec_info']=$v2['color_name'].' '.self::get_type_option_name($pdo,$v2['option_id']);
		if($goods_info['q_'.$v]>($v2['quantity']+self::get_big_inventory($pdo,$goods[$v]['id']))){
			$alone_buy.='<a href="./index.php?monxin=mall.goods&id='.$v.'">['.self::$language['low_stocks'].']'.$goods[$v]['title'].'</a><br />';continue;	
		}
		
	}else{//否则
		$goods[$v]['spec_info']='';
		if($goods_info['q_'.$v]>($goods[$v]['inventory']+self::get_big_inventory($pdo,$goods[$v]['id']))){
			$alone_buy.='<a href="./index.php?monxin=mall.goods&id='.$v.'">['.self::$language['low_stocks'].']'.$goods[$v]['title'].'</a><br />';continue;	
		}
		
	}
	if($goods_src=='package_id'){
		$price=sprintf("%.2f",$goods[$v]['w_price']*$package_discount/10);
	}else{
		$shop_discount=self::get_shop_discount($pdo,$goods[$v]['shop_id']);
		if($goods[$v]['discount']<10 && $time>$goods[$v]['discount_start_time'] && $time<$goods[$v]['discount_end_time']){$discount=$goods[$v]['discount'];$goods_discount=$goods[$v]['discount'];}else{$discount=$shop_discount;}
		if($discount<10 && ($goods[$v]['sales_promotion'] || $_SESSION['discount_all'])){$price=sprintf("%.2f",$goods[$v]['w_price']*$discount/10);}else{$price=$goods[$v]['w_price'];}
	}
	$favorable_price=$goods[$v]['w_price'];
	
	//▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃ 如店铺信息未初始化  start
	if(!isset($shops[$goods[$v]['shop_id']]['index'])){
		$shops[$goods[$v]['shop_id']]['index']=$index;$index++;
		$sql="select `name`,`domain`,`evaluation_0`,`evaluation_1`,`evaluation_2`,`express` from ".self::$table_pre."shop where `id`=".$goods[$v]['shop_id'];
		
		$r2=$pdo->query($sql,2)->fetch(2);
		$r2=de_safe_str($r2);
		if($r2['evaluation_2']==0 && $r2['evaluation_0']==0){
			$satisfaction=100;
		}elseif($r2['evaluation_2']==0 && $r2['evaluation_0']!=0){
			$satisfaction=0;
		}else{
			$satisfaction=intval($r2['evaluation_2']/($r2['evaluation_2']+$r2['evaluation_0'])*100);
		}
		$fulfil_preferential=self::get_fulfil_preferential_method($pdo,self::$table_pre,self::$language,$goods[$v]['shop_id']);
		
		$shops[$goods[$v]['shop_id']]['shop_info']="<div class=shop_info><span class=name_l>".self::$language['store2']."：</span><span class=name_v>".$r2['name']."</span><span class=satisfaction_l>".self::$language['satisfaction'].":</span><span class=satisfaction_v>".$satisfaction."%	</span><span class=fulfil_preferential>".$fulfil_preferential."</span></div>";
		$shops[$goods[$v]['shop_id']]['shop_goods']='';
		$shops[$goods[$v]['shop_id']]['express']='';
		$shops[$goods[$v]['shop_id']]['weight']=0;
		$shops[$goods[$v]['shop_id']]['all_money']=0;
		$shops[$goods[$v]['shop_id']]['promotion_money']=0;
		$r2['express']=trim($r2['express'],',');
		$sql="select * from ".self::$table_pre."express where `id` in (".$r2['express'].") order by `sequence` desc";
		if($r2['express']==''){
			$sql="select * from ".self::$table_pre."express order by `sequence` desc limit 0,1";	
		}
		
		
		$r=$pdo->query($sql,2);
		foreach($r as $e){
			$e['first_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$e['first_price']);
			$e['over_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$e['over_price']);
			
			$sql="select `area_id`,`first_price`,`continue_price` from ".self::$table_pre."express_price where `express_id`=".$e['id']." and `shop_id`=".$goods[$v]['shop_id'];
			$r2=$pdo->query($sql,2);
			$prices=array();
			foreach($r2 as $e2){
				$prices[$e2['area_id']]=array();
				$prices[$e2['area_id']]['f_p']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$e2['first_price']);	
				$prices[$e2['area_id']]['c_p']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$e2['continue_price']);	
			}
			
			$shops[$goods[$v]['shop_id']]['express'].='<option value="'.$e['id'].'" first_weight='.$e['first_weight'].' over_weight='.$e['over_weight'].' first_price='.$e['first_price'].' over_price='.$e['over_price'].' prices=\''.json_encode($prices).'\'>'.$e['name'].'</option>';
			
		}
	}
	//▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃ 如店铺信息未初始化  end
	
	
	
	$subtotal="<span class=v>".sprintf("%.2f",$price*$goods_info['q_'.$goods[$v]['id']])."</span>";
	if($goods[$v]['state'] == 1){
		//┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅ 如是预售商品 start
		$pre_price=$goods[$v]['w_price']*$goods[$v]['pre_discount']/10;
		$favorable_price=$pre_price;
		$price=$pre_price;
		$end_pay=($pre_price-$goods[$v]['reduction'])*$goods_info['q_'.$goods[$v]['id']];
		$reduction=($goods[$v]['reduction']-$goods[$v]['deposit'])*$goods_info['q_'.$goods[$v]['id']];
		
		$subtotal="<div class=deposit><span class=m_label>".self::$language['deposit2']."</span><span class=v>".sprintf("%.2f",$goods[$v]['deposit']*$goods_info['q_'.$goods[$v]['id']])."</span></div><div class=last_pay><span class=m_label>".self::$language['end_pay']."</span>".$end_pay."</div><div class=has_preferential><span class=m_label>".self::$language['has'].self::$language['preferential'].'</span>'.$reduction."</div>";
		
		$shops[$goods[$v]['shop_id']]['all_money']+=sprintf("%.2f",$goods[$v]['deposit']*$goods_info['q_'.$goods[$v]['id']]);
		$shops[$goods[$v]['shop_id']]['promotion_money']+=sprintf("%.2f",$goods[$v]['deposit']*$goods_info['q_'.$goods[$v]['id']]);
		$sales_promotion='<span class=sales_promotion>'.self::$language['sales_promotion_short'].'</span>';
	
		//┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅┅ 如是预售商品 end
		
	}else{
		//▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃ 如买家已登录 查询买家在店内的折扣 及积分倍数 start		
		if(isset($_SESSION['monxin']['username'])){
			if(!isset($_SESSION['monxin'][$goods[$v]['shop_id'].'_discount'])){
				$sql="select `group_id` from ".self::$table_pre."shop_buyer where `shop_id`=".$goods[$v]['shop_id']." and `username`='".$_SESSION['monxin']['username']."'  limit 0,1";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['group_id']=='' || $r['group_id']<1){
					$_SESSION['monxin'][$goods[$v]['shop_id'].'_shop_group']='';
					$_SESSION['monxin'][$goods[$v]['shop_id'].'_discount']=10;
					$_SESSION['monxin'][$goods[$v]['shop_id'].'_buy_credits_multiple']=1;
					$_SESSION['monxin'][$goods[$v]['shop_id'].'_group_id']=0;
				}else{
					$sql="select `name`,`discount`,`buy_credits_multiple`,`id` from ".self::$table_pre."shop_buyer_group where `id`=".$r['group_id']." and `shop_id`=".$goods[$v]['shop_id']." limit 0,1";
					$r=$pdo->query($sql,2)->fetch(2);
					$_SESSION['monxin'][$goods[$v]['shop_id'].'_shop_group']=$r['name'];
					$_SESSION['monxin'][$goods[$v]['shop_id'].'_discount']=$r['discount'];
					$_SESSION['monxin'][$goods[$v]['shop_id'].'_buy_credits_multiple']=$r['buy_credits_multiple'];	
					$_SESSION['monxin'][$goods[$v]['shop_id'].'_group_id']=$r['id'];
				}
					
			}
		}
		
		//---如是店内会员，并折扣大于 店铺限时折扣
		if(isset($_SESSION['monxin'][$goods[$v]['shop_id'].'_group_id'])){
			$sql="select `discount` from ".self::$table_pre."goods_group_discount where `goods_id`=".$goods[$v]['id']." and `group_id`=".$_SESSION['monxin'][$goods[$v]['shop_id'].'_group_id']." limit 0,1";
			$ggd=$pdo->query($sql,2)->fetch(2);
			if($ggd['discount']){
				$goods_group_discount=$ggd['discount'];
			}else{
				$goods_group_discount=100;	
			}
		}
		if(isset($_SESSION['monxin'][$goods[$v]['shop_id'].'_discount']) and ($_SESSION['monxin'][$goods[$v]['shop_id'].'_discount']<10 || $goods_group_discount < 10)  and ($_SESSION['monxin'][$goods[$v]['shop_id'].'_discount'] < $discount || $goods_group_discount < $discount) and $goods[$v]['sales_promotion']){
			if($goods_group_discount==100){
				$goods_group_discount=$_SESSION['monxin'][$goods[$v]['shop_id'].'_discount'];
			}
			$favorable_price=$goods[$v]['w_price']*$goods_group_discount/10;	
		}		
		//▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃ 如买家已登录 查询买家在店内的折扣 及积分倍数 end
		
		
		$shops[$goods[$v]['shop_id']]['all_money']+=$price*$goods_info['q_'.$goods[$v]['id']];
		if($goods[$v]['sales_promotion']){
			$shops[$goods[$v]['shop_id']]['promotion_money']+=$price*$goods_info['q_'.$goods[$v]['id']];
			$sales_promotion='<span class=sales_promotion>'.self::$language['sales_promotion_short'].'</span>';
		}else{
			$sales_promotion='';
		}
	}
	
	$price=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$price);
	$favorable_price=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$favorable_price);
	
	if($_COOKIE['monxin_device']=='pc'){//电脑版 html
		$shops[$goods[$v]['shop_id']]['shop_goods'].="
	<div class=tr goods_id=".$key." quantity=".$goods_info['q_'.$goods[$v]['id']].">
			<div class=goods_td>
			<a class=goods_info href=./index.php?monxin=mall.goods&id=".$goods[$v]['id']." target=_blank><img src='./program/mall/".$goods[$v]['icon']."' /><div class=title_model><div class=title>".$goods[$v]['title']."</div><div class=model>".$goods[$v]['spec_info']."</div></div></a>
			</div><div class=unit_price_td>
			<span class=price>".$price."</span>".$sales_promotion."
			<span class=favorable_price>".$favorable_price."</span>
			</div><div class=quantity_td>".$goods_info['q_'.$goods[$v]['id']]." <span class=unit>".self::get_mall_unit_name($pdo,$goods[$v]['unit'])."</span></div><div class=subtotal_td>".$subtotal."</div>
		</div>
	";
	}else{//手机版 html
		$shops[$goods[$v]['shop_id']]['shop_goods'].="
	<div class=tr goods_id=".$key." quantity=".$goods_info['q_'.$goods[$v]['id']].">
			<div class=goods_td>
			<a class=goods_info href=./index.php?monxin=mall.goods&id=".$goods[$v]['id']." target=_blank><img src='./program/mall/".$goods[$v]['icon']."' /><div class=title_model><div class=g_title>".$goods[$v]['title']."</div><div class=model>".$goods[$v]['spec_info']."</div>
				<div class=unit_price_td>
				<span class=price>".$price."</span>".$sales_promotion."
				<span class=favorable_price>".$favorable_price."</span>
				</div><div class=quantity_td>".$goods_info['q_'.$goods[$v]['id']]." <span class=unit>".self::get_mall_unit_name($pdo,$goods[$v]['unit'])."</span></div>
			</div>
			</a>
			</div><div class=subtotal_td>".$subtotal."</div>
		</div>
	";
	}


	$weight_a=0;
	$weight_b=0;
	if($goods[$v]['logistics_volume']>0){$weight_a=$goods[$v]['logistics_volume']/self::$config['volume_rate'];}
	if($goods[$v]['logistics_weight']){$weight_b=$goods[$v]['logistics_weight'];}
	if($goods_src=='package_id'){$goods[$v]['free_shipping']=$free_shipping;}
	if($goods[$v]['free_shipping']==0){
	
		$shops[$goods[$v]['shop_id']]['weight']+=max($weight_a,$weight_b)*$goods_info['q_'.$goods[$v]['id']];
		//echo $shops[$goods[$v]['shop_id']]['weight'].'<br />';
	}

}


//███████████████████████████████████████████████████████████████████ 按店整理商品信息 end
$module['alone_buy']=$alone_buy;
	

//███████████████████████████████████████████████████████████████████ 整理 .shop_div start
$shops=self::array_sort($shops,'index',$type='asc');
$module['goods_html']='';
foreach($shops as $k=>$v){
	if($pre_sale){
		$full_pre='0';
	}else{
		$full_pre=self::get_fulfil_preferential($pdo,self::$table_pre,$shops[$k]['promotion_money'],$shops[$k]['all_money'],$k);
		
		if($full_pre==='free_shipping'){$full_pre=self::$language['free_shipping'];}else{
			$full_pre=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$full_pre);
			$full_pre='-'.$full_pre;
		}
	}

	$module['preferential_way_option']='<option value="2" selected>'.self::$language['preferential_way_option'][2].'</option><option value="4">'.self::$language['preferential_way_option'][4].'</option><option value="7">'.self::$language['preferential_way_option'][7].'</option>';
	$red_coupon=array();
	$red_coupon['amount']=0;
	$red_coupon['id']=0;
	$use_shop_credits_div='';
	if(isset($_SESSION['monxin']['username'])){
		$temp=self::get_red_coupon($pdo,self::$table_pre,$shops[$k]['promotion_money'],$shops[$k]['all_money'],$k);
		if($temp!==false){$red_coupon=$temp;$module['preferential_way_option'].='<option value="3">'.self::$language['preferential_way_option'][3].'</option>';}
		$sql="select `credits` from ".self::$table_pre."shop_buyer where `username`='".$_SESSION['monxin']['username']."' and `shop_id`=".$k." limit 0,1";
		$buyer=$pdo->query($sql,2)->fetch(2);
		if($buyer['credits']!='' && $buyer['credits']>0){
			$sql="select `credits_rate` from ".self::$table_pre."shop_order_set where `shop_id`=".$k." limit 0,1";
			$order_set=$pdo->query($sql,2)->fetch(2);
			$use_shop_credits_div='<div class="credits use_shop_credits_div">
                    	<span class=s><input type="checkbox"  />'.self::$language['use_shop_credits'].'</span>
                    	<span class=m><input type="text" rate="'.$order_set['credits_rate'].'"  /><span>('.self::$language['available'].'<span class=vv>'.$buyer['credits'].'</span>)</span></span>
                    	<span class=e>-'.self::$language['money_symbol'].'<span>0.00</span></span>
                    </div>';
		}
		
	}
	
	if(isset($_SESSION['monxin'][$k.'_discount']) && $_SESSION['monxin'][$k.'_shop_group']!=''){
		$module['preferential_way_option'].='<option value="5">'.$_SESSION['monxin'][$k.'_shop_group'].self::$language['rebate'].'</option>';	
	}else{
		$shops[$k]['shop_goods']=preg_replace("#(<span class=favorable_price>.*</span>)#iU",'',$shops[$k]['shop_goods']);
		$shops[$k]['shop_goods']=preg_replace("#(favorable_price='.*')#iU",'',$shops[$k]['shop_goods']);
	}
	if($recommendation){$module['preferential_way_option'].='<option value="6">'.self::$language['preferential_way_option'][6].'</option>';}
	if($pre_sale){$use_shop_credits_div='';}
	$shops[$k]['all_money']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$shops[$k]['all_money']);
	$shops[$k]['promotion_money']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$shops[$k]['promotion_money']);
	$red_coupon['amount']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$red_coupon['amount']);
	
	$module['goods_html'].="<div class=shop_div id=shop_".$k." red_coupon_amount='-".$red_coupon['amount']."' red_coupon_id=".$red_coupon['id']." weight=".$shops[$k]['weight']." full_pre='".$full_pre."' promotion_money='".$shops[$k]['promotion_money']."' all_money='".$shops[$k]['all_money']."' >".$shops[$k]['shop_info']."
	<div class=shop_goods>".$shops[$k]['shop_goods']."</div>
	<div class=remark_other>
		<div class=remark><input type='text' placeholder='".self::$language['order_remark_placeholder']."' /></div><div class=other>
			<div class=express_company_div>".self::$language['express_company']."：<select class=express>".$shops[$k]['express']."</select><span class=v>*</span></div>
			<div class=preferential_way_div>".self::$language['use_method']."：<select class=preferential_way>".$module['preferential_way_option']."</select><span class=preferential_code_span><input type='text' class='preferential_code' placeholder=".self::$language['please_input']." /> <a href=#>".self::$language['check']."</a><span></span></span><span class=v>*</span></div>
			<div class=shop_money>".$use_shop_credits_div.self::$language['store2'].self::$language['subtotal']."<span class=sum>*</span></div>
		</div>
		
	</div>
	
	</div>";
}
//███████████████████████████████████████████████████████████████████ 整理 .shop_div end

$module['money']=$promotion_money;
$module['goods_money']=$money_count;
$module['weight_all']=ceil($module['weight_all']);
$module['weight']=ceil($module['weight']);
//if($module['attr_full_pre']=='free_shipping'){$module['weight']=0;}


//███████████████████████████████████████████████████████████████ 获取上一个订单的收货信息 start
if(isset($_SESSION['monxin']['username'])){
	$sql="select `receiver_id`,`delivery_time` from ".self::$table_pre."order where `buyer`='".$_SESSION['monxin']['username']."' order by `id` desc limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$module['receiver_id']=$r['receiver_id'];
	if($r['receiver_id']!=''){
		$sql="select `id` from ".self::$table_pre."receiver where `id`=".$r['receiver_id'];
		$r2=$pdo->query($sql,2)->fetch(2);
		if($r2['id']!=''){
			$module['receiver_id']=$r2['id'];
		}else{
			$sql="select `id` from ".self::$table_pre."receiver where `username`='".$_SESSION['monxin']['username']."' order by `id` desc limit 0,1";
			$r2=$pdo->query($sql,2)->fetch(2);
			$module['receiver_id']=$r2['id'];
		}
	}else{
		$sql="select `id` from ".self::$table_pre."receiver where `username`='".$_SESSION['monxin']['username']."' order by `id` desc limit 0,1";
		$r2=$pdo->query($sql,2)->fetch(2);
		$module['receiver_id']=$r2['id'];
	}
	
	$module['delivery_time']=$r['delivery_time'];
}else{
	$module['receiver_id']=0;
	$module['delivery_time']=0;
}
//███████████████████████████████████████████████████████████████ 获取上一个订单的收货信息 end

$module['delivery_time_list']='';
foreach(self::$language['delivery_time_info'] as $k=>$v){
	$module['delivery_time_list'].='<a href=# value='.$k.' >'.self::$language['delivery_time_info'][$k].'<br />'.self::$language['delivery_time_info2'][$k].'</a>';	
}




if($pre_sale){$module['pre_sale']=1;}else{$module['pre_sale']=0;}
if($pre_sale){$module['use_web_credits_div']='';}

$module['pay_mode']=self::$config['pay_mode'];



$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
echo '<div style="display:none;" id="visitor_position_append">'.self::$language['pages']['mall.confirm_order']['name'].'</div>';
