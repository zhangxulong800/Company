<?php
class index{
	public static $config,$language,$module_config;
	function __construct(){
		if(!self::$config){
			//echo 'construct<br>';
			global $config,$language,$page;
			$program=__CLASS__;
			$program_config=require './program/'.$program.'/config.php';
			$program_language=require './program/'.$program.'/language/'.$program_config['program']['language'].'.php';
			self::$config=array_merge($config,$program_config);
			self::$config['web']=array_merge(self::$config['web'],$program_config['program']);
			self::$language=array_merge($language,$program_language);
			self::$module_config=require'./program/'.$program.'/module_config.php';
		}		
		//echo 'index __construct<br/>';
	}
	function __call($method,$args){
		$pdo=$args[0];
		$call=$method;
		$class=__CLASS__;
		$method=$class."::".$method;
		if(in_array($class.'.'.$call,self::$config['program_unlogin_function_power'])){$m_require_login=0;}else{$m_require_login=1;}
		require './program/'.$class.'/show/'.$call.'.php';
   }
   
   
	//==========================================================================================================	
	function get_select_id($pdo,$type,$v){
		$sql="select * from ".$pdo->index_pre."select where `type`='$type'";
		$stmt=$pdo->query($sql,2);
		$temp=$v;
		$module[$type]="";
		foreach($stmt as $v){
			if($temp==$v['value']){$selected='selected';}else{$selected='';}
			$module[$type].="<option value='".$v['value']."' $selected >".$v['name']."</option>";	
		}
		return $module[$type];			
	}
	
	//==========================================================================================================	
	static function get_user_real_name($pdo,$field,$v){
		$sql="select `real_name` from ".$pdo->index_pre."user where `$field`='$v'";
		$r=$pdo->query($sql,2)->fetch(2);
		return $r['real_name'];			
	}
	//==========================================================================================================	
	static function get_group_name($pdo,$id){
		$sql="select `name` from ".$pdo->index_pre."group where `id`='$id'";
		$r=$pdo->query($sql,2)->fetch(2);
		return $r['name'];			
	}
	//==========================================================================================================	
	
	static function get_manager($pdo,$id,$group,$manager){
		
		$sql="select `parent` from ".$pdo->index_pre."group where `id`='$group'";
		$r=$pdo->query($sql,2)->fetch(2);
		$groups=array();
		$loop=0;
		while($r['parent']!=0){
			$sql="select `name`,`id`,`parent` from ".$pdo->index_pre."group where `id`='".$r['parent']."'";
			$r=$pdo->query($sql,2)->fetch(2);
			$groups[$r['id']]=$r['name'];
			$loop++;
			if($loop>30){break;}
		}
		$r['manager']=$manager;
		$managers=array();
		$loop=0;
		while($r['manager']!=0){
			$sql="select `real_name`,`group`,`manager`  from ".$pdo->index_pre."user where `id`='".$r['manager']."'";
			$r=$pdo->query($sql,2)->fetch(2);
			$managers[$r['group']]=$r['real_name'];
			$loop++;
			if($loop>30){break;}

		}
		//var_dump($groups);
		$str='';
		foreach($groups as $key=>$v){
			$real_name=@$managers[$key];
			if($real_name==''){
				$sql="select count(id) as c from ".$pdo->index_pre."user where `group`='$key'";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['c']==1){
					$sql="select `real_name` from ".$pdo->index_pre."user where `group`='$key'";
					$r=$pdo->query($sql,2)->fetch(2);
					$real_name=$r['real_name'];
				}	
			}
			$str.=$v.'['.$real_name.']<-';
		}
		return trim($str,'<-');
					
	}
	//==========================================================================================================	
	static function get_group_select($pdo,$v,$id){
		
		$sql="select `name`,`id`,`parent`,`deep` from ".$pdo->index_pre."group where `parent`='$id' order by `sequence` desc";
		$stmt=$pdo->query($sql,2);
		$temp=$v;
		$list="";
		foreach($stmt as $v){
			$padding='';
			$deep=$v['deep']-1;
			for($i=0;$i<$deep;$i++){$padding.="&nbsp;&nbsp;&nbsp;&nbsp;";}
			
			if($temp==$v['id']){$selected='selected';}else{$selected='';}
			$list.="<option value='".$v['id']."' $selected >$padding".$v['name']."</option>";
			if($v['parent']==0){$count=1;}
			$list.=index::get_group_select($pdo,0,$v['id']);
		}
		return $list;			
	}
	
