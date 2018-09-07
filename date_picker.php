<?php
/*
js 调用示例
src=date_picker.php?request=js&input_id=birthday&callback=submit_hidden&output=date&data=*****&unit=show
params：
	request=请求类型 可以是 js或text
	input_id=选择后，把相关值返回到指定ID的表单元素
	callback=选择后，回调函数
	output=输出类型，可是 date(年月日) 或 time（年月日时分秒）
	data=时间戳（可为空）
	unit=是否显示时间单位，可以是 show 或空
	
	


*/
header('Content-Type:text/html;charset=utf-8');
$config=require_once './config.php';
$language=require_once './language/'.$config['web']['language'].'.php';
require_once './config/functions.php';
$callback=@$_GET['callback'];
$unit=@$_GET['unit'];
if($callback==''){exit;}
$input_id=@$_GET['input_id'];
if($input_id==''){exit;}

$request=@$_GET['request'];
$output=@$_GET['output'];
$data=@$_GET['data'];
$y_start=@$_GET['y_start'];
$y_end=@$_GET['y_end'];
$Y=@$_GET['Y'];
$m=@$_GET['m'];
/*$d=@$_GET['d'];
$H=@$_GET['H'];
$i=@$_GET['i'];
$s=@$_GET['s'];*/

if(is_numeric($data)){
$data=date('Y-m-d-H-i-s',$data);
$data=explode("-",$data);	
}

