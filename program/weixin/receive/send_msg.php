<?php
$time=time();
$wid=safe_str(@$_GET['wid']);
$openid=safe_str(@$_GET['openid']);
$type=safe_str(@$_GET['type']);
//echo $wid;
if(!$this->check_wid_power($pdo,self::$table_pre)){exit("{'state':'fail','info':'<span class=fail>".self::$language['act_noPower']."</span>'}");}
if($openid==''){exit("{'state':'fail','info':'<span class=fail>openid ".self::$language['is_null']."</span>','id':'key'}");}



switch($type){
	case 'text':
		$v=safe_str(@$_POST['text']);
		if($v==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'text'}");}
		$v=self::weixin_text_to_json($v,$openid);
		$sql="insert into ".self::$table_pre."dialog (`wid`,`from`,`to`,`type`,`time`,`content`,`input_type`) values ('".$wid."','".$wid."','".$openid."','text','".$time."','".$v."','".$type."')";
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
		$data['picurl']=get_monxin_path().'program/weixin/image_thumb/'.$v;
		$data['url']=get_monxin_path().'program/weixin/image/'.$v.'?openid='.$openid;
		$v=self::weixin_image_to_json($data,$openid);
		$sql="insert into ".self::$table_pre."dialog (`wid`,`from`,`to`,`type`,`time`,`content`,`input_type`) values ('".$wid."','".$wid."','".$openid."','news','".$time."','".$v."','".$type."')";
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
		$data['picurl']=get_monxin_path().'program/weixin/img/voice.png';
		$data['url']=get_monxin_path().'index.php?monxin=weixin.index&show=dialog&type=voice&path='.$v.'&openid='.$openid;
		$v=self::weixin_voice_to_json($data,$openid);		
		$sql="insert into ".self::$table_pre."dialog (`wid`,`from`,`to`,`type`,`time`,`content`,`input_type`) values ('".$wid."','".$wid."','".$openid."','news','".$time."','".$v."','".$type."')";
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
		$data['picurl']=get_monxin_path().'program/weixin/img/video.png';
		$data['url']=get_monxin_path().'index.php?monxin=weixin.index&show=dialog&type=video&path='.$v.'&openid='.$openid;
		$v=self::weixin_voice_to_json($data,$openid);		
		$sql="insert into ".self::$table_pre."dialog (`wid`,`from`,`to`,`type`,`time`,`content`,`input_type`) values ('".$wid."','".$wid."','".$openid."','news','".$time."','".$v."','".$type."')";
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
		$data['title']=$_POST['title'];
		$data['description']=$_POST['description'];
		$data['url']=str_replace('openid=v','openid='.$openid,$_POST['url']);
		$data['picurl']=get_monxin_path().'program/weixin/image_thumb/'.$img;
		$v=self::weixin_single_news_to_json($data,$openid);		
		
		$sql="insert into ".self::$table_pre."dialog (`wid`,`from`,`to`,`type`,`time`,`content`,`input_type`) values ('".$wid."','".$wid."','".$openid."','news','".$time."','".$v."','".$type."')";
		break;	
	case 'news':
		$v='news';
		$sql="insert into ".self::$table_pre."dialog (`wid`,`from`,`to`,`type`,`time`,`content`,`input_type`) values ('".$wid."','".$wid."','".$openid."','news','".$time."','".$v."','".$type."')";
		break;	
	case 'function':
		$v=safe_str(@$_POST['function_v']);
		if($v==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'function'}");}
		$sql="insert into ".self::$table_pre."dialog (`wid`,`from`,`to`,`type`,`time`,`content`,`input_type`) values ('".$wid."','".$wid."','".$openid."','news','".$time."','".$v."','".$type."')";
		break;	
		
		
}


if($pdo->exec($sql)){
	$dialog_id=$pdo->lastInsertId();
	switch($type){
		case 'function':
			$v=self::call_function($pdo,self::$table_pre,self::$language,$v,'json',$openid);			
			$sql="update ".self::$table_pre."dialog set `content`='".$v['data']."',`input_type`='".$v['input_type']."' where `id`=".$dialog_id;
			$pdo->exec($sql);
			$v=$v['data'];
			break;
		case 'news':
			get_date_dir('./program/weixin/image/');	
			get_date_dir('./program/weixin/image_thumb/');
			$_POST=safe_str($_POST);
			//var_dump($_POST);
			$image=new image();
			$data=array();
			$i=0;
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
				if($v['img']!=''){
					if($i==0){
						$data[$i]['picurl']=get_monxin_path().'program/weixin/image/'.$v['img'];
					}else{
						$data[$i]['picurl']=get_monxin_path().'program/weixin/image_thumb/'.$v['img'];
					}
				}else{
					$data[$i]['picurl']='';
				}
				$data[$i]['title']=$v['title'];
				$data[$i]['url']=$v['url'];
				$i++;
			}
			$v=self::weixin_news_to_json($data,$openid);		
			$sql="update ".self::$table_pre."dialog set `content`='".$v."' where `id`=".$dialog_id;
			$pdo->exec($sql);
			break;	
			
	}
	$r=self::weixin_send_msg($pdo,self::$table_pre,$wid,$v);
	if($r!==true){reset_weixin_info($wid,$pdo);$r=self::weixin_send_msg($pdo,self::$table_pre,$wid,$v);}
	if($r!==true){exit("{'state':'fail','info':'<span class=fail>".$r."</span>'}");}
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
}else{
	//echo $sql;
	exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
}

	
