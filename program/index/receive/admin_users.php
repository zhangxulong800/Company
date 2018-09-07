<?php
$act=@$_GET['act'];
$id=intval(@$_GET['id']);
require("./program/index/index.class.php");
if($act=='import_im'){
	$ids=@$_GET['ids'];
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=explode("|",$ids);
	$ids=array_filter($ids);
	$success='';
	foreach($ids as $id){
		$id=intval($id);
		if(index::check_user_power($pdo,$id)){
			$sql="select `id`,`username` from ".$pdo->index_pre."user where `id`=".$id;
			$r=$pdo->query($sql,2)->fetch(2);
			$sql="insert into ".$pdo->sys_pre."im_addressee (`username`,`addressee`,`last_time`) values ('".$_SESSION['monxin']['username']."','".$r['username']."','".time()."')";
			if($pdo->exec($sql)){$success.=$id."|";}
		}
	}
	$success=trim($success,"|");	
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>','ids':'".$success."'}");
}
if($act=='import_im_all'){
	$sql=$_SESSION['bulk_action']['sql'];
	//var_dump($sql);
	$sql=str_replace('count(id) as c','`username`',$sql);
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$sql="insert into ".$pdo->sys_pre."im_addressee (`username`,`addressee`,`last_time`) values ('".$_SESSION['monxin']['username']."','".$v['username']."','".time()."')";
		$pdo->exec($sql);
	}
	exit(self::$language['success']);
}

