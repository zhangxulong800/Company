<?php
if($_GET['act']=='clear_file_cache'){
	if(clear_file_cache()){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($_GET['act']=='clear_sql_cache'){
	if(clear_sql_cache()){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
