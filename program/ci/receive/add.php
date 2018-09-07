<?php
if(self::$config['visitor_add']==false && !isset($_SESSION['monxin']['username'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['act_noPower']."</span>'}");}
if(self::check_day_add_max($pdo,self::$table_pre,self::$config['day_add_max'])===false){
	exit("{'state':'fail','info':'<span class=fail>".str_replace('{v}',self::$config['day_add_max'],self::$language['published_daily_limit_has_been_reached_please_come_back_tomorrow_to_release'])."</span>'}");
}

$type=intval(@$_GET['type']);
if($type==0){exit("{'state':'fail','info':'<span class=fail>type err</span>'}");}
$act=@$_GET['act'];
if($act=='add'){
	$_POST=safe_str($_POST);
	if(!isset($_SESSION['monxin']['username'])){
		if(strtolower($_POST['authcode'])!=strtolower($_SESSION["authCode"])){
			exit("{'state':'fail','info':'<span class=fail>".self::$language['authcode_err']."</span>','id':'authcode'}");	
		}
		if(self::check_day_add_max($pdo,self::$table_pre,self::$config['day_add_max'],$_POST['contact'])===false){
			exit("{'state':'fail','info':'<span class=fail>".str_replace('{v}',self::$config['day_add_max'],self::$language['published_daily_limit_has_been_reached_please_come_back_tomorrow_to_release'])."</span>'}");
		}
	}
	
	$attribute_sql=array();
	$sql="select * from ".self::$table_pre."type_attribute where `type_id`=".$type." order by `sequence` desc,`id` asc";
	$r=$pdo->query($sql,2);
	$fields='';
	$values='';
	foreach($r as $v){
		$v=de_safe_str($v);
		$v['name']='a_'.$v['id'];
		$args=format_attribute($v['input_args']);
		if($v['required'] && $_POST[$v['name']]==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'".$v['name']."'}");}
		if($v['reg']!='' && $v['required']){
			if(!is_match($v['reg'],$_POST[$v['name']])){exit("{'state':'fail','info':'<span class=fail>".self::$language['not_match']."</span>','id':'".$v['name']."'}");}			
		}
		if($v['input_type']=='time'){$_POST[$v['name']]=get_unixtime($_POST[$v['name']],self::$config['other']['date_style']);;}
		if($v['type']=='int' || $v['type']=='bigint' || $v['type']=='decimal'){
			if($_POST[$v['name']]!='' && !is_numeric($_POST[$v['name']])){exit("{'state':'fail','info':'<span class=fail>".self::$language['must_number']."</span>','id':'".$v['name']."'}");}
		}
		if($v['unique']){
			$sql="select count(id) as c from ".self::$table_pre."attribute_value where `a_id`='".$v['id']."' and `content`='".$_POST[$v['name']]."'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['c']>0){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist_same']."</span>','id':'".$v['name']."'}");}
		}
		//==============================================================================================textarea
		if($v['input_type']=='textarea' && $_POST[$v['name']]!=''){
			if($args['textarea_allow_html']!=1){ $_POST[$v['name']]=strip_tags($_POST[$v['name']]);	}
		}
		//==================================================================================================editor
		if($v['input_type']=='editor' && $_POST[$v['name']]!=''){
			$reg='#<img.*src="(program/'.self::$config['class_name'].'/attachd/.*)".*>#iU';		
			$imgs=get_match_all($reg,$_POST[$v['name']]);
			reg_attachd_img("add",self::$config['class_name'],$imgs,$pdo,$args['editor_open_image_mark']);		
		}
		//==================================================================================================number
		if($v['input_type']=='number' && $_POST[$v['name']]!=''){
			if(is_numeric($args['number_min']) && $_POST[$v['name']]<$args['number_min']){
				exit("{'state':'fail','info':'<span class=fail>".self::$language['must_be_greater_than'].$args['number_min']."</span>','id':'".$v['name']."'}");
			}
			if(is_numeric($args['number_max']) && $_POST[$v['name']]>$args['number_max']){
				exit("{'state':'fail','info':'<span class=fail>".self::$language['must_be_less_than'].$args['number_max']."</span>','id':'".$v['name']."'}");
			}
		}
		//==================================================================================================img
		if($v['input_type']=='img' && $_POST[$v['name']]!=''){
			if(file_exists('./temp/'.$_POST[$v['name']])){
				$path='./program/ci/img/'.safe_path($_POST[$v['name']]);
				get_date_dir('./program/ci/img/');
				get_date_dir('./program/ci/img_thumb/');
				if(safe_rename('./temp/'.safe_path($_POST[$v['name']]),$path)==false){
					exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>','id':'".$v['name']."'}");
				}
				$image=new image();
				resize_big_image($image,$path);
				if(intval($args['img_width'])>0 && intval($args['img_height'])>0){
					$image->thumb($path,'./program/ci/img_thumb/'.$_POST[$v['name']],intval($args['img_width']),intval($args['img_height']));
				}
				if($args['img_open_image_mark']){$image->addMark($path);}
				
			}else{
				$_POST[$v['name']]='';	
			}	
		}
		//==================================================================================================imgs
		if($v['input_type']=='imgs' && $_POST[$v['name']]!=''){
			get_date_dir('./program/ci/imgs/');
			get_date_dir('./program/ci/imgs_thumb/');
			$temp2='';
			$temp=explode('|',$_POST[$v['name']]);
			$temp=array_filter($temp);
			$image=new image();
			foreach($temp as $v2){
				if(file_exists('./temp/'.$v2)){
					$path='./program/ci/imgs/'.safe_path($v2);
					if(safe_rename('./temp/'.safe_path($v2),$path)==false){continue;}
					resize_big_image($image,$path);
					if(intval($args['imgs_width'])>0 && intval($args['imgs_height'])>0){
						$image->thumb($path,'./program/ci/imgs_thumb/'.$v2,intval($args['imgs_width']),intval($args['imgs_height']));
					}
					if($args['imgs_open_image_mark']){$image->addMark($path);}
					$temp2.='|'.$v2;
				}	
			}
			$_POST[$v['name']]=$temp2;
		}
		//==================================================================================================file
		if($v['input_type']=='file' && $_POST[$v['name']]!=''){
			if(file_exists('./temp/'.$_POST[$v['name']])){
				$path='./program/ci/file/'.safe_path($_POST[$v['name']]);
				get_date_dir('./program/ci/file/');
				if(safe_rename('./temp/'.safe_path($_POST[$v['name']]),$path)==false){
					exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>','id':'".$v['name']."'}");
				}				
			}else{
				$_POST[$v['name']]='';	
			}	
		}
		//==================================================================================================files
		if($v['input_type']=='files' && $_POST[$v['name']]!=''){
			get_date_dir('./program/ci/files/');
			$temp2='';
			$temp=explode('|',$_POST[$v['name']]);
			$temp=array_filter($temp);
			foreach($temp as $v2){
				if(file_exists('./temp/'.$v2)){
					$path='./program/ci/files/'.safe_path($v2);
					if(safe_rename('./temp/'.safe_path($v2),$path)==false){continue;}
					$temp2.='|'.$v2;
				}	
			}
			$_POST[$v['name']]=$temp2;
		}
		
		$_POST[$v['name']]=safe_str(@$_POST[$v['name']]);
		$attribute_sql[]="insert into ".self::$table_pre."attribute_value (`a_id`,`c_id`,`content`) values ('".$v['id']."','{c_id}','".$_POST[$v['name']]."')";
	}
	
if(@$_POST['icon']!=''){
	if(file_exists('./temp/'.$_POST['icon'])){
		$path='./program/ci/img/'.safe_path($_POST['icon']);
		get_date_dir('./program/ci/img/');	
		get_date_dir('./program/ci/img_thumb/');	
		if(safe_rename('./temp/'.safe_path($_POST['icon']),$path)==false){
			exit("{'state':'fail','info':'<span class=fail>image up failed</span>'}");
		}
		$image=new image();
		resize_big_image($image,$path);
		$image->thumb($path,'./program/ci/img_thumb/'.$_POST['icon'],self::$config['program']['thumb_width'],self::$config['program']['thumb_height']);
		if(self::$config['program']['imageMark']){
			$image->addMark($path);
		}
	}	
}
	
	
	$time=time();
	$_POST['circle']=intval($_POST['circle']);
	$user=@$_SESSION['monxin']['username'];
	$state=(self::$config['info_verify'])?0:1;
	if(isset($_POST['price'])){$price=floatval($_POST['price']);}else{$price='0.00';}
	if($price<0){$price='0.00';}
	$sql="insert into ".self::$table_pre."content (`type`,`icon`,`title`,`content`,`username`,`add_time`,`last_time`,`reflash`,`state`,`price`,`linkman`,`contact`,`circle`) values ('".$type."','".@$_POST['icon']."','".$_POST['title']."','".$_POST['content']."','".$user."','".$time."','".$time."','".$time."','".$state."','".$price."','".$_POST['linkman']."','".$_POST['contact']."','".$_POST['circle']."')";
	//echo $sql;
	if($pdo->exec($sql)){
		$id=$pdo->lastInsertId();
		foreach($attribute_sql as $v){
			$v=str_replace('{c_id}',$id,$v);
			$pdo->exec($v);
		}
		
		$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
		$imgs=get_match_all($reg,$_POST['content']);
		reg_attachd_img("add",self::$config['class_name'],$imgs,$pdo,self::$config['program']['imageMark']);
		if($_COOKIE['monxin_device']=='pc'){
			exit("{'state':'success','info':'<span class=success style=\"line-height:300px;\">".self::$language['release'].self::$language['success']." &nbsp; &nbsp; &nbsp; &nbsp; <a href=./index.php?monxin=ci.detail&id=".$id.">".self::$language['view'].self::$language['info']."</a> &nbsp; &nbsp; &nbsp; &nbsp; <a href=./index.php?monxin=ci.my_info>".self::$language['manage_my_info']."</a> &nbsp; &nbsp; &nbsp; &nbsp; <a href=./index.php?monxin=ci.top&id=".$id." class=set>".self::$language['top_the_info']."</a></span>'}");	
		}else{
			exit("{'state':'success','info':'<span class=success style=\"line-height:300px;\">".self::$language['release'].self::$language['success']."<br /><a href=./index.php?monxin=ci.detail&id=".$id.">".self::$language['view'].self::$language['info']."</a><br /><a href=./index.php?monxin=ci.my_info>".self::$language['manage_my_info']."</a><br /><a href=./index.php?monxin=ci.top&id=".$id." class=set>".self::$language['top_the_info']."</a></span>'}");	
			
		}
				
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
		
		
}
