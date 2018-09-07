<?php
$id=intval(@$_GET['id']);
if($id==0){return not_find();}
$sql="select `save_to`,`id`,`name` from ".self::$table_pre."regular where `id`=".$id;
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){return not_find();}
echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=copy.regular&id='.$id.'">'.$r['name'].'</a><span class=text>'.self::$language['pages']['copy.field']['name'].'</span></div>';

$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&id='.$id;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['class_name']=self::$config['class_name'];
$table=explode(',',$r['save_to']);
$list='';
function get_data_source_type_option($arr){
	$list='';
	foreach($arr as $key=>$v){
		$list.='<option value="'.$key.'">'.$v.'</option>';	
	}
	return $list;	
}
function get_data_type_option($arr){
	$list='';
	foreach($arr as $key=>$v){
		$list.='<option value="'.$key.'">'.$v.'</option>';	
	}
	return $list;	
}

function get_data_source_2(){
	return '<option value="id">id</option><option value="url">url</option><option value="icon">icon</option><option value="title">title</option>';	
}
function get_data_source_4($pdo,$table){
	$sql="SHOW FULL COLUMNS FROM  `".$pdo->sys_pre.$table[0]."`";
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$list.='<option value="'.$v['Field'].'">'.$v['Field'].'</option>';
	}
	return $list;
}
$table_index=0;
foreach($table as $v){
	$sql="SHOW FULL COLUMNS FROM  `".$pdo->sys_pre.$v."`";
	//echo $sql;
	$r=$pdo->query($sql,2);
	//var_dump($r);
	if(!$r){continue;}
	foreach($r as $v2){
		if($v2['Field']=='id'){continue;}
		$sql="select * from ".self::$table_pre."field where `regular_id`='".$id."' and  `table`='".$v."' and `field`='".$v2['Field']."'";
		//echo $sql.'<br />';
		$v3=$pdo->query($sql,2)->fetch(2);
		if(is_array($v3)){$v3=de_safe_str($v3);}
		if($table_index==0){
			$auto_update_display='block';
		}else{
			$auto_update_display='none';
		}
		
		$list.="<tr id='tr_".$v.'__'.$v2['Field']."'>
	<td><span class=field_info title='".$v2['Type']." ".$v2['Comment']."'>".$v.' '.$v2['Field']."</span></td>
	<td><input type=text id='default_value' name='default_value' class=default_value value='".$v3['default_value']."' /></td>
	<td><input type=checkbox class=auto_update id='auto_update' name='auto_update' style='display:".$auto_update_display."' value='".$v3['auto_update']."' /></td>
	<td><textarea id='replace_to' name='replace'>".$v3['replace_to']."</textarea></td>
	<td class='data_source_type_td'>
	<select class='data_source_type' id='data_source_type' name='data_source_type' monxin_value='".$v3['data_source_type']."'>". get_data_source_type_option(self::$language['data_source_type_option'])."</select>
	<div class=data_source_type_option_div id=data_source_type_0></div>
	<div class=data_source_type_option_div id=data_source_type_1></div>
	<div class=data_source_type_option_div id=data_source_type_2><span class=m_label_2>".self::$language['data_source_type_label'][2]."</span><span class=input_span_2><select id=data_source_2 name=data_source_2 monxin_value='".$v3['data_source_2']."'>".get_data_source_2()."</select> <span class=state_2></span></span></div>
	<div class=data_source_type_option_div id=data_source_type_3><span class=m_label_2>".self::$language['data_source_type_label'][3]."</span><span class=input_span_2><textarea id=data_source_3 name=data_source_3 >".$v3['data_source_3']."</textarea> <span class=state_2></span></span></div>
	<div class=data_source_type_option_div id=data_source_type_4><span class=m_label_2>".self::$language['data_source_type_label'][4]."</span><span class=input_span_2><select id=data_source_4 name=data_source_4 monxin_value='".$v3['data_source_4']."'>".get_data_source_4($pdo,$table)."</select> <span class=state_2></span></span></div>
	</td>
	<td><textarea id='extract_reg' name='extract_reg'>".$v3['extract_reg']."</textarea></td>
	<td class='data_type_td'>
	<select class='data_type' id='data_type' name='data_type' monxin_value='".$v3['data_type']."'>". get_data_type_option(self::$language['data_type_option'])."</select>
	<div class=data_type_option_div id=data_type_0>
	".self::$language['allow_html']."<select id='allow_html' name='allow_html' monxin_value='".$v3['allow_html']."' ><option value=0>".self::$language['no']."</option><option value=1>".self::$language['yes']."</option></select> <span class=state_2></span><br />
	".self::$language['html_img_save_path']."<input type='text' id='html_img_save_path' name='html_img_save_path' value='".$v3['html_img_save_path']."' /> <span class=state_2></span><br />
	".self::$language['html_img_watermark']."<select id='html_img_watermark' name='html_img_watermark' monxin_value='".$v3['html_img_watermark']."' ><option value=0>".self::$language['no']."</option><option value=1>".self::$language['yes']."</option></select> <span class=state_2></span><br />
	</div>
	<div class=data_type_option_div id=data_type_1>
	".self::$language['save_path']."<input type='text' id='data_type_img_save_path' name='data_type_img_save_path' value='".$v3['data_type_img_save_path']."' /> <span class=state_2></span><br />
	".self::$language['data_type_img_imageMark']."<select id='data_type_img_imageMark' name='data_type_img_imageMark' monxin_value='".$v3['data_type_img_imageMark']."' ><option value=0>".self::$language['no']."</option><option value=1>".self::$language['yes']."</option></select> <span class=state_2></span><br />
	".self::$language['data_type_img_thumb_save_path']."<input type='text' id='data_type_img_thumb_save_path' name='data_type_img_thumb_save_path' value='".$v3['data_type_img_thumb_save_path']."' /> <span class=state_2></span><br />
	".self::$language['data_type_img_thumb_width']."<input type='text' id='data_type_img_thumb_width' name='data_type_img_thumb_width' value='".$v3['data_type_img_thumb_width']."' /> <span class=state_2></span><br />
	".self::$language['data_type_img_thumb_height']."<input type='text' id='data_type_img_thumb_height' name='data_type_img_thumb_height' value='".$v3['data_type_img_thumb_height']."' /> <span class=state_2></span><br />
	</div>
	<div class=data_type_option_div id=data_type_2>".self::$language['save_path']."<input type='text' id='data_type_file_save_path' name='data_type_file_save_path' value='".$v3['data_type_file_save_path']."' /> <span class=state_2></span></div>
	</td>
  <td class=operation_td>
  <a href='#' onclick='return update(\"tr_".$v.'__'.$v2['Field']."\")'  class='submit'>".self::$language['submit']."</a> <span id=state_tr_".$v.'__'.$v2['Field']." class='state'></span></td>
</tr>
";	
	}
	$table_index++;
}

if($list==''){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$module['list']=$list;


		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
