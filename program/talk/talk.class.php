<?php
class talk{
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
	function content_head_data($pdo){
		$id=intval(@$_GET['id']);
		if($id==0 && @$_GET['key']!=''){
			$sql="select `id` from ".self::$table_pre."title where `key`='".safe_str($_GET['key'])."'";
			$r=$pdo->query($sql,2)->fetch(2);
			$id=intval($r['id']);	
		}
		if($id>0){
			$sql="select `title`,`type` from ".self::$table_pre."title where `id`='$id' and `visible`=1";
			$r=$pdo->query($sql,2)->fetch(2);
			$r=de_safe_str($r);
			$name=$r['title'];
			$id=$r['type'];
			$sql="select `name`,`parent` from ".self::$table_pre."type where `id`='$id' and `visible`=1";
			$r=$pdo->query($sql,2)->fetch(2);
			$r=de_safe_str($r);
			$name.='-'.$r['name'];
			if(@$r['parent']!='' && $r['parent']!=0){
				$sql="select `name`,`parent` from ".self::$table_pre."type where `id`=".$r['parent'];
				$r2=$pdo->query($sql,2)->fetch(2);
				$name.='-'.$r2['name'];
				if($r2['parent']!=0){
					$sql="select `name`,`parent` from ".self::$table_pre."type where `id`=".$r2['parent'];
					$r3=$pdo->query($sql,2)->fetch(2);
					$name.='-'.$r3['name'];
				}	
			}
			$name.='-'.self::$language['program_name'];

			
			$v['title']=$name;	
			$v['keywords']=$name;		
			$v['description']=$name;	
			return $v;
		}
	}
	
//=======================================================================================================
	function title_head_data($pdo){
		$id=intval(@$_GET['type']);
		if($id>0){
			$sql="select `name`,`parent` from ".self::$table_pre."type where `id`='$id' and `visible`=1";
			$r=$pdo->query($sql,2)->fetch(2);
			$r=de_safe_str($r);
			$name=$r['name'];
			if(@$r['parent']!='' && $r['parent']!=0){
				$sql="select `name`,`parent` from ".self::$table_pre."type where `id`=".$r['parent'];
				$r2=$pdo->query($sql,2)->fetch(2);
				$name.='-'.$r2['name'];
				if($r2['parent']!=0){
					$sql="select `name`,`parent` from ".self::$table_pre."type where `id`=".$r2['parent'];
					$r3=$pdo->query($sql,2)->fetch(2);
					$name.='-'.$r3['name'];
				}	
			}
			$name.='-'.self::$language['program_name'];
			$v['title']=$name;	
			$v['keywords']=$name;	
			$v['description']=$name;		
			return $v;
		}
	}
	
//=======================================================================================================
	function type_head_data($pdo){
		$id=intval(@$_GET['id']);
		
		if($id>0){
			$sql="select `name`,`parent` from ".self::$table_pre."type where `id`='$id' and `visible`=1";
			$r=$pdo->query($sql,2)->fetch(2);
			$r=de_safe_str($r);
			$name=$r['name'];
			if(@$r['parent']!='' && $r['parent']!=0){
				$sql="select `name`,`parent` from ".self::$table_pre."type where `id`=".$r['parent'];
				$r2=$pdo->query($sql,2)->fetch(2);
				$name.='-'.$r2['name'];
				if($r2['parent']!=0){
					$sql="select `name`,`parent` from ".self::$table_pre."type where `id`=".$r2['parent'];
					$r3=$pdo->query($sql,2)->fetch(2);
					$name.='-'.$r3['name'];
				}	
			}
			$name.='-'.self::$language['program_name'];
			$v['title']=$name;	
			$v['keywords']=$name;	
			$v['description']=$name;		
			return $v;
		}else{
			$name=self::$language['program_name'];
			$v['title']=$name;	
			$v['keywords']=$name;	
			$v['description']=$name;		
			return $v;
		}
	}
	

