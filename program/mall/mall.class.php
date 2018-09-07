<?php
/**
 *	商城数据显示类 示例 ./index.php?monxin=mall.goods_add (monxin=类名.方法名)，大部分情况是通过 __call方法 加载执行 ./program/mall/show/ 目录下的对应名称的文件
 */
class mall{
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
				self::update_cart($pdo,self::$table_pre);	
			}
			
			self::get_shop_id($pdo);
			$sql="select `username` from ".self::$table_pre."shop where `id`=".SHOP_ID;
			$r=$pdo->query($sql,2)->fetch(2);
			define("SHOP_MASTER", $r['username']);
			
			if(isset($_SESSION['monxin']['username'])){
				if(!isset($_SESSION['monxin'][SHOP_ID.'_discount'])){
					$sql="select `group_id` from ".self::$table_pre."shop_buyer where `shop_id`=".SHOP_ID." and `username`='".$_SESSION['monxin']['username']."'  limit 0,1";
					$r=$pdo->query($sql,2)->fetch(2);
					/*
					if($r['group_id']=='' || $r['group_id']<1){
						self::add_shop_buyer($pdo,$_SESSION['monxin']['username'],SHOP_ID);//自动添加到店内会员
						$sql="select `group_id` from ".self::$table_pre."shop_buyer where `shop_id`=".SHOP_ID." and `username`='".$_SESSION['monxin']['username']."'  limit 0,1";
						$r=$pdo->query($sql,2)->fetch(2);
					}
					*/
					if($r['group_id']=='' || $r['group_id']<1){
							$_SESSION['monxin'][SHOP_ID.'_shop_group']='';
							$_SESSION['monxin'][SHOP_ID.'_discount']=10;
							$_SESSION['monxin'][SHOP_ID.'_group_id']=0;
					}else{
						$sql="select `name`,`discount`,`id` from ".self::$table_pre."shop_buyer_group where `id`=".$r['group_id']." and `shop_id`=".SHOP_ID." limit 0,1";
						$r=$pdo->query($sql,2)->fetch(2);
						$_SESSION['monxin'][SHOP_ID.'_shop_group']=$r['name'];
						$_SESSION['monxin'][SHOP_ID.'_discount']=$r['discount'];
						$_SESSION['monxin'][SHOP_ID.'_group_id']=$r['id'];
					}
						
				}		
			}
			self::exe_task_($pdo,$program_config);
			//echo '!isset<hr>';	
		}
		//echo '__construct<hr>';		
	}

	function __call($method,$args){
		$call_old_method=$method;
		$pdo=$args[0];
		$call=$method;
		if(in_array('mall.'.$call,self::$config['program_unlogin_function_power'])){if(self::$config['pay_mode']!='money'){self::$language['yuan']=self::$language['credits_s'];}}
		
		$class=__CLASS__;
		if(self::$one_task && $method!='cart'){
			$m_require_login=0;
			$method='mall::cart';
			require './program/mall/show/cart.php';
			//$method='mall::search';
			//require './program/mall/show/search.php';
			self::$one_task=false;	
		}
		$class=__CLASS__;
		$method=$call_old_method;
		$call=$method;
		$method=$class."::".$method;
		if(in_array($class.'.'.$call,self::$config['program_unlogin_function_power'])){$m_require_login=0;}else{$m_require_login=1;}		
		require './program/'.$class.'/show/'.$call.'.php';
   }

//======================================================================================================= 执行任务
	function exe_task_($pdo,$program_config){
		$program_config=self::exe_task_y($pdo,$program_config);
		$program_config=self::exe_task_m($pdo,$program_config);
		$program_config=self::exe_task_w($pdo,$program_config);
		$program_config=self::exe_task_d($pdo,$program_config);
		$program_config=self::exe_task_h($pdo,$program_config);
		$program_config=self::exe_task_minute($pdo,$program_config);
	}

