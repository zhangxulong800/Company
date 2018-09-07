<?php
class receive{
	public static $config,$language;
	function __construct(){
		if(!self::$config){
			//echo 'construct<br>';
			global $config,$language,$program,$page;
			$program_config=require_once './program/'.$program.'/config.php';
			$program_language=require_once './program/'.$program.'/language/'.$program_config['program']['language'].'.php';
			self::$config=array_merge($config,$program_config);
			self::$language=array_merge($language,$program_language);
			
		}		
	
	}
	
	
	function __call($method,$args){
		@require "./plugin/set_magic_quotes_gpc_off/set_magic_quotes_gpc_off.php";
		//var_dump( $args);
		$pdo=$args[0];
		$call=$method;
		$class=__CLASS__;
		$method=$class."::".$method;
		require './program/'.self::$config['class_name'].'/receive/'.$call.'.php';
   }
	static function get_group_deep($pdo,$parent){
		$deep=1;
		$r['parent']=$parent;
		while($r['parent']>0){
			$sql="select `parent` from ".$pdo->index_pre."group where `id`='".$r['parent']."'";
			$r=$pdo->query($sql,2)->fetch(2);
			$deep++;
			if($deep>30){exit('endless while');}
		}
		return $deep;
	}
	static function get_group_sub_ids($pdo,$id){
		$ids=array();
		$ids='';
			$sql="select `id` from ".$pdo->index_pre."group where `parent`='".$id."'";
			$r=$pdo->query($sql,2);
			$v['id']=0;
			foreach($r as $v){
				$ids.=$v['id'].',';
				$ids.=receive::get_group_sub_ids($pdo,$v['id']);
			}
		return $ids;
	}
	function get_manager($pdo,$group){
		$sql="select `parent` from ".$pdo->index_pre."group where `id`='".$group."'";
		$r=$pdo->query($sql,2)->fetch(2);
		$parent=$r['parent'];
		$sql="select count(id) as c from ".$pdo->index_pre."user where `group`='".$parent."'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']!=1){return 0;}
		$sql="select `id` from ".$pdo->index_pre."user where `group`='".$parent."'";
		$r=$pdo->query($sql,2)->fetch(2);
		return $r['id'];
	}
   
