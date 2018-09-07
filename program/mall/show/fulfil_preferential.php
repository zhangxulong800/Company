<?php


function get_use_method_option($arr){
	$list='';
	foreach($arr as $key=>$v){
		$list.='<option value="'.$key.'">'.$v.'</option>';
	}
	return $list;
}

$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$sql="select * from ".self::$table_pre."fulfil_preferential where `shop_id`=".SHOP_ID." order by `min_money` asc";
$r=$pdo->query($sql,2);
$module['data']='';
foreach($r as $v){
	$start_time=get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['start_time']);
	$end_time=get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['end_time']);
	if(time()>$v['end_time']){$state=' ('.self::$language['timeout'].')';}else{$state='';}
	$module['data'].='<fieldset id="f_'.$v['id'].'" class="out_fieldset"><legend>'.self::$language['full'].'<input type="text" class="min_money" value="'.$v['min_money'].'" />'.self::$language['yuan'].$state.' <span class=state></span></legend>
    	<div class=input_line><span class=m_label>'.self::$language['join_goods'].'</span><span class=input_span><select class=join_goods  monxin_value="'.$v['join_goods'].'" ><option value="1">'.self::$language['join_goods_admin'][1].'</option><option value="0">'.self::$language['join_goods_admin'][0].'</option><option value="2">'.self::$language['join_goods_admin'][2].'</option></select> <span class=state></span></span></div>
    	<div class=input_line><span class=m_label>'.self::$language['preferential_start_time'].'</span><span class=input_span><input type="text" id="start_time_'.$v['id'].'" class="start_time" onclick=show_datePicker(this.id,"date") onblur= hide_datePicker() value="'.$start_time.'"  /> <span class=state></span></span></div>
    	<div class=input_line><span class=m_label>'.self::$language['preferential_end_time'].'</span><span class=input_span><input type="text" name="end_time_'.$v['id'].'" id="end_time_'.$v['id'].'" class="end_time" onclick=show_datePicker(this.id,"date") onblur= hide_datePicker() value="'.$end_time.'"  /> <span class=state></span></span></div>
    	
    	<div class=input_line><span class=m_label>'.self::$language['use_method'].'</span><span class=input_span><select class=use_method  monxin_value="'.$v['use_method'].'" ><option value="-1">'.self::$language['please_select'].'</option>'.get_use_method_option(self::$language['use_method_option']).'</select> <span class=state></span></span></div>
        <div class=input_line><span class=m_label>&nbsp;</span><span class=input_span id="use_method_div">
    		<fieldset id="use_method_0" style="display: none;"><legend>'.self::$language['use_method_option'][0].'</legend>
            <div class=input_line><span class=m_label style="width:60px;">'.self::$language['discount_rate'].'</span><span class=input_span><input type="text" class="discount" value="'.$v['discount'].'"  style="width:100px;" /> <span class=state></span></span></div>
            </fieldset>
   
      
    		<fieldset id="use_method_1" style="display:none;"><legend>'.self::$language['use_method_option'][1].'</legend>
            <div class=input_line><span class=m_label style="width:60px;">'.self::$language['decrease'].'</span><span class=input_span><input type="text" class="less_money" value="'.$v['less_money'].'"  style="width:60px;" />'.self::$language['yuan'].' <span class=state></span></span></div>
            </fieldset>
        
        </span></div>
        
        <div class=input_line><span class=m_label>&nbsp;</span><span class=input_span>
        <a href="#" id=submit class="submit">'.self::$language['submit'].'</a> <span class=state></span>
        &nbsp;&nbsp;&nbsp;<a href="#" onclick="return del('.$v['id'].');" class="del">'.self::$language['del'].'</a> <span class=state></span>
        </span></div>
        </fieldset>';
	
}
$module['use_method_option']=get_use_method_option(self::$language['use_method_option']);

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