//=================================================================================================================	
	static function get_group_deep($pdo,$parent){
		$deep=0;
		$r['parent']=$parent;
		while($r['parent']>0){
			$sql="select `parent` from ".$pdo->index_pre."group where `id`='".$r['parent']."'";
			$r=$pdo->query($sql,2)->fetch(2);
			$deep++;
		}
		return $deep;
	}
	
//=================================================================================================================	
	static function count_group($pdo,$id){
		$sql="select count(id) as c from ".$pdo->index_pre."user where `group`='".$id."'";
		$r=$pdo->query($sql,2)->fetch(2);
		return $r['c'];
	}
	
//=================================================================================================================	
	static function get_groups($pdo,$id,$url){
		$sql="select `name`,`id`,`parent`,`deep` from ".$pdo->index_pre."group where `parent`='$id' order by `sequence` desc";
		$stmt=$pdo->query($sql,2);
		$list="";
		foreach($stmt as $v){
			$list.="<a href='".$url.$v['id']."' style='width:".(100-$v['deep']*10)."%;' id='group_".$v['id']."'>".$v['name']."</a>";
			if($v['parent']==0){$name_count=1;}
			$list.=index::get_groups($pdo,$v['id'],$url);
		}
		return $list;			
	}
//=================================================================================================================	
	static function get_program_option($pdo){
		$sql="select `name` from ".$pdo->index_pre."program  order by `id` asc";
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			if(!file_exists('./program/'.$v['name'].'/config.php')){continue;}
			$program_config=require('./program/'.$v['name'].'/config.php');
			$language=require('./program/'.$v['name'].'/language/'.$program_config['program']['language'].'.php');
			$list.='<option value="'.$v['name'].'">'.$language['program_name'].'</option>';	
		}
		return $list;			
	}

//=================================================================================================================	
	static function get_group_sub_ids($pdo,$id){
		$sql="select `id` from ".$pdo->index_pre."group where `parent`=$id";
		$r=$pdo->query($sql,2);
		$ids='';
		foreach($r as $v){
			$ids.=$v['id'].',';	
			$sql2="select count(id) as c from ".$pdo->index_pre."group where `parent`='".$v['id']."'";
			$r2=$pdo->query($sql2,2)->fetch(2);
			if($r2['c']>0){$ids.=index::get_group_sub_ids($pdo,$v['id']);}
		}
		return $ids;
		
	}	
//=================================================================================================================	
	static function get_user_sub_ids($pdo,$id){
		$sql="select `id` from ".$pdo->index_pre."user where `manager`=$id";
		$r=$pdo->query($sql,2);
		$ids='';
		foreach($r as $v){
			$ids.=$v['id'].',';	
			$sql2="select count(id) as c from ".$pdo->index_pre."user where `manager`='".$v['id']."'";
			$r2=$pdo->query($sql2,2)->fetch(2);
			if($r2['c']>0){$ids.=index::get_group_sub_ids($pdo,$v['id']);}
		}
		return $ids;
		
	}	
//=================================================================================================================	
	static function check_user_power($pdo,$id){
		$sql2="select count(id) as c from ".$pdo->index_pre."user where `group`='".$_SESSION['monxin']['group_id']."'";
		$r2=$pdo->query($sql2,2)->fetch(2);
		if($r2['c']==1 || $_SESSION['monxin']['group_id']==1){
			$groups=index::get_group_sub_ids($pdo,$_SESSION['monxin']['group_id']);	
			$groups=trim($groups,",");
			if($groups==''){$groups=0;}
			$sql="select count(*) as c from ".$pdo->index_pre."user where `group` in ($groups) and `id`='$id'";
			$r=$pdo->query($sql,2)->fetch(2);
			return  $r['c'];
			
		}else{
			$ids=index::get_user_sub_ids($pdo,$_SESSION['monxin']['id']);	
			$ids=trim($ids,",");
			if($ids==''){$ids=0;}
			$sql="select count(*) as c from ".$pdo->index_pre."user where `id` in ($ids) and `id`='$id'";
			$r=$pdo->query($sql,2)->fetch(2);
			return $r['c'];
		}
	}	
}
?>