   function set_power($pdo,$id,$action,$url){
	   if(!is_numeric($url)){
	    //echo $url.',';
		$sql="select `function_power`,`page_power` from ".$pdo->index_pre."group where `id`='$id'";
		$r=$pdo->query($sql,2)->fetch(2);
		//echo $r['function_power'];
		//exit();
		$function_power=explode(",",trim($r['function_power'],","));
		$page_power=explode(",",trim($r['page_power'],","));
		if($action){
			array_push($function_power,$url);
			array_push($page_power,$url);
		}else{
			if(array_search($url,$function_power)>0){
				file_put_contents('power_log.txt',@file_get_contents('power_log.txt')."\r\n key:".array_search($url,$page_power).' '.$page_power[array_search($url,$page_power)].'  '.date('Y-m-d H:i:s'));
				unset($function_power[array_search($url,$function_power)]);
				unset($page_power[array_search($url,$page_power)]);
			}
			
		}
		$function_power=array_unique($function_power);
		$function_power=array_filter($function_power);
		$function_power=implode(",",$function_power);
		
		$page_power=array_unique($page_power);
		$page_power=array_filter($page_power);
		$page_power=implode(",",$page_power);
		
		$sql="update ".$pdo->index_pre."group set `function_power`='$function_power',`page_power`='$page_power' where `id`='$id'";		
		if($pdo->exec($sql)){
			self::update_admin_nv($pdo,$id);
			return ("{'state':'success','info':'<span class=success>&nbsp;</span>'}");
		}else{
			return ("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}	   
	  } 
	}













//=================================================================================================================	
	function get_user_sub_ids($pdo,$id){
		$sql="select `id` from ".$pdo->index_pre."user where `manager`=$id";
		$r=$pdo->query($sql,2);
		$ids='';
		foreach($r as $v){
			$ids.=$v['id'].',';	
			$sql2="select count(id) as c from ".$pdo->index_pre."user where `manager`='".$v['id']."'";
			$r2=$pdo->query($sql2,2)->fetch(2);
			if($r2['c']>0){$ids.=$this->get_group_sub_ids($pdo,$v['id']);}
		}
		return $ids;
		
	}	
//=================================================================================================================	
	function check_user_power($pdo,$id){
		$sql2="select count(id) as c from ".$pdo->index_pre."user where `group`='".$_SESSION['monxin']['group_id']."'";
		$r2=$pdo->query($sql2,2)->fetch(2);
		if($r2['c']==1){
			$groups=index::get_group_sub_ids($pdo,$_SESSION['monxin']['group_id']);	
			$groups=trim($groups,",");
			if($groups==''){$groups=0;}
			$sql="select count(*) as c from ".$pdo->index_pre."user where `group` in ($groups) and `id`='$id'";
			$r=$pdo->query($sql,2)->fetch(2);
			return  $r['c'];
			//echo $groups;
		}else{
			$ids=index::get_user_sub_ids($pdo,$_SESSION['monxin']['id']);	
			$ids=trim($ids,",");
			if($ids==''){$ids=0;}
			$sql="select count(*) as c from ".$pdo->index_pre."user where `id` in ($ids) and `id`='$id'";
			$r=$pdo->query($sql,2)->fetch(2);
			return $r['c'];
		}
	}	


//====================================================================================================================================update_admin_nv start
	function update_admin_nv($pdo,$group_id){
		$sql="select `page_power` from ".$pdo->index_pre."group where `id`=".$group_id;
		$r=$pdo->query($sql,2)->fetch(2);
		$page_power=explode(',',$r['page_power']);
		$one_max=5;
		$map=array();
		$language=array();
		$template=array();
		$path='./program/';
		$array=scandir($path);
		foreach($array as $v){
			if($v!='' && $v!='.' && $v!='..'){
				if(is_dir($path.$v) && is_file($path.$v."/admin_map.php")){
					$a=require($path.$v."/admin_map.php");
					$c=require($path.$v."/config.php");
					$l=require($path.$v."/language/".$c['program']['language'].".php");
					$template[$v]=$c['program']['template_1'];
					foreach($a as $k=>$value){
						$map[$k]=$value;
						if(isset($l['pages'][$k]['name'])){$language[$k]=$l['pages'][$k]['name'];}else{$language[$value]=$l['pages'][$value]['name'];}
						
						if(is_array($value) && count($value)>0){
							foreach($value as $k2=>$value2){
								if(is_array($value2)){
									$key=$k2;
									foreach($value2 as $k3=>$v3){
										if(is_array($v3)){$key3=$k3;}else{$key3=$v3;}
										if(isset($l['pages'][$key3]['name'])){$language[$key3]=$l['pages'][$key3]['name'];}
									}
									}else{$key=$value2;}
								if(isset($l['pages'][$key]['name'])){$language[$key]=$l['pages'][$key]['name'];}
							}	
						}
					}
				}
			}	
		}
		//var_dump($map);
		$sql="select `url` from ".$pdo->index_pre."group_menu where `group_id`=".$group_id." and `visible`=1 order by `sequence` desc , `id` asc ";
		$r=$pdo->query($sql,2);
		$i=0;
		$list=array();
		$other='';
		foreach($r as $v){
			$temp='';
			$program=explode('.',$v['url']);
			$program=$program[0];
			//echo $v['url'];
			if(isset($map[$v['url']])){
				if($i<$one_max){
					
					if(is_array($map[$v['url']]) && (count($map[$v['url']])>1)){
						
						$temp='<a href="./index.php?monxin='.$v['url'].'"><img src=./templates/1/'.$program.'/'.$template[$program].'/page_icon/'.$v['url'].'.png /><span>'.$language[$v['url']].'</span><i class="fa fa-angle-down"></i></a>';
						$temp2='';
					
						foreach($map[$v['url']] as $k2=>$v2){
							$temp3='';
								if(is_array($v2)){
									$key2=$k2;
									
									foreach($v2 as $k3=>$v3){
										if(is_array($v3)){$key3=$k3;}else{$key3=$v3;}
										if(isset($language[$key3])){
											if(in_array($key3,$page_power)){$pw="1";}else{$pw='0';}
											$temp3.='<li pw='.$pw.'><a href="./index.php?monxin='.$key3.'"><img src=./templates/1/'.$program.'/'.$template[$program].'/page_icon/'.$key3.'.png /><span>'.$language[$key3].'</span></a></li>';
										}
									}
									if($temp3!=''){$temp3='<ul>'.$temp3.'</ul>';}
									$temp3='';
									if(isset($language[$key2])){
										if(in_array($key2,$page_power)){$pw="1";}else{$pw='0';}
										$temp2.='<li pw='.$pw.'><a href="./index.php?monxin='.$key2.'"><img src=./templates/1/'.$program.'/'.$template[$program].'/page_icon/'.$key2.'.png /><span>'.$language[$key2].'</span><i class="fa fa-angle-right"></i></a>'.$temp3.'</li>';
									}
									
								}else{
								
									$key2=$v2;
									if(isset($language[$key2])){
										if(in_array($key2,$page_power)){$pw="1";}else{$pw='0';}
										$temp2.='<li pw='.$pw.'><a href="./index.php?monxin='.$key2.'"><img src=./templates/1/'.$program.'/'.$template[$program].'/page_icon/'.$key2.'.png /><span>'.$language[$key2].'</span></a></li>';
									}
								}
								
								

							
							
						}
						if($temp2!=''){$temp2='<ul>'.$temp2.'</ul>';}
						$temp.=$temp2;	
					}else{
						
						$temp='<a  href="./index.php?monxin='.$v['url'].'"><img src=./templates/1/'.$program.'/'.$template[$program].'/page_icon/'.$v['url'].'.png /><span>'.$language[$v['url']].'</span></a>';
					}
					
					if(in_array($v['url'],$page_power)){$pw="1";}else{$pw='0';}
					$list[$i]='<li pw='.$pw.'>'.$temp.'</li>';	
					$i++;	
				}else{
					
//--------------------------------------------------------------------------------------------------------------------------------more start					
					if(!isset($list[$one_max])){$list[$one_max]='';}
					if( is_array($map[$v['url']]) && (count($map[$v['url']]) >0) ){
						$temp='';
						$temp2='';
					
						foreach($map[$v['url']] as $k2=>$v2){
							$temp3='';
								if(is_array($v2)){
									$key2=$k2;
								}else{
									$key2=$v2;
								}
								if(isset($language[$key2])){
									if(in_array($key2,$page_power)){$pw="1";}else{$pw='0';}
									$temp2.='<li pw='.$pw.'><a href="./index.php?monxin='.$key2.'"><img src=./templates/1/'.$program.'/'.$template[$program].'/page_icon/'.$key2.'.png /><span>'.$language[$key2].'</span></a></li>';
								}
						}
						$temp.=$temp2;	
						if(in_array($v['url'],$page_power)){$pw="1";}else{$pw='0';}
						$list[$one_max].='<li pw='.$pw.'><a href="./index.php?monxin='.$v['url'].'"><img src=./templates/1/'.$program.'/'.$template[$program].'/page_icon/'.$v['url'].'.png /><span>'.$language[$v['url']].'</span></a><ul>'.$temp.'</ul></li>';	
					}else{
						if(in_array($v['url'],$page_power)){$pw="1";}else{$pw='0';}
						$other.='<li pw='.$pw.'><a href="./index.php?monxin='.$v['url'].'"><img src=./templates/1/'.$program.'/'.$template[$program].'/page_icon/'.$v['url'].'.png /><span>'.$language[$v['url']].'</span></a></li>';
					}
					
					
//----------------------------------------------------------------------------------------------------------------------------------more end					
				}	
			}
			
		}
		//var_dump($other);
		if($other!=''){$other='<li><a><img src="./templates/1/index/default/page_icon/index.index.png" /><span>'.self::$language['composite'].'</span></a><ul>'.$other.'</ul></li>';}
		if(!isset($list[$one_max])){$list[$one_max]='';}
		$list[$one_max]=$list[$one_max];
		if($list[$one_max]!=''){$icon='./program/index/navigation_icon/more.png';$list[$one_max]='<li><a href="#"  id=more_admin><img src='.$icon.' /> '.self::$language['more'].'<i class="fa fa-angle-down"></i></a><ul class=more_ul>'.$list[$one_max].'</ul></li>';	}
		
		
		$str='<li><a href="./index.php">'.self::$language['home'].'</a></li>';
		$str='';
		foreach($list as $k=>$v){
			$str.=$v;	
		}
		//echo $str;
		$sql="update ".$pdo->index_pre."group set `map`='".$other.$str."' where `id`=".$group_id;
		$pdo->exec($sql);
	}
//====================================================================================================================================update_admin_nv end

	

//====================================================================================================================================update_navigation start
	function update_navigation($pdo){
		$one_max=self::$config['navigation_one_max'];
		$sql="select `id`,`name`,`url`,`open_target`,`parent_id` from ".$pdo->index_pre."navigation where `parent_id`=0 and `visible`=1 order by `sequence` desc";
		$r=$pdo->query($sql,2);
		$i=0;
		$list=array();
		$other='';
		foreach($r as $v){
			$temp='';
			if($i<$one_max){
				$sql2="select * from ".$pdo->index_pre."navigation where `parent_id`='".$v['id']."' and `visible`=1 order by `sequence` desc";
				$r2=$pdo->query($sql2,2);
					$icon='./program/index/navigation_icon/'.$v['id'].'.png';
					if(!is_file($icon)){$icon='./program/index/navigation_icon/default.png';}
					$temp='<a href="'.$v['url'].'" target="'.$v['open_target'].'"><img wsrc="'.$icon.'" /><span>'.$v['name'].'</span><i class="fa fa-angle-down"></i></a>';
					$temp2='';
				
					foreach($r2 as $v2){
						$temp3='';
						$sql3="select * from ".$pdo->index_pre."navigation where `parent_id`='".$v2['id']."' and `visible`=1 order by `sequence` desc";
						$r3=$pdo->query($sql3,2);
							foreach($r3 as $v3){
								$icon='./program/index/navigation_icon/'.$v3['id'].'.png';
								if(!is_file($icon)){$icon='./program/index/navigation_icon/default.png';}
								$temp3.='<li><a href="'.$v3['url'].'" target="'.$v3['open_target'].'"><img wsrc="'.$icon.'" /><span>'.$v3['name'].'</span></a></li>';
							}
						$icon='./program/index/navigation_icon/'.$v2['id'].'.png';
						if(!is_file($icon)){$icon='./program/index/navigation_icon/default.png';}
						if($temp3!=''){	
							if($temp3!=''){$temp3='<ul>'.$temp3.'</ul>';}	
						$temp2.='<li><a href="'.$v2['url'].'" target="'.$v2['open_target'].'"><img wsrc="'.$icon.'" /><span>'.$v2['name'].'</span><i class="fa fa-angle-right"></i></a>'.$temp3.'</li>';							
						}else{
							$temp2.='<li><a href="'.$v2['url'].'" target="'.$v2['open_target'].'"><img wsrc="'.$icon.'" /><span>'.$v2['name'].'</span></a></li>';
						}
					}
				if($temp2!=''){	
					if($temp2!=''){$temp2='<ul>'.$temp2.'</ul>';}
					$temp.=$temp2;	
				}else{
					$icon='./program/index/navigation_icon/'.$v['id'].'.png';
					if(!is_file($icon)){$icon='./program/index/navigation_icon/default.png';}
					$temp='<a href="'.$v['url'].'" target="'.$v['open_target'].'"><img wsrc="'.$icon.'" /><span>'.$v['name'].'</span></a>';
				}
				$list[$i]='<li>'.$temp.'</li>';	
				$i++;	
			}else{
	//--------------------------------------------------------------------------------------------------------------------------------more start					
				if(!isset($list[$one_max])){$list[$one_max]='';}
				$sql2="select * from ".$pdo->index_pre."navigation where `parent_id`='".$v['id']."' and `visible`=1 order by `sequence` desc";
				$r2=$pdo->query($sql2,2);
				$temp='';
				$temp2='';
			
				foreach($r2 as $k2=>$v2){
					$icon='./program/index/navigation_icon/'.$v2['id'].'.png';
					if(!is_file($icon)){$icon='./program/index/navigation_icon/default.png';}
					$temp2.='<li><a href="'.$v2['url'].'" target="'.$v2['open_target'].'"><img wsrc="'.$icon.'" /><span>'.$v2['name'].'</span></a></li>';
				}
				$temp.=$temp2;	
				$icon='./program/index/navigation_icon/'.$v['id'].'.png';
				if(!is_file($icon)){$icon='./program/index/navigation_icon/default.png';}
				$list[$one_max].='<li><a href="'.$v['url'].'" target="'.$v['open_target'].'"><img wsrc="'.$icon.'" /><span>'.$v['name'].'</span></a><ul>'.$temp.'</ul></li>';				
	//----------------------------------------------------------------------------------------------------------------------------------more end					
			}	
			
			
		}
		//var_dump($other);
		if($other!=''){$other='<li><a>'.self::$language['composite'].'</a><ul>'.$other.'</ul></li>';}
		if(!isset($list[$one_max])){$list[$one_max]='';}
		$list[$one_max]=$other.$list[$one_max];
		if($list[$one_max]!=''){
			$icon='./program/index/navigation_icon/more.png';
			$list[$one_max]='<li><a href="#"  id=more_admin><img wsrc="'.$icon.'" /><span>'.self::$language['more'].'</span><i class="fa fa-angle-down"></i></a><ul>'.$list[$one_max].'</ul></li>';	
		}
		
		
		$str='';
		foreach($list as $k=>$v){
			$str.=$v;	
		}
		//echo $str;
		return file_put_contents('./program/index/navigation.txt',$str);
	}
//====================================================================================================================================update_navigation end

	
	
	function sum_modules($pdo){
		$sums=array();
		$path='./program/';
		$r=scandir($path);
		foreach($r as $v){
			if($v!='.' && $v!='..' && is_dir($path.$v)){
				$config=require($path.$v.'/config.php');
				if(!isset($config['dashboard_module'])){continue;}
				foreach($config['dashboard_module'] as $v2){
					$sql="select `id` from ".$pdo->index_pre."sum_modules where `key`='".$v2."' limit 0,1";
					$r3=$pdo->query($sql,2)->fetch(2);
					if($r3['id']==''){
						$sql="insert into ".$pdo->index_pre."sum_modules (`key`) values ('".$v2."')";
						$pdo->exec($sql);	
					}
				}	
			} 	
		}
	}
	
	
}
?>