//================================================================================================================================	
if($act=='import'){
	$field_set=$_POST['field_set'];
	$import_file=$_POST['import_file'];
	if($field_set=='' || $import_file=='' ){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	$import_file='./temp/'.trim($import_file,'|');
	if(!is_file($import_file)){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	$data=file_get_contents($import_file);
	$data=iconv(self::$config['other']['export_csv_charset'].'//IGNORE',"UTF-8",$data);
	if($data==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	$data=str_replace("'",'',$data);
	$data=str_replace("\\",'',$data);
	$field_set=trim($field_set,',');
	$field=explode(',',$field_set);
	if(!in_array('username',$field)){exit("{'state':'fail','info':'<span class=fail>username ".self::$language['not_exist']."</span>'}");}
	if(!in_array('password',$field)){exit("{'state':'fail','info':'<span class=fail>password ".self::$language['not_exist']."</span>'}");}
	
	$user=explode("\r\n",$data);
	$temp=$user[0];
	$temp=explode(',',$temp);
	if(count($temp)!=count($field)){exit("{'state':'fail','info':'<span class=fail>".self::$language['field_inconformity']."</span>'}");}
	$username_index=false;
	$password_index=false;
	$transaction_password_index=false;
	$group_index=false;
	$reg_time_index=false;
	$field_sql='';
	foreach($field as $k=>$v){
		$field_sql.='`'.$v.'`,';
		if($v=='username'){$username_index=$k;}	
		if($v=='password'){$password_index=$k;}	
		if($v=='transaction_password'){$transaction_password_index=$k;}	
		if($v=='group'){$group_index=$k;}	
		if($v=='reg_time'){$reg_time_index=$k;}	
	}
	$field_sql=trim($field_sql,',');
	
	$sql="select ".$field_sql." from ".$pdo->index_pre."user limit 0,1";
	//echo $sql;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['username']==''){
		$sql="select `id` from ".$pdo->index_pre."user limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']!=''){
				exit("{'state':'fail','info':'<span class=fail>".self::$language['field'].self::$language['err']."</span>'}");
			}
	}
	
	if(!$group_index){$field_sql.=',`group`';}
	
	$success_sum=0;
	$fail_list='';
	$sqls='';
	foreach($user as $v){
		$v=explode(',',$v);
		if(!isset($v[$username_index])){continue;}
		$sql="select `id` from ".$pdo->index_pre."user where `username`='".$v[$username_index]."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!='' && (is_match(self::$config['other']['reg_phone'],$v[$username_index]) || is_email($v[$username_index])) ){
			$fail_list.=$v[$username_index].'<br />';
		}else{
			if($r['id']!=''){$v[$username_index]=$v[$username_index].'_'.get_verification_code(4);}
			$values='';
			//var_dump($transaction_password_index);
			//var_dump($password_index);
			//var_dump($v);
			
			foreach($v as $k=>$v2){
				if($k===$password_index || $k===$transaction_password_index){
					//echo $k.'=='.$v2.'<br />';
					if(strlen($v2)!=32){$v2=md5($v2);}	
				}
				if($k===$reg_time_index && $v2!='' && !is_numeric($v2)){
					$v2=str_replace('/','-',$v2);
					$v2=get_unixtime($v2,'Y-m-d H:i:s');
				}
				
				$values.="'".$v2."',";
			}
			if(!$group_index){$values.="'".self::$config['reg_set']['default_group_id']."',";}
			$values=trim($values,',');
			$sql="insert into ".$pdo->index_pre."user (".$field_sql.",`state`) values (".$values.",'1')";
			if($pdo->exec($sql)){
				//$sqls.=$sql.";\r";
				$success_sum++;
			}else{
				$fail_list.=$v[$username_index].'<br />';
			}
			
		}	
	}
	//file_put_contents('t.txt',$sqls);
	safe_unlink($import_file);
	if($success_sum>0){
		if($fail_list!=''){
			exit("{'state':'success','info':'<span class=success>".self::$language['success'].' '.$success_sum."<hr />".self::$language['fail'].':<br />'.$fail_list."'}");
		}else{
			
		}exit("{'state':'success','info':'<span class=success>".self::$language['success'].' '.$success_sum."</span>'}");
		
	}else{
		exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['success'].' '.$success_sum."<hr />".self::$language['fail'].':<br />'.$fail_list."'}");
	}
	
}
//================================================================================================================================	
if($act=='state'){
	if(index::check_user_power($pdo,$id)){
		$state=intval(@$_GET['state']);
		$sql="update ".$pdo->index_pre."user set `state`='$state' where `id`='$id'";
		//echo $sql;
		if($pdo->exec($sql)){
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
		}
	}else{
		exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['act_noPower']."'}");
	}		
}
//================================================================================================================================	
if($act=='del'){
	if(index::check_user_power($pdo,$id)){
		$sql="select * from ".$pdo->index_pre."user where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="delete from ".$pdo->index_pre."user where `id`='$id'";
		//echo $sql;
		if($pdo->exec($sql)){
			$sql="update ".$pdo->index_pre."user set `manager`='0' where `manager`='$id'";
			$pdo->exec($sql);
			del_user_relevant($pdo,$r);
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
	}else{
		exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['act_noPower']."'}");
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
				if(index::check_user_power($pdo,$id)){
					$sql="select * from ".$pdo->index_pre."user where `id`=".$id;
					$r=$pdo->query($sql,2)->fetch(2);
					$sql="delete from ".$pdo->index_pre."user where `id`='$id'";
					if($pdo->exec($sql)){
						$success.=$id."|";
						$sql="update ".$pdo->index_pre."user set `manager`='0' where `manager`='$id'";
						$pdo->exec($sql);
						del_user_relevant($pdo,$r);
					}
				}
			}
			$success=trim($success,"|");	
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}
		
