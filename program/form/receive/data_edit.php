<?php
$table_id=intval(@$_GET['table_id']);
if($table_id==0){exit('table_id err');}
$id=intval(@$_GET['id']);
if($id==0){exit('id err');}

$act=@$_GET['act'];
if($act=='update'){
	$sql="select `name`,`description`,`edit_power` from ".self::$table_pre."table where `id`=".$table_id;
	$r=$pdo->query($sql,2)->fetch(2);
	$table_name=$r['name'];
	if($table_name==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." table does not exist</span>'}");}
	$table_edit_power=explode('|',$r['edit_power']);
	//if(!in_array('0',$table_edit_power)){
		if(!in_array($_SESSION['monxin']['group_id'],$table_edit_power)){exit("{'state':'fail','info':'<span class=fail>".self::$language['without'].self::$language['edit'].self::$language['power']."</span>'}");}	
	//}
	$sql="select * from ".self::$table_pre.$table_name." where `id`=".$id;
	$module['data']=$pdo->query($sql,2)->fetch(2);
	if($module['data']['id']==''){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	$default_publish=$module['data']['publish'];
	$sql="select * from ".self::$table_pre."field where `table_id`=$table_id order by `sequence` desc,`id` asc";
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
		if($v['unique']  && $v['required']){
			$sql="select count(id) as c from ".self::$table_pre.$table_name." where `".$v['name']."`='".$_POST[$v['name']]."' and `id`!=".$id;
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
			$old_imgs=get_match_all($reg,de_safe_str($module['data'][$v['name']]));
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
					@safe_unlink('./program/form/img_thumb/'.$module['data'][$v['name']]);
					@safe_unlink('./program/form/img/'.$module['data'][$v['name']]);
				}
			}else{
				$_POST[$v['name']]=$module['data'][$v['name']];	
			}	
		}
		//==================================================================================================imgs
		if($v['input_type']=='imgs'){
			if($_POST[$v['name']]!=''){
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
			$_POST[$v['name']].=$_POST[$v['name'].'_old_value'];
			
			$temp=explode('|',$module['data'][$v['name']]);
			$temp=array_filter($temp);
			$temp2=explode('|',$_POST[$v['name'].'_old_value']);
			$temp2=array_filter($temp2);
			foreach($temp as $v2){
				if(!in_array($v2,$temp2)){
					@safe_unlink('./program/form/imgs_thumb/'.$v2);
					@safe_unlink('./program/form/imgs/'.$v2);
				}
			}
			
		}
		//==================================================================================================file
		if($v['input_type']=='file'){
			if($_POST[$v['name']]!=''){
				if(file_exists('./temp/'.$_POST[$v['name']])){
					$path='./program/form/file/'.safe_path($_POST[$v['name']]);
					get_date_dir('./program/form/file/');
					if(safe_rename('./temp/'.safe_path($_POST[$v['name']]),$path)==false){
						exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>','id':'".$v['name']."'}");
					}
					@safe_unlink('./program/form/file/'.$module['data'][$v['name']]);
				}
			}else{
				$_POST[$v['name']]=$module['data'][$v['name']];	
			}	
		}
		//==================================================================================================files
		if($v['input_type']=='files'){
			if($_POST[$v['name']]!=''){
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
			$_POST[$v['name']].=$_POST[$v['name'].'_old_value'];
			
			$temp=explode('|',$module['data'][$v['name']]);
			$temp=array_filter($temp);
			$temp2=explode('|',$_POST[$v['name'].'_old_value']);
			$temp2=array_filter($temp2);
			foreach($temp as $v2){
				if(!in_array($v2,$temp2)){
					//echo $v2;
					@safe_unlink('./program/form/files/'.$v2);
				}
			}
			
		}












		
		$_POST[$v['name']]=safe_str(@$_POST[$v['name']]);
		$fields.="`".$v['name']."`='".$_POST[$v['name']]."',";
	}
	$fields=trim($fields,',');
	$values=trim($values,',');
	$edit_time=time();
	$editor=(isset($_SESSION['monxin']['id']))?$_SESSION['monxin']['id']:0;
	
	$sql="update ".self::$table_pre.$table_name." set  ".$fields.",`edit_time`='".$edit_time."',`editor`='".$editor."' where `id`=".$id;

	//echo $sql;
	if($pdo->exec($sql)){
		if($default_publish){$view='<a href="./index.php?monxin=form.data_show_detail&table_id='.$table_id.'&id='.$id.'" class="view">'.self::$language['view'].'</a>';}else{$view='';}
		exit("{'state':'success','info':'<span class=success>".self::$language['submit'].self::$language['success']." ".$view.' <a href="./index.php?monxin=form.data_edit&table_id='.$table_id.'&id='.$id.'" class="edit">'.self::$language['continue'].self::$language['edit'].'</a>'."</span>'}");			
		
				
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
		
		
}
