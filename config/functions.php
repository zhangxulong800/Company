<?php
ini_set('session.save_path', dirname(__FILE__).'/session/');
//ini_set('session.gc_maxlifetime', "60"); // 秒  
//ini_set("session.cookie_lifetime","60"); // 秒 
//ini_set('session.cookie_lifetime', 18000);
//ini_set('session.gc_probability', 1);
//ini_set('session.gc_divisor', 1);
	function decrese_module_size($v,$number){
		$temp=explode('%',$v);
		if(isset($temp[1])){
			return ($temp[0]-1).'%';	
		}else{
			return ($temp[0]-$number).'px';
		}
	}
	function add_module_size($v,$number){
		$temp=explode('%',$v);
		if(isset($temp[1])){
			return ($temp[0]+1).'%';	
		}else{
			return ($temp[0]+$number).'px';
		}
	}

//正则提取邮箱（PHP代码/函数）	
function get_email_account($str){ 
	preg_match_all('/[a-zA-Z0-9_\.]+@[a-zA-Z0-9-]+[\.a-zA-Z]+/',$str,$r);
	$r=array_unique($r['0']);
	return $r; 
} 

//正则提取手机号（PHP代码/函数）	
function get_phone_account($str){ 
	preg_match_all('/1[0-9]{10}/',$str,$r);
	$r=array_unique($r['0']);
	return $r; 
} 

//判断mysql字段是否存在（PHP代码/函数）	
function field_exist($pdo,$table,$field){
	$exist=false;
	$sql="select `$field` from ".$table." limit 0,1";
	$r=$pdo->query($sql);
	if($pdo->errorCode()==00000){$exist=true;}
	return $exist;
}

//获取图片水印位置下接框（PHP代码/函数）	
function get_image_mark_option($v,$language){
	if($v){
		$option='<option value="1" selected>'.$language['yes'].'</option><option value="0">'.$language['no'].'</option>';
	}else{
		$option='<option value="1">'.$language['yes'].'</option><option value="0"  selected>'.$language['no'].'</option>';
	}
	return $option;
}

//判断访问设备是手机还是电脑（PHP代码/函数）	
function isMobile(){  
	$useragent=isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';  
	$useragent_commentsblock=preg_match('|\(.*?\)|',$useragent,$matches)>0?$matches[0]:'';  	  
	function CheckSubstrs($substrs,$text){  
		foreach($substrs as $substr)  
			if(false!==strpos($text,$substr)){  
				return true;  
			}  
			return false;  
	}
	$mobile_os_list=array('Google Wireless Transcoder','Windows CE','WindowsCE','Symbian','Android','armv6l','armv5','Mobile','CentOS','mowser','AvantGo','Opera Mobi','J2ME/MIDP','Smartphone','Go.Web','Palm','iPAQ');
	$mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160×160','176×220','240×240','240×320','320×240','UP.Browser','UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','iPod');  
		  
	$found_mobile=CheckSubstrs($mobile_os_list,$useragent_commentsblock) ||  
			  CheckSubstrs($mobile_token_list,$useragent);  
		  
	if ($found_mobile){  
		return true;  
	}else{  
		return false;  
	}  
}



function stripslashes_deep($value) {
	 //$value=is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value); 
	 //return trim($value);
	if(!is_array($value)){
		$r=stripslashes($value);
	}else{
		$r=array();
		foreach($value as $key=>$v){
			$r[$key]=stripslashes($v);
		}		
	}
	
	return $r;
}
	 

function __autoload($className){
	$path='./lib/'.$className.'.class.php';
	if(file_exists($path)){require_once $path;}else{exit('Class <b>'.$className.'</b> not exists');}
	

	}

//正则判断是否邮箱email（PHP代码/函数）	
function is_email($email){ 
	$pattern="/^([\w\.-]+)@([a-zA-Z0-9-]+)(\.[a-zA-Z\.]+)$/i";//包含字母、数字、下划线_和点.的名字的email 
	if(preg_match($pattern,$email)){ 
		return true; 
	}else{ 
		return false; 
	} 
} 

//获取访问者IP（PHP代码/函数）	
function get_ip(){
	if(getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown")){
	  $ip=getenv("HTTP_CLIENT_IP");
	}else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"),"unknown")){
	  $ip=getenv("HTTP_X_FORWARDED_FOR");
	}else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"),"unknown")){
	  $ip=getenv("REMOTE_ADDR");
	}else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'],"unknown")){
	  $ip=$_SERVER['REMOTE_ADDR'];
	}else{
	  $ip="unknown" ;  
	}
	return safe_str($ip,1,0);  
}

//判断是否URL网址（PHP代码/函数）	
function is_url($v){
	$pattern="#(http|https)://(.*\.)?.*\..*#i";
	if(preg_match($pattern,$v)){ 
		return true; 
	}else{ 
		return false; 
	} 
}

//翻页（PHP代码/函数）	
function MonxinDigitPage($sum,$current_page,$page_size,$touch_id='',$page_template='当前：第 <span class=set_page></span> 页，共{max_page}页,{sum}条数据'){
	//$sum=1000;
	$page_sum=ceil($sum/$page_size);
	if($page_sum==1){return '';}
	$min_page=max($current_page-4,1);
	$max_page=min($current_page+4,$page_sum);
	if($current_page<5){$max_page=min($min_page+8,$page_sum);}
	if(($current_page+4)>$page_sum){$min_page=max($max_page-8,1);}
	
	$page_list='';
	
	
	for($i=$min_page;$i<=$max_page;$i++){
		if($i<10){
			$page_list.="<li class='paginate_button'><a href='".replace_get('current_page',$i)."' id='page_".$i."' class='page_1'>{$i}</a></li>";
		}elseif($i<100){
			$page_figure=2;
			$page_list.="<li class='paginate_button'><a href='".replace_get('current_page',$i)."' id='page_".$i."' class='page_2'>{$i}</a></li>";	
		}else{
			$page_figure=3;
			$page_list.="<li class='paginate_button'><a href='".replace_get('current_page',$i)."' id='page_".$i."' class='page_3'>{$i}</a></li>";
		}
		
			
	}
	if($current_page<10){$page_figure=1;}elseif($current_page<100){$page_figure=2;}else{$page_figure=3;}
	$page_list="<li class='paginate_button'><a href='".replace_get('current_page',max($current_page-1,1))."' id=page_pre><i class='fa fa-angle-left'></i></a></li>".$page_list."<li class='paginate_button'><a href='".replace_get('current_page',min($current_page+1,$page_sum))."' id=page_next><i class='fa fa-angle-right'></i></a></li>";
	
	$list="<div class='dataTables_paginate paging_simple_numbers'><ul class='pagination' id='MonxinDigitPage' user_color='page'>{$page_list}</ul></div>";
	$touch_event='';
	if($touch_id!=''){
		$touch_event="		
		if(touchAble){
			//$('".$touch_id."').attr('ontouchstart','set_touch_start(event)');
			//$('".$touch_id."').attr('ontouchmove','exe_touch_move(event,\"monxin_page_go\")');
		}
";	
	}
	
	$list.="<script>
$(document).ready(function(){
	$('#MonxinDigitPage #page_".$current_page."').parent().addClass('active');
	$('#current_page').prop('value','".$current_page."');
	$('#current_page').change(function(){
		id=$(this).attr('id');
		page_go(id);	
	});	
	$('#page_size').change(function(){
		id=$(this).attr('id');
		page_go(id);	
	});	
		".$touch_event."
		$(document).keydown(function(event){
			if(event.keyCode==37 && event.target.tagName!='INPUT' && event.target.tagName!='TEXTAREA'){monxin_page_go('left');}			  	
			if(event.keyCode==39 && event.target.tagName!='INPUT' && event.target.tagName!='TEXTAREA'){monxin_page_go('right');}			  	
		});		
	
});
function page_go(id){
			url=window.location.href;
			url=replace_get(url,id,$('#'+id).prop('value'));
			if(id=='page_size'){url=replace_get(url,'current_page',1);}
			//monxin_alert(url);
			window.location.href=url;	
}
	function monxin_page_go(v){
		url=window.location.href;
		c_page=get_param('current_page');
		if(c_page==''){c_page=1;}
		if(v!='left' && v!='right'){return false;}
		if(v=='left'){
			url=replace_get(url,'current_page',Math.max(1,c_page-1));
		}else{
			url=replace_get(url,'current_page',Math.min(".$page_sum.",parseInt(c_page)+1));
		}
		window.location.href=url;	
	}

</script>
";
	if($page_sum<2){return '';}
	if($current_page==1){$start=1;}else{$start=($current_page-1)*$page_size;}
	$temp=str_replace('{start}',1,$page_template);
	$temp=str_replace('{end}',$current_page*$page_size,$temp);
	$temp=str_replace('{max_page}',$page_sum,$temp);
	$temp=str_replace('{sum}',$sum,$temp);
	$temp=str_replace('{current_page}',$current_page,$temp);
	$list='<div class=page_row page_size='.$page_size.' max_page='.$page_sum.' current_page='.$current_page.'><div>'.$temp.'</div><div>'.$list.'</div></div>';	
	return $list;
}


//替换GET参数（PHP代码/函数）	
function replace_get($key,$v){
	$url=GetCurUrl();
	$temp=explode("&",$url);
	if(count($temp)==1){
		$symbol="?";
		$temp=explode("?",$url);
		if(count($temp)==1){return $url."?".$key."=".urlencode($v);}
	}else{
		$symbol="&";
	}
	$url='';
	for($i=0;$i<count($temp);$i++){
		$temp2=explode("=",$temp[$i]);
		if($temp2[0]!=$key){$url.=$temp[$i].$symbol;}
	}
	$url=trim($url,$symbol);
	$url.="&".$key."=".urlencode($v);
	return $url;
}

//获取当前网址URL（PHP代码/函数）	
function GetCurUrl(){ 
	if(!empty($_SERVER["REQUEST_URI"])){ 
		$scriptName=$_SERVER["REQUEST_URI"]; 
		$nowurl=$scriptName; 
	}else{ 
		$scriptName=$_SERVER["PHP_SELF"]; 
		if(empty($_SERVER["QUERY_STRING"])) { 
			$nowurl=$scriptName; 
		}else{ 
			$nowurl=$scriptName."?".$_SERVER["QUERY_STRING"]; 
		} 
	} 
	return $nowurl; 
} 

//获取选项ID Monxin专用（PHP代码/函数）		
function get_select_id($pdo,$type,$v){
	$sql="select * from ".$pdo->index_pre."select where `type`='$type'";
	$stmt=$pdo->query($sql,2);
	$temp=$v;
	//$module[$type]="<option value=''></option>";
	$module[$type]="";
	foreach($stmt as $v){
		if($temp==$v['id']){$selected='selected';}else{$selected='';}
		$module[$type].="<option value='".$v['id']."' $selected >".$v['name']."</option>";	
	}
	return $module[$type];			
}

//获取选项value Monxin专用（PHP代码/函数）		
function get_select_value($pdo,$type,$v){
	$sql="select * from ".$pdo->index_pre."select where `type`='$type'";
	$stmt=$pdo->query($sql,2);
	$temp=$v;
	//$module[$type]="<option value=''></option>";
	$module[$type]="";
	foreach($stmt as $v){
		if($temp==$v['value']){$selected='selected';}else{$selected='';}
		$module[$type].="<option value='".$v['value']."' $selected >".$v['name']."</option>";	
	}
	return $module[$type];			
}

//获取用户组选项option Monxin专用（PHP代码/函数）	）	
function get_group($pdo,$v){
	$sql="select `id`,`name` from ".$pdo->index_pre."group order by `sequence` desc";
	$stmt=$pdo->query($sql,2);
	$temp=$v;
	$list='';
	foreach($stmt as $v){
		if($temp==$v['id']){$selected='selected';}else{$selected='';}
		$list.="<option value='".$v['id']."' $selected >".$v['name']."</option>";	
	}
	return $list;			
}

//获取用户账户状态 Monxin专用（PHP代码/函数）	
function get_user_state($language,$user_state){
	$list='';
	foreach($language['user_state'] as $key=>$v){
		if($key==$user_state){$selected='selected';}else{$selected='';}
		$list.="<option value='".$key."' $selected >".$v."</option>";	
	}
	return $list;			
}

//获取选项值 Monxin专用（PHP代码/函数）		
function get_select_txt($pdo,$v){
	$sql="select `name` from ".$pdo->index_pre."select where `id`='$v'";
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['name'];			
}

//获取模板所在目录 Monxin专用（PHP代码/函数）		
function get_template_dir($path){
	$t=str_replace(DIRECTORY_SEPARATOR,"/",$path);
	//echo $t;
	$t=explode("templates/",$t);
	$t=explode("/",$t[1]);
	$dir='';
	for($i=0;$i<count($t)-1;$i++){$dir.=$t[$i]."/";}
	return "templates/".$dir;	
}

//获取monxin_table.css路径 Monxin专用（PHP代码/函数）		
function get_monxin_table_css_dir($path){
	$t=str_replace(DIRECTORY_SEPARATOR,"/",$path);
	//echo $t;
	$t=explode("templates/",$t);
	$t=explode("/",$t[1]);
	$dir='';
	for($i=0;$i<count($t)-1;$i++){$dir.=$t[$i]."/";}
	$dir="./templates/".$dir;
	if(file_exists($dir.'monxin_table.css')){
		return $dir;	
	}else{
		$dir='./templates/index/'.$t[count($t)-3].'/'.$t[count($t)-2];
		if(file_exists($dir.'/monxin_table.css')){
			return $dir;
		}else{
			return './templates/index/default/'.$t[count($t)-2];
		}
	}
}

//获取monxin_table.js 路径 Monxin专用（PHP代码/函数）		
function get_monxin_table_js_dir($path){
	$t=str_replace(DIRECTORY_SEPARATOR,"/",$path);
	//echo $t;
	$t=explode("templates/",$t);
	$t=explode("/",$t[1]);
	$dir='';
	for($i=0;$i<count($t)-1;$i++){$dir.=$t[$i]."/";}
	$dir="./templates/".$dir;
	if(file_exists($dir.'monxin_table.js')){
		return $dir;	
	}else{
		$dir='./templates/index/'.$t[count($t)-3].'/'.$t[count($t)-2];
		if(file_exists($dir.'/monxin_table.js')){
			return $dir;
		}else{
			return './templates/index/default/'.$t[count($t)-2];
		}
	}
}

//获取用户名 Monxin专用（PHP代码/函数）		
function get_username($pdo,$id){
	$sql="select `username` from ".$pdo->index_pre."user where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['username'];	
}

//检测用户名是否存在 Monxin专用（PHP代码/函数）		
function check_username($pdo,$username){
	$sql="select count(id) as c from ".$pdo->index_pre."user where `username`='$username'";
	$r=$pdo->query($sql)->fetch(2);	
	if($r['c']==1){return true;}else{return false;}
}

//获取用户真实姓名 Monxin专用（PHP代码/函数）		
function get_real_name($pdo,$id){
	$sql="select `real_name` from ".$pdo->index_pre."user where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['real_name'];	
}

//获取用户ID Monxin专用（PHP代码/函数）		
function get_user_id($pdo,$username){
	$sql="select `id` from ".$pdo->index_pre."user where `username`='$username'";
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['id'];	
}

//获取用户呢称 Monxin专用（PHP代码/函数）		
function get_nickname($pdo,$id){
	$sql="select `nickname` from ".$pdo->index_pre."user where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['nickname'];	
}

//获取用户所在用户组名称 Monxin专用（PHP代码/函数）		
function get_user_group_name($pdo,$username){
	$sql="select `group` from ".$pdo->index_pre."user where `username`='$username'";
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="select `name` from ".$pdo->index_pre."group where `id`='".$r['group']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['name'];	
}

//格式化模板调用参数 返回数组 Monxin专用（PHP代码/函数）			
function format_attribute($args){
	$args=trim($args,'(');
	$args=trim($args,')');
	$temp=explode('|',$args);
	$attribute=array();
	foreach($temp as $v){
		$temp2=explode(':',$v);
		$attribute[$temp2[0]]=@$temp2[1];
		if($temp2[0]=='field'){
			$temp3=explode('/',@$temp2[1]);
			$temp4='';
			foreach($temp3 as $v3){
				$temp4.='`'.$v3.'`,';	
			}
			$temp4=trim($temp4,',');	
			$attribute[$temp2[0]]=$temp4;
		}
	}
	return $attribute;
}

//格式化字段 Monxin专用（PHP代码/函数）		
function get_field_array($v){
	$v=str_replace('`','',$v);
	$v=explode(',',$v);
	return $v;
}

//格式化字段为checkbox Monxin专用（PHP代码/函数）		
function get_field_checkbox($checked,$all){
	$checked=str_replace('`','',$checked);
	$checked=explode(',',$checked);
	$checkbox='';
	foreach($all as $key=>$v){
		$state='';
		foreach($checked as $v2){
			if($v2==$key){$state='checked';break;}	
		}
		$checkbox.='<input type="checkbox" id="field[]" name="field[]" field=field value="'.$key.'" '.$state.' /> <span>'.$v.'</span> ';				
	}
	return $checkbox;
}

//是否匹配 正则（PHP代码/函数）		
function is_match($reg,$str){
	@preg_match($reg,$str,$r);
	return (isset($r[0]))?true:false;
}

//返回所有匹配结果 正则（PHP代码/函数）		
function get_match_all($reg,$str){
	preg_match_all($reg,$str,$r);
	//var_dump($r);
	return @$r[1];
}

//返回单个匹配结果 正则（PHP代码/函数）
function get_match_single($reg,$str){
	@preg_match($reg,$str,$r);
	return @$r[1];
}

//正则提取内容图片路径 Monxin专用（PHP代码/函数）		
function reg_attachd_img($act,$class_name,$imgs,$pdo,$image_mark=''){
	//var_dump($imgs);
	if($act=='add'){
		$config=require("./program/{$class_name}/config.php");
		$image=new image();
		
		
		$image_mark=($image_mark==='')?$config['program']['imageMark']:$image_mark;
		//var_dump($image_mark);
		foreach($imgs as $v){
			$sql="select count(id) as c from ".$pdo->index_pre."attachd_img where `path`='$v'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['c']==0){
				$sql="insert into ".$pdo->index_pre."attachd_img (`path`) values ('$v')";
				$pdo->exec($sql);
				resize_big_image($image,$v);
				if($image_mark){$image->addMark($v);}
			}	
		}
	}
	if($act=='del'){
		//var_dump($imgs);
		if(!is_array($imgs)){
			$temp=explode('.',$imgs);
			if(strtolower($temp[count($temp)-1])=='php'){return false;}
			$sql="delete from ".$pdo->index_pre."attachd_img where `path`='$imgs'";
			$pdo->exec($sql);
			@safe_unlink($imgs);
		}else{
	 		foreach($imgs as $v){
				$temp=explode('.',$v);
				if(strtolower($temp[count($temp)-1])=='php'){continue;}
				$sql="delete from ".$pdo->index_pre."attachd_img where `path`='$v'";
				$pdo->exec($sql);
				@safe_unlink($v);	
			}	
		}
	}
}

function resize_big_image($image,$v){
	$width=1920;
	$info=$image->getInfo($v);
	//file_put_contents('t.txt',$info['width']);
	if($info['width']<$width){return true;}
	$zoom=$width/$info['width'];
	$height=$info['height']*$zoom;
	$image->thumb($v,$v,$width,$height);	
}


//PHP过虑禁用字符，入数据库前（PHP代码/函数）		
function safe_str($str,$replace_script=true,$allow_html=true){
	$array=array('receive.php','select','insert','update','delete','union','into','load_file','outfile','@SQL');
	if(!is_array($str)){
		foreach($array as $v){
			$str=preg_replace("#({$v})#iU","-\${1}-",$str);	
		}
		//$str=preg_replace("![][xX]([A-Fa-f0-9])!","x \${1}",$str);`
		$str=str_replace("'",'&#39;',$str);
		$str=str_replace('"','&#34;',$str);
		$str=str_replace("--",'- - ',$str);
		$str=str_replace("\*",'\-*',$str);
		$str=str_replace("\\",'monxin_backslash',$str);
		if($replace_script){
			$str = preg_replace("/<script/iUs", "<monxin_script", $str); 
			$str = preg_replace("/script>/iUs", "monxin_script>", $str); 
		}
		if(!$allow_html){$str=htmlspecialchars($str);}
		$r=$str;
	}else{
		$r=array();
		foreach($str as $key=>$value){
			//$key=safe_str($key);
			$r[$key]=safe_str($value,$replace_script,$allow_html);
		}		
	}
	
	return $r;
}

//PHP还原禁用字符，出数据库后（PHP代码/函数）		
function de_safe_str($str){
	$array=array('receive.php','select','insert','update','delete','union','into','load_file','outfile','@SQL','0x');
	if(!is_array($str)){
		foreach($array as $v){
			$str=preg_replace("#-({$v})-#i","\${1}",$str);	
		}
		//$str=preg_replace("![][xX]([A-Fa-f0-9])!","x \${1}",$str);
		$str=str_replace("&#39;","'",$str);
		$str=str_replace('&#34;','"',$str);
		$str=str_replace('- - ',"--",$str);
		$str=str_replace("\-*",'\*',$str);
		
		$str=str_replace('monxin_backslash',"\\",$str);
		$r=$str;
	}else{
		$r=array();
		foreach($str as $key=>$value){
			//$key=de_safe_str($key);
			$r[$key]=de_safe_str($value);
		}		
	}
	return $r;
}

