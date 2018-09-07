<?php
header('Content-Type:text/html;charset=utf-8');
require_once './config/functions.php';
$config=require_once './config.php';
$language=require_once './language/'.$config['web']['language'].'.php';
$pdo=new  ConnectPDO();
$id=@$_GET['id'];
$id=is_numeric($id)?$id:0;
$input_id=@$_GET['input_id'];
$output=@$_GET['output'];

if($input_id==''){exit;}
if($output==''){exit;}

//echo $id.'---<hr/>';


if($output=='select'){
	$area_select=new area_select();
	if($id==0 || $id==''){
		$list=$area_select->get_level1();
	}else{
		$list=$area_select->get_select($id);
	}
	echo $list;
}
?>
<?php



class area_select{
	function __construct(){
		
	}
	function get_select($id){
		global $pdo,$input_id,$language;
		$list='';
			$sql="select `level`,`name`,`id` from ".$pdo->index_pre."area where `upid`='$id' order by `sequence` desc,`id` asc";
			$stmt=$pdo->query($sql,2);
			$temp='';
			foreach($stmt as $v){
				$temp.="<option value='".$v['id']."|".$v['level']."'>".$v['name']."</option>";
				$level=$v['level'];	
			}

			if($temp!=''){
				if($level==2){$level_name=$language['province'];}
				if($level==3){$level_name=$language['city'];}
				if($level==4){$level_name=$language['county'];}
				if($level==5){$level_name=$language['twon'];}
				if($level==6){$level_name=$language['village'];}
				if($level==7){$level_name=$language['group'];}
				if(isset($level_name)){$list="<select class='{$input_id}_select_change'  autocomplete='off'><option value='0'>-".$level_name."-</option>$temp</select>";}
				}	
			return $list;
			
	}
	function get_level1(){
		global $pdo,$input_id,$language;
		$list='';
		$sql="select `level`,`name`,`id` from ".$pdo->index_pre."area where `level`=1 order by `sequence` desc,`id` asc";
		$stmt=$pdo->query($sql,2);
		
		foreach($stmt as $v){
			$list.="<option value='".$v['id']."|".$v['level']."'>".$v['name']."</option>";	
		}	
		return "<select class='{$input_id}_select_change'  autocomplete='off'><option value='0'>-".$language['country']."-</option>$list</select>";
	}	
}

?>