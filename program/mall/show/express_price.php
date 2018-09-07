<?php
$id=intval(@$_GET['id']);
if($id==0){echo 'id err'; return false;}
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$sql="select * from ".self::$table_pre."express where `id`=".$id;
$r=$pdo->query($sql,2)->fetch(2);
$module['express_name']=$r['name'];
$module['first_weight']=$r['first_weight'].self::$language['gram'];
$module['over_weight']=$r['over_weight'].self::$language['gram'];
$module['first_price']=self::$language['default'].":".self::format_price($r['first_price']).self::$language['yuan'];
$module['over_price']=self::$language['default'].":".self::format_price($r['over_price']).self::$language['yuan'];

$sql="select * from ".self::$table_pre."express_price where `express_id`='".$id."' and `shop_id`=".SHOP_ID;
$r=$pdo->query($sql,2);
$list='';
$price=array();
foreach($r as $v){
	$price[$v['area_id']]['first_price']=$v['first_price'];
	$price[$v['area_id']]['continue_price']=$v['continue_price'];
}

$upid=intval(@$_GET['upid']);
$sql="select * from ".$pdo->index_pre."area where `upid`=".$upid." order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$list.="<tr id='tr_".$v['id']."'>
		<td><span class=name>".$v['name']."</span> <a href=./index.php?monxin=mall.express_price&id=".$id."&upid=".$v['id']." class=show_sub title=".self::$language['sub']."></a></td>
		<td><input type='text' name='first_price_".$v['id']."' id='first_price_".$v['id']."' value='".@$price[$v['id']]['first_price']."'  class='first_price' /></td>
		<td><input type='text' name='continue_price_".$v['id']."' id='continue_price_".$v['id']."' value='".@$price[$v['id']]['continue_price']."'  class='continue_price' /></td>
	  <td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a> <span id=state_".$v['id']." class='state'></span> <a href=# class=batch_write>".self::$language['batch_write']."</a></td>
	</tr>
";	

}


$module['area_a_position']=get_area_a_position($pdo,$upid,'./index.php?monxin=mall.express_price&id='.$id.'&upid=');




$module['list']=$list;
if($module['list']==''){$module['list']='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}

$sql="select `name` from ".self::$table_pre."express where `id`=".$id;
$r=$pdo->query($sql,2)->fetch(2);

echo '<div  style="display:none;" id="user_position_append"><span class=text>'.$r['name'].' '.self::$language['pages']['mall.express_price']['name'].'</span></div>';

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