//按年月日创建目录（PHP代码/函数）		
function get_date_dir($path){
	$path=trim($path,"/")."/";
	$Y=date("Y");
	$m=date("m");
	$d=date("d");
	if(!is_dir($path.$Y."_".$m)){mkdir($path.$Y."_".$m);}
	if(!is_dir($path.$Y."_".$m."/".$d)){mkdir($path.$Y."_".$m."/".$d);}
	return $path.$Y."_".$m."/".$d."/";	
}

//获取地区选项option Monxin专用（PHP代码/函数）		
function get_area_option($pdo,$upid){
	$sql="select `id`,`name` from ".$pdo->index_pre."area where `upid`='$upid' order by `sequence` desc,`id` asc";	
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$list.='<option value="'.$v['id'].'">'.$v['name'].'</option>';	
	}
	return $list;
}

//获取地区 a 标签 位置	 	
function get_area_a_position($pdo,$upid,$url){
	if($upid==0){return '';}
	$sql="select `upid`,`name`,`id` from ".$pdo->index_pre."area where `id`=".$upid;
	$r=$pdo->query($sql,2)->fetch(2);
	$list='<a href="'.$url.$r['id'].'">'.de_safe_str($r['name']).'</a>';
	$max=8;
	for($i=0;$i<$max;$i++){
		if($r['upid']!=0){
			$sql="select `upid`,`name`,`id` from ".$pdo->index_pre."area where `id`=".$r['upid'];
			$r=$pdo->query($sql,2)->fetch(2);
			$list='<a href="'.$url.$r['id'].'">'.de_safe_str($r['name']).'</a>'.$list;
		}
	}
	return $list;
}
//获取地区 a 标签 位置	 	
function get_area_parent_ids($pdo,$id){
	if($id==0){return '';}
	$list=$id.',';
	$sql="select `upid`,`name`,`id` from ".$pdo->index_pre."area where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	$list.=$r['upid'].',';
	$max=8;
	for($i=0;$i<$max;$i++){
		if($r['upid']!=0){
			$sql="select `upid`,`name`,`id` from ".$pdo->index_pre."area where `id`=".$r['upid'];
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['upid']!=0){$list.=$r['upid'].',';}
			
		}
	}
	return $list;
}

//获取地区选项ids Monxin专用（PHP代码/函数）		
function get_area_ids($pdo,$id){
	$sql="select `id` from ".$pdo->index_pre."area where `upid`='$id'";
	$r=$pdo->query($sql,2);
	$ids=$id.',';
	foreach($r as $v){
		$ids.=$v['id'].',';
		$sql2="select count(id) as c from ".$pdo->index_pre."area where `upid`='".$v['id']."'";	
		$r2=$pdo->query($sql2,2)->fetch(2);
		if($r2['c']>0){$ids.=get_area_ids($pdo,$v['id']);}
	}
	return $ids;
	
}

//获取年份选项option（PHP代码/函数）		
function get_year_option($year_range){
	$list='';
	$year_range=explode("-",$year_range);
	//var_dump($year_range);
	$start=intval($year_range[0]);
	$end=intval($year_range[1]);
	for($i=$start;$i<=$end;$i++){
		$list.='<option value="'.$i.'">'.$i.'</option>';	
	}
	return $list;	
}

//获取月份选项option（PHP代码/函数）		
function get_month_option(){
	$list='';
	for($i=1;$i<13;$i++){
		$list.='<option value="'.$i.'">'.$i.'</option>';	
	}
	return $list;	
}

//获取天数选项option（PHP代码/函数）		
function get_day_option($year,$month){
	$list='';
	for($i=1;$i<get_days($year,$month)+1;$i++){
		$list.='<option value="'.$i.'">'.$i.'</option>';	
	}
	return $list;	
}

//获取指定年月的天数（PHP代码/函数）		
function get_days($year,$month){
	return cal_days_in_month(CAL_GREGORIAN,$month,$year);
}

//获取地区名称 Monxin专用（PHP代码/函数）		
function get_area_name($pdo,$id){
	$list='';
	$flag=true;
	$v['upid']=$id;
	while($flag){
		
		$sql="select `upid`,`name`,`id` from ".$pdo->index_pre."area where `id`='".$v['upid']."'";
		$v=$pdo->query($sql,2)->fetch(2);
		$list=$v['name']." ".$list;
		if($v['upid']==0){$flag=false;}
	}
	return $list;
}

//16进制转RGB （PHP代码/函数）		
function hex2rgb($hex){
	$hex=str_replace('#','',$hex);
	$length=strlen($hex);
	$rgb='';
	if($length==3){
		$rgb.=hexdec($hex[0].$hex[0]).',';
		$rgb.=hexdec($hex[1].$hex[1]).',';
		$rgb.=hexdec($hex[2].$hex[2]);
	}
	if($length==6){
		$rgb.=hexdec($hex[0].$hex[1]).',';
		$rgb.=hexdec($hex[2].$hex[3]).',';
		$rgb.=hexdec($hex[4].$hex[5]);
	}
	return $rgb;
}


//转换文件大小单位 （PHP代码/函数）		
function format_size($fileSize){
	if(!$fileSize){return false;}           
	$size=sprintf("%u ",$fileSize);           
	if($size==0){return( "0 Bytes ");}           
	$sizename=array( "Bytes","KB ","MB","GB","TB","PB","EB","ZB","YB");         
	return round($size/pow(1024,($i=floor(log($size,1024)))),2).$sizename[$i];   
}   

//查询可用短信余额 Monxin专用（PHP代码/函数）		
function inquiry_available_SMS($config){
	$ctx=stream_context_create(array('http'=>array('timeout'=>30)));
		$param='';
		if($config['sms']['inquiry_method']=='GET'){
			$param.="&".$config['sms']['username_field']."=".$config['sms']['username'];
			$param.="&".$config['sms']['password_field']."=".$config['sms']['password'];
			$ctx=stream_context_create(array('http'=>array('timeout'=>30)));
			if(strpos($config['sms']['available_url'],"?")==false){
				$url=$config['sms']['available_url']."?".trim($param,"&");	
			}else{
				$url=$config['sms']['available_url'].$param;	
			}
			$ctx=stream_context_create(array('http'=>array('timeout'=>30)));
			//echo $url;
			$state=@file_get_contents($url,false,$ctx);
			$state=iconv($config['sms']['server_charset'],"utf-8",$state);
			$state=trim($state);
			return $state;
			//var_dump(strpos($state,$config['sms']['success_val']));
			
		}else{
			$post_data=array();  
			$post_data[$config['sms']['username_field']]=$config['sms']['username'];  
			$post_data[$config['sms']['password_field']]=$config['sms']['password'];  
			$o="";  
			foreach ($post_data as $k=>$v){$o.= "$k=".urlencode($v)."&";}  
			$post_data=substr($o,0,-1);  
			$ch=curl_init();  
			curl_setopt($ch, CURLOPT_POST, 1);  
			curl_setopt($ch, CURLOPT_HEADER, 0);  
			curl_setopt($ch, CURLOPT_URL,$config['sms']['available_url']);  
			//为了支持cookie  
			curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');  
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);  
			$state=curl_exec($ch);  
			
			//echo ",".$state;
			$state=iconv($config['sms']['server_charset'],"utf-8",$state);
			$state=trim($state);
			return $state;
		}
}
	
function yunpian_sms($config,$apikey,$mobile,$text){
	if(mb_strlen($text)<10){
		$temp=explode('+',$mobile);
		if(isset($temp[1])){
			//file_put_contents('sms.txt',$config['reg_set']['phone_country'].'!='.substr($temp[1],0,strlen($config['reg_set']['phone_country'])));
			if($config['reg_set']['phone_country']!=substr($temp[1],0,strlen($config['reg_set']['phone_country']))){
				
				$text=str_replace('#code#',$text,$config['sms']['validation_template_en']);
			}else{
				$text=str_replace('#code#',$text,$config['sms']['validation_template']);
			}
		}else{
			$text=str_replace('#code#',$text,$config['sms']['validation_template']);
		}
	}
	$ch = curl_init();
	$data=array('text'=>$text,'apikey'=>$apikey,'mobile'=>$mobile);
	curl_setopt ($ch, CURLOPT_URL, 'http://sms.yunpian.com/v2/sms/single_send.json');
	//curl_setopt ($ch, CURLOPT_URL, 'http://sms.yunpian.com/v2/sms/single_send.json');
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	$json_data = curl_exec($ch);
	$r = json_decode($json_data,true);
	if(isset($r['sid'])){return true;}else{$_POST['yunpian_sms_result']=$text.'<br />'.$json_data;return false;}
	
}
	
//调用发送短信 Monxin专用（PHP代码/函数）		
function send_sms($config,$language,$pdo,$id=0){
	if($id==0){
		$sql="select * from ".$pdo->index_pre."phone_msg where `state`='1' order by `time` asc limit 0,1";
	}else{
		$sql="select * from ".$pdo->index_pre."phone_msg where `id`='$id' and `state`='1'";
	}
	
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['addressee']!='' && $r['content']!=''){
		$r=de_safe_str($r);
		$send_result=yunpian_sms($config,$config['sms']['apikey'],$r['addressee'],$r['content']);
		if($send_result){
			 $sql="update ".$pdo->index_pre."phone_msg set `state`='2' where `id`='".$r['id']."'";
			 $pdo->exec($sql);
			 return true;
		}else{
			 $sql="update ".$pdo->index_pre."phone_msg set `state`='3' where `id`='".$r['id']."'";
			 $pdo->exec($sql);
			 $title=str_replace('{web_name}',$config['web']['name'],$language['config_language']['sms']['fail_email_content']);
			 $content='http://'.$config['web']['domain'].'/index.php?monxin=index.config#sms';
			 $content=$language['config_language']['sms']['this_name'].' <a href='.$content.' >'.$content.'</a><br />'.@$_POST['yunpian_sms_result'];
			 //var_dump($language);
			 //file_put_contents('sms_fail_mail_title.txt',$title.'<br >'.$content);
			 email($config,$language,$pdo,'monxin',$config['sms']['fail_email'],$title,$content);
			 
			 return false;
		}
	}else{return false;}
	
	
	
	function match_result($success_val,$state){
		$operational_character=array('=','≠','∈','>','<',);
		$temp=mb_substr($success_val,0,1,'utf-8');
		
		if(!in_array($temp,$operational_character)){
			$temp='=';	
		}
		$success_val=mb_substr($success_val,1,1000,'utf-8');
		$send_state=false;
		switch($temp){
			case '=':
				if($state==$success_val){$send_state=true;}
				break;	
			case '≠':
				if($state!=$success_val){$send_state=true;}
				break;	
			case '∈':
				if(strpos($state,$success_val)!==false){$send_state=true;}
				break;	
			case '<':
				if(intval($state)<intval($success_val)){$send_state=true;}
				break;	
			case '>':
				if(intval($state)>intval($success_val)){$send_state=true;}
				break;	
		}
		return $send_state;
	}
	
	$id=intval($id);
	if($id==0){
		$sql="select * from ".$pdo->index_pre."phone_msg where `state`='1' order by `time` asc limit 0,1";
	}else{
		$sql="select * from ".$pdo->index_pre."phone_msg where `id`='$id' and `state`='1'";
	}
	
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['addressee']!='' && $r['content']!=''){
		$r=de_safe_str($r);
			$ctx=stream_context_create(array('http'=>array('timeout'=>30)));
			$url=str_replace('{phone}',$r['addressee'],$config['sms']['send_url']);
			$url=str_replace('{code}',$r['content'],$url);
			
			//exit();
			$state=@file_get_contents($url,false,$ctx);
			$state=trim($state);
			$send_state=match_result($config['sms']['success_val'],$state);			
			if($send_state){
				 $sql="update ".$pdo->index_pre."phone_msg set `state`='2' where `id`='".$r['id']."'";
				 $pdo->exec($sql);
				 return true;
			}else{
				 $sql="update ".$pdo->index_pre."phone_msg set `state`='3' where `id`='".$r['id']."'";
				 $pdo->exec($sql);
				 $title=str_replace('{web_name}',$config['web']['name'],$language['config_language']['sms']['fail_email_content']);
				 $content='http://'.$config['web']['domain'].'/index.php?monxin=index.config#sms';
				 $content=$language['config_language']['sms']['this_name'].' <a href='.$content.' >'.$content.'</a>';
				 //var_dump($language);
				 //file_put_contents('sms_fail_mail_title.txt',$title.'<br >'.$content);
				 email($config,$language,$pdo,'monxin',$config['sms']['fail_email'],$title,$content);
				 
				 return false;
			}
		
		
		
	}
	
}

//PHP发送短信 Monxin专用（PHP代码/函数）		
function sms($config,$language,$pdo,$sender,$phone_number,$content){
	$time=time();
	$sql="insert into ".$pdo->index_pre."phone_msg (`sender`,`addressee`,`content`,`state`,`time`,`count`,`timing`,`ip`) values ('$sender','".$phone_number."','".$content."','1','$time','1','0','".get_ip()."')";	
	//file_put_contents('t.txt',$sql);
	if($pdo->exec($sql)){
		return  send_sms($config,$language,$pdo,$pdo->lastInsertId());
	}else{
		return false;
	}

}

//获取邮件发件箱SMTP信息 Monxin专用（PHP代码/函数）		
function get_mail_info($pdo,$email,$id=0){
	if($id!=0){
		$sql="select * from ".$pdo->index_pre."smtp where `id`='$id'";
	}else{
		$temp=explode('@',$email);
		$postfix=$temp[1];
		$sql="select * from ".$pdo->index_pre."smtp where `postfix`='$postfix' order by `time` asc limit 0,1";	
	}
	$r=$pdo->query($sql,2)->fetch(2);
	$r=de_safe_str($r);
	if(@$r['url']==''){
		$sql="select * from ".$pdo->index_pre."smtp order by `time` asc limit 0,1";	
		$r=$pdo->query($sql,2)->fetch(2);	
		$r=de_safe_str($r);
	}
	if($r['url']==''){return false;}
	
	$mail_info=$r['url']."|".$r['username']."|".$r['password'];
		$sql="update ".$pdo->index_pre."smtp set `time`=`time`+1 where `id`=".$r['id'];
		$pdo->exec($sql);
	return $mail_info;
}

//调用发送邮件 Monxin专用（PHP代码/函数）		
function send_email($config,$pdo,$id=0){
	$id=intval($id);
	if($id==0){
		$sql="select * from ".$pdo->index_pre."email_msg where `state`='1' order by `time` asc limit 0,1";
	}else{
		$sql="select * from ".$pdo->index_pre."email_msg where `id`='$id'";
	}
	
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['addressee']!='' && $r['content']!=''){
			$r=de_safe_str($r);
			$path="./plugin/mail/class.phpmailer.php";
			if(!is_file($path)){$path="../plugin/mail/class.phpmailer.php";}
			if(!is_file($path)){$path="../../plugin/mail/class.phpmailer.php";}
			if(!is_file($path)){return false;}
			require_once($path); 
			$result=sendmail($config['web']['name'],$r['addressee'],$r['title'],$r['content'],get_mail_info($pdo,$r['addressee']));
			@ob_clean(); 
			@ob_end_flush(); 

			if($result){
				 $sql="update ".$pdo->index_pre."email_msg set `state`='2' where `id`='".$r['id']."'";
				 $pdo->exec($sql);
				 return true;
			}else{
				 $sql="update ".$pdo->index_pre."email_msg set `state`='3' where `id`='".$r['id']."'";
				 $pdo->exec($sql);
				 return false;
			}
	
	}else{return false;}
	
}

//发送邮件 Monxin专用（PHP代码/函数）		
function email($config,$language,$pdo,$sender,$addressee,$title,$content){
	
	$sender=safe_str($sender);
	$addressee=safe_str($addressee);
	$title=safe_str($title);
	$content=safe_str($content);
	$time=time();
	$sql="insert into ".$pdo->index_pre."email_msg (`sender`,`addressee`,`title`,`content`,`state`,`time`) values ('$sender','$addressee','".$title."','".$content."','1','$time')";
	if($pdo->exec($sql)){
		return  send_email($config,$pdo,$pdo->lastInsertId());
	}else{
		return false;
	}

}

function return_selected($v,$v2){
	if($v==$v2){return "selected";}	
}

//年月日转 unixtime时间戳（PHP代码/函数）		
function get_unixtime($date,$date_style) {
	if($date_style[0]=='m'){
		$temp=explode($date_style[1],$date);
		$temp2=explode($date_style[1],$date);
		$temp[0]=$temp2[1];	
		$temp[1]=$temp2[0];	
		$date=implode($date_style[1],$temp);
	}
	$r=strtotime($date);
	if($r!=false){return $r;}
	try{$datetime= new DateTime($date);return $datetime->format('U');}catch(Exception $e){return 0;}
    
} 

//unixtime时间戳 转 年月日（PHP代码/函数）		
function get_date($unixtime,$date_style,$timeoffset) {
	if(!is_numeric($unixtime)){return '';};
	if($unixtime>-1 && $unixtime<2147472000){return date($date_style,$unixtime);}
	//echo "datetime_date";
    $time=$unixtime + $timeoffset * 3600;
    $datetime=new DateTime("@$time");
    return $datetime->format($date_style);
}

//年月日 转 年龄（PHP代码/函数）		
function get_age($birthday){
	if($birthday==0){return '';}
	$age=date("Y")-get_date($birthday,"Y",0);
	return $age;
}


//获取内容发布时间与当前的时差 Monxin专用（PHP代码/函数）		
function get_time($style,$timeoffset,$language,$time){
	if($time==0){return $language['none'];}
	$stime=$time;
	$time=time()-$time;
	if($time>43200){$time2=get_date($stime,$style,$timeoffset);}
	if($time<43200){$time2=floor($time/60/60).$language['hours_ago'];}
	if($time<3600){$time2=floor($time/60).$language['minutes_ago'];}
	if($time<60){$time2=floor($time).$language['seconds_ago'];}
	if($time<0){$time2=get_date($stime,$style,$timeoffset);}
	return $time2;
}


function uninstall_program($name){
	return true;
}

//操作用户余额 Monxin专用（PHP代码/函数）		
function operator_money($config,$language,$pdo,$username,$money,$reason,$program,$negative=false){
	//if($pdo=='' || $username=='' || $money=='' || $program==''){return false;}
	$sql="select `money` from ".$pdo->index_pre."user where `username`='$username'";
	$r=$pdo->query($sql,2)->fetch(2);
	$money=sprintf("%.2f",$money);
	$r['money']=sprintf("%.2f",$r['money']);
	$money=str_replace('+','',$money);
	$after_money=$r['money']+$money;
	$after_money=sprintf("%.2f",$after_money);
	if($after_money<0 && $negative==false){
		$money=str_replace('-','',$money);
		$_POST['operator_money_err_info']='<a href=./index.php?monxin=index.recharge&money='.$money.'&return_url='.urlencode(str_replace('&','|||',@$_SERVER['HTTP_REFERER'])).' id=please_recharge>'.$language['please'].$language['recharge'].'</a>';	
		return false;
	}
	$sql="update ".$pdo->index_pre."user set `money`=`money`+$money where `username`='$username'";
	//file_put_contents('./test.txt',$sql);
	if($pdo->exec($sql)){
		$sql="insert into ".$pdo->index_pre."money_log (`time`,`username`,`money`,`reason`,`operator`,`program`,`before_money`,`after_money`,`ip`) values ('".time()."','$username','$money','$reason','".@$_SESSION['monxin']['username']."','$program','".$r['money']."','$after_money','".get_ip()."')";
		
		if(!$pdo->exec($sql)){
			$sql="update ".$pdo->index_pre."user set `money`=`money`+$money where `username`='$username'";
			if(!$pdo->exec($sql)){add_err_log($sql);}
			//echo 'err_1';
			return false;
		}
		if($money>0){
			push_money_add_info($pdo,$config,$language,$username,$reason,$money,$r['money']+$money);
		}else{
			push_money_deduction_info($pdo,$config,$language,$username,$reason,$money,$r['money']+$money);
		}
		
		
		
		return true;	
	}else{
		//echo 'err_2';
		return false;
	}
	
}


//记录出错SQL语句 Monxin专用（PHP代码/函数）		
function add_err_log($v){
	$err_log=require("./err_log.php");
	$config=require("./config.php");
	$err_log=get_date(time(),'Y-m-d H:i',$config['other']['timeoffset']).' '.str_replace("'",'&#39;',$v)."\r\n".$err_log;
	return file_put_contents('./err_log.php',"<?php return '$err_log'?>");
}

//更新用户充值状态 Monxin专用（PHP代码/函数）		
function update_recharge($pdo,$config,$language,$id,$money=''){
	$id=floatval($id);
	$sql="select `state`,`money`,`return_function`,`for_id` from ".$pdo->index_pre."recharge where `in_id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['state']==4){return true;}
	if($money!='' && $money<$r['money']){$_POST['money_less']=$r['money_less']-$money;return true;}
	$return_function=$r['return_function'];
	$for_id=$r['for_id'];
	$sql="update ".$pdo->index_pre."recharge set `state`='4',`rate`='".($money-$r['money'])."' where `in_id`='$id' and `state`='2'";
	if($pdo->exec($sql)){
		$sql="select `username`,`money` from ".$pdo->index_pre."recharge where `in_id`='$id'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['username']!=''){
			if(operator_money($config,$language,$pdo,$r['username'],$r['money'],$language['recharge'],'index')===true){
				group_auto_upgrade_money($pdo,$config,$language,$r['username']);
				//file_put_contents('fu.txt',$return_function);
				call_recharge_return_function($config,$language,$pdo,$return_function,$for_id,$id);
				return true;
			}else{
				$sql="update ".$pdo->index_pre."recharge set `state`='2' where `in_id`='$id' and `state`='4'";
				if(!$pdo->exec($sql)){
					add_err_log($sql);	
				}
				return false;
			}
		}else{
			call_recharge_return_function($config,$language,$pdo,$return_function,$for_id,$id);
			return true;
		}
	}else{
			return false;
	}


	
}

