<?php
$act=@$_GET['act'];

if($act=='add'){
		$time=time();
		$_POST['type']=intval(@$_POST['type']);
		$_POST['v']=safe_str(@$_POST['v']);
		if($_POST['type']>0 && $_POST['v']!=''){
			$_POST['v']=explode('|',$_POST['v']);
			$_POST['v']=array_filter($_POST['v']);
			$image=new image();
			$success_list='';
			$thumb_width=(intval(@$_POST['thumb_width'])>0)?$_POST['thumb_width']:self::$config['program']['thumb_width'];
			$thumb_height=(intval(@$_POST['thumb_height'])>0)?$_POST['thumb_height']:self::$config['program']['thumb_height'];
			
			foreach($_POST['v'] as $v){
				$path='./program/image/img/'.$v;
				if(file_exists($path)){
					get_date_dir('./program/image/img_thumb/');
					compress_img('./program/image/img/'.$v,800);
					$image->thumb('./program/image/img/'.$v,'./program/image/img_thumb/'.$v,$thumb_width,$thumb_height);
					if($_POST['image_mark']){
						$image->addMark($path);
					}
					$sql="insert into ".self::$table_pre."img (`type`,`src`,`editor`,`time`) values ('".$_POST['type']."','".$v."','".$_SESSION['monxin']['id']."','$time')";	
					//echo $sql;
					if($pdo->exec($sql)){
						$success_list.=$v.',';	
					}else{
						@safe_unlink("./program/image/img_thumb/".$v);	
						@safe_unlink($path);	
					}
				}	
			}
			
			
			if($success_list!=''){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}

		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");
		}	
	
}