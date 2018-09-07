<?php
	$sql="select `template`,`".$_COOKIE['monxin_device']."_menu`,`phone_menu_show`,`name`,`state` from ".self::$table_pre."shop where `id`=".SHOP_ID;
	$r=$pdo->query($sql,2)->fetch(2);
	self::$config['shop_template']=$r['template'];	
	self::$config['shop_'.$_COOKIE['monxin_device'].'_menu']=$r[$_COOKIE['monxin_device'].'_menu'];	
	self::$config['shop_name']=$r['name'];	


self::collect_interest($pdo);
$_GET['id']=intval(@$_GET['id']);
$id=intval(@$_GET['id']);
if($id==0){return not_find();}

//===========================================================================================================================砍价
$g_l=require('./program/gbuy/language/chinese_simplified.php');
$sql="select * from ".$pdo->sys_pre."gbuy_goods where `g_id`=".$id." limit 0,1";
$module['data']=$pdo->query($sql,2)->fetch(2);
$gb=$module['data'];
if($module['data']['id']==''){echo 'id err';return false;}
$bargin=$module['data'];
if($bargin['state']!=1){exit("<script>alert('".$g_l['goods_state_option'][$bargin['state']]."');window.location.href='./index.php?monxin=gbuy.list';</script>");}
if($bargin['start_time']>time()){exit("<script>alert('".$g_l['gbuy_no_start']."');window.location.href='./index.php?monxin=gbuy.list';</script>");}
if($bargin['end_time']+$bargin['hour']*3600<time()){exit("<script>alert('".$g_l['gbuy_end']."');window.location.href='./index.php?monxin=gbuy.list';</script>");}




$sql="select * from ".$pdo->sys_pre."gbuy_group where `g_id`=".$gb['g_id']." and `state`=1 order by `id` desc limit 0,10";
$g=$pdo->query($sql,2);
$module['group_list']='';
foreach($g as $v){
	$sql="select `icon` from ".$pdo->index_pre."user where `username`='".$v['username']."' limit 0,1";
	$u=$pdo->query($sql,2)->fetch(2);
	if(!is_url($u['icon'])){
		if($u['icon']==''){$u['icon']='default.png';}
		$u['icon']="./program/index/user_icon/".$u['icon'];
	}
	$remain_order=str_replace('{v}',($gb['number']-$v['quantity']),$g_l['remain_order']);
	
	$module['group_list'].="<div class=or><span class=icon_s><img src=".$u['icon']." /></span><span class=name_s>".$v['username']."</span><span class=remain><div class=remain_order>".$remain_order."</div><div class=remain_time><span class=time_limit remain=".(($v['start']+($gb['hour']*3600))-time())."></span></div></span><span class=act_s><a href=index.php?monxin=gbuy.detail&group=".$v['id'].">".$g_l['go_gbuy']."</a></span></div>";
}	

self::$language['close_gbuy_time']=$g_l['close_gbuy_time'];
self::$language['she_gbuying']=$g_l['she_gbuying'];



$sql="select * from ".self::$table_pre."goods where `id`=".$id;
$module['data']=$pdo->query($sql,2)->fetch(2);
if($module['data']['id']==''){return not_find();}
if($module['data']['state']==0){echo '<script>alert("'.self::$language['goods_state'][0].'");window.location.href="index.php";</script>';return false;}
self::update_goods_monthly_id($pdo,$id);
if($module['data']['mall_state']!=1){
	if(!isset($_SESSION['monxin']['group_id'])){echo '<div style="text-align:center;line-height:100px;"><span style="border:#CCC 1px solid; padding:10px;">'.str_replace('{goods_state}',self::$language['mall_state'][$module['data']['mall_state']],self::$language['goods_check_notice']).'</span></div>';return false;}	
	
	if(in_array('mall.m_goods_admin',$_SESSION['monxin']['page']) || in_array('mall.goods_admin',$_SESSION['monxin']['page']) || in_array('mall.goods_db',$_SESSION['monxin']['page'])){
		echo '<div style="text-align:center;line-height:100px;"><span style="border:#CCC 1px solid; padding:10px;">'.str_replace('{goods_state}',self::$language['mall_state'][$module['data']['mall_state']],self::$language['goods_check_notice']).'</span></div>';
		
	}else{
		echo '<div style="text-align:center;line-height:100px;"><span style="border:#CCC 1px solid; padding:10px;">'.str_replace('{goods_state}',self::$language['mall_state'][$module['data']['mall_state']],self::$language['goods_check_notice']).'</span></div>';return false;;
	}
}


//========================================================================================================================处理拼团数据 start
if(!isset($_GET['gid'])){header('location:./index.php');exit;}
$gid=intval($_GET['gid']);
$sql="select * from ".$pdo->sys_pre."gbuy_goods where `id`=".$gid." limit 0,1";

$module['gdata']=$pdo->query($sql,2)->fetch(2);
$gb=$module['gdata'];
$module['gbuy_price']=$gb['price'];
if($module['gdata']['id']==''){echo 'id err';return false;}
$bargin=$module['gdata'];

if($bargin['start_time']>time()){exit("<script>alert('".self::$language['gbuy_no_start']."');window.location.href='./index.php?monxin=gbuy.list';</script>");}
if($bargin['end_time']<time()){exit("<script>alert('".self::$language['gbuy_end']."');window.location.href='./index.php?monxin=gbuy.list';</script>");}

$sql="update ".$pdo->sys_pre."gbuy_goods set `view`=`view`+1 where `id`=".$gid;
$pdo->exec($sql);


//========================================================================================================================处理拼团数据 end