//================================================================================================================================	
		
		
		if($act=='submit_select'){
			//var_dump($_POST);	
			$success='';
			foreach($_POST as $v){
				if(index::check_user_power($pdo,$v['id'])){
					$v['id']=intval($v['id']);
					$v['state']=intval($v['state']);
					$sql="update ".$pdo->index_pre."user set `state`='".$v['state']."' where `id`='".$v['id']."'";
					if($pdo->exec($sql)){$success.=$v['id']."|";}
				}
			}
			$success=trim($success,"|");	
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}
		
		
		if($act=='export_csv'){
			if($_SERVER['HTTP_REFERER']!=$_SESSION['bulk_action']['url']){
				header('location:'.$_SESSION['bulk_action']['url']);exit;
			}else{
				header("Content-Type: text/csv");
				header("Content-Disposition: attachment; filename=export_user".date("Y-m-d H_i_s").".csv");
				header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
				header('Expires:0');
				header('Pragma:public');
				
				$list=self::$language['nickname'].','.self::$language['username'].','.self::$language['password'].','.self::$language['transaction_password'].','.self::$language['real_name'].','.self::$language['gender'].','.self::$language['age'].','.self::$language['height'].','.self::$language['weight'].','.self::$language['blood_type'].','.self::$language['married'].','.self::$language['education'].','.self::$language['profession'].','.self::$language['annual_income'].','.self::$language['user_money'].','.self::$language['user_group'].','.self::$language['parent'].','.self::$language['introducer'].','.self::$language['email'].','.self::$language['phone'].','.self::$language['address'].','.self::$language['home_area'].','.self::$language['current_area'].','.self::$language['reg_time'].','.self::$language['chip'].',group'."\r\n";	
	
				$sql=$_SESSION['bulk_action']['sql'];
				$sql=str_replace(" count(id) as c "," * ",$sql);
				$r=$pdo->query($sql,2);
				foreach($r as $v){
					
					$list.=str_replace(',',' ',$v['nickname'])."\t,".str_replace(',',' ',$v['username'])."\t,".str_replace(',',' ',$v['password'])."\t,".str_replace(',',' ',$v['transaction_password'])."\t,".str_replace(',',' ',$v['real_name'])."\t,".str_replace(',',' ',get_select_txt($pdo,$v['gender']))."\t,".get_age($v['birthday']).' ('.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['birthday']).'),'.$v['height']."\t,".$v['weight']."\t,".str_replace(',',' ',get_select_txt($pdo,$v['blood_type']))."\t,".str_replace(',',' ',get_select_txt($pdo,$v['married']))."\t,".str_replace(',',' ',get_select_txt($pdo,$v['education']))."\t,".str_replace(',',' ',get_select_txt($pdo,$v['profession']))."\t,".str_replace(',',' ',get_select_txt($pdo,$v['annual_income']))."\t,".$v['money']."\t,".str_replace(',',' ',index::get_group_name($pdo,$v['group']))."\t,".str_replace(',',' ',index::get_manager($pdo,$v['id'],$v['group'],$v['manager']))."\t,".str_replace(',',' ',$v['introducer']).'('.str_replace(',',' ',index::get_user_real_name($pdo,'username',$v['introducer'])).')'."\t,".$v['email']."\t,".$v['phone']."\t,".str_replace(',',' ',$v['address'])."\t,".str_replace(',',' ',get_area_name($pdo,$v['home_area']))."\t,".str_replace(',',' ',get_area_name($pdo,$v['current_area']))."\t,".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['reg_time'])."\t,".str_replace(',',' ',$v['chip']).",".$v['group']."\r\n";	
				}
				
				$list=iconv("UTF-8",self::$config['other']['export_csv_charset']."//IGNORE",$list);
			echo $list;
				exit;
			
		}		
		}
