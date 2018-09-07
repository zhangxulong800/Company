<?php
header('Content-Type:text/html;charset=utf-8');
if($_POST['username']!='temp' || $_POST['password']!='123'){
	exit('false');
	}
	
if($_GET['act']=='check'){exit('true');}


for($i=1;$i<10;$i++){

$data[]=array('id'=>$i,'text'=>'号订单:
原装正品 金士顿 Kingston DT101 G2 8G 旋转 U盘 优盘 促销 价格:40.00*1件=40元
正品 金士顿 Kingston DT101 G2 4G 8G旋转 U盘 优盘 闪存盘 价格:30.00*1件=30元
总计:70.00元
收货人:张华 180745086*6
地址:怀化市交通局对面物资大楼附五楼瑞安爆破公司

');
	
}
//print_r($data);


//echo json_encode($data);
!empty($_POST['id'])?$id=$_POST['id']:$id=0;
if($id>9){$id=0;}
echo '{"id":'.$data[$id]['id'].',"text":"'.$data[$id]['text'].'"}';
//print_r($data);
?>