$module['data']=de_safe_str($module['data']);
$_GET['type']=$module['data']['shop_type'];
//$module['parent']=$this->get_parent($pdo);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['module_save_name']=str_replace("::","_",$method.$args[1]);
$module['class_name']=self::$config['class_name'];
$module['count_url']="receive.php?target=".$method."&id=".$id;
$module['agency_count_url']='';
$module['agency_store']='';
if(self::$config['agency'] && isset($_GET['store_id'])){
	$module['agency_count_url']='$.get("./receive.php?target=agency::shop&act=visit&store_id='.$_GET['store_id'].'&goods_id='.$id.'");';
	$sql="select `icon`,`name`,`state`,`template` from ".$pdo->sys_pre."agency_store where `id`=".intval($_GET['store_id']);
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['state']==''){echo '<div style="line-height:5rem; text-align:center;">'.self::$language['not_exist'].'<br /><a href=./index.php>'.self::$language['go_home'].'</a></div>';return false;}
	if($r['state']==0){echo '<div style="line-height:5rem; text-align:center;">'.$r['name'].self::$language['the_store'].self::$language['store_closure'].'<br /><a href=./index.php>'.self::$language['go_home'].'</a></div>';return false;}
	$agency_config=require('./program/agency/config.php');
	$module['agency_store']='<style>'.file_get_contents('./templates/0/agency/'.$agency_config['program']['template_0'].'/'.$_COOKIE['monxin_device'].'/shop_style/'.$r['template'].'/main.css').'</style>';
	if($_COOKIE['monxin_device']=='pc'){
		$module['agency_store'].='<div id="agency_head">
    <div style="text-align:center;">
        <div class="default_value">
            <a class="s_logo" href="index.php?monxin=agency.shop&store_id='.$_GET['store_id'].'"><img src="program/agency/shop_icon/'.$r['icon'].'" /></a><span class="s_name">'.$r['name'].'</span><span class="s_name_postfix">'.self::$language['the_store'].'</span> 
        </div>
    </div>
</div>    
';	
	}else{
		$module['agency_store'].='
 <br /><div class="goods_store_info">
        <a class="s_logo" href="index.php?monxin=agency.shop&store_id='.$_GET['store_id'].'"><img src="program/agency/shop_icon/'.$r['icon'].'"></a><div class=info>
        	<div class=store_name><span class="s_name">'.$r['name'].'</span><span class="s_name_postfix">'.self::$language['the_store'].'</span> </div>
            <div class=buttons>
            	<a href="index.php?monxin=agency.shop&store_id='.$_GET['store_id'].'" class=goods_type>'.self::$language['view_all_goods'].'</a><a href=./index.php?monxin=agency.spread&store_id='.$_GET['store_id'].' class=qr_code>'.self::$language['qr_code'].'</a>
            </div>
        </div>
    </div>
';	
	}
		
}

$module['data']['thumb_list']='<a href="#"><img src="./program/mall/img_thumb/'.$module['data']['icon'].'" /></a>';
$module['data']['img_list']='<li class=swiper-slide><a href="#"><img src="./program/mall/img/'.$module['data']['icon'].'" /></a></li>';
$temp=explode('|',$module['data']['multi_angle_img']);
foreach($temp as $v){
	if($v==''){continue;}
	$module['data']['thumb_list'].='<a href="#"><img src="./program/mall/img_thumb/'.$v.'" /></a>';
	$module['data']['img_list'].='<li class=swiper-slide><a href="#"><img src="./program/mall/img/'.$v.'" /></a></li>';
}

$time=time();
$discount=10;
if($module['data']['discount']<10 && $time>$module['data']['discount_start_time'] && $time<$module['data']['discount_end_time']){
	$discount=$module['data']['discount'];
	$end_time=$module['data']['discount_end_time'];
}else{
	self::get_shop_discount($pdo,SHOP_ID);
	if($module['data']['sales_promotion'] || $_POST['discount_join_goods']){
		$sql="select * from ".self::$table_pre."discount where `shop_id`='".SHOP_ID."' and `end_time`>".$time;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){
			if($r['rate']>0 && $r['rate']<10){$discount=$r['rate'];$end_time=$r['end_time'];}
		}
	}
}

$module['transaction_progress']='';
if($module['data']['state']==1){
	$sql="select * from ".self::$table_pre."pre_sale where `goods_id`=".$module['data']['id']." limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$module['data']['deposit']=$r['deposit'];	
	$module['data']['reduction']=$r['reduction'];	
	$module['data']['last_pay_start_time']=date('Y-m-d',$r['last_pay_start_time']);
	$module['data']['last_pay_end_time']=date('Y-m-d',$r['last_pay_end_time']);	
	$module['data']['delivered']=date('Y-m-d',$r['delivered']);
	
	$left= remain_time(self::$language,$r['last_pay_start_time']-time());
	$last_pay=$module['data']['last_pay_start_time'].' ~ '.$module['data']['last_pay_end_time'];
	$module['transaction_progress']='<div class=transaction_progress>
	<span class="name">'.self::$language['transaction_progress'].'</span>
	<span class="order_step_1"><span class=start></span><span class=middle><div class=step>'.self::$language['order_step_1'].'</div><div class=remark>'.self::$language['left'].': '.$left.'</div></span><span class=end></span></span>
	<span class="order_step_2"><span class=start></span><span class=middle><div class=step>'.self::$language['order_step_2'].'</div><div class=remark>'.$last_pay.'</div></span><span class=end></span></span>
	<span class="order_step_3"><span class=start></span><span class=middle><div class=step>'.self::$language['order_step_3'].'</div></span><span class=end></span></span>
	<span class="order_step_4"><span class=start></span><span class=middle><div class=step>'.self::$language['order_step_4'].'</div><div class=remark>'.$module['data']['delivered'].'</div></span><span class=end></span></span>
	</div>';
}

