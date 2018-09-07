<?php
$table_id=intval(@$_GET['table_id']);
if($table_id==0){exit('table_id err');}

$act=@$_GET['act'];
if($act=='add'){
	$sql="select `name`,`description`,`add_power`,`default_publish`,`write_state`,`read_state`,`sms_inform`,`email_inform`,`inform_user`,`authcode` from ".self::$table_pre."table where `id`=".$table_id;
	$r=$pdo->query($sql,2)->fetch(2);
	$table_name=$r['name'];
	$table_description=$r['description'];
	if($table_name==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." table does not exist</span>'}");}
	if($r['write_state']==0){exit("{'state':'fail','info':'<span class=fail>".$r['description'].self::$language['program_state']['closed']."</span>'}");}
	$table_add_power=explode('|',$r['add_power']);
	if(!in_array('0',$table_add_power)){
		if(!isset($_SESSION['monxin']['group_id'])){$_SESSION['monxin']['group_id']='0';}
		if(!in_array($_SESSION['monxin']['group_id'],$table_add_power)){exit("{'state':'fail','info':'<span class=fail>".self::$language['without'].self::$language['add'].self::$language['power']."</span>'}");}	
	}
	
	$read_state=$r['read_state'];
	$default_publish=$r['default_publish'];
	$sms_inform=$r['sms_inform'];
	$email_inform=$r['email_inform'];
	$inform_user=$r['inform_user'];
	$authcode=$r['authcode'];
	if($authcode){
		if(strtolower($_POST['authcode'])!=strtolower($_SESSION["authCode"])){
			exit("{'state':'fail','info':'<span class=fail>".self::$language['authcode_err']."</span>','id':'authcode'}");	
		}
	}
	$sql="select * from ".self::$table_pre."field where `table_id`=$table_id and `write_able`=1 order by `sequence` desc,`id` asc";
	$r=$pdo->query($sql,2);
	$fields='';
	$values='';
	foreach($r as $v){
		if(in_array($v['name'],self::$config['sys_field'])){continue;}
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
			$sql="select count(id) as c from ".self::$table_pre.$table_name." where `".$v['name']."`='".$_POST[$v['name']]."'";
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
				$path='./program/form/img/'.safe_path($_POST[$v['name']]);
				get_date_dir('./program/form/img/');
				get_date_dir('./program/form/img_thumb/');
				if(safe_rename('./temp/'.safe_path($_POST[$v['name']]),$path)==false){
					exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>','id':'".$v['name']."'}");
				}
				$image=new image();
				if(intval($args['img_width'])>0 && intval($args['img_height'])>0){
					$image->thumb($path,'./program/form/img_thumb/'.$_POST[$v['name']],intval($args['img_width']),intval($args['img_height']));
				}
				if($args['img_open_image_mark']){$image->addMark($path);}
				
			}else{
				$_POST[$v['name']]='';	
			}	
		}
		//==================================================================================================imgs
		if($v['input_type']=='imgs' && $_POST[$v['name']]!=''){
			get_date_dir('./program/form/imgs/');
			get_date_dir('./program/form/imgs_thumb/');
			$temp2='';
			$temp=explode('|',$_POST[$v['name']]);
			$temp=array_filter($temp);
			$image=new image();
			foreach($temp as $v2){
				if(file_exists('./temp/'.$v2)){
					$path='./program/form/imgs/'.safe_path($v2);
					if(safe_rename('./temp/'.safe_path($v2),$path)==false){continue;}
					if(intval($args['imgs_width'])>0 && intval($args['imgs_height'])>0){
						$image->thumb($path,'./program/form/imgs_thumb/'.$v2,intval($args['imgs_width']),intval($args['imgs_height']));
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
				$path='./program/form/file/'.safe_path($_POST[$v['name']]);
				get_date_dir('./program/form/file/');
				if(safe_rename('./temp/'.safe_path($_POST[$v['name']]),$path)==false){
					exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>','id':'".$v['name']."'}");
				}				
			}else{
				$_POST[$v['name']]='';	
			}	
		}
		//==================================================================================================files
		if($v['input_type']=='files' && $_POST[$v['name']]!=''){
			get_date_dir('./program/form/files/');
			$temp2='';
			$temp=explode('|',$_POST[$v['name']]);
			$temp=array_filter($temp);
			foreach($temp as $v2){
				if(file_exists('./temp/'.$v2)){
					$path='./program/form/files/'.safe_path($v2);
					if(safe_rename('./temp/'.safe_path($v2),$path)==false){continue;}
					$temp2.='|'.$v2;
				}	
			}
			$_POST[$v['name']]=$temp2;
		}
		
		$_POST[$v['name']]=safe_str(@$_POST[$v['name']],1,0);
		$fields.='`'.$v['name'].'`,';
		$values.="'".$_POST[$v['name']]."',";
	}
	$fields=trim($fields,',');
	$values=trim($values,',');
	$write_time=time();
	$writer=(isset($_SESSION['monxin']['id']))?$_SESSION['monxin']['id']:0;
	
	$sql="insert into ".self::$table_pre.$table_name." (".$fields.",`write_time`,`writer`,`publish`) values (".$values.",'".$write_time."','".$writer."','".$default_publish."')";

	//echo $sql;
	if($pdo->exec($sql)){
		$id=$pdo->lastInsertId();
		if($inform_user!='' && ($sms_inform==1 || $email_inform==1)){
			$sql="select `email`,`phone` from ".$pdo->index_pre."user where `username`='".$inform_user."'";
			$r2=$pdo->query($sql,2)->fetch(2);
			
			if($default_publish && $read_state){
				$url='http://'.self::$config['web']['domain'].'/index.php?monxin=form.data_show_detail&table_id='.$table_id.'&id='.$id;
			}else{
				$url='http://'.self::$config['web']['domain'].'/index.php?monxin=form.data_edit&table_id='.$table_id.'&id='.$id;
			}
			
			if($r2['email']!='' && $email_inform==1){
				$e_title=$_SERVER['HTTP_HOST'].'('.self::$config['web']['name'].') '.$table_description.' '.self::$language['receive_new_information'];
				$e_content=self::$language['view'].self::$language['url'].': '.$url;
				email(self::$config,self::$language,$pdo,'monxin',$r2['email'],$e_title,$e_content);	
			}
			if($r2['phone']!='' && $sms_inform==1){
				$e_title=$_SERVER['HTTP_HOST'].'('.self::$config['web']['name'].') '.$table_description.' '.self::$language['receive_new_information'];
				$content=$e_title.' '.self::$language['view'].self::$language['url'].': '.$url;
				sms(self::$config,self::$language,$pdo,'monxin',$r2['phone'],$content);
			}
		}		
		if($default_publish){$view='<a href="./index.php?monxin=form.data_show_detail&table_id='.$table_id.'&id='.$id.'" class="view">'.self::$language['view'].'</a>';}else{$view='';}
		exit("{'state':'success','info':'<span class=success>".self::$language['submit'].self::$language['success']." ".$view.' <a href="./index.php?monxin=form.data_add&table_id='.$table_id.'" class="return_button">'.self::$language['return'].'</a>'."</span>'}");			
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
		
		
}
