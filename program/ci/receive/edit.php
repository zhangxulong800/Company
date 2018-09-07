<?php
$id=intval(@$_GET['id']);
if($id==0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
$act=@$_GET['act'];
if($act=='edit'){
	$sql="select * from ".self::$table_pre."content where `id`=".$id;
	$old=$pdo->query($sql,2)->fetch(2);
	if($old['id']==''){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	if($old['username']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['unauthorized_operation']."</span>'}");}
	if($old['username']!=$_SESSION['monxin']['username']){exit("{'state':'fail','info':'<span class=fail>".self::$language['unauthorized_operation']."</span>'}");}
	
	if($old['state']>1){exit("{'state':'fail','info':'<span class=fail>".self::$language['info_state'][$old['state']]."</span>'}");}
	$type=$old['type'];
	$_GET['type']=$old['type'];
	$_POST=safe_str($_POST);
	
	$attribute_val=array();
	$sql="select `content`,`a_id` from ".self::$table_pre."attribute_value where `c_id`=".$id;
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$attribute_val['a_'.$v['a_id']]=$v['content'];	
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
		if($v['input_type']=='editor'){
			$reg='#<img.*src="(program/'.self::$config['class_name'].'/attachd/.*)".*>#iU';		
			$imgs=get_match_all($reg,$_POST[$v['name']]);
			reg_attachd_img("add",self::$config['class_name'],$imgs,$pdo,$args['editor_open_image_mark']);	
			
			
			$reg='#<img.*src="(program/'.self::$config['class_name'].'/attachd/.*)".*>#iU';
			$new_imgs=get_match_all($reg,$_POST[$v['name']]);
			//var_dump($new_imgs);
			$old_imgs=get_match_all($reg,de_safe_str($attribute_val[$v['name']]));
			foreach($old_imgs as $v2){
				if(!in_array($v2,$new_imgs)){
						$path=$v2;
						safe_unlink($path);
						reg_attachd_img("del",self::$config['class_name'],$path,$pdo);
				}	
			}
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
		if($v['input_type']=='img'){
			if($_POST[$v['name']]!=''){
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
					@safe_unlink('./program/ci/img_thumb/'.$attribute_val[$v['name']]);
					@safe_unlink('./program/ci/img/'.$attribute_val[$v['name']]);
				}
			}else{
				$_POST[$v['name']]=$attribute_val[$v['name']];	
			}	
		}
		//==================================================================================================imgs
		if($v['input_type']=='imgs'){
			if($_POST[$v['name']]!=''){
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
			$_POST[$v['name']].=$_POST[$v['name'].'_old_value'];
			
			$temp=explode('|',$attribute_val[$v['name']]);
			$temp=array_filter($temp);
			$temp2=explode('|',$_POST[$v['name'].'_old_value']);
			$temp2=array_filter($temp2);
			foreach($temp as $v2){
				if(!in_array($v2,$temp2)){
					@safe_unlink('./program/ci/imgs_thumb/'.$v2);
					@safe_unlink('./program/ci/imgs/'.$v2);
				}
			}
			
		}
		//==================================================================================================file
		if($v['input_type']=='file'){
			if($_POST[$v['name']]!=''){
				if(file_exists('./temp/'.$_POST[$v['name']])){
					$path='./program/ci/file/'.safe_path($_POST[$v['name']]);
					get_date_dir('./program/ci/file/');
					if(safe_rename('./temp/'.safe_path($_POST[$v['name']]),$path)==false){
						exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>','id':'".$v['name']."'}");
					}
					@safe_unlink('./program/ci/file/'.$attribute_val[$v['name']]);
				}
			}else{
				$_POST[$v['name']]=$attribute_val[$v['name']];	
			}	
		}
		//==================================================================================================files
		if($v['input_type']=='files'){
			if($_POST[$v['name']]!=''){
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
			$_POST[$v['name']].=$_POST[$v['name'].'_old_value'];
			
			$temp=explode('|',$attribute_val[$v['name']]);
			$temp=array_filter($temp);
			$temp2=explode('|',$_POST[$v['name'].'_old_value']);
			$temp2=array_filter($temp2);
			foreach($temp as $v2){
				if(!in_array($v2,$temp2)){
					//echo $v2;
					@safe_unlink('./program/ci/files/'.$v2);
				}
			}
			
		}

		
		$_POST[$v['name']]=safe_str(@$_POST[$v['name']]);
		$sql="select `id` from ".self::$table_pre."attribute_value where `c_id`=".$id." and `a_id`=".str_replace('a_','',$v['name'])." limit 0,1";
		$r2=$pdo->query($sql,2)->fetch(2);
		if($r2['id']==''){
			$attribute_sql[]="insert into ".self::$table_pre."attribute_value (`a_id`,`c_id`,`content`) values ('".$v['id']."','".$id."','".$_POST[$v['name']]."')";	
		}else{
			$attribute_sql[]="update ".self::$table_pre."attribute_value set `content`='".$_POST[$v['name']]."' where `c_id`=".$id." and `a_id`=".str_replace('a_','',$v['name']);
		}
	}
	
	$time=time();
	$user=$_SESSION['monxin']['username'];
	$state=(self::$config['info_verify'])?0:1;
	if(isset($_POST['price'])){$price=floatval($_POST['price']);}else{$price='0.00';}
	if($price<0){$price='0.00';}
	
	if($_POST['icon']==''){
		$_POST['icon']=$old['icon'];	
	}else{
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
			@safe_unlink('./program/ci/img/'.$old['icon']);
			@safe_unlink('./program/ci/img_thumb/'.$old['icon']);
			
		}	
	}
	$_POST['circle']=intval($_POST['circle']);
	$sql="update ".self::$table_pre."content set `icon`='".$_POST['icon']."',`title`='".$_POST['title']."',`content`='".$_POST['content']."',`last_time`='".$time."',`reflash`='".$time."',`state`='".$state."',`price`='".$price."',`linkman`='".$_POST['linkman']."',`contact`='".$_POST['contact']."',`circle`='".$_POST['circle']."' where `id`=".$id;
	//echo $sql;
	if($pdo->exec($sql)){
		foreach($attribute_sql as $v){
			$pdo->exec($v);
		}
		
		$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
		$new_imgs=get_match_all($reg,$_POST['content']);
		//var_dump($new_articles);
		$old_imgs=get_match_all($reg,$old['content']);
		$imgs=array();
		foreach($new_imgs as $v){
			if(!in_array($v,$old_imgs)){$imgs[]=$v;}
		}
		foreach($old_imgs as $v){
			if(!in_array($v,$new_imgs)){
				$sql="select `id` from ".self::$table_pre."content where `content` like '%".$v."%' limit 0,1";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['id']==''){
					$path=$v;
					@safe_unlink($path);
					reg_attachd_img("del",self::$config['class_name'],$path,$pdo);
				}
			}	
		}
		if(count($imgs)>0){reg_attachd_img("add",self::$config['class_name'],$imgs,$pdo,self::$config['program']['imageMark']);}


		if($_COOKIE['monxin_device']=='pc'){
			exit("{'state':'success','info':'<span class=success>".self::$language['release'].self::$language['success']." &nbsp; &nbsp; &nbsp; &nbsp; <a href=./index.php?monxin=ci.detail&id=".$id.">".self::$language['view'].self::$language['info']."</a> &nbsp; &nbsp; &nbsp; &nbsp; <a href=./index.php?monxin=ci.my_info>".self::$language['manage_my_info']."</a> &nbsp; &nbsp; &nbsp; &nbsp; <a href=./index.php?monxin=ci.top&id=".$id." class=set>".self::$language['top_the_info']."</a></span>'}");	
		}else{
			exit("{'state':'success','info':'<span class=success>".self::$language['release'].self::$language['success']."<br /><a href=./index.php?monxin=ci.detail&id=".$id.">".self::$language['view'].self::$language['info']."</a><br /><a href=./index.php?monxin=ci.my_info>".self::$language['manage_my_info']."</a><br /><a href=./index.php?monxin=ci.top&id=".$id." class=set>".self::$language['top_the_info']."</a></span>'}");	
		}
				
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
		
		
}
