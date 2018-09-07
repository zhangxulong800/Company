<?php
class form{
	public static $config,$language,$table_pre,$module_config;
	function __construct($pdo){
		if(!self::$config){
			//echo 'construct<br>';
			global $config,$language,$page;
			$program=__CLASS__;
			$program_config=require './program/'.$program.'/config.php';
			$program_language=require './program/'.$program.'/language/'.$program_config['program']['language'].'.php';
			self::$config=array_merge($config,$program_config);
			self::$language=array_merge($language,$program_language);
			self::$table_pre=$pdo->sys_pre.self::$config['class_name']."_";
			self::$module_config=require './program/'.$program.'/module_config.php';

		}		
	
	}

	function __call($method,$args){
		//echo $args[1];
		//var_dump( $args);
		$pdo=$args[0];
		$call=$method;
		$class=__CLASS__;
		$method=$class."::".$method;
		require './program/'.$class.'/show/'.$call.'.php';
   }

	function data_add_head_data($pdo){
		$table_id=intval(@$_GET['table_id']);
		if($table_id>0){
			$sql="select `description` from ".self::$table_pre."table where `id`='$table_id'";
			$r=$pdo->query($sql,2)->fetch(2);
			$r=de_safe_str($r);
			$v['title']=@$r['description'];	
			$v['keywords']=@$r['description'];	
			$v['description']=@$r['description'];	
			return $v;
		}
	}

	function data_show_list_head_data($pdo){
		$table_id=intval(@$_GET['table_id']);
		if($table_id>0){
			$sql="select `description` from ".self::$table_pre."table where `id`='$table_id'";
			$r=$pdo->query($sql,2)->fetch(2);
			$r=de_safe_str($r);
			$v['title']=@$r['description'];	
			$v['keywords']=@$r['description'];	
			$v['description']=@$r['description'];	
			return $v;
		}
	}

	function data_show_detail_head_data($pdo){
		$table_id=intval(@$_GET['table_id']);
		$id=intval(@$_GET['id']);
		if($table_id>0){			
			$sql="select `description`,`name`,`read_state` from ".self::$table_pre."table where `id`='$table_id'";
			$r=$pdo->query($sql,2)->fetch(2);
			$r=de_safe_str($r);
			$v['title']=@$r['description'];	
			$v['keywords']=@$r['description'];	
			$v['description']=@$r['description'];	
			if(@$r['read_state']==1){
				$sql="select * from ".self::$table_pre.$r['name']." where `id`=".$id;
				$r2=$pdo->query($sql,2)->fetch(2);
				if($r2['publish']!=1){return $v;}
				$temp='';
				$sql="select * from ".self::$table_pre."field where `table_id`=$table_id order by `sequence` desc,`id` asc";
				$r=$pdo->query($sql,2);
				$module['fields']='';
				foreach($r as $v2){
					if(!in_array($v2['name'],self::$config['sys_field'])){$temp.=$r2[$v2['name']].' ';}
				}
				$temp=strip_tags($temp);
				$temp=mb_substr($temp,0,40,'utf-8');
				$temp.=' ';
				$v['title']=$temp.$v['title'];	
				$v['keywords']=$temp.$v['keywords'];		
				$v['description']=$temp.$v['description'];		
			}
			
			return $v;
		}
	}