//======================================================================================================= 执行年任务
	function exe_task_y($pdo,$program_config){
		
		$v=date('Y',time());
		if($v==$program_config['task_y']){return $program_config;}
		$program_config['task_y']=$v;
		self::reset_interest_year($pdo);
		
		
		file_put_contents('./program/mall/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行月任务
	function exe_task_m($pdo,$program_config){
		$v=date('Y-m',time());
		if($v==$program_config['task_m']){return $program_config;}
		$program_config['task_m']=$v;
		self::reset_interest_month($pdo);
		
		
		file_put_contents('./program/mall/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行周任务
	function exe_task_w($pdo,$program_config){
		$v=date('W',time());
		if($v==$program_config['task_w']){return $program_config;}
		$program_config['task_w']=$v;
		self::reset_interest_week($pdo);
		
		
		file_put_contents('./program/mall/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行日任务
	function exe_task_d($pdo,$program_config){
		$v=date('Y-m-d',time());
		if($v==$program_config['task_d']){return $program_config;}
		$program_config['task_d']=$v;
		
			self::update_pre_sale_goods($pdo);
			self::update_pre_sale_order_13($pdo);
			self::reset_interest_day($pdo);
			
		file_put_contents('./program/mall/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行时任务
	function exe_task_h($pdo,$program_config){
		$v=date('Y-m-d H',time());
		if($v==$program_config['task_h']){return $program_config;}
		$program_config['task_h']=$v;
		
		
		
		file_put_contents('./program/mall/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行分钟任务
	function exe_task_minute($pdo,$program_config){
		$v=date('Y-m-d H:i',time());
		if($v==$program_config['task_minute']){return $program_config;}
		$program_config['task_minute']=$v;
		
		file_put_contents('./program/mall/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 获取 店铺自定义网页 Title
	function diypage_show_head_data($pdo){
		$id=intval(@$_GET['id']);
		if($id>0){
			$sql="select `title` from ".self::$table_pre."diypage where `id`='$id' and `visible`=1";
			$r=$pdo->query($sql,2)->fetch(2);
			$r=de_safe_str($r);
			$r['title']=@$r['title'];
			$v['title']=@$r['title'];	
			$v['keywords']=@$r['title'];	
			$v['description']=@$r['title'];	
			return $v;
		}
	}
//======================================================================================================= 获取 店铺首页 Title
	function shop_index_head_data($pdo){
		$sql="select `name` from ".self::$table_pre."shop where `id`=".SHOP_ID;
		$r=$pdo->query($sql,2)->fetch(2);
		$v['title']=@$r['name'];	
		$v['keywords']=@$r['name'];	
		$v['description']=@$r['name'];	
		return $v;
	}
//======================================================================================================= 获取 商品详情页 Title
	function goods_head_data($pdo){
		$id=intval(@$_GET['id']);
		if($id>0 && SHOP_ID!='' && SHOP_ID!=0){
			$sql="select `name` from ".self::$table_pre."shop where `id`=".SHOP_ID;
			$s=$pdo->query($sql,2)->fetch(2);
			$sql="select `shop_type`,`title` from ".self::$table_pre."goods where `id`='$id'";
			$r=$pdo->query($sql,2)->fetch(2);
			$r=de_safe_str($r);
			$r['title']=@$r['title'].'-'.self::get_shop_type_title($pdo,$r['shop_type']).'-'.$s['name'];
			$v['title']=@$r['title'];	
			$v['keywords']=@$r['title'];	
			$v['description']=@$r['title'];	
			return $v;
		}
	}
	
//======================================================================================================= 获取 平台商品列表页 Title
	function goods_list_head_data($pdo){
		$v=array();
		$v['title']='';	
		$v['keywords']='';	
		$v['description']='';	
		if(@$_GET['tag']!=''){
			$sql="select `name` from ".self::$table_pre."tag where `id`=".intval($_GET['tag']);
			$r=$pdo->query($sql,2)->fetch(2);	
			$v['title'].=' '.de_safe_str($r['name']);
			$v['keywords']=$v['title'];	
			$v['description']=$v['title'];	
		}
		$circle=intval($_COOKIE['circle']);
		if($circle>0){
			$sql="select `name` from ".$pdo->index_pre."circle where `id`=".$circle;
			$r=$pdo->query($sql,2)->fetch(2);	
			$v['title'].=' '.de_safe_str($r['name']);
			$v['keywords']=$v['title'];	
			$v['description']=$v['title'];	
			
		}
		if(@$_GET['store_tag']!=''){
			$sql="select `name` from ".self::$table_pre."store_tag where `id`=".intval($_GET['store_tag']);
			$r=$pdo->query($sql,2)->fetch(2);	
			$v['title'].=' '.de_safe_str($r['name']);
			$v['keywords']=$v['title'];	
			$v['description']=$v['title'];	
			
		}
		if(@$_GET['search']!=''){
			$v['title'].=' '.$_GET['search'];
			$v['keywords']=$v['title'];	
			$v['description']=$v['title'];	
			
		}
		
		
		if($v['title']==''){
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
	
//======================================================================================================= 获取 平台店铺列表页 Title
	function shop_list_head_data($pdo){
		$v=array();
		$r['title']='';
		$v['title']='';	
		$v['keywords']='';	
		$v['description']='';	
		if(@$_GET['tag']!=''){
			$sql="select `name` from ".self::$table_pre."store_tag where `id`=".intval($_GET['tag']);
			$r=$pdo->query($sql,2)->fetch(2);	
			$v['title'].=de_safe_str($r['name']);
			$v['keywords']=$v['title'];	
			$v['description']=$v['title'];	
			
		}
		if(@$_GET['circle']!=''){
			$sql="select `name` from ".$pdo->index_pre."circle where `id`=".intval($_GET['circle']);
			$r=$pdo->query($sql,2)->fetch(2);	
			$v['title'].=' '.de_safe_str($r['name']);
			$v['keywords']=$v['title'];	
			$v['description']=$v['title'];	
			
		}
		if(@$_GET['search']!=''){
			$v['title'].=' '.$_GET['search'];
			$v['keywords']=$v['title'];	
			$v['description']=$v['title'];	
			
		}
		return $v;
	}
	
//======================================================================================================= 获取 店内商品列表页详情页 Title
	function shop_goods_list_head_data($pdo){
		$sql="select `name` from ".self::$table_pre."shop where `id`=".SHOP_ID;
		$s=$pdo->query($sql,2)->fetch(2);
		$v=array();
		if(@$_GET['tag']!=''){
			$sql="select `name` from ".self::$table_pre."shop_tag where `id`=".intval($_GET['tag']);
			$r=$pdo->query($sql,2)->fetch(2);	
					$r['title']=$r['name'].'-'.$s['name'];
					$v['title']=$r['title'];	
					$v['keywords']=$r['title'];	
					$v['description']=$r['title'];	
			
		}elseif(@$_GET['search']!=''){
					$r['title']=$_GET['search'].'-'.$s['name'];
					$v['title']=$r['title'];	
					$v['keywords']=$r['title'];	
					$v['description']=$r['title'];	
			
		}else{
			$id=intval(@$_GET['type']);
			if($id>0){
				$r['title']=self::get_shop_type_title($pdo,$id).'-'.$s['name'];
				$v['title']=$r['title'];	
				$v['keywords']=$r['title'];	
				$v['description']=$r['title'];	
			}
		}
		return $v;
	}
	




//======================================================================================================= 获取 平台商品分类 上级选项
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
	

//======================================================================================================= 获取 店内商品分类 上级选项
	function get_shop_parent($pdo,$id=0,$deep=3){
		$sql="select `name`,`id` from ".self::$table_pre."shop_type where `shop_id`=".SHOP_ID." and `parent`=0 and `id`!='$id' order by `sequence` desc";
		$stmt=$pdo->query($sql,2);
		$module['parent']="";
		foreach($stmt as $v){
			$v['name']=de_safe_str($v['name']);
			$module['parent'].="<option value='".$v['id']."'>&nbsp;&nbsp;&nbsp;&nbsp;".$v['name']."</option>";
			if($deep>1){
				$sql2="select `name`,`id` from ".self::$table_pre."shop_type where `shop_id`=".SHOP_ID." and `parent`=".$v['id']." and `id`!='$id' order by `sequence` desc";
				$r=$pdo->query($sql2,2);
				foreach($r as $v2){
					$v2['name']=de_safe_str($v2['name']);
					$module['parent'].="<option value='".$v2['id']."' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$v2['name']."</option>";
					if($deep>2){
						
						$sql3="select `name`,`id` from ".self::$table_pre."shop_type where `shop_id`=".SHOP_ID." and `parent`=".$v2['id']." and `id`!='$id' order by `sequence` desc";
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
	
//======================================================================================================= 获取 平台商品分类 上级ID
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

//======================================================================================================= 获取 店内商品分类 上级ID
	function get_shop_type_ids($pdo,$id){
		$sql="select `id` from ".self::$table_pre."shop_type where `parent`=$id and `shop_id`=".SHOP_ID;
		$r=$pdo->query($sql,2);
		$ids=$id.',';
		foreach($r as $v){
			$ids.=$v['id'].',';
			$sql2="select `id` from ".self::$table_pre."shop_type where `parent`=".$v['id']." and `shop_id`=".SHOP_ID;
			$r2=$pdo->query($sql2,2);
			foreach($r2 as $v2){
				$ids.=$v2['id'].',';
				$sql3="select `id` from ".self::$table_pre."shop_type where `parent`=".$v2['id']." and `shop_id`=".SHOP_ID;
				$r3=$pdo->query($sql3,2);
				foreach($r3 as $v3){
					$ids.=$v3['id'].',';
				}
			}
			
		}
		return trim($ids,',');
	}

//======================================================================================================= 获取 平台商品分类 上级名称
	function get_type_names($pdo,$id,$target,$title=''){
		$names='<a href="./index.php?monxin=mall.goods_list&type='.$id.'" class=parent target='.$target.'>'.$title.'</a>';			
		$sql="select `id`,`name`,`url` from ".self::$table_pre."type where `parent`=$id and `visible`=1 order by `sequence` desc,`id` desc";
		$r=$pdo->query($sql,2);
		//echo $sql;
		$names.='<div class=type_deep_1>';
		foreach($r as $v){
			$v=de_safe_str($v);
			if($v['url']==''){$v['url']='./index.php?monxin=mall.goods_list&type='.$v['id'];}
			$names.='<a href="'.$v['url'].'" id="type_'.$v['id'].'" target='.$target.'><b class=n>'.$v['name'].'</b><p class=show_sub>&nbsp;</p></a>';
			$sql2="select `id`,`name`,`url` from ".self::$table_pre."type where `parent`=".$v['id']." and `visible`=1 order by `sequence` desc,`id` desc";
			$r2=$pdo->query($sql2,2);
			$names.='<div id=type_'.$v['id'].'_div class="type_deep_2">';
			foreach($r2 as $v2){
				$v2=de_safe_str($v2);
				if($v2['url']==''){$v2['url']='./index.php?monxin=mall.goods_list&type='.$v2['id'];}
				$names.='<a href="'.$v2['url'].'" id="type_'.$v2['id'].'" target='.$target.'><b class=n>'.$v2['name'].'</b><p class=show_sub>&nbsp;</p></a>';
				$sql3="select `id`,`name`,`url` from ".self::$table_pre."type where `parent`=".$v2['id']." and `visible`=1 order by `sequence` desc,`id` desc";
				$r3=$pdo->query($sql3,2);
				$names.='<div id=type_'.$v2['id'].'_div class="type_deep_3">';
				foreach($r3 as $v3){
					$v3=de_safe_str($v3);
					if($v3['url']==''){$v3['url']='./index.php?monxin=mall.goods_list&type='.$v3['id'];}
					$names.='<a href="'.$v3['url'].'" id="type_'.$v3['id'].'" target='.$target.'>'.$v3['name'].'</a>';
				}
				$names.='</div>';
			}
			$names.='</div>';
		
		}
		$names.='</div>';
		return $names;
	}

//======================================================================================================= 获取 店内商品分类 上级名称
	function get_shop_type_names($pdo,$id,$target,$title=''){
		$names='<a href="./index.php?monxin=mall.shop_goods_list&shop_id='.SHOP_ID.'&type='.$id.'" class=parent target='.$target.'>'.$title.'</a>';			
		$sql="select `id`,`name` from ".self::$table_pre."shop_type where `parent`=$id and `visible`=1 and `shop_id`=".SHOP_ID." order by `sequence` desc,`id` desc";
		$r=$pdo->query($sql,2);
		//echo $sql;
		$names.='<div class=type_deep_1>';
		foreach($r as $v){
			$v=de_safe_str($v);
			$v['url']='./index.php?monxin=mall.shop_goods_list&shop_id='.SHOP_ID.'&type='.$v['id'];
			$names.='<a href="'.$v['url'].'" id="type_'.$v['id'].'" target='.$target.'><b class=n>'.$v['name'].'</b><p class=show_sub>&nbsp;</p></a>';
			$sql2="select `id`,`name` from ".self::$table_pre."shop_type where `parent`=".$v['id']." and `visible`=1 and `shop_id`=".SHOP_ID." order by `sequence` desc,`id` desc";
			$r2=$pdo->query($sql2,2);
			$names.='<div id=type_'.$v['id'].'_div class="type_deep_2">';
			foreach($r2 as $v2){
				$v2=de_safe_str($v2);
				$v2['url']='./index.php?monxin=mall.shop_goods_list&shop_id='.SHOP_ID.'&type='.$v2['id'];
				$names.='<a href="'.$v2['url'].'" id="type_'.$v2['id'].'" target='.$target.'><b class=n>'.$v2['name'].'</b><p class=show_sub>&nbsp;</p></a>';
				$sql3="select `id`,`name` from ".self::$table_pre."shop_type where `parent`=".$v2['id']." and `visible`=1 and `shop_id`=".SHOP_ID." order by `sequence` desc,`id` desc";
				$r3=$pdo->query($sql3,2);
				$names.='<div id=type_'.$v2['id'].'_div class="type_deep_3">';
				foreach($r3 as $v3){
					$v3=de_safe_str($v3);
					$v3['url']='./index.php?monxin=mall.shop_goods_list&shop_id='.SHOP_ID.'&type='.$v3['id'];
					$names.='<a href="'.$v3['url'].'" id="type_'.$v3['id'].'" target='.$target.'>'.$v3['name'].'</a>';
				}
				$names.='</div>';
			}
			$names.='</div>';
		
		}
		$names.='</div>';
		return $names;
	}
//======================================================================================================= 获取 店铺名称
	function get_shop_name($pdo,$id){
		if(intval($id)==0){return '0';}
		$sql="select `name` from ".self::$table_pre."shop where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['name']==''){$r['name']=$id;}
		return $r['name'];
	}
//======================================================================================================= 获取 店主用户名
	function get_shop_master($pdo,$id){
		if(intval($id)==0){return '0';}
		$sql="select `username` from ".self::$table_pre."shop where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['username']==''){$r['username']=$id;}
		return $r['username'];
	}
//======================================================================================================= 获取 店铺ID
	function get_shop_id($pdo){
		if(defined('SHOP_ID')){return false;}
		if(intval(@$_GET['shop_id'])!=0){define("SHOP_ID", intval($_GET['shop_id']));return true;}
		
		
		$monxin=@$_GET['monxin'];
		if($monxin=='mall.shop_index' && @$_GET['domain']!=''){
			$domain_pre=explode('.',$_GET['domain']);
			$domain_pre=safe_str($domain_pre[0]);
			$sql="select `id` from ".self::$table_pre."shop where `domain`='".$domain_pre."'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){header('location:http://'.self::$config['web']['domain']);exit('domain err');}
			$_GET['shop_id']=$r['id'];
			define("SHOP_ID", $r['id']);return true;
		}
		if($monxin=='mall.shop_goods_list' && intval(@$_GET['type'])>0){
			$sql="select `shop_id` from ".$pdo->sys_pre."mall_shop_type where `id`=".intval($_GET['type']);
			$r=$pdo->query($sql,2)->fetch(2);
			define("SHOP_ID", $r['shop_id']);return true;
		}
		if(($monxin=='mall.goods' || $monxin=='mall.gbuy_goods') && intval(@$_GET['id'])>0){
			$sql="select `shop_id` from ".$pdo->sys_pre."mall_goods where `id`=".intval($_GET['id']);
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['shop_id']==''){$r['shop_id']=0;}
			define("SHOP_ID", $r['shop_id']);return true;
		}
		if($monxin=='mall.diypage_show' && intval(@$_GET['id'])>0){
			$sql="select `shop_id` from ".$pdo->sys_pre."mall_diypage where `id`=".intval($_GET['id']);
			$r=$pdo->query($sql,2)->fetch(2);
			define("SHOP_ID", $r['shop_id']);return true;
		}
		if(isset($_SESSION['monxin']['username']) && $_SESSION['monxin']['group_id']==self::$config['cashier_group_id']){
			$sql="select `id` from ".self::$table_pre."shop where `cashier` like '%".$_SESSION['monxin']['username'].",%' and `state`=2 order by `id` desc limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){$r['id']=0;}
			define("SHOP_ID", $r['id']);return true;
		}
		if(isset($_SESSION['monxin']['username']) && $_SESSION['monxin']['group_id']==self::$config['storekeeper_group_id']){
			$sql="select `id` from ".self::$table_pre."shop where `storekeeper` like '%".$_SESSION['monxin']['username'].",%' and `state`=2 order by `id` desc limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){$r['id']=0;}
			define("SHOP_ID", $r['id']);return true;
		}
		if(!isset($_SESSION['monxin']['username'])){define("SHOP_ID", 0);return true;}
		$sql="select `id` from ".self::$table_pre."shop where `username`='".$_SESSION['monxin']['username']."' and `state`=2 order by `id` desc limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){$r['id']=0;}
		define("SHOP_ID", $r['id']);return true;
	}
//======================================================================================================= 根据平台分类设定当前所在位置条
	function get_type_position($pdo,$id){
		if(intval($id)==0){return '';}
		$position='';
		$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=$id";
		$r=$pdo->query($sql,2)->fetch(2);
		$position='<a href="./index.php?monxin=mall.goods_list&type='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>';
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position='<a href="./index.php?monxin=mall.goods_list&type='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>'.$position;
		}
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position='<a href="./index.php?monxin=mall.goods_list&type='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>'.$position;
		}
		return $position;
	}
	function get_shop_tags_name($pdo,$tag){
		$tag=str_replace('|',',',$tag);
		$tag=trim($tag,',');
		if($tag==''){return '';}
		$sql="select `name`,`id` from ".self::$table_pre."shop_tag where `id` in (".$tag.") and `shop_id`=".SHOP_ID;
		$r=$pdo->query($sql,2);
		$temp='';
		foreach($r as $v){
			$temp.='<a href=./index.php?monxin=mall.shop_goods_list&shop_id'.SHOP_ID.'&tag='.$v['id'].'>'.$v['name'].'</a> , ';
		}
		$temp=trim($temp,' , ');
		return $temp;
			
	}
	function get_store_tags_name($pdo,$tag){
		$tag=str_replace('|',',',$tag);
		$tag=trim($tag,',');
		if($tag==''){return '';}
		$sql="select `name`,`id` from ".self::$table_pre."store_tag where `id` in (".$tag.")";
		$r=$pdo->query($sql,2);
		$temp='';
		foreach($r as $v){
			$temp.='<a href=./index.php?monxin=mall.shop_list&tag='.$v['id'].'>'.$v['name'].'</a> , ';
		}
		$temp=trim($temp,' , ');
		return $temp;
			
	}
//======================================================================================================= 根据店内分类设定当前所在位置条
	function get_shop_type_position($pdo,$id){
		if(intval($id)==0){return '';}
		$position='';
		$sql="select `name`,`parent`,`id` from ".self::$table_pre."shop_type where `id`=$id";
		$r=$pdo->query($sql,2)->fetch(2);
		$position='<a href="./index.php?monxin=mall.shop_goods_list&shop_id='.SHOP_ID.'&type='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>';
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."shop_type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position='<a href="./index.php?monxin=mall.shop_goods_list&shop_id='.SHOP_ID.'&type='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>'.$position;
		}
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."shop_type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position='<a href="./index.php?monxin=mall.shop_goods_list&shop_id='.SHOP_ID.'&type='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>'.$position;
		}
		return $position;
	}
	
//======================================================================================================= 根据平台分类设定当前所在位置条（后台专用）
	function get_type_user_position($pdo,$id){
		if(intval($id)==0){return '';}
		$position='';
		$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=$id";
		$r=$pdo->query($sql,2)->fetch(2);
		$position='<a href="./index.php?monxin=mall.type&parent='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>';
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position='<a href="./index.php?monxin=mall.type&parent='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>'.$position;
		}
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position='<a href="./index.php?monxin=mall.type&parent='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>'.$position;
		}
		return $position;
	}

//======================================================================================================= 根据平台商品分类 设定Title
	function get_type_title($pdo,$id){
		if(intval($id)==0){return self::$language['pages']['mall.type']['name'];}
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

//======================================================================================================= 根据店铺商品分类 设定Title
	function get_shop_type_title($pdo,$id){
		if(intval($id)==0){return self::$language['all_goods'];}
		$position='';
		$sql="select `name`,`parent`,`id` from ".self::$table_pre."shop_type where `id`=$id";
		$r=$pdo->query($sql,2)->fetch(2);
		$position=$r['name'];
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."shop_type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position.='-'.$r['name'];
		}
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."shop_type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position.='-'.$r['name'];
		}
		return $position;
	}

//======================================================================================================= 获取平台标签 并返回 input
  function get_tag_html($pdo){
	$sql="select * from ".self::$table_pre."tag order by `sequence` desc";
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$list.='<input type="checkbox" id=tag_'.$v['id'].' name=tag_'.$v['id'].' value="'.$v['id'].'" class=tag />'.$v['name'].' &nbsp;&nbsp;';
	}
	return $list;
  }

//======================================================================================================= 获取平台店铺标签 并返回 input
  function get_store_tag_html($pdo){
	$sql="select * from ".self::$table_pre."store_tag order by `sequence` desc";
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$list.='<input type="checkbox" id=store_tag_'.$v['id'].' name=store_tag_'.$v['id'].' value="'.$v['id'].'" class=store_tag />'.$v['name'].' &nbsp;&nbsp;';
	}
	return $list;
  }
  
//======================================================================================================= 获取平台标签 并返回 HTML
	function get_tags_name($pdo,$tag){
		$tag=str_replace('|',',',$tag);
		$tag=trim($tag,',');
		if($tag==''){return '';}
		$sql="select `name`,`id` from ".self::$table_pre."tag where `id` in (".$tag.")";
		$r=$pdo->query($sql,2);
		$temp='';
		foreach($r as $v){
			$temp.='<a href=./index.php?monxin=mall.goods_list&tag='.$v['id'].'>'.$v['name'].'</a> , ';
		}
		$temp=trim($temp,' , ');
		return $temp;
			
	}
	
//======================================================================================================= 获取店内标签 并返回 HTML
  function get_shop_tag_html($pdo){
	$sql="select * from ".self::$table_pre."shop_tag where `shop_id`=".SHOP_ID." order by `sequence` desc";
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$list.='<input type="checkbox" id=tag_'.$v['id'].' name=tag_'.$v['id'].' value="'.$v['id'].'" class=tag />'.$v['name'].' &nbsp;&nbsp;';
	}
	return $list;
  }
	
//======================================================================================================= 返回商品销售展示所在位置 options 
	function get_goods_position_option($pdo){
		$sql="select * from ".self::$table_pre."position where `shop_id`=".SHOP_ID." order by `sequence` desc";
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			$list.='<option value="'.$v['id'].'">'.$v['name'].'</option>';
		}
		return $list;
	}
	
//======================================================================================================= 返回商品库存所在位置 options 
	function get_goods_storehouse_option($pdo){
		$sql="select * from ".self::$table_pre."storehouse where `shop_id`=".SHOP_ID." order by `sequence` desc";
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			$list.='<option value="'.$v['id'].'">'.$v['name'].'</option>';
		}
		return $list;
	}
	
//======================================================================================================= 返回商品供应商 options 
	function get_goods_supplier_option($pdo){
		$sql="select * from ".self::$table_pre."supplier where `shop_id`=".SHOP_ID." order by `sequence` desc";
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			$list.='<option value="'.$v['id'].'">'.$v['name'].'</option>';
		}
		return $list;
	}
	
//======================================================================================================= 返回商品供应商名称 
	function get_supplier_name($pdo,$id){
		$sql="select `name` from ".self::$table_pre."supplier where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		return $r['name'];
	}
	
//======================================================================================================= 返回商品单位 options 
	function get_goods_unit_option($pdo){
		$sql="select * from ".self::$table_pre."unit order by `sequence` desc";
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			$list.='<option value="'.$v['id'].'">'.$v['name'].'</option>';
		}
		return $list;
	}
	
//======================================================================================================= 返回平台商品上级分类 文本 常用于设定Title 
	function get_type_parent_text($pdo,$id){
		$id=intval($id);
		if($id==0){return false;}
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
	
//======================================================================================================= 返回商品分类对应的品牌 options 
	function get_brand_option($pdo,$id){
		$type=0;
		$sql="select `brand_source`,`parent`,`id` from ".self::$table_pre."type where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['brand_source']==1){
			$type=$id;
		}elseif($r['parent']!=0){
			$sql="select `brand_source`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['brand_source']==1){
				$type=$r['id'];
			}elseif($r['parent']!=0){
				$sql="select `brand_source`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
				$r=$pdo->query($sql,2)->fetch(2);
				$type=$r['id'];
			}else{
			$type=$r['id'];
			}
		}else{
			$type=$r['id'];
		}
		if($type==0){return '';}
		$sql="select `id`,`name` from ".self::$table_pre."type_brand where `type_id`=".$type;	
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			$list.='<option value="'.$v['id'].'">'.$v['name'].'</option>';	
		}
		//var_dump($list);
		return $list;
	}
	
	
//======================================================================================================= 返回商品分类对应的属性 html(常用于商品列表顶部) 
	function get_attribute_html($pdo,$id){
		$type=0;
		$sql="select `attribute_source`,`parent` from ".self::$table_pre."type where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['attribute_source']==1){
			$type=$id;
		}elseif($r['parent']!=0){
			$sql="select `attribute_source`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['attribute_source']==1){
				$type=$r['id'];
			}elseif($r['parent']!=0){
				$sql="select `attribute_source`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['attribute_source']==1){
					$type=$r['id'];
				}
			}
		}
		
		$sql="select `id` from ".self::$table_pre."type_attribute where `type_id`=".$type;	
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			$list.=$v['id'].',';	
		}
		//var_dump($list);
		if($list==''){return '';}
		$list=trim($list,',');
		$sql="select * from ".self::$table_pre."type_attribute where `id` in (".$list.")";
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			if($v['values']==''){
				$input='<input type="text" id=attribute_'.$v['id'].'_input />';
			}else{
				$v['values']=trim($v['values'],'/');
				$temp=explode('/',$v['values']);
				$option='';
				foreach($temp as $v2){
					$option.='<option value="'.$v2.'">'.$v2.'</option>';	
				}
				$input='<input type="text" id=attribute_'.$v['id'].'_input style="display:none;" /><select id=attribute_'.$v['id'].'_select ><option value="-1">&nbsp;&nbsp;</option>'.$option.'</select> <a href="#" class=attribute_switch>&nbsp;</a>';	
			}
			$list.='<div id=attribute_'.$v['id'].' class=attribute_sub_div><span class=a_label>'.$v['name'].'</span><span class=a_input>'.$input.' <span class=state></span></span></div>';	
		}
		return $list;
	}
	
	