//更新用户充值状态后，如有下一步业务操作函数则调用 
function call_recharge_return_function($config,$language,$pdo,$name,$for_id,$in_id){
	//file_put_contents('u.txt',$name);
	if($name==''){return false;}
	$fun=explode('.',$name);
	if(!isset($fun[1])){return false;}
	$path='./program/'.$fun[0].'/'.$fun[1].'.php';
	if(!is_file($path)){$path='../../program/'.$fun[0].'/'.$fun[1].'.php';}
	//file_put_contents('1163.txt',$path);
	if(!is_file($path)){return false;}
	//file_put_contents('1165.txt',$fun[0].'_'.$fun[1]);
	
	require_once($path);
	//$fun[0].'_'.$fun[1]($config,$language,$pdo,$for_id,$in_id);
	if($fun[0].'_'.$fun[1]=='mall_update_order_state'){mall_update_order_state($config,$language,$pdo,$for_id,$in_id);}
	if($fun[0].'_'.$fun[1]=='index_recharge_credits_back'){index_recharge_credits_back($config,$language,$pdo,$for_id,$in_id);}
	//
	file_put_contents('u.txt','end');
}


//获取程序中文名 Monxin专用（PHP代码/函数）		
function get_program_names($path=''){
	if($path==''){$path='./program/';}	
	$r=scandir($path);
	$lang=array();
	foreach($r as $key=>$v){
		if($v!='.' && $v!='..'){
			if(is_file($path.$v.'/config.php')){
				$config=require($path.$v.'/config.php');
				$language=require($path.$v.'/language/'.$config['program']['language'].'.php');
				$lang[$v]=$language['program_name'];	
			}
		}
			
	}
	return $lang;
	
}


//根据URL判断是否本地局域网访问（PHP代码/函数）		
function is_local($url){
	if(stristr($url,'localhost') || stristr($url,'127.') || stristr($url,'192.') ){
		return true;	
	}else{
		return false;	
	}	
}

//获取当前URL（PHP代码/函数）		
function get_url(){
	if(empty($_SERVER["REQUEST_URI"])){
		return $_SERVER["HTTP_HOST"].'?'.$_SERVER["QUERY_STRING"];
	}else{
		return $_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];
	}
}

//获取monxin所在目录 Monxin专用（PHP代码/函数）		
function get_monxin_path(){
	$path=get_url();
	$path=explode('index.php',$path);
	if(count($path)==2){return 'http://'.$path[0];}
	$path=explode('receive.php',$path[0]);
	if(count($path)==2){return 'http://'.$path[0];}
	return 'http://'.$path[0];		
}

//跳转monxin所设网址 Monxin专用（PHP代码/函数）		
function go_domain($domain){
	if(!is_local($_SERVER['HTTP_HOST'])){
		if($_SERVER['HTTP_HOST']!=$domain){
			if(!is_file('./install_monxin.php')){
				$url=str_ireplace($_SERVER['HTTP_HOST'],$domain,get_url());
				header("location:http://".$url);	
			}else{
				header("location:./install_monxin.php");	
			}
		}	
	}
}


//解压ZIP压缩文件（PHP代码/函数）		
function extract_zip($path,$del_zip=true){
	$zip=new ZipArchive;
	if ($zip->open($path)=== TRUE) {
		$temp_dir='./temp_dir/'.md5(time().rand(999,9999));
		$zip->extractTo($temp_dir);
		$zip->close();
		if($del_zip){safe_unlink($path);}
		return $temp_dir;
	} else {
		return false;
	}
}

//检测Monxin子程序使用权限 Monxin专用（PHP代码/函数）		
function program_permissions($config,$language,$program,$path){
	return true;
	$dir=new Dir();
	$_POST['files_size']=$dir->get_dir_size($path.'show/');
	$_POST['files_list']=$dir->show_dir($path.'show/',array('php'),false,false);
	$_POST['files_list']=implode('|',$_POST['files_list']);
	$_POST['files_list']=str_replace($path.'show/','',$_POST['files_list']);
	//echo $_POST['files_size'].','.$_POST['files_list'];

	if($program=='index'){return true;}
	$url=$config['server_url']."receive.php?target=server::program_server&act=program_permissions&program=".$program."&site_id=".$config['web']['site_id']."&site_key=".$config['web']['site_key']."&domain=".$_SERVER['HTTP_HOST'].'&files_size='.$_POST['files_size'].'&files_list='.$_POST['files_list'].'&language='.$config['web']['language'];
	//echo $url;
	$c=@file_get_contents($url);
	//echo $c;
	if(trim($c)==1){return true;}else{return false;}
}

//检测Monxin子程序安装包的完整性 Monxin专用（PHP代码/函数）		
function check_installation_files($path,$class){
	$files=array($class.'.class.php','config.php','icon.png','menu.php','pages.php','receive.class.php','install.php','uninstall.php');	
	$dirs=array('language','receive','show','install_templates');	
	$dir=new Dir();
	if(is_file($path)){
		$path=extract_zip($path,false);
		$del=true;
	}else{$del=false;}
	if(is_dir($path.'/'.$class)){
		$r=scandir($path.'/'.$class);
		$dir_list=array();
		foreach($r as $v){
			$dir_list[$v]=$v;	
		}
		$lack='';
		foreach($files as $v){
			if(!isset($dir_list[$v])){$lack.='File: '.$v.'<br />';}	
		}
		foreach($dirs as $v){
			if(!isset($dir_list[$v])){$lack.='Dir: '.$v.'<br />';}	
		}
		$_POST['files_size']=$dir->get_dir_size($path.'/'.$class.'/show/');
		$_POST['files_list']=$dir->show_dir($path.'/'.$class.'/show/',array('php'),false,false);
		$_POST['files_list']=implode('|',$_POST['files_list']);
		$_POST['files_list']=str_replace($path.'/'.$class.'/show/','',$_POST['files_list']);
		$_POST['get_config_info']=safe_get_config($path.'/'.$class.'/config.php');
	}else{
		return 'Dir: '.$class.'<br />';
	}
	if($del && is_dir($path)){
		$dir->del_dir($path);	
	}
	return $lack;
}

//检测Monxin子程序升级包的完整性 Monxin专用（PHP代码/函数）		
function check_patch_files($path,$class){
	$files=array('upgrade.php','info.txt','uninstall.php');	
	$dirs=array('default');	
	if(is_file($path)){
		$path=extract_zip($path,false);
		$del=true;
	}else{$del=false;}
	
	
	if(is_dir($path.'/patch')){
		$_POST['get_txt_info']=get_txt_info($path.'/patch/info.txt');
		$r=scandir($path.'/patch');
		$dir_list=array();
		foreach($r as $v){
			$dir_list[$v]=$v;	
		}
		$lack='';
		foreach($dirs as $v){
			if(!is_dir($path.'/patch/'.$v)){$lack.='Dir: patch/'.$v.'<br />';}	
		}
		foreach($files as $v){
			if(!isset($dir_list[$v])){$lack.='File: patch/'.$v.'<br />';}	
		}
	}else{
		return 'Dir: patch<br />';
	}
	if($del && is_dir($path)){
		//echo $path;
		$dir=new Dir();
		$dir->del_dir($path);	
	}	
	return $lack;
}

//检测模板的使用权限 Monxin专用（PHP代码/函数）		
function template_permissions($config,$language,$program,$template,$path){
	return true;
	//if($template=='default'){return true;}
	//echo $path;
	$dir=new Dir();
	$_POST['files_size']=$dir->get_dir_size($path.'pc/img/');
	if(is_file($path.'pc/img/Thumbs.db')){$_POST['files_size']-=filesize($path.'pc/img/Thumbs.db'); }
	$_POST['files_list']=$dir->show_dir($path.'pc/img/',array('jpg','jpeg','png','gif'),false,false);
	$_POST['files_list']=implode('|',$_POST['files_list']);
	$_POST['files_list']=str_replace($path.'pc/img/','',$_POST['files_list']);
	//echo $_POST['files_size'].','.$_POST['files_list'];
	
	$url=$config['server_url']."receive.php?target=server::template_server&act=template_permissions&program=".$program."&template=".$template."&site_id=".$config['web']['site_id']."&site_key=".$config['web']['site_key']."&domain=".$_SERVER['HTTP_HOST'].'&files_size='.$_POST['files_size'].'&files_list='.$_POST['files_list'].'&language='.$config['web']['language'];
	$c=@file_get_contents($url);
	//echo $c;
	if(trim($c)==1){return true;}else{return false;}
}

//检测模板的完整性 Monxin专用（PHP代码/函数）		
function check_template_files($path,$template,$program=''){
	//echo $template.','.$program;
	$files=array('icon.png','info.txt');	
	//$dirs=array('page_icon','pc','phone');
	$dirs=array('pc','phone');
	$dir=new Dir();	
	if(is_file($path)){
		$path=extract_zip($path,false);
		$del=true;
	}else{$del=false;}
	if(is_dir($path.'/'.$template)){
		$lack='';
		if(is_file($path.'/'.$template.'/info.txt') && $program!=''){
			//echo 'xx';
			$template_info=get_txt_info($path.'/'.$template.'/info.txt');
			
			if($template_info['for']!=$program){
				
				$lack.='The template and the program does not match<br />';	
			}
		}
		$r=scandir($path.'/'.$template);
		$dir_list=array();
		foreach($r as $v){
			$dir_list[$v]=$v;	
		}
		
		foreach($files as $v){
			if(!isset($dir_list[$v])){$lack.='File: '.$v.'<br />';}	
		}
		foreach($dirs as $v){
			if(!isset($dir_list[$v])){$lack.='Dir: '.$v.'<br />';}	
		}
				
		$_POST['files_size']=$dir->get_dir_size($path.'/'.$template.'/pc/img/');
		if(is_file($path.'/'.$template.'/pc/img/Thumbs.db')){$_POST['files_size']-=filesize($path.'/'.$template.'/pc/img/Thumbs.db'); }
		$_POST['files_list']=$dir->show_dir($path.'/'.$template.'/pc/img/',array('jpg','jpeg','png','gif'),false,false);
		$_POST['files_list']=@implode('|',$_POST['files_list']);
		$_POST['files_list']=str_replace($path.'/'.$template.'/pc/img/','',$_POST['files_list']);
		$_POST['get_txt_info']=get_txt_info($path.'/'.$template.'/info.txt');
		
	}else{
		return 'Dir: '.$template.'<br />';
	}
	if($del && is_dir($path)){
		$dir->del_dir($path);	
	}
	return $lack;
}

//判断密码是否合法 （PHP代码/函数）		
function is_passwd($v){
	$pattern="/^(\w){1,100}$/";
	if(preg_match($pattern,$v)){ 
		return true; 
	}else{ 
		return false; 
	} 
}


//清空文件的BOM头（PHP代码/函数）		
function clear_bom($str){
    $charset[1]= substr($str, 0, 1); 
    $charset[2] = substr($str, 1, 1); 
    $charset[3] = substr($str, 2, 1); 
    if(ord($charset[1])== 239 && ord($charset[2]) == 187 && ord($charset[3])== 191){$str=substr($str, 3);}
	return $str;
}

function get_txt_info($path){
	if(!is_file($path)){return false;}
	$info=file_get_contents($path);
	$info=clear_bom($info);
	$info=explode("\r\n",$info);
	$info=array_filter($info);
	$i=array();
	foreach($info as $i2){
		$temp=explode("=",$i2);	
		$i[trim($temp[0])]=@$temp[1];
	}
	return $i;
}

//自动给宽高加后缀 （PHP代码/函数）		
function add_px($v){
	$v2=floatval($v);
	$last=substr($v,strlen($v)-1);
	if($last=='x'){return $v2.'px';}
	if($last=='%'){return $v2.'%';}
	if($last=='m'){return $v2.'rem';}
	return $v2.'px';
}

//跳转到404页面 Monxin专用（PHP代码/函数）		
function not_find(){
	header('location:index.php?monxin=index.not_found');exit;
	echo('404');	
}

//更新导航条静态数据 Monxin专用（PHP代码/函数） stop		
function update_navigation_txt($pdo){
	$sql="select `id`,`name`,`url`,`open_target`,`parent_id` from ".$pdo->index_pre."navigation where `parent_id`=0 and `visible`=1 order by `sequence` desc";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$v=de_safe_str($v);
		$navigation_1.='<a href="'.$v['url'].'" target="'.$v['open_target'].'" id="'.$v['id'].'"><img src="./program/index/navigation_icon/'.$v['id'].'.png" /><span>'.$v['name'].'</span></a>';	
		$sql2="select * from ".$pdo->index_pre."navigation where `parent_id`='".$v['id']."' and `visible`=1 order by `sequence` desc";
		$r2=$pdo->query($sql2,2);
		$navigation_2_temp='';
		foreach($r2 as $v2){
			$v2=de_safe_str($v2);
			$navigation_2_temp.='<a href="'.$v2['url'].'" target="'.$v2['open_target'].'" id="'.$v2['id'].'"><img src="./program/index/navigation_icon/'.$v2['id'].'.png" /><span>'.$v2['name'].'</span></a>';	
			$sql3="select * from ".$pdo->index_pre."navigation where `parent_id`='".$v2['id']."' and `visible`=1 order by `sequence` desc";
			$r3=$pdo->query($sql3,2);
			$navigation_3_temp='';
			foreach($r3 as $v3){
				$v3=de_safe_str($v3);
				$navigation_3_temp.='<a href="'.$v3['url'].'" target="'.$v3['open_target'].'" id="'.$v3['id'].'"><img src="./program/index/navigation_icon/'.$v3['id'].'.png" /><span>'.$v3['name'].'</span></a>';	
			}
			if($navigation_3_temp!=''){$navigation_3.='<div class="navigation_3" id="'.$v2['id'].'_sub"><a class="for_touch" href="'.$v2['url'].'" target="'.$v2['open_target'].'"><img src="./program/index/navigation_icon/'.$v2['id'].'.png" /><span>'.$v2['name'].'</span></a>'.$navigation_3_temp.'</div>';}
		}
		if($navigation_2_temp!=''){$navigation_2.='<div class="navigation_2" id="'.$v['id'].'_sub"><a class="for_touch" href="'.$v['url'].'" target="'.$v['open_target'].'" ><img src="./program/index/navigation_icon/'.$v['id'].'.png" /><span>'.$v['name'].'</span></a>'.$navigation_2_temp.'</div>';}
	}
	if($navigation_1!=''){$navigation_1='<div id=navigation_bar><span id=navigation_start>&nbsp;</span><div class="navigation_1">'.$navigation_1.'</div><span id=navigation_end>&nbsp;</span></div>
';}
	return file_put_contents('./program/index/navigation.txt',$navigation_1.$navigation_2.$navigation_3);
}

//记录用户的访问设备 Monxin专用（PHP代码/函数）		
function set_device(){
	$device_array=array('pc','phone');
	//if(!isset($_COOKIE['monxin_device'])){$_COOKIE['monxin_device']=$device_array[0];return true;}
	
	if(isset($_GET['monxin_device']) && in_array(@$_GET['monxin_device'],$device_array)){	
		$_COOKIE['monxin_device']=$_GET['monxin_device'];
		//echo $_COOKIE['monxin_device'].'=monxin_device';
		return true;	
	}
	if(!in_array(@$_COOKIE['monxin_device'],$device_array)){
		$_COOKIE['monxin_device']=$device_array[0];
		return true;
	}
	if(isset($_COOKIE['monxin_device'])){return true;}
	
	$pc=array('Windows','Macintosh');
	$phone=array('Android','iPhone','iPod','BlackBerry','Windows Phone');
	foreach($pc as $v){
		if(strpos($_SERVER['HTTP_USER_AGENT'],$v)!==false){$_COOKIE['monxin_device']='pc';break;}	
	}
	foreach($phone as $v){
		if(strpos($_SERVER['HTTP_USER_AGENT'],$v)!==false){$_COOKIE['monxin_device']='phone';break;}	
	}
	
	
	return false;
}

//删除monxin子程序的相关数据表 Monxin专用（PHP代码/函数）		
function del_program_table($pdo,$program){
	$sql="show tables like '".$pdo->sys_pre.$program."\_%'";
	//exit($sql);
	$r=$pdo->query($sql);
	foreach($r as $v) {
		$pdo->exec("DROP TABLE IF EXISTS `".$v[0]."`");
		//echo $v[0];
	}
	return true;
}

//导出mysql数据表 Monxin专用（PHP代码/函数）		
function output_table($pdo,$save_dir,$program='',$flag=1){
	set_time_limit(0);
    $mysql='monxin_sql_start';
	if($program!=''){
		$statments=$pdo->query("show tables like '".$pdo->sys_pre.$program."\_%'");	
	}else{
		$statments=$pdo->query("show tables like '".$pdo->sys_pre."%'");	
	}
	$file_count=0;
	$save_dir.='/';
	$save_dir=str_replace('//','/',$save_dir.'/');
	$save_path=$save_dir.date('Y-m-d_H-i',time()).'_'.rand(100,99999).'__';
	$files=array();
    foreach ($statments as $value) {
        $table_name=$value[0];
        $mysql.="DROP TABLE IF EXISTS `$table_name`;m;o;n;\n\r";
        $table_query=$pdo->query("show create table `$table_name`");
        $create_sql=$table_query->fetch();
        $mysql.=$create_sql['Create Table'] .";m;o;n;\n\r";
        if ($flag != 0) {
            $iteams_query=$pdo->query("select * from `$table_name`");
            $values="";
            $items="";
			$i=0;
			
            while ($item_query=$iteams_query->fetch(PDO::FETCH_ASSOC)){ 
                $i++;
				$item_names=array_keys($item_query);
                $item_names=array_map("addslashes", $item_names);
                $items=join('`,`', $item_names); 
                $item_values=array_values($item_query);
                $item_values=array_map("addslashes", $item_values);
                $value_string=join("','", $item_values);
                $value_string="('" . $value_string . "'),";
                $values.="\n" . $value_string;
				
				if($i==50){
					$mysql.= "INSERT INTO `$table_name` (`$items`) VALUES" . rtrim($values, ",") . ";m;o;n;\n\r";
					$i=0;
					$items='';
					$values='';
				}
				if(strlen($mysql)>(1024*1024*10)){
					$file_count++;
					file_put_contents($save_path.$file_count.'.sql',$mysql);
					//echo $save_path.$file_count.'.sql'.'<br/>';
					$mysql='';
					$files[]=$save_path.$file_count.'.sql';	
				}
            }
            if ($values != "" && $i!=50) {
               $insert_sql="INSERT INTO `$table_name` (`$items`) VALUES" . rtrim($values, ",") . ";m;o;n;\n\r";
               $mysql.=$insert_sql;
             }
         }
      }
	  if($mysql!=''){
		  $file_count++;
		  file_put_contents($save_path.$file_count.'.sql',$mysql.'monxin_sql_end');
		  //echo $save_path.$file_count.'.sql'.'<br/>';
		  $mysql='';
		  $files[]=$save_path.$file_count.'.sql';
	  }elseif($file_count>0){
		  //echo $save_path.$file_count.'.sql<hr>';
		  file_put_contents($save_path.$file_count.'.sql',file_get_contents($save_path.$file_count.'.sql').'monxin_sql_end');
	  }
	  $_POST['output_table']=$files;
     return  true;
}

//获取本批数据备份文件名 Monxin专用（PHP代码/函数）		
function get_sql_series($path){
	 if(file_exists($path)){
		 $series=array();
		$i=get_match_single('/__(\d)\.sql/i',$path);
	   	$path_prefix=str_replace('__'.$i.'.sql','',$path);
	 	for($i=1;$i<1000;$i++){
			 $path=$path_prefix.'__'.($i).'.sql';
			// echo $path.',';
			  if(file_exists($path)){
				  $series[]=$path;
			  }else{break;}
		 }
		return $series;
	 }
	 return false;
}

//数据导入mysql Monxin专用（PHP代码/函数）		
function input_table($pdo,$path,$auto=true){
	set_time_limit(0);
   if (file_exists($path)) {
	   $i=get_match_single('/__(\d)\.sql/i',$path);
	   if(is_numeric($i) && $auto){
		   $series=get_sql_series($path);
		  // var_dump( $series);
		   if(count($series)==0){$_POST['err_info']='lack_series_file';return false;}
		   if(strpos(file_get_contents($series[0]),'monxin_sql_start')===false){$_POST['err_info']='lack_series_file';return false;}
		   if(strpos(file_get_contents($series[count($series)-1]),'monxin_sql_end')===false){$_POST['err_info']='lack_series_file';return false;}
		   
		   foreach($series as $v){
			  $pdo=new  ConnectPDO();
			  input_table($pdo,$v,false);
		   }
		}else{
		   $sql_stream=file_get_contents($path);
		   $sql_stream=rtrim($sql_stream);
		   $sql_stream=trim($sql_stream,'monxin_sql_start');
		   $sql_stream=trim($sql_stream,'monxin_sql_end');
		   $sql_array=explode(";m;o;n;\n\r",$sql_stream);
		   array_filter($sql_array);
		  if(count($sql_array)==0){$_POST['err_info']='the_sql_is_not_for_Monxin';return false;}
		   foreach ($sql_array as $value) {
			   if($value==''){continue;}
			   $pdo->exec($value);
		   }
		}
	 return true;  
	}
	return false;
}