//================================================================================================================================	
		if($act=='export_csv_selected'){
			header("Content-Type: text/csv");
			header("Content-Disposition: attachment; filename=export_user".date("Y-m-d H_i_s").".csv");
			header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
			header('Expires:0');
			header('Pragma:public');
			
			$list=self::$language['nickname'].','.self::$language['username'].','.self::$language['password'].','.self::$language['transaction_password'].','.self::$language['real_name'].','.self::$language['gender'].','.self::$language['age'].','.self::$language['height'].','.self::$language['weight'].','.self::$language['blood_type'].','.self::$language['married'].','.self::$language['education'].','.self::$language['profession'].','.self::$language['annual_income'].','.self::$language['user_money'].','.self::$language['user_group'].','.self::$language['parent'].','.self::$language['introducer'].','.self::$language['email'].','.self::$language['phone'].','.self::$language['address'].','.self::$language['home_area'].','.self::$language['current_area'].','.self::$language['reg_time'].','.self::$language['chip'].',group'."\r\n";	
			
			$ids=trim(@$_GET['ids'],'|');
			//echo $ids;
			$ids=explode("|",$ids);
			$temp='';
			foreach($ids as $v){
				if(is_numeric($v) && index::check_user_power($pdo,$v)){$temp.=$v.',';}
			}
			$ids=trim($temp,',');
			$sql="select * from ".$pdo->index_pre."user where `id` in ($ids)";
			//echo $sql;
			$r=$pdo->query($sql,2);
			foreach($r as $v){
				$list.=str_replace(',',' ',$v['nickname'])."\t,".str_replace(',',' ',$v['username'])."\t,".str_replace(',',' ',$v['password'])."\t,".str_replace(',',' ',$v['transaction_password'])."\t,".str_replace(',',' ',$v['real_name'])."\t,".str_replace(',',' ',get_select_txt($pdo,$v['gender']))."\t,".get_age($v['birthday']).' ('.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['birthday']).'),'.$v['height']."\t,".$v['weight']."\t,".str_replace(',',' ',get_select_txt($pdo,$v['blood_type']))."\t,".str_replace(',',' ',get_select_txt($pdo,$v['married']))."\t,".str_replace(',',' ',get_select_txt($pdo,$v['education']))."\t,".str_replace(',',' ',get_select_txt($pdo,$v['profession']))."\t,".str_replace(',',' ',get_select_txt($pdo,$v['annual_income']))."\t,".$v['money']."\t,".str_replace(',',' ',index::get_group_name($pdo,$v['group']))."\t,".str_replace(',',' ',index::get_manager($pdo,$v['id'],$v['group'],$v['manager']))."\t,".str_replace(',',' ',$v['introducer']).'('.str_replace(',',' ',index::get_user_real_name($pdo,'username',$v['introducer'])).')'."\t,".$v['email']."\t,".$v['phone']."\t,".str_replace(',',' ',$v['address'])."\t,".str_replace(',',' ',get_area_name($pdo,$v['home_area']))."\t,".str_replace(',',' ',get_area_name($pdo,$v['current_area']))."\t,".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['reg_time'])."\t,".str_replace(',',' ',$v['chip']).",".$v['group']."\r\n";	
			}
			
			$list=iconv("UTF-8",self::$config['other']['export_csv_charset'].'//IGNORE',$list);
		echo $list;
			exit;
			
				
		}
//================================================================================================================================	
		if($act=='send_wxmoney'){
			$ids=trim(@$_GET['ids'],'|');
			//echo $ids;
			$ids=explode("|",$ids);
			$temp='';
			foreach($ids as $v){
				if(is_numeric($v) && index::check_user_power($pdo,$v)){$temp.=$v.',';}
			}
			$ids=trim($temp,',');
			$sql="select * from ".$pdo->index_pre."user where `id` in ($ids)";
			
			$r=$pdo->query($sql,2);
			$list='';
			foreach($r as $v){
				$list.=de_safe_str($v['username']).',';	
			}
			echo '<script src="./public/jquery.js"></script>
<script>
$(document).ready(function(){$("form:first").submit();        
    });
    </script>
    

<form id="monxin_form" name="monxin_form" method="POST" action="./index.php?monxin=index.send_wxmoney"><input type="text" name="data" id="data" value="'.$list.'" /></form>
';
		}
		
//================================================================================================================================	
		if($act=='site_msg'){
			if($_SERVER['HTTP_REFERER']!=$_SESSION['bulk_action']['url']){
				header('location:'.$_SESSION['bulk_action']['url']);exit;
			}else{
				$sql=$_SESSION['bulk_action']['sql'];
				$sql=str_replace(" count(id) as c "," `username` ",$sql);
				$r=$pdo->query($sql,2);
				$list='';
				foreach($r as $v){
					$list.=$v['username'].',';	
				}
				echo '<script src="./public/jquery.js"></script>
<script>
$(document).ready(function(){$("form:first").submit();        
    });
    </script>
    

<form id="monxin_form" name="monxin_form" method="POST" action="./index.php?monxin=index.site_msg"><input type="text" name="data" id="data" value="'.$list.'" /></form>
';
			}
		}
		
//================================================================================================================================	
		if($act=='email_msg'){
			if($_SERVER['HTTP_REFERER']!=$_SESSION['bulk_action']['url']){
				header('location:'.$_SESSION['bulk_action']['url']);exit;
			}else{
				$sql=$_SESSION['bulk_action']['sql'];
				$sql=str_replace(" count(id) as c "," `email` ",$sql);
				$r=$pdo->query($sql,2);
				$list='';
				foreach($r as $v){
					if($v['email']!=''){$list.=$v['email'].',';}
				}
				echo '<script src="./public/jquery.js"></script>
<script>
$(document).ready(function(){$("form:first").submit();        
    });
    </script>
    

<form id="monxin_form" name="monxin_form" method="POST" action="./index.php?monxin=index.email_msg"><input type="text" name="data" id="data" value="'.$list.'" /></form>
';
			}
		}
		
		
