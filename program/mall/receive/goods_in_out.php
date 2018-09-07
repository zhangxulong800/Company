<?php
$act=@$_GET['act'];
$id=intval(@$_GET['id']);
//================================================================================================================================	
if($act=='import'){
	$import_file=$_POST['import_file'];
	if($import_file=='' ){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	$import_file='./temp/'.trim($import_file,'|');
	if(!is_file($import_file)){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	$data=file_get_contents($import_file);
	$data=iconv(self::$config['other']['export_csv_charset'].'//IGNORE',"UTF-8",$data);
	if($data==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	$data=safe_str($data);
	$goods=explode("\r\n",$data);
	$temp=$goods[0];
	$temp=explode(',',$temp);
	if(count($temp)!=17){exit("{'state':'fail','info':'<span class=fail>".self::$language['field_inconformity']."</span>'}");}
	
	$sql="select `is_head` from ".self::$table_pre."shop where `id`=".SHOP_ID;
	$rr=$pdo->query($sql,2)->fetch(2);
	$share=$rr['is_head'];
	$success_sum=0;
	$fail_list='';
	$sqls='';
	foreach($goods as $k=>$v){
		if($k==0){continue;}
		
		$vv=explode(',',$v);
		$vv=monxin_trim($vv);
		$vv[3]=trim(@$vv[3],'￥');
		//var_dump(floatval($vv[3]));
		if(!isset($vv[1])){continue;}
		if(!isset($vv[15])){$fail_list.=self::$language['missing_field'].$vv[0].'<br />';continue;}
		
		if($vv[1]!='' && $vv[1]!='0'  && self::barcode_repeat($pdo,SHOP_ID)==0){
			$vv[1]=floatval($vv[1]);
			$sql="select count(id) as c from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and (`bar_code`='".$vv[1]."' or `speci_bar_code` like '%".$vv[1]."|%')";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['c']>0){$fail_list.=self::$language['already_exists'].":".$vv[0].' <b>'.$vv[1].'</b>'.'<br />';continue;}
		}
		if($vv[2]!='' && $vv[2]!='0'){
			$sql="select count(id) as c from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and (`store_code`='".$vv[2]."' or `speci_store_code` like '%".$vv[2]."|%')";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['c']>0){$fail_list.=self::$language['already_exists'].":".$vv[0].' <b>'.$vv[2].'</b>'.'<br />';continue;}
		}
		$vv[5]=preg_replace("/\d+/", '',$vv[5]);
		$vv[5]=trim($vv[5],'.');
		$vv[5]=self::add_unit($pdo,self::$table_pre,$vv[5]);
		$vv[14]=self::add_supplier($pdo,self::$table_pre,$vv[14]);
		$vv[15]=self::add_brand($pdo,self::$table_pre,$vv[15],$vv[13]);
		$vv[16]=self::add_shop_type($pdo,self::$table_pre,$vv['16']);
		self::add_grade($pdo,SHOP_ID,$vv[8]);
		self::add_habitat($pdo,SHOP_ID,$vv[7]);
		self::add_contain($pdo,SHOP_ID,$vv[6]);
		
		$time=time();
		$sql="insert into ".self::$table_pre."goods (`type`,`unit`,`logistics_weight`,`free_shipping`,`supplier`,`title`,`icon`,`detail`,`time`,`username`,`bar_code`,`w_price`,`e_price`,`cost_price`,`inventory`,`option_enable`,`shelf_life`,`shop_id`,`state`,`store_code`,`grade`,`contain`,`habitat`,`share`,`brand`,`mall_state`,`shop_type`) values ('".intval($vv[13])."','".intval($vv[5])."','".floatval($vv[6])."','0','".intval($vv[14])."','".$vv[0]."','default.png','".$vv[9]."','".$time."','".$_SESSION['monxin']['username']."','".safe_str($vv[1])."','".floatval($vv[3])."','".floatval($vv[3])."','".floatval($vv[4])."','".floatval($vv[10])."','0','".intval($vv[11])."','".SHOP_ID."','2','".$vv[2]."','".$vv[8]."','".$vv[6]."','".$vv[7]."','".$share."','".$vv[15]."','".self::$config['goods_check']."','".$vv[16]."')";
		//file_put_contents('t.txt',$sql);
		if($pdo->exec($sql)){
			$insret_id=$pdo->lastInsertId();
			//--------------------------------------------------------------------------------------生成商品快照
			/*$sql="select * from ".self::$table_pre."goods where `id`=".$insret_id;
			$current_goods=$pdo->query($sql,2)->fetch(2);
			self::create_mall_goods_snapshot($pdo,self::$table_pre,$current_goods);
			*/
			self::add_goods_batch($pdo,$insret_id,floatval($vv[10]),floatval($vv[4]),$vv[14]);
			
			
			$success_sum++;
		}else{
			file_put_contents('t.txt',$sql);
		}
	
		
	}
	//file_put_contents('t.txt',$sqls);
	safe_unlink($import_file);
	if($success_sum>0){
		self::update_shop_goods($pdo,self::$table_pre,SHOP_ID);
		if($fail_list!=''){
			exit("{'state':'success','info':'<span class=success>".self::$language['success'].' '.$success_sum."<hr />".self::$language['fail'].':<br />'.$fail_list."'}");
		}else{
			exit("{'state':'success','info':'<span class=success>".self::$language['success'].' '.$success_sum."</span>'}");
		}
	}else{
		exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['success'].' '.$success_sum."<hr />".self::$language['fail'].':<br />'.$fail_list."'}");
	}
	
}