//优化MYSQL数据库 Monxin专用（PHP代码/函数）		
function optimize_db($pdo){
	$statments=$pdo->query("show tables like '".$pdo->sys_pre."%'");	
	foreach ($statments as $value) {
        $table_name=$value[0];
		$pdo->exec("OPTIMIZE TABLE `$table_name`");
	}
	return true;
}

//修复MYSQL数据库 Monxin专用（PHP代码/函数）		
function repair_db($pdo){
	$statments=$pdo->query("show tables like '".$pdo->sys_pre."%'");	
	foreach ($statments as $value) {
        $table_name=$value[0];
		$pdo->exec("REPAIR TABLE `$table_name`");
	}
	return true;
}



function safe_get_config($path){
	$str=file_get_contents($path);
	$str=explode(',',$str);
	$config=array();
	foreach($str as $key=>$v){
		trim($v);
		trim($v,'"');
		trim($v,"'");
		$temp=explode('=>',$v);
		if(isset($temp[1])){
			$temp[0]=trim($temp[0]);
			$temp[0]=trim($temp[0],'"');
			$temp[0]=trim($temp[0],"'");
			$temp[1]=trim($temp[1]);
			$temp[1]=trim($temp[1],'"');
			$temp[1]=trim($temp[1],"'");
			$config[$temp[0]]=$temp[1];	
		}	
	}
	return $config;
}

//转换文件大小单（PHP代码/函数）		
function formatSize($size){           
	//$size=sprintf("%u ",$size);           
	if($size==0){return( "0 Bytes ");}           
	$sizename=array(" Bytes"," KB"," MB"," GB"," TB"," PB"," EB"," ZB"," YB");         
	return round($size/pow(1024,($i=floor(log($size,1024)))),2).$sizename[$i];	   
}   

//文件直接下载 （PHP代码/函数）		
function file_download($file,$filename='')
{
	file_exists($file) or exit('文件不存在');
	$filename = $filename ? $filename : basename($file);
	$filetype = get_file_postfix($filename);
	$filesize = filesize($file);
	header('Cache-control: max-age=31536000');
	header('Expires: '.gmdate('D, d M Y H:i:s', time() + 31536000).' GMT');
	header('Content-Encoding: none');
	header('Content-Length: '.$filesize);
	header('Content-Disposition: attachment; filename='.$filename);
	header('Content-Type: '.$filetype);
	readfile($file);
	exit;
}

//获取文件后缀名（PHP代码/函数）		
function get_file_postfix($filename){return trim(substr(strrchr($filename, '.'),1));}

//文件路径转A链接（PHP代码/函数）		
function get_dir_link($dir,$href_pre){
	$temp=trim($dir,'/');
	$temp=explode('/',$temp);
	$deep=count($temp);
	$href='';
	$dir_link='';
	for($i=0;$i<$deep;$i++){
		if($temp[$i]==''){continue;}
		$href.=$temp[$i].'/';
		$dir_link.='<a href='.$href_pre.$href.'>'.$temp[$i].'</a> / ';	
	}
	return $dir_link;
}

function get_dir_path($path=null){
	if (!empty($path)) {
		if (strpos($path,'\\')!==false) {
			return substr($path,0,strrpos($path,'\\')).'/';
		} elseif (strpos($path,'/')!==false) {
			return substr($path,0,strrpos($path,'/')).'/';
		}
	}
	return './';
}

//启用用户的个人设置 Monxin专用（PHP代码/函数）		
function send_user_set_cookie($pdo){
	$sql="select * from ".$pdo->index_pre."user_set_item";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$sql2="select `item_value` from ".$pdo->index_pre."user_set where `user_id`='".@$_SESSION['monxin']['id']."' and `item_variable`='".$v['variable']."'";
		$r2=$pdo->query($sql2,2)->fetch(2);
		if($r2['item_value']==''){
			$value=$v['default_value'];
			if($v['variable']=='user_set_color'){
				$sql="select `id` from ".$pdo->index_pre."color order by `sequence` desc limit 0,1";
				$r3=$pdo->query($sql,2)->fetch(2);
				$value=$r3['id'];	
			}
		}else{
			$value=$r2['item_value'];
		}
		//var_dump($v['variable'].'='.$value);
		@setcookie($v['variable'],$value,0,'/');
	}				
}	

//浏览器直接查看数组 （PHP代码/函数）		
function monxin_var_dump($array){
	echo '<pre>';
	var_dump($array);
	echo '</pre>';	
}				

//更新同步程序的page.php文件 Monxin专用（PHP代码/函数）		
function update_pages_file($pdo,$id){
	clear_file_cache();
	if(is_numeric($id)){
		$sql="select * from ".$pdo->index_pre."page where `id`=$id";
	}else{
		$sql="select * from ".$pdo->index_pre."page where `url`='$id'";
	}
	
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['url']==''){return false;}
	$t=explode('.',$r['url']);
	if(!file_exists('./program/'.$t[0].'/pages.php')){return false;}
	$pages=require('./program/'.$t[0].'/pages.php');
	$pages[$r['url']]['layout']=$r['layout'];
	$pages[$r['url']]['head']=$r['head'];
	$pages[$r['url']]['left']=$r['left'];
	$pages[$r['url']]['right']=$r['right'];
	$pages[$r['url']]['full']=$r['full'];
	$pages[$r['url']]['bottom']=$r['bottom'];	
	$pages[$r['url']]['target']=$r['target'];	
	$pages[$r['url']]['tutorial']=$r['tutorial'];	
	$pages[$r['url']]['require_login']=$r['require_login'];	
	$pages[$r['url']]['url']=$r['url'];	
	if(file_put_contents('./program/'.$t[0].'/pages.php','<?php return '.var_export($pages,true).'?>')){
		return true;
	}else{
		return false;	
	}

}

//获取服务器支持文件最大上传大小 （PHP代码/函数）		
function get_upload_max_size(){
	return min(intval(get_cfg_var('upload_max_filesize')),intval(get_cfg_var('post_max_size')),intval(get_cfg_var('memory_limit')));	
}

//转HTML 换行（PHP代码/函数）		
function rn_to_br($v){
	$arr= array("\n", "\r", "\r\n");
	return str_replace($arr,"<br />",$v);
}

//清空临时文件 Monxin专用（PHP代码/函数）		
function clear_temp_file(){
	$path='./program/index/day.txt';
	if(is_file($path)){
		$day=file_get_contents($path);	
	}else{$day=date("d",time())-1;}
	if($day!=date("d",time())){
		$dir=new Dir();
		$dir->del_dir('./temp');
		$dir->del_dir('./temp_dir');
		//$dir->del_dir('./cache');
		mkdir('./temp');
		mkdir('./temp_dir');
		//mkdir('./cache');
		file_put_contents($path,date("d",time()));
	}	
}

//https_post提交（PHP代码/函数）		
function https_post($url,$data){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url); 
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    if (curl_errno($curl)) {
       return 'Errno'.curl_error($curl);
    }
    curl_close($curl);
    return $result;
}

function request_post($url = '', $param = '') {
	if (empty($url) || empty($param)) {
		return false;
	}
	$postUrl = $url;
	$curlPost = $param;
	$ch = curl_init();//初始化curl
	curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
	curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
	curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
	curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
	$data = curl_exec($ch);//运行curl
	curl_close($ch);
	
	return $data;
}

function replace_str($key,$str){
	$temp1=explode(',',$key);
	foreach($temp1 as $v){
		$v=explode('==',$v);
		if(isset($v[1])){
			$str=str_replace($v[0],$v[1],$str);	
		}
	}
	return $str;
}

//CURL获取网页（PHP代码/函数）		
function curl_open($url){
	$ch = curl_init();  
	curl_setopt($ch, CURLOPT_URL, $url);  
	curl_setopt($ch, CURLOPT_HEADER, false);  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.1 Safari/537.11');  	  
	$res = curl_exec($ch);  
	$rescode = curl_getinfo($ch, CURLINFO_HTTP_CODE);   
	curl_close($ch) ;  
	return $res;  
}

//获取图片绝对路径 采集图片用到（PHP代码/函数）		
function get_img_absolute_path($img_url,$page_url){
	if($img_url=='' || $page_url==''){return '';}
	if(stripos($img_url,'http')===false){
		$url=parse_url($page_url);
		$domain=$url['scheme'].'://'.$url['host'].'/';
		if(stripos($img_url,'/')===0){return $domain.trim($img_url,'/');}
		$dir=array();
		if(isset($url['path'])){
			$temp=explode('/',$url['path']);
			foreach($temp as $v){
				if($v!=''){
					if(stripos($v,'.')===false){$dir[]=$v;}
				}	
			}
		}
		if(substr_count($img_url,'../')==0 && count($dir)==0){return $domain.trim($img_url,'./');}
		$deep=count($dir)-substr_count($img_url,'../');
		//echo $deep;
		$path='';
		for($i=0;$i<$deep;$i++){
			$path.=$dir[$i].'/';	
		}
		$img_url=str_replace('../','',$img_url);
		return $domain.$path.trim($img_url,'./');
	}else{
		return $img_url;	
	}	
}
//加密部分内容(敏感信息，如:密码，用户名等...)（PHP代码/函数）
function encryption_str($str){
	if($str==''){return $str;}
	$length=mb_strlen($str,'utf-8');
	switch($length){
		case 1:
			return mb_substr($str,0,1,'utf-8');
			break;	
		case 2:
			return '*'.mb_substr($str,1,1,'utf-8');
			break;	
		case 3:
			return mb_substr($str,0,1,'utf-8').'*'.mb_substr($str,2,1,'utf-8');
			break;	
		case 4:
			return mb_substr($str,0,2,'utf-8').'*'.mb_substr($str,3,1,'utf-8');
			break;	
		case 5:
			return mb_substr($str,0,1,'utf-8').'**'.mb_substr($str,3,2,'utf-8');
			break;	
		case 6:
			return mb_substr($str,0,2,'utf-8').'**'.mb_substr($str,4,2,'utf-8');
			break;	
		case 7:
			return mb_substr($str,0,2,'utf-8').'***'.mb_substr($str,5,2,'utf-8');
			break;	
		case 8:
			return mb_substr($str,0,3,'utf-8').'****'.mb_substr($str,7,2,'utf-8');
			break;	
		case 9:
			return mb_substr($str,0,4,'utf-8').'****'.mb_substr($str,8,1,'utf-8');
			break;	
		case 10:
			return mb_substr($str,0,5,'utf-8').'****'.mb_substr($str,9,1,'utf-8');
			break;	
		case 11:
			return mb_substr($str,0,6,'utf-8').'****'.mb_substr($str,10,1,'utf-8');
			break;	
		default :
			return mb_substr($str,0,$length-8,'utf-8').'******'.mb_substr($str,$length-1,1,'utf-8');
	}	
}


function get_verification_code($length){
	$code="123456789"; //这是随机数
	$string=''; //定义一个空字符串
	for($i=0; $i<$length; $i++){ //codeNum为验证码的位数,一般为4
		$char=$code{rand(0, strlen($code)-1)}; //随机数,如果$code{0}那就是2
		$string.=$char; //附加验证码符号到字符串
	}

	return $string;
}

function get_random_str($length){
	$code="ABCDEFGHIJKLMNOPQRSTUVWXYZ"; //这是随机数
	$string=''; //定义一个空字符串
	for($i=0; $i<$length; $i++){ //codeNum为验证码的位数,一般为4
		$char=$code{rand(0, strlen($code)-1)}; //随机数,如果$code{0}那就是2
		$string.=$char; //附加验证码符号到字符串
	}
	return $string;
}
function get_random($length){
	$code="ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; //这是随机数
	$string=''; //定义一个空字符串
	for($i=0; $i<$length; $i++){ //codeNum为验证码的位数,一般为4
		$char=$code{mt_rand(0, strlen($code)-1)}; //随机数,如果$code{0}那就是2
		$string.=$char; //附加验证码符号到字符串
	}
	return $string;
}


function sms_frequency($pdo,$phone,$frequency=''){
	$phone=safe_str($phone);
	if($frequency==''){return true;}
	$temp=explode('/',$frequency);
	$frequency=array_filter($temp);
	foreach($frequency as $v){
		$temp=explode(':',$v);
		if(!isset($temp[1])){continue;}
		if(!is_numeric($temp[0]) || !is_numeric($temp[1])){continue;}
		$start=time()-$temp[0]*60;
		$sql="select count(id) as c from ".$pdo->index_pre."phone_msg where `time`>".$start." and `addressee`='".$phone."'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']>$temp[1]){return false; }
	}
	$start=time()-86400;
	$sql="select count(id) as c from ".$pdo->index_pre."phone_msg where `time`>".$start." and `ip`='".get_ip()."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']>10){return false; }
	
	
	
	return true;
}

function email_frequency($pdo,$email){
	$email=safe_str($email);
	$start=time()-300;
	$sql="select count(id) as c from ".$pdo->index_pre."email_msg where `time`>".$start." and `addressee`='".$email."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']>2){return false; }
	$start=time()-600;
	$sql="select count(id) as c from ".$pdo->index_pre."email_msg where `time`>".$start." and `addressee`='".$email."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']>3){return false; }
	$start=time()-3600;
	$sql="select count(id) as c from ".$pdo->index_pre."email_msg where `time`>".$start." and `addressee`='".$email."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']>6){return false; }
	$start=time()-86400;
	$sql="select count(id) as c from ".$pdo->index_pre."email_msg where `time`>".$start." and `addressee`='".$email."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']>10){return false; }
	return true;

}

function oauth_bind($pdo,$user_id){
	$open_id=safe_str($_SESSION['oauth']['open_id']);

	if(strpos($_SESSION['oauth']['open_id'],'wx:')!==false){
		$sql="select `openid` from ".$pdo->index_pre."user where `id`=".$user_id;
		$r3=$pdo->query($sql,2)->fetch(2);
		if($r3['openid']==''){
			$sql="update ".$pdo->index_pre."user set `openid`='".str_replace('wx:','',$open_id)."' where `id`=".$user_id;
			$pdo->exec($sql);
		}	
	}
	
	$sql="select `id` from ".$pdo->index_pre."oauth where `user_id`=".$user_id." and `open_id`='".$open_id."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){return true;}
	$sql="insert into ".$pdo->index_pre."oauth (`user_id`,`open_id`,`time`) values ('".$user_id."','".$open_id."','".time()."')";
	if($pdo->exec($sql)){return true;}else{return false;}
	
}


function oauth_login($pdo,$language,$config){
	$open_id=safe_str($_SESSION['oauth']['open_id']);
	if(substr($open_id,0,3)=='wx:'){
		$sql="select `id`,`subscribe` from ".$pdo->sys_pre."weixin_user where `wid`='".$config['web']['wid']."' and `openid`='".str_replace('wx:','',$open_id)."' limit 0,1";	
		file_put_contents('w.txt',$sql);
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']=='' || $r['subscribe']==0){
			$sql="select `qr_code` from ".$pdo->sys_pre."weixin_account  where `wid`='".$config['web']['wid']."' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			exit('<!DOCTYPE html><head><meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" /><meta http-equiv="Content-type" content="text/html; charset=utf-8" /><style>.fa-spin,.loading{display:none;}</style></head><body><div style="text-align:center; padding:20px; font-size:18px;"><img src="/program/weixin/qr_code/'.@$r['qr_code'].'" width=80% style="max-width:300px" /><br />'.$language['please_attention_weixin'].'<br />'.$language['wechat_scan'].'<br /><a href=../../index.php?monxin=index.login>'.$language['re_login'].'</a></div></body></html>');
			
		}		
	}
	
	$sql="select `user_id` from ".$pdo->index_pre."oauth where `open_id`='".$open_id."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['user_id']!=''){
		$user_id=$r['user_id'];		
	}else{
		//return false;	
		$openid=str_replace('wx:','',$open_id);	
		$sql="select `id` from ".$pdo->index_pre."user where `openid`='".$openid."' limit 0,1";
		$rr=$pdo->query($sql,2)->fetch(2);
		if($rr['id']!=''){
			$user_id=$rr['id'];
			$sql="insert into ".$pdo->index_pre."oauth (`user_id`,`open_id`,`time`) values ('".$user_id."','wx:".$openid."','".time()."')";
			$pdo->exec($sql);	
		}else{
			return false;	
		}
		
	}
	
	$sql="select {$pdo->index_pre}user.id as userid,{$pdo->index_pre}group.id as group_id,`nickname`,`username`,`name`,`page_power`,`function_power`,`state`,`icon`,`reg_oauth`,`recommendation`,`introducer` from ".$pdo->index_pre."user,".$pdo->index_pre."group where {$pdo->index_pre}user.id=".$user_id." and `group`=".$pdo->index_pre."group.id";
	$stmt=$pdo->query($sql,2);
	$v=$stmt->fetch(2);	
	if($v==false){
		
		$sql="delete from ".$pdo->index_pre."oauth where `open_id`='".$open_id."'";
		$pdo->exec($sql);
		return false;
	}	
			
	if($v['state']!=1){
		exit('<div class=return_false>'.$language['user_state'][$v['state']].'</div>');
		
	}else{
			
		if(strpos($_SESSION['oauth']['open_id'],'wx:')!==false){
			$sql="select `openid` from ".$pdo->index_pre."user where `id`=".$v['userid'];
			$r3=$pdo->query($sql,2)->fetch(2);
			if($r3['openid']==''){
				$sql="update ".$pdo->index_pre."user set `openid`='".str_replace('wx:','',$open_id)."' where `id`=".$v['userid'];
				$pdo->exec($sql);
			}	
			
		}
		if($v['username']==''){
			$v['username']=date('Ymd',time()).'_'.get_random_str(4);
			$sql="update ".$pdo->index_pre."user set `username`='".$v['username']."' where `id`=".$v['userid'];
			$pdo->exec($sql);
		}
		push_login_info($pdo,$config,$language,$v['username']);
		login_credits($pdo,$config,$language,$v['userid'],$v['username'],$config['credits_set']['login'],$language['login_credits'],$config['other']['timeoffset']);
		if($v['recommendation']==''){
			$recommendation=$v['userid'].get_random_str(8-strlen($v['userid']));
			$sql="update ".$pdo->index_pre."user set `recommendation`='".$recommendation."' where `id`=".$v['userid'];
			$pdo->exec($sql);	
		}
		if(!is_url($v['icon'])){$v['icon']="./program/index/user_icon/".$v['icon'];}
		$_SESSION['monxin']['id']=$v['userid'];
		$_SESSION['monxin']['introducer']=$v['introducer'];
		$_SESSION['monxin']['username']=$v['username'];
		$_SESSION['monxin']['nickname']=$v['nickname'];
		$_SESSION['monxin']['icon']=$v['icon'];
		if($v['icon']==''){$_SESSION['monxin']['icon']='default.png';}
		$_SESSION['monxin']['group']=$v['name'];
		$_SESSION['monxin']['group_id']=$v['group_id'];
		$_SESSION['monxin']['page']=explode(",",$v['page_power']);
		$_SESSION['monxin']['function']=explode(",",$v['function_power']);
		setcookie("monxin_id",$v['userid'],0,'/');
		setcookie("monxin_nickname",$v['nickname'],0,'/');
		setcookie("monxin_icon",$_SESSION['monxin']['icon'],0,'/');
		if(in_array('index.edit_page_layout',$_SESSION['monxin']['function'])){
			//setcookie("edit_page_layout",'true',time() + 24 * 3600,'/',$_SERVER['HTTP_HOST']);	
			setcookie("edit_page_layout",'true',0,'/');	
		}
		//user_set cookie					
		send_user_set_cookie($pdo);
		$time=time();
		$ip=get_ip();
		$sql="update ".$pdo->index_pre."user set `last_time`='$time',`last_ip`='$ip' where `id`='".$_SESSION['monxin']['id']."'";
		$pdo->exec($sql);
		$sql="select count(id) as c from ".$pdo->index_pre."user_login where `userid`='".$_SESSION['monxin']['id']."'";
		$stmt=$pdo->query($sql,2);
		$v=$stmt->fetch(2);
		if($v['c']<$config['other']['user_login_log']){
			$sql="insert into ".$pdo->index_pre."user_login (`userid`,`ip`,`time`) values ('".$_SESSION['monxin']['id']."','$ip','$time')";
		}else{
			$sql="select `id` from ".$pdo->index_pre."user_login where `userid`='".$_SESSION['monxin']['id']."' order by time asc limit 0,1";
			$stmt=$pdo->query($sql,2);
			$v=$stmt->fetch(2);
			$sql="update ".$pdo->index_pre."user_login set `ip`='$ip',`time`='$time' where `id`='".$v['id']."'";
		}
		$pdo->exec($sql);
		$sql="update ".$pdo->index_pre."user set `login_num`=login_num+1 where `id`='".$_SESSION['monxin']['id']."'";
		$pdo->exec($sql);
		$backurl=str_replace('|||','&',$_SESSION['oauth']['backurl']);
		$_SESSION['oauth']=array();

		//var_dump($_SESSION['oauth']['backurl']);
		if(@$_COOKIE['monxin_device']=='phone'){
			$temp=explode('?',$backurl);
			if(count($temp)>1){
				$l_url=str_replace('http://'.$config['web']['domain'],'',$backurl).'&reload='.get_random_str(5);
			}else{
				$l_url=str_replace('http://'.$config['web']['domain'],'',$backurl).'?&reload='.get_random_str(5);	
			}
			header('location:'.$l_url);
			exit('<script>window.location.href="'.$backurl.'?&reload='.get_random_str(5).'";</script>');
		}
		exit("<script>window.close();</script>");
		
		
	}
}