if($module['data']['state']==3){
	$module['data']['out_delivered']='<div class=out_delivered><span class=m_label>'.self::$language['estimate'].self::$language['send_time'].': </span><span class=value>'.date('Y-m-d',$module['data']['out_delivered']).'</span></div>';
}else{
	$module['data']['out_delivered']='';
}

if(isset($_SESSION['monxin'][SHOP_ID.'_group_id'])){
	$sql="select `discount` from ".self::$table_pre."goods_group_discount where `goods_id`=".$id." and `group_id`=".$_SESSION['monxin'][SHOP_ID.'_group_id']." limit 0,1";
	$ggd=$pdo->query($sql,2)->fetch(2);
	if($ggd['discount']){
		$goods_group_discount=$ggd['discount'];
	}else{
		$goods_group_discount=100;	
	}
}



if($module['data']['option_enable']){
	//==================================================================================================================================【获取有规格商品价格】
	if($module['data']['state']==1){
			if($module['data']['min_price']==$module['data']['max_price']){
				$temp=sprintf("%.2f",$module['data']['min_price']*$module['data']['pre_discount']/10);
				$temp2=$module['data']['min_price'];
			}else{
				$temp=sprintf("%.2f",($module['data']['min_price']*$module['data']['pre_discount']/10)).'-'.sprintf("%.2f",($module['data']['max_price']*$module['data']['pre_discount']/10));
				$temp2=$module['data']['min_price'].'-'.$module['data']['max_price'];
			}
		$module['price_div_html']='<div id=pre_sale>
		<div class=old_price><span class=price_label>'.self::$language['price'].'</span><span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=value  old="'.$temp2.'">'.$temp2.'</span></div>
		<div class=pre_div>
			<div class=pre_price><span class=price_label>'.self::$language['pre_price'].'</span><span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=price_value old="'.$temp.'">'.$temp.'</span></div>
			<div class=pre_deposit><span class=price_label>'.self::$language['deposit2'].'</span><span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=deposit_value>'.$module['data']['deposit'].'</span><span class=reduction_div>'.self::$language['deposit2'].self::$language['reduce'].'<span class=reduction> '.self::$language['money_symbol'].$module['data']['reduction'].'</span></span><a href="#" class=pre_sale_rules>'.self::$language['pre_sale_rules'].'</a></div>
		</div>
		</div>';		
	}else{
		
		//---如是店内会员，并折扣大于 店铺限时折扣
		if(isset($_SESSION['monxin'][SHOP_ID.'_discount']) and ($_SESSION['monxin'][SHOP_ID.'_discount']<10 || $goods_group_discount<10) and ($_SESSION['monxin'][SHOP_ID.'_discount'] < $discount || $goods_group_discount< $discount)  and $module['data']['sales_promotion']){
			if($goods_group_discount==100){$goods_group_discount=$_SESSION['monxin'][SHOP_ID.'_discount'];}

			if($module['data']['min_price']==$module['data']['max_price']){
				$temp=sprintf("%.2f",$module['data']['min_price']* $goods_group_discount/10);
				$temp2=$module['data']['min_price'];
			}else{
				$temp=sprintf("%.2f",($module['data']['min_price']* $goods_group_discount/10)).'-'.sprintf("%.2f",($module['data']['max_price']* $goods_group_discount/10));
				$temp2=$module['data']['min_price'].'-'.$module['data']['max_price'];
			}
	
			$module['price_div_html']='<div id=have_discount>
								<div class=normal_price><span class=price_label>'.self::$language['normal_price'].'</span><span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=price_value>'.$temp2.'</span></div>
								<div class=discount_price><span class=price_label>'.$_SESSION['monxin'][SHOP_ID.'_shop_group'].self::$language['price2'].':</span><span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=price_value>'.$temp.'</span>  <span class=discount_value><span class=discount_number>'.$goods_group_discount.'</span>'.self::$language['discount'].'</span></div>
								
							</div>';	

		
		}else{
		//----否则	
			if($discount==10){
				if($module['data']['min_price']==$module['data']['max_price']){$temp=$module['data']['min_price'];}else{$temp=$module['data']['min_price'].'-'.$module['data']['max_price'];}
				$module['price_div_html']='<div id=no_discount><span class=price_label>'.self::$language['goods_price'].'</span><span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=price_value>'.$temp.'</span> </div>';	
			}else{
				$remain_time='';
				$time=$end_time-$time;
				if($time>86400){
					$remain_time='<span class=number>'.ceil(($time/86400)).'</span>'.self::$language['day'];	
				}elseif($time>3600){
					$remain_time='<span class=number>'.ceil(($time/3600)).'</span>'.self::$language['hour'];	
				}elseif($time>60){
					$remain_time='<span class=number>'.ceil(($time/60)).'</span>'.self::$language['minute'];	
				}else{
					$remain_time='<span class=number>'.$time.'</span>'.self::$language['second'];	
				}
				if($module['data']['min_price']==$module['data']['max_price']){
					$temp=sprintf("%.2f",$module['data']['min_price']*$discount/10);
					$temp2=$module['data']['min_price'];
				}else{
					$temp=sprintf("%.2f",($module['data']['min_price']*$discount/10)).'-'.sprintf("%.2f",($module['data']['max_price']*$discount/10));
					$temp2=$module['data']['min_price'].'-'.$module['data']['max_price'];
				}
		
				$module['price_div_html']='<div id=have_discount>
									<div class=discount_price><span class=price_label>'.self::$language['limited_discount'].'</span><span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=price_value>'.$temp.'</span> <span class=discount_value><span class=discount_number>'.$discount.'</span>'.self::$language['discount'].'</span><span class=discount_time>'.self::$language['the_last'].$remain_time.'</span></div>
									<div class=normal_price><span class=price_label>'.self::$language['normal_price'].'</span><span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=price_value>'.$temp2.'</span></div>
								</div>';	
			}
		}		
	}
	//==================================================================================================================================【获取商品规格】
	$module['option_html']='';
	
	$sql="select `option_id` from ".self::$table_pre."goods_specifications where `goods_id`='".$id."' and `option_id`!='0' group by `option_id`";
	$r=$pdo->query($sql,2);
	$ids='';
	foreach($r as $v){
		$ids.=$v['option_id'].',';
	}
	$ids=trim($ids,',');
	if($ids!=''){
		$sql="select `id`,`type_id`,`name` from ".self::$table_pre."type_option where `id` in (".$ids.") order by `sequence` desc";
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			$list.='<a href="#" id=option_'.$v['id'].'>'.$v['name'].'</a>';
			$type_id=$v['type_id'];
		}
		if($list!=''){
			$sql="select `option_name` from ".self::$table_pre."type where `id`=".$type_id;
			$r=$pdo->query($sql,2)->fetch(2);
			$module['option_html'].='<div class=option_line_div><div class=option_label>'.$r['option_name'].'</div><div class=option_option>'.$list.'</div></div>';
		}
	}
	
	$sql="select `color_id`,`option_id`,`id`,`w_price`,`quantity` from ".self::$table_pre."goods_specifications where `goods_id`='".$id."'";
	$r=$pdo->query($sql,2);
	$list=array();
	$module['inventory']=0;
	foreach($r as $v){
		$list[$v['id']]['color_id']=$v['color_id'];
		$list[$v['id']]['option_id']=$v['option_id'];
		$list[$v['id']]['w_price']=$v['w_price'];
		$list[$v['id']]['pre_price']=$v['w_price']*$module['data']['pre_discount']/10;
		$list[$v['id']]['quantity']=self::format_quantity($v['quantity']);
		$module['inventory']+=$v['quantity'];
	}
	$module['inventory']+=self::get_big_inventory($pdo,$id);
	$module['inventory']=self::format_quantity($module['inventory']);
	$module['specifications']='';
	if(count($list)!=0){$module['specifications']=json_encode($list);}
	$list='';
	
	
	
	$sql="select `color_id`,`color_name`,`color_show`,`color_img` from ".self::$table_pre."goods_specifications where `goods_id`='".$id."' and `color_id`!='0' group by `color_id` order by `color_img` desc,`color_show` asc,`quantity` desc";
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$temp='';
		if($v['color_img']==''){
			if($v['color_show']==0){
				$temp='<img src="./program/mall/color_icon/'.$v['color_id'].'.png" />';	
			}else{
				$temp='<span class=color_name>'.$v['color_name'].'</span>';	
			}
		}else{
			$temp='<img src="./program/mall/img_thumb/'.$v['color_img'].'" />';	
		}
		$list.='<a href="#" id=color_'.$v['color_id'].' title="'.$v['color_name'].'">'.$temp.'</a>';	
	}
	if($list!=''){$module['option_html'].='<div class=color_line_div><div class=color_label>'.self::$language['color'].'</div><div class=color_option>'.$list.'</div></div>';}
	
	
	
		
}else{
	$module['data']['inventory']+=self::get_big_inventory($pdo,$id);
	$module['inventory']=self::format_quantity($module['data']['inventory']);
	//==================================================================================================================================【获取无规格商品价格】
	if($module['data']['state']==1){
		
		$module['price_div_html']='<div id=pre_sale>
		<div class=old_price><span class=price_label>'.self::$language['price'].'</span><span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=value>'.$module['data']['w_price'].'</span></div>
		<div class=pre_div>
			<div class=pre_price><span class=price_label>'.self::$language['pre_price'].'</span><span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=price_value>'.sprintf("%.2f",$module['data']['w_price']*$module['data']['pre_discount']/10).'</span></div>
			<div class=pre_deposit><span class=price_label>'.self::$language['deposit2'].'</span><span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=deposit_value>'.$module['data']['deposit'].'</span><span class=reduction_div>'.self::$language['deposit2'].self::$language['reduce'].'<span class=reduction> '.self::$language['money_symbol'].$module['data']['reduction'].'</span></span><a href="#" class=pre_sale_rules>'.self::$language['pre_sale_rules'].'</a></div>
		</div>
		</div>';		
	}else{
		//---如是店内会员，并折扣大于 店铺限时折扣
		if(isset($_SESSION['monxin'][SHOP_ID.'_discount']) and ($_SESSION['monxin'][SHOP_ID.'_discount']<10 || $goods_group_discount<10)  and ($_SESSION['monxin'][SHOP_ID.'_discount'] < $discount || $goods_group_discount < $discount ) and $module['data']['sales_promotion'] ){		
			if($goods_group_discount==100){$goods_group_discount=$_SESSION['monxin'][SHOP_ID.'_discount'];}
			$temp=sprintf("%.2f",($module['data']['w_price']* $goods_group_discount/10));
			$temp2=$module['data']['w_price'];
	
			$module['price_div_html']='<div id=have_discount>
								<div class=normal_price><span class=price_label>'.self::$language['normal_price'].'</span><span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=price_value>'.$temp2.'</span></div>
								<div class=discount_price><span class=price_label>'.$_SESSION['monxin'][SHOP_ID.'_shop_group'].self::$language['price2'].'</span><span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=price_value>'.$temp.'</span>  <span class=discount_value><span class=discount_number>'.$goods_group_discount.'</span>'.self::$language['discount'].'</span></div>
								
							</div>';	

		
		}else{
		//----否则			
			if($discount==10){
				$module['price_div_html']='<div id=no_discount><span class=price_label>'.self::$language['goods_price'].'</span><span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=price_value>'.$module['data']['w_price'].'</span></div>';	
			}else{
				$remain_time='';
				$time=$end_time-$time;
				if($time>86400){
					$remain_time='<span class=number>'.ceil(($time/86400)).'</span>'.self::$language['day'];	
				}elseif($time>3600){
					$remain_time='<span class=number>'.ceil(($time/3600)).'</span>'.self::$language['hour'];	
				}elseif($time>60){
					$remain_time='<span class=number>'.ceil(($time/60)).'</span>'.self::$language['minute'];	
				}else{
					$remain_time='<span class=number>'.$time.'</span>'.self::$language['second'];	
				}
				
				$module['price_div_html']='<div id=have_discount>
									<div class=discount_price><span class=price_label>'.self::$language['limited_discount'].'</span><span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=price_value>'.sprintf("%.2f",($module['data']['w_price']*$discount/10)).'</span> <span class=discount_value><span class=discount_number>'.$discount.'</span>'.self::$language['discount'].'</span><span class=discount_time>'.self::$language['the_last'].$remain_time.'</span></div>
									<div class=normal_price><span class=price_label>'.self::$language['normal_price'].'</span><span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=price_value>'.$module['data']['w_price'].'</span></div>
								</div>';	
			}
		}
	}
		
}

