<?php
class article{
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
		$pdo=$args[0];
		$call=$method;
		$class=__CLASS__;
		$method=$class."::".$method;
		if(in_array($class.'.'.$call,self::$config['program_unlogin_function_power'])){$m_require_login=0;}else{$m_require_login=1;}		
		require './program/'.$class.'/show/'.$call.'.php';
   }

	
	
//=======================================================================================================
	function show_head_data($pdo){
		$id=intval(@$_GET['id']);
		if($id>0){
			$sql="select `type`,`title` from ".self::$table_pre."article where `id`='$id' and `visible`=1";
			$r=$pdo->query($sql,2)->fetch(2);
			$r=de_safe_str($r);
			$r['title'].='-'.self::get_type_title($pdo,$r['type']);
			$v['title']=$r['title'];	
			$v['keywords']=$r['title'];	
			$v['description']=$r['title'];	
			return $v;
		}
	}
	
//=======================================================================================================
	function show_article_list_head_data($pdo){
		$type=intval(@$_GET['type']);
		if($type>0){
			$r['title']=self::get_type_title($pdo,$type);
		}else{
			$r['title']=self::$language['pages']['article.show_article_list']['name'];	
		}
		$v['title']=$r['title'];	
		$v['keywords']=$r['title'];	
		$v['description']=$r['title'];	
		return $v;
	}
	
	
	
	//===============================================================================================get_type_title	
	function get_type_title($pdo,$id){
		if(intval($id)==0){return self::$language['pages']['article.show_article_list']['name'];}
		$position='';
		$sql="select `name`,`parent`,`id` from ".self::$table_pre."article_type where `id`=$id";
		$r=$pdo->query($sql,2)->fetch(2);
		$position=$r['name'];
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."article_type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position.='-'.$r['name'];
		}
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."article_type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position.='-'.$r['name'];
		}
		return $position;
	}
	
	

	//====================================================================================================get_parent	
	function get_parent($pdo,$id=0,$deep=3){
		$sql="select `name`,`id` from ".self::$table_pre."article_type where `parent`=0 and `id`!='$id' order by `sequence` desc";
		$stmt=$pdo->query($sql,2);
		$module['parent']="";
		foreach($stmt as $v){
			$v['name']=de_safe_str($v['name']);
			$module['parent'].="<option value='".$v['id']."'>&nbsp;&nbsp;&nbsp;&nbsp;".$v['name']."</option>";
			if($deep>1){
				$sql2="select `name`,`id` from ".self::$table_pre."article_type where `parent`=".$v['id']." and `id`!='$id' order by `sequence` desc";
				$r=$pdo->query($sql2,2);
				foreach($r as $v2){
					$v2['name']=de_safe_str($v2['name']);
					$module['parent'].="<option value='".$v2['id']."' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$v2['name']."</option>";
					if($deep>2){
						
						$sql3="select `name`,`id` from ".self::$table_pre."article_type where `parent`=".$v2['id']." and `id`!='$id' order by `sequence` desc";
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
		$sql="select `id` from ".self::$table_pre."article_type where `parent`=$id";
		$r=$pdo->query($sql,2);
		$ids=$id.',';
		foreach($r as $v){
			$ids.=$v['id'].',';
			$sql2="select `id` from ".self::$table_pre."article_type where `parent`=".$v['id']."";
			$r2=$pdo->query($sql2,2);
			foreach($r2 as $v2){
				$ids.=$v2['id'].',';
				$sql3="select `id` from ".self::$table_pre."article_type where `parent`=".$v2['id']."";
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
		$names='<a href="./index.php?monxin=article.show_article_list&type='.$id.'" class=parent target='.$target.'>'.$title.'</a>';			
		$sql="select `id`,`name` from ".self::$table_pre."article_type where `parent`=$id and `visible`=1 order by `sequence` desc,`id` desc";
		$r=$pdo->query($sql,2);
		//echo $sql;
		$names.='<div class=article_type_deep_1>';
		foreach($r as $v){
			$names.='<a href="./index.php?monxin=article.show_article_list&type='.$v['id'].'" id="article_type_'.$v['id'].'" target='.$target.'>'.$v['name'].'<span class=show_sub>&nbsp;</span></a>';
			$sql2="select `id`,`name` from ".self::$table_pre."article_type where `parent`=".$v['id']." and `visible`=1 order by `sequence` desc,`id` desc";
			$r2=$pdo->query($sql2,2);
			$names.='<div id=article_type_'.$v['id'].'_div class="article_type_deep_2">';
			foreach($r2 as $v2){
				$names.='<a href="./index.php?monxin=article.show_article_list&type='.$v2['id'].'" id="article_type_'.$v2['id'].'" target='.$target.'>'.$v2['name'].'<span class=show_sub>&nbsp;</span></a>';
				$sql3="select `id`,`name` from ".self::$table_pre."article_type where `parent`=".$v2['id']." and `visible`=1 order by `sequence` desc,`id` desc";
				$r3=$pdo->query($sql3,2);
				$names.='<div id=article_type_'.$v2['id'].'_div class="article_type_deep_3">';
				foreach($r3 as $v3){
					$names.='<a href="./index.php?monxin=article.show_article_list&type='.$v3['id'].'" id="article_type_'.$v3['id'].'" target='.$target.'>'.$v3['name'].'</a>';
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
		if(intval($id)==0){return '<a href="./index.php?monxin=article.show_article_list&order='.@$_GET['order'].'">'.self::$language['pages']['article.show_article_list']['name'].'</a>';}
		$position='';
		$sql="select `name`,`parent`,`id` from ".self::$table_pre."article_type where `id`=$id";
		$r=$pdo->query($sql,2)->fetch(2);
		$position='<a href="./index.php?monxin=article.show_article_list&type='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>';
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."article_type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position='<a href="./index.php?monxin=article.show_article_list&type='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>'.$position;
		}
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."article_type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position='<a href="./index.php?monxin=article.show_article_list&type='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>'.$position;
		}
		return $position;
	}

	
}
	

?>