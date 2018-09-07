<?php
/*$install_file=@$_GET['install'];
$file_path="./index/install_file/".$install_file;
if(file_exists($file_path)){
	$dir=trim($install_file,".zip");
	$dir=trim($dir,".ZIP");
	if(is_dir("./$dir/") && @$_GET['cover']!='true'){exit("{'state':'program_exist','info':'<span class=fail>".$install_file."".self::$language['program_exist']."</span> <a href=# onclick='return cover_yes()'>".self::$language['yes']."</a> <a href=# onclick='return cover_no()'>".self::$language['no']."</a>'}");}
	require_once("./index/install.class.php");
	$install=new install();
	$install->extract_zip($file_path);
	$install->add_program($dir,$pdo);
	$install->add_program_menu($dir,$pdo);
	$install->add_page($dir,$pdo);
	$install->add_function($dir,$pdo);
	exit(self::$language['install'].self::$language['success']);	
}
*/