<?php
class ci{
	public static $config,$language,$table_pre,$module_config,$one_task;
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
			self::$one_task=false;
			if($_COOKIE['monxin_device']=='phone'){self::$one_task=true;}
			
			if(isset($_GET['refresh'])){
				//self::update_cart($pdo,self::$table_pre);	
			}
		}		
	}

	function __call($method,$args){
		$call_old_method=$method;
		$pdo=$args[0];
		$call=$method;
		$class=__CLASS__;
		self::$one_task=false;		
		if(self::$one_task){
			$m_require_login=0;
			$method='ci::search';
			require './program/ci/show/search.php';
			self::$one_task=false;	
		}
		if(in_array($class.'.'.$call,self::$config['program_unlogin_function_power'])){$m_require_login=0;}else{$m_require_login=1;}	
		$class=__CLASS__;
		$method=$call_old_method;
		$call=$method;
		$method=$class."::".$method;
		require './program/'.$class.'/show/'.$call.'.php';
   }
	
	function update_top_price($pdo,$table_pre){
	   $minute=file_get_contents('./program/ci/update_top_price.txt');
	   if($minute==date('i',time())){return false;}
	   $time=time();
	   $sql="update ".$table_pre."content set `top_price`=`top_price_spare` where `top_price`=0 and `top_price_spare`>0 and `top_start`<".$time."";
	   $pdo->exec($sql);
	   $sql="update ".$table_pre."content set `top_price`=0,`top_start`=0,`top_end`=0 where `top_end`<".$time."";
	   $pdo->exec($sql);	   
	   file_put_contents('./program/ci/update_top_price.txt',date('i',time()));
	}

	function  format_price($v,$yuan,$million_yuan){
		$v=floor($v*100)/100;
		$v=str_replace('.00','',$v);
		//$v=trim($v,'0');
		if($v<10000){return '<span class=number>'.$v.'</span><span class=unit>'.$yuan.'</span>';}else{
			$v=$v/10000;
			$v=floor($v*100)/100;
			return '<span class=number>'.$v.'</span><span class=unit>'.$million_yuan.'</span>';;	
		}
			
	}
//=======================================================================================================
	function detail_head_data($pdo){
		$id=intval(@$_GET['id']);
		if($id>0){
			$sql="select `type`,`title` from ".self::$table_pre."content where `id`='$id' and `state`=1";
			$r=$pdo->query($sql,2)->fetch(2);
			$r=de_safe_str($r);
			$r['title']=@$r['title'].'-'.self::get_type_title($pdo,@$r['type']);
			$v['title']=@$r['title'];	
			$v['keywords']=@$r['title'];	
			$v['description']=@$r['title'];	
			return $v;
		}
	}
	
