<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;

$sql="select * from ".self::$table_pre."coupon where `shop_id`=".SHOP_ID." and `open`=1 and `draws`<`sum_quantity` order by `amount` asc ";
$r=$pdo->query($sql,2);
$list='';
$goods_ids='';
foreach($r as $v){
	if($v['end_time']<time()){continue;}
	if($v['join_goods']==0){$join_goods=self::$language['shop_whole'].self::$language['join_goods_front'][0];}
	if($v['join_goods']==1){$join_goods=self::$language['join_goods_front'][1].self::$language['general'];}
	if($v['join_goods']==2){$join_goods=self::$language['shop_whole'].self::$language['join_goods_front'][2];}

	$list.='<div class=coupon d_id='.$v['id'].'>
            	<div class=info>
                	<div class=i_head>
                    	<span class=amount>¥<span class="v">'.$v['amount'].'</span></span><span class="join_goods">'.$join_goods.'</span>
                    </div>
                    <div class="i_body">
                    	<div class=shop_name><span class=m_label>'.self::$language['condition_of_use'].'：</span><span class=m_value>'.self::$language['full'].$v['min_money'].self::$language['yuan'].'</span></div>
                    	<div class=shop_name><span class=m_label>'.self::$language['effective_time'].'：</span><span class=m_value>'.date('Y-m-d',$v['start_time']).' '.self::$language['to'].' '.date('Y-m-d',$v['end_time']).'</span></div>
                    </div>
                </div>
                <div class=act><a href="#" class=draws>'.self::$language['draws'].'</a><span class=state></span></div>
            </div>';
	
}
if($list==''){$list='<div align="center"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></div>';}		
$module['list']=$list;





require('./templates/0/'.$class.'_shop/'.self::$config['shop_template'].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php');