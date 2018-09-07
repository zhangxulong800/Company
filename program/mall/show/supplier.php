<?php

$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$sql="select * from ".self::$table_pre."supplier where `shop_id`=".SHOP_ID." order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
		
		$sql="select count(id) as c from ".self::$table_pre."goods_batch where `shop_id`='".SHOP_ID."' and `supplier`=".$v['id'];
		$old_sql=$sql;
		$sql=str_replace('count(id) as c','sum(`quantity`*`price`) as c',$sql);
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']==''){$r['c']==0;}
		$sum=number_format($r['c']);
		
		$sql=str_replace('count(id) as c','sum(`payment`*`price`) as c',$old_sql);
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']==''){$r['c']==0;}
		$pay_end=number_format($r['c']);
		
		
		
		$sql=str_replace('count(id) as c','sum((`quantity`-`payment`)*`price`) as c',$old_sql);
		$r=$pdo->query($sql." and `quantity`>`payment`",2)->fetch(2);
		if($r['c']==''){$r['c']==0;}
		$pay_wait=number_format($r['c']);
		
			
	
	$list.="<tr id='tr_".$v['id']."'>
		<td><input type='text' name='name_".$v['id']."' id='name_".$v['id']."' value='".$v['name']."'  class='name' /></td>
		<td><input type='text' name='link_man_".$v['id']."' id='link_man_".$v['id']."' value='".$v['link_man']."'  class='link_man' /></td>
		<td><input type='text' name='contact_".$v['id']."' id='contact_".$v['id']."' value='".$v['contact']."'  class='contact' /></td>
	  <td><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."'  class='sequence' /></td>
	  <td>".$sum."</td>
	  <td>".$pay_end."</td>
	  <td>".$pay_wait."</td>
	  <td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
	</tr>
";	

}
$module['list']=$list;
if($module['list']==''){$module['list']='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