//======================================================================================================= 返回商品分类对应的规格 html(常用于商品列表顶部) 
	function get_option_html($pdo,$id){
		$type=0;
		$sql="select `specifications_source`,`parent` from ".self::$table_pre."type where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['specifications_source']==1){
			$type=$id;
		}elseif($r['parent']!=0){
			$sql="select `specifications_source`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['specifications_source']==1){
				$type=$r['id'];
			}elseif($r['parent']!=0){
				$sql="select `specifications_source`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['specifications_source']==1){
					$type=$r['id'];
				}
			}
		}

		if($type==0){return '';}
		$id=$type;
		$_POST['option_type']=$id;
		$sql="select * from ".self::$table_pre."type where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$list='';
		if($r['color']){
			
			$_POST['option_color']=1;
			$color='';
			$sql="select * from ".self::$table_pre."color order by `sequence` desc";
			$r2=$pdo->query($sql,2);
			foreach($r2 as $v){
				$color.='<span class=color_span><input type="checkbox" id="color_'.$v['id'].'" /><m_label for="color_'.$v['id'].'" ><img src="./program/mall/color_icon/'.$v['id'].'.png"> <span class=color_name>'.$v['name'].'</span></m_label></span>';	
			}
			$list.='<div id=color_div><span class=title_span>'.self::$language['color'].'</span><br />'.$color.'</div>';
		}
		if($r['diy_option'] && $r['option_name']!=''){
			$option_name=$r['option_name'];
			$sql="select count(id) as c from ".self::$table_pre."type_option where `type_id`=".$id;
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['c']>0){
				$_POST['option_option']=1;
				$sql="select * from ".self::$table_pre."type_option where `type_id`=".$id;
				$r=$pdo->query($sql,2);
				$option='';
				foreach($r as $v){
					$option.='<span class=option_span><input type="checkbox" id="option_'.$v['id'].'" /><m_label for="option_'.$v['id'].'" >'.$v['name'].'</m_label></span>';		
				}
				$option.='<a href=# class="create new_option">'.self::$language['add'].'</a> <div class=new_option_div> <input type=text class=new_name /><a href=# class=add  type='.$id.'>'.self::$language['submit'].'</a> <span class=state></span></div>';		
				$list.='<div id=option_option_div><span class=title_span>'.$option_name.'</span><br />'.$option.'</div>';
			}	
		}
		if($list==''){unset($_POST['option_type']);}	
		return $list;
		
	}
	
//======================================================================================================= 返回商品计量单位名 
	function get_mall_unit_name($pdo,$id){
		if($id==''){return false;}
		$sql="select `name`,`gram` from ".self::$table_pre."unit where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$_POST['temp_unit_gram']=$r['gram'];
		return $r['name'];	
	}
	
//======================================================================================================= 返回商品分类规格名 
	function get_type_option_name($pdo,$id){
		if($id==''){return false;}
		$sql="select `name` from ".self::$table_pre."type_option where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		return $r['name'];	
	}
	
//======================================================================================================= 返回店铺折扣度 
	function get_shop_discount($pdo,$shop_id){
		$discount=10;
		$time=time();
		$sql="select * from ".self::$table_pre."discount where `shop_id`='".$shop_id."' and `end_time`>".$time;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){
			if($r['rate']>0 && $r['rate']<10){$discount=$r['rate'];}
		}
		$_SESSION['discount_all']=$r['join_goods'];
		$_POST['discount_join_goods']=$r['join_goods'];
		return $discount;
	}
	
//======================================================================================================= 返回店铺满元惠方式
	function get_fulfil_preferential_method_sub($language,$v){
		$r='';
		if($v['use_method']==0){
			$r=$v['discount'].$language['discount'];
		}elseif($v['use_method']==1){
			$r=$language['reduction'].$v['less_money'].$language['yuan_2'];
		}else{
			$r=$language['free_shipping'];
		}
		return $r;
	}
	
	
//======================================================================================================= 返回店铺满元惠信息
	function get_fulfil_preferential_method($pdo,$table_pre,$language,$shop_id){
		$list='';
		$time=time();
		$sql="select * from ".$table_pre."fulfil_preferential where `shop_id`='".$shop_id."' and `end_time`>'".$time."' order by `min_money` asc";
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$temp='';
			$temp=self::$language['join_goods_front'][$v['join_goods']].self::$language['full'].$v['min_money'].$language['yuan_2'];	
			$list.=$temp.self::get_fulfil_preferential_method_sub($language,$v).'&nbsp; ';
		}
		return $list;
	}
	
//======================================================================================================= 返回店铺满元惠信息 json格式 
	function get_fulfil_preferential_json($pdo,$table_pre,$shop_id){
		$list=array();
		$time=time();
		$sql="select * from ".$table_pre."fulfil_preferential where `shop_id`='".$shop_id."' and `end_time`>'".$time."' order by `min_money` asc";
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			if($v['use_method']>1){continue;}
			$list[$v['id']]['min_money']=$v['min_money'];	
			$list[$v['id']]['use_method']=$v['use_method'];	
			$list[$v['id']]['less_money']=$v['less_money'];	
			$list[$v['id']]['discount']=$v['discount'];	
			$list[$v['id']]['join_goods']=$v['join_goods'];	
		}
		//$list=self::array_sort($list,'min_money',$type='asc');
		return json_encode($list);
	}
	
//======================================================================================================= 返回店铺满元惠 省了多少钱
	function get_fulfil_preferential($pdo,$table_pre,$money,$money_all,$shop_id){
		$time=time();
		$sql="select * from ".$table_pre."fulfil_preferential where `shop_id`='".$shop_id."' and (`min_money`<=".$money." || `min_money`<=".$money_all." ) and `end_time`>'".$time."' order by `min_money` desc";
		$r=$pdo->query($sql,2);
		$use=0;
		foreach($r as $v){
			if($v['join_goods']==0){if($v['min_money']<=$money){$use=$v;$e_money=$money;break;}}
			if($v['join_goods']==1){if($v['min_money']<=$money_all){$use=$v;$e_money=$money_all;break;}}
			if($v['join_goods']==2){if($v['min_money']<=$money_all-$money){$use=$v;$e_money=$money_all-$money;break;}}
		}
	
		if($use==0 || $e_money==0){return 0;}
		if($use['use_method']==0){
			return $e_money-sprintf("%.2f",$e_money*$use['discount']/10);
		}
		if($use['use_method']==1){
			return $use['less_money'];
		}
		if($use['use_method']==2){
			return 'free_shipping';
		}
		
		
	}
	
	
