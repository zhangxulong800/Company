<?php
$act=@$_GET['act'];

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
	$field_sql='';
	foreach($field as $k=>$v){
		$field_sql.='`'.$v.'`,';
		if($v=='username'){$username_index=$k;}	
		if($v=='password'){$password_index=$k;}	
		if($v=='transaction_password'){$transaction_password_index=$k;}	
		if($v=='group'){$group_index=$k;}	
	}
	$field_sql=trim($field_sql,',');
	
	$sql="select ".$field_sql." from ".$pdo->index_pre."user limit 0,1";
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
		if($r['id']!=''){
			if(!self::add_shop_buyer($pdo,$v[$username_index],SHOP_ID)){$fail_list.=$v[$username_index].'<br />';}else{$success_sum++;}
		}else{
			$values='';
			foreach($v as $k=>$v2){
				if($k==$password_index || $k==$transaction_password_index){
					if(strlen($v2)!=32){$v2=md5($v2);}	
				}
				if($k==$group_index){$v2=self::$config['reg_set']['default_group_id'];}
				$values.="'".$v2."',";
			}
			if(!$group_index){$values.="'".self::$config['reg_set']['default_group_id']."',";}
			$values=trim($values,',');
			$sql="insert into ".$pdo->index_pre."user (".$field_sql.",`state`) values (".$values.",'1')";
			if($pdo->exec($sql)){
				if(!self::add_shop_buyer($pdo,$v[$username_index],SHOP_ID)){$fail_list.=$v[$username_index].'<br />';}else{$success_sum++;}
				//$sqls.=$sql.";\r";
				
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

if($act=='update'){
	$_GET['id']=intval(@$_GET['id']);
	$_GET['group_id']=intval(@$_GET['group_id']);
	$_GET['chip']=safe_str(@$_GET['chip']);
	if($_GET['chip']!=''){
		$sql="select `username` from ".self::$table_pre."shop_buyer where `chip`='".$_GET['chip']."' and `shop_id`=".SHOP_ID." and `id`!=".$_GET['id']." limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['username']!=''){exit("{'state':'fail','info':'<span class=fail>".str_replace('{username}','<b>'.$r['username'].'</b>',self::$language['shop_chip_exists'])."</span>'}");}	
		
	}
	$sql="update ".self::$table_pre."shop_buyer set `group_id`='".$_GET['group_id']."',`chip`='".$_GET['chip']."' where `id`='".$_GET['id']."' and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}
if($act=='del'){
	$id=intval(@$_GET['id']);
	if($id<1){exit();}
	$sql="delete from ".self::$table_pre."shop_buyer where `id`='$id' and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}

if($act=='export'){
	$sql="select * from ".self::$table_pre."shop_buyer where `shop_id`=".SHOP_ID.' order by `id` desc';
	$r=$pdo->query($sql,2);
	
	header("Content-Type: text/csv");
	header("Content-Disposition: attachment; filename=export_user".date("Y-m-d H_i_s").".csv");
	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
	header('Expires:0');
	header('Pragma:public');
	
	$list=self::$language['username'].','.self::$language['email'].','.self::$language['phone'].','.self::$language['successful_consumption'].','.self::$language['cumulative_order'].','.self::$language['store'].self::$language['balance'].','.self::$language['available'].self::$language['credits'].','.self::$language['first_time'].','.self::$language['level'].','.self::$language['shop_chip'].''."\r\n";	
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$sql="select `name` from ".self::$table_pre."shop_buyer_group where `id`=".$v['group_id'];
		$g=$pdo->query($sql,2)->fetch(2);
		$sql="select `phone`,`email` from ".$pdo->index_pre."user where `username`='".$v['username']."' limit 0,1";
		$user=$pdo->query($sql,2)->fetch(2);
		
		$list.=str_replace(',',' ',$v['username'])."\t,".str_replace(',',' ',$user['email'])."\t,".str_replace(',',' ',$user['phone'])."\t,".$v['money']."\t,".$v['order']."\t,".$v['balance']."\t,".$v['credits']."\t,".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."\t,".$g['name']."\t,".str_replace(',',' ',$v['chip'])."\r\n";	
	}
	
	$list=iconv("UTF-8",self::$config['other']['export_csv_charset']."//IGNORE",$list);
	echo $list;
	exit;

}

