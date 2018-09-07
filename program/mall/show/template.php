<?php
		$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
		$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
		$sql="select * from ".self::$table_pre."template order by `sequence` desc,`id` asc";
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			//$v=de_safe_str($v);
			$sql="select count(id) as c from ".self::$table_pre."shop where `template`='".$v['dir']."'";
			$r2=$pdo->query($sql,2)->fetch(2);
			$list.="<tr id='tr_".$v['id']."'>
				<td><input type='text' name='dir_".$v['id']."' id='dir_".$v['id']."' value='".$v['dir']."'  class='dir' /></td>
				<td><input type='text' name='name_".$v['id']."' id='name_".$v['id']."' value='".$v['name']."'  class='name' /></td>
				<td><span class=use>".$r2['c']."</span></td>
				<td><input type='text' name='for_shop_".$v['id']."' id='for_shop_".$v['id']."' value='".$v['for_shop']."'  class='for_shop' /></td>
			  <td><input type='checkbox' name='data_state_".$v['id']."' id='data_state_".$v['id']."'  class='data_state' value='".$v['state']."' /></td>
			  <td><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."'  class='sequence' /></td>
			  <td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
			</tr>
	";	

		}
		$module['list']=$list;
		if($module['list']==''){$module['list']='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}
		
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);	
