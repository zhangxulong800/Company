<?php
$time=time();
$wid=safe_str(@$_GET['wid']);
$type=safe_str(@$_GET['type']);
//echo $wid;
if(!$this->check_wid_power($pdo,self::$table_pre)){exit("{'state':'fail','info':'<span class=fail>".self::$language['act_noPower']."</span>'}");}
$key=safe_str(@$_POST['key']);
if($key==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'key'}");}

$sql="select count(id) as c from ".self::$table_pre."auto_answer where `wid`='".$wid."' and `key`='".$key."'";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist_same']."</span>','id':'key'}");}


switch($type){
	case 'text':
		$v=safe_str(@$_POST['text']);
		if($v==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'text'}");}
		$sql="insert into ".self::$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`".$type."`,`author`) values ('".$wid."','".$key."','".$type."','text','".$time."','".$v."','".$_SESSION['monxin']['username']."')";
		break;	
	case 'image':
		$v=safe_str(@$_POST['image']);
		if($v==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'image'}");}
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
		$sql="insert into ".self::$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`".$type."`,`author`) values ('".$wid."','".$key."','".$type."','news','".$time."','".$v."','".$_SESSION['monxin']['username']."')";
		break;	
	case 'voice':
		$v=trim(safe_str(@$_POST['voice']),'|');
		if($v==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'voice'}");}
		if(!is_file('./temp/'.$v)){exit("{'state':'fail','info':'<span class=fail>".self::$language['upload'].self::$language['fail']."</span>','id':'voice'}");}
		get_date_dir('./program/weixin/voice/');	
		$path='./program/weixin/voice/'.$v;
		if(safe_rename('./temp/'.$v,$path)==false){
			exit("{'state':'fail','info':'<span class=fail>".self::$language['upload'].self::$language['fail']."</span>','id':'voice'}");
		}
		$sql="insert into ".self::$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`".$type."`,`author`) values ('".$wid."','".$key."','".$type."','news','".$time."','".$v."','".$_SESSION['monxin']['username']."')";
		break;	
	case 'video':
		$v=trim(safe_str(@$_POST['video']),'|');
		if($v==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'video'}");}
		if(!is_file('./temp/'.$v)){exit("{'state':'fail','info':'<span class=fail>".self::$language['upload'].self::$language['fail']."</span>','id':'video'}");}
		get_date_dir('./program/weixin/video/');	
		$path='./program/weixin/video/'.$v;
		if(safe_rename('./temp/'.$v,$path)==false){
			exit("{'state':'fail','info':'<span class=fail>".self::$language['upload'].self::$language['fail']."</span>','id':'video'}");
		}
		$sql="insert into ".self::$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`".$type."`,`author`) values ('".$wid."','".$key."','".$type."','news','".$time."','".$v."','".$_SESSION['monxin']['username']."')";
		break;	
	case 'single_news':
		$_POST=safe_str($_POST);
		if(@$_POST['url']!=''){if(!is_url($_POST['url'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['pattern_err']."</span>','id':'url'}");}}

		$img=safe_str(@$_POST['img']);
		if($img==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'img'}");}
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
		$sql="insert into ".self::$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`author`) values ('".$wid."','".$key."','".$type."','news','".$time."','".$_SESSION['monxin']['username']."')";
		break;	
	case 'news':
		$sql="insert into ".self::$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`author`) values ('".$wid."','".$key."','".$type."','news','".$time."','".$_SESSION['monxin']['username']."')";
		break;	
	case 'function':
		$v=safe_str(@$_POST['function_v']);
		if($v==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'function'}");}
		$sql="insert into ".self::$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`".$type."`,`author`) values ('".$wid."','".$key."','".$type."','news','".$time."','".$v."','".$_SESSION['monxin']['username']."')";
		break;	
		

}

if($pdo->exec($sql)){
	$key_id=$pdo->lastInsertId();
	switch($type){
		case 'single_news':
			$sql="insert into ".self::$table_pre."single_news (`key_id`,`title`,`img`,`description`,`url`) values ('".$key_id."','".$_POST['title']."','".$_POST['img']."','".$_POST['description']."','".$_POST['url']."')";
			if(!$pdo->exec($sql)){exit("{'state':'fail','info':'<span class=fail>inset single_news ".self::$language['fail']."</span>'}");}
			
			break;
	case 'news':
		get_date_dir('./program/weixin/image/');	
		get_date_dir('./program/weixin/image_thumb/');
		$_POST=safe_str($_POST);
		//var_dump($_POST);
		$image=new image();
		foreach($_POST as $k=>$v){
			if($k==='key'){continue;}
			//$temp.='img='.$_POST[$k]['img'].',url='.$_POST[$k]['url']."\r\n";
			if($_POST[$k]['img']=='' && $_POST[$k]['title']==''){continue;}
			if($v['img']!=''){
				if(is_file('./temp/'.$v['img'])){
					$path='./program/weixin/image/'.$v['img'];
					if(safe_rename('./temp/'.$v['img'],$path)){
						$image->thumb($path,'./program/weixin/image_thumb/'.$v['img'],self::$config['square_thumb']['width'],self::$config['square_thumb']['height'],false);	
						$image->thumb($path,$path,self::$config['rectangle_thumb']['width'],self::$config['rectangle_thumb']['height'],false);	
						//if(self::$config['program']['imageMark']){$image->addMark($path);}
					}else{
						$v['img']='';	
					}
				}	
			}
			if(!is_url($v['url'])){$v['url']='';}
			$sql="insert into ".self::$table_pre."news (`key_id`,`img`,`title`,`sequence`,`url`) values ('".$key_id."','".$v['img']."','".$v['title']."','".intval($v['sequence'])."','".$v['url']."')";
			$pdo->exec($sql); 
			
		}
		break;	
			
	}
	
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
}else{
	//echo $sql;
	exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
}

	