	//====================================================================================================get_parent	
	function get_parent($pdo,$id=0,$deep=3){
		$sql="select `name`,`id` from ".self::$table_pre."type where `parent`=0 and `id`!='$id' order by `sequence` desc";
		$stmt=$pdo->query($sql,2);
		$module['parent']="";
		foreach($stmt as $v){
			$v['name']=de_safe_str($v['name']);
			$module['parent'].="<option value='".$v['id']."'>&nbsp;&nbsp;&nbsp;&nbsp;".$v['name']."</option>";
			if($deep>1){
				$sql2="select `name`,`id` from ".self::$table_pre."type where `parent`=".$v['id']." and `id`!='$id' order by `sequence` desc";
				$r=$pdo->query($sql2,2);
				foreach($r as $v2){
					$v2['name']=de_safe_str($v2['name']);
					$module['parent'].="<option value='".$v2['id']."' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$v2['name']."</option>";
					if($deep>2){
						
						$sql3="select `name`,`id` from ".self::$table_pre."type where `parent`=".$v2['id']." and `id`!='$id' order by `sequence` desc";
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
	function get_type_names($pdo,$id,$target,$sum=false){
		$names='';
		$sql="select `id`,`name`,`title_sum`,`content_sum`,`day_title_sum` from ".self::$table_pre."type where visible=1 and `parent`=$id order by `sequence` desc,`id` desc";
		$r=$pdo->query($sql,2);
		//echo $sql;
		foreach($r as $v){
			$sql2="select count(id) as c from ".self::$table_pre."type where `parent`=".$v['id']." and `visible`=1";
			$r2=$pdo->query($sql2,2)->fetch(2);
			if($r2['c']!=0){
				$url="./index.php?monxin=talk.type&id=".$v['id'];
				$sql="select sum(`title_sum`) as c1,sum(`day_title_sum`) as c2 from ".self::$table_pre."type where `parent`=".$v['id']." and `visible`=1";
				$r3=$pdo->query($sql,2)->fetch(2);
				$v['title_sum']=$r3['c1'];
				$v['day_title_sum']=$r3['c2'];
								
			}else{
				$url="./index.php?monxin=talk.title&type=".$v['id'];	
			}
			
			$sum_div='<div class=sum_div>
				<div class=name>'.$v['name'].'</div>
				<div><span class="day_title_sum_span">'.self::$language['today'].'</span><span class="day_title_sum"><span class="v">'.$v['day_title_sum'].'</span></span></div>
				<div><span class="title_sum_span">'.self::$language['sum_title'].'</span><span class="title_sum"><span class="v">'.$v['title_sum'].'</span></span></div>
				</div>';
			$names.='<a href="'.$url.'" id="type_'.$v['id'].'" target='.$target.' class=type_a><div class=icon_div><img src="./program/talk/type_icon/'.$v['id'].'.png" /></div>'.$sum_div.'</a>';		
		}
		return $names;
	}

	//===============================================================================================get_type_position	
	function get_type_position($pdo,$id){
		if(intval($id)==0){return '<a href="./index.php?monxin=talk.type&order='.@$_GET['order'].'">'.self::$language['pages']['talk.type']['name'].'</a>';}
		$position='';
		$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=$id";
		$r=$pdo->query($sql,2)->fetch(2);
		$position='<a href="./index.php?monxin=talk.title&type='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>';
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position='<a href="./index.php?monxin=talk.type&id='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>'.$position;
		}
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position='<a href="./index.php?monxin=talk.type&id='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>'.$position;
		}
		return $position;
	}
	//===============================================================================================get_type_position	
	function get_content_link($pdo,$id,$title_id=0,$module_config=''){
		if($title_id==0){
			$sql="select `title_id` from ".self::$table_pre."content where `id`=".$id;
			$r=$pdo->query($sql,2)->fetch(2);
			$title_id=$r['title_id'];	
		}
		$sql="select count(id) as c from ".self::$table_pre."content where `title_id`='".$title_id."' and `id`<".$id." and `for`=0";
		$r=$pdo->query($sql,2)->fetch(2);
		if($module_config==''){$module_config=require './program/talk/module_config.php';}
		$end_page=ceil(($r['c']+1)/$module_config['talk.content']['pagesize']);
		$link='./index.php?monxin=talk.content&id='.$title_id.'&current_page='.$end_page."&#content_".$id;
		return $link;		
		
	}


   	function update_type_sum($pdo,$type_id,$d=0){
		$id=$type_id;
		$time=get_unixtime(date('Y-m-d',time()),'Y-m-d');
		$sql="select count(`id`) as c from ".self::$table_pre."title where `type`=".$id." and `visible`=1 and `time`>".$time;
		$r=$pdo->query($sql,2)->fetch(2);
		$day_title_sum=$r['c'];
		
		$sql="select count(`id`) as c from ".self::$table_pre."title where `type`=".$id." and `visible`=1";
		$r=$pdo->query($sql,2)->fetch(2);
		$title_sum=$r['c'];
			
		$sql="select `id` from ".self::$table_pre."title where `type`=".$id;
		$r=$pdo->query($sql,2);
		$content_sum=0;
		foreach($r as $v){
			$sql="select count(`id`) as c from ".self::$table_pre."content where `title_id`=".$v['id'];
			$r2=$pdo->query($sql,2)->fetch(2);
			$content_sum+=$r2['c'];	
		}
		if($d!=0){
			$title_sum--;
			$day_title_sum--;	
		}
		$sql="update ".self::$table_pre."type set `day_title_sum`='".$day_title_sum."',`title_sum`='".$title_sum."',`content_sum`='".$content_sum."' where `id`=".$id;
		$pdo->exec($sql);
			
	}
   
	
}
	

?>