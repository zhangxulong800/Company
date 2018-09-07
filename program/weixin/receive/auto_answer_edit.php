<?php
$time=time();
$wid=safe_str(@$_GET['wid']);
$type=safe_str(@$_GET['type']);
//echo $wid;
if(!$this->check_wid_power($pdo,self::$table_pre)){exit("{'state':'fail','info':'<span class=fail>".self::$language['act_noPower']."</span>'}");}
$key=safe_str(@$_POST['key']);
if($key==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'key'}");}

$id=intval(@$_GET['id']);

$sql="select count(id) as c from ".self::$table_pre."auto_answer where `wid`='".$wid."' and `key`='".$key."' and `id`!='".$id."'";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist_same']."</span>','id':'key'}");}

$sql="select * from ".self::$table_pre."auto_answer where `id`='".$id."' and `wid`='".$wid."'";
$r=$pdo->query($sql,2)->fetch(2);
if($r['author']=='monxin'){$key=$r['key'];}

switch($type){
	case 'text':
		$v=safe_str(@$_POST['text']);
		if($v==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'text'}");}
		$sql="update ".self::$table_pre."auto_answer set `key`='".$key."',`input_type`='".$type."',`output_type`='text',`time`='".$time."',`".$type."`='".$v."' where `id`='".$id."' and `wid`='".$wid."'";
		break;	
	case 'image':
		$v=safe_str(@$_POST['image']);
		if($v!=''){
			if(!is_file('./temp/'.$v)){exit("{'state':'fail','info':'<span class=fail>".self::$language['upload'].self::$language['fail']."</span>','id':'image'}");}
			get_date_dir('./program/weixin/image/');	
			get_date_dir('./program/weixin/image_thumb/');
			$path='./program/weixin/image/'.$v;
			if(safe_rename('./temp/'.$v,$path)==false){
				exit("{'state':'fail','info':'<span class=fail>".self::$language['upload'].self::$language['fail']."</span>','id':'image'}");
			}
			$image=new image();
			$image->thumb($path,'./program/weixin/image_thumb/'.$v,self::$config['rectangle_thumb']['width'],self::$config['rectangle_thumb']['height']);	
			if(self::$config['program']['imageMark']){$image->addMark($path);}
			$sql="update ".self::$table_pre."auto_answer set `key`='".$key."',`input_type`='".$type."',`output_type`='news',`time`='".$time."',`".$type."`='".$v."' where `id`='".$id."' and `wid`='".$wid."'";
		}else{
			$sql="update ".self::$table_pre."auto_answer set `key`='".$key."',`input_type`='".$type."',`output_type`='news',`time`='".$time."' where `id`='".$id."' and `wid`='".$wid."'";	
		}
		break;	
	case 'voice':
		$v=trim(safe_str(@$_POST['voice']),'|');
		if($v!=''){
			if(!is_file('./temp/'.$v)){exit("{'state':'fail','info':'<span class=fail>".self::$language['upload'].self::$language['fail']."</span>','id':'voice'}");}
			get_date_dir('./program/weixin/voice/');	
			$path='./program/weixin/voice/'.$v;
			if(safe_rename('./temp/'.$v,$path)==false){
				exit("{'state':'fail','info':'<span class=fail>".self::$language['upload'].self::$language['fail']."</span>','id':'voice'}");
			}
			$sql="update ".self::$table_pre."auto_answer set `key`='".$key."',`input_type`='".$type."',`output_type`='news',`time`='".$time."',`".$type."`='".$v."' where `id`='".$id."' and `wid`='".$wid."'";
		}else{
			$sql="update ".self::$table_pre."auto_answer set `key`='".$key."',`input_type`='".$type."',`output_type`='news',`time`='".$time."' where `id`='".$id."' and `wid`='".$wid."'";	
		}
		break;	
	case 'video':
		//echo $type;
		$v=trim(safe_str(@$_POST['video']),'|');
		if($v!=''){
			if(!is_file('./temp/'.$v)){exit("{'state':'fail','info':'<span class=fail>".self::$language['upload'].self::$language['fail']."</span>','id':'video'}");}
			get_date_dir('./program/weixin/video/');	
			$path='./program/weixin/video/'.$v;
			if(safe_rename('./temp/'.$v,$path)==false){
				exit("{'state':'fail','info':'<span class=fail>".self::$language['upload'].self::$language['fail']."</span>','id':'video'}");
			}
			$sql="update ".self::$table_pre."auto_answer set `key`='".$key."',`input_type`='".$type."',`output_type`='news',`time`='".$time."',`".$type."`='".$v."' where `id`='".$id."' and `wid`='".$wid."'";
		}else{
			$sql="update ".self::$table_pre."auto_answer set `key`='".$key."',`input_type`='".$type."',`output_type`='news',`time`='".$time."' where `id`='".$id."' and `wid`='".$wid."'";	
		}
		break;	
	case 'single_news':
		$_POST=safe_str($_POST);
		if(@$_POST['url']!=''){if(!is_url($_POST['url'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['pattern_err']."</span>','id':'url'}");}}
		$img=safe_str(@$_POST['img']);
		if($img!=''){
			if(!is_file('./temp/'.$img)){exit("{'state':'fail','info':'<span class=fail>".self::$language['upload'].self::$language['fail']."</span>','id':'img'}");}
			get_date_dir('./program/weixin/image/');	
			get_date_dir('./program/weixin/image_thumb/');
			$path='./program/weixin/image/'.$img;
			if(safe_rename('./temp/'.$img,$path)==false){
				exit("{'state':'fail','info':'<span class=fail>".self::$language['upload'].self::$language['fail']."</span>','id':'img'}");
			}
			$image=new image();
			$image->thumb($path,'./program/weixin/image_thumb/'.$img,self::$config['rectangle_thumb']['width'],self::$config['rectangle_thumb']['height']);	
			if(self::$config['program']['imageMark']){$image->addMark($path);}
		}else{
			$sql="select count(id) as c from ".self::$table_pre."single_news where `key_id`=".$id;
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['c']==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'img'}");}	
		}
		$sql="update ".self::$table_pre."auto_answer set `key`='".$key."',`input_type`='".$type."',`output_type`='news',`time`='".$time."' where `id`='".$id."' and `wid`='".$wid."'";	

		break;	
	case 'news':
		$sql="update ".self::$table_pre."auto_answer set `key`='".$key."',`input_type`='".$type."',`output_type`='news',`time`='".$time."' where `id`='".$id."' and `wid`='".$wid."'";	
		break;	
	case 'function':
		$v=safe_str(@$_POST['function_v']);
		if($v==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'function'}");}
		$sql="update ".self::$table_pre."auto_answer set `key`='".$key."',`input_type`='".$type."',`output_type`='news',`time`='".$time."',`".$type."`='".$v."' where `id`='".$id."' and `wid`='".$wid."'";
		break;	
		
}