	function get_input_html($language,$v){
		$args=format_attribute($v['input_args']);
		if($v['required']){$required='<span class=required>*</span>';}else{$required='';}
		//echo $v['name'].$required.'<br />';
		switch ($v['input_type']) {
		case 'text':
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" value="'.@$args['text_default_value'].'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'"  maxlength="'.@$args['text_length'].'"  class="monxin_input" /> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'authcode':
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$language['authcode'].'</span><span class=input_span><input type=text id='.$v['name'].'   monxin_required="'.$v['required'].'"  class="monxin_input" size="8" style="vertical-align:middle;"  /> <span class=state id='.$v['name'].'_state ></span> <a href="#" onclick="return change_authcode();" title="'.self::$language['click_change_authcode'].'"><img id="authcode_img" src="./lib/authCode.class.php" style="vertical-align:middle; border:0px;" /></a></span></div>';
			break;
		case 'textarea':
			return '<div id='.$v['name'].'_div><span class=m_label style="display:inline-block; vertical-align:top; height:'.$args['textarea_height'].';">'.$required.''.$v['description'].'</span><span class=input_span><textarea id='.$v['name'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" style="width:'.$args['textarea_width'].'; height:'.$args['textarea_height'].';"  class="monxin_input" >'.$args['textarea_default_value'].'</textarea> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'editor':
			return '<script charset="utf-8" src="editor/kindeditor.js"></script>
<script charset="utf-8" src="editor/create.php?id='.$v['name'].'&program=form&language=chinese_simplified"></script><div id='.$v['name'].'_div><span class=m_label style="display:inline-block; vertical-align:top; height:'.$args['editor_height'].';">'.$required.''.$v['description'].'</span><span class=input_span><textarea  name='.$v['name'].' id='.$v['name'].'  check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" style="display:none;width:100%;height:'.$args['editor_height'].';"  class="monxin_input" >'.$args['editor_default_value'].'</textarea> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'select':
			$temp=explode('/',$args['select_option']);
			$temp=array_filter($temp);
			$option='';
			foreach($temp as $vv){$option.='<option value="'.$vv.'">'.$vv.'</option>';}
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><select id='.$v['name'].' monxin_value="'.$args['select_default_value'].'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'"  class="monxin_input" >'.$option.'</select> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'radio':
			$temp=explode('/',$args['radio_option']);
			$temp=array_filter($temp);
			$option='';
			foreach($temp as $vv){$option.='<input type="radio" name="'.$v['name'].'" value="'.$vv.'" /><span class=radio_text>'.$vv.'</span>';}
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><monxin_radio id='.$v['name'].' monxin_value="'.$args['radio_default_value'].'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" class="monxin_input"  >'.$option.'</monxin_radio> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'checkbox':
			$temp=explode('/',$args['checkbox_option']);
			$temp=array_filter($temp);
			$option='';
			foreach($temp as $vv){$option.='<input type="checkbox" name="'.$v['name'].'" value="'.$vv.'" /><span class=checkbox_text>'.$vv.'</span>';}
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><monxin_checkbox id='.$v['name'].' monxin_value="'.$args['checkbox_default_value'].'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" class="monxin_input"  >'.$option.'</monxin_checkbox> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'img':
			require_once("./plugin/html4Upfile/createHtml4.class.php");
			$html4Upfile=new createHtml4();
			$html4Upfile->echo_input($v['name'],'auto','./temp/','true','false',str_replace(',','|',$args['img_allow_image_type']),1024*5,'1');
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('class','monxin_input');			
		$('#".$v['name']."').attr('monxin_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend><span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'imgs':
			require_once("./plugin/html5Upfile/createHtml5.class.php");
			$html5Upfile=new createHtml5();
			$html5Upfile->echo_input(self::$language,$v['name'],'auto','multiple','./temp/','true','false',str_replace(',','|',$args['imgs_allow_image_type']),1024*5,'1');
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('class','monxin_input');			
		$('#".$v['name']."').attr('monxin_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend><span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'file':
			require_once("./plugin/html4Upfile/createHtml4.class.php");
			$html4Upfile=new createHtml4();
			$html4Upfile->echo_input($v['name'],'auto','./temp/','true','false',str_replace(',','|',$args['file_allow_file_type']),1024*30,'1');
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('class','monxin_input');			
		$('#".$v['name']."').attr('monxin_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend><span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'files':
			require_once("./plugin/html5Upfile/createHtml5.class.php");
			$html5Upfile=new createHtml5();
			$html5Upfile->echo_input(self::$language,$v['name'],'auto','multiple','./temp/','true','false',str_replace(',','|',$args['files_allow_file_type']),1024*get_upload_max_size(),'1');
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('class','monxin_input');			
		$('#".$v['name']."').attr('monxin_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend><span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'number':
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" value="'.$args['number_default_value'].'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'"  class="monxin_input" /> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'time':
			if($args['time_style']=="Y-m-d"){$time_style='date';}else{$time_style='date_time';}
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" onclick=show_datePicker(this.id,"'.$time_style.'") onblur= hide_datePicker() class="monxin_input"  /> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'map':
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'"  class="monxin_input" />  <span class=state id='.$v['name'].'_state></span> <a href="http://api.map.baidu.com/lbsapi/getpoint/index.html" target="_blank">'.self::$language['get_map'].'</a></span></div>';
			break;
		case 'area':
			echo '<script>function set_'.$v['name'].'(id,v){
				 $("#"+id).prop("value",v);
				}</script>';
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=hidden id='.$v['name'].' check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" class="monxin_input"  /> <span class=state id='.$v['name'].'_state></span><script src="area_js.php?callback=set_'.$v['name'].'&input_id='.$v['name'].'&id=0&output=select" id="'.$v['name'].'_area_js"></script>
</span></div>';
			break;
		default:

		}
		
	}
	

	function get_input_html2($language,$v,$data){
		$old_data=$data;
		$args=format_attribute($v['input_args']);
		if($v['required']){$required='<span class=required>*</span>';}else{$required='';}
		//echo $v['name'].$required.'<br />';
		switch ($v['input_type']) {
		case 'text':
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" value="'.$data.'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'"  maxlength="'.@$args['text_length'].'"  class="monxin_input" /> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'textarea':
			return '<div id='.$v['name'].'_div><span class=m_label style="display:inline-block; vertical-align:top; height:'.$args['textarea_height'].';">'.$required.''.$v['description'].'</span><span class=input_span><textarea id='.$v['name'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" style="width:'.$args['textarea_width'].'; height:'.$args['textarea_height'].';"  class="monxin_input" >'.$data.'</textarea> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'editor':
			return '<script charset="utf-8" src="editor/kindeditor.js"></script>
<script charset="utf-8" src="editor/create.php?id='.$v['name'].'&program=form&language=chinese_simplified"></script><div id='.$v['name'].'_div><span class=m_label style="display:inline-block; vertical-align:top; height:'.$args['editor_height'].';">'.$required.''.$v['description'].'</span><span class=input_span><textarea  name='.$v['name'].' id='.$v['name'].'  check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" style="display:none;width:100%;height:'.$args['editor_height'].';"  class="monxin_input" >'.$data.'</textarea> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'select':
			$temp=explode('/',$args['select_option']);
			$temp=array_filter($temp);
			$option='';
			foreach($temp as $vv){$option.='<option value="'.$vv.'">'.$vv.'</option>';}
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><select id='.$v['name'].' monxin_value="'.$data.'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'"  class="monxin_input" >'.$option.'</select> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'radio':
			$temp=explode('/',$args['radio_option']);
			$temp=array_filter($temp);
			$option='';
			foreach($temp as $vv){$option.='<input type="radio" name="'.$v['name'].'" value="'.$vv.'" /><span class=radio_text>'.$vv.'</span>';}
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><monxin_radio id='.$v['name'].' monxin_value="'.$data.'"  value="'.$data.'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" class="monxin_input"  >'.$option.'</monxin_radio> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'checkbox':
			$temp=explode('/',$args['checkbox_option']);
			$temp=array_filter($temp);
			$option='';
			foreach($temp as $vv){$option.='<input type="checkbox" name="'.$v['name'].'" value="'.$vv.'" /><span class=checkbox_text>'.$vv.'</span>';}
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><monxin_checkbox id='.$v['name'].'  monxin_value="'.$data.'" value="'.$data.'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" class="monxin_input"  >'.$option.'</monxin_checkbox> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'img':
			require_once("./plugin/html4Upfile/createHtml4.class.php");
			$html4Upfile=new createHtml4();
			$html4Upfile->echo_input($v['name'],'auto','./temp/','true','false',str_replace(',','|',$args['img_allow_image_type']),1024*5,'1');
			if($data!=''){
				if(is_file('./program/form/img_thumb/'.$data)){
					$data="<a href='./program/form/img/".$data."' target=_blank><img src='./program/form/img_thumb/".$data."' class=img_thumb  /></a><br />";
				}else{
					$data="<a href='./program/form/img/".$data."' target=_blank><img src='./program/form/img/".$data."' class=img_thumb  /></a><br />";
				}	
			}
			
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('old_value','".$old_data."');			
		$('#".$v['name']."').attr('class','monxin_input');			
		$('#".$v['name']."').attr('monxin_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend>'.$data.'<span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'imgs':
			require_once("./plugin/html5Upfile/createHtml5.class.php");
			$html5Upfile=new createHtml5();
			$html5Upfile->echo_input(self::$language,$v['name'],'auto','multiple','./temp/','true','false',str_replace(',','|',$args['imgs_allow_image_type']),1024*5,'1');
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('old_value','".$old_data."');			
		$('#".$v['name']."').attr('class','monxin_input');			
		$('#".$v['name']."').attr('monxin_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
		
			if($data!=''){
				$temp3=explode('|',$data);
				$temp3=array_filter($temp3);
				$temp4='';	
				foreach($temp3 as $v3){
					if(is_file('./program/form/imgs_thumb/'.$v3)){
						$temp4.="<a href='./program/form/imgs/".$v3."' target=_blank><img src='./program/form/imgs_thumb/".$v3."' class=img_thumb   /></a> <a href=# class='del_imgs' input_name='".$v['name']."'  file=".$v3.">".self::$language['del']."</a><br />";
					}else{
						$temp4.="<a href='./program/form/imgs/".$v3."' target=_blank><img src='./program/form/imgs/".$v3."' class=img_thumb  /></a> <a href=# class='del_imgs' input_name='".$v['name']."' file=".$v3.">".self::$language['del']."</a><br />";
					}	
				}
				$data=$temp4;
			}
	
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend>'.$data.'<span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'file':
			require_once("./plugin/html4Upfile/createHtml4.class.php");
			$html4Upfile=new createHtml4();
			$html4Upfile->echo_input($v['name'],'auto','./temp/','true','false',str_replace(',','|',$args['file_allow_file_type']),1024*30,'1');
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('old_value','".$old_data."');			
		$('#".$v['name']."').attr('class','monxin_input');			
		$('#".$v['name']."').attr('monxin_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
			if($data!=''){
				if(is_file('./program/form/file/'.$data)){
					$data="<a href='./program/form/file/".$data."' target=_blank>".substr($data,11)."</a><br />";
				}	
			}
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend>'.$data.'<span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'files':
			require_once("./plugin/html5Upfile/createHtml5.class.php");
			$html5Upfile=new createHtml5();
			$html5Upfile->echo_input(self::$language,$v['name'],'auto','multiple','./temp/','true','false',str_replace(',','|',$args['files_allow_file_type']),1024*get_upload_max_size(),'1');
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('old_value','".$old_data."');			
		$('#".$v['name']."').attr('class','monxin_input');			
		$('#".$v['name']."').attr('monxin_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
			if($data!=''){
				$temp3=explode('|',$data);
				$temp3=array_filter($temp3);
				$temp4='';	
				foreach($temp3 as $v3){
					if(is_file('./program/form/files/'.$v3)){
						$temp4.="<a href='./program/form/files/".$v3."' target=_blank>".substr($v3,11)."</a> <a href=# class='del_files' input_name='".$v['name']."'  file=".$v3.">".self::$language['del']."</a><br />";
					}	
				}
				$data=$temp4;
			}
	
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend>'.$data.'<span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'number':
			if($data==0){$data='';}
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" value="'.$data.'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'"  class="monxin_input" /> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'time':
			if($args['time_style']=="Y-m-d"){$time_style='date';}else{$time_style='date_time';}
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" value="'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$data).'" onclick=show_datePicker(this.id,"'.$time_style.'") onblur= hide_datePicker() class="monxin_input"  /> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'map':
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'"  value="'.$data.'" class="monxin_input" />  <span class=state id='.$v['name'].'_state></span> <a href="http://api.map.baidu.com/lbsapi/getpoint/index.html" target="_blank">'.self::$language['get_map'].'</a></span></div>';
			break;
		case 'area':
			echo '<script>function set_'.$v['name'].'(id,v){
				 $("#"+id).prop("value",v);
				}</script>';
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=hidden id='.$v['name'].' check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" class="monxin_input"  /> <span class=state id='.$v['name'].'_state></span><script src="area_js.php?callback=set_'.$v['name'].'&input_id='.$v['name'].'&id='.$data.'&output=select" id="'.$v['name'].'_area_js"></script></span></div>';
			break;
		default:

		}
		
	}
	
	function get_input_html3($pdo,$language,$v,$data){
		$old_data=$data;
		$args=format_attribute($v['input_args']);
		//echo $v['name'].$required.'<br />';
		
		switch ($v['input_type']) {
		case 'text':
			return '<div id='.$v['name'].'_div><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['description'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
		case 'textarea':

			
			return '<div id='.$v['name'].'_div><span class=m_label>&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend>'.rn_to_br($data).'</fieldset></span></div>';
			break;
		case 'editor':
			return '<div id='.$v['name'].'_div><span class=m_label>&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend>'.$data.'</fieldset></span></div>';
			break;
		case 'select':
			return '<div id='.$v['name'].'_div><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['description'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
		case 'radio':
			return '<div id='.$v['name'].'_div><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['description'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
		case 'checkbox':
			return '<div id='.$v['name'].'_div><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['description'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
		case 'img':
			if($data!=''){
				if(is_file('./program/form/img_thumb/'.$data)){
					$data="<a href='./program/form/img/".$data."' target=_blank><img src='./program/form/img_thumb/".$data."' class=img_thumb  /></a><br />";
				}else{
					$data="<a href='./program/form/img/".$data."' target=_blank><img src='./program/form/img/".$data."' class=img_thumb  /></a><br />";
				}	
			}
			return '<div id='.$v['name'].'_div><span class=m_label>&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend>'.$data.'</fieldset></span></div>';
			break;
		case 'imgs':
			if($data!=''){
				$temp3=explode('|',$data);
				$temp3=array_filter($temp3);
				$temp4='';	
				foreach($temp3 as $v3){
					if(is_file('./program/form/imgs_thumb/'.$v3)){
						$temp4.="<a href='./program/form/imgs/".$v3."' target=_blank><img src='./program/form/imgs_thumb/".$v3."' class=img_thumb /></a>";
					}else{
						$temp4.="<a href='./program/form/imgs/".$v3."' target=_blank><img src='./program/form/imgs/".$v3."' class=img_thumb /></a>";
					}	
				}
				$data=$temp4;
			}
			return '<div id='.$v['name'].'_div><span class=m_label>&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend>'.$data.'</fieldset></span></div>';
			break;
		case 'file':
			if($data!=''){
				if(is_file('./program/form/file/'.$data)){
					$data="<a href='./program/form/file/".$data."' target=_blank>".substr($data,11)."</a><br />";
				}	
			}
			return '<div id='.$v['name'].'_div><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['description'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
		case 'files':
			if($data!=''){
				$temp3=explode('|',$data);
				$temp3=array_filter($temp3);
				$temp4='';	
				foreach($temp3 as $v3){
					if(is_file('./program/form/files/'.$v3)){
						$temp4.="<a href='./program/form/files/".$v3."' target=_blank>".substr($v3,11)."</a><br />";
					}	
				}
				$data=$temp4;
			}
	
			return '<div id='.$v['name'].'_div><span class=m_label>&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend>'.$data.'</fieldset></span></div>';
			break;
		case 'number':
			if($data==0){$data='';}
			return '<div id='.$v['name'].'_div><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['description'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
		case 'time':
			return '<div id='.$v['name'].'_div><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['description'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$data).'</span></div>';
			break;
		case 'map':
			return '<div id='.$v['name'].'_div><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['description'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
		case 'area':
			$data="<span class=load_js_span  src='area_js.php?callback=set_area&input_id=".$v['name']."&id=".$data."&output=text2' id='".$v['name']."_".$data."'></span>";
			return '<div id='.$v['name'].'_div><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['description'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
		case 'bool':
			$data=($data)?$language['yes']:$language['no'];
			return '<div id='.$v['name'].'_div><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['description'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
		case 'user':
			$data=($data)?get_username($pdo,$data):$language['unlogin_user'];
			return '<div id='.$v['name'].'_div><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['description'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
			
		default:

		}
		
	}
	
}
	

?>