//================================================================================================================================	
		if($act=='phone_msg'){
			if($_SERVER['HTTP_REFERER']!=$_SESSION['bulk_action']['url']){
				header('location:'.$_SESSION['bulk_action']['url']);exit;
			}else{
				$sql=$_SESSION['bulk_action']['sql'];
				$sql=str_replace(" count(id) as c "," `phone` ",$sql);
				$r=$pdo->query($sql,2);
				$list='';
				foreach($r as $v){
					if($v['phone']!=''){$list.=$v['phone'].',';}
				}
				echo '<script src="./public/jquery.js"></script>
<script>
$(document).ready(function(){$("form:first").submit();        
    });
    </script>
    

<form id="monxin_form" name="monxin_form" method="POST" action="./index.php?monxin=index.phone_msg"><input type="text" name="data" id="data" value="'.$list.'" /></form>
';
			}
		}
		
//================================================================================================================================	
		if($act=='site_msg_selected'){
			$ids=trim(@$_GET['ids'],'|');
			//echo $ids;
			$ids=explode("|",$ids);
			$list='';
			foreach($ids as $v){			
			$v=intval($v);
			if(index::check_user_power($pdo,$v)){$list.=$v.',';}

			}
			$list=trim($list,',');
			$sql="select `username` from ".$pdo->index_pre."user where `id` in ($list)";
			$r=$pdo->query($sql,2);
			$list='';
			foreach($r as $v){
				$list.=$v['username'].',';	
			}

			echo '<script src="./public/jquery.js"></script>
<script>
$(document).ready(function(){$("form:first").submit();        
    });
    </script>
    

<form id="monxin_form" name="monxin_form" method="POST" action="./index.php?monxin=index.site_msg"><input type="text" name="data" id="data" value="'.$list.'" /></form>
';
		}
		
//================================================================================================================================	
		if($act=='email_msg_selected'){
			$ids=trim(@$_GET['ids'],'|');
			//echo $ids;
			$ids=explode("|",$ids);
			$list='';
			foreach($ids as $v){			
			$v=intval($v);
			if(index::check_user_power($pdo,$v)){$list.=$v.',';}

			}
			$ids=trim($list,',');
			$sql="select `email` from ".$pdo->index_pre."user where `id` in ($ids)";
			//echo $sql;
			$r=$pdo->query($sql,2);
			$list='';
			foreach($r as $v){
				if($v['email']!=''){$list.=$v['email'].',';}
			}
			echo '<script src="./public/jquery.js"></script>
<script>
$(document).ready(function(){$("form:first").submit();        
    });
    </script>
    

<form id="monxin_form" name="monxin_form" method="POST" action="./index.php?monxin=index.email_msg"><input type="text" name="data" id="data" value="'.$list.'" /></form>
';
		}
		
//================================================================================================================================	
		if($act=='phone_msg_selected'){
			$ids=trim(@$_GET['ids'],'|');
			//echo $ids;
			$ids=explode("|",$ids);
			$list='';
			foreach($ids as $v){			
			$v=intval($v);
			if(index::check_user_power($pdo,$v)){$list.=$v.',';}

			}
			$ids=trim($list,',');
			$sql="select `phone` from ".$pdo->index_pre."user where `id` in ($ids)";
			//echo $sql;
			$r=$pdo->query($sql,2);
			$list='';
			foreach($r as $v){
				if($v['phone']!=''){$list.=$v['phone'].',';}
			}
			echo '<script src="./public/jquery.js"></script>
<script>
$(document).ready(function(){$("form:first").submit();        
    });
    </script>
    

<form id="monxin_form" name="monxin_form" method="POST" action="./index.php?monxin=index.phone_msg"><input type="text" name="data" id="data" value="'.$list.'" /></form>
';
		}
		
