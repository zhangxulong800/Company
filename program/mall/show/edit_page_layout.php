<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;


function get_layout($language,$v){
	if($v=='left'){$left='selected';}else{$left='';}	
	if($v=='right'){$right='selected';}else{$right='';}	
	if($v=='full'){$full='selected';}else{$full='';}
	return '<option value="left" '.$left.'>'.$language['left_2'].'</option><option value="right" '.$right.'>'.$language['right_2'].'</option><option value="full" '.$full.'>'.$language['full'].'</option>';	
		
}


	$sql="select * from ".self::$table_pre."page where `shop_id`='".SHOP_ID."'";
	if(@$_GET['url']!=''){
		$sql="select * from ".self::$table_pre."page where `shop_id`='".SHOP_ID."' and `url`='".safe_str($_GET['url'])."'";
		echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=mall.edit_page_layout">'.self::$language['pages']['mall.edit_page_layout']['name'].'</a><span class=text>'.$_GET['url'].'</span></div>';

	}
	
	$module['list']='';
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$module_list=self::$language['head'].'<input type="text" id=head_'.$v['id'].' name=head_'.$v['id'].' value="'.$v['head'].'" /><br />';
		$module_list.=self::$language['left_2'].'<input type="text" id=left_'.$v['id'].' name=left_'.$v['id'].' value="'.$v['left'].'" /><br />';
		$module_list.=self::$language['right_2'].'<input type="text" id=right_'.$v['id'].' name=right_'.$v['id'].' value="'.$v['right'].'" /><br />';
		$module_list.=self::$language['full'].'<input type="text" id=full_'.$v['id'].' name=full_'.$v['id'].' value="'.$v['full'].'" /><br />';
		$module_list.=self::$language['bottom'].'<input type="text" id=bottom_'.$v['id'].' name=bottom_'.$v['id'].' value="'.$v['bottom'].'" /><br />';
		$module_list.=self::$language['phone_device'].'<input type="text" id=phone_'.$v['id'].' name=phone_'.$v['id'].' value="'.$v['phone'].'" /><br class=br_none /><br class=br_none />';
		$module['list'].='<tr id="tr_'.$v['id'].'">
		<td><a href=index.php?monxin='.$v['url'].' target=_blank class=url><span class=name>'.self::$language['pages'][$v['url']]['name'].'</span><span class=url2>'.$v['url'].'</span></a></td>
		<td><span class=module_list>'.$module_list.'</span></td>
		<td><span class=layout><select name="layout_'.$v['id'].'" id="layout_'.$v['id'].'">
	  '.get_layout(self::$language,$v['layout']).'
	  </select></span></td>
		<td class=operation_td><a href="./index.php?monxin='.$v['url'].'&edit_mall_layout=true"  target=_blank class=visual_edit>'.self::$language['visual_edit'].'</a><br class=br_none /><a href=# onclick="return update('.$v['id'].')"  class=submit>'.self::$language['submit'].'</a><br class=br_none /><span id=state_'.$v['id'].' class=state></span></td></tr>
';
	}
	



$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);