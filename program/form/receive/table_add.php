<?php
$act=@$_GET['act'];
if($act=='add'){
	$_GET['name']=@$_GET['name'];
	$_GET['description']=@$_GET['description'];
	if($_GET['description']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['name'].self::$language['is_null']."</span>','id':'description'}");}
	if($_GET['name']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['table_name'].self::$language['is_null']."</span>'}");}
	if(!is_passwd($_GET['name'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['table_name'].self::$language['only_letters_numbers_underscores']."</span>','id':'name''}");}
	if(field_exist($pdo,$pdo->sys_pre.'form_'.$_GET['name'],'id')){exit("{'state':'fail','info':'<span class=fail>".self::$language['table_name'].self::$language['already_exists']."</span>','id':'name'}");}
	
	$sql = "create table `".$pdo->sys_pre.'form_'.$_GET['name']."` (`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,`write_time` BIGINT( 12 ) NOT NULL DEFAULT  '0',`writer` INT( 11 ) NOT NULL DEFAULT  '0',`edit_time` BIGINT( 12 ) NOT NULL DEFAULT  '0',`editor` INT( 11 ) NOT NULL DEFAULT  '0',`publish` INT( 1 ) NOT NULL DEFAULT  '0',`sequence` INT( 5 ) NOT NULL DEFAULT  '0',`visit` INT( 10 ) NOT NULL DEFAULT  '0') ENGINE = MYISAM DEFAULT CHARSET=utf8";
	$pdo->exec($sql);
	if(field_exist($pdo,$pdo->sys_pre.'form_'.$_GET['name'],'id')){
		$sql="insert into ".self::$table_pre."table (`name`,`description`) value ('".$_GET['name']."','".$_GET['description']."')";		
		$pdo->exec($sql);
		
		
		
		
		//============================================================================================添加默认字段
		$table_id=$pdo->lastInsertId();
		$sql="insert into ".self::$table_pre."field (`table_id`,`name`,`description`,`type`,`input_type`,`placeholder`,`default_value`,`length`,`reg`,`unique`,`search_able`,`required`,`input_args`,`fore_list_show`,`back_list_show`,`read_able`,`sequence`) values ('".$table_id."','write_time','".self::$language['add'].self::$language['time']."','".self::$language['sys_bring']."','".self::$language['sys_bring']."','','0','12','','0','0','1','','0','1','0','-11')";
		$pdo->exec($sql);
		$sql="insert into ".self::$table_pre."field (`table_id`,`name`,`description`,`type`,`input_type`,`placeholder`,`default_value`,`length`,`reg`,`unique`,`search_able`,`required`,`input_args`,`fore_list_show`,`back_list_show`,`read_able`,`sequence`) values ('".$table_id."','writer','".self::$language['writer']."','".self::$language['sys_bring']."','".self::$language['sys_bring']."','','0','11','','0','0','1','','0','1','0','-10')";
		$pdo->exec($sql);
		$sql="insert into ".self::$table_pre."field (`table_id`,`name`,`description`,`type`,`input_type`,`placeholder`,`default_value`,`length`,`reg`,`unique`,`search_able`,`required`,`input_args`,`fore_list_show`,`back_list_show`,`read_able`,`sequence`) values ('".$table_id."','edit_time','".self::$language['edit'].self::$language['time']."','".self::$language['sys_bring']."','".self::$language['sys_bring']."','','0','12','','0','0','1','','0','0','0','-13')";
		$pdo->exec($sql);
		$sql="insert into ".self::$table_pre."field (`table_id`,`name`,`description`,`type`,`input_type`,`placeholder`,`default_value`,`length`,`reg`,`unique`,`search_able`,`required`,`input_args`,`fore_list_show`,`back_list_show`,`read_able`,`sequence`) values ('".$table_id."','editor','".self::$language['editor']."','".self::$language['sys_bring']."','".self::$language['sys_bring']."','','0','12','','0','0','1','','0','0','0','-12')";
		$pdo->exec($sql);
		$sql="insert into ".self::$table_pre."field (`table_id`,`name`,`description`,`type`,`input_type`,`placeholder`,`default_value`,`length`,`reg`,`unique`,`search_able`,`required`,`input_args`,`fore_list_show`,`back_list_show`,`read_able`,`sequence`) values ('".$table_id."','publish','".self::$language['publish'].self::$language['state']."','".self::$language['sys_bring']."','".self::$language['sys_bring']."','','0','12','','0','0','1','','0','1','0','-8')";
		$pdo->exec($sql);
		$sql="insert into ".self::$table_pre."field (`table_id`,`name`,`description`,`type`,`input_type`,`placeholder`,`default_value`,`length`,`reg`,`unique`,`search_able`,`required`,`input_args`,`fore_list_show`,`back_list_show`,`read_able`,`sequence`) values ('".$table_id."','sequence','".self::$language['sequence']."','".self::$language['sys_bring']."','".self::$language['sys_bring']."','','0','10','','0','0','1','','0','1','0','-9')";
		$pdo->exec($sql);
		$sql="insert into ".self::$table_pre."field (`table_id`,`name`,`description`,`type`,`input_type`,`placeholder`,`default_value`,`length`,`reg`,`unique`,`search_able`,`required`,`input_args`,`fore_list_show`,`back_list_show`,`read_able`,`sequence`) values ('".$table_id."','visit','".self::$language['visit_count']."','".self::$language['sys_bring']."','".self::$language['sys_bring']."','','0','10','','0','0','1','','0','0','0','-8')";
		$pdo->exec($sql);
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
		
		
}
