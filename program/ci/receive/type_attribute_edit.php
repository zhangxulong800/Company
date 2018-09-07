<?php
$id=intval(@$_GET['id']);
if($id==0){exit('id err');}

$act=@$_GET['act'];
if($act=='update'){
	$_POST['name']=@$_POST['name'];
	if($_POST['name']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['table_name'].self::$language['is_null']."</span>'}");}
	
	$sql="select `type_id` from ".self::$table_pre."type_attribute where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	$type_id=$r['type_id'];
	$sql="select count(id) as c from ".self::$table_pre."type_attribute where `name`='".$_POST['name']."'  and `id`!='".$id."' and `type`=".$type_id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']>0){exit("{'state':'fail','info':'<span class=fail>".self::$language['already_exists']."</span>','id':'name'}");}
			
	$args=@$_POST['args'];
	//echo @$_POST['args'];
	$input_type=@$_POST['input_type'];
	$args_array=array();
	$default_value='';
	$length='';
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
			break;
		case 'editor':
			$type='text';
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
			break;
		case 'file':
			$type='varchar';
			$length=100;
			break;
		case 'files':
			$type='text';
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
	
	$_POST['postfix']=safe_str(@$_POST['postfix']);
	$_POST['placeholder']=safe_str(@$_POST['placeholder']);
	$_POST['reg']=@$_POST['reg'];
	$_POST['unique']=intval(@$_POST['unique']);
	$_POST['search_able']=intval(@$_POST['search_able']);
	$_POST['required']=intval(@$_POST['required']);
	$_POST['unique']=intval(@$_POST['unique']);
	
	//var_dump($_POST);
	if($input_type=='textarea' || $input_type=='editor'){$fore_list_show=0;$back_list_show=0;}
	$sql="update ".self::$table_pre."type_attribute set `name`='".$_POST['name']."',`type`='".$type."',`input_type`='".$input_type."',`placeholder`='".$_POST['placeholder']."',`default_value`='".$default_value."',`length`='".$length."',`reg`='".$_POST['reg']."',`unique`='".$_POST['unique']."',`search_able`='".$_POST['search_able']."',`required`='".$_POST['required']."',`postfix`='".$_POST['postfix']."',`input_args`='".$args."' where `id`=".$id;
	
	
	//echo $sql;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
	}else{
		exit("{'state':'fail','info':'<span class=fail>update ".self::$language['fail']."</span>'}");
	}
		
		
}