function get_ip_position($ip,$ak=''){
	if($ak==''){
		return file_get_contents('http://www.monxin.com/get_position.php?ip='.$ip);	
	}else{
		$r=file_get_contents('http://api.map.baidu.com/location/ip?ak='.$ak.'&ip='.$ip.'&coor=bd09ll');
		$r=(json_decode($r,1));
		if(isset($r['content']['address_detail']['city'])){return $r['content']['address_detail']['city'];}else{return '未知';}
	}	
}

function get_gps_position($v,$ak=''){
	if($ak==''){
		return '';
	}else{
		$url='http://api.map.baidu.com/geocoder/v2/?location='.$v.'&output=json&pois=1&ak='.$ak;
		$r=file_get_contents($url);
		$r=(json_decode($r,1));
		if(isset($r['result']['addressComponent'])){return $r['result']['addressComponent']['district'].@$r['result']['addressComponent']['street'].@$r['result']['addressComponent']['street_number'];}else{return '';}
	}	
}


function operation_credits($pdo,$config,$language,$username,$number,$reason,$type='other',$negative=false){
	if($number<0){
		$sql="select `credits` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if(($r['credits']+$number)<0 && $negative==false){return false;}
	}
	
	$sql="update ".$pdo->index_pre."user set `credits`=`credits`+".$number.",`cumulative_credits`=`cumulative_credits`+".$number." where `username`='".$username."'  limit 1";	
	if($number<0){
		if($type!='buy_return'){
			$sql="update ".$pdo->index_pre."user set `credits`=`credits`+".$number." where `username`='".$username."'  limit 1";		
		}	
	}
		

	if($pdo->exec($sql)){
		
		$time=time();
		$sql="insert into ".$pdo->index_pre."credits (`time`,`username`,`money`,`reason`,`type`) values ('".$time."','".$username."','".$number."','".$reason."','".$type."')";
		$pdo->exec($sql);
		$sql="select `credits` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($type!='login'){push_credits($pdo,$config,$language,$username,$type,$number,$r['credits']);}
		if($number>0){group_auto_upgrade($pdo,$config,$language,$username);}
		return true;
	}else{
		return false;
	}	
}

function group_auto_upgrade($pdo,$config,$language,$username){
	if($config['web']['group_upgrade']!='credits'){return false;}
	$sql="select `cumulative_credits`,`group` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";	
	$user=$pdo->query($sql,2)->fetch(2);
	
	$sql="select `credits`,`name` from ".$pdo->index_pre."group where `id`='".$user['group']."'";
	$group=$pdo->query($sql,2)->fetch(2);
	if($group['credits']<0){return false;}
	
	$sql="select `id`,`credits`,`name` from ".$pdo->index_pre."group where `id`!=".$user['group']." and `credits`>".$group['credits']." and `credits`<".($user['cumulative_credits']+1)." order by `credits` desc limit 1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==1){return false;}
	if($r['id']!='' && $r['credits']>0){
		$sql="update ".$pdo->index_pre."user set `group`=".$r['id']." where `username`='".$username."' limit 1";
		$pdo->exec($sql);
		push_group_change($pdo,$config,$language,$username,$group['name'],$r['name']);	
	}
}

function group_auto_upgrade_money($pdo,$config,$language,$username){
	if($config['web']['group_upgrade']!='money'){return false;}
	$sql="select `group` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";	
	$user=$pdo->query($sql,2)->fetch(2);
	
	$sql="select sum(`money`) as c from ".$pdo->index_pre."recharge where `username`='".$username."' and `state`=4";	
	$r=$pdo->query($sql,2)->fetch(2);
	$user['money']=$r['c'];
	
	$sql="select `credits`,`name` from ".$pdo->index_pre."group where `id`='".$user['group']."'";
	$group=$pdo->query($sql,2)->fetch(2);
	if($group['credits']<0){return false;}
	$sql="select `id`,`credits`,`name` from ".$pdo->index_pre."group where `id`!=".$user['group']." and `credits`>".$group['credits']." and `credits`<".($user['money']+1)." order by `credits` desc limit 1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==1){return false;}
	if($r['id']!='' && $r['credits']>0){
		$sql="update ".$pdo->index_pre."user set `group`=".$r['id']." where `username`='".$username."' limit 1";
		$pdo->exec($sql);
		push_group_change($pdo,$config,$language,$username,$group['name'],$r['name']);	
	}
}

function login_credits($pdo,$config,$language,$userid,$username,$credits,$reason,$timeoffset){
	$time=time();
	$today=get_date($time,'Y-m-d',$timeoffset);
	$today=get_unixtime($today,'y-m-d');
	$sql="select `id` from ".$pdo->index_pre."user_login where `time`>".$today." and `userid`='".$userid."' limit 1";
	$t_r=$pdo->query($sql,2)->fetch(2);
	if($t_r['id']=='' && $credits>0){
		operation_credits($pdo,$config,$language,$username,$credits,$reason,'login');	
	}
}

function remain_time($language,$second){
	$day=floor($second/(3600*24));
	$second = $second%(3600*24);
	$hour = floor($second/3600);
	$second = $second%3600;
	$minute = floor($second/60);
	$second = $second%60;
	return $day.$language['d2'].$hour.$language['h'].$minute.$language['i'];
}

function clear_attribute_dot($v){
	$a=explode('.',$v);
	$i=0;
	$new='';
	foreach($a as $v){
		if($i==0){
			$new.=$v.'.';	
		}else{
			$new.=$v;	
		}
		$i++;	
	}
	return $new;
}

function write_err_log($path,$sql){
	$old=@file_get_contents($path);	
	$new=$sql."	".date('Y-m-d H:i',time())."\r\n ".$old;
	file_put_contents($path,$new);
}

function isWeiXin(){
	$v=strtolower($_SERVER['HTTP_USER_AGENT']);
	if(strpos($v,'micromessenger')===false){return false;}else{return true;}
}

function reset_weixin_info($wid,$pdo){
	$sql="update ".$pdo->sys_pre."weixin_account set `weixin_token`='' where `wid`='".$wid."' limit 1";
	$pdo->exec($sql);
	set_weixin_info($wid,$pdo);
	return get_weixin_info($wid,$pdo);
}

function set_weixin_info($wid,$pdo){
	$sql="select `AppId`,`AppSecret` from ".$pdo->sys_pre."weixin_account where `wid`='".$wid."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$r=de_safe_str($r);
	if(@$r['AppSecret']==''){
		if(isset($_POST['AppSecret'])){
			$r['AppId']=$_POST['AppId'];
			$r['AppSecret']=$_POST['AppSecret'];
		}else{
			return false;		
		}		
	}
	$config=array();
	$token=@file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$r['AppId'].'&secret='.$r['AppSecret']);
	$token=json_decode($token,1);
	if(!isset($token['access_token'])){return false;}
	$ticket=file_get_contents('https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$token['access_token'].'&type=jsapi');
	//var_dump($ticket);
	$ticket=json_decode($ticket,1);	
	if(!isset($ticket['ticket'])){return false;}
	$_POST['monxin_weixin'][$wid]=array();
	$_POST['monxin_weixin'][$wid]['AppId']=$r['AppId'];
	$_POST['monxin_weixin'][$wid]['token']=$token['access_token'];
	$_POST['monxin_weixin'][$wid]['ticket']=$ticket['ticket'];
	$_POST['monxin_weixin'][$wid]['expires_in']=time()-60;
	$r=json_encode($_POST['monxin_weixin'][$wid]);
	$r=safe_str($r);
	$sql="update ".$pdo->sys_pre."weixin_account set `weixin_token`='".$r."' where `wid`='".$wid."' limit 1";
	$pdo->exec($sql);
	//echo $sql;
	$_POST['monxin_weixin'][$wid]['new']=date('Y-m-d H:i',time());
	return true;	
}

function get_weixin_info($wid,$pdo){
	if(isset($_POST['monxin_weixin'][$wid]['expires_in'])){if(time()<$_POST['monxin_weixin'][$wid]['expires_in']+3600){return true;}}
	if(!table_exist($pdo,$pdo->sys_pre."weixin_account")){return false;}
	$sql="select `weixin_token` from ".$pdo->sys_pre."weixin_account where `wid`='".$wid."' limit 0,1";
	//echo $sql;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['weixin_token']==''){return set_weixin_info($wid,$pdo);}
	
	$r=de_safe_str($r);
	$r=json_decode($r['weixin_token'],1);
	if(count($r)==0){return set_weixin_info($wid,$pdo);}
	$_POST['monxin_weixin'][$wid]=array();
	foreach($r as $k=>$v){
		if($v==''){continue;}
		$_POST['monxin_weixin'][$wid][$k]=$v;	
	}
	//var_dump(date('Y-m-d H:i',$_POST['monxin_weixin'][$wid]['expires_in']));
	
	if(time()<$_POST['monxin_weixin'][$wid]['expires_in']+3600){return true;}else{return  set_weixin_info($wid,$pdo); }
		
}

function get_weixin_js_config($wid,$pdo){
	get_weixin_info($wid,$pdo);
	if(!isset($_POST['monxin_weixin'][$wid]['ticket'])){return false;}
	$_POST['weixin_js_config']['appId'] =$_POST['monxin_weixin'][$wid]['AppId'];
	$_POST['weixin_js_config']['timestamp'] = time();
	$_POST['weixin_js_config']['nonceStr'] = get_random_str(6);
	$_POST['weixin_js_config']['signature']=sha1(sprintf("jsapi_ticket=%s&noncestr=%s&timestamp=%s&url=%s",$_POST['monxin_weixin'][$wid]['ticket'], $_POST['weixin_js_config']['nonceStr'], $_POST['weixin_js_config']['timestamp'],'http://'.get_url()));
		
}

function get_user_openid($pdo,$username){
	$sql="select `openid` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['openid'];
}

function notice_app($pdo,$wid,$data){
	get_weixin_info($wid,$pdo);
	if(!isset($_POST['monxin_weixin'][$wid]['token'])){return false;}
	$r= https_post('https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$_POST['monxin_weixin'][$wid]['token'],$data);
	//file_put_contents('t.txt',$data.' '.$r);
	$r=json_decode($r,1);
	$_POST['notice_app_errcode']=$r['errcode'];
	if($r['errcode']==0){return true;}else{set_weixin_info($wid,$pdo);return false;}
}

function get_weixin_template_id($pdo,$wid,$id){
	get_weixin_info($wid,$pdo);
	if(!isset($_POST['monxin_weixin'][$wid]['token'])){return false;}
	$data='{
           "template_id_short":"'.$id.'"
       }';
	$r= https_post('https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token='.$_POST['monxin_weixin'][$wid]['token'],$data);
	var_dump($r);
	$r=json_decode($r,1);
	if($r['errcode']==0){return $r['template_id'];}else{return false;}
}

function authcode_push($pdo,$config,$language,$username){
	$sql="select `id`,`email`,`phone`,`openid` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){return false;}
	$_SESSION['verification_code']=get_verification_code(6);
	switch($config['web']['authcode_push_mode']){
		case 'sms':
			authcode_push_sms($pdo,$config,$language,$r['phone'],$_SESSION['verification_code']);
			break;	
		case 'email':
			authcode_push_email($pdo,$config,$language,$r['email'],$_SESSION['verification_code']);
			break;	
		case 'openid':
			authcode_push_openid($pdo,$config,$language,$r['openid'],$_SESSION['verification_code']);
			break;	
	}
	return true;	
}
function other_push($pdo,$config,$language,$username,$email_data,$openid_data){
	$sql="select `id`,`email`,`openid` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){return false;}
	$state=false;
	switch($config['web']['other_push_mode']){
		case 'email':
			if($r['email']==''){$config['web']['other_push_mode']='openid';}else{
				$state=other_push_email($pdo,$config,$language,$r['email'],$email_data);
				break;					
			}
		case 'openid':
			if($r['openid']!=''){
				$openid_data=str_replace('{openid}',$r['openid'],$openid_data);
				
				$state=notice_app($pdo,$config['web']['wid'],$openid_data);			
			}elseif($r['email']!=''){
				if($email_data!=''){$state=other_push_email($pdo,$config,$language,$r['email'],$email_data);}else{$state=true;}
				
			}
			break;	
	}
	return $state;
}

function other_push_email($pdo,$config,$language,$email,$data){
	if(!is_email($email) || !isset($data['title'])){return false;}
	//if(email_frequency($pdo,$email)==false){exit("{'state':'fail','info':'".$language['sms_frequent']."'}");}
	if(email($config,$language,$pdo,'monxin',$email,$data['title'],$data['content'])){
		return true;
	}else{
		return false;
	}
}

function authcode_push_sms($pdo,$config,$language,$phone,$code){
	if(!is_match($config['other']['reg_phone'],$phone)){exit("{'state':'fail','info':'".$language['phone'].$language['pattern_err']."','key':'phone'}");}
	//if(sms_frequency($pdo,$phone,$config['sms']['frequency_limit'])==false){exit("{'state':'fail','info':'".$language['sms_frequent']."'}");}
	if(sms($config,$language,$pdo,'monxin',$phone,$code)){
		$success=str_replace('{device}',$language['phone'],$language['verification_code_sent_notice']);
		exit("{'state':'success','info':'".$success."'}");
	}else{
		exit("{'state':'fail','info':'".$language['fail']."'}"); 
	}
}

function authcode_push_email($pdo,$config,$language,$email,$code){
	if(!is_email($email)){exit("{'state':'fail','info':'".$language['email'].$language['pattern_err']."','key':'email'}");}
	//if(email_frequency($pdo,$email)==false){exit("{'state':'fail','info':'".$language['sms_frequent']."'}");}
	$title=$config['web']['name']."-".$language['authcode'];
	$content=$config['web']['name']."-".$language['authcode'].":".$_SESSION['verification_code'];		
	if(email($config,$language,$pdo,'monxin',$email,$title,$content)){
		$success=str_replace('{device}',$language['email'],$language['verification_code_sent_notice']);
		exit("{'state':'success','info':'".$success."'}");
	}else{
		exit("{'state':'fail','info':'".$language['fail']."'}"); 
	}
}

function authcode_push_openid($pdo,$config,$language,$openid,$code){
	$notice=array();
	$notice['touser']=$openid;
	$notice['template_id']=$config['openid_notice_template']['OPENTM203026900'];	
	$notice['url']='http://'.$config['web']['domain'];	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=str_replace('{webname}',$config['web']['name'],$language['verification_code_title']);	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=$code;
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=$language['verification_code_expires_in'];	
	$notice['data']['keyword2']['color']='#173177';	
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['verification_code_remark'];	
	$notice['data']['remark']['color']='#173177';
	$notice=json_encode($notice);
	if(notice_app($pdo,$config['web']['wid'],$notice)){
		$success=str_replace('{device}',$language['openid'],$language['verification_code_sent_notice']);
		exit("{'state':'success','info':'".$success."'}");
	}else{
		if($_POST['notice_app_errcode']==43004){$reason=$language['please_attention_weixin_2'];}else{$reason='';}
		exit("{'state':'fail','info':'".$language['fail']."','reason':'".$reason."'}"); 
	}
}