//======================================================================================================= 返回适用红包 抵扣金额
	function get_red_coupon($pdo,$table_pre,$promotion_money,$all_money,$shop_id){
		$time=time();
		$sql="select * from ".self::$table_pre."coupon where `shop_id`=".$shop_id." and `start_time`<'".$time."' and  `end_time`>'".$time."' and `used`<`sum_quantity` and `min_money`<=".$all_money;
		$r=$pdo->query($sql,2);
		$red_ids='';
		foreach($r as $v){
			$ok=false;
			if($v['join_goods']==0){//仅参加促销的商品 可使用
				if($promotion_money>=$v['min_money']){$ok=true;}
			}
			if($v['join_goods']==1){//全店商品 可使用
				if($all_money>=$v['min_money']){$ok=true;}
			}
			if($v['join_goods']==2){//不参加促销的商品 可使用
				if($all_money-$promotion_money>=$v['min_money']){$ok=true;}
			}
			
			if($ok){$red_ids.=$v['id'].',';}
		}
		$red_ids=trim($red_ids,',');
		if($red_ids==''){return false;}
		$sql="select `coupon_id` from ".self::$table_pre."my_coupon where `username`='".$_SESSION['monxin']['username']."' and `use_time`=0 and `coupon_id` in (".$red_ids.")";
		$r=$pdo->query($sql,2);
		$useable='';
		foreach($r as $v){
			$useable.=$v['coupon_id'].',';	
		}
		$useable=trim($useable,',');
		if($useable==''){return false;}
		$sql="select `amount`,`id` from ".self::$table_pre."coupon where `id` in (".$useable.") order by `amount` desc limit 0,1";
		//echo $sql;
		$r=$pdo->query($sql,2)->fetch(2);
		return $r;
		
	}
	
//======================================================================================================= 数组排序
	function array_sort($arr,$keys,$type='asc'){ 
		$keysvalue = $new_array = array();
		foreach ($arr as $k=>$v){
			$keysvalue[$k] = $v[$keys];
		}
		if($type == 'asc'){
			asort($keysvalue);
		}else{
			arsort($keysvalue);
		}
		reset($keysvalue);
		foreach ($keysvalue as $k=>$v){
			$new_array[$k] = $arr[$k];
		}
		return $new_array; 
	} 

//======================================================================================================= 返回买家收货信息
	function get_receiver_address($pdo,$table_pre,$id){
		$sql="select * from ".$table_pre."receiver where `id`='".$id."' limit 0,1";
		//echo $sql;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){return false;}
		return $r['name'].' '.$r['phone'].' '.get_area_name($pdo,$r['area_id']).' '.$r['detail']; 	
	}

//======================================================================================================= 返回快递公司名
	function get_express_name($pdo,$table_pre,$id){
		$sql="select `name` from ".$table_pre."express where `id`='".$id."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		return $r['name'];
	}

//======================================================================================================= 返回订单支付期限
	function get_pay_time_limit($language,$pay_time_limit,$v){
		$second='';
		$remain=($v+$pay_time_limit*60)-time();
		if($remain>86400){
			$day=floor($remain/86400).$language['day']; 
			$t=$remain%86400;
			$hour='';
			if($t!=0){
				if($t>3600){
					$hour=floor($t/3600).self::$language['hour'];	
				}	
			}
			return $day.$hour;	
			
		}elseif($remain>3600){
			$hour=floor($remain/3600).self::$language['hour'];
			$t=$remain%3600;
			$minute='';
			if($t!=0){
				$minute=floor($t/60).self::$language['minute'];		
			}
			return $hour.$minute;	
		}elseif($remain>60){
			$minute=floor($remain/60).self::$language['minute'];
			$t=$remain%60;
			if($t!=0){
				$second=$t.self::$language['second'];		
			}
			return $minute.$second;	
		}elseif($remain>0){
			return $remain.self::$language['second'];
		}else{
			return false;	
		}
	}
	
//======================================================================================================= 更新逾期未付款订单状态为，超时取消
	function update_expire_order($pdo,$table_pre,$pay_time_limit){
		$remain=time()-$pay_time_limit*60;
		$sql="select * from  ".$table_pre."order where `state`=0 and `add_time`<".$remain." and `check_code_state`!=1 and `cashier`='monxin'";
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			self::return_goods_quantity($pdo,$table_pre,$v['id'],$v['inventory_decrease']);
			self::order_cancel_untread_credits($pdo,$v);
			
			$sql="select `name` from ".self::$table_pre."shop where `id`=".$v['shop_id'];
			$r2=$pdo->query($sql,2)->fetch(2);
			$shop_name=$r2['name'];
			$title=str_replace('{web_name}',self::$config['web']['name'],self::$language['update_expire_order_template']);
			$title=str_replace('{shop_name}',$shop_name,$title);	
			$v['goods_names']=mb_substr($v['goods_names'],0,10,'utf-8').' ...';	
			push_cancel_order_info($pdo,self::$config,self::$language,$v['buyer'],$title,$v['out_id'],$v['actual_money'],'mall.my_order',$v['goods_names']);
		}
		
		$sql="update ".$table_pre."order set `state`='3' where `state`=0 and `add_time`<".$remain."";
		$pdo->exec($sql);
		
	}
	
	
//======================================================================================================= 更新达到 尾款支付起始时间的订单状态为：预售待付尾款
	function update_pre_sale_order_13($pdo){
		$time=time();
		$sql="select * from  ".self::$table_pre."order where `state`=12";
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$sql="select * from ".self::$table_pre."order_pre_sale where `order_id`=".$v['id']." limit 0,1";
			$pre=$pdo->query($sql,2)->fetch(2);
			if($pre['last_pay_start_time']<=$time){
				$sql="update ".self::$table_pre."order set `state`='13' where `id`=".$v['id'];
				$pdo->exec($sql);
			}
		}
		
	}
	
	
	
//======================================================================================================= 取消订单后，退回下单时 使用的积分
	function order_cancel_untread_credits($pdo,$r){
		if($r['buyer']==''){return false;}
		if($r['web_credits']>0){operation_credits($pdo,self::$config,self::$language,$r['buyer'],$r['web_credits'],self::$language['pages']['mall.order_cancel']['name'],'other');}
		if($r['shop_credits']>0){
			$sql="update ".self::$table_pre."shop_buyer set `credits`=`credits`+".$r['shop_credits']." where `username`='".$r['buyer']."' and `shop_id`=".$r['shop_id']." limit 1";
			$pdo->exec($sql);
		}
		
	}

//======================================================================================================= 更新商品批次库存数据
	function return_goods_batch($pdo,$goods_id,$quantity,$id){
		if($id==0){return false;}
		$sql="update ".self::$table_pre."goods_batch set `left`=`left`+".$quantity." where `id`=".$id;
		return $pdo->exec($sql);
	}

//======================================================================================================= 更新商品销量
	function return_goods_quantity($pdo,$table_pre,$order_id,$state){
		if($state==0){return false;}
		$sql="select `id`,`goods_id`,`s_id`,`quantity` from ".$table_pre."order_goods where `order_id`=".$order_id;
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$goods_id=$v['goods_id'];
			if($v['s_id']!=0){
				$sql="update ".$table_pre."goods_specifications set `quantity`=`quantity`+".$v['quantity']." where `id`=".$v['s_id'];	
				$pdo->exec($sql);
				$goods_id.='_'.$v['s_id'];
			}
			$sql="update ".$table_pre."goods set `inventory`=`inventory`+".$v['quantity'].",`sold`=`sold`-".$v['quantity']." where `id`=".$v['goods_id'];	
			if($pdo->exec($sql)){
				$sql="select `batch_id` from ".self::$table_pre."goods_quantity_log where `order_id`=".$order_id." limit 0,1";
				$r=$pdo->query($sql,2)->fetch(2);
				self::return_goods_batch($pdo,$goods_id,$v['quantity'],$r['batch_id']);
				$sql="delete from ".$table_pre."goods_quantity_log  where `order_id`=".$order_id;
				$pdo->exec($sql);
				
			}
		}
		$sql="update ".self::$table_pre."order set `inventory_decrease`=0 where `id`=".$order_id;
		$pdo->exec($sql);	
	}

//======================================================================================================= 网上自助提交的订单符合减商品库存条件时，减商品库存
	function decrease_goods_quantity($pdo,$table_pre,$order){
		$sql="select `decrease_quantity` from ".$table_pre."shop_order_set where `shop_id`=".$order['shop_id'];
		$r=$pdo->query($sql,2)->fetch(2);
		if(intval($r['decrease_quantity'])==intval($order['state']) && $order['inventory_decrease']==0){
			$sql="select `id`,`goods_id`,`s_id`,`quantity` from ".$table_pre."order_goods where `order_id`=".$order['id'];
			$r=$pdo->query($sql,2);
			foreach($r as $v){
				$goods_id=$v['goods_id'];
				if($v['s_id']!=0){
					$sql="update ".$table_pre."goods_specifications set `quantity`=`quantity`-".$v['quantity']." where `id`=".$v['s_id'];	
					$pdo->exec($sql);
					$goods_id.='_'.$v['s_id'];
				}
				$sql="update ".$table_pre."goods set `inventory`=`inventory`-".$v['quantity'].",`sold`=`sold`+".$v['quantity']." where `id`=".$v['goods_id'];	
				if($pdo->exec($sql)){
					$batch_id=self::decrease_goods_batch($pdo,$goods_id,$v['quantity']);
					$sql="insert into ".$table_pre."goods_quantity_log (`goods_id`,`quantity`,`username`,`time`,`order_id`,`batch_id`,`shop_id`,`s_id`) values ('".$v['goods_id']."','-".$v['quantity']."','monxin','".time()."','".$order['id']."','".$batch_id."','".$order['shop_id']."','".$v['s_id']."')";
					$pdo->exec($sql);
					
				}
			}
			$sql="update ".self::$table_pre."order set `inventory_decrease`=1 where `id`=".$order['id'];
			$pdo->exec($sql);	
		}
		self::update_config_file('goods_update_time',time());
	}
	

//======================================================================================================= 收银提交的订单交易成功后，减商品库存
	function checkout_decrease_goods_quantity($pdo,$table_pre,$order){
		if($order['inventory_decrease']==1){return false;}
		$sql="select `id`,`goods_id`,`s_id`,`quantity` from ".$table_pre."order_goods where `order_id`=".$order['id'];
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$goods_id=$v['goods_id'];
			if($v['s_id']!=0){
				$sql="update ".$table_pre."goods_specifications set `quantity`=`quantity`-".$v['quantity']." where `id`=".$v['s_id'];	
				$pdo->exec($sql);
			}
			$sql="update ".$table_pre."goods set `inventory`=`inventory`-".$v['quantity'].",`sold`=`sold`+".$v['quantity']." where `id`=".$v['goods_id'];	
			if($pdo->exec($sql)){
				$batch_id=self::decrease_goods_batch($pdo,$goods_id,$v['quantity']);
				$sql="insert into ".$table_pre."goods_quantity_log (`goods_id`,`quantity`,`username`,`time`,`order_id`,`batch_id`,`shop_id`,`s_id`) values ('".$v['goods_id']."','-".$v['quantity']."','monxin','".time()."','".$order['id']."','".$batch_id."','".$order['shop_id']."','".$v['s_id']."')";
				$pdo->exec($sql);
				$goods_id.='_'.$v['s_id'];
				
			}
		}
		$sql="update ".self::$table_pre."order set `inventory_decrease`=1 where `id`=".$order['id'];
		$pdo->exec($sql);	
		self::update_config_file('goods_update_time',time());
	}

//======================================================================================================= 网上自动下单的订单交易成功后，减商品库存
	function decrease_goods_batch($pdo,$goods_id,$quantity){
		$time=time();
		$sql="select `id`,`left` from ".self::$table_pre."goods_batch where `goods_id`='".$goods_id."' and `left`>0 order by `id` asc";
		$r=$pdo->query($sql,2);
		$decrease=0;
		foreach($r as $v){
			if($quantity==0){return $id;}
			$id=$v['id'];
			if($v['left']>$quantity){
				$sql="update ".self::$table_pre."goods_batch set `left`=`left`-".$quantity." where `id`=".$v['id'];	
				$quantity=0;
			}elseif($v['left']==$quantity){
				$sql="update ".self::$table_pre."goods_batch set `left`=`left`-".$quantity.",`sell_out_time`=".$time." where `id`=".$v['id'];
				$quantity=0;	
			}elseif($v['left']<$quantity){
				$sql="update ".self::$table_pre."goods_batch set `left`=0,`sell_out_time`=".$time." where `id`=".$v['id'];	
				$quantity-=$v['left'];
			}
			$pdo->exec($sql);
		}
		if($quantity!=0){
			if(isset($v)){
				$sql="update ".self::$table_pre."goods_batch set `left`=`left`-".$quantity.",`sell_out_time`=".$time." where `id`=".$v['id'];	
			}else{
				$sql="update ".self::$table_pre."goods_batch set `left`=`left`-".$quantity.",`sell_out_time`=".$time."  where `goods_id`='".$goods_id."'  order by `id` desc limit 1";	
			}
			
			$pdo->exec($sql);
		}
		if(!isset($id)){
			$sql="select `id` from ".self::$table_pre."goods_batch where `goods_id`='".$goods_id."'  order by `id` desc limit 1";	
			$r=$pdo->query($sql,2)->fetch(2);
			$id=$r['id'];
		}
		
		return $id;	
	}
	
