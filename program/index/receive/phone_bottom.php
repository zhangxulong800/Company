<?php
$act=@$_GET['act'];
if($act=='geolocation'){
	if(isset($_SESSION['monxin']['username'])){
		$geohash=new Geohash;
		$temp=explode(',',$_POST['v']);
		$geohash_str=$geohash->encode($temp[0],$temp[1]);
		$sql="update ".$pdo->index_pre."user set `geolocation`='".safe_str($_POST['v'])."',`geohash`='".$geohash_str."' where `username`='".$_SESSION['monxin']['username']."' limit 1";
		$pdo->query($sql);	
		$_SESSION['monxin']['geo']=1;	
	}	
}