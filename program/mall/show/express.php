<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$sql="select * from ".self::$table_pre."express order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$list.="<tr id='tr_".$v['id']."'>
		<td><input type='text' name='name_".$v['id']."' id='name_".$v['id']."' value='".$v['name']."'  class='name' /></td>
		<td><input type='text' name='first_weight_".$v['id']."' id='first_weight_".$v['id']."' value='".$v['first_weight']."'  class='first_weight' /></td>
		<td><input type='text' name='first_price_".$v['id']."' id='first_price_".$v['id']."' value='".$v['first_price']."'  class='first_price' /></td>
		<td><input type='text' name='over_weight_".$v['id']."' id='over_weight_".$v['id']."' value='".$v['over_weight']."'  class='over_weight' /></td>
		<td><input type='text' name='over_price_".$v['id']."' id='over_price_".$v['id']."' value='".$v['over_price']."'  class='over_price' /></td>
		<td><input type='text' name='url_".$v['id']."' id='url_".$v['id']."' value='".$v['url']."'  class='url' /></td>
	  <td><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."'  class='sequence' /></td>
	  <td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a><a href='./index.php?monxin=mall.express_layout&id=".$v['id']."'>".self::$language['composing']."</a><a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
	</tr>
";	

}
$module['list']=$list;
if($module['list']==''){$module['list']='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
