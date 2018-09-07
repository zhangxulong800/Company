<?php
$act=$_GET['act'];

if($act=='talk_title_new'){
	$type=intval(@$_GET['type']);
	$last_id=floatval(@$_GET['last_id']);
	if($last_id=='' || $type=='' ){exit("{'state':'fail','info':'<span class=fail>is null</span>'}");}
	
	$sql="select `title`,`id`,`username` from ".$pdo->sys_pre."talk_title where `visible`=1 and `type`=".$type." and `id`>".$last_id;
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$v=de_safe_str($v);
		$list.="<tr id=tr_".$v['id']."><td><a href=./index.php?monxin=talk.content&id=".$v['id']." class=title>".$v['title']."</a></td><td>".$v['username']."</td><td colspan=10></td></tr>";
	}
	$result=array();
	$result['state']='success';
	$result['list']=$list;
	exit(json_encode($result));
	
}

if($act=='talk_content_new'){
	$id=intval(@$_GET['id']);
	$type=intval(@$_GET['type']);
	$last_id=floatval(@$_GET['last_id']);
	if($id=='' || $last_id=='' || $type=='' ){exit("{'state':'fail','info':'<span class=fail>is null</span>'}");}
	
	
	$manager='';
	$sql="select `manager`,`read_power` from ".$pdo->sys_pre."talk_type where `id`=".$type;
	$r2=$pdo->query($sql,2)->fetch(2);
	$manager=$r2['manager'];
	
	$sql="select * from ".$pdo->sys_pre."talk_content where `title_id`='".$id."' and `for`=0 and `visible`=1 and `id`>".$last_id." order by `id` asc";
	$r=$pdo->query($sql,2);
	$list='';
	$ids='';
	foreach($r as $v){
		$v=de_safe_str($v);
		$ids.=$v['id'].',';
		$operation='';
		if($manager==@$_SESSION['monxin']['username']){
			if($v['visible']){
				$operation="<a href='#' class='m_hide' cid=".$v['id'].">".self::$language['hide']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span>";	
			}else{
				$operation="<a href='#' class='m_show' cid=".$v['id'].">".self::$language['show']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span>";	
			}
		}
		
		$sql="select * from ".$pdo->sys_pre."talk_content where `title_id`='".$id."' and `for`='".$v['id']."'";
		$r2=$pdo->query($sql,2);
		$for='';
		foreach($r2 as $v2){
			$operation2='';
			if($manager==@$_SESSION['monxin']['username']){
				if($v2['visible']){
					$operation2="<a href='#' class='m_hide' cid=".$v2['id'].">".self::$language['hide']."</a> <a href='#' onclick='return del(".$v2['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v2['id']." class='state'></span>";	
				}else{
					$operation2="<a href='#' class='m_show' cid=".$v2['id'].">".self::$language['show']."</a> <a href='#' onclick='return del(".$v2['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v2['id']." class='state'></span>";	
				}
			}
			
			$for.="<div class=comment_div id=content_".$v2['id'].">".'<span class=username>'.$v2['username'].'</span><span class=time>'.get_time(self::$config['other']['date_style']." H:i",self::$config['other']['timeoffset'],self::$language,$v2['time']).'</span><div class=comemnt><div class=v>'.$v2['content'].'</div> <div class=buttons2>'.$operation2.'</div></div></div>';
		}
		$list.='<div class=content_div id=content_'.$v['id'].'><div class=content_author><span class=username>'.$v['username'].'</span><span class=time>'.get_time(self::$config['other']['date_style']." H:i",self::$config['other']['timeoffset'],self::$language,$v['time']).'</span>'."</div><div class=content_content><div class=answer><div class=v>".$v['content']."</div></div><div class=buttons>".$operation."<a href=# class=comment_button click_id=".$v['id'].">".self::$language['comment']."</a></div></div>".$for."</div>";				
	}
	
	$ids=trim($ids,',');
	
	if($ids==''){
		$sql="select * from ".$pdo->sys_pre."talk_content where `title_id`='".$id."' and `for`>0 and `visible`=1 and `id`>".$last_id." order by `id` asc";
	}else{
		$sql="select * from ".$pdo->sys_pre."talk_content where `title_id`='".$id."' and `for`>0 and `for` not in (".$ids.") and `visible`=1 and `id`>".$last_id." order by `id` asc";
	}
	$r=$pdo->query($sql,2);
	$comemnt='';
	foreach($r as $v2){
		$operation2='';
		if($manager==@$_SESSION['monxin']['username']){
			if($v2['visible']){
				$operation2="<a href='#' class='m_hide' cid=".$v2['id'].">".self::$language['hide']."</a> <a href='#' onclick='return del(".$v2['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v2['id']." class='state'></span>";	
			}else{
				$operation2="<a href='#' class='m_show' cid=".$v2['id'].">".self::$language['show']."</a> <a href='#' onclick='return del(".$v2['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v2['id']." class='state'></span>";	
			}
		}
		
		$comemnt.="<div class=comment_div for=".$v2['for']." id=content_".$v2['id'].">".'<span class=username>'.$v2['username'].'</span><span class=time>'.get_time(self::$config['other']['date_style']." H:i",self::$config['other']['timeoffset'],self::$language,$v2['time']).'</span><div class=comemnt><div class=v>'.$v2['content'].'</div> <div class=buttons2>'.$operation2.'</div></div></div>';
	}
		
	$result=array();
	$result['state']='success';
	$result['list']=$list;
	$result['comemnt']=$comemnt;
	exit(json_encode($result));
	
}

if($act=='load_wx_icon'){
	if(is_url($_SESSION['monxin']['icon']) && strlen($_SESSION['monxin']['icon'])>100){
		$path=get_date_dir('./program/index/user_icon/').time().'.png';
		$img=@file_get_contents($_SESSION['monxin']['icon']);
		if(!$img || strlen($img)<(1024)){
			$url=str_replace('wx.qlogo.cn','182.254.18.178',$_SESSION['monxin']['icon']);
			$img=@file_get_contents($url);
		}
		if($img && file_put_contents($path,$img)){
			$temp=explode('user_icon/',$path);
			$v['icon']=$temp[1];
			$_SESSION['monxin']['icon']=$v['icon'];
			$sql="update ".$pdo->index_pre."user set `icon`='".$_SESSION['monxin']['icon']."' where `id`=".$_SESSION['monxin']['id'];
			$pdo->exec($sql);
			//echo $sql;
		}		
	}
}

if($act=='inquiries_pay_state'){
	$id=intval(@$_GET['id']);
	$sql="select * from ".$pdo->index_pre."recharge where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	$v=inquiries_pay_state(self::$config,$r['type'],$r['in_id']);
	if($v){
		update_recharge($pdo,self::$config,self::$language,$r['in_id']);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','url':'".$r['return_url']."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
	}	
}


if($act=='share'){
	$browser_md5=md5($_SERVER['HTTP_USER_AGENT']);
	self::$config['credits_set']['share']=intval(self::$config['credits_set']['share']);
	$temp=explode('#',$_POST['url']);
	if($_SERVER["HTTP_REFERER"]!=$temp[0]){echo $_SERVER["HTTP_REFERER"].'!='.$_POST['url'].','; exit('HTTP_REFERER');}
	if($_POST['url']=='' || $_POST['title']=='' ||  $_POST['share']==''){exit('is null');}
	$share=intval($_POST['share']);
	if($share==0){exit('user err');}
	$sql="select `id`,`username` from ".$pdo->index_pre."user where `id`=".$share;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit('user err');}
	$username=$r['username'];
	$_SESSION['share']=$share;
	$url=explode('index.php?monxin=',$_POST['url']);
	if(isset($url[1])){
		$url=explode('&share=',$url[1]);
		$url=safe_str($url[0]);
	}else{
		$url=explode('share=',$_POST['url']);
		if(!isset($url[1])){exit('url is err');}
		$url='';
	}
	
	
	$title=mb_substr(safe_str($_POST['title']),0,30,'utf-8');
	$time=time();
	$visit_is_ip=false;
	if(isset($_SESSION['monxin']['username'])){$visit=$_SESSION['monxin']['username'];}else{$visit=get_ip();$visit_is_ip=true;}
	$time_start=$time-86400;
	if($visit_is_ip){
		$sql="select count(id) as c from ".$pdo->index_pre."share_visit where `visit`='".$visit."' and `browser_md5`='".$browser_md5."' and `time`>".$time_start." limit 0,3";
	}else{
		if($share==$_SESSION['monxin']['id']){exit('is your self');}
		$sql="select count(id) as c from ".$pdo->index_pre."share_visit where `visit`='".$visit."' and `time`>".$time_start." limit 0,3";
	}
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']==3){exit('share click >3');}
			
	
	$sql="select `id` from ".$pdo->index_pre."share where `user_id`='".$share."' and `url`='".$url."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$new=false;
	if($r['id']==''){
		$sql="insert into ".$pdo->index_pre."share (`user_id`,`url`,`title`,`time`,`contribution`,`username`) values ('".$share."','".$url."','".$title."','".$time."','".self::$config['credits_set']['share']."','".$username."')";
		if($pdo->exec($sql)){$r['id']=$pdo->lastInsertId();$new=true;}
		if($r['id']==''){exit('share_id err');}
	}else{
		$sql="update ".$pdo->index_pre."share set `contribution`=`contribution`+".self::$config['credits_set']['share'].",`time`=".$time." where `id`=".$r['id'];
		$pdo->exec($sql);
	}
	$_SESSION['share_url_id']=$r['id'];

	$sql="select `id` from ".$pdo->index_pre."share_visit where `share_id`=".$r['id']." and `visit`='".$visit."' limit 0,1";
	$temp=$pdo->query($sql,2)->fetch(2);
	if($temp['id']!=''){
		if($new){
			$sql="delete from ".$pdo->index_pre."share where `id`=".$r['id'];
			$pdo->exec($sql);
		}else{
			$sql="update ".$pdo->index_pre."share set `contribution`=`contribution`-".self::$config['credits_set']['share'].",`time`=".$time." where `id`=".$r['id'];
			$pdo->exec($sql);			
		}
		exit('is old user');
	}
	
	$sql="insert into ".$pdo->index_pre."share_visit (`share_id`,`visit`,`time`,`browser_md5`,`user_id`) values ('".$r['id']."','".$visit."','".$time."','".$browser_md5."','".$share."')";
	$pdo->exec($sql);
	$reason=str_replace('{page_title}','<a href=./index.php?monxin='.$url.'>'.$title.'</a>',self::$language['share_reson']);
	operation_credits($pdo,self::$config,self::$language,$username,self::$config['credits_set']['share'],$reason,'share');	
}