function push_credits($pdo,$config,$language,$username,$type,$money,$balance){
	if($money>0){$money='+'.$money;}
	$notice=array();
	$notice['touser']='{openid}';	
	$notice['template_id']=$config['openid_notice_template']['TM00335'];	
	$notice['url']='http://'.$config['web']['domain'].'/index.php?monxin=index.credits_log';	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=str_replace('{webname}',$config['web']['name'],$language['verification_code_title']);	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['account']=array();
	$notice['data']['account']['value']=$username;
	$notice['data']['account']['color']='#173177';	
	$notice['data']['time']=array();
	$notice['data']['time']['value']=date('Y-m-d H:i');	
	$notice['data']['time']['color']='#173177';	
	$notice['data']['type']=array();
	$notice['data']['type']['value']=$language['credits_type'][$type];	
	$notice['data']['type']['color']='#173177';
	$notice['data']['number']=array();
	$notice['data']['number']['value']=$money;	
	$notice['data']['number']['color']='#173177';
	$notice['data']['amount']=array();
	$notice['data']['amount']['value']=$balance;	
	$notice['data']['amount']['color']='#173177';
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['click_view_more'];	
	$notice['data']['remark']['color']='#173177';
	$email=$notice['data'];
	$email['account']['label']=$language['username'];
	$email['time']['label']=$language['time'];
	$email['type']['label']=$language['type'];
	$email['number']['label']=$language['credits'];
	$email['amount']['label']=$language['user_money'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['TM00335'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	$notice=json_encode($notice);
	other_push($pdo,$config,$language,$username,$email_data,$notice);
}

function push_audit($pdo,$config,$language,$username,$project,$state){
	$notice=array();
	$notice['touser']='{openid}';
	$notice['template_id']=$config['openid_notice_template']['OPENTM205258520'];	
	$notice['url']='http://'.$config['web']['domain'];	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=str_replace('{webname}',$config['web']['name'],$language['verification_code_title']);	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=$username;
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=$project;
	$notice['data']['keyword2']['color']='#173177';	
	$notice['data']['keyword3']=array();
	$notice['data']['keyword3']['value']=$state;	
	$notice['data']['keyword3']['color']='#173177';	
	$notice['data']['keyword4']=array();
	$notice['data']['keyword4']['value']=date('Y-m-d H:i');	
	$notice['data']['keyword4']['color']='#173177';	
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['relist'];	
	$notice['data']['remark']['color']='#173177';
	
	$email=$notice['data'];
	$email['keyword1']['label']=$language['username'];
	$email['keyword2']['label']=$language['content'];
	$email['keyword3']['label']=$language['state'];
	$email['keyword4']['label']=$language['time'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['OPENTM205258520'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	
	$notice=json_encode($notice);
	
	other_push($pdo,$config,$language,$username,$email_data,$notice);
	//notice_app($pdo,$config['web']['wid'],$notice);	
}
function push_group_change($pdo,$config,$language,$username,$old,$new){
	$notice=array();
	$notice['touser']='{openid}';
	$notice['template_id']=$config['openid_notice_template']['TM00891'];	
	$notice['url']='http://'.$config['web']['domain'];	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=str_replace('{webname}',$config['web']['name'],$language['verification_code_title']).' '.$username;	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['grade1']=array();
	$notice['data']['grade1']['value']=$old;
	$notice['data']['grade1']['color']='#173177';	
	$notice['data']['grade2']=array();
	$notice['data']['grade2']['value']=$new;
	$notice['data']['grade2']['color']='#173177';
	$notice['data']['time']=array();
	$notice['data']['time']['value']=date('Y-m-d H:i');	
	$notice['data']['time']['color']='#173177';	
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['remark'];	
	$notice['data']['remark']['color']='#173177';
	
	$email=$notice['data'];
	$email['grade1']['label']=$language['old_group'];
	$email['grade2']['label']=$language['new_group'];
	$email['time']['label']=$language['time'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['TM00891'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	
	$notice=json_encode($notice);
	
	other_push($pdo,$config,$language,$username,$email_data,$notice);
	//notice_app($pdo,$config['web']['wid'],$notice);	
}

function push_money_add_info($pdo,$config,$language,$username,$reason,$money,$balance){
	$reason=strip_tags($reason);
	$balance=sprintf("%.2f",$balance);
	$notice=array();
	$notice['touser']='{openid}';
	$notice['template_id']=$config['openid_notice_template']['OPENTM405465388'];	
	$notice['url']='http://'.$config['web']['domain'].'/index.php?monxin=index.money_log';	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=str_replace('{webname}',$config['web']['name'],$language['verification_code_title']).' '.$username;	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=$reason;
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=$money;
	$notice['data']['keyword2']['color']='#173177';
	$notice['data']['keyword3']=array();
	$notice['data']['keyword3']['value']=date('Y-m-d H:i').' '.$language['balance'].': '.$balance;	
	$notice['data']['keyword3']['color']='#173177';	
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['click_view_more'];	
	$notice['data']['remark']['color']='#173177';
	
	$email=$notice['data'];
	$email['keyword1']['label']=$language['reason'];
	$email['keyword2']['label']=$language['money'];
	$email['keyword3']['label']=$language['time'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['OPENTM405465388'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	
	$notice=json_encode($notice);
	other_push($pdo,$config,$language,$username,$email_data,$notice);
}

function push_money_deduction_info($pdo,$config,$language,$username,$reason,$money,$balance){
	$reason=strip_tags($reason);
	$balance=sprintf("%.2f",$balance);
	$notice=array();
	$notice['touser']='{openid}';
	$notice['template_id']=$config['openid_notice_template']['OPENTM204690186'];	
	$notice['url']='http://'.$config['web']['domain'].'/index.php?monxin=index.money_log';	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=str_replace('{webname}',$config['web']['name'],$language['verification_code_title']).' '.$username;	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=date('Y-m-d H:i');	
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=$money;
	$notice['data']['keyword2']['color']='#173177';	
	$notice['data']['keyword3']=array();
	$notice['data']['keyword3']['value']=$balance;
	$notice['data']['keyword3']['color']='#173177';
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['reason'].':'.$reason;	
	$notice['data']['remark']['color']='#173177';
	
	$email=$notice['data'];
	$email['keyword1']['label']=$language['time'];
	$email['keyword2']['label']=$language['money'];
	$email['keyword3']['label']=$language['balance'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['OPENTM204690186'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	
	$notice=json_encode($notice);
	other_push($pdo,$config,$language,$username,$email_data,$notice);
}


function push_new_order_info($pdo,$config,$language,$username,$title,$shop_name,$goods_name,$money,$state,$id){
	$notice=array();
	$notice['touser']='{openid}';
	$notice['template_id']=$config['openid_notice_template']['OPENTM200750297'];	
	$notice['url']='http://'.$config['web']['domain'].'/index.php?monxin=mall.order_admin&search='.$id;	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=$title;	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=$shop_name;	
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=$goods_name;
	$notice['data']['keyword2']['color']='#173177';	
	$notice['data']['keyword3']=array();
	$notice['data']['keyword3']['value']=date('Y-m-d H:i',time());
	$notice['data']['keyword3']['color']='#173177';
	$notice['data']['keyword4']=array();
	$notice['data']['keyword4']['value']=$money;
	$notice['data']['keyword4']['color']='#173177';
	$notice['data']['keyword5']=array();
	$notice['data']['keyword5']['value']=$language['pay_state_option'][$state];
	$notice['data']['keyword5']['color']='#173177';
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['click_view_more'];	
	$notice['data']['remark']['color']='#173177';
	
	$email=$notice['data'];
	$email['keyword1']['label']=$language['shop_name'];
	$email['keyword2']['label']=$language['goods_name'];
	$email['keyword3']['label']=$language['order_time'];
	$email['keyword4']['label']=$language['order_money'];
	$email['keyword5']['label']=$language['pay_state'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['OPENTM200750297'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	
	$notice=json_encode($notice);
	other_push($pdo,$config,$language,$username,$email_data,$notice);
}


function push_cancel_order_info($pdo,$config,$language,$username,$title,$id,$money,$page,$goods_name){
	$notice=array();
	$notice['touser']='{openid}';
	$notice['template_id']=$config['openid_notice_template']['OPENTM201490123'];	
	$notice['url']='http://'.$config['web']['domain'].'/index.php?monxin='.$page.'&search='.$id;	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=$title;	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=$id;	
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=$goods_name;
	$notice['data']['keyword2']['color']='#173177';	
	$notice['data']['keyword3']=array();
	$notice['data']['keyword3']['value']=$money;
	$notice['data']['keyword3']['color']='#173177';
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['click_view_more'];	
	$notice['data']['remark']['color']='#173177';
	
	$email=$notice['data'];
	$email['keyword1']['label']=$language['orderid'];
	$email['keyword2']['label']=$language['goods_name'];
	$email['keyword3']['label']=$language['order_money'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['OPENTM201490123'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	$notice=json_encode($notice);
	other_push($pdo,$config,$language,$username,$email_data,$notice);
}

function push_send_order_info($pdo,$config,$language,$username,$title,$id,$company,$code,$url){
	$notice=array();
	$notice['touser']='{openid}';
	$notice['template_id']=$config['openid_notice_template']['OPENTM200565259'];	
	$notice['url']=$url;	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=$title;	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=$id;	
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=$company;
	$notice['data']['keyword2']['color']='#173177';	
	$notice['data']['keyword3']=array();
	$notice['data']['keyword3']['value']=$code;
	$notice['data']['keyword3']['color']='#173177';
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['click_view_more'];	
	$notice['data']['remark']['color']='#173177';
	
	$email=$notice['data'];
	$email['keyword1']['label']=$language['orderid'];
	$email['keyword2']['label']=$language['logistics_company'];
	$email['keyword3']['label']=$language['logistics_code'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['OPENTM200565259'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	$notice=json_encode($notice);
	other_push($pdo,$config,$language,$username,$email_data,$notice);
}



function push_send_cabinet_info($pdo,$config,$language,$username,$title,$id,$number,$code,$url,$remark){
	$remark=str_replace("\n ","\n",$remark);
	$remark=str_replace("\n ","\n",$remark);
	$remark=str_replace("\n ","\n",$remark);
	$remark=str_replace("\n ","\n",$remark);
	$notice=array();
	$notice['touser']='{openid}';
	$notice['template_id']=$config['openid_notice_template']['OPENTM415477209'];	
	$notice['url']=$url;	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=$title;	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=$id;	
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=$number;
	$notice['data']['keyword2']['color']='#173177';	
	$notice['data']['keyword3']['value']=$code;
	$notice['data']['keyword3']['color']='#173177';	
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$remark;	
	$notice['data']['remark']['color']='#173177';
	
	$email=$notice['data'];
	$email['keyword1']['label']=$language['orderid'];
	$email['keyword2']['label']=$language['cabinet_number'];
	$email['keyword3']['label']=$language['password'];
	$email['keyword4']['label']=$language['time'];
	
	
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['OPENTM415477209'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.@$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	$notice=json_encode($notice);
	other_push($pdo,$config,$language,$username,$email_data,$notice);
}

function push_order_apply_refund_info($pdo,$config,$language,$username,$title,$goods_name,$money,$id,$reason){
	$notice=array();
	$notice['touser']='{openid}';
	$notice['template_id']=$config['openid_notice_template']['OPENTM204146731'];	
	$notice['url']='http://'.$config['web']['domain'].'/index.php?monxin=mall.order_admin&search='.$id;	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=$title;	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=$id;	
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=$goods_name;
	$notice['data']['keyword2']['color']='#173177';	
	$notice['data']['keyword3']=array();
	$notice['data']['keyword3']['value']=$money;
	$notice['data']['keyword3']['color']='#173177';
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$reason.' '.$language['click_view_more'];	
	$notice['data']['remark']['color']='#173177';
	
	$email=$notice['data'];
	$email['keyword1']['label']=$language['orderid'];
	$email['keyword2']['label']=$language['goods_name'];
	$email['keyword3']['label']=$language['money'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['OPENTM204146731'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	
	$notice=json_encode($notice);
	other_push($pdo,$config,$language,$username,$email_data,$notice);
}

function push_order_agree_refund_info($pdo,$config,$language,$username,$title,$goods_name,$money,$id){
	$notice=array();
	$notice['touser']='{openid}';
	$notice['template_id']=$config['openid_notice_template']['OPENTM202849987'];	
	$notice['url']='http://'.$config['web']['domain'].'/index.php?monxin=mall.my_order&search='.$id;	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=$title;	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=$id;	
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=$goods_name;
	$notice['data']['keyword2']['color']='#173177';	
	$notice['data']['keyword3']=array();
	$notice['data']['keyword3']['value']=$money;
	$notice['data']['keyword3']['color']='#173177';
	$notice['data']['keyword4']=array();
	$notice['data']['keyword4']['value']=date('Y-m-d H:i',time());
	$notice['data']['keyword4']['color']='#173177';
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['click_view_more'];	
	$notice['data']['remark']['color']='#173177';
	
	$email=$notice['data'];
	$email['keyword1']['label']=$language['orderid'];
	$email['keyword2']['label']=$language['goods_name'];
	$email['keyword3']['label']=$language['money'];
	$email['keyword3']['label']=$language['time'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['OPENTM202849987'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	
	$notice=json_encode($notice);
	other_push($pdo,$config,$language,$username,$email_data,$notice);
}

function push_login_info($pdo,$config,$language,$username){
	$notice=array();
	$notice=array();
	$notice['touser']='{openid}';
	$notice['template_id']=$config['openid_notice_template']['OPENTM201673425'];	
	$notice['url']='http://'.$config['web']['domain'].'/index.php?monxin=index.edit_user&field=password';	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=str_replace('{webname}',$config['web']['name'],$language['login_notice_app_title']);	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=$username;
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=date('Y-m-d H:i',time());	
	$notice['data']['keyword2']['color']='#173177';	
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['login_notice_app_remark'];	
	$notice['data']['remark']['color']='#173177';
	
	
	$email=$notice['data'];
	$email['keyword1']['label']=$language['username'];
	$email['keyword2']['label']=$language['time'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['OPENTM201673425'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	
	$notice=json_encode($notice);
	other_push($pdo,$config,$language,$username,$email_data,$notice);
}

function push_new_msg_info($pdo,$config,$language,$username,$with,$content,$url,$first){
	$notice=array();
	$notice=array();
	$content=strip_tags($content);
	if($content==''){$content='***';}
	$notice['touser']='{openid}';
	$notice['template_id']=$config['openid_notice_template']['OPENTM202119578'];	
	$notice['url']=$url;	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=$first;	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=$with;
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=$content;	
	$notice['data']['keyword2']['color']='#173177';	
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['click'].$language['reply'];	
	$notice['data']['remark']['color']='#173177';
	
	
	$email=$notice['data'];
	$email['keyword1']['label']=$language['username'];
	$email['keyword2']['label']=$language['content'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['OPENTM202119578'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	
	$notice=json_encode($notice);
	other_push($pdo,$config,$language,$username,$email_data,$notice);
}



function get_circle_option($pdo){
	$sql="select `id`,`name` from ".$pdo->index_pre."circle where `parent_id`=0 and `visible`=1 order by `sequence` desc,`id` asc";
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$list.='<option value="'.$v['id'].'">'.de_safe_str($v['name']).'</option>';
		$sql="select `id`,`name` from ".$pdo->index_pre."circle where `parent_id`='".$v['id']."' and `visible`=1 order by `sequence` desc,`id` asc";
		$r2=$pdo->query($sql,2);
		foreach($r2 as $v2){
			$list.='<option value="'.$v2['id'].'">&nbsp;&nbsp;'.de_safe_str($v2['name']).'</option>';	
		}
	}
	return $list;
}

function get_circle_ids($pdo,$circle){
	$sql="select `id` from ".$pdo->index_pre."circle where `parent_id`=".$circle;
	$r=$pdo->query($sql,2);
	$circle.=',';
	foreach($r as $v){
		$circle.=$v['id'].',';	
	}
	return trim($circle,',');
}

function get_circle_name($pdo,$circle){
	$sql="select `name` from ".$pdo->index_pre."circle where `id`=".$circle;
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['name'];
}

function get_color_array($pdo){
	if(isset($_COOKIE['user_set_color']) && intval($_COOKIE['user_set_color'])>0){
		$sql="select `data` from ".$pdo->index_pre."color where `id`=".intval($_COOKIE['user_set_color'])." and `data`!=''";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['data']==''){
			$sql="select `data` from ".$pdo->index_pre."color where `data`!='' order by `sequence` desc limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
		}	
	}else{
		$sql="select `data` from ".$pdo->index_pre."color where `data`!='' order by `sequence` desc limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);		
	}
	if($r['data']==''){return '';}
	//var_dump(de_safe_str($r['data']));
	$color=json_decode(de_safe_str($r['data']),1);
	//var_dump($color);
	return 	$color;
}
function get_color_data($pdo){
	if(isset($_COOKIE['user_set_color']) && intval($_COOKIE['user_set_color'])>0){
		$sql="select `data` from ".$pdo->index_pre."color where `id`=".intval($_COOKIE['user_set_color'])." and `data`!=''";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['data']==''){
			$sql="select `data` from ".$pdo->index_pre."color where `data`!='' order by `sequence` desc limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
		}	
	}else{
		$sql="select `data` from ".$pdo->index_pre."color where `data`!='' order by `sequence` desc limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);		
	}
	if($r['data']==''){return '';}
	//var_dump(de_safe_str($r['data']));
	$color=json_decode(de_safe_str($r['data']),1);
	//var_dump($color);
	return 	color_to_css($color);
}

function color_to_css($color){
	$css="<style>
		[user_color='head']{ border-color:".$color['head']['border']."; background:".$color['head']['background']."; color:".$color['head']['text'].";}
		[user_color='head'] a{color:".$color['head']['text'].";}
		[user_color='head'] input,[user_color='head'] select,[user_color='head'] textarea{background:".$color['head']['background']."; color:".$color['head']['text'].";}

		[user_color='container'],#mall_layout{ border-color:".@$color['container']['border']."; background:".$color['container']['background']."; color:".$color['container']['text'].";}
		
		[user_color='container'] a,#mall_layout a{ color:".$color['container']['text'].";}
		.sum_card .card_head{background:".$color['shape_head']['background']."; color:".$color['shape_head']['text'].";}
		[user_color='shape_head']{ border-color:".$color['shape_head']['border']."; background:".$color['shape_head']['background']."; color:".$color['shape_head']['text'].";}
		[user_color='shape_head'] a{color:".$color['shape_head']['text'].";}
		[user_color='shape_head'] input,[user_color='shape_head'] select,[user_color='shape_head'] textarea{background:".$color['shape_head']['background']."; color:".$color['shape_head']['text'].";}
		.caption{color:".$color['shape_head']['background']."; }
		[user_color='shape_bottom']{ border-color:".$color['shape_bottom']['border']."; background:".$color['shape_bottom']['background']."; color:".$color['shape_bottom']['text'].";}
		[user_color='shape_bottom'] a{  color:".$color['shape_bottom']['text'].";}
		[user_color='shape_bottom'] input,[user_color='shape_bottom'] select,[user_color='shape_bottom'] textarea{background:".$color['shape_bottom']['background']."; color:".$color['shape_bottom']['text'].";}

		[user_color='nv_1']{ border-color:".$color['nv_1']['border']."; background:".$color['nv_1']['background']."; color:".$color['nv_1']['text'].";}
		[user_color='nv_1'] > a{ border-color:".$color['nv_1']['border']."; background:".$color['nv_1']['background']."; color:".$color['nv_1']['text'].";}
		[user_color='nv_1']:hover{ border-color:".$color['nv_1_hover']['border']."; background:".$color['nv_1_hover']['background']."; color:".$color['nv_1_hover']['text'].";}
		.dropdown-menu li:hover{background:".$color['nv_1_hover']['background']."; color:".$color['nv_1_hover']['text'].";}
		.dropdown-menu li:hover a{color:".$color['nv_1_hover']['text'].";}

		[user_color='nv_1']:hover a{ border-color:".$color['nv_1_hover']['border']."; background:".$color['nv_1_hover']['background']."; color:".$color['nv_1_hover']['text'].";}
		[user_color='nv_2']{ border-color:".$color['nv_2']['border']."; background:".$color['nv_2']['background']."; color:".$color['nv_2']['text'].";}
		[user_color='nv_2']>a{ border-color:".$color['nv_2']['border']."; background:".$color['nv_2']['background']."; color:".$color['nv_2']['text'].";}
		[user_color='nv_2']:hover{ border-color:".$color['nv_2_hover']['border']."; background:".$color['nv_2_hover']['background']."; color:".$color['nv_2_hover']['text'].";}
		[user_color='nv_2']:hover a{ border-color:".$color['nv_2_hover']['border']."; background:".$color['nv_2_hover']['background']."; color:".$color['nv_2_hover']['text'].";}
		[user_color='nv_3']{ border-color:".$color['nv_3']['border']."; background:".$color['nv_3']['background']."; color:".$color['nv_3']['text'].";}
		[user_color='nv_3']>a{ border-color:".$color['nv_3']['border']."; background:".$color['nv_3']['background']."; color:".$color['nv_3']['text'].";}
		[user_color='nv_3']:hover{ border-color:".$color['nv_3_hover']['border']."; background:".$color['nv_3_hover']['background']."; color:".$color['nv_3_hover']['text'].";}
		[user_color='nv_3']:hover a{ border-color:".$color['nv_3_hover']['border']."; background:".$color['nv_3_hover']['background']."; color:".$color['nv_3_hover']['text'].";}

		
		[user_color='container'] [monxin-module]{ border-color:".$color['module']['border']."; background:".$color['module']['background']."; color:".$color['module']['text'].";}
		[user_color='container'] [monxin-module] a{ color:".$color['module']['text'].";}
		[user_color='container'] [monxin-module] input,[user_color='container'] [monxin-module] select,[user_color='container'] [monxin-module] textarea{background:".$color['module']['background']."; color:".$color['module']['text'].";}
		.portlet{box-shadow: 0px 2px 5px 2px ".$color['module']['border'].";}
		
		.table_scroll table{ border-color:".$color['table']['border'].";  background:".$color['table']['thead_background']."; color:".$color['table']['thead_text'].";}
		.table_scroll{ border:1px solid ".$color['table']['border'].";}
		.table_scroll table tr td{ border-color:".$color['table']['border']."; }
		.table_scroll table thead{ border-color:".$color['table']['border']."; background:".$color['table']['thead_background']."; color:".$color['table']['thead_text'].";}
		.table_scroll table thead a{ color:".$color['table']['thead_text'].";}
		
		.table_scroll table tbody tr:nth-of-type(odd){ border-color:".$color['table']['border']."; background:".$color['table']['odd_background']."; color:".$color['table']['odd_text'].";}
		.table_scroll table tbody tr:nth-of-type(odd) input,.table_scroll table tbody tr:nth-of-type(odd) select,.table_scroll table tbody tr:nth-of-type(odd) textarea{  background:".$color['table']['odd_background']."; color:".$color['table']['odd_text'].";}
		.table_scroll table tbody tr:nth-of-type(odd) a{  color:".$color['table']['odd_text'].";}
		
		.table_scroll table tbody tr:nth-of-type(even){ border-color:".$color['table']['border']."; background:".$color['table']['even_background']."; color:".$color['table']['even_text'].";}
		.table_scroll table tbody tr:nth-of-type(even) input,.table_scroll table tbody tr:nth-of-type(even) select,.table_scroll table tbody tr:nth-of-type(even) textarea{  background:".$color['table']['even_background']."; color:".$color['table']['even_text'].";}
		.table_scroll table tbody tr:nth-of-type(even) a{color:".$color['table']['even_text'].";}
		
		.table_scroll table tbody tr:hover{ border-color:".$color['table']['border']."; background:".$color['table']['hover_background']."; color:".$color['table']['hover_text'].";}
		.table_scroll table tbody tr:hover a{ color:".$color['table']['hover_text'].";}

		.container [user_color='page']{ border-color:".$color['page']['border']."; background:".$color['page']['background']."; color:".$color['page']['text'].";}
		.container [user_color='page'] a{ border-color:".$color['page']['border']."; background:".$color['page']['background']."; color:".$color['page']['text'].";}
		.container [user_color='page'] a:hover{ border-color:".$color['page']['border']."; background:".$color['page']['hover_background']."; color:".$color['page']['text'].";}
		.container [user_color='page'] .active a{ border-color:".$color['page']['border']."; background:".$color['page']['current_background']."; color:".$color['page']['current_text'].";}
		.container [user_color='page'] .active:hover a{ border-color:".$color['page']['border']."; background:".$color['page']['current_background']."; color:".$color['page']['current_text'].";}
		
		.container [user_color='button'],.submit,#submit,.add,.btn,.replace,.increase,#add{ border-color:".$color['button']['border']."; background:".$color['button']['background']."; color:".$color['button']['text'].";}
		.container [user_color='button']:hover,.submit:hover,#submit:hover,.add:hover,.replace:hover,.increase:hover,#add:hover{border-color:".$color['button_hover']['border']."; background:".$color['button_hover']['background']."; color:".$color['button_hover']['text'].";}
		.container [user_color='button'] .view{color:".$color['button_hover']['text'].";}
		
		#icons li a img{ border-color:".$color['button']['border']."; background:".$color['button']['background']."; color:".$color['button']['text'].";}
		#icons li a img:hover{border-color:".$color['button_hover']['border']."; background:".$color['button_hover']['background']."; color:".$color['button_hover']['text'].";}
		
	</style>";
	return $css;
}
	
function send_info_to_openid($pdo,$wid,$username,$content){
	get_weixin_info($wid,$pdo);
	if(!isset($_POST['monxin_weixin'][$wid]['token'])){return false;}
	$sql="select `openid` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['openid']==''){return false;}
	$v='{
"touser":"'.de_safe_str($r['openid']).'",
"msgtype":"text",
"text":
{
	 "content":"'.$content.'"
}
}  ';
	$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$_POST['monxin_weixin'][$wid]['token'];
	$r=https_post($url,$v);
	$r=json_decode($r,1);
	if($r['errcode']!=0){return $r['errmsg'];}else{return true;}

}	

function get_distance($lat1, $lng1, $lat2, $lng2){ 
	$earthRadius = 6367000; 
	$lat1 = ($lat1 * pi() ) / 180; 
	$lng1 = ($lng1 * pi() ) / 180; 
	$lat2 = ($lat2 * pi() ) / 180; 
	$lng2 = ($lng2 * pi() ) / 180; 
	$calcLongitude = $lng2 - $lng1; 
	$calcLatitude = $lat2 - $lat1; 
	$stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2); 
	$stepTwo = 2 * asin(min(1, sqrt($stepOne))); 
	$calculatedDistance = $earthRadius * $stepTwo; 
	return round($calculatedDistance); 
} 

function format_distance($v){
	if($v>999){
		return sprintf("%.1f",($v/1000)).'km';
	}else{
		return $v.'m';
	}
	return $v;
}

function safe_order_by($v){
	$v=explode("|",$v);
	if(strlen($v[0])>16){$v[0]='id';}	
	if($v[1]!='asc'){$v[1]='desc';}	
	return $v;
}


  //GCJ-02(火星，高德) 坐标转换成 BD-09(百度) 坐标
  	//@param bd_lon 百度经度
    //@param bd_lat 百度纬度
  function bd_encrypt($gg_lon,$gg_lat){
    $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
    $x = $gg_lon;
    $y = $gg_lat;
    $z = sqrt($x * $x + $y * $y) - 0.00002 * sin($y * $x_pi);
    $theta = atan2($y, $x) - 0.000003 * cos($x * $x_pi);
    $data['0'] = $z * cos($theta) + 0.0065;
    $data['1'] = $z * sin($theta) + 0.006;
    return $data;
  }
  //BD-09(百度) 坐标转换成  GCJ-02(火星，高德) 坐标
  	//@param bd_lon 百度经度
    //@param bd_lat 百度纬度
  function bd_decrypt($bd_lon,$bd_lat){
    $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
    $x = $bd_lon - 0.0065;
    $y = $bd_lat - 0.006;
    $z = sqrt($x * $x + $y * $y) - 0.00002 * sin($y * $x_pi);
    $theta = atan2($y, $x) - 0.000003 * cos($x * $x_pi);
    $data['0'] = $z * cos($theta);
    $data['1'] = $z * sin($theta);
    return $data;
  }
  
  function t_browser($v){
	  $v[0]=$v[0]+0.005;
	  $v[1]=$v[1]+0.005;
	  return $v;
	}
	
	function set_sql_cache($config,$sql,$c){
		if(!$config['cache']['sql_cache_switch']){return false;}
		@mkdir('./cache');
		$key=md5($sql);
		$cache_path='./cache/sql/'.$key.'.json';
		//var_dump($c);
		$c=json_encode($c);
		if($config['cache']['cache_type']=='file'){
			if(!@file_put_contents($cache_path,$c)){
				require_once 'lib/Dir.class.php';
				$dir=new Dir();
				$dir->del_dir('./cache/sql/');
				mkdir('./cache/sql/');
				file_put_contents($cache_path,$c);
			}
		}else{
			if(in_array('memcache',$php_extensions)){
				$memcache=new Memcache;
				$memcache->connect("localhost",11211);
				$memcache->add($cache_path,$c,MEMCACHE_COMPRESSED,$config['cache']['cache_time']);
				//$memcache->set($cache_path,$c,MEMCACHE_COMPRESSED,$config['cache']['cache_time']);
				$memcache->close();
				}
		}	
	
		return true;
	}

	function get_sql_cache($config,$sql){
		if(!$config['cache']['sql_cache_switch']){return false;}
		//echo 'get';
		$key=md5($sql);
		$cache_path='./cache/sql/'.$key.'.json';
		
		if($config['cache']['cache_type']=='file'){
			$cache_file_time=@filemtime($cache_path)+$config['cache']['cache_time'];
			//echo $cache_file_time.'-'.time().'='.$cache_file_time-time();
			if($cache_file_time>time()){
				/*echo 'I am cache<br/>';*/
				$r=file_get_contents($cache_path);
				$r=json_decode($r,1);
				return $r;
			}
		}else{
			$php_extensions=get_loaded_extensions();
			if(in_array('memcache',$php_extensions)){
				@$memcache=new Memcache;
				@$memcache->connect($config['cache']['memcache_host'],$config['cache']['memcache_port']);
				@$r=$memcache->get($cache_path);
				@$memcache->close();
				if(!empty($r)){
					$r=json_decode($r,1);
					return $r;
				}
			}
		}	
		
		return false;	
	}
	
	function safe_path($v){
		$v=str_replace('..','',$v);	
		$v=trim($v,'/');
		return $v;	
	}
	
	function safe_rename($old,$new){
		$old=str_ireplace('temp/..','temp/',$old);
		compress_img($old,-1);
		return rename($old,$new);
	}
	
	function compress_img($path,$max){
		//compress_img($path,self::$config['web']['img_max']);
		if(in_array(substr($path,strlen($path)-4,4),array('.png','.jpg','.gif'))){
			if($max==-1){
				$config=require('./config.php');
				$max=$config['web']['img_max'];
			}
			$max=intval($max);
			if($max==0){$max=1024;}
			$file_size=sprintf("%u",filesize($path));
			if($file_size/1024>$max){
				$image =new Image();
				$state=$image->thumb($path,$path,1920,-1);
			}
		}
	}
	
	function safe_unlink($v){
		$v=str_ireplace('../','',$v);
		@unlink($v);
	}
	
	
	function inquiries_pay_state($config,$type,$in_id){
		//$r=inquiries_pay_state(self::$config,'weixin','20160817111120');
		if(is_local($config['web']['domain'])){return false;}
		if(strpos($type,'scanpay_')!==false){
			$url='http://'.$config['web']['domain'].'/scanpay_type/'.str_replace('scanpay_','',$type).'/inquiry.php?in_id='.$in_id;
		}else{
			$url='http://'.$config['web']['domain'].'/payment/'.$type.'/inquire.php?in_id='.$in_id;
		}		
		$r=file_get_contents($url);
		//file_put_contents('t.txt',$url.'<br />'.$r);
		if($r=='success'){return true;}else{return false;}	
	}
	
	

	
	function wexin_red_pack($pdo,$username,$sender,$wishing,$money,$program){
		//wexin_red_pack($pdo,$_SESSION['monxin']['username'],$sender,$wishing,$money,'prize')
		//if(!$r){echo($_POST['err_code_des']);}else{}
		$sql="select `openid` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
		$user=$pdo->query($sql,2)->fetch(2);
		if($user['openid']==''){$_POST['err_code_des']='openid is null';return false;}
		$wxid= date('YmdHis').rand(10, 99);
		$sql="insert into ".$pdo->index_pre."wxpay (`time`,`username`,`openid`,`money`,`reason`,`operator`,`program`,`ip`,`send_state`,`receive_state`,`type`,`wxid`) values ('".time()."','".$username."','".$user['openid']."','".$money."','".$sender.','.$wishing."','".@$_SESSION['monxin']['username']."','".$program."','".get_ip()."','0','0','0','".$wxid."')";
		if(!$pdo->exec($sql)){$_POST['err_code_des']='insert redpack err';return false;}
		$log_id=$pdo->lastInsertId();
		$config=require('./payment/weixin/config.php');
		if($config['state']!='opening'){$_POST['err_code_des']='weixin pay not is opening';return false;}

		 $money = $money*100;
		 $obj2 = array();
		 $obj2['wxappid']         	= $config['appid'];
		 $obj2['mch_id']         	= $config['mchid'];
		 $obj2['mch_billno']			=  $wxid;
		 $obj2['client_ip']    		= $_SERVER['REMOTE_ADDR'];
		 $obj2['re_openid']         	= $user['openid'];
		 $obj2['total_amount']       = $money;
		 $obj2['min_value']         	= $money;
		 $obj2['max_value']         	= $money;
		 $obj2['total_num']         	= 1;
		 $obj2['nick_name']      	= $sender;
		 $obj2['send_name']      	= $sender;
		 $obj2['wishing']        	= $wishing;
		 $obj2['act_name']      	= $sender;
		 $obj2['remark']      		= $sender;

		// var_dump($obj2);

		 $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
		 $wxHongBaoHelper2 = new WxPay();
		 $result = $wxHongBaoHelper2->pay($url, $obj2,$config);
		 //var_dump( $result);
		if($result){
			$result = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);
			if($result->result_code=='SUCCESS'){
				$sql="update ".$pdo->index_pre."wxpay set `send_state`=1 where `id`=".$log_id;
				$pdo->exec($sql);
				return true;
			}else{
				$_POST['err_code_des']=$result->err_code_des;return false;
			}
		}else{
			$_POST['err_code_des']='';return false;	
		}
	
	}
	
	
	function wexin_red_pack_inquiry($pdo,$id){
		$config=require('./payment/weixin/config.php');
		if($config['state']!='opening'){$_POST['err_code_des']='weixin pay not is opening';return false;}
		$sql="select `wxid` from ".$pdo->index_pre."wxpay where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['wxid']==0){return false;}
		$obj2 = array();
		$obj2['appid']         	= $config['appid'];
		$obj2['mch_id']         	= $config['mchid'];
		$obj2['mch_billno']			= $r['wxid'];
		$obj2['bill_type']        	= "MCHT";
		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/gethbinfo';
		$wxHongBaoHelper4 = new WxPay();
		$result = $wxHongBaoHelper4->pay($url, $obj2,$config);
		if($result){
			$result = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);	
			if($result->status=='RECEIVED'){
				$sql="update ".$pdo->index_pre."wxpay set `receive_state`=1 where `id`=".$id;	
				$pdo->exec($sql);
			}
			return $result->status;
		}else{return false;}
	}
	
	
	function wexin_transfers($pdo,$username,$sender,$money,$program){
		//$r=wexin_transfers($pdo,$_SESSION['monxin']['username'],self::$config['web']['name'].' '.self::$language['withdraw'],1,'index');
		//if(!$r){echo($_POST['err_code_des']);}else{}
		$sql="select `openid` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
		$user=$pdo->query($sql,2)->fetch(2);
		if($user['openid']==''){$_POST['err_code_des']='openid is null';return false;}
		$wxid= date('YmdHis').rand(10, 99);

		$sql="insert into ".$pdo->index_pre."wxpay (`time`,`username`,`openid`,`money`,`reason`,`operator`,`program`,`ip`,`send_state`,`receive_state`,`type`,`wxid`) values ('".time()."','".$username."','".$user['openid']."','".$money."','".$sender."','".@$_SESSION['monxin']['username']."','".$program."','".get_ip()."','0','0','1','".$wxid."')";
		if(!$pdo->exec($sql)){$_POST['err_code_des']='insert redpack err';return false;}
		$log_id=$pdo->lastInsertId();
		$config=require('./payment/weixin/config.php');
		if($config['state']!='opening'){$_POST['err_code_des']='weixin pay not is opening';return false;}

		 $money = $money*100;
		 $obj1 = array();
		 
		 $obj1['openid']         	= $user['openid'];
		 $obj1['amount']         	= $money;
		 $obj1['desc']        		=$sender;
		 $obj1['mch_appid']         	= $config['appid'];
		 $obj1['mchid']         		= $config['mchid'];
		 $obj1['partner_trade_no']	= $wxid;
		 $obj1['spbill_create_ip']   = $_SERVER['REMOTE_ADDR'];
		 $obj1['check_name']      	= "NO_CHECK";
		 $obj1['re_user_name']    	= "";
		 
		 

		// var_dump($obj2);

		 $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
		 $wxHongBaoHelper2 = new WxPay();
		 $result = $wxHongBaoHelper2->pay($url, $obj1,$config);
		 //var_dump( $result);
		if($result){
			$result = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);
			if($result->result_code=='SUCCESS'){
				$sql="update ".$pdo->index_pre."wxpay set `send_state`=1,`receive_state`=1 where `id`=".$log_id;
				$pdo->exec($sql);
				return true;
			}else{
				$_POST['err_code_des']=$result->err_code_des;return false;
			}
		}else{
			$_POST['err_code_des']='';return false;	
		}
	
	}
	

	function wexin_transfers_inquiry($pdo,$id){
		$config=require('./payment/weixin/config.php');
		if($config['state']!='opening'){$_POST['err_code_des']='weixin pay not is opening';return false;}
		$sql="select `wxid` from ".$pdo->index_pre."wxpay where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['wxid']==''){return false;}
		$obj2 = array();
		$obj2['appid']         	= $config['appid'];
		$obj2['mch_id']         	= $config['mchid'];
		$obj2['partner_trade_no']			= $r['wxid'];
		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/gettransferinfo';
		$wxHongBaoHelper4 = new WxPay();
		$result = $wxHongBaoHelper4->pay($url, $obj2,$config);
		if($result){
			$result = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);	
			if($result->status=='SUCCESS'){
				$sql="update ".$pdo->index_pre."wxpay set `receive_state`=1 where `id`=".$id;	
				$pdo->exec($sql);
			}
			return $result->status;
		}else{return false;}
	}
	
//清空前台页面缓存	
function clear_file_cache(){
	$dir=new Dir();
	$dir->del_dir('./cache/pc/');
	@mkdir('./cache/pc');
	$dir->del_dir('./cache/phone/');
	@mkdir('./cache/phone');
	$dir->del_dir('./program/mall/cache/');
	@mkdir('./program/mall/cache');
	$dir->del_dir('./program/trip/cache/');
	@mkdir('./program/trip/cache');
	return true;
}

//清空SQL结果缓存	
function clear_sql_cache(){
	$dir=new Dir();
	$dir->del_dir('./cache/sql/');
	@mkdir('./cache/sql');
	return true;
}

//记录会员注册推荐人
function set_reg_introducer($pdo,$config,$language){
	if(!isset($_SESSION['monxin']['id'])){return false;}
	if(!isset($_SESSION['monxin']['username'])){return false;}
	if(@$_SESSION['monxin']['introducer']!=''){return false;}
	if(isset($_COOKIE['store_id']) && $_COOKIE['store_id']!=''){
		$sql="select `username` from ".$pdo->sys_pre."agency_store where `id`=".intval($_COOKIE['store_id']);
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['username']!=$_SESSION['monxin']['username']){$introducer=$r['username'];}
	}
	if(isset($_SESSION['share']) && $_SESSION['share']!=''){
		$introducer=$_SESSION['share'];
		if(is_numeric($_SESSION['share'])){
			$sql="select `id` from ".$pdo->index_pre."user where `username`='".$_SESSION['share']."' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){
				$sql="select `username` from ".$pdo->index_pre."user where `id`='".$_SESSION['share']."'";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['username']!=''){$introducer=$r['username'];}
			}			
		}
	}
	if(isset($introducer)){
		$sql="select `reg_time` from ".$pdo->index_pre."user where `username`='".$introducer."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="select `reg_time`,`username`,`introducer` from ".$pdo->index_pre."user where `id`=".$_SESSION['monxin']['id'];
		$r2=$pdo->query($sql,2)->fetch(2);
		if($r2['introducer']!=''){return false;}
		if($r2['reg_time']>$r['reg_time']){
			$sql="update ".$pdo->index_pre."user set `introducer`='".$introducer."' where `id`=".$_SESSION['monxin']['id'];
			$pdo->exec($sql);
			$reason=$language['new_user_introduce'].$r2['username'];
			operation_credits($pdo,$config,$language,$introducer,$config['credits_set']['introduce'],$reason,'introduce');	
	
		}
	}
}

//扫微信自定二维码，自动创建账号并设置注册推荐人
function wx_diy_qr_crate_user($pdo,$language,$openid,$wid,$introducer=''){
	$sql="select * from ".$pdo->sys_pre."weixin_user where `openid`='".$openid."' and `wid`='".$wid."' limit 0,1";
	$userinfo=$pdo->query($sql,2)->fetch(2);
	if($userinfo['id']==''){return false;}
	
	$sql="select `id`,`username` from ".$pdo->index_pre."user where openid='".$userinfo['openid']."' limit 0,1";
    $r=$pdo->query($sql,2)->fetch(2); 
	if($r['username']!=''){
		if($introducer!=''){set_user_introducer($pdo,$introducer,$r['username']);}
		return false;
	}
	
	$sql="select `id` from ".$pdo->index_pre."user where `username`='".$userinfo['nickname']."' limit 0,1";
    $r=$pdo->query($sql,2)->fetch(2); 
	if($r['id']!=''){
		$userinfo['nickname'].="_".rand(10000,99999);
	}
	
	$config=require('./config.php');
	
	require_once('plugin/py/py_class.php');
	$py_class=new py_class();  
	try { $py=$py_class->str2py($userinfo['nickname']); } catch(Exception $e) { $py='';}
	$sql="insert into ".$pdo->index_pre."user (`icon`,`nickname`,`username`,`username_py`,`reg_time`,`reg_ip`,`group`,`state`,`manager`,`gender`,`reg_oauth`,`openid`) values ('".$userinfo['headimgurl']."','".$userinfo['nickname']."','".$userinfo['nickname']."','".$py."','".time()."','".get_ip()."','".$config['reg_set']['default_group_id']."',1,0,'".$userinfo['sex']."',1,'".$userinfo['openid']."')";
	if($pdo->exec($sql)){
		$user_id=$pdo->lastInsertId();
		$sql="insert into ".$pdo->index_pre."oauth (`user_id`,`open_id`,`time`) values ('".$user_id."','wx:".$userinfo['openid']."','".time()."')";
		$pdo->exec($sql);
		//file_put_contents('introducer.txt',$introducer);
		
		if($introducer!=''){
			set_user_introducer($pdo,$introducer,$userinfo['nickname']);		
			$config['credits_set']['introduce']=intval($config['credits_set']['introduce']);
			$reason=$language['new_user_introduce'].$userinfo['nickname'];
			operation_credits($pdo,$config,$language,$introducer,$config['credits_set']['introduce'],$reason,'introduce');	
		}
			//创建分销账号
			$path='./program/distribution/config.php';
			if(is_file($path)){
				$dc=require($path);
				if($dc['check']){$state=0;}else{$state=1;}
				$sql="select * from ".$pdo->sys_pre."distribution_distributor where `username`='".$userinfo['nickname']."' limit 0,1";
				$d=$pdo->query($sql,2)->fetch(2);
				if($d['id']==''){
					$sql="insert into ".$pdo->sys_pre."distribution_distributor (`username`,`phone`,`time`,`state`,`superior`) values ('".$userinfo['nickname']."','','".time()."',".$state.",'".$introducer."')";
					$pdo->exec($sql);
				}

			}

		
		
		return true;
	}
	return false;

}


//设置注册推荐人
function set_user_introducer($pdo,$old,$new){
	$sql="select `reg_time`,`introducer` from ".$pdo->index_pre."user where `username`='".$new."' limit 0,1";
	$r2=$pdo->query($sql,2)->fetch(2);
	if($r2['introducer']!=''){return false;}
	$sql="select `reg_time` from ".$pdo->index_pre."user where `username`='".$old."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r2['reg_time']>$r['reg_time']){
		$sql="update ".$pdo->index_pre."user set `introducer`='".$old."' where `username`='".$new."' limit 1";
		$pdo->exec($sql);
	}
}



//======================================================================================================================================自动开通分销店 start
function auto_create_store($pdo,$username){
	$sql="select * from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
	$user=$pdo->query($sql,2)->fetch(2);
	$user=de_safe_str($user);
	if($user['id']==''){return false;}
	$sql="select `id` from ".$pdo->sys_pre."agency_store where `username`='".$username."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){return false;}
	$config=require('./config.php');
	$p_config=require('./program/agency/config.php');
	$icon='default.png';
	$banner='default.png';
	$shop_name=$user['username'];
	if($user['nickname']!=''){$shop_name=$user['nickname'];}
	
	if($user['icon']!='' && !is_url($user['icon'])){$source_icon='./program/index/user_icon/'.$user['icon'];}else{$source_icon='./favicon.png';}
	$path=get_date_dir('./program/agency/shop_icon/');
	$path.=md5($user['username']).'.jpg';	
	if(!copy($source_icon,$path)){$icon='default.png';}else{
		$temp=explode('shop_icon/',$path);
		$icon=$temp[1];	
	}
	$referee=$user['introducer'];
	
	$sql="insert into ".$pdo->sys_pre."agency_store (`username`,`name`,`time`,`template`,`icon`,`banner`,`referee`) values ('".$user['username']."','".$shop_name."','".time()."','default','".$icon."','".$banner."','".$referee."')";
	if($pdo->exec($sql)){
		$s_id=$pdo->lastInsertId();
		$store_id=$s_id;
		//$agency->update_store_qr_path($pdo,$s_id);
				if($config['web']['wid']!=''){
					get_weixin_info($config['web']['wid'],$pdo); 
					$data='{
							"action_name": "QR_LIMIT_STR_SCENE", 
							"action_info": {
								"scene": {
									"scene_str": "agency_store__'.$store_id.'"
								}
							}
						}';	
					$r= https_post('https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$_POST['monxin_weixin'][$config['web']['wid']]['token'],$data);
					$r=json_decode($r,1);
					if(isset($r['url'])){
						$sql="update ".$pdo->sys_pre."agency_store set `qr_path`='".safe_str($r['url'])."' where `id`='".$store_id."'";
						$pdo->exec($sql);
					}
				}		
		if($referee!=''){
			$sql="update ".$pdo->sys_pre."agency_store set `rebate_2`=`rebate_2`+1 where `username`='".$referee."' limit 1";
			$pdo->exec($sql);
			$sql="select `referee` from ".$pdo->sys_pre."agency_store where `username`='".$referee."' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['referee']!=''){
				$sql="update ".$pdo->sys_pre."agency_store set `rebate_3`=`rebate_3`+1 where `username`='".$r['referee']."' limit 1";
				$pdo->exec($sql);
			}	
		}
		$time=time();
		$sql="select * from ".$pdo->sys_pre."agency_store where `username`='".$username."' limit 0,1";
		$store=$pdo->query($sql,2)->fetch(2);

		$sql="select `goods_id`,`shop_id` from ".$pdo->sys_pre."mall_goods where `state`=2 and `stock`=0 limit 0,".$p_config['store_default_goods'];
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$sql="insert into ".$pdo->sys_pre."store_goods (`goods_id`,`shop_id`,`store_id`,`username`,`time`) values ('".$v['goods_id']."','".$v['shop_id']."','".$module['id']."','".$_SESSION['monxin']['username']."','".$time."')";
			$pdo->exec($sql);
		}
	}
}
//======================================================================================================================================自动开通分销店 end


//清空头尾空白字符
function monxin_trim($v){
	if(is_array($v)){
		$r=array();
		foreach($v as $k=>$vv){
			if(is_array($vv)){
				$r[$k]=monxin_trim($vv);
			}else{
				$r[$k]=trim($vv);
			}			
		}
		return $r;
	}else{return trim($v);}
}


function table_exist($pdo,$table){
	$sql="select * from ".$table;
	return $pdo->query($sql,2);
}

function yun_print($supplier,$partner,$apikey,$machine_code,$msign,$content){
	if($supplier=='' || $partner=='' || $apikey=='' || $machine_code=='' || $msign=='' || $content==''){return false;}
	switch($supplier){
		case 'yilianyun'://提交到易联云
			$path="./plugin/yilianyun/print.class.php";
			if(!is_file($path)){$path="../../plugin/yilianyun/print.class.php";}
			if(!is_file($path)){return false;}
			if(!isset($_POST['include_print'])){include($path);$_POST['include_print']='1';}
			$print = new Yprint();
			$print->action_print($partner,$machine_code,$content,$apikey,$msign);//打印
			break;
	}
}

//删除会员相关数据
function del_user_relevant($pdo,$r){
	$sql="delete from ".$pdo->index_pre."money_log where `username`='".$r['username']."'";
	$pdo->exec($sql);
	$sql="delete from ".$pdo->index_pre."money_transfer where `username`='".$r['username']."'";
	$pdo->exec($sql);
	$sql="delete from ".$pdo->index_pre."user_login where `userid`='".$r['id']."'";
	$pdo->exec($sql);
	$sql="delete from ".$pdo->index_pre."credits where `username`='".$r['username']."'";
	$pdo->exec($sql);
	$sql="delete from ".$pdo->index_pre."oauth where `user_id`='".$r['id']."'";
	$pdo->exec($sql);	
	
	@safe_unlink('./program/index/user_icon/'.$r['icon']);
	@safe_unlink('./program/index/license_photo_front/'.$r['license_photo_front']);
	@safe_unlink('./program/index/user_license_photo_reverse/'.$r['user_license_photo_reverse']);
	
}


function trim_csv_quotes($array){
	foreach($array as $k=>$v){
		$temp=explode(',',$v);
		$v='';
		foreach($temp as $kk=>$vv){
			$vv=str_replace('&#34;','',$vv);
			$vv=trim($vv,'"');
			$vv=trim($vv,"'");
			$v.=trim($vv).',';
		}
		$array[$k]=trim($v,',');
	}
	return $array;	
}

function getthemonth($date){
   $firstday = date('Y-m-01', strtotime($date));
   $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
   return array($firstday,$lastday);
}

function update_user_last($pdo){
	if(!isset($_SESSION['monxin']['username'])){return false;}
	$sql="update ".$pdo->index_pre."user set `last`=".time()." where `username`='".$_SESSION['monxin']['username']."' limit 1";
	$pdo->exec($sql);
}

function get_im_new($pdo){
	if(!isset($_SESSION['monxin']['username'])){return false;}
	$sql="select `id` from ".$pdo->sys_pre."im_msg_info where `addressee`='".$_SESSION['monxin']['username']."' and `addressee_state`=1 and `delete_a`!='".$_SESSION['monxin']['username']."' and `delete_b`!='".$_SESSION['monxin']['username']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){
		@setcookie("im_new",1,time()+180);
	}else{
		@setcookie("im_new",0);
	}
}

function is_online($pdo,$username){
	if(!isset($_SESSION['monxin']['username'])){return false;}
	$sql="select `last` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['last']==''){return false;}
	if($r['last']>time()-300){return true;}else{return false;}
}

function get_phone_country_opton($phone_country){
	$option='';
	foreach($phone_country as $k=>$v){
		$option.='<option value='.$k.'>'.$v.'</option>';
	}
	return $option;
}

function price_decimal_html($v){
	$temp=explode(".",$v);
	if(isset($temp[1])){return $temp[0].'<i class=decimal>.'.$temp[1].'</i>';}else{return $v;}
}

function send_im_msg($config,$language,$pdo,$sender,$receiver,$msg){
	$table_pre=$pdo->sys_pre.'im_';
	$time=time();
	$sql="select `id` from ".$table_pre."addressee where `username`='".$sender."' and `addressee`='".$receiver."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){
		$sql="insert into ".$table_pre."addressee (`username`,`addressee`,`last_time`) values ('".$sender."','".$receiver."','".time()."')";
		$pdo->exec($sql);
	}
	
	$sql="select `id` from ".$table_pre."addressee where `username`='".$receiver."' and `addressee`='".$sender."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){
		$sql="insert into ".$table_pre."addressee (`username`,`addressee`,`last_time`) values ('".$receiver."','".$sender."','".time()."')";
		$pdo->exec($sql);
	}
	
	
	$msg_id=0;
	$sql="select `id` from ".$table_pre."msg where `content`='".$msg."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){
		$msg_id=$r['id'];
		$sql="update ".$table_pre."msg set `used`=`used`+1 where `id`=".$msg_id;
		$pdo->exec($sql);
	}else{
		$sql="insert into ".$table_pre."msg (`username`,`time`,`content`) values ('".$sender."','".$time."','".$msg."')";
		if($pdo->exec($sql)){
			$msg_id=$pdo->lastInsertId();
		}
	}

		$sql="insert into ".$table_pre."msg_info (`state`,`sender`,`addressee`,`msg_id`,`time`) values ('1','".$sender."','".$receiver."','".$msg_id."','".$time."')";
		if($pdo->exec($sql)){
			if(!is_online($pdo,$receiver)){
				$url='http://'.$config['web']['domain'].'/index.php?monxin=im.talk&with='.$sender;
				$first=str_replace('{username}',$receiver,$language['you_have_a_new_message']);
				push_new_msg_info($pdo,$config,$language,$receiver,$sender,$msg,$url,$first);
			}			
			$last_msg=mb_substr($msg,0,10,'utf-8');
			$temp=explode('<img src=',$last_msg);
			if(isset($temp[1])){$last_msg=$language['image'];}
			$last_msg=strip_tags($last_msg);
			$sql="update ".$table_pre."addressee set `last_msg`='".$last_msg."',`last_time`='".$time."' where `username`='".$sender."' and `addressee`='".$receiver."' limit 1";
			$pdo->exec($sql);
			$sql="update ".$table_pre."addressee set `last_msg`='".$last_msg."',`last_time`='".$time."' where `username`='".$receiver."' and `addressee`='".$sender."' limit 1";
			$pdo->exec($sql);
			return true;
		}else{
			return false;
		}
}

function monxin_number_difference($a,$b,$difference){
	$v=$a-$b;
	$v=abs($v);
	if($v>$difference){return false;}else{return true;}
}

function index_create_qr_pay($pdo,$username){
	$code=get_verification_code(8);
	$time=time();
	$min_time=$time-60;
	$sql="select `id` from ".$pdo->index_pre."qr_pay where `money`=0 and `create_time`>".$min_time." and `code`='".$code."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){
		$code=get_verification_code(8);
		$sql="select `id` from ".$pdo->index_pre."qr_pay where `money`=0 and `create_time`>".$min_time." and `code`='".$code."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){
			$code=get_verification_code(8);
			$sql="select `id` from ".$pdo->index_pre."qr_pay where `money`=0 and `create_time`>".$min_time." and `code`='".$code."' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']!=''){
				$sql="delete from ".$pdo->index_pre."qr_pay where `id`=".$r['id'];
				$pdo->exec($sql);
			}
		}
	}
	
	$sql="insert into ".$pdo->index_pre."qr_pay (`username`,`code`,`create_time`) values ('".$username."','".$code."','".$time."')";
	if($pdo->exec($sql)){
		$id=$pdo->lastInsertId();
		$sql="delete from ".$pdo->index_pre."qr_pay where `username`='".$username."' and `id`!=".$id." and `money`=0";
		$pdo->exec($sql);
		
		return $code;
	}else{
		return '';
	}
}

function get_qr_pay_info($pdo,$code){
	$time=time();
	$min_time=$time-60;
	$sql="select * from ".$pdo->index_pre."qr_pay where `code`='".$code."' and `money`=0 and `create_time`>".$min_time." limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	return $r;
	
}

function index_qr_pay_update($pdo,$id,$money,$operator){
	$sql="update ".$pdo->index_pre."qr_pay set `money`=".$money.",`operator`='".$operator."',`ip`='".get_ip()."',`deduc_time`=".time()." where `id`=".$id." and `money`=0";
	return $pdo->exec($sql);
}

function my_safe_save_file_name($path,$allow){
	$allow=explode(',',$allow);
	$a=explode('.',$path);
	$postfix=strtolower($a[count($a)-1]);
	if(!in_array($postfix,$allow)  || $postfix=='php' || $postfix=='asp' || $postfix=='aspx' || $postfix=='jsp'){
		$path=str_replace('.php','.php_forbidden',$path);
		$path=str_replace('.asp','.asp_forbidden',$path);
		$path=str_replace('.aspx','.aspx_forbidden',$path);
		$path=str_replace('.jsp','.jsp_forbidden',$path);
		$path=str_replace('.'.$postfix,'.'.$postfix.'_forbidden',$path);
	}
	return $path;
}
function trim_0($v){
	$v=trim($v,'0');
	$v=trim($v,'.');
	return $v;
}
function unescape($str) 
{ 
    $ret = ''; 
    $len = strlen($str); 
    for ($i = 0; $i < $len; $i ++) 
    { 
        if ($str[$i] == '%' && $str[$i + 1] == 'u') 
        { 
            $val = hexdec(substr($str, $i + 2, 4)); 
            if ($val < 0x7f) 
                $ret .= chr($val); 
            else  
                if ($val < 0x800) 
                    $ret .= chr(0xc0 | ($val >> 6)) . 
                     chr(0x80 | ($val & 0x3f)); 
                else 
                    $ret .= chr(0xe0 | ($val >> 12)) . 
                     chr(0x80 | (($val >> 6) & 0x3f)) . 
                     chr(0x80 | ($val & 0x3f)); 
            $i += 5; 
        } else  
            if ($str[$i] == '%') 
            { 
                $ret .= urldecode(substr($str, $i, 3)); 
                $i += 2; 
            } else 
                $ret .= $str[$i]; 
    } 
    return $ret; 
}

//$data=get_weixin_article($url,'./temp/'); 采集文章
function copy_content($url,$img_dir,$content_reg){
	$data=array();
	$str=curl_open($url);
	$temp=explode('mp.weixin.qq.com',$url);
	$data['title']=get_match_single('#<title>(.*)</title>#iUs',$str);
	if(isset($temp[1])){
		$str=get_match_single('#<div.*class="rich_media_content.*>(.*)</div>#iUs',$str);
		$imgs=get_match_all('#<img.*src="(.*)".*/>#iU',$str);
		foreach($imgs as $v){
			$temp=explode('wx_fmt=',$v);
			if(!isset($temp[1])){$postfix='jpg';}else{$postfix=$temp[1];}
			$img=md5($v).'.'.$postfix;
			file_put_contents($img_dir.$img,@file_get_contents($v));
			$str=str_replace($v,$img_dir.$img,$str);
		}
		$str=str_replace(" src=","wsrc=",$str);
		$str=str_replace("data-src=","src=",$str);
	}else{
		if($content_reg==''){$content_reg='#<body.*>(.*)</body>#iUs';}
		$str=get_match_single($content_reg,$str);
		$imgs=get_match_all('#<img.*src="(.*)".*/>#iU',$str);
		//var_dump($imgs);
		foreach($imgs as $v){
			$temp=explode('.',$v);
			if(!isset($temp[1])){$postfix='jpg';}else{$postfix=$temp[1];}
			$img=md5($v).'.'.$postfix;
			$v_url=get_img_absolute_path($v,$url);
			@file_put_contents($img_dir.$img,@file_get_contents($v_url));
			$str=str_replace($v,$img_dir.$img,$str);
		}
	}
	
	$data['content']=$str;
	return $data;
}

function number_to_letter($v,$length=false){
	$str_v=array('A','B','C','D','E','F','G','H','I','J',);
	$str_k=array('A'=>0,'B'=>1,'C'=>2,'D'=>3,'E'=>4,'F'=>5,'G'=>6,'H'=>7,'I'=>8,'J'=>9,);
	$new = '';
	for($i=0;$i<strlen($v);$i++){
		if(!isset($str_v[$v[$i]])){$new='';break;}
		$new.=$str_v[$v[$i]];
	}
	if($length){
		for($i=strlen($new);$i<$length;$i++){
			$new.='x';
		}
	}
	return $new;
}

function letter_to_number($v){
	$str_v=array('A','B','C','D','E','F','G','H','I','J',);
	$str_k=array('A'=>0,'B'=>1,'C'=>2,'D'=>3,'E'=>4,'F'=>5,'G'=>6,'H'=>7,'I'=>8,'J'=>9,);
	$new = '';
	for($i=0;$i<strlen($v);$i++){
		if($v[$i]=='x'){break;}
		if(!isset($str_k[$v[$i]])){$new='';break;}
		$new.=$str_k[$v[$i]];
	}
	return $new;
}

//==========================================================身份证地址转换为地区ID
function address_to_area_id($pdo,$address){
	$splier=array('乡','镇','街道','区');
	$str='';
	foreach($splier as $v){
		if(strripos($address,$v)!=false){
			$str=mb_substr($address,0,strripos($address,$v)).$v;
		}
	}
	if($str!=''){
		$sql="select `id` from ".$pdo->index_pre."area where `address`='".$str."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){return $r['id'];}
	}
	return 0;
}
//==========================================================更新地区ID为身份证地址
function update_area_address($pdo,$id=0){
	$sql="select `id`,`upid`,`name`,`level` from ".$pdo->index_pre."area";
	if($id>0){$sql="select `id`,`upid`,`name`,`level` from ".$pdo->index_pre."area where `id`=".$id;}
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$address='';
		if($v['level']!=3 && $v['level']!=1){$address=$v['name'].$address;}
		if($v['upid']!=0){
			$sql="select `id`,`upid`,`name`,`level` from ".$pdo->index_pre."area where `id`=".$v['upid'];
			$v2=$pdo->query($sql,2)->fetch(2);
			if($v2['level']!=3 && $v2['level']!=1){$address=$v2['name'].$address;}
			if($v2['upid']!=0){
				$sql="select `id`,`upid`,`name`,`level` from ".$pdo->index_pre."area where `id`=".$v2['upid'];
				$v3=$pdo->query($sql,2)->fetch(2);
				if($v3['level']!=3 && $v3['level']!=1){$address=$v3['name'].$address;}
				if($v3['upid']!=0){
					$sql="select `id`,`upid`,`name`,`level` from ".$pdo->index_pre."area where `id`=".$v3['upid'];
					$v4=$pdo->query($sql,2)->fetch(2);
					if($v4['level']!=3 && $v4['level']!=1){$address=$v4['name'].$address;}
					if($v4['upid']!=0){
						$sql="select `id`,`upid`,`name`,`level` from ".$pdo->index_pre."area where `id`=".$v4['upid'];
						$v5=$pdo->query($sql,2)->fetch(2);
						if($v5['level']!=3 && $v5['level']!=1){$address=$v5['name'].$address;}
					}
				}
			}
		}
		$sql="update ".$pdo->index_pre."area set `address`='".$address."' where `id`=".$v['id'];
		$pdo->exec($sql);
	}
}

function refund_recharge($pdo,$id,$for_id,$money,$return_function){
	/*
	$id='';
	$for_id='322';
	$money=0;
	$return_function='mall.update_order_state';
	$r=refund_recharge($pdo,$id,$for_id,$money,$return_function);
	*/	
	if($id!=''){
		$sql="select * from ".$pdo->index_pre."recharge where `id`=".intval($id);	
	}else{
		$sql="select * from ".$pdo->index_pre."recharge where `for_id`=".intval($for_id)." and `return_function`='".$return_function."' limit 0,1";		
	}
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){return false;}
	if($r['state']==5){return false;}
	if($money==0){$money=$r['money']+$r['rate'];}
	if($money>$r['money']){$money=$r['money']+$r['rate'];}
	$wexin=array('weixin','weixin_wap','wxh5_wap','scanpay_weixin');
	$alipay=array('alipay','alipay_wap','scanpay_alipay');
	if(in_array($r['type'],$wexin)){
		require_once('./refund/weixin/index.php');
		$p_config=require('./payment/weixin/config.php');	
		
		$cert_path='/payment/weixin'.trim($p_config['sslcert_path'],'.');
		$key_path='/payment/weixin'.trim($p_config['sslkey_path'],'.');

		$mchid = $p_config['mchid'];          //微信支付商户号 PartnerID 通过微信支付商户资料审核后邮件发送
		$appid =$p_config['appid'];  //微信支付申请对应的公众号的APPID
		$apiKey =$p_config['key'];   //https://pay.weixin.qq.com 帐户设置-安全设置-API安全-API密钥-设置API密钥
		$orderNo = $r['in_id'];              //商户订单号（商户订单号与微信订单号二选一，至少填一个）
		$wxOrderNo = '';                     //微信订单号（商户订单号与微信订单号二选一，至少填一个）
		$totalFee = $r['money']+$r['rate'];  //订单金额，单位:元
		$refundFee =$money;                  //退款金额，单位:元
		$refundNo = 'refund_'.uniqid();      //退款订单号(可随机生成)
		$wxPay = new WxpayService($mchid,$appid,$apiKey,$cert_path,$key_path);
		$result = $wxPay->doRefund($totalFee, $refundFee, $refundNo, $wxOrderNo,$orderNo);
		if($result===true){
			$sql="update ".$pdo->index_pre."recharge set `state`=5 where `id`=".$r['id'];
			$pdo->exec($sql);
			return true;
		}		
		
	}
	if(in_array($r['type'],$alipay)){
		if(!table_exist($pdo,$pdo->sys_pre."scanpay_account")){return false;}
		require_once('./refund/alipay/index.php');
		$sql="select * from ".$pdo->sys_pre."scanpay_account where `is_web`=1 and `state`=1 and `type`='alipay' limit 0,1";
		$a=$pdo->query($sql,2)->fetch(2);
		if($a['id']==''){return false;}
		$a['data']=de_safe_str($a['data']);
		$ali=json_decode($a['data'],1);
		$result=alipay_refund($ali['app_id'],$ali['private_key'],$ali['public_key'],$r['in_id'],$money);
		if($result===true){
			$sql="update ".$pdo->index_pre."recharge set `state`=5 where `id`=".$r['id'];
			$pdo->exec($sql);
			return true;
		}		
	}	
	return false;
}


function alipay_transfer($pdo,$account,$money){
	if(!table_exist($pdo,$pdo->sys_pre."scanpay_account")){return false;}
	require_once('./refund/alipay/transfer.php');
	$sql="select * from ".$pdo->sys_pre."scanpay_account where `is_web`=1 and `state`=1 and `type`='alipay' limit 0,1";
	$a=$pdo->query($sql,2)->fetch(2);
	if($a['id']==''){return false;}
	$a['data']=de_safe_str($a['data']);
	$ali=json_decode($a['data'],1);
	return ali_transfer($ali['app_id'],$ali['private_key'],$ali['public_key'],$account,$money);
	return false;
}

function push_gbuy_success($pdo,$config,$language,$openid,$data){
	/*
	$openid='oAfj8v0JRwLssBK3rhTqNH65tBTE';
	$data=array();
	$data['first']=self::$config['web']['name'];
	$data['keyword1']='99988393';
	$data['keyword2']='goods_name';
	$data['keyword3']='goods_money';
	$data['keyword4']='time';
	$data['remark']=self::$language['click_view_more'];
	push_gbuy_success($pdo,self::$config,self::$language,$openid,$data);	
	*/
	
	$notice=array();
	$notice['touser']=$openid;
	$notice['template_id']=$config['openid_notice_template']['OPENTM415124164'];	
	$notice['url']='http://'.$config['web']['domain'].'/index.php?monxin=gbuy.my_buy';	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=$data['first'];	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=$data['keyword1'];
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=$data['keyword2'];;	
	$notice['data']['keyword2']['color']='#173177';	
	$notice['data']['keyword3']=array();
	$notice['data']['keyword3']['value']=$data['keyword3'];;	
	$notice['data']['keyword3']['color']='#173177';	
	$notice['data']['keyword4']=array();
	$notice['data']['keyword4']['value']=$data['keyword4'];;	
	$notice['data']['keyword4']['color']='#173177';	
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$data['remark'];;	
	$notice['data']['remark']['color']='#173177';
	$notice=json_encode($notice);
	if(notice_app($pdo,$config['web']['wid'],$notice)){
		return true;
	}else{
		return false;
	}
}


function push_gbuy_fail($pdo,$config,$language,$openid,$data){
	/*
	$openid='oAfj8v0JRwLssBK3rhTqNH65tBTE';
	$data=array();
	$data['first']=self::$config['web']['name'];
	$data['keyword1']='99988393';
	$data['keyword2']='goods_name';
	$data['keyword3']='goods_money';
	$data['remark']=self::$language['click_view_more'];
	push_gbuy_fail($pdo,self::$config,self::$language,$openid,$data);
	*/
	$notice=array();
	$notice['touser']=$openid;
	$notice['template_id']=$config['openid_notice_template']['OPENTM401113750'];	
	$notice['url']='http://'.$config['web']['domain'].'/index.php?monxin=gbuy.my_buy';	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=$data['first'];	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=$data['keyword1'];
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=$data['keyword2'];;	
	$notice['data']['keyword2']['color']='#173177';	
	$notice['data']['keyword3']=array();
	$notice['data']['keyword3']['value']=$data['keyword3'];;	
	$notice['data']['keyword3']['color']='#173177';	
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$data['remark'];;	
	$notice['data']['remark']['color']='#173177';
	$notice=json_encode($notice);
	if(notice_app($pdo,$config['web']['wid'],$notice)){
		return true;
	}else{
		return false;
	}
}

function money_to_credits($rate,$set,$money){
	if($set=='money'){
		//$money=trim(trim($money,'0'),'.');
		return $money;
	}else{
		
		$v=floatval($money)/floatval($rate);
		$v=ceil($v);
		return $v;
	}
}


function removeEmoji($str) {
	$str = preg_replace_callback( '/./u',
      function (array $match) {
        return strlen($match[0]) >= 4 ? '' : $match[0];
      }, $str);
   return $str;	
}


?>