//======================================================================================================= 更新购物车数据
	function update_cart($pdo,$table_pre){
		if(isset($_SESSION['monxin']['username'])){
			if(@$_COOKIE['mall_cart']!=''){
				$cart=json_decode($_COOKIE['mall_cart'],true);
				foreach($cart as $k=>$v){
					$sql="select `id` from ".$table_pre."cart where `username`='".$_SESSION['monxin']['username']."' and `key`='".safe_str($k)."' limit 0,1";
					$r=$pdo->query($sql,2)->fetch(2);
					if($r['id']!=''){
						$sql="update ".$table_pre."cart set `quantity`=`quantity`+1 where `id`=".$r['id'];
					}else{
						$sql="insert into ".$table_pre."cart (`username`,`key`,`quantity`,`price`,`time`) values ('".$_SESSION['monxin']['username']."','".safe_str($k)."','".floatval($v['quantity'])."','".floatval($v['price'])."','".(floatval($v['time'])/1000)."')";
					}
					//echo $sql;
					$pdo->exec($sql);	
				}
			}
			$sql="select * from ".$table_pre."cart where `username`='".$_SESSION['monxin']['username']."'";
			$r=$pdo->query($sql,2);
			$mall_cart=array();
			foreach($r as $v){
				$mall_cart[$v['key']]['quantity']=self::format_quantity($v['quantity']);
				$mall_cart[$v['key']]['price']=$v['price'];
				$mall_cart[$v['key']]['time']=$v['time'];
			}
			setcookie("mall_cart",json_encode($mall_cart));
			$_COOKIE['mall_cart']=json_encode($mall_cart);
		}else{
			setcookie("mall_cart",'');		
		}
	}
	
//======================================================================================================= 格式化商品数量后缀
	function format_quantity($v){
		if(!is_numeric($v)){return 0;}
		$v=sprintf("%.3f",$v);
		$v=rtrim($v,'0');
		$v=rtrim($v,'0');
		$v=rtrim($v,'.');
		return $v;
	}
	
//======================================================================================================= 格式化商品价格后缀
	function format_price($v){
		if(!is_numeric($v)){return 0;}
		$v=sprintf("%.2f",$v);
		$v=rtrim($v,'0');
		$v=rtrim($v,'0');
		$v=rtrim($v,'.');
		return $v;
	}
	
//======================================================================================================= 返回店铺聊天客服选项
	function get_talk_option($pdo,$table_pre){
		$sql="select `id`,`name` from ".$table_pre."talk order by `sequence` desc";
		$r=$pdo->query($sql,2);
		$option='';
		foreach($r as $v){
			$v=de_safe_str($v);
			$option.='<option value='.$v['id'].'>'.$v['name'].'</option>';	
		}
		return $option;
	}
	
//======================================================================================================= 返回地区所在省ID
	function get_area_top_id($pdo,$id){
		$sql="select `upid` from ".$pdo->index_pre."area where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['upid']!=0){
			return  self::get_area_top_id($pdo,$r['upid']);
		}else{
			return $id;
		}	
	}
	
//======================================================================================================= 更新商城配置文件
	function update_config_file($key,$v){
		$config=require('./program/mall/config.php');
		$config[$key]=$v;
		file_put_contents('./program/mall/config.php','<?php return '.var_export($config,true).'?>');
	}	
	
	
//======================================================================================================= 下单后，通知店家
	function order_notice($language,$config,$pdo,$table_pre,$order){
		$sql="select `name`,`username`,`storekeeper` from ".$table_pre."shop where `id`=".$order['shop_id'];
		$r=$pdo->query($sql,2)->fetch(2);
		$username=$r['username'];
		$shop_name=$r['name'];
		$storekeeper=de_safe_str($r['storekeeper']);
		$sql="select `order_notice_when` from ".$table_pre."shop_order_set where `shop_id`=".$order['shop_id'];
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['order_notice_when']==$order['state'] ){
			$title=$language['order_notice_template'];
			$order['buyer']=($order['buyer']!='')?$order['buyer']:$order['receiver_name'];
			$title=str_replace('{username}',$order['buyer'],$title);
			$title=str_replace('{webname}',$config['web']['name'].':'.$shop_name,$title);
			$title=str_replace('{state}',$language['order_state'][$order['state']],$title);
			if($order['pay_method']=='cash_on_delivery'){$order['state']=0;}
			$order['goods_names']=mb_substr($order['goods_names'],0,10,'utf-8').' ...';
			push_new_order_info($pdo,$config,$language,$username,$title,$shop_name,de_safe_str($order['goods_names']),$order['actual_money'],$order['state'],$order['out_id']);
			if($storekeeper!=''){
				$storekeeper=explode(',',$storekeeper);
				push_new_order_info($pdo,$config,$language,$storekeeper[0],$title,$shop_name,de_safe_str($order['goods_names']),$order['actual_money'],$order['state'],$order['out_id']);	
			}
			
			self::submit_cloud_print($pdo,$order['id']);
			
			
			
		}
	}


//==================================================================================================================提交到云打印机服务器 自动打印
function  submit_cloud_print($pdo,$order_id){
	$sql="select * from ".$pdo->sys_pre."mall_order where `id`=".$order_id;
	
	$v=$pdo->query($sql,2)->fetch();
	if($v){	
		$sql="select `name` from ".$pdo->sys_pre."mall_shop where `id`=".$v['shop_id'];
		$r=$pdo->query($sql,2)->fetch(2);
		$shop_name=$r['name'];			
		$sql="select `title`,`transaction_price`,`quantity`,`unit`,`s_id`,`price`,`barcode` from ".$pdo->sys_pre."mall_order_goods where `order_id`=".$v['id'];
		$r2=$pdo->query($sql,2);
		$list2='';
		//file_put_contents('yun_print.txt',''.$sql);
		foreach($r2 as $v2){
			if($v['preferential_way']==5){$o_price='<span class=o_price>'.$v2['price'].'</span>';$v2['price']=$v2['transaction_price'];}else{$o_price='';}
						

			//echo $v2['title'].' '.mb_strlen($v2['title'],'utf-8').'<br />';
			if(mb_strlen($v2['title'],'utf-8')>18){
				if($v2['s_id']!=0){
					$v2['title']=mb_substr($v2['title'],0,6,'utf-8').'..'.mb_substr($v2['title'],mb_strlen($v2['title'],'utf-8')-14,9,'utf-8');
				}else{
					$v2['title']=mb_substr($v2['title'],0,15,'utf-8').'..';
				}			
			}
			if($v2['barcode']=='0'){$v2['barcode']='';}
			$list2.='<tr><td colspan=3>'.trim($v2['title']).'</td></tr><tr><td>'.$v2['price'].'</td><td>'.self::format_quantity($v2['quantity']).$v2['unit'].'</td><td>'.number_format($v2['price']*$v2['quantity'],2).'</td></tr><tr><td colspan=3>------------------------------</td></tr>';
				
		}
		$sql="select `name` from ".$pdo->sys_pre."mall_shop where `id`=".$v['shop_id'];
		
		$r=$pdo->query($sql,2)->fetch(2);
		$shop_name=$r['name'];
		
		if($v['receiver_area_name']==''){
			$receiver_info='';
		}else{
			$receiver_info=$v['receiver_name'].' '.$v['receiver_phone'].' '.$v['receiver_area_name'].' '.$v['receiver_detail'].' '.$v['receiver_post_code'].' '.' '.self::$language['delivery_time_info'][$v['delivery_time']]." ".self::get_express_name($pdo,$pdo->sys_pre."mall_",$v['express'])." ".$v['express_code']." ";
		}
		if($v['goods_money']+$v['express_cost_buyer']-$v['sum_money']!=0){
			$preferential_way="<right>".self::$language['sum'].":".$v['goods_money'].self::$language['yuan']."</right><right>".$v['preferential_code'].self::$language['preferential_way_option'][$v['preferential_way']].": -". sprintf('%.2f',$v['goods_money']+$v['express_cost_buyer']-$v['sum_money']).self::$language['yuan']."</right>";		
		}else{$preferential_way='';}		
		
		if($v['buyer_remark']!=''){$v['buyer_remark']=self::$language['buyer'].self::$language['remark'].':'.$v['buyer_remark'];}
		if($v['seller_remark']!=''){$v['seller_remark']=self::$language['seller'].self::$language['remark'].':'.$v['seller_remark'];}
		if($v['preferential_way']==5){$preferential_way='';}
		if($v['web_credits_money']!=0){$v['buyer_remark'].=' '.$v['credits_remark'];}
		$content="<center>".$shop_name."</center>\r".self::$language['order_number'].':'.$v['out_id']."\r".self::$language['order_id'].self::$language['state'].":".self::$language['order_state'][$v['state']]." ".@self::$language['pay_method'][$v['pay_method']]."\r<table><tr><td>".self::$language['price']."</td><td>".self::$language['quantity']."</td><td>".self::$language['subtotal']."</td></tr>".$list2."</table>\r".$preferential_way."<right>".self::$language['actual_pay'].self::$language['money_symbol'].str_replace('.00','',$v['actual_money']-$v['web_credits_money']).self::$language['yuan'].'('.self::$language['freight_costs'].str_replace('.00','',$v['express_cost_buyer']).self::$language['yuan'].")</right>".$v['change_price_reason']."\r".$receiver_info."\r".$v['buyer']."  ".date('Y-m-d H:i',$v['add_time'])."\r\n".$v['buyer_remark'].$v['seller_remark'];	
		file_put_contents('yunp.txt',$content);
		}
	$sql="select * from ".$pdo->sys_pre."mall_shop_order_set where `shop_id`=".$v['shop_id']." limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){return false;}	
	yun_print($r['print_supplier'],$r['print_partner'],$r['print_apikey'],$r['print_machine_code'],$r['print_msign'],$content);//提交到易联云
	
}	
	

	
	
