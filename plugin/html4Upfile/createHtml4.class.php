<?php

/*  use demo 
	require "./plugin/html4Upfile/createHtml4.class.php";
	$html4Upfile=new createHtml4();
	$html4Upfile->echo_input("myPhoto",'100%','./test','true','true','jpg|gif|png|rar','500','5','name.png');
	//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');
	//指定保存名时，要先设置权限 $_SESSION['replace_file']=true;  ，否则将无效

*/


class createHtml4{

	
	function __construct(){
		$config=require './config.php';
		$language=require './language/'.$config['web']['language'].'.php';
		@session_start();
		$_SESSION['html4Upfile_token']=md5(time().rand(1000,9999));
		require("./plugin/html4Upfile/echo_js.php");
	}
	function echo_input($input_name,$div_width,$save_dir,$dir_append_date,$sourceName,$top_html4_suffix,$max_size,$min_size,$save_name=''){
		require("./plugin/html4Upfile/echo_input.php");
	}
}
?>