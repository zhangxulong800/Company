<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;

$program=@$_GET['program'];

$sql="select * from ".$pdo->index_pre."program";
$r=$pdo->query($sql);
$module['program_list']='';
$p_language=array();
foreach($r as $v){
	if(is_file('./program/'.$v['name'].'/config.php')){
	$p_config=require('./program/'.$v['name'].'/config.php');
	$p_language[$v['name']]=require('./program/'.$v['name'].'/language/'.$p_config['program']['language'].'.php');
	$module['program_list'].='<a href="./index.php?monxin=index.edit_page_layout&program='.$v['name'].'"><img src=./program/'.$v['name'].'/icon.png /><br />'.$p_language[$v['name']]['program_name'].'</a>';
	}
}


function get_layout($language,$v){
	if($v=='left'){$left='selected';}else{$left='';}	
	if($v=='right'){$right='selected';}else{$right='';}	
	if($v=='full'){$full='selected';}else{$full='';}
	return '<option value="left" '.$left.'>'.$language['left'].'</option><option value="right" '.$right.'>'.$language['right_2'].'</option><option value="full" '.$full.'>'.$language['full'].'</option>';	
		
}

function get_tutorial($language,$v){
	if($v==0){$a='selected';}else{$a='';}	
	if($v==1){$b='selected';}else{$b='';}	
	return '<option value="0" '.$a.'>'.$language['none'].'</option><option value="1" '.$b.'>'.$language['have'].'</option>';	
}

$module['list']='';
if($program!=''){
		
	
	$sql="select * from ".$pdo->index_pre."page where `url` like '".$program.".%'";
	$url=@$_GET['url'];
	if($url!=''){
		$sql="select * from ".$pdo->index_pre."page where `url` ='".$url."'";
		echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=index.edit_page_layout">'.$p_language['index']['pages']['index.edit_page_layout']['name'].'</a><a href="./index.php?monxin=index.edit_page_layout&program='.$program.'">'.$p_language[$program]['program_name'].'</a><span class=text>'.$p_language[$program]['pages'][$url]['name'].'</span></div>';	
	}else{
		echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=index.edit_page_layout">'.$p_language['index']['pages']['index.edit_page_layout']['name'].'</a><span class=text>'.$p_language[$program]['program_name'].'</span></div>';	
	}
	
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		if($v['made']=='user'){
			$del='<a href="#" class=del  onclick="return del('.$v['id'].')"  >'.self::$language['del'].'</a><br class=br_none />';
		}else{
			$del='';
		}
		$module_list=self::$language['head'].'<input type="text" id=head_'.$v['id'].' name=head_'.$v['id'].' value="'.$v['head'].'" /><br />';
		$module_list.=self::$language['left'].'<input type="text" id=left_'.$v['id'].' name=left_'.$v['id'].' value="'.$v['left'].'" /><br />';
		$module_list.=self::$language['right_2'].'<input type="text" id=right_'.$v['id'].' name=right_'.$v['id'].' value="'.$v['right'].'" /><br />';
		$module_list.=self::$language['full'].'<input type="text" id=full_'.$v['id'].' name=full_'.$v['id'].' value="'.$v['full'].'" /><br />';
		$module_list.=self::$language['bottom'].'<input type="text" id=bottom_'.$v['id'].' name=bottom_'.$v['id'].' value="'.$v['bottom'].'" /><br />';
		$module_list.=self::$language['phone_device'].'<input type="text" id=phone_'.$v['id'].' name=phone_'.$v['id'].' value="'.$v['phone'].'" /><br class=br_none /><br class=br_none />';
		$module['list'].='<tr id="tr_'.$v['id'].'">
		<td><a href=index.php?monxin='.$v['url'].' target=_blank class=url><span class=name>'.@$p_language[$program]['pages'][$v['url']]['name'].'</span><span class=url2>'.$v['url'].'</span></a><br /><input type=text class=authorize value="'.$v['authorize'].'" id=authorize_'.$v['id'].' name=authorize_'.$v['id'].'  placeholder="'.self::$language['authorize_code'].'" /></td>
		<td><span class=module_list>'.$module_list.'</span></td>
		<td><span class=layout><select name="layout_'.$v['id'].'" id="layout_'.$v['id'].'">
	  '.get_layout(self::$language,$v['layout']).'
	  </select></span></td>
		<td><span class=target><select name="target_'.$v['id'].'" id="target_'.$v['id'].'">
	  '.get_select_value($pdo,'target',$v['target']).'
	  </select></span></td>
		<td><span class=tutorial><select name="tutorial_'.$v['id'].'" id="tutorial_'.$v['id'].'" class=tutorial>
	  '.get_tutorial(self::$language,$v['tutorial']).'
	  </select></span></td>
		<td class=operation_td><a href="./index.php?monxin='.$v['url'].'&edit_page_layout=true"  target=_blank class=visual_edit>'.self::$language['visual_edit'].'</a><br class=br_none /><a href=# onclick="return update('.$v['id'].')"  class=submit>'.self::$language['submit'].'</a><br class=br_none />'.$del.'<span id=state_'.$v['id'].' class=state></span></td></tr>
';
	}
	
}



if($module['list']==''){$module['list']='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}

$module['list'].='<tr id="tr_new">
		<td><input type=text class=name placeholder="'.self::$language['name'].'" /><br /><input type=text class=url placeholder="'.self::$language['url'].'" /></td>
		<td><span class=module_list>
		'.self::$language['head'].'<input type="text" class=head /><br />
		'.self::$language['left'].'<input type="text" class=left /><br />
		'.self::$language['right_2'].'<input type="text" class=right /><br />
		'.self::$language['full'].'<input type="text" class=full /><br />
		'.self::$language['bottom'].'<input type="text" class=bottom /><br />
		</span></td>
		<td><select class=layout>
	  '.get_layout(self::$language,'full').'
	  </select></td>
		<td><select class="target">
	  '.get_select_value($pdo,'target','_self').'
	  </select></td>
		<td><select class=tutorial>
	  '.get_tutorial(self::$language,0).'
	  </select></td>
		<td class=operation_td><a href=# class=add>'.self::$language['add'].'</a> <span class=state></span></td></tr>
';


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