//=========================================================================================================================虚拟物品自动发货 start
	function virtual_auto_delivery($config,$language,$pdo,$table_pre,$order){
		file_put_contents('a.txt',1528);
		
		$sql="select * from ".$table_pre."shop where `id`=".$order['shop_id'];
		$r=$pdo->query($sql,2)->fetch(2);
		$r=de_safe_str($r);
		$shopName=$r['name'];
		$shop_address=$r['address'];
		$tel=$r['phone'];
		
		$code="23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKMNPQRSTUVWXYZ"; //这是随机数
		$random_str=''; //定义一个空字符串
		for($i=0; $i < 6; $i++){ //
			$char=$code{rand(0, strlen($code)-1)}; //随机数,如果$code{0}那就是2
			$random_str.=$char; //附加验证码符号到字符串
		}
		
		$code="1234567890"; //这是随机数
		$random_int=''; //定义一个空字符串
		for($i=0; $i < 6; $i++){ 
			$char=$code{rand(0, strlen($code)-1)}; //随机数,如果$code{0}那就是2
			$random_int.=$char; //附加验证码符号到字符串
		}
	
		$sql="select `goods_id` from ".$table_pre."order_goods where `order_id`='".$order['id']."'";
		$r=$pdo->query($sql,2);
		$g_ids='';
		foreach($r as $v){
			$g_ids.=$v['goods_id'].',';
		}
		$g_ids=trim($g_ids,',');
		$sql="select `title`,`virtual_auto_delivery` from ".$table_pre."goods where `id` in (".$g_ids.")";
		$r=$pdo->query($sql,2);
		$http=array();
		$sms=array();
		$email=array();
		$email_title=array();
		$random=array();
		$count=0;
		foreach($r as $v){
			$v=de_safe_str($v);
			if($v['virtual_auto_delivery']==''){continue;}
				$temp=explode('{random_str}',$v['virtual_auto_delivery']);
				if(count($temp)>1){$random[]=$random_str;}
				$temp=explode('{random_int}',$v['virtual_auto_delivery']);
				if(count($temp)>1){$random[]=$random_int;}
				$temp=explode('{check_code}',$v['virtual_auto_delivery']);
				if(count($temp)>1){$random[]=$random_str;}
			
			if(strtolower(mb_substr($v['virtual_auto_delivery'],0,4,'utf-8'))=='http'){
				$http[]=$v['virtual_auto_delivery'];
				//file_put_contents('./http.txt',@file_get_contents('./http.txt')."\r\n".$v['virtual_auto_delivery']);
			}else{
				if(strtolower(mb_substr($v['virtual_auto_delivery'],0,5,'utf-8'))=='email'){$v['virtual_auto_delivery']=mb_substr($v['virtual_auto_delivery'],6);}
				
				//$v['virtual_auto_delivery']=str_replace('{random_str}',$random_str,$v['virtual_auto_delivery']);
				//$v['virtual_auto_delivery']=str_replace('{random_int}',$random_int,$v['virtual_auto_delivery']);
				if(substr($v['virtual_auto_delivery'],0,4)=='sms:'){
					$v['virtual_auto_delivery']=substr($v['virtual_auto_delivery'],4);
					$sms[]=$v['virtual_auto_delivery'];
				}
				$email[]=$v['virtual_auto_delivery'];
				$email_title[]=$v['title'];
			}
			$count++;	
		}
		
		if($count==0){
			if($order['receiver_id']==-1){
				$check_code=get_verification_code(8);
				$sql="select `id` from ".self::$table_pre."order where `check_code`='".$check_code."' and `shop_id`=".SHOP_ID." and `state`<2 limit 0,1";
				$temp=$pdo->query($sql,2)->fetch(2);
				if($temp['id']!=''){
					$check_code.=get_verification_code(4);
				}
				$sql="update ".$table_pre."order set `check_code`='".$check_code."',`send_time`=".time().",`check_code_state`=1 where `id`=".$order['id'];
				self::$language['have_automatic_delivery']=self::$language['have_automatic_delivery_check_code'];
				return $pdo->exec($sql);			
			}else{
				return false;
			}
		}
		if($g_ids!=''){
			if($order['buyer']!=''){
				$sql="select `email` from ".$pdo->index_pre."user where `username`='".$order['buyer']."' limit 0,1";
				$user=$pdo->query($sql,2)->fetch(2);
			}
			if(!isset($random_code)){
				if(count($random)>1){$random_code=$random_int;}
				if(count($random)==1){$random_code=$random[0];}
				if(count($random)==0){$random_code='';}
			}
			
			//=======================================================================================send_emall
			if(count($email)>0 && $order['buyer']!=''){
				if($user['email']!=''){
					$email_t='【'.$config['web']['name'].'】'.$language['virtual_auto_delivery'];
					$email_content='';
					foreach($email as $k=>$v2){
						$email_content.='<b>'.mb_substr($email_title[$k],0,20,'utf-8')."</b> >>> ".$v2.'<hr />';	
					}
										
					$email_content=str_replace('{phone}',$order['receiver_phone'],$email_content);
					$email_content=str_replace('{email}',@$user['email'],$email_content);
					$email_content=str_replace('{order_id}',$order['id'],$email_content);
					$email_content=str_replace('{random_str}',$random_code,$email_content);	
					$email_content=str_replace('{random_int}',$random_code,$email_content);
					$email_content=str_replace('{web_name}',$config['web']['name'],$email_content);
					$email_content=str_replace('{shopName}',$shopName,$email_content);
					$email_content=str_replace('{address}',$shop_address,$email_content);
					$email_content=str_replace('{tel}',$tel,$email_content);
					$email_content=str_replace('{check_code}',$random_code,$email_content);
					
					email($config,$language,$pdo,'monxin',$user['email'],$email_t,$email_content);
					//file_put_contents('./auto_send_email.txt',@file_get_contents('./auto_send_email.txt')."\r\n".$email_t.'<br />'.$email_content);
				}
			}
			
			
			
			if(isset($random_code)){
				$sql="update ".$table_pre."order set `check_code`='".$random_code."',`send_time`=".time()." where `id`=".$order['id'];
				if($order['receiver_id']==-1){$sql="update ".$table_pre."order set `check_code`='".$random_code."',`send_time`=".time().",`check_code_state`=1 where `id`=".$order['id'];}
				$sql="update ".$table_pre."order set `check_code`='".$random_code."',`send_time`=".time().",`check_code_state`=1 where `id`=".$order['id'];
				$pdo->exec($sql);
			}
			
			//=======================================================================================http
			if(count($http)>0){
				foreach($http as $v2){
					if($order['receiver_id']<1){
						$sql="select `phone` from ".$pdo->index_pre."user where `username`='".$order['buyer']."' limit 0,1";
						$buyer=$pdo->query($sql,2)->fetch(2);
						$order['receiver_phone']=$buyer['phone'];
					}
					$url=str_replace('{phone}',$order['receiver_phone'],de_safe_str($v2));
					$url=str_replace('{email}',@$user['email'],$url);
					$url=str_replace('{order_id}',$order['id'],$url);
					$url=str_replace('{random_int}',$random_int,$url);
					$url=str_replace('{random_str}',$random_str,$url);
					$url=str_replace('{shopName}',$shopName,$url);
					$url=str_replace('{address}',$shop_address,$url);
					$url=str_replace('{tel}',$tel,$url);
					$url=str_replace('{check_code}',$random_code,$url);
					$url=trim($url);
					//file_put_contents('./auto_send_test.txt',@file_get_contents('./auto_send_test.txt')."\r\n".$url);
					curl_open($url);
				}
			}
		}
		return true;
	}
//==========================================================================================================================虚拟物品自动发货 end	
	
	
	

//======================================================================================================= 购物后 自动添加买家为店内会员
	function add_shop_buyer($pdo,$username,$shop_id){
		$sql="select `id`,`phone` from ".self::$table_pre."shop_buyer where `shop_id`=".$shop_id." and `username`='".$username."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){return false;}
		$sql="select `id` from ".self::$table_pre."shop_buyer_group where `shop_id`=".$shop_id." order by `discount` desc limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		$group_id=$r['id'];
		
		$sql="select `phone`,`email` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
		$user=$pdo->query($sql,2)->fetch(2);
		
		require_once('plugin/py/py_class.php');
		$py_class=new py_class();  
		try { $py=$py_class->str2py($username); } catch(Exception $e) { $py='';}
		
		$sql="insert into ".self::$table_pre."shop_buyer (`username`,`username_py`,`time`,`shop_id`,`group_id`,`phone`,`email`) value ('".$username."','".$py."','".time()."','".$shop_id."','".$group_id."','".$user['phone']."','".$user['email']."')";
		return $pdo->exec($sql);	
	}
	
	
//======================================================================================================= 更新店内会员 订单统计
	function update_shop_buyer($pdo,$table_pre,$order){
		$sql="select count(id) as c,sum(`actual_money`) as c2 from ".self::$table_pre."order where `shop_id`=".$order['shop_id']." and `buyer`='".$order['buyer']."' and `state`=6";
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="update ".self::$table_pre."shop_buyer set `money`='".$r['c2']."',`order`='".$r['c']."' where `shop_id`=".$order['shop_id']." and `username`='".$order['buyer']."'";
		$pdo->exec($sql);
			
	}

	
//======================================================================================================= 判断是否店内VIP会员(弃用)
	function is_shop_vip($pdo,$shop_id){
		if(!isset($_SESSION['monxin']['username'])){return false;}
		$sql="select `vip` from ".self::$table_pre."shop_buyer where `shop_id`=".$shop_id." and `username`='".$_SESSION['monxin']['username']."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['vip']=='' || $r['vip']==0){return false;}else{return true;}	
	}
	
	function get_shop_buyer_group_option($pdo,$shop_id){
		$sql="select `id`,`name` from ".self::$table_pre."shop_buyer_group where `shop_id`=".$shop_id;
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			$list.='<option value="'.$v['id'].'">'.$v['name'].'</option>';	
		}
		return $list;	
	}

	function get_goods_state_option($pdo){
		$list='';
		foreach(self::$language['goods_state'] as $k=>$v){
			$list.='<option value="'.$k.'">'.$v.'</option>';	
		}
		return $list;	
	}
	
//======================================================================================================= 更新预售期结束的商品
	function update_pre_sale_goods($pdo){
		$time=time();
		$sql="select `goods_id` from ".self::$table_pre."pre_sale where `last_pay_start_time`<".$time;
		$r=$pdo->query($sql,2);
		$ids='';
		foreach($r as $v){
			$ids.=$v['goods_id'].',';	
		}
		$ids=trim($ids,',');
		if($ids!=''){
			$sql="update ".self::$table_pre."goods set `state`=2 where `id` in (".$ids.")";
			$pdo->exec($sql);	
		}
		
	}
	
	
//======================================================================================================= 返回商品各店内会员折扣度
	function get_goods_group_discount($pdo,$goods_id){
		$sql="select `discount`,`id`,`name` from ".self::$table_pre."shop_buyer_group where `shop_id`=".SHOP_ID;
		$r=$pdo->query($sql,2);
		$attribute='';
		foreach($r as $v){
			$sql="select `discount` from ".self::$table_pre."goods_group_discount where `goods_id`=".$goods_id." and `group_id`=".$v['id']." limit 0,1";
			$r2=$pdo->query($sql,2)->fetch(2);
			if($r2['discount']!=''){
				$v['discount']=$r2['discount'];
			}
			$attribute.=' g_'.$v['id'].'='.$v['discount'].' gname_'.$v['id'].'="'.$v['name'].'"';
		}
		return $attribute;
		
	}
	
	
	function get_headquarters_name($pdo){
		$sql="select `name` from ".self::$table_pre."headquarters where `username`='".$_SESSION['monxin']['username']."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		return $r['name'];	
	}
	
	function get_head_id($pdo,$shop_id){
		$sql="select `head` from ".self::$table_pre."shop where `id`=".$shop_id;
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="select `id` from ".self::$table_pre."shop where `name`='".$r['head']."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		return $r['id'];
	}
	

	
//=======================================================================================================【返回最近入库商品成本】
	function get_cost_price_new($pdo,$goods_id){
		$sql="select `price` from ".self::$table_pre."goods_batch where  `goods_id`='".$goods_id."' order by `id` desc limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if(!$r['price']){$r['price']=0;}
		if($r['price']==0){
			if(is_numeric($goods_id)){
				$sql="select `cost_price` from ".self::$table_pre."goods where `id`=".$goods_id;
			}else{
				$temp=explode('_',$goods_id);
				$sql="select `cost_price` from ".self::$table_pre."goods_specifications where `id`=".$temp[1];	
			}
			$r=$pdo->query($sql,2)->fetch(2);
			$r['price']=$r['cost_price'];
		}
		return $r['price'];	
	}
//=======================================================================================================【返回最近入库商品成本 不限规格】
	function get_cost_price_new_2($pdo,$goods_id){
		if(is_numeric($goods_id)){
			$sql="select `price` from ".self::$table_pre."goods_batch where  `goods_id` ='".$goods_id."' order by `id` desc limit 0,1";
		}else{
			$temp=explode('_',$goods_id);
			$sql="select `price` from ".self::$table_pre."goods_batch where  `goods_id` like '".$temp[0]."_%' order by `id` desc limit 0,1";
		}
		$r=$pdo->query($sql,2)->fetch(2);
		if(!$r['price']){$r['price']=0;}
		if($r['price']==0){
			if(is_numeric($goods_id)){
				$sql="select `cost_price` from ".self::$table_pre."goods where `id`=".$goods_id;
			}else{
				$temp=explode('_',$goods_id);
				$sql="select `cost_price` from ".self::$table_pre."goods_specifications where `id`=".$temp[1];	
			}
			$r=$pdo->query($sql,2)->fetch(2);
			$r['price']=$r['cost_price'];
		}				
		return $r['price'];	
	}
//=======================================================================================================【返回最近入库商品成本 不限规格2】
	function get_cost_price_new_3($pdo,$goods_id,$option_enable){
		if($option_enable==0){
			$sql="select `price` from ".self::$table_pre."goods_batch where  `goods_id` ='".$goods_id."' order by `id` desc limit 0,1";
		}else{
			$temp=explode('_',$goods_id);
			$sql="select `price` from ".self::$table_pre."goods_batch where  `goods_id` like '".$temp[0]."_%' order by `id` desc limit 0,1";
		}
		$r=$pdo->query($sql,2)->fetch(2);
		if(!$r['price']){$r['price']=0;}
		if($r['price']==0){
			if(is_numeric($goods_id)){
				$sql="select `cost_price` from ".self::$table_pre."goods where `id`=".$goods_id;
			}else{
				$temp=explode('_',$goods_id);
				$sql="select `cost_price` from ".self::$table_pre."goods_specifications where `id`=".$temp[1];	
			}
			$r=$pdo->query($sql,2)->fetch(2);
			$r['price']=$r['cost_price'];
		}				
		return $r['price'];	
	}
