<?php
$table_id=intval(@$_GET['table_id']);
if($table_id==0){exit("{'state':'fail','info':'<span class=fail>table_id err</span>'}");}

$sql="select `name`,`description` from ".self::$table_pre."table where `id`=$table_id";
$r=$pdo->query($sql,2)->fetch(2);
$table_name=$r['name'];
$table_description=$r['description'];


$act=@$_GET['act'];

if($act=='export'){
	  if($_POST['field']==''){exit('field is null');}
	  $field=explode('|',trim($_POST['field'],'|'));
	  
	  //======================================================get thead
	  $sql="select `name`,`description` from ".self::$table_pre."table where `id`=$table_id";
	  $r=$pdo->query($sql,2)->fetch(2);
	  $table_name=$r['name'];	  
	  $sql="select `name`,`description`,`input_type` from ".self::$table_pre."field where `table_id`=$table_id order by `sequence` desc,`id` asc";
	  $r=$pdo->query($sql,2);
	  $temp='';	 
	  $input_type=array(); 
	  foreach($r as $v){
		  $input_type[$v['name']]=$v['input_type'];
		  if(in_array($v['name'],$field)){$temp.=$v['description'].','; }
	  }
	  $list=trim($temp,',')."\r\n";		
	  
	  $fields='';
	  foreach($field as $v){$fields.='`'.$v.'`,';}
	  $fields=rtrim($fields,',');
	  $sql="select ".$fields." from ".self::$table_pre.$table_name;
	  if(isset($_POST['where'])){
			if($_POST['where']!=''){
				$sql.=$_POST['where'];
				$sql=str_replace($table_name.' and',$table_name.' where',$sql);
			}  
	  }
	  
	  //var_dump($input_type);
	  //echo $sql;
	  $r=$pdo->query($sql,2);
	  foreach($r as $v){
		  $temp='';
		  foreach($field as $k){
			  if($input_type[$k]=='time' || $k=='write_time' || $k=='edit_time'){$v[$k]=date('Y-m-d H:i',$v[$k]);}
			  if($input_type[$k]=='area'){$v[$k]=get_area_name($pdo,$v[$k]);}
			  $temp.=str_replace(',',' ',$v[$k])."\t,";
		  }
		  $list.=rtrim($temp,',')."\r\n";	;
		  	
	  }
	  
	  $list=iconv("UTF-8",self::$config['other']['export_csv_charset'].'//IGNORE',$list);
	  //$list=mb_convert_encoding($list,"UTF-8",self::$config['other']['export_csv_charset']);
	  header("Content-Type: text/csv");
	  header("Content-Disposition: attachment; filename=".$table_description."_".date("Y-m-d H_i_s").".csv");
	  header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
	  header('Expires:0');
	  header('Pragma:public');
	  echo $list;
	  exit;

}


if($act=='update'){
	$_GET['id']=intval(@$_GET['id']);
	if($_GET['id']==0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	$sql="update ".self::$table_pre.$table_name." set `publish`='".intval($_GET['publish'])."',`sequence`='".intval($_GET['sequence'])."' where `id`='".$_GET['id']."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}		
}

if($act=='submit_select'){
	//var_dump($_POST);	
	$success='';
	foreach($_POST as $v){
		$v['id']=intval($v['id']);
		$v['publish']=intval($v['publish']);
		$v['sequence']=intval($v['sequence']);
		$sql="update ".self::$table_pre.$table_name." set `publish`='".intval($v['publish'])."',`sequence`='".intval($v['sequence'])."' where `id`='".$v['id']."'";
		//echo $sql;
		if($pdo->exec($sql)){$success.=$v['id']."|";}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

if($act=='del' || $act=='del_select'){
	$sql="select `name`,`search_able`,`description`,`input_type`,`input_args` from ".self::$table_pre."field where `table_id`=$table_id  order by `sequence` desc,`id` asc";
	$r=$pdo->query($sql,2);
	
	$fields=array();
	$input_type=array();
	$input_args=array();
	
	foreach($r as $v){
		$input_type[$v['name']]=$v['input_type'];
		$input_args[$v['name']]=$v['input_args'];
		$fields[$v['name']]=$v['name'];
	}
	
	
}

if($act=='del'){	
	$_GET['id']=intval(@$_GET['id']);
	if($_GET['id']==0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	$sql="select * from ".self::$table_pre.$table_name." where `id`='".$_GET['id']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="delete from ".self::$table_pre.$table_name." where `id`='".$_GET['id']."'";
	if($pdo->exec($sql)){
		foreach($fields as $v){
			switch ($input_type[$v]) {
				case 'img':
					if($r[$v]!=''){
						safe_unlink('./program/form/img/'.$r[$v]);
						@safe_unlink('./program/form/img_thumb/'.$r[$v]);
					}
					break;
				case 'imgs':
					if($r[$v]!=''){
						$temp3=explode('|',$r[$v]);
						$temp3=array_filter($temp3);
						$temp4='';	
						foreach($temp3 as $v3){
							safe_unlink('./program/form/imgs/'.$v3);
							@safe_unlink('./program/form/imgs_thumb/'.$v3);
						}
					}
					break;
				case 'file':
					if($r[$v]!=''){
						safe_unlink('./program/form/file/'.$r[$v]);
					}
					break;
				case 'files':
					if($r[$v]!=''){
						$temp3=explode('|',$r[$v]);
						$temp3=array_filter($temp3);
						$temp4='';	
						foreach($temp3 as $v3){
							safe_unlink('./program/form/files/'.$v3);
						}
					}
					break;
				case 'editor':
					if($r[$v]!=''){
						$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
						$imgs=get_match_all($reg,$r[$v]);
						reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);	
					}
					break;
				default:
			}
			
		}
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}		
}

if($act=='del_select'){
	$ids=@$_GET['ids'];
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=explode("|",$ids);
	$ids=array_filter($ids);
	$success='';
	foreach($ids as $id){
		$id=intval($id);
		$sql="select * from ".self::$table_pre.$table_name." where `id`='".$id."'";
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="delete from ".self::$table_pre.$table_name." where `id`='".$id."'";
		if($pdo->exec($sql)){
			foreach($fields as $v){
				switch ($input_type[$v]) {
					case 'img':
						if($r[$v]!=''){
							safe_unlink('./program/form/img/'.$r[$v]);
							@safe_unlink('./program/form/img_thumb/'.$r[$v]);
						}
						break;
					case 'imgs':
						if($r[$v]!=''){
							$temp3=explode('|',$r[$v]);
							$temp3=array_filter($temp3);
							$temp4='';	
							foreach($temp3 as $v3){
								safe_unlink('./program/form/imgs/'.$v3);
								@safe_unlink('./program/form/imgs_thumb/'.$v3);
							}
						}
						break;
					case 'file':
						if($r[$v]!=''){
							safe_unlink('./program/form/file/'.$r[$v]);
						}
						break;
					case 'files':
						if($r[$v]!=''){
							$temp3=explode('|',$r[$v]);
							$temp3=array_filter($temp3);
							$temp4='';	
							foreach($temp3 as $v3){
								safe_unlink('./program/form/files/'.$v3);
							}
						}
						break;
					case 'editor':
						if($r[$v]!=''){
							$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
							$imgs=get_match_all($reg,$r[$v]);
							reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);	
						}
						break;
				}
			}
			$success.=$id."|";
			
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
