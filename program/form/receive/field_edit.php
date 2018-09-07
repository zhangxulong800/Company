<?php
$id=intval(@$_GET['id']);
if($id==0){exit('id err');}
$act=@$_GET['act'];
if($act=='update'){
	$_POST['name']=@$_POST['name'];
	
	$_POST['description']=safe_str(@$_POST['description']);
	if($_POST['description']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['name'].self::$language['is_null']."</span>','id':'description'}");}
	if($_POST['name']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['table_name'].self::$language['is_null']."</span>'}");}
	if(!is_passwd($_POST['name'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['table_name'].self::$language['only_letters_numbers_underscores']."</span>','id':'name''}");}
	
	$sql="select `name`,`table_id`,`fore_list_show`,`back_list_show` from ".self::$table_pre."field where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	$old_name=$r['name'];
	$table_id=$r['table_id'];
	if($table_id==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." field does not exist</span>'}");}
	$fore_list_show=$r['fore_list_show'];
	$back_list_show=$r['back_list_show'];
	
	
	$sql="select `name` from ".self::$table_pre."table where `id`=".$table_id;
	$r=$pdo->query($sql,2)->fetch(2);
	$table_name=$r['name'];
	if($table_name==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." table does not exist</span>'}");}
	
	$args=@$_POST['args'];
	//echo @$_POST['args'];
	$input_type=@$_POST['input_type'];
	$args_array=array();
	$default_value='';
	$length='';
	$field_sql='';
	if($args!=''){
		$args_array=format_attribute($args);
	}
	switch ($input_type) {
		case 'text':
			$type='varchar';
			$default_value=$args_array['text_default_value'];
			$length=min(255,max(intval($args_array['text_length']),strlen($default_value)));
			if($length==0){$length=255;}
			break;
		case 'textarea':
			$type='text';
			$default_value=$args_array['textarea_default_value'];
			$field_sql="ALTER TABLE  ".self::$table_pre.$table_name." CHANGE `".$old_name."` `".$_POST['name']."` ".$type." NULL ";
			break;
		case 'editor':
			$type='text';
			$field_sql="ALTER TABLE  ".self::$table_pre.$table_name." CHANGE `".$old_name."` `".$_POST['name']."` ".$type." NULL ";
			$default_value=$args_array['editor_default_value'];
			break;
		case 'select':
			$type='varchar';
			$default_value=$args_array['select_default_value'];
			$length=255;
			break;
		case 'radio':
			$type='varchar';
			$default_value=$args_array['radio_default_value'];
			$length=255;
			break;
		case 'checkbox':
			$type='varchar';
			$default_value=$args_array['checkbox_default_value'];
			$length=255;
			break;
		case 'img':
			$type='varchar';
			$length=100;
			break;
		case 'imgs':
			$type='text';
			$field_sql="ALTER TABLE  ".self::$table_pre.$table_name." CHANGE `".$old_name."` `".$_POST['name']."` ".$type." NULL ";
			break;
		case 'file':
			$type='varchar';
			$length=100;
			break;
		case 'files':
			$type='text';
			$field_sql="ALTER TABLE  ".self::$table_pre.$table_name." CHANGE `".$old_name."` `".$_POST['name']."` ".$type." NULL ";
			break;
		case 'number':
			if($args_array['number_decimal_places']==0){
				if($args_array['number_max']<2147483647 || $args_array['number_max']==''){$type='int';$length=11;}else{$type='bigint';$length=12;}
			}else{
				$type='decimal';
				$length=max(strlen($args_array['number_max']),10).','.$args_array['number_decimal_places'];
			}
			$default_value=intval($args_array['number_default_value']);
			break;
		case 'time':
			$type='bigint';
			$length=12;
			$default_value=0;
			break;
		case 'map':
			$type='varchar';
			$length=255;
			break;
		case 'area':
			$type='int';
			$length=10;
			$default_value=0;
			break;
		default:
			$type='varchar';
			$input_type='text';
			$default_value='';
			$length=255;

	}
	
	$_POST['placeholder']=safe_str(@$_POST['placeholder']);
	$_POST['reg']=@$_POST['reg'];
	$_POST['unique']=intval(@$_POST['unique']);
	$_POST['search_able']=intval(@$_POST['search_able']);
	$_POST['required']=intval(@$_POST['required']);
	$_POST['unique']=intval(@$_POST['unique']);
	
	//var_dump($_POST);
	$sql="select count(id) as c from ".self::$table_pre."field where `description`='".$_POST['description']."'  and `id`!=".$id." and `table_id`=".$table_id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']>0){exit("{'state':'fail','info':'<span class=fail>".self::$language['already_exists']."</span>','id':'description'}");}
	
	if(!field_exist($pdo,self::$table_pre.$table_name,$old_name)){exit("{'state':'fail','info':'<span class=fail>".self::$language['not_exist']."</span>','id':'name'}");}
	if($old_name!=$_POST['name']){
		if(field_exist($pdo,self::$table_pre.$table_name,$_POST['name'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['already_exists']."</span>','id':'name'}");}
	}
	if($input_type=='textarea' || $input_type=='editor'){$fore_list_show=0;$back_list_show=0;}
	
	$sql="update ".self::$table_pre."field set `name`='".$_POST['name']."',`description`='".$_POST['description']."',`type`='".$type."',`input_type`='".$input_type."',`placeholder`='".$_POST['placeholder']."',`default_value`='".$default_value."',`length`='".$length."',`reg`='".$_POST['reg']."',`unique`='".$_POST['unique']."',`search_able`='".$_POST['search_able']."',`required`='".$_POST['required']."',`input_args`='".$args."',`fore_list_show`='".$fore_list_show."',`back_list_show`='".$back_list_show."' where `id`=".$id;
	$result=$pdo->exec($sql);
	if(!$result){
		$sql="update ".self::$table_pre."field set `name`='".$_POST['name']."',`description`='".$_POST['description']."',`type`='".$type."',`input_type`='".$input_type."',`placeholder`='".$_POST['placeholder']."',`default_value`='".$default_value."',`reg`='".$_POST['reg']."',`unique`='".$_POST['unique']."',`search_able`='".$_POST['search_able']."',`required`='".$_POST['required']."',`input_args`='".$args."',`fore_list_show`='".$fore_list_show."',`back_list_show`='".$back_list_show."' where `id`=".$id;
		$result=$pdo->exec($sql);
	}
	
	if($result){
		$insret_id=$pdo->lastInsertId();
		if($field_sql==''){
			$field_sql="ALTER TABLE  ".self::$table_pre.$table_name." CHANGE `".$old_name."` `".$_POST['name']."` ".$type."( ".$length." ) NULL DEFAULT  '".$default_value."' ";
		}
		file_put_contents('test.sql',$field_sql);
		$r=$pdo->exec($field_sql);
		//var_dump($r);
		if($r!==false){
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','table_id':'".$table_id."'}");	
		}else{
			$sql="delete from ".self::$table_pre."field where `id`=".$insret_id;
			$pdo->exec($sql);
			exit("{'state':'fail','info':'<span class=fail>change ".self::$language['fail']."</span>'}");
		}
		
	}else{
		exit("{'state':'fail','info':'<span class=fail>update ".self::$language['fail']."</span>'}");
	}
		
		
}