if($request=='js'){
	$list='';
	$y_start=$y_start?$y_start: date('Y')-50;
	$y_start=$y_start>=1970?$y_start:1970;
	$y_end=$y_end?$y_end: date('Y')+50;
	$y_end=$y_end<=2037?$y_end:2037;
	if(count($data)==6){
		for($i=$y_start;$i<=$y_end;$i++){
			if($data[0]==$i){$selected='selected';}else{$selected='';}
			$list.="<option value='$i' $selected>$i</option>";	
		}
	}else{
		for($i=$y_start;$i<=$y_end;$i++){
			$list.="<option value='$i'>$i</option>";	
		}
	}
	
	$Y_list="<select id='{$input_id}_Y' onchange='{$input_id}_get_days();'><option value='0'>-".$language['Y']."-</option>$list</select>";
	
	$list='';
	
	if(count($data)==6){
		for($i=1;$i<=12;$i++){
			if($data[1]==$i){$selected='selected';}else{$selected='';}
			if($i<10){$temp='0'.$i;}else{$temp=$i;}
			$list.="<option value='$temp' $selected>$temp</option>";	
		}
	}else{
		for($i=1;$i<=12;$i++){
			if($i<10){$temp='0'.$i;}else{$temp=$i;}
			$list.="<option value='$temp'>$temp</option>";	
		}
	}
	
	$m_list="<select id='{$input_id}_m' onchange='{$input_id}_get_days();'><option value='0'>-".$language['m']."-</option>$list</select>";
	
	$list='';
	if(count($data)==6){
		$days = cal_days_in_month(CAL_GREGORIAN, $data[1],$data[0]);
		for($i=1;$i<=$days;$i++){
			if($data[2]==$i){$selected='selected';}else{$selected='';}
			if($i<10){$temp='0'.$i;}else{$temp=$i;}
			$list.="<option value='$temp' $selected>$temp</option>";	
		}
	}else{
		for($i=1;$i<=31;$i++){
			if($i<10){$temp='0'.$i;}else{$temp=$i;}
			$list.="<option value='$temp'>$temp</option>";	
		}
	}
	$d_list="<select id='{$input_id}_d' onchange='{$input_id}_get_days();'><option value='0'>-".$language['d']."-</option>$list</select>";


?>
function <?php echo $input_id;?>_get_days(){
	Y=document.getElementById('<?php echo $input_id;?>_Y');
	m=document.getElementById('<?php echo $input_id;?>_m');
	d=document.getElementById('<?php echo $input_id;?>_d');
    <?php if($output=='time'){echo "h=document.getElementById('".$input_id."_h');\r\n h=document.getElementById('".$input_id."_h');\r\n i=document.getElementById('".$input_id."_i');\r\n s=document.getElementById('".$input_id."_s');";}?>
    //monxin_alert('xx');
    if(Y.value!=0 && m.value!=0 && d.value!=0 <?php if($output=='time'){echo " && h.value!='0' && i.value!='0' && s.value!='0'";}?>){
        v=Y.value+"-"+m.value+"-"+d.value<?php if($output=='time'){echo "+' '+h.value+':'+i.value+':'+s.value";}?>;
        
		<?php 
    /*	if($config['other']['date_style']=='Y-m-d'){echo 'v=Y.value+"-"+m.value+"-"+d.value;';}
        if($config['other']['date_style']=='m-d-Y'){echo 'v=m.value+"-"+d.value+"-"+Y.value;';}
        if($config['other']['date_style']=='d-m-Y'){echo 'v=d.value+"-"+m.value+"-"+Y.value;';}
    */	?>
        
        if($("#<?php echo $input_id;?>").prop('value')==v){return false; }
       // monxin_alert($("#<?php echo $input_id;?>").prop('value')+'=='+v);
        $("#<?php echo $input_id;?>").prop('value',v);
        <?php echo $callback;?>('<?php echo $input_id;?>');
        return false;	
    }	
         if(Y.value==0 || m.value==0 || d.value!=0){return false;}
   
	$("#<?php echo $input_id;?>_d").load('date_picker.php?request=ajax&callback=<?php echo $callback;?>&input_id=<?php echo $input_id;?>&Y='+Y.value+'&m='+m.value,function(){
    //monxin_alert($("#<?php echo $input_id;?>_day").html());
    });
        

}

<?php
//echo $config['other']['date_style'];

if($unit=='show'){
	$Y_list.=$language['Y'];
	$m_list.=$language['m'];
	$d_list.=$language['d'];
	
}


if($config['other']['date_style']=='Y-m-d'){
	echo 'document.write("'.$Y_list.$m_list.$d_list.'");';
}
if($config['other']['date_style']=='m-d-Y'){
	echo 'document.write("'.$m_list.$d_list.$Y_list.'");';
}
if($config['other']['date_style']=='d-m-Y'){
	echo 'document.write("'.$d_list.$m_list.$Y_list.'");';
}
if($output=='time'){
	$list='';
	if(count($data)==6){
		for($i=0;$i<24;$i++){
			if($data[3]==$i){$selected='selected';}else{$selected='';}
			if($i<10){$temp='0'.$i;}else{$temp=$i;}
			$list.="<option value='$temp' $selected>$temp</option>";	
		}
	}else{
		for($i=0;$i<=23;$i++){
			if($i<10){$temp='0'.$i;}else{$temp=$i;}
			$list.="<option value='$temp'>$temp</option>";	
		}
	}
	$h_list="<select id='{$input_id}_h' onchange='{$input_id}_get_days();'><option value='0'>-".$language['h']."-</option>$list</select>";
	
	$list='';
	if(count($data)==6){
		for($i=0;$i<60;$i++){
			if($data[4]==$i){$selected='selected';}else{$selected='';}
			if($i<10){$temp='0'.$i;}else{$temp=$i;}
			$list.="<option value='$temp' $selected>$temp</option>";	
		}
	}else{
		for($i=0;$i<60;$i++){
			if($i<10){$temp='0'.$i;}else{$temp=$i;}
			$list.="<option value='$temp'>$temp</option>";	
		}
	}
	$i_list="<select id='{$input_id}_i' onchange='{$input_id}_get_days();'><option value='0'>-".$language['i']."-</option>$list</select>";


	
	$list='';
	if(count($data)==6){
		for($i=0;$i<60;$i++){
			if($data[5]==$i){$selected='selected';}else{$selected='';}
			if($i<10){$temp='0'.$i;}else{$temp=$i;}
			$list.="<option value='$temp' $selected>$temp</option>";	
		}
	}else{
		for($i=0;$i<60;$i++){
			if($i<10){$temp='0'.$i;}else{$temp=$i;}
			$list.="<option value='$temp'>$temp</option>";	
		}
	}
	$s_list="<select id='{$input_id}_s' onchange='{$input_id}_get_days();'><option value='0'>-".$language['s']."-</option>$list</select>";

	if($unit=='show'){
		$h_list.=$language['h'];
		$i_list.=$language['i'];
		$s_list.=$language['s'];
		
	}


	
	echo 'document.write("'.$h_list.$i_list.$s_list.'");';
		
}

		
	exit();
}

if($request=='ajax'){
	$list='';
	$days = cal_days_in_month(CAL_GREGORIAN, $m,$Y);
	for($i=1;$i<=$days;$i++){
		$list.="<option value='$i'>$i</option>";	
	}
	
	echo "<option value='0'>".$language['d']."</option>$list";	
	exit();
}

if($request=='text' && $_GET['data']!=''){
echo "document.write('".date($config['other']['date_style'],$_GET['data'])."');";
	
}




?>