$right_info='';
$right_info_count=0;
$module['sold_comment_label']='';
$module['monthly_sold']=self::$language['monthly_sold'].'('.$module['data']['monthly'].')';
$module['cumulative_comment']=self::$language['cumulative_comment'].'('.($module['data']['comment_0']+$module['data']['comment_1']+$module['data']['comment_2']).')';


if(self::$config['show_sold']){
	$right_info_count++;
	$right_info.='<a href="#sold_div" class=sold_sum><span class=m_label>'.self::$language['monthly_sold'].': </span><span class=value>'.$module['data']['monthly'].'</span></a>';
	$module['sold_comment_label'].='<a href="#" id=sold_label>'.$module['monthly_sold'].'</a>';
}
if(self::$config['show_comment']){
	$right_info_count++;
	$right_info.='<a href="#comment_div" class=comment_sum><span class=m_label>'.self::$language['cumulative_comment'].': </span><span class=value>'.($module['data']['comment_0']+$module['data']['comment_1']+$module['data']['comment_2']).'</span></a>';
	$module['sold_comment_label'].='<a href="#" id=comment_label>'.$module['cumulative_comment'].'</a>';
}

$module['credits_multiple']=self::$config['give_credits'];
if(isset($_SESSION['monxin']['group_id'])){
	$sql="select `credits` from ".self::$table_pre."group_set where `group_id`=".$_SESSION['monxin']['group_id']." limit 0,1";
	$temp=$pdo->query($sql,2)->fetch(2);
	if(isset($temp['credits'])){$module['credits_multiple']=$temp['credits'];}
}