//=======================================================================================================【按商品先进先出方法，返回商品成本】
	function get_cost_price($pdo,$goods_id){
		$sql="select `price` from ".self::$table_pre."goods_batch where  `goods_id`='".$goods_id."' and `left`>0 order by `id` asc limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if(!$r['price']){
			$sql="select `price` from ".self::$table_pre."goods_batch where  `goods_id`='".$goods_id."' order by `id` desc limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
		}
		if(!$r['price']){$r['price']=0;}
		return $r['price'];	
	}

//=======================================================================================================【检测是否总部】
	function is_head($pdo,$shop_id){
		$sql="select `head` from ".self::$table_pre."shop where `id`=".$shop_id;
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="select `name` from ".self::$table_pre."headquarters where `username`='".$_SESSION['monxin']['username']."' limit 0,1";
		$r2=$pdo->query($sql,2)->fetch(2);
		if($r['head']==$r2['name']){return true;}else{return false;}
	}

	function get_language_option($r){
		$list='';
		foreach($r as $k=>$v){
			$list.='<option value="'.$k.'">'.$v.'</option>';
		}
		return $list;	
	}
	
	function get_circle_shop_ids($pdo,$circle){
		$sql="select `id` from ".self::$table_pre."shop where (`circle` in (".$circle.") || `span_circle`=1) and `state`=2";
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			$list.=$v['id'].',';	
		}
		$list=trim($list,',');
		return $list;	
	}
	
	function get_store_tag_shop_ids($pdo,$id){
		$sql="select `id` from ".self::$table_pre."shop where `tag` like '%|".$id."|%' and `state`=2";
		//echo $sql;
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			$list.=$v['id'].',';	
		}
		$list=trim($list,',');
		return $list;	
	}
	
	function get_grade_option($pdo,$shop_id){
		$sql="select `name` from ".self::$table_pre."goods_grade where `shop_id`=".$shop_id."";
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			$v['name']=de_safe_str($v['name']);
			$list.="<option value='".$v['name']."'>".$v['name']."</option>";
		}
		return $list;	
	}
	
	function get_habitat_option($pdo,$shop_id){
		$sql="select `name` from ".self::$table_pre."goods_habitat where `shop_id`=".$shop_id."";
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			$v['name']=de_safe_str($v['name']);
			$list.="<option value='".$v['name']."'>".$v['name']."</option>";
		}
		return $list;	
	}
	
	function get_contain_option($pdo,$shop_id){
		$sql="select `name` from ".self::$table_pre."goods_contain where `shop_id`=".$shop_id."";
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			$v['name']=de_safe_str($v['name']);
			$list.="<option value='".$v['name']."'>".$v['name']."</option>";
		}
		return $list;	
	}
	
	function get_headquarters_shop_id($pdo){
		$sql="select `id` from ".self::$table_pre."shop where `is_head`=1";
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			$list.=$v['id'].',';	
		}
		return trim($list,',');
	}
	
	function get_interest_word_array($pdo){
		$sql="select `name` from ".self::$table_pre."interest_word";
		$r=$pdo->query($sql,2);
		$word=array();	
		foreach($r as $v){
			$word[]=$v['name'];
		}
		return $word;
	}
	
	function collect_interest($pdo){
		if(!isset($_SESSION['monxin']['username'])){return false;}
		$monxin=@$_GET['monxin'];
		$word=array();
		$time=time();
		$type_id=0;
		switch($monxin){
			case 'mall.goods_list':
				if(@$_GET['search']!=''){
					$word[]=safe_str($_GET['search']);
					
				}elseif(@$_GET['type']!=''){
					$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=".intval($_GET['type']);
					$r=$pdo->query($sql,2)->fetch(2);
					$word[]=$r['name'];
					$type_id=$r['id'];
					if($r['parent']==0){
						$sql="select `id` from ".self::$table_pre."interest_group where `name`='".$r['name']."'";
						$r=$pdo->query($sql,2)->fetch(2);
						if($r['id']==''){
							$sql="insert into ".self::$table_pre."interest_group (`name`) values ('".$r['name']."')";	
							$pdo->exec($sql);
							$r['id']=$pdo->lastInsertId();
						}
						
						$gid=$r['id'];
						$sql="update ".self::$table_pre."interest_group set `day`=`day`+1,`week`=`week`+1,`month`=`month`+1,`year`=`year`+1,`sum`=`sum`+1 where `id`='".$gid."'";
						$pdo->exec($sql);
						$sql="select `id` from ".self::$table_pre."interest_group_user where `group_id`=".$gid." and `username`='".$_SESSION['monxin']['username']."' limit 0,1";
						$r=$pdo->query($sql,2)->fetch(2);
						if($r['id']==''){
							$sql="insert into ".self::$table_pre."interest_group_user (`group_id`,`username`,`frequency`,`last_time`) values ('".$gid."','".$_SESSION['monxin']['username']."','1','".$time."')";
							$pdo->exec($sql);
						}else{
							$sql="update ".self::$table_pre."interest_group_user set `frequency`=`frequency`+1,`last_time`=".$time." where `group_id`=".$gid." and `username`='".$_SESSION['monxin']['username']."' limit 1";
							$pdo->exec($sql);	
						}
							
					}
				}
				break;
				
			case 'mall.goods':
				$sql="select `title`,`type` from ".self::$table_pre."goods where `id`=".intval($_GET['id']);
				$r=$pdo->query($sql,2)->fetch(2);
				$type_id=$r['type'];
				$w=self::get_interest_word_array($pdo);
				$title=strtolower($r['title']);
				foreach($w as $v){
					if($v==''){continue;}
					if(strpos($title,$v)!==false){$word[]=$v;}	
				}
					$sql="select `name` from ".self::$table_pre."type where `id`=".$type_id;
					$r=$pdo->query($sql,2)->fetch(2);
					$word[]=$r['name'];	
				break;
			
			case 'mall.shop_goods_list':
				if(@$_GET['search']!=''){
					$word[]=safe_str($_GET['search']);
				}elseif(@$_GET['type']!=''){
					$sql="select `name` from ".self::$table_pre."shop_type where `id`=".intval($_GET['type']);
					$r=$pdo->query($sql,2)->fetch(2);
					$word[]=$r['name'];
				}
				break;			
		}
		foreach($word as $v){
			
			$sql="select `id`,`group_ids` from ".self::$table_pre."interest_word where `name`='".$v."' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){
				$sql="insert into ".self::$table_pre."interest_word (`name`,`type_id`) values ('".$v."','".$type_id."')";
				$pdo->exec($sql);	
				$id=$pdo->lastInsertId();
				$group_ids='';
			}else{
				$id=$r['id'];
				$group_ids=$r['group_ids'];
			}
			
			
			$sql="select `id` from ".self::$table_pre."interest_word_user where `word_id`=".$id." and `username`='".$_SESSION['monxin']['username']."' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){
				$sql="insert into ".self::$table_pre."interest_word_user (`word_id`,`username`,`frequency`,`last_time`) values ('".$id."','".$_SESSION['monxin']['username']."','1','".$time."')";
				$pdo->exec($sql);
				
			}else{
				$sql="update ".self::$table_pre."interest_word_user set `frequency`=`frequency`+1,`last_time`=".$time." where `word_id`=".$id." and `username`='".$_SESSION['monxin']['username']."' limit 1";
				$pdo->exec($sql);	
			}
		
			$sql="update ".self::$table_pre."interest_word set `day`=`day`+1,`week`=`week`+1,`month`=`month`+1,`year`=`year`+1,`sum`=`sum`+1 where `id`=".$id;
			$pdo->exec($sql);
			$temp=explode(',',$group_ids);
			foreach($temp as $gid){
				if(!is_numeric($gid)){continue;}
				$sql="update ".self::$table_pre."interest_group set `day`=`day`+1,`week`=`week`+1,`month`=`month`+1,`year`=`year`+1,`sum`=`sum`+1 where `id`=".$gid;
				$pdo->exec($sql);
				$sql="select `id` from ".self::$table_pre."interest_group_user where `group_id`=".$gid." and `username`='".$_SESSION['monxin']['username']."' limit 0,1";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['id']==''){
					$sql="insert into ".self::$table_pre."interest_group_user (`group_id`,`username`,`frequency`,`last_time`) values ('".$gid."','".$_SESSION['monxin']['username']."','1','".$time."')";
					$pdo->exec($sql);
					
				}else{
					$sql="update ".self::$table_pre."interest_group_user set `frequency`=`frequency`+1,`last_time`=".$time." where `group_id`=".$gid." and `username`='".$_SESSION['monxin']['username']."' limit 1";
					$pdo->exec($sql);	
				}
				
			}
		}
	}
	
	function get_interest_group_id($pdo,$type_id){
		$name='';
		$sql="select `parent`,`name` from ".self::$table_pre."type where `id`=".$type_id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['parent']==0){$name=$r['name'];}
		if($name==''){
			$sql="select `parent`,`name` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['parent']==0){$name=$r['name'];}
		}
		if($name==''){
			$sql="select `parent`,`name` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['parent']==0){$name=$r['name'];}
		}
		if($name==''){
			$sql="select `parent`,`name` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['parent']==0){$name=$r['name'];}
		}
		if($name==''){return '';}
		$sql="select `id` from ".self::$table_pre."interest_group where `name`='".$name."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		return $r['id'];
			
	}
	
	function reset_interest_year($pdo){
		$sql="update ".self::$table_pre."interest_group set `year`=0";
		$pdo->exec($sql);
		$sql="update ".self::$table_pre."interest_word set `year`=0";
		$pdo->exec($sql);
	}
	
	function reset_interest_month($pdo){
		$sql="update ".self::$table_pre."interest_group set `month`=0";
		$pdo->exec($sql);
		$sql="update ".self::$table_pre."interest_word set `month`=0";
		$pdo->exec($sql);
	}
	
	function reset_interest_week($pdo){
		$sql="update ".self::$table_pre."interest_group set `week`=0";
		$pdo->exec($sql);
		$sql="update ".self::$table_pre."interest_word set `week`=0";
		$pdo->exec($sql);
	}
	
	function reset_interest_day($pdo){
		$sql="update ".self::$table_pre."interest_group set `day`=0";
		$pdo->exec($sql);
		$sql="update ".self::$table_pre."interest_word set `day`=0";
		$pdo->exec($sql);
	}
	
	


