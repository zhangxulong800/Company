<?php
$act=@$_GET['act'];
if($act=='export_csv'){
	if($_SERVER['HTTP_REFERER']!=$_SESSION['purchase']['url']){
		header('location:'.$_SESSION['purchase']['url']);exit;
	}else{
		$sql="select `name` from ".self::$table_pre."shop where `id`=".SHOP_ID;
		$r=$pdo->query($sql,2)->fetch(2);
		$shop_name=de_safe_str($r['name']);
		$supplier_name=array();
		$unit_name=array();
		$storehouse=array();
		$sql="select `id`,`name` from ".self::$table_pre."storehouse where `shop_id`=".SHOP_ID;
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$storehouse[$v['id']]=de_safe_str($v['name']);
		}

		
		header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=".$shop_name.self::$language['purchase_bill'].@$_GET['purchase_name'].".csv");
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0');
		header('Pragma:public');
		
		$list=self::$language['goods'].'/'.self::$language['barcode'].','.self::$language['goods_supplier'].','.self::$language['cost_price'].','.self::$language['into_quantity'].','.self::$language['subtotal'].','.self::$language['purchase'].self::$language['time'].','.self::$language['overdue'].self::$language['time'].','.self::$language['money_settled'].','.self::$language['remark'].','.self::$language['storehouse']."\r\n";	

		$sql=$_SESSION['purchase']['sql'];
		//echo $sql;
		$r=$pdo->query($sql,2);
		foreach($r as $v){
					
			$sql="select `id`,`title`,`option_enable`,`unit`,`icon`,`bar_code` from ".self::$table_pre."goods where `id`=".intval($v['goods_id']);
			$goods=$pdo->query($sql,2)->fetch(2);
			if(!isset($goods['id'])){
				$s=$pdo->query($sql,2)->fetch(2);
				if(!isset($s['id'])){
					$sql="delete from ".self::$table_pre."goods_batch where `id`=".$v['id'];
					$pdo->exec($sql);
					continue;		
				}	
			}
			if(!is_numeric($v['goods_id'])){
			//if($goods['option_enable']){
				$temp=explode('_',$v['goods_id']);
				//var_dump($v['goods_id']);
				if(!isset($temp[1])){
					$sql="delete from ".self::$table_pre."goods_batch where `id`=".$v['id'];
					$pdo->exec($sql);
					continue;
				}
				$sql="select `id`,`option_id`,`color_name`,`barcode` from ".self::$table_pre."goods_specifications where `id`=".$temp[1];
				$s=$pdo->query($sql,2)->fetch(2);
				if(!isset($s['id'])){
					$sql="delete from ".self::$table_pre."goods_batch where `id`=".$v['id'];
					$pdo->exec($sql);
					continue;		
				}
				$goods['title'].=' '.self::get_type_option_name($pdo,$s['option_id']).' '.$s['color_name'];
				$goods['bar_code']=$s['barcode'];	
			}
			if(!isset($unit_name[$goods['unit']])){$unit_name[$goods['unit']]=self::get_mall_unit_name($pdo,$goods['unit']);}
			$unit=$unit_name[$goods['unit']];
			
			if(!isset($supplier_name[$v['supplier']])){$supplier_name[$v['supplier']]=self::get_supplier_name($pdo,$v['supplier']);}
			$supplier=$supplier_name[$v['supplier']];

			if($v['expiration']!=0){$v['expiration']=date('Y-m-d',$v['expiration']);}else{$v['expiration']='';}
			if($v['storehouse']!=0){$v['storehouse']=$storehouse[$v['storehouse']];}else{$v['storehouse']='';}
			if($goods['bar_code']==0){$goods['bar_code']='';}else{$goods['bar_code']='/'.$goods['bar_code'];}
			
			
			$list.=str_replace(',',' ',$goods['title'].$goods['bar_code'])."\t,".str_replace(',',' ',$supplier)."\t,".$v['price']."\t,".self::format_quantity($v['quantity']).' '.$unit."\t,".self::format_quantity($v['quantity'])*$v['price']."\t,".date('Y-m-d',$v['add_time'])."\t,".$v['expiration']."\t,".self::format_quantity($v['payment']).' '.$unit."\t,".str_replace(',',' ',$v['remark'])."\t,".str_replace(',',' ',$v['storehouse'])."\r\n";	
		}
		
		$sql=str_replace(' and `quantity`>`payment`','',$_SESSION['purchase']['sql']);
		$old_sql=$sql;
		$sql=str_replace('*','sum(`quantity`*`price`) as c',$sql);
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']==''){$r['c']==0;}
		$sum=$r['c'];
		
		$sql=str_replace('*','sum(`payment`*`price`) as c',$old_sql);
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']==''){$r['c']==0;}
		$pay_end=$r['c'];
		
		$sql=str_replace('*','sum((`quantity`-`payment`)*`price`) as c',$old_sql);
		$r=$pdo->query($sql." and `quantity`>`payment`",2)->fetch(2);
		if($r['c']==''){$r['c']==0;}
		$pay_wait=$r['c'];
		
		$list=$shop_name.self::$language['purchase_bill'].@$_GET['purchase_name']."\r\n".self::$language['total_purchase_cost'].':'.$sum.self::$language['yuan'].','.self::$language['pay_end'].':'.$pay_end.self::$language['yuan'].','.self::$language['pay_wait'].':'.$pay_wait.self::$language['yuan']."\r\n\r\n".$list;
		
		$list=iconv("UTF-8",self::$config['other']['export_csv_charset'].'//IGNORE',$list);
	echo $list;
		exit;
	
}		
}
