<?php
$act=@$_GET['act'];
$id=intval(@$_GET['id']);
//================================================================================================================================	
if($act=='import'){
	$time=time();
	$import_file=$_POST['import_file'];
	if($import_file=='' ){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	$import_file='./temp/'.trim($import_file,'|');
	if(!is_file($import_file)){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	$data=file_get_contents($import_file);
	$data=iconv(self::$config['other']['export_csv_charset'].'//IGNORE',"UTF-8",$data);
	if($data==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	$data=safe_str($data);
	$goods=explode("\r\n",$data);
	$goods=trim_csv_quotes($goods);
	$temp=$goods[0];
	$temp=explode(',',$temp);
	if(count($temp)<5){exit("{'state':'fail','info':'<span class=fail>".self::$language['field_inconformity']."</span>'}");}
	
	$first=$goods[0];
	$first=explode(',',$first);
	if($first[0]!='' && $first[0]!='0'){
		$where_filed='id';
		$where_index=0;
	}elseif($first[1]!='' && $first[1]!='0'){
		$where_filed='bar_code';
		$where_index=1;
	}elseif($first[2]!='' && $first[2]!='0'){
		$where_filed='store_code';	
		$where_index=2;
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['field_inconformity']."</span>'}");	
	}
	
		$sum=count($first)-6;
		$sum=$sum/2;
		//var_dump($sum);exit();
		
	
	
		$sql="select `name`,`id`,`discount` from ".self::$table_pre."shop_buyer_group where `shop_id`='".SHOP_ID."' order by `discount` desc";
		$r=$pdo->query($sql,2);
		$group=array();
		$group_discount=array();
		$up_group_id=array();
		foreach($r as $v){
			$group[$v['id']]=$v['name'];	
			$group_discount[$v['id']]=$v['discount'];
			for($i=0;$i<=$sum;$i++){
				$v['name']=str_replace(self::$language['price2'],'',$v['name']);
				//echo str_replace(self::$language['price2'],'',$first[5+$i]).'=='.$v['name'].'<br />';
				if(str_replace(self::$language['price2'],'',$first[5+$i])==$v['name']){$up_group_id[5+$i]=$v['id'];}
			}
					
		}
	//exit();
	$fail_list='';
	$success_sum=0;
	
	foreach($goods as $index=>$v){
		if($index==0){continue;}
		$g=explode(',',$v);
		if(@$g[3]==''){continue;}
		if(count($g)<5){$fail_list.=@$g[3]."  <b>".self::$language['fail']."</b><br />";continue;}
		$g[4]=floatval($g[4]);
		$sql="select `id`,`w_price`,`option_enable`,`introducer_rate` from ".self::$table_pre."goods where `".$where_filed."`='".$g[$where_index]."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){exit; $fail_list.=$g[3]."  <b>".self::$language['fail']."</b><br />";continue;}
		$goods_id=$r['id'];
		if($r['option_enable']==1){
			$sql="select `w_price`,`id` from ".self::$table_pre."goods_specifications where  `goods_id`='".$r['id']."' order by `w_price` desc limit 0,1";
			$s=$pdo->query($sql,2)->fetch(2);
			$r['w_price']=$s['w_price'];	
		}
		//===========================================================================================================修改标题 推荐人返佣及默认价 start
		if($r['w_price']!=$g[4] || $r['introducer_rate']!=trim($g[count($first)-1],'%')){
			if($r['option_enable']==1){
				$sql="update ".self::$table_pre."goods_specifications set `w_price`='".$g[4]."',`e_price`='".$g[4]."' where `id`='".$s['id']."'";
				if($pdo->exec($sql)){
					$min_update='';
					if($where_filed=='id'){
						$sql="select `w_price` from ".self::$table_pre."goods_specifications where `goods_id`='".$g[0]."' order by `w_price` asc limit 0,1";
						$min_r=$pdo->query($sql,2)->fetch(2);
						if($min_r['w_price']<$g[4]){$min_update=",`min_price`='".$min_r['w_price']."'";}
					}
					
					
					$sql="update ".self::$table_pre."goods set `title`='".$g[3]."',`introducer_rate`='".trim($g[count($first)-1],'%')."',`max_price`='".$g[4]."',`e_price`='".$g[4]."' ".$min_update.",`time`=".$time." where `".$where_filed."`='".$g[$where_index]."' limit 1";
					
					if(!$pdo->exec($sql)){$fail_list.=$g[3]."  <b>".self::$language['fail']."</b><br />";continue;}
				}else{
					
					$fail_list.=$g[3]."  <b>".self::$language['fail']."</b><br />";continue;	
				}
			}else{
				$sql="update ".self::$table_pre."goods set `title`='".$g[3]."',`introducer_rate`='".trim($g[count($first)-1],'%')."',`max_price`='".$g[4]."',`min_price`='".$g[4]."',`w_price`='".$g[4]."',`e_price`='".$g[4]."',`time`=".$time." where `".$where_filed."`='".$g[$where_index]."' limit 1";
				
				if(!$pdo->exec($sql)){$fail_list.=$g[3]."  <b>".self::$language['fail']."</b><br />";continue;}
			}
		}
		//===========================================================================================================修改标题 推荐人返佣及默认价 end
		
		//===========================================================================================================更新店内用户组折扣 start
		//var_dump($up_group_id);
		
		foreach($up_group_id as $k=>$gi){
			$sql="select `discount`,`id` from ".self::$table_pre."goods_group_discount where `goods_id`='".$goods_id."' and `group_id`='".$gi."' limit 0,1";
			$d=$pdo->query($sql,2)->fetch(2);
			if($d['discount']==''){$old_discount=$group_discount[$gi];}else{$old_discount=$d['discount'];}
			$old_price=$r['w_price']*$old_discount/10;
			
			$new_discount=$g[$k+count($up_group_id)];		
			$new_price=$g[$k];
			if($old_price!=$new_price && $g[4]!=0){
				$new_discount=$new_price/$g[4]*10;
			}
			if($new_discount!=$old_discount){
				if($d['id']==''){
					$sql="insert into ".self::$table_pre."goods_group_discount (`goods_id`,`group_id`,`discount`) values ('".$goods_id."','".$gi."','".$new_discount."')";	
				}else{
					$sql="update ".self::$table_pre."goods_group_discount set `discount`='".$new_discount."'  where `goods_id`='".$goods_id."' and `group_id`='".$gi."' limit 1";
				}
				//echo $sql;
				$pdo->exec($sql);
				
			}
			
			
			
		}
		
		//===========================================================================================================更新店内用户组折扣 end
		$success_sum++;
		
			
	}
	
	
	
	//file_put_contents('t.txt',$sqls);
	safe_unlink($import_file);
	if($success_sum>0){
		if($fail_list!=''){
			exit("{'state':'success','info':'<span class=success>".self::$language['success'].' '.$success_sum."<hr />".self::$language['fail'].':<br />'.$fail_list."'}");
		}else{
			exit("{'state':'success','info':'<span class=success>".self::$language['success'].' '.$success_sum."</span>'}");
		}
	}else{
		exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['success'].' '.$success_sum."<hr />".self::$language['fail'].':<br />'.$fail_list."'}");
	}
	
}


if($act=='export'){
		header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=export_goods".date("Y-m-d H_i_s").".csv");
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0');
		header('Pragma:public');
		
		$sql="select `name`,`id`,`discount` from ".self::$table_pre."shop_buyer_group where `shop_id`='".SHOP_ID."' order by `discount` desc";
		$r=$pdo->query($sql,2);
		$group=array();
		$group_discount=array();
		$group_field_a='';
		$group_field_b='';
		foreach($r as $v){
			$group[$v['id']]=de_safe_str($v['name']);	
			$group_discount[$v['id']]=$v['discount'];	
			$v['name']=de_safe_str($v['name']);
			$group_field_a.=','.$v['name'].self::$language['price2'];
			$group_field_b.=','.$v['name'].self::$language['discount_rate'];
		}
				
		self::$language['batch_reset_price_field'].=$group_field_a.$group_field_b.','.self::$language['introducer'].self::$language['introducer_rate']."(%)";
		$list=self::$language['batch_reset_price_field']."\r\n";
		$sql="select `id`,`bar_code`,`store_code`,`title`,`w_price`,`option_enable`,`introducer_rate` from  ".self::$table_pre."goods where `shop_id`='".SHOP_ID."' order by `id` desc";
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$v=de_safe_str($v);
			
			if($v['option_enable']==1){
				$sql="select `w_price` from ".self::$table_pre."goods_specifications where `goods_id`='".$v['id']."' order by `w_price` asc limit 0,1";
				$s=$pdo->query($sql,2)->fetch(2);
				$v['w_price']=$s['w_price'];	
			}
			$list.=str_replace(',',' ',$v['id'])."\t,";
			$list.=str_replace(',',' ',$v['bar_code'])."\t,";
			$list.=str_replace(',',' ',$v['store_code'])."\t,";
			$list.=str_replace(',',' ',$v['title'])."\t,";
			$list.=str_replace(',',' ',$v['w_price'])."\t,";
			
			$goods_group_discount=array();
			
			foreach($group as $k=>$g){
				$discount=$group_discount[$k];
				$sql="select `discount` from ".self::$table_pre."goods_group_discount where `goods_id`='".$v['id']."' and `group_id`='".$k."' limit 0,1";
				$d=$pdo->query($sql,2)->fetch(2);
				if($d['discount']){$discount=$d['discount'];}
				$list.=str_replace(',',' ',sprintf("%.2f",$v['w_price']*$discount/10))."\t,";		
				$goods_group_discount[$k]=$discount;			
			}
			
			foreach($group as $k=>$g){
				$list.=str_replace(',',' ',$goods_group_discount[$k]).',';					
			}
			$v['introducer_rate']=rtrim($v['introducer_rate'],'0');
			$v['introducer_rate']=rtrim($v['introducer_rate'],'.');
			$list.="".$v['introducer_rate'].",\r\n";	
		}
		
		$list=iconv("UTF-8",self::$config['other']['export_csv_charset']."//IGNORE",$list);
		echo $list;
		exit;
}