//======================================================================================================= 获取 品牌模块 上级选项
	function get_brand_parent($pdo,$id=0,$deep=3,$need_url=false){
		$sql="select `name`,`id` from ".self::$table_pre."brand where `parent`=0 and `id`!='$id' order by `sequence` desc";
		if(!$need_url){$sql="select `name`,`id` from ".self::$table_pre."brand where `parent`=0 and `id`!='$id' and (`url`='' or `url` is null) order by `sequence` desc";}
		$stmt=$pdo->query($sql,2);
		$module['parent']="";
		foreach($stmt as $v){
			$v['name']=de_safe_str($v['name']);
			$module['parent'].="<option value='".$v['id']."'>&nbsp;&nbsp;&nbsp;&nbsp;".$v['name']."</option>";
			if($deep>1){
				$sql2="select `name`,`id` from ".self::$table_pre."brand where `parent`=".$v['id']." and `id`!='$id' order by `sequence` desc";
				if(!$need_url){$sql2="select `name`,`id` from ".self::$table_pre."brand where `parent`=".$v['id']." and `id`!='$id' and (`url`='' or `url` is null) order by `sequence` desc";}
				$r=$pdo->query($sql2,2);
				foreach($r as $v2){
					$v2['name']=de_safe_str($v2['name']);
					$module['parent'].="<option value='".$v2['id']."' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$v2['name']."</option>";
					if($deep>2){
						
						$sql3="select `name`,`id` from ".self::$table_pre."brand where `parent`=".$v2['id']." and `id`!='$id' order by `sequence` desc";
						if(!$need_url){$sql3="select `name`,`id` from ".self::$table_pre."brand where `parent`=".$v2['id']." and `id`!='$id'  and (`url`='' or `url` is null)  order by `sequence` desc";}
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
	
	//==============================================================================================================共库存商品 获取大包装 库存
	function get_big_inventory($pdo,$small){
		$sql="select `big`,`quantity` from ".self::$table_pre."public_stock where `small`=".$small." limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['big']!=0 && $r['quantity']>0){
			$sql="select `id`,`inventory`,`option_enable` from ".self::$table_pre."goods where `id`=".$r['big'];
			$g=$pdo->query($sql,2)->fetch(2);
			if($g['option_enable']){
				$g['inventory']=0;
				$sql="select `quantity` from ".self::$table_pre."goods_specifications where `goods_id`='".$r['big']."'";
				$gs=$pdo->query($sql,2);
				$list=array();
				$module['inventory']=0;
				foreach($gs as $v){
					$g['inventory']+=$v['quantity'];
				}
			}
			return $g['inventory']*$r['quantity'];			
		}else{return 0;}
	}
	
//======================================================================================================= 操作买家店内积分
	function operator_shop_buyer_credits($pdo,$username,$money,$reason,$shop_id){
		$sql="update ".self::$table_pre."shop_buyer set `credits`=`credits`+".$money.",`cumulative_credits`=`cumulative_credits`+".$money." where `username`='".$username."' and `shop_id`=".$shop_id." limit 1";
		if($pdo->exec($sql)){
			$sql="insert into ".self::$table_pre."shop_buyer_credits (`username`,`shop_id`,`time`,`money`,`reason`) values ('".$username."','".$shop_id."','".time()."','".$money."','".$reason."')";	
			$pdo->exec($sql);
			return true;
		}
		return false;
	}
	
	function update_order_pay_method_remark($pdo){
		$sql="select `id`,`pay_method_remark` from ".self::$table_pre."order where `pay_method`='online_payment' and (`state`=1 or `state`=2)";
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			if($v['pay_method_remark']!=''){continue;}
			$sql="select `type` from ".$pdo->index_pre."recharge where `state`=4 and `return_function`='mall.update_order_state' and `for_id`='".$v['id']."' or `for_id` like '".$v['id'].",%' or `for_id` like '%,".$v['id'].",%' or `for_id` like '%,".$v['id']."' limit 0,1";
			$r2=$pdo->query($sql,2)->fetch(2);
			if($r2['type']==''){$type='unknow';}else{$type=$r2['type'];}
			$sql="update ".self::$table_pre."order set `pay_method_remark`='".$type."' where `id`=".$v['id'];
			$pdo->exec($sql);
		}		
	}
	
	function get_kg_rate($pdo,$id){
		$sql="select `gram` from ".self::$table_pre."unit where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['gram']==0){return 0;}
		return 1000/$r['gram'];	
	}
	
	function get_goods_s($pdo,$goods_id){
		$sql="select `id`,`w_price` from ".self::$table_pre."goods_specifications where `goods_id`=".$goods_id." limit 0,2";
		$s=$pdo->query($sql,2);
		$re=array();
		$re['s_id']=0;
		$re['s_price']=0;
		foreach($s as $sv){
			if($re['s_id']!=0){$re['s_id']=0;$re['s_price']=0;}else{$re['s_id']=$goods_id.'_'.$sv['id'];$re['s_price']=$sv['w_price'];}
		}
		return $re;
	}
	
	function update_checkout_log($pdo,$shop_id,$day,$log_id,$username){
		$start_time=$day;
		$end_time=$start_time+86400;
		
		$where=" and `add_time`>$start_time";	
		$where.=" and `add_time`<$end_time";	
		
		$sql="select `cashier` from ".self::$table_pre."shop where `id`=".$shop_id;
		$r=$pdo->query($sql,2)->fetch(2);
		$r=explode(',',$r['cashier']);
		$cashier=array();
		$index=0;
		foreach($r as $v){
			if($v==''){break;}
			if($username!='' && $v!=$username){continue;}
			$cashier[$index]['username']=$v;
			$sql2="select sum(`actual_money`) as c,sum(`web_credits_money`) as c2 from ".self::$table_pre."order where `shop_id`=".$shop_id." and `state`=6 and `pay_method`='cash' and `cashier`='".$v."'".$where;
			$r2=$pdo->query($sql2,2)->fetch(2);
			$cashier[$index]['received_goods_money']=floatval($r2['c'])-floatval($r2['c2']);		
			
			$sql2="select sum(`actual_money`) as c from ".self::$table_pre."order where `shop_id`=".$shop_id." and `state`=6 and `pay_method`='pos' and `cashier`='".$v."'".$where;
			$r2=$pdo->query($sql2,2)->fetch(2);
			$cashier[$index]['pos']=floatval($r2['c']);		
			
			$sql2="select sum(`actual_money`) as c from ".self::$table_pre."order where `shop_id`=".$shop_id." and `state`=6 and `pay_method`='balance' and `cashier`='".$v."'".$where;
			$r2=$pdo->query($sql2,2)->fetch(2);
			$cashier[$index]['balance']=floatval($r2['c']);		
			
			$sql2="select sum(`actual_money`) as c from ".self::$table_pre."order where `shop_id`=".$shop_id." and `state`=6 and `pay_method`='shop_balance' and `cashier`='".$v."'".$where;
			$r2=$pdo->query($sql2,2)->fetch(2);
			$cashier[$index]['shop_balance']=floatval($r2['c']);		
			
			$sql2="select sum(`actual_money`) as c from ".self::$table_pre."order where `shop_id`=".$shop_id." and `state`=6 and `pay_method`='weixin' and `cashier`='".$v."'".$where;
			$r2=$pdo->query($sql2,2)->fetch(2);
			$cashier[$index]['weixin']=floatval($r2['c']);		
			
			$sql2="select sum(`actual_money`) as c from ".self::$table_pre."order where `shop_id`=".$shop_id." and `state`=6 and `pay_method`='alipay' and `cashier`='".$v."'".$where;
			$r2=$pdo->query($sql2,2)->fetch(2);
			$cashier[$index]['alipay']=floatval($r2['c']);		
			
			
			$sql2="select sum(`actual_money`) as c from ".self::$table_pre."order where `shop_id`=".$shop_id." and `state`=6 and `pay_method`='weixin_p' and `cashier`='".$v."'".$where;
			$r2=$pdo->query($sql2,2)->fetch(2);
			$cashier[$index]['weixin_p']=floatval($r2['c']);		
			
			$sql2="select sum(`actual_money`) as c from ".self::$table_pre."order where `shop_id`=".$shop_id." and `state`=6 and `pay_method`='alipay_p' and `cashier`='".$v."'".$where;
			$r2=$pdo->query($sql2,2)->fetch(2);
			$cashier[$index]['alipay_p']=floatval($r2['c']);		
			
			
			$sql2="select sum(`actual_money`) as c from ".self::$table_pre."order where `shop_id`=".$shop_id." and `state`=6 and `pay_method`='meituan' and `cashier`='".$v."'".$where;
			$r2=$pdo->query($sql2,2)->fetch(2);
			$cashier[$index]['meituan']=floatval($r2['c']);		
			
			
			$sql2="select sum(`actual_money`) as c from ".self::$table_pre."order where `shop_id`=".$shop_id." and `state`=6 and `pay_method`='nuomi' and `cashier`='".$v."'".$where;
			$r2=$pdo->query($sql2,2)->fetch(2);
			$cashier[$index]['nuomi']=floatval($r2['c']);		
			
			$sql2="select sum(`actual_money`) as c from ".self::$table_pre."order where `shop_id`=".$shop_id." and `state`=6 and `pay_method`='other' and `cashier`='".$v."'".$where;
			$r2=$pdo->query($sql2,2)->fetch(2);
			$cashier[$index]['other']=floatval($r2['c']);		
			
			$sql2="select sum(`actual_money`) as c from ".self::$table_pre."order where `shop_id`=".$shop_id." and `state`=6 and `pay_method`='credit' and `cashier`='".$v."'".$where;
			$r2=$pdo->query($sql2,2)->fetch(2);
			$cashier[$index]['credit']=floatval($r2['c']);		
			
			$sql2="select count(`id`) as c from ".self::$table_pre."order where `shop_id`=".$shop_id." and `state`=6 and `cashier`='".$v."'".$where;
			$r2=$pdo->query($sql2,2)->fetch(2);
			$cashier[$index]['exe_order']=floatval($r2['c']);	
			
			$sql2="select sum(`money`) as c from ".self::$table_pre."shop_buyer_balance where `shop_id`=".$shop_id." and `operator`='".$v."'".(str_replace('add_','',$where));
			$r2=$pdo->query($sql2,2)->fetch(2);
			$cashier[$index]['recharge']=floatval($r2['c']);	
			
			$sql2="select sum(`pay_2`) as c from ".self::$table_pre."order where `shop_id`=".$shop_id." and `state`=6 and `pay_method`='balance' and `cashier`='".$v."'".$where;
			$r2=$pdo->query($sql2,2)->fetch(2);
			$cashier[$index]['pay_2']=floatval($r2['c']);	
			
			
			
			$index++;	
		}
		
		$module['list']='';
		foreach($cashier as $v){			
			$sql="update ".self::$table_pre."checkout_log set `balance`='".$v['balance']."',`shop_balance`='".$v['shop_balance']."',`cash`='".$v['received_goods_money']."',`credit`='".$v['credit']."',`alipay`='".$v['alipay']."',`weixin`='".$v['weixin']."',`pos`='".$v['pos']."',`alipay_p`='".$v['alipay_p']."',`weixin_p`='".$v['weixin_p']."',`meituan`='".$v['meituan']."',`nuomi`='".$v['nuomi']."',`other`='".$v['other']."',`recharge`='".$v['recharge']."',`pay_2`='".$v['pay_2']."' where `id`=".$log_id;
			$pdo->exec($sql);	
		}
		
		
		
	}
	
	function call_update_checkout_log($pdo,$shop_id,$username=''){
		$time=time();
		$today=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);
		$today=get_unixtime($today,'y-m-d');
		
		$sql="select `cashier` from ".self::$table_pre."shop where `id`=".$shop_id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['cashier']==''){return false;}
		$temp=explode(',',$r['cashier']);
		foreach($temp as $v){
			if($v==''){continue;}
			if($username!='' && $v!=$username){continue;}	
			for($i=0;$i<8;$i++){
				$day=$today-$i*86400;
				$sql="select `id` from ".self::$table_pre."checkout_log where `shop_id`=".$shop_id." and `username`='".$v."' and `day`=".$day." limit 0,1";
				$r=$pdo->query($sql,2)->fetch(2);
				
				if($r['id']==''){
					$sql="insert into ".self::$table_pre."checkout_log (`day`,`username`,`shop_id`) values ('".$day."','".$v."','".$shop_id."')";
					$pdo->exec($sql);
					$r['id']=$pdo->lastInsertId();
				}
				
				self::update_checkout_log($pdo,$shop_id,$day,$r['id'],$v);
			}
	
		}
		
	}
	
	function end_pre_sale_order($pdo,$order,$pre_sale){
		if(time()>$pre_sale['last_pay_end_time']){
			$sql="update ".self::$table_pre."order set `state`=15 where `id`=".$order['id'];
			if($pdo->exec($sql)){
				$r=$order;
				$seller=self::get_shop_master($pdo,$order['shop_id']);
				$r['actual_money']=$pre_sale['deposit'];
				$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.order_admin&search='.$r['out_id'].' target=_blank>'.$r['out_id'].'</a>',self::$language['add_order_money_template']);
				$reason=str_replace('{sum_money}',$r['actual_money'],$reason);
				if(operator_money(self::$config,self::$language,$pdo,$seller,$r['actual_money'],$reason,'mall')){
					self::operation_shop_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],$r['actual_money'],9,$reason);
					exit('<script>window.location.reload();</script>');
				}
					
				
			}
		}
		return false;
	}
	
	
	//======================================================================================================= 新增店铺财务记录
	function operation_shop_finance($language,$pdo,$table_pre,$shop_id,$money,$type,$reason){
		$sql="select `after_money` from ".$table_pre."shop_finance where `shop_id`=".$shop_id." order by `id` desc limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		$before_money=$r['after_money'];
		$money=str_replace('+','',$money);
		//echo $money;
		$after_money=$before_money+$money;
		$sql="insert into ".$table_pre."shop_finance (`type`,`time`,`money`,`before_money`,`after_money`,`operator`,`reason`,`shop_id`) values ('".$type."','".time()."','".$money."','".$before_money."','".$after_money."','".@$_SESSION['monxin']['username']."','".$reason."','".$shop_id."')";
		if($pdo->exec($sql)){
			return true;
		}else{
			return false;
		}
	}
	
	//======================================================================================================= 更新单个商品月销量
	function update_goods_monthly_id($pdo,$goods_id){
		$start_time=time()-(86400*30);
		$sql="select sum(quantity) as c from ".self::$table_pre."order_goods where `goods_id`=".$goods_id." and `time`>".$start_time;
		$v2=$pdo->query($sql,2)->fetch(2);
		$sql="update ".self::$table_pre."goods set `monthly`=".$v2['c']." where `id`=".$goods_id;
		$pdo->exec($sql);	
		
	}

	function get_satisfaction($r){
		if($r['evaluation_2']==0 && $r['evaluation_0']==0){
			$module['satisfaction']=100;
		}elseif($r['evaluation_0']==0 && $r['evaluation_2']!=0){
			$module['satisfaction']=0;
		}else{
			$module['satisfaction']=intval($r['evaluation_0']/($r['evaluation_0']+$r['evaluation_2'])*100);
		}
		return $module['satisfaction'];
	}
		
}
?>