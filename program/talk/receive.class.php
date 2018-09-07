<?php
class receive{
	public static $config,$language,$table_pre;
	function __construct($pdo){
		if(!self::$config){
			//echo 'construct<br>';
			global $config,$language,$program,$page;
			$program_config=require_once './program/'.$program.'/config.php';
			$program_language=require_once './program/'.$program.'/language/'.$program_config['program']['language'].'.php';
			self::$config=array_merge($config,$program_config);
			self::$language=array_merge($language,$program_language);
			self::$table_pre=$pdo->sys_pre.self::$config['class_name']."_";
		}		
	
	}
	
	function __call($method,$args){
		//var_dump( $args);
		@require "./plugin/set_magic_quotes_gpc_off/set_magic_quotes_gpc_off.php";
		$pdo=$args[0];
		$call=$method;
		$class=__CLASS__;
		$method=$class."::".$method;
		require './program/'.self::$config['class_name'].'/receive/'.$call.'.php';
   }
   	function update_type_sum($pdo,$id,$d=0){
		$sql="select `type` from ".self::$table_pre."title where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$id=$r['type'];
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
   
	function add_content($pdo,$content,$id,$type,$for=0,$email=0){
		$content=safe_str($content);
		$sql="insert into ".self::$table_pre."content (`content`,`title_id`,`username`,`time`,`ip`,`for`,`email`) values ('".$content."','".$id."','".$_SESSION['monxin']['username']."','".time()."','".get_ip()."','".$for."','".$email."')";
		if($pdo->exec($sql)){
			$_POST['insret_id']=$pdo->lastInsertId();
			$sql="update ".self::$table_pre."type set `content_sum`=`content_sum`+1 where `id`=".$type;
			$pdo->exec($sql);
			$sql="update ".self::$table_pre."title set `contents`=`contents`+1,`reply_time`='".time()."' where `id`=".$id;
			$pdo->exec($sql);
			$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';	
			$imgs=get_match_all($reg,$content);
			reg_attachd_img("add",self::$config['class_name'],$imgs,$pdo,self::$config['program']['imageMark']);
			if($for){
				$sql="select `email`,`username`,`content` from ".self::$table_pre."content where `id`=".$for;
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['email']==1){
					$sql="select `email` from ".$pdo->index_pre."user where `username`='".$r['username']."'";
					$r2=$pdo->query($sql,2)->fetch(2);
					if(is_email($r2['email'])){
						$end_page=@$_POST['current_page'];
						$title='《'.mb_substr((strip_tags($r['content'])),0,30).'》'.self::$language['have_a_new_comment'];
						$content=self::$language['content'].':<br />'.$content.'<br /><a href='.get_monxin_path().'index.php?monxin=talk.content&id='.$id.'&current_page='.$end_page.'>'.self::$language['see_details'].'</a>';
						email(self::$config,self::$language,$pdo,'monxin',$r2['email'],$title,$content);	
					}	
				}
			}else{
				
				$sql="select `email`,`username`,`title` from ".self::$table_pre."title where `id`=".$id;
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['email']==1){
					$sql="select `email` from ".$pdo->index_pre."user where `username`='".$r['username']."'";
					$r2=$pdo->query($sql,2)->fetch(2);
					if(is_email($r2['email'])){
						$sql="select count(id) as c from ".self::$table_pre."content  where `title_id`='".$id."' and `for`=0 and `visible`=1";
						$r3=$pdo->query($sql,2)->fetch(2);
						$module_config=require './program/talk/module_config.php';
						$end_page=ceil($r3['c']/$module_config['talk.content']['pagesize']);
						$title='《'.$r['title'].'》'.self::$language['have_a_new_replay'];
						$content=self::$language['content'].':<br />'.$content.'<br /><a href='.get_monxin_path().'index.php?monxin=talk.content&id='.$id.'&current_page='.$end_page.'>'.self::$language['see_details'].'</a>';
						email(self::$config,self::$language,$pdo,'monxin',$r2['email'],$title,$content);	
					}	
				}
			}
			return true;
		}else{
			return false;
		}
	}
	function del_content($pdo,$id,$type){
		$sql="select count(id) as c from ".self::$table_pre."content where `for`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist_sub_comments_cannot_be_deleted']."</span>'}");}
		
		$sql="select * from ".self::$table_pre."content where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="delete from ".self::$table_pre."content where `id`=".$id;
		if($pdo->exec($sql)){
			$sql="update ".self::$table_pre."type set `content_sum`=`content_sum`-1 where `id`=".$type;
			$pdo->exec($sql);
			$sql="update ".self::$table_pre."title set `contents`=`contents`-1 where `id`=".$r['title_id'];
			$pdo->exec($sql);
			$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
			$imgs=get_match_all($reg,$r['content']);
			reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);	
	
			return true;
		}else{
			return false;
		}
	}
	
	function update_content($pdo,$id,$content,$email=0){
		$content=safe_str($content);
		$sql="select `content` from ".self::$table_pre."content where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$old_content=$r['content'];
		$sql="update ".self::$table_pre."content set `content`='".$content."',`email`='".$email."',`time`='".time()."',`ip`='".get_ip()."' where `id`='".$id."' and `username`='".$_SESSION['monxin']['username']."'";
		if($pdo->exec($sql)){
	
			$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
			$new_imgs=get_match_all($reg,$content);
			//var_dump($new_imgs);
			$old_imgs=get_match_all($reg,$old_content);
			foreach($old_imgs as $v){
				if(!in_array($v,$new_imgs)){
					$sql="select count(id) as c from ".self::$table_pre."content where `content` like '%".$v."%'";
					$r=$pdo->query($sql,2)->fetch(2);
					if($r['c']==0){
						$path=$v;
						reg_attachd_img("del",self::$config['class_name'],$path,$pdo);
					}
				}	
			}
			$imgs=array();
			foreach($new_imgs as $v){
				if(!in_array($v,$old_imgs)){$imgs[]=$v;}	
			}
			if(count($imgs)>0){reg_attachd_img("add",self::$config['class_name'],$imgs,$pdo,self::$config['program']['imageMark']);}
	
			return true;
		}else{
			return false;
		}
	}
	
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
}
?>