//================================================================================================================================	
		if($act=='change_group'){
			if($_SERVER['HTTP_REFERER']!=$_SESSION['bulk_action']['url']){
				header('location:'.$_SESSION['bulk_action']['url']);exit;
			}else{
				$sql=$_SESSION['bulk_action']['sql'];
				$sql=str_replace(" count(id) as c "," `id` ",$sql);
				$r=$pdo->query($sql,2);
				$list='';
				foreach($r as $v){
					$list.=$v['id'].',';	
				}
				echo '<script src="./public/jquery.js"></script>
<script>
$(document).ready(function(){$("form:first").submit();        
    });
    </script>
    

<form id="monxin_form" name="monxin_form" method="POST" action="index.php?monxin=index.edit_user_group"><input type="text" name="data" id="data" value="'.$list.'" /></form>
';
			}
		}

//================================================================================================================================	
		if($act=='change_manager'){
			if($_SERVER['HTTP_REFERER']!=$_SESSION['bulk_action']['url']){
				header('location:'.$_SESSION['bulk_action']['url']);exit;
			}else{
				$sql=$_SESSION['bulk_action']['sql'];
				$sql=str_replace(" count(id) as c "," `id` ",$sql);
				$r=$pdo->query($sql,2);
				$list='';
				foreach($r as $v){
					$list.=$v['id'].',';	
				}
				echo '<script src="./public/jquery.js"></script>
<script>
$(document).ready(function(){$("form:first").submit();        
    });
    </script>
    

<form id="monxin_form" name="monxin_form" method="POST" action="index.php?monxin=index.edit_user_group&group='.$_GET['group'].'"><input type="text" name="data" id="data" value="'.$list.'" /></form>
';
			}
		}

//================================================================================================================================	
		if($act=='change_group_selected'){
			$ids=trim(@$_GET['ids'],'|');
			//echo $ids;
			$ids=explode("|",$ids);
			$list='';
			foreach($ids as $v){			
			$v=intval($v);
			if(index::check_user_power($pdo,$v)){$list.=$v.',';}

			}
				echo '<script src="./public/jquery.js"></script>
<script>
$(document).ready(function(){$("form:first").submit();        
    });
    </script>
    

<form id="monxin_form" name="monxin_form" method="POST" action="index.php?monxin=index.edit_user_group"><input type="text" name="data" id="data" value="'.$list.'" /></form>
';
		}

//================================================================================================================================	
		if($act=='change_manager_selected'){
			$ids=trim(@$_GET['ids'],'|');
			//echo $ids;
			$ids=explode("|",$ids);
			$list='';
			foreach($ids as $v){			
			$v=intval($v);
			if(index::check_user_power($pdo,$v)){$list.=$v.',';}

			}
				echo '<script src="./public/jquery.js"></script>
<script>
$(document).ready(function(){$("form:first").submit();        
    });
    </script>
    

<form id="monxin_form" name="monxin_form" method="POST" action="index.php?monxin=index.edit_user_group&group='.$_GET['group'].'"><input type="text" name="data" id="data" value="'.$list.'" /></form>
';
		}
//================================================================================================================================	
		if($act=='bulk_action_state'){
			if($_SERVER['HTTP_REFERER']!=$_SESSION['bulk_action']['url']){
				header('location:'.$_SESSION['bulk_action']['url']);exit;
			}else{
				$sql=$_SESSION['bulk_action']['sql'];
				$sql=str_replace(" count(id) as c "," `id` ",$sql);
				$r=$pdo->query($sql,2);
				$list='';
				foreach($r as $v){
					if(index::check_user_power($pdo,$v['id'])){$list.=$v['id'].',';}
				}
				$list=trim($list,',');
				$state=intval($_GET['state']);
				$sql="update ".$pdo->index_pre."user set `state`='$state' where `id` in ($list)";
				if($pdo->exec($sql)){
					exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
				}else{
					exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
				}
			}
		}
		
//================================================================================================================================	
		if($act=='bulk_action_state_selected'){
			$ids=trim(@$_GET['ids'],'|');
			//echo $ids;
			$ids=explode("|",$ids);
			$list='';
			foreach($ids as $v){
				$v=intval($v);
				if(index::check_user_power($pdo,$v)){$list.=$v.',';}
			}
				$list=trim($list,',');
				$state=intval($_GET['state']);
				$sql="update ".$pdo->index_pre."user set `state`='$state' where `id` in ($list)";
				//echo $sql;
				if($pdo->exec($sql)){
					exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
				}else{
					exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
				}
		}
		
		