$module['log_div_html']='<div class=line_'.$right_info_count.'>'.$right_info.'<a class=credits><span class=m_label>'.self::$language['give'].self::$language['credits'].':</span><span class=value>'.($module['credits_multiple']*100).' %</span></a></div>';

$module['fulfil_preferential']=self::get_fulfil_preferential_method($pdo,self::$table_pre,self::$language,SHOP_ID);

$module['unit']=self::get_mall_unit_name($pdo,$module['data']['unit']);
$module['relevance_package']='';
//==================================================================================================================================【获取关联套餐】
if($module['data']['relevance_package']!=''){
	$sql="select * from ".self::$table_pre."package where `id` in (".$module['data']['relevance_package'].") and `discount`>0";
	//echo $sql;
	$package_ids=$module['data']['relevance_package'];
	$r=$pdo->query($sql,2);
	$list=array();
	foreach($r as $v){
		if($v['goods_ids']==''){continue;}
		$price_sum=0;
		$sql="select `min_price`,`max_price`,`w_price`,`option_enable`,`title`,`icon`,`id` from ".self::$table_pre."goods where `id` in (".$v['goods_ids'].") and `state`!=0";
		//echo $sql;
		$r2=$pdo->query($sql,2);
		$temp=array();
		foreach($r2 as $v2){
			$v2=de_safe_str($v2);
			if($v2['option_enable']==0){
				$price_sum+=$v2['w_price'];
				$w_price='<span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=money_value>'.$v2['w_price'].'</span>';
			}else{
				$price_sum+=$v2['min_price'];
				if($v2['min_price']==$v2['max_price']){
					$w_price='<span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=money_value>'.$v2['min_price'].'</span>';
				}else{
					$w_price='<span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=money_value>'.$v2['min_price'].'-'.$v2['max_price'].'</span>';
				}
			}
			$temp[$v2['id']]='<div class=goods_div id=goods_div_'.$v2['id'].'><a href="./index.php?monxin=mall.goods&id='.$v2['id'].'" target=_blank class=goods_a><img src="./program/mall/img_thumb/'.$v2['icon'].'" /><div>'.$w_price.'<br /><span class=goods_name>'.$v2['title'].'</span></div></a></div><div class="add_symbol">&nbsp;</div>';	
		}
		$temp2=explode(',',$v['goods_ids']);
		$temp3='';
		foreach($temp2 as $v2){
			$temp3.=@$temp[$v2];	
		}		
		$list[$v['id']]='<div class=package_div id=package_div_'.$v['id'].'>'.$temp3.'<div class=result_div>
		<div class=normal_price><span class=m_label>'.self::$language['normal_price'].'</span><span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=value>'.$price_sum.'</span><span class=more_than>'.self::$language['more_than'].'</span></div>
		<div class=package_price><span class=m_label>'.self::$language['package_price'].'</span><span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=value>'.sprintf("%.2f",($price_sum*$v['discount']/10)).'</span><span class=more_than>'.self::$language['more_than'].'</span></div>
		<div class=save_money><span class=m_label>'.self::$language['save_money'].'</span><span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=value>'.sprintf("%.2f",($price_sum-($price_sum*$v['discount']/10))).'</span><span class=more_than>'.self::$language['more_than'].'</span></div>
		<div class=save_money></div>
		<a href="./index.php?monxin=mall.package&id='.$v['id'].'" target=_blank class=view user_color=button>'.self::$language['view'].self::$language['package'].'</a>
		</div></div>';	
	}
	$temp2=explode(',',$module['data']['relevance_package']);
	$temp3='';
	foreach($temp2 as $v2){
		$temp3.=@$list[$v2];	
	}		
	$list=$temp3;
	$list=str_replace('<div class="add_symbol">&nbsp;</div><div class=result_div>','<div class="equal_symbol">&nbsp;</div><div class=result_div>',$list);
	$module['relevance_package']=$list;
}
$module['relevance_goods']='';
//==================================================================================================================================【获取关联商品】
if($module['data']['relevance_goods']!=''){
	$shop_discount=self::get_shop_discount($pdo,SHOP_ID);
	$sql="select `min_price`,`max_price`,`w_price`,`option_enable`,`title`,`icon`,`id`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time` from ".self::$table_pre."goods where `id` in (".$module['data']['relevance_goods'].") and `state`!=0";
	//echo $sql;
	$r2=$pdo->query($sql,2);
	$temp=array();
	$time=time();
	foreach($r2 as $v){
		$v=de_safe_str($v);
		if($v['discount']<10 && $time>$v['discount_start_time'] && $time<$v['discount_end_time']){$discount=$v['discount'];$goods_discount=$v['discount'];}else{$discount=$shop_discount;}
		if($v['option_enable']==0){
			if(($shop_discount<10 && $v['sales_promotion']) || isset($goods_discount)){$v['w_price']=sprintf("%.2f",$v['w_price']*$discount/10);}
			$w_price='<span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=money_value>'.$v['w_price'].'</span>';
		}else{
			if(($shop_discount<10 && $v['sales_promotion']) || isset($goods_discount)){$v['min_price']=sprintf("%.2f",$v['min_price']*$discount/10);$v['max_price']=sprintf("%.2f",$v['max_price']*$discount/10);}
			if($v['min_price']==$v['max_price']){
				$w_price='<span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=money_value>'.$v['min_price'].'</span>';
			}else{
				$w_price='<span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=money_value>'.$v['min_price'].'-'.$v['max_price'].'</span>';
			}
			
		}
		$temp[$v['id']]='<a href="./index.php?monxin=mall.goods&id='.$v['id'].'" target=_blank class=goods_a><img src="./program/mall/img_thumb/'.$v['icon'].'" /><div>'.$w_price.'<br /><span class=title>'.$v['title'].'</span></div></a>';	
	}
	$temp2=explode(',',$module['data']['relevance_goods']);
	foreach($temp2 as $v){
		$module['relevance_goods'].=@$temp[$v];	
	}
}
//==================================================================================================================================【获取商品属性】
$sql="select `id`,`attribute_id`,`value` from ".self::$table_pre."goods_attribute where `goods_id`=".$_GET['id'];
$r=$pdo->query($sql,2);
$temp=array();
$ids='';
foreach($r as $v){
	$ids.=$v['attribute_id'].',';
	$temp[$v['attribute_id']]=$v['value'];	
}
$ids=trim($ids,',');
$module['goods_attribute']='';
if($ids!=''){
	$sql="select `id`,`name` from ".self::$table_pre."type_attribute where `id` in (".$ids.") order by `sequence` desc";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$module['goods_attribute'].='<div><span class=a_label>'.$v['name'].'</span><span class=a_value>'.$temp[$v['id']].'</span></div>';	
	}
	$module['goods_attribute']='<div id=goods_attribute>'.$module['goods_attribute'].'</div>';	
}

