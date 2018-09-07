<?php
if(file_put_contents('./program/index/phone_bottom_data.txt',$_POST['content'])){
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
	exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
}
