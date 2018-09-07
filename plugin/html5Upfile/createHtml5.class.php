<?php

/*use demo 			
	require "./plugin/html5Upfile/createHtml5.class.php";
	$html5Upfile=new createHtml5();
$html5Upfile->echo_input(self::$language,"up_new",'500px','multiple','./temp/','true','false','jpg|gif|png','5000','5');
//echo_input(语言数组,"house_model",'控件宽度(百分比或像素)','multiple','保存到文件夹','文件夹是否附加日期','是否原名保存','允许文件类型','文件最大值','文件最小值');
*/
class createHtml5{

	
	function __construct($token=''){
		$config=require './config.php';
		$language=require './language/'.$config['web']['language'].'.php';
		@session_start();
		if($token!=''){
			$_SESSION['html5Upfile_token']=$token;
		}else{
			$_SESSION['html5Upfile_token']=md5(time().rand(1000,9999));
		}
		

		require("./plugin/html5Upfile/echo_js.php");
	}
	function echo_input($language,$input_name,$div_width,$multiple,$save_dir,$dir_append_date,$sourceName,$top_html5_suffix,$max_size,$min_size){
		require("./plugin/html5Upfile/echo_input.php");	
	}
}
?>