//==================================================================================================================================【获取商品销量】
$module['sold_html']='';
if(self::$config['show_sold']){
	$start_time=time()-(86400*30);
	$sql="select `id`,`title`,`quantity`,`time`,`price`,`buyer`,`order_id` from ".self::$table_pre."order_goods where `goods_id`='".$module['data']['id']."' and `time`>".$start_time." order by `id` desc limit 0,".self::$config['monthly_sold_page_size'];
	$r=$pdo->query($sql,2);
	$temp='';
	foreach($r as $v){
		$v=de_safe_str($v);
		if(mb_strlen($v['title'],'utf-8')>18){
			$v['title']=mb_substr($v['title'],0,8,'utf-8').'**'.mb_substr($v['title'],mb_strlen($v['title'],'utf-8')-8,8,'utf-8');
		}
		if($v['buyer']==''){
			$v['buyer']=self::$language['tourist'];
			$sql="select `cashier` from ".self::$table_pre."order where `id`=".$v['order_id'];
			$b=$pdo->query($sql,2)->fetch(2);
			if($b['cashier']!=''){$v['buyer']=self::$language['offline_sales'];}
		}else{$v['buyer']=encryption_str($v['buyer']);}
		if($_COOKIE['monxin_device']!='pc'){
			$temp.='<tr id='.$v['id'].'><td><span class=username>'.$v['buyer'].'</span></td><td>'.$v['title'].'</td><td>'.date('Y-m-d',$v['time']).'</td></tr>';
		}else{
			$temp.='<tr id='.$v['id'].'><td><span class=username>'.$v['buyer'].'</span></td><td>'.$v['price'].'</td><td>'.$v['title'].'</td><td>'.self::format_quantity($v['quantity']).'</td><td>'.date('Y-m-d',$v['time']).'</td></tr>';
		}
		
	}
	if($_COOKIE['monxin_device']!='pc'){
		$thead=' <thead><tr><td>'.self::$language['buyer'].'</td><td>'.self::$language['model'].'</td><td>'.self::$language['time'].'</td></tr></thead>';
	}else{
		$thead=' <thead><tr><td>'.self::$language['buyer'].'</td><td>'.self::$language['price'].'</td><td>'.self::$language['model'].'</td><td>'.self::$language['quantity'].'</td><td>'.self::$language['time'].'</td></tr></thead>';
	}
	//echo $module['data']['monthly'].'>'.self::$config['monthly_sold_page_size'];
	if($module['data']['monthly']>self::$config['monthly_sold_page_size']){$more='<a href="" class=sold_page  sum='.$module['data']['monthly'].'>'.self::$language['more'].'</a>';}else{$more='';}
	if($temp==''){$thead='';$temp='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['the_last_30_days_no_sales'].'</span></td></tr>';}
	$module['sold_html']='
		<div id="sold_div">
        	<div class=sold_title>'.self::$language['monthly_sold'].'('.$module['data']['monthly'].')</div>
            <table cellpadding="0" cellspacing="0" id="sold_table">
               '.$thead.'
                <tbody>
                  '.$temp.'
                </tbody>
            </table>
            '.$more.'
        </div>
';
}

$module['data']['sum_comment']=0;
$module['data']['comment_0']=0;
$module['data']['comment_1']=0;
$module['data']['comment_2']=0;
$module['comment_html']='';

//==================================================================================================================================【获取商品评论】
if(self::$config['show_comment']){
	$module['data']['sum_comment']=($module['data']['comment_0']+$module['data']['comment_1']+$module['data']['comment_2']);

	$sql="select * from ".self::$table_pre."comment where `goods_id`='".$module['data']['id']."' order by `id` desc limit 0,".self::$config['comment_page_size'];
	$r=$pdo->query($sql,2);
	$module['comment_all']='';
	foreach($r as $v){
		$v=de_safe_str($v);
		if($v['answer']!=''){
			$answer="<div class=seller><span class=username>".self::$language['seller_answer'].": </span><span class=answer>".$v['answer']."</span><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['answer_time'])."</span></div>";
		}else{
			$answer='';	
		}
		$module['comment_all'].="<div class=cooment_line id=".$v['id']."><div class=buyer><span class=username>".encryption_str($v['buyer'])."</span><span class=point></span><span class=content>".$v['content'].$answer."</span><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</span></div></div>";	
		
	}
	
	$sql="select * from ".self::$table_pre."comment where `goods_id`='".$module['data']['id']."' and `level`=0 order by `id` desc limit 0,".self::$config['comment_page_size'];
	$r=$pdo->query($sql,2);
	$module['comment_0']='';
	foreach($r as $v){
		$v=de_safe_str($v);
		if($v['answer']!=''){
			$answer="<div class=seller><span class=username>".self::$language['seller_answer'].": </span><span class=answer>".$v['answer']."</span><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['answer_time'])."</span></div>";
		}else{
			$answer='';	
		}
		$module['comment_0'].="<div class=cooment_line id=".$v['id']."><div class=buyer><span class=username>".encryption_str($v['buyer'])."</span><span class=point></span><span class=content>".$v['content'].$answer."</span><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</span></div></div>";	
	}
	
	$sql="select * from ".self::$table_pre."comment where `goods_id`='".$module['data']['id']."' and `level`=1 order by `id` desc limit 0,".self::$config['comment_page_size'];
	$r=$pdo->query($sql,2);
	$module['comment_1']='';
	foreach($r as $v){
		$v=de_safe_str($v);
		if($v['answer']!=''){
			$answer="<div class=seller><span class=username>".self::$language['seller_answer'].": </span><span class=answer>".$v['answer']."</span><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['answer_time'])."</span></div>";
		}else{
			$answer='';	
		}
		$module['comment_1'].="<div class=cooment_line id=".$v['id']."><div class=buyer><span class=username>".encryption_str($v['buyer'])."</span><span class=point></span><span class=content>".$v['content'].$answer."</span><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</span></div></div>";	
	}
	
	$sql="select * from ".self::$table_pre."comment where `goods_id`='".$module['data']['id']."' and `level`=2 order by `id` desc limit 0,".self::$config['comment_page_size'];
	$r=$pdo->query($sql,2);
	$module['comment_2']='';
	foreach($r as $v){
		$v=de_safe_str($v);
		if($v['answer']!=''){
			$answer="<div class=seller><span class=username>".self::$language['seller_answer'].": </span><span class=answer>".$v['answer']."</span><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['answer_time'])."</span></div>";
		}else{
			$answer='';	
		}
		$module['comment_2'].="<div class=cooment_line><div class=buyer><span class=username>".encryption_str($v['buyer'])."</span><span class=point></span><span class=content>".$v['content'].$answer."</span><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</span></div></div>";	
	}
	$module['comment_html']='<div id="comment_div">
        	<div class=comment_title>'.self::$language['cumulative_comment'].'</div>
        	<div class=comment_label><a href="#" id=comment_all class=selected>'.self::$language['all'].'('.$module['data']['sum_comment'].')</a><a href="#" id=comment_0>'.self::$language['comment_option'][0].'('.$module['data']['comment_0'].')</a><a href="#" id=comment_1>'.self::$language['comment_option'][1].'('.$module['data']['comment_1'].')</a><a href="#" id=comment_2>'.self::$language['comment_option'][2].'('.$module['data']['comment_2'].')</a></div>
            <div class=comment_content>
                <div class=comment_page_div id=div_comment_all style="display:block;">
                   	'.$module['comment_all'].'
                    <a href="" class=comment_page sum='.$module['data']['sum_comment'].'>'.self::$language['more'].'</a>
                </div>
                <div class=comment_page_div id=div_comment_0>
                   '.$module['comment_0'].'
                    <a href="" class=comment_page sum='.$module['data']['comment_0'].'>'.self::$language['more'].'</a>
                </div>
                <div class=comment_page_div id=div_comment_1>
                    '.$module['comment_1'].'
                    <a href="" class=comment_page  sum='.$module['data']['comment_1'].'>'.self::$language['more'].'</a>
                </div>
                <div class=comment_page_div id=div_comment_2>
                    '.$module['comment_2'].'
                    <a href="" class=comment_page  sum='.$module['data']['comment_2'].'>'.self::$language['more'].'</a>
                </div>
            </div>    
        </div>
';
}

if($module['relevance_package']!=''){
	$module['relevance_package_div']='<div id="relevance_package_div">
			<div class=relevance_package>'.self::$language['preferential_packages'].'</div>'.$module['relevance_package'].'
        </div>';
}else{
	$module['relevance_package_div']='';
}

if($module['relevance_goods']!=''){
	$module['relevance_goods_div']='<div id="relevance_goods_div">
			<div class=relevance_package>'.self::$language['related_goods'].'</div>
			'.$module['relevance_goods'].'
        </div>';
}else{
	$module['relevance_goods_div']='';	
}
if($_COOKIE['monxin_device']=='phone'){
	if($module['data']['m_detail']!=''){
		$module['data']['detail']=$module['data']['m_detail'];	
	}else{
		$module['data']['detail']=preg_replace('#font-size:.*px;#iU','',$module['data']['detail']);	
	}
	
}

$module['data']['detail']=preg_replace("#<img(.*)src#iUs","<img$1wsrc",$module['data']['detail']);


$module['goods_detail_div']='<div id="goods_detail_div">
        	<div id=m_label_div><a href="#" id=detail_label class=current>'.self::$language['goods_detail'].'</a>'.$module['sold_comment_label'].'</div>
            <div id=goods_detail>
            	
                	'.$module['goods_attribute'].'
                
                <div id=goods_detail_html>'.$module['data']['detail'].'</div>
            </div>
        </div>'.$module['comment_html'].$module['sold_html'];

$module['html']='';
$attribute=format_attribute($args[1]);
asort($attribute);
//$attribute=array_flip($attribute);
$attribute=array_reverse($attribute);
//var_dump($attribute);
foreach($attribute as $k=>$v){
	if($v==0){continue;}
	$module['html'].=$module[$k];
}


$module['position']="<span id=current_position_text>".self::$language['current_position']."</span><a href='./index.php?monxin=mall.shop_index&shop_id=".SHOP_ID."'><span id=visitor_position_icon>&nbsp;</span>".self::$config['shop_name']."</a><a href=./index.php?monxin=mall.shop_goods_list&shop_id=".SHOP_ID.">".self::$language['all_goods']."</a>";
$module['shop_id']=SHOP_ID;
if(@$_GET['tag']!=''){
	$sql="select `name` from ".self::$table_pre."shop_tag where `id`=".intval($_GET['tag']);
	$r=$pdo->query($sql,2)->fetch(2);
	$module['position'].=$r['name'];
}elseif(@$_GET['search']!=''){
	$module['position'].=$_GET['search'];
}else{
	$module['position'].=$this->get_shop_type_position($pdo,$module['data']['shop_type']);
}
$module['shop_master']=SHOP_MASTER;


if($module['data']['limit']>0){
	$temp=explode('{number}',self::$language['everyone_buy_limit']);
	$module['data']['limit']='<span class=limit >'.$temp[0].'<span class="limit_v">'.$module['data']['limit'].'</span>'.$module['unit'].'</span>';	
}else{
	$module['data']['limit']='';	
}

$module['username']=@$_SESSION['monxin']['username'];

if($_COOKIE['monxin_device']=='phone'){
	$sql="select `id`,`name`,`domain`,`evaluation_0`,`evaluation_1`,`evaluation_2`,`talk_type`,`talk_account`,`deposit`,`username` from ".self::$table_pre."shop where `id`=".SHOP_ID;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){echo 'no shop';return false;}
	$module['shop_name']=$r['name'];
	if($r['evaluation_2']==0 && $r['evaluation_0']==0){
		$module['satisfaction']=100;
	}elseif($r['evaluation_0']==0 && $r['evaluation_2']!=0){
		$module['satisfaction']=0;
	}else{
		$module['satisfaction']=intval($r['evaluation_0']/($r['evaluation_0']+$r['evaluation_2'])*100);
	}
	$module['talk']='';
	if($r['talk_account']!=''){
		$sql="select `code` from ".self::$table_pre."talk where `id`=".$r['talk_type'];
		$r2=$pdo->query($sql,2)->fetch(2);
		$r2=de_safe_str($r2);
		$account=explode(',',$r['talk_account']);
		//echo $r['talk_type'];
		foreach($account as $v){
			if($v==''){continue;}
			$module['talk'].=str_replace('{account}',$v,@$r2['code']);	
		}
	}
	//$module['talk'].='<a talk="'.$r['username'].'" title="'.self::$language['site_msg'].'" class=talk></a>';
	$module['deposit']=intval($r['deposit']);
}

//======================================================================================================= 获取商品原 网售价
	function get_mall_goods_price($pdo,$goods_id){
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
	$module['mall_price']=get_mall_goods_price($pdo,$id);
	




require('./templates/0/'.$class.'_shop/'.self::$config['shop_template'].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php');