function get_mall_supplier_name($pdo,$table_pre,$id){
	$sql="select `name` from ".$table_pre."supplier where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['name'];	
}



if($act=='export'){
		header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=export_goods".date("Y-m-d H_i_s").".csv");
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0');
		header('Pragma:public');
		
		$list=self::$language['goods_in_out_field']."\r\n";	

		$sql="select `id`,`title`,`bar_code`,`store_code`,`w_price`,`cost_price`,`unit`,`contain`,`habitat`,`grade`,`detail`,`inventory`,`shelf_life`,`logistics_weight`,`type`,`supplier`,`brand`,`shop_type` from  ".self::$table_pre."goods where `shop_id`='".SHOP_ID."' and `option_enable`=0 order by `id` desc";
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$v=de_safe_str($v);
			$v['cost_price']=self::get_cost_price($pdo,$v['id']);			
			$list.=str_replace(',',' ',$v['title'])."\t,";
			$list.=str_replace(',',' ',$v['bar_code'])."\t,";
			$list.=str_replace(',',' ',$v['store_code'])."\t,";
			$list.=str_replace(',',' ',$v['w_price'])."\t,";
			$list.=str_replace(',',' ',$v['cost_price'])."\t,";
			$list.=str_replace(',',' ',self::get_mall_unit_name($pdo,$v['unit']))."\t,";
			$list.=str_replace(',',' ',$v['contain'])."\t,";
			$list.=str_replace(',',' ',$v['habitat'])."\t,";
			$list.=str_replace(',',' ',$v['grade'])."\t,";
			$list.=str_replace("\n","<br />",str_replace("\r","<br />",str_replace(',',' ',$v['detail'])))."\t,";
			$list.=str_replace(',',' ',$v['inventory'])."\t,";
			$list.=str_replace(',',' ',$v['shelf_life'])."\t,";
			$list.=str_replace(',',' ',$v['logistics_weight'])."\t,";
			$list.=str_replace(',',' ',$v['type'])."\t,";
			$list.=str_replace(',',' ',get_mall_supplier_name($pdo,self::$table_pre,$v['supplier']))."\t,";
			$list.=str_replace(',',' ',self::get_mall_brand_name($pdo,$v['brand']))."\t,";
			$list.=str_replace(',',' ',self::get_shop_type_name($pdo,self::$table_pre,$v['shop_type'])).'';
			$list.="\r\n";	
		}
		
		$list=iconv("UTF-8",self::$config['other']['export_csv_charset']."//IGNORE",$list);
		echo $list;
		exit;
}