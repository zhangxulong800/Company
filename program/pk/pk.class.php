<?php
class pk{
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
		if(in_array($class.'.'.$call,self::$config['program_unlogin_function_power'])){$m_require_login=0;}else{$m_require_login=1;}		
		require './program/'.$class.'/show/'.$call.'.php';
   }

	
//=======================================================================================================
	function show_head_data($pdo){
		$id=intval(@$_GET['pk_id']);
		if($id>0){
			$sql="select `name` from ".self::$table_pre."pk where `id`='$id' and `state`=1";
			$r=$pdo->query($sql,2)->fetch(2);
			$r=de_safe_str($r);
			if($r['name']==''){return  not_find();}
			$v['title']=$r['name'];	
			$v['keywords']=$r['name'];	
			$v['description']=$r['name'];	
			return $v;
		}
	}
	

	//====================================================================================================get_parent	
	function get_parent($pdo,$pk_id,$id=0,$deep=3){
		$sql="select `name`,`id` from ".self::$table_pre."item where `pk_id`=".$pk_id." and `parent`=0 and `id`!='$id' order by `sequence` desc,`id` asc";
		$stmt=$pdo->query($sql,2);
		$module['parent']="";
		foreach($stmt as $v){
			$v['name']=de_safe_str($v['name']);
			$module['parent'].="<option value='".$v['id']."'>&nbsp;&nbsp;&nbsp;&nbsp;".$v['name']."</option>";
			if($deep>1){
				$sql2="select `name`,`id` from ".self::$table_pre."item where `pk_id`=".$pk_id." and `parent`=".$v['id']." and `id`!='$id' order by `sequence` desc,`id` asc";
				$r=$pdo->query($sql2,2);
				foreach($r as $v2){
					$v2['name']=de_safe_str($v2['name']);
					$module['parent'].="<option value='".$v2['id']."' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$v2['name']."</option>";
					if($deep>2){
						
						$sql3="select `name`,`id` from ".self::$table_pre."item where `pk_id`=".$pk_id." and `parent`=".$v2['id']." and `id`!='$id' order by `sequence` desc,`id` asc";
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
		$sql="select `id` from ".self::$table_pre."item where `parent`=$id";
		$r=$pdo->query($sql,2);
		$ids=$id.',';
		foreach($r as $v){
			$ids.=$v['id'].',';
			$sql2="select `id` from ".self::$table_pre."item where `parent`=".$v['id']."";
			$r2=$pdo->query($sql2,2);
			foreach($r2 as $v2){
				$ids.=$v2['id'].',';
				$sql3="select `id` from ".self::$table_pre."item where `parent`=".$v2['id']."";
				$r3=$pdo->query($sql3,2);
				foreach($r3 as $v3){
					$ids.=$v3['id'].',';
				}
			}
			
		}
		return trim($ids,',');
	}
	//===================================================================================================get_type_names	
	function get_type_names($pdo,$id,$target,$title=''){
		$names='<a href="./index.php?monxin=pk.show_page_list&type='.$id.'" class=parent target='.$target.'>'.$title.'</a>';			
		$sql="select `id`,`name` from ".self::$table_pre."item where `parent`=$id and `state`=1 order by `sequence` desc,`id` desc";
		$r=$pdo->query($sql,2);
		//echo $sql;
		$names.='<div class=item_deep_1>';
		foreach($r as $v){
			$names.='<a href="./index.php?monxin=pk.show_page_list&type='.$v['id'].'" id="item_'.$v['id'].'" target='.$target.'>'.$v['name'].'<span class=show_sub>&nbsp;</span></a>';
			$sql2="select `id`,`name` from ".self::$table_pre."item where `parent`=".$v['id']." and `state`=1 order by `sequence` desc,`id` desc";
			$r2=$pdo->query($sql2,2);
			$names.='<div id=item_'.$v['id'].'_div class="item_deep_2">';
			foreach($r2 as $v2){
				$names.='<a href="./index.php?monxin=pk.show_page_list&type='.$v2['id'].'" id="item_'.$v2['id'].'" target='.$target.'>'.$v2['name'].'<span class=show_sub>&nbsp;</span></a>';
				$sql3="select `id`,`name` from ".self::$table_pre."item where `parent`=".$v2['id']." and `state`=1 order by `sequence` desc,`id` desc";
				$r3=$pdo->query($sql3,2);
				$names.='<div id=item_'.$v2['id'].'_div class="item_deep_3">';
				foreach($r3 as $v3){
					$names.='<a href="./index.php?monxin=pk.show_page_list&type='.$v3['id'].'" id="item_'.$v3['id'].'" target='.$target.'>'.$v3['name'].'</a>';
				}
				$names.='</div>';
			}
			$names.='</div>';
		
		}
		$names.='</div>';
		return $names;
	}

	function get_pk_value_input($pdo,$thead,$item_id){
		$input='';
		foreach($thead as $vv){
			$sql="select `id`,`value`,`checked` from ".self::$table_pre."value where `object_id`=".$vv." and `item_id`=".$item_id." limit 0,1";
			$v3=$pdo->query($sql,2)->fetch(2);
			if($v3['id']==''){$v3['id']=0;$v3['value']='';$v3['checked']=0;}
			$input.='<td class=object object_id='.$vv.' item_id='.$item_id.'><input type=checkbox monxin_value='.$v3['checked'].' class=pk_checkbox /><input type=text value="'.de_safe_str($v3['value']).'" class=pk_value /></td>';
		}
		return $input;
	}

	function get_pk_value($pdo,$thead,$item_id){
		$input='';
		foreach($thead as $vv){
			$sql="select `id`,`value`,`checked` from ".self::$table_pre."value where `object_id`=".$vv." and `item_id`=".$item_id." limit 0,1";
			$v3=$pdo->query($sql,2)->fetch(2);
			if($v3['id']==''){$v3['id']=0;$v3['value']='';$v3['checked']=0;}
			if($v3['value']=='' && $v3['checked']==1){$v3['value']='<b class=yes></b>';}
			$input.='<td class=object object_id='.$vv.' item_id='.$item_id.'>'.$v3['value'].'</td>';
		}
		return $input;
	}
	
}

?>