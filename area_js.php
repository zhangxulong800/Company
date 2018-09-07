<?php 
header('Content-Type:text/html;charset=utf-8');
$config=require_once './config.php';
$language=require_once './language/'.$config['web']['language'].'.php';
require_once './config/functions.php';
$pdo=new  ConnectPDO();

$id=@$_GET['id'];
$id=is_numeric($id)?$id:0;

$callback=@$_GET['callback'];
if($callback==''){exit;}
$input_id=@$_GET['input_id'];
$output=@$_GET['output'];
if($input_id==''){exit;}
if($output==''){exit;}

if($output=='select'){
?>
$(document).ready(function(){

	$("<span id=<?php echo $input_id;?>_area_level_7></span>").insertAfter("#<?php echo $input_id;?>_area_js");
	$("<span id=<?php echo $input_id;?>_area_level_6></span>").insertAfter("#<?php echo $input_id;?>_area_js");
	$("<span id=<?php echo $input_id;?>_area_level_5></span>").insertAfter("#<?php echo $input_id;?>_area_js");
	$("<span id=<?php echo $input_id;?>_area_level_4></span>").insertAfter("#<?php echo $input_id;?>_area_js");
	$("<span id=<?php echo $input_id;?>_area_level_3></span>").insertAfter("#<?php echo $input_id;?>_area_js");
	$("<span id=<?php echo $input_id;?>_area_level_2></span>").insertAfter("#<?php echo $input_id;?>_area_js");
	$("<span id=<?php echo $input_id;?>_area_level_1></span>").insertAfter("#<?php echo $input_id;?>_area_js");
	
    <?php
	$top_id=0;
    if($id!=0){
		//echo $input_id."_get_area_list(0,1);";
		$flag=true;
		$list='';
		$v['upid']=$id;
		
		while($flag){
			$sql="select `upid`,`id`,`level` from ".$pdo->index_pre."area where `id`='".$v['upid']."' order by `sequence` desc,`id` asc";
			$v=$pdo->query($sql,2)->fetch(2);
			//if($v['id']==''){exit;}
			if($v['id']!=''){
				if($v['upid']>0){
					$list=$input_id."_get_area_list(".$v['id'].",".($v['level']+1).");".$list;
				}else{
					$flag=false;
					$sql="select `upid`,`id`,`level` from ".$pdo->index_pre."area where `id`='".$v['id']."' order by `sequence` desc,`id` asc";
					$v=$pdo->query($sql,2)->fetch(2);
					$list=$input_id."_get_area_list(".$v['id'].",".($v['level']+1).");".$list;
					if($v['upid']==0){
						$top_id=$v['id'];
					}
					$list=$input_id."_get_area_list(".$v['upid'].",".($v['level']).");".$list;
					
				}
			}else{
				$list=$input_id."_get_area_list(0,1);".$list;
				$flag=false;
			}
			//echo $v['upid'].'<hr />';
		}
		echo $list;
		
				
	}else{
		echo $input_id."_get_area_list(0,1);";
	}
	?>
    	
      	$(document).on("change",".<?php echo $input_id;?>_select_change",function(){
      	//$(".<?php echo $input_id;?>_select_change").on("change",function(){
        	//alert('xx');
        	v=$(this).prop('value').split('|');
        	<?php echo $input_id;?>_get_area_list(v[0],parseInt(v[1])+1);
        });
        
        setTimeout("<?php echo $input_id;?>_set_top_value()",600);  
});

function <?php echo $input_id;?>_set_top_value(){
    $("#<?php echo $input_id;?>_area_level_1 select").prop('value','<?php echo $top_id?>|1');
    //alert( $("#<?php echo $input_id;?>_area_level_1 select").prop('value'));
}


function <?php echo $input_id;?>_exe_selected(v){
    //monxin_alert(v);
    level=v.split("|");
    level=level[1];
   $("#<?php echo $input_id;?>_area_level_"+level+" option[value='"+v+"']").prop("selected",true);
    
}

function <?php echo $input_id;?>_get_area_list(id,level){
	if(level=='<?php echo @$_GET['level']?>'){
    	try{<?php echo $callback;?>('<?php echo $input_id;?>',id);}catch(e){}
         v=id+'|'+(level-1);
        setTimeout("<?php echo $input_id;?>_exe_selected('"+v+"')",400);  
		return false;
    }
    $("#<?php echo $input_id;?>_state").html('');
	$("#<?php echo $input_id;?>_area_level_"+level).load('area.php?output=select&input_id=<?php echo $input_id;?>&id='+id,function(){
    	if($("#<?php echo $input_id;?>_area_level_"+level).html()==''){
       	// monxin_alert('callback');
      	try{<?php echo $callback;?>('<?php echo $input_id;?>',id);}catch(e){}
        }
         v=id+'|'+(level-1);
        setTimeout("<?php echo $input_id;?>_exe_selected('"+v+"')",200);  
    });

    for(var i=8;i>level;i--){
    	$("#<?php echo $input_id;?>_area_level_"+i).html('');
    }
  
}
<?php }
if($output=='text' && $id>0){	
class area_text{
	function __construct($id){
		global $pdo,$input_id,$language;
		$list='';
		$flag=true;
		$v['upid']=$id;
		while($flag){
			
			$sql="select `upid`,`name`,`id` from ".$pdo->index_pre."area where `id`='".$v['upid']."' order by `sequence` desc,`id` asc";
			$v=$pdo->query($sql,2)->fetch(2);
			$list=$v['name']." ".$list;
			if($v['upid']==0){$flag=false;}
		}
		$list="document.write('$list');";	
		
		echo $list;
	}
	
}
new area_text($id);	
}


if($output=='text2' && $id>0){	
class area_text2{
	function __construct($id){
		global $pdo,$input_id,$language;
		$list='';
		$flag=true;
		$v['upid']=$id;
		while($flag){
			
			$sql="select `upid`,`name`,`id` from ".$pdo->index_pre."area where `id`='".$v['upid']."' order by `sequence` desc,`id` asc";
			$v=$pdo->query($sql,2)->fetch(2);
			$list=$v['name']." ".$list;
			if($v['upid']==0){$flag=false;}
		}
		echo $list;
		exit();
	}
	
}
new area_text2($id);	
}

?>