if($pdo->exec($sql)){
	switch($type){
		case 'image':
			if($v!=''){
				@safe_unlink('./program/weixin/image/'.$r['image']);
				@safe_unlink('./program/weixin/image_thumb/'.$r['image']);
			}
			break;
		case 'voice':
			if($v!=''){
				@safe_unlink('./program/weixin/voice/'.$r['voice']);
			}
			break;
		case 'video':
			if($v!=''){
				@safe_unlink('./program/weixin/video/'.$r['video']);
			}
			break;
		case 'single_news':
			$sql="select count(id) as c from ".self::$table_pre."single_news where `key_id`=".$id;
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['c']==0){
				$sql="insert into ".self::$table_pre."single_news (`key_id`,`title`,`img`,`description`,`url`) values ('".$id."','".$_POST['title']."','".$_POST['img']."','".$_POST['description']."','".$_POST['url']."')";
				if(!$pdo->exec($sql)){exit("{'state':'fail','info':'<span class=fail>inset single_news ".self::$language['fail']."</span>'}");}
			}else{
				$sql="select `img` from ".self::$table_pre."single_news where `key_id`=".$id;
				$r=$pdo->query($sql,2)->fetch(2);
				if($_POST['img']!=''){
					@safe_unlink('./program/weixin/image/'.$r['img']);
					@safe_unlink('./program/weixin/image_thumb/'.$r['img']);
				}else{
					$_POST['img']=$r['img'];
				}
				$sql="update ".self::$table_pre."single_news set `img`='".$_POST['img']."',`title`='".$_POST['title']."',`description`='".$_POST['description']."',`url`='".$_POST['url']."' where `key_id`=".$id;
				$pdo->exec($sql);
			}
			
			
			
			break;
	case 'news':
		get_date_dir('./program/weixin/image/');	
		get_date_dir('./program/weixin/image_thumb/');
		$_POST=safe_str($_POST);
		//var_dump($_POST);
		$image=new image();
		$submit_ids=array();
		foreach($_POST as $k=>$v){
			if($k==='key'){continue;}
			$submit_ids[]=$v['id'];
			if($_POST[$k]['img']=='' && $_POST[$k]['title']=='' && $_POST[$k]['url']==''){continue;}
			//echo 'img='.$_POST[$k]['img'].',url='.$_POST[$k]['url']."\r\n";

			if($v['img']!=''){
				if(is_file('./temp/'.$v['img'])){
					$path='./program/weixin/image/'.$v['img'];
					if(safe_rename('./temp/'.$v['img'],$path)){
						$image->thumb($path,'./program/weixin/image_thumb/'.$v['img'],self::$config['square_thumb']['width'],self::$config['square_thumb']['height'],false);	
						$image->thumb($path,$path,self::$config['rectangle_thumb']['width'],self::$config['rectangle_thumb']['height'],false);	
					}else{
						$v['img']='';	
					}
				}	
			}
			if(!is_url($v['url'])){$v['url']='';}
			if($v['id']==0){
				$sql="insert into ".self::$table_pre."news (`key_id`,`img`,`title`,`sequence`,`url`) values ('".$id."','".$v['img']."','".$v['title']."','".intval($v['sequence'])."','".$v['url']."')";
				$pdo->exec($sql);
				$submit_ids[]=$pdo->lastInsertId();
			}else{
				$sql="select `img` from ".self::$table_pre."news where `id`='".$v['id']."' and `key_id`='".$id."'";
				$r=$pdo->query($sql,2)->fetch(2);
				if($v['img']==''){
					$img=$r['img'];
				}else{
					$img=$v['img'];	
				}
				$sql="update ".self::$table_pre."news set `img`='".$img."',`title`='".$v['title']."',`sequence`='".intval($v['sequence'])."',`url`='".$v['url']."' where `id`='".$v['id']."' and `key_id`=".$id;
				//echo $sql;
				if($pdo->exec($sql)){
					if($r['img']!='' && $v['img']!=''){
						@safe_unlink('./program/weixin/image/'.$r['img']);
						@safe_unlink('./program/weixin/image_thumb/'.$r['img']);
					}
				}	
			}
			
		}
		$sql="select `id`,`img` from ".self::$table_pre."news where `key_id`=".$id;
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			if(!in_array($v['id'],$submit_ids)){
				$sql="delete from ".self::$table_pre."news where `id`=".$v['id'];
				if($pdo->exec($sql)){
					if($v['img']!=''){
						@safe_unlink('./program/weixin/image/'.$v['img']);
						@safe_unlink('./program/weixin/image_thumb/'.$v['img']);
					}	
				}	
			}	
		}		
		break;	
			
	}
	
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
}else{
	//echo $sql;
	exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
}

	