//=======================================================================================================
	function list_head_data($pdo){
		$v=array();
		if(@$_GET['tag']!=''){
			$sql="select `name` from ".self::$table_pre."tag where `id`=".intval($_GET['tag']);
			$r=$pdo->query($sql,2)->fetch(2);	
					$r['title']=$r['name'];
					$v['title']=$r['title'];	
					$v['keywords']=$r['title'];	
					$v['description']=$r['title'];	
			
		}elseif(@$_GET['search']!=''){
					$r['title']=$_GET['search'];
					$v['title']=$r['title'];	
					$v['keywords']=$r['title'];	
					$v['description']=$r['title'];	
			
		}else{
			$id=intval(@$_GET['type']);
			if($id>0){
				$r['title']=self::get_type_title($pdo,$id);
				$v['title']=$r['title'];	
				$v['keywords']=$r['title'];	
				$v['description']=$r['title'];	
			}
		}
		return $v;
	}
	

	function exe_day_task($pdo){
		file_put_contents("./program/ci/update_task/day.txt",date("d",time()));
		$sql="update ".self::$table_pre."user set `day_add`=0,`day_reflash`=0";
		$pdo->exec($sql);	
	}
	
	function check_day_add_max($pdo,$table_pre,$max,$contact=''){
		$start_time=get_unixtime(date('Y-m-d',time()),'Y-m-d H:i:s');
		if(!isset($_SESSION['monxin']['username'])){
			return true;
		}else{
			$sql="select count(id) as c from ".$table_pre."content where `add_time`>".$start_time." and `username`='".$_SESSION['monxin']['username']."'";
		}
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']>=$max){return false;}else{return true;}
	}


	//====================================================================================================get_parent	
	function get_parent($pdo,$id=0,$deep=3,$need_url=false){
		$sql="select `name`,`id` from ".self::$table_pre."type where `parent`=0 and `id`!='$id' order by `sequence` desc";
		if(!$need_url){$sql="select `name`,`id` from ".self::$table_pre."type where `parent`=0 and `id`!='$id' and (`url`='' or `url` is null) order by `sequence` desc";}
		$stmt=$pdo->query($sql,2);
		$module['parent']="";
		foreach($stmt as $v){
			$v['name']=de_safe_str($v['name']);
			$module['parent'].="<option value='".$v['id']."'>&nbsp;&nbsp;&nbsp;&nbsp;".$v['name']."</option>";
			if($deep>1){
				$sql2="select `name`,`id` from ".self::$table_pre."type where `parent`=".$v['id']." and `id`!='$id' order by `sequence` desc";
				if(!$need_url){$sql2="select `name`,`id` from ".self::$table_pre."type where `parent`=".$v['id']." and `id`!='$id' and (`url`='' or `url` is null) order by `sequence` desc";}
				$r=$pdo->query($sql2,2);
				foreach($r as $v2){
					$v2['name']=de_safe_str($v2['name']);
					$module['parent'].="<option value='".$v2['id']."' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$v2['name']."</option>";
					if($deep>2){
						
						$sql3="select `name`,`id` from ".self::$table_pre."type where `parent`=".$v2['id']." and `id`!='$id' order by `sequence` desc";
						if(!$need_url){$sql3="select `name`,`id` from ".self::$table_pre."type where `parent`=".$v2['id']." and `id`!='$id'  and (`url`='' or `url` is null)  order by `sequence` desc";}
						$r3=$pdo->query($sql3,2);
						foreach($r3 as $v3){
							
							$v3['name']=de_safe_str($v3['name']);
							$module['parent'].="<option value='".$v3['id']."'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$v3['name']."</option>";
						}	
					}
					
				}	
			}
		}
		return $module['parent'];			
	}
	
	//====================================================================================================get_type_ids	
	function get_type_ids($pdo,$id){
		$sql="select `id` from ".self::$table_pre."type where `parent`=$id";
		$r=$pdo->query($sql,2);
		$ids=$id.',';
		foreach($r as $v){
			$ids.=$v['id'].',';
			$sql2="select `id` from ".self::$table_pre."type where `parent`=".$v['id']."";
			$r2=$pdo->query($sql2,2);
			foreach($r2 as $v2){
				$ids.=$v2['id'].',';
				$sql3="select `id` from ".self::$table_pre."type where `parent`=".$v2['id']."";
				$r3=$pdo->query($sql3,2);
				foreach($r3 as $v3){
					$ids.=$v3['id'].',';
				}
			}
			
		}
		return trim($ids,',');
	}

	//====================================================================================================get_type_names	
	function get_type_names($pdo,$id,$target,$title=''){
		$names='<a href="./index.php?monxin=ci.list&type=0" class=parent target='.$target.'>'.$title.'</a>';			
		$sql="select `id`,`name`,`url` from ".self::$table_pre."type where `parent`=$id and `visible`=1 order by `sequence` desc,`id` desc";
		$r=$pdo->query($sql,2);
		//echo $sql;
		$names.='<div class=type_deep_1>';
		foreach($r as $v){
			$v=de_safe_str($v);
			if($v['url']==''){$v['url']='./index.php?monxin=ci.list&type='.$v['id'];}
			$names.='<a href="'.$v['url'].'" id="type_'.$v['id'].'" target='.$target.'><b class=n>'.$v['name'].'</b><p class=show_sub>&nbsp;</p></a>';
			$sql2="select `id`,`name`,`url` from ".self::$table_pre."type where `parent`=".$v['id']." and `visible`=1 order by `sequence` desc,`id` desc";
			$r2=$pdo->query($sql2,2);
			$names.='<div id=type_'.$v['id'].'_div class="type_deep_2">';
			foreach($r2 as $v2){
				$v2=de_safe_str($v2);
				if($v2['url']==''){$v2['url']='./index.php?monxin=ci.list&type='.$v2['id'];}
				$names.='<a href="'.$v2['url'].'" id="type_'.$v2['id'].'" target='.$target.'><b class=n>'.$v2['name'].'</b><p class=show_sub>&nbsp;</p></a>';
				$sql3="select `id`,`name`,`url` from ".self::$table_pre."type where `parent`=".$v2['id']." and `visible`=1 order by `sequence` desc,`id` desc";
				$r3=$pdo->query($sql3,2);
				$names.='<div id=type_'.$v2['id'].'_div class="type_deep_3">';
				foreach($r3 as $v3){
					$v3=de_safe_str($v3);
					if($v3['url']==''){$v3['url']='./index.php?monxin=ci.list&type='.$v3['id'];}
					$names.='<a href="'.$v3['url'].'" id="type_'.$v3['id'].'" target='.$target.'>'.$v3['name'].'</a>';
				}
				$names.='</div>';
			}
			$names.='</div>';
		
		}
		$names.='</div>';
		return $names;
	}
	//===============================================================================================get_type_position	
	function get_type_position($pdo,$id){
		if(intval($id)==0){return '<a href="./index.php?monxin=ci.list&order='.@$_GET['order'].'">'.self::$language['pages']['ci.list']['name'].'</a>';}
		$position='<a href="./index.php?monxin=ci.list&order='.@$_GET['order'].'">'.self::$language['pages']['ci.list']['name'].'</a>';
		$position1='';
		$position2='';
		$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=$id";
		$r=$pdo->query($sql,2)->fetch(2);
		$position3='<a href="./index.php?monxin=ci.list&type='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>';
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position2='<a href="./index.php?monxin=ci.list&type='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>';
		}
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position1='<a href="./index.php?monxin=ci.list&type='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>';
		}
		return $position.$position1.$position2.$position3;
	}
	//===============================================================================================get_type_user_position	
	function get_type_user_position($pdo,$id){
		if(intval($id)==0){return '';}
		$position='';
		$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=$id";
		$r=$pdo->query($sql,2)->fetch(2);
		$position='<a href="./index.php?monxin=ci.type&parent='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>';
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position='<a href="./index.php?monxin=ci.type&parent='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>'.$position;
		}
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position='<a href="./index.php?monxin=ci.type&parent='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>'.$position;
		}
		return $position;
	}

	//===============================================================================================get_type_title	
	function get_type_title($pdo,$id){
		if(intval($id)==0){return self::$language['pages']['ci.type']['name'];}
		$position='';
		$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=$id";
		$r=$pdo->query($sql,2)->fetch(2);
		$position=$r['name'];
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position.='-'.$r['name'];
		}
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position.='-'.$r['name'];
		}
		return $position;
	}

  function get_tag_html($pdo){
	$sql="select * from ".self::$table_pre."tag order by `sequence` desc";
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$list.='<input type="checkbox" id=tag_'.$v['id'].' name=tag_'.$v['id'].' value="'.$v['id'].'" class=tag />'.$v['name'].' &nbsp;&nbsp;';
	}
	return $list;
  }
  
	
	function get_type_parent_text($pdo,$id){
		$sql="select `parent`,`name` from ".self::$table_pre."type where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$result=$r['name'];
		if($r['parent']!=0){
			$sql="select `parent`,`name` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$result=$r['name'].' -> '.$result;
			
			if($r['parent']!=0){
				$sql="select `parent`,`name` from ".self::$table_pre."type where `id`=".$r['parent'];
				$r=$pdo->query($sql,2)->fetch(2);
				$result=$r['name'].' -> '.$result;
			}	
		}
		return $result;	
	}
	
	function get_tags_name($pdo,$tag){
		$tag=str_replace('|',',',$tag);
		$tag=trim($tag,',');
		if($tag==''){return '';}
		$sql="select `name`,`id` from ".self::$table_pre."tag where `id` in (".$tag.")";
		$r=$pdo->query($sql,2);
		$temp='';
		foreach($r as $v){
			$temp.='<a href=./index.php?monxin=ci.list&tag='.$v['id'].'>'.$v['name'].'</a> , ';
		}
		$temp=trim($temp,' , ');
		return $temp;
			
	}
	
	


	function get_input_html($language,$v,$pdo){
		$args=format_attribute($v['input_args']);
		if($v['required']){$required='<span class=required>*</span>';}else{$required='';}
		//echo $v['name'].$required.'<br />';
		if(isset($args[$v['input_type'].'_default_value']) && $args[$v['input_type'].'_default_value']=='last'){
			$args[$v['input_type'].'_default_value']='';
			if(isset($_SESSION['monxin']['username'])){
				$type=intval(@$_GET['type']);
				$sql="select `id` from ".self::$table_pre."content where `type`=".$type." and `username`='".$_SESSION['monxin']['username']."'  order by `id` desc limit 0,1";
				$r=$pdo->query($sql,2)->fetch(2);
				$last_id=$r['id'];
				if($last_id){
					$sql="select `content` from ".self::$table_pre."attribute_value where `c_id`=".$last_id." and `a_id`=".$v['id']." limit 0,1";
					$r=$pdo->query($sql,2)->fetch(2);
					if($r['content']!=''){$args[$v['input_type'].'_default_value']=de_safe_str($r['content']);}
				}
				
			}
		}
		switch ($v['input_type']) {
		case 'text':
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.''.$v['name'].'</span><span class=input_span><input type=text id=a_'.$v['id'].' placeholder="'.$v['placeholder'].'" value="'.@$args['text_default_value'].'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'"  maxlength="'.@$args['text_length'].'"  class="monxin_input" /> <span class=postfix>'.$v['postfix'].'</span> <span class=state id=a_'.$v['id'].'_state></span></span></div>';
			break;
		case 'authcode':
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.''.$language['authcode'].'</span><span class=input_span><input type=text id=a_'.$v['id'].'   monxin_required="'.$v['required'].'"  class="monxin_input" size="8" style="vertical-align:middle;"  /> <span class=state id=a_'.$v['id'].'_state ></span> <a href="#" onclick="return change_authcode();" title="'.self::$language['click_change_authcode'].'"><img id="authcode_img" src="./lib/authCode.class.php" style="vertical-align:middle; border:0px;" /></a></span></div>';
			break;
		case 'textarea':
			return '<div id=a_'.$v['id'].'_div><span class=m_label style="display:inline-block; vertical-align:top; height:'.$args['textarea_height'].';">'.$required.''.$v['name'].'</span><span class=input_span><textarea id=a_'.$v['id'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" style="width:'.$args['textarea_width'].'; height:'.$args['textarea_height'].';"  class="monxin_input" >'.$args['textarea_default_value'].'</textarea> <span class=postfix>'.$v['postfix'].'</span> <span class=state id=a_'.$v['id'].'_state></span></span></div>';
			break;
		case 'editor':
			return '<script charset="utf-8" src="editor/kindeditor.js"></script>
<script charset="utf-8" src="editor/create.php?id=a_'.$v['id'].'&program=crm&language=chinese_simplified"></script><div id=a_'.$v['id'].'_div><span class=m_label style="display:inline-block; vertical-align:top; height:'.$args['editor_height'].';">'.$required.''.$v['name'].'</span><span class=input_span><textarea  name='.$v['name'].' id=a_'.$v['id'].'  check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" style="display:none;width:100%;height:'.$args['editor_height'].';"  class="monxin_input" >'.$args['editor_default_value'].'</textarea> <span class=postfix>'.$v['postfix'].'</span> <span class=state id=a_'.$v['id'].'_state></span></span></div>';
			break;
		case 'select':
			$temp=explode('/',$args['select_option']);
			$temp=array_filter($temp);
			$option='';
			foreach($temp as $vv){$option.='<option value="'.$vv.'">'.$vv.'</option>';}
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.''.$v['name'].'</span><span class=input_span><select id=a_'.$v['id'].' monxin_value="'.$args['select_default_value'].'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'"  class="monxin_input" >'.$option.'</select> <span class=postfix>'.$v['postfix'].'</span> <span class=state id=a_'.$v['id'].'_state></span></span></div>';
			break;
		case 'radio':
			$temp=explode('/',$args['radio_option']);
			$temp=array_filter($temp);
			$option='';
			foreach($temp as $vv){$option.='<input type="radio" name="'.$v['name'].'" value="'.$vv.'" /><span class=radio_text>'.$vv.'</span>';}
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.''.$v['name'].'</span><span class=input_span><monxin_radio id=a_'.$v['id'].' monxin_value="'.$args['radio_default_value'].'" value="'.$args['radio_default_value'].'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" class="monxin_input"  >'.$option.'</monxin_radio> <span class=postfix>'.$v['postfix'].'</span> <span class=state id=a_'.$v['id'].'_state></span></span></div>';
			break;
		case 'checkbox':
			$temp=explode('/',$args['checkbox_option']);
			$temp=array_filter($temp);
			$option='';
			foreach($temp as $vv){$option.='<input type="checkbox" name="'.$v['name'].'" value="'.$vv.'" /><span class=checkbox_text>'.$vv.'</span>';}
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.''.$v['name'].'</span><span class=input_span><monxin_checkbox id=a_'.$v['id'].' monxin_value="'.$args['checkbox_default_value'].'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" class="monxin_input"  >'.$option.'</monxin_checkbox> <span class=postfix>'.$v['postfix'].'</span> <span class=state id=a_'.$v['id'].'_state></span></span></div>';
			break;
		case 'img':
			require_once("./plugin/html4Upfile/createHtml4.class.php");
			$html4Upfile=new createHtml4();
			$html4Upfile->echo_input('a_'.$v['id'],'auto','./temp/','true','false',str_replace(',','|',$args['img_allow_image_type']),1024*5,'1');
			echo "<script>$(document).ready(function(){
		$('#a_".$v['id']."').attr('class','monxin_input');			
		$('#a_".$v['id']."').attr('monxin_required','".$v['required']."');			
		$('#a_".$v['id']."_ele').insertBefore($('#a_".$v['id']."_state'));});</script>";
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['name'].'</legend><span id=a_'.$v['id'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'imgs':
			require_once("./plugin/html5Upfile/createHtml5.class.php");
			$html5Upfile=new createHtml5();
			$html5Upfile->echo_input(self::$language,'a_'.$v['id'],'auto','multiple','./temp/','true','false',str_replace(',','|',$args['imgs_allow_image_type']),1024*5,'1');
			echo "<script>$(document).ready(function(){
		$('#a_".$v['id']."').attr('class','monxin_input');			
		$('#a_".$v['id']."').attr('monxin_required','".$v['required']."');			
		$('#a_".$v['id']."_ele').insertBefore($('#a_".$v['id']."_state'));});</script>";
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['name'].'</legend><span id=a_'.$v['id'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'file':
			require_once("./plugin/html4Upfile/createHtml4.class.php");
			$html4Upfile=new createHtml4();
			$html4Upfile->echo_input('a_'.$v['id'],'auto','./temp/','true','false',str_replace(',','|',$args['file_allow_file_type']),1024*30,'1');
			echo "<script>$(document).ready(function(){
		$('#a_".$v['id']."').attr('class','monxin_input');			
		$('#a_".$v['id']."').attr('monxin_required','".$v['required']."');			
		$('#a_".$v['id']."_ele').insertBefore($('#a_".$v['id']."_state'));});</script>";
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['name'].'</legend><span id=a_'.$v['id'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'files':
			require_once("./plugin/html5Upfile/createHtml5.class.php");
			$html5Upfile=new createHtml5();
			$html5Upfile->echo_input(self::$language,'a_'.$v['id'],'auto','multiple','./temp/','true','false',str_replace(',','|',$args['files_allow_file_type']),1024*get_upload_max_size(),'1');
			echo "<script>$(document).ready(function(){
		$('#a_".$v['id']."').attr('class','monxin_input');			
		$('#a_".$v['id']."').attr('monxin_required','".$v['required']."');			
		$('#a_".$v['id']."_ele').insertBefore($('#a_".$v['id']."_state'));});</script>";
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['name'].'</legend><span id=a_'.$v['id'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'number':
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.''.$v['name'].'</span><span class=input_span><input type=text id=a_'.$v['id'].' placeholder="'.$v['placeholder'].'" value="'.$args['number_default_value'].'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'"  class="monxin_input" /> <span class=postfix>'.$v['postfix'].'</span> <span class=state id=a_'.$v['id'].'_state></span></span></div>';
			break;
		case 'time':
			if($args['time_style']=="Y-m-d"){$time_style='date';}else{$time_style='date_time';}
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.''.$v['name'].'</span><span class=input_span><input type=text id=a_'.$v['id'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" onclick=show_datePicker(this.id,"'.$time_style.'") onblur= hide_datePicker() class="monxin_input"  /> <span class=state id=a_'.$v['id'].'_state></span></span></div>';
			break;
		case 'map':
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.''.$v['name'].'</span><span class=input_span><input type=text id=a_'.$v['id'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'"  class="monxin_input" monxin_type="map" />  <span class=state id=a_'.$v['id'].'_state></span> </span></div>';			
			break;
		case 'area':
			echo '<script>function set_'.$v['id'].'(id,v){
				 $("#"+id).prop("value",v);
				}</script>';
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.''.$v['name'].'</span><span class=input_span><input type=hidden id=a_'.$v['id'].' check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" class="monxin_input"  /> <span class=state id=a_'.$v['id'].'_state></span><script src="area_js.php?callback=set_'.$v['id'].'&input_id=a_'.$v['id'].'&id=0&output=select" id="a_'.$v['id'].'_area_js"></script>
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
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.''.$v['name'].'</span><span class=input_span><input type=text id=a_'.$v['id'].' placeholder="'.$v['placeholder'].'" value="'.$data.'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'"  maxlength="'.@$args['text_length'].'"  class="monxin_input" /> <span class=postfix>'.$v['postfix'].'</span> <span class=state id=a_'.$v['id'].'_state></span></span></div>';
			break;
		case 'textarea':
			return '<div id=a_'.$v['id'].'_div><span class=m_label style="display:inline-block; vertical-align:top; height:'.$args['textarea_height'].';">'.$required.''.$v['name'].'</span><span class=input_span><textarea id=a_'.$v['id'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" style="width:'.$args['textarea_width'].'; height:'.$args['textarea_height'].';"  class="monxin_input" >'.$data.'</textarea> <span class=postfix>'.$v['postfix'].'</span> <span class=state id=a_'.$v['id'].'_state></span></span></div>';
			break;
		case 'editor':
			return '<script charset="utf-8" src="editor/kindeditor.js"></script>
<script charset="utf-8" src="editor/create.php?id=a_'.$v['id'].'&program=crm&language=chinese_simplified"></script><div id=a_'.$v['id'].'_div><span class=m_label style="display:inline-block; vertical-align:top; height:'.$args['editor_height'].';">'.$required.''.$v['name'].'</span><span class=input_span><textarea  name='.$v['name'].' id=a_'.$v['id'].'  check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" style="display:none;width:100%;height:'.$args['editor_height'].';"  class="monxin_input" >'.$data.'</textarea>  <span class=postfix>'.$v['postfix'].'</span> <span class=state id=a_'.$v['id'].'_state></span></span></div>';
			break;
		case 'select':
			$temp=explode('/',$args['select_option']);
			$temp=array_filter($temp);
			$option='';
			foreach($temp as $vv){$option.='<option value="'.$vv.'">'.$vv.'</option>';}
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.''.$v['name'].'</span><span class=input_span><select id=a_'.$v['id'].' monxin_value="'.$data.'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'"  class="monxin_input" >'.$option.'</select> <span class=postfix>'.$v['postfix'].'</span> <span class=state id=a_'.$v['id'].'_state></span></span></div>';
			break;
		case 'radio':
			$temp=explode('/',$args['radio_option']);
			$temp=array_filter($temp);
			$option='';
			foreach($temp as $vv){$option.='<input type="radio" name="'.$v['name'].'" value="'.$vv.'" /><span class=radio_text>'.$vv.'</span>';}
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.''.$v['name'].'</span><span class=input_span><monxin_radio id=a_'.$v['id'].' monxin_value="'.$data.'"  value="'.$data.'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" class="monxin_input"  >'.$option.'</monxin_radio> <span class=state id=a_'.$v['id'].'_state></span></span></div>';
			break;
		case 'checkbox':
			$temp=explode('/',$args['checkbox_option']);
			$temp=array_filter($temp);
			$option='';
			foreach($temp as $vv){$option.='<input type="checkbox" name="'.$v['name'].'" value="'.$vv.'" /><span class=checkbox_text>'.$vv.'</span>';}
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.''.$v['name'].'</span><span class=input_span><monxin_checkbox id=a_'.$v['id'].'  monxin_value="'.$data.'" value="'.$data.'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" class="monxin_input"  >'.$option.'</monxin_checkbox> <span class=state id=a_'.$v['id'].'_state></span></span></div>';
			break;
		case 'img':
			require_once("./plugin/html4Upfile/createHtml4.class.php");
			$html4Upfile=new createHtml4();
			$html4Upfile->echo_input('a_'.$v['id'],'auto','./temp/','true','false',str_replace(',','|',$args['img_allow_image_type']),1024*5,'1');
			if($data!=''){
				if(is_file('./program/ci/img_thumb/'.$data)){
					$data="<a href='./program/ci/img/".$data."' target=_blank><img src='./program/ci/img_thumb/".$data."' class=img_thumb  /></a><br />";
				}else{
					$data="<a href='./program/ci/img/".$data."' target=_blank><img src='./program/ci/img/".$data."' class=img_thumb  /></a><br />";
				}	
			}
			
			echo "<script>$(document).ready(function(){
		$('#a_".$v['id']."').attr('old_value','".$old_data."');			
		$('#a_".$v['id']."').attr('class','monxin_input');			
		$('#a_".$v['id']."').attr('monxin_required','".$v['required']."');			
		$('#a_".$v['id']."_ele').insertBefore($('#a_".$v['id']."_state'));});</script>";
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['name'].'</legend>'.$data.'<span id=a_'.$v['id'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'imgs':
			require_once("./plugin/html5Upfile/createHtml5.class.php");
			$html5Upfile=new createHtml5();
			$html5Upfile->echo_input(self::$language,'a_'.$v['id'],'auto','multiple','./temp/','true','false',str_replace(',','|',$args['imgs_allow_image_type']),1024*5,'1');
			echo "<script>$(document).ready(function(){
		$('#a_".$v['id']."').attr('old_value','".$old_data."');			
		$('#a_".$v['id']."').attr('class','monxin_input');			
		$('#a_".$v['id']."').attr('monxin_required','".$v['required']."');			
		$('#a_".$v['id']."_ele').insertBefore($('#a_".$v['id']."_state'));});</script>";
		
			if($data!=''){
				$temp3=explode('|',$data);
				$temp3=array_filter($temp3);
				$temp4='';	
				foreach($temp3 as $v3){
					if(is_file('./program/ci/imgs_thumb/'.$v3)){
						$temp4.="<a href='./program/ci/imgs/".$v3."' target=_blank><img src='./program/ci/imgs_thumb/".$v3."' class=img_thumb   /></a> <a href=# class='del_imgs' input_name='".$v['name']."'  file=".$v3.">".self::$language['del']."</a><br />";
					}else{
						$temp4.="<a href='./program/ci/imgs/".$v3."' target=_blank><img src='./program/ci/imgs/".$v3."' class=img_thumb  /></a> <a href=# class='del_imgs' input_name='a_".$v['id']."' file=".$v3.">".self::$language['del']."</a><br />";
					}	
				}
				$data=$temp4;
			}
	
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['name'].'</legend>'.$data.'<span id=a_'.$v['id'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'file':
			require_once("./plugin/html4Upfile/createHtml4.class.php");
			$html4Upfile=new createHtml4();
			$html4Upfile->echo_input('a_'.$v['id'],'auto','./temp/','true','false',str_replace(',','|',$args['file_allow_file_type']),1024*30,'1');
			echo "<script>$(document).ready(function(){
		$('#a_".$v['id']."').attr('old_value','".$old_data."');			
		$('#a_".$v['id']."').attr('class','monxin_input');			
		$('#a_".$v['id']."').attr('monxin_required','".$v['required']."');			
		$('#a_".$v['id']."_ele').insertBefore($('#a_".$v['id']."_state'));});</script>";
			if($data!=''){
				if(is_file('./program/ci/file/'.$data)){
					$data="<a href='./program/ci/file/".$data."' target=_blank>".substr($data,11)."</a><br />";
				}	
			}
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['name'].'</legend>'.$data.'<span id=a_'.$v['id'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'files':
			require_once("./plugin/html5Upfile/createHtml5.class.php");
			$html5Upfile=new createHtml5();
			$html5Upfile->echo_input(self::$language,'a_'.$v['id'],'auto','multiple','./temp/','true','false',str_replace(',','|',$args['files_allow_file_type']),1024*get_upload_max_size(),'1');
			echo "<script>$(document).ready(function(){
		$('#a_".$v['id']."').attr('old_value','".$old_data."');			
		$('#a_".$v['id']."').attr('class','monxin_input');			
		$('#a_".$v['id']."').attr('monxin_required','".$v['required']."');			
		$('#a_".$v['id']."_ele').insertBefore($('#a_".$v['id']."_state'));});</script>";
			if($data!=''){
				$temp3=explode('|',$data);
				$temp3=array_filter($temp3);
				$temp4='';	
				foreach($temp3 as $v3){
					if(is_file('./program/ci/files/'.$v3)){
						$temp4.="<a href='./program/ci/files/".$v3."' target=_blank>".substr($v3,11)."</a> <a href=# class='del_files' input_name='a_".$v['id']."'  file=".$v3.">".self::$language['del']."</a><br />";
					}	
				}
				$data=$temp4;
			}
	
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['name'].'</legend>'.$data.'<span id=a_'.$v['id'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'number':
			if($data==0){$data='';}
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.''.$v['name'].'</span><span class=input_span><input type=text id=a_'.$v['id'].' placeholder="'.$v['placeholder'].'" value="'.$data.'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'"  class="monxin_input" /> <span class=postfix>'.$v['postfix'].'</span> <span class=state id=a_'.$v['id'].'_state></span></span></div>';
			break;
		case 'time':
			if($args['time_style']=="Y-m-d"){$time_style='date';}else{$time_style='date_time';}
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.''.$v['name'].'</span><span class=input_span><input type=text id=a_'.$v['id'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" value="'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$data).'" onclick=show_datePicker(this.id,"'.$time_style.'") onblur= hide_datePicker() class="monxin_input"  /> <span class=state id=a_'.$v['id'].'_state></span></span></div>';
			break;
		case 'map':
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.''.$v['name'].'</span><span class=input_span><input type=text id=a_'.$v['id'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'"  value="'.$data.'" class="monxin_input" monxin_type="map"  />  <span class=state id=a_'.$v['id'].'_state></span> </span></div>';
			break;
		case 'area':
			echo '<script>function set_'.$v['id'].'(id,v){
				 $("#"+id).prop("value",v);
				}</script>';
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$required.''.$v['name'].'</span><span class=input_span><input type=hidden id=a_'.$v['id'].' check_reg="'.$v['reg'].'" monxin_required="'.$v['required'].'" class="monxin_input"  /> <span class=state id=a_'.$v['id'].'_state></span><script src="area_js.php?callback=set_'.$v['id'].'&input_id=a_'.$v['id'].'&id='.$data.'&output=select" id="a_'.$v['id'].'_area_js"></script></span></div>';
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
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$v['name'].'</span><span class=input_span>'.$data.' <span class=postfix>'.$v['postfix'].'</span></span></div>';
			break;
		case 'textarea':

			
			return '<div id=a_'.$v['id'].'_div><span class=m_label>&nbsp;</span><span class=input_span><fieldset><legend>'.$v['name'].'</legend>'.rn_to_br($data).'</fieldset> <span class=postfix>'.$v['postfix'].'</span></span></div>';
			break;
		case 'editor':
			return '<div id=a_'.$v['id'].'_div><span class=m_label>&nbsp;</span><span class=input_span><fieldset><legend>'.$v['name'].'</legend>'.$data.'</fieldset> <span class=postfix>'.$v['postfix'].'</span></span></div>';
			break;
		case 'select':
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$v['name'].'</span><span class=input_span>'.$data.' <span class=postfix>'.$v['postfix'].'</span></span></div>';
			break;
		case 'radio':
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$v['name'].'</span><span class=input_span>'.$data.' <span class=postfix>'.$v['postfix'].'</span></span></div>';
			break;
		case 'checkbox':
			return '<div id=a_'.$v['id'].'_div><span class=m_label>'.$v['name'].'</span><span class=input_span>'.$data.' <span class=postfix>'.$v['postfix'].'</span></span></div>';
			break;
		case 'img':
			if($data!=''){
				if(is_file('./program/ci/img_thumb/'.$data)){
					$data="<a href='./program/ci/img/".$data."' target=_blank><img src='./program/ci/img/".$data."' class=img_thumb  /></a><br />";
				}else{
					$data="<a href='./program/ci/img/".$data."' target=_blank><img src='./program/ci/img/".$data."' class=img_thumb  /></a><br />";
				}	
			}
			return '<div id=a_'.$v['id'].'_div><span class=m_label>&nbsp;</span><span class=input_span><fieldset><legend>'.$v['name'].'</legend>'.$data.'</fieldset></span></div>';
			break;
		case 'imgs':
			if($data!=''){
				$temp3=explode('|',$data);
				$temp3=array_filter($temp3);
				$temp4='';	
				foreach($temp3 as $v3){
					if(is_file('./program/ci/imgs_thumb/'.$v3)){
						$temp4.="<a href='./program/ci/imgs/".$v3."' target=_blank><img src='./program/ci/imgs/".$v3."' class=img_thumb /></a>";
					}else{
						$temp4.="<a href='./program/ci/imgs/".$v3."' target=_blank><img src='./program/ci/imgs/".$v3."' class=img_thumb /></a>";
					}	
				}
				$data=$temp4;
			}
			return '<div id=a_'.$v['id'].'_div><span class=m_label>&nbsp;</span><span class=input_span><fieldset><legend>'.$v['name'].'</legend>'.$data.'</fieldset></span></div>';
			break;
		case 'file':
			if($data!=''){
				if(is_file('./program/ci/file/'.$data)){
					$data="<a href='./program/ci/file/".$data."' target=_blank>".substr($data,11)."</a><br />";
				}	
			}
			return '<div id=a_'.$v['id'].'_div><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['name'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
		case 'files':
			if($data!=''){
				$temp3=explode('|',$data);
				$temp3=array_filter($temp3);
				$temp4='';	
				foreach($temp3 as $v3){
					if(is_file('./program/ci/files/'.$v3)){
						$temp4.="<a href='./program/ci/files/".$v3."' target=_blank>".substr($v3,11)."</a><br />";
					}	
				}
				$data=$temp4;
			}
	
			return '<div id=a_'.$v['id'].'_div><span class=m_label>&nbsp;</span><span class=input_span><fieldset><legend>'.$v['name'].'</legend>'.$data.'</fieldset></span></div>';
			break;
		case 'number':
			if($data==0){$data='';}
			return '<div id=a_'.$v['id'].'_div><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['name'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.' <span class=postfix>'.$v['postfix'].'</span></span></div>';
			break;
		case 'time':
			return '<div id=a_'.$v['id'].'_div><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['name'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$data).'</span></div>';
			break;
		case 'map':
			return '<div id=a_'.$v['id'].'_div><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['name'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span><iframe width="100%" id="map" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://'.self::$config['web']['map_api'].'.monxin.com/map2.php?point='.$data.'&zoom=15&map_width=100%&map_height=100%">
</iframe><a href="http://'.self::$config['web']['map_api'].'.monxin.com/map2.php?point='.$data.'&zoom=15&map_width=100%&map_height=100%" target="_blank">'.$language['full_screen_view_map'].'</a></span></div>';
			break;
		case 'area':
			$data="<span class=load_js_span  src='area_js.php?callback=set_area&input_id=".$v['id']."&id=".$data."&output=text2' id='".$v['id']."_".$data."'></span>";
			return '<div id=a_'.$v['id'].'_div><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['name'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
		case 'bool':
			$data=($data)?$language['yes']:$language['no'];
			return '<div id=a_'.$v['id'].'_div><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['name'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
		case 'user':
			$data=($data)?get_username($pdo,$data):$language['unlogin_user'];
			return '<div id=a_'.$v['id'].'_div><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['name'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
			
		default:

		}
		
	}
	
	
	
}
	

?>