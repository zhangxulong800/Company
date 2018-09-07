<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);
$_POST['token']=$_SESSION['token'][$method];
$path='./';
$module['list']=check_dir_php($path);
if($module['list']==''){$module['list']='<div class=no_related_content_span>'.self::$language['no_forbidden_code'].'</div>';}
function check_dir_php($path){
	$r=scandir($path);
	$c='';
	foreach($r as $v){
		if($v=='.' || $v=='..'){continue;}
		
		$v=iconv('gbk',"UTF-8".'//IGNORE',$v);
		if(is_dir($path.$v)){
			$c.=check_dir_php($path.$v.'/');	
		}else{
			$name=strtolower($v);
			$t=explode('.',$name);
			$post_fix=$t[count($t)-1];
			if($post_fix=='php'){
				$c.=check_file_php($path.$v);
			}
		}
	}
	return $c;
}

function check_file_php($path){
	if($path=='./program/index/show/safe.php'){return '';}
	$c=@file_get_contents($path);
	
	$forbidden=array();
	$forbidden[]='system ?\(';
	$forbidden[]='passthru ?\(';
	$forbidden[]='shell_exec ?\(';
	$forbidden[]='eval ?\(';
	$forbidden[]='exec ?\(';
	$forbidden[]='popen ?\(';
	$forbidden[]='proc_open';
	$forbidden[]='eval ?\((\'|"|\s*)\\$';
	$forbidden[]='assert ?\((\'|"|\s*)\\$';
	$forbidden[]='returnsstringsoname';
	$forbidden[]='intooutfile';
	$forbidden[]='select(\s+)(.*)load_file';
	$forbidden[]='eval ?\(gzinflate\(';
	$forbidden[]='eval ?\(base64_decode\(';
	$forbidden[]='eval ?\(gzuncompress\(';
	$forbidden[]='eval ?\(gzdecode\(';
	$forbidden[]='eval ?\(str_rot13\(';
	$forbidden[]='gzuncompress\(base64_decode\(';
	$forbidden[]='base64_decode\(gzuncompress\(';
	$forbidden[]='eval ?\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)';
	$forbidden[]='assert ?\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)';
	$forbidden[]='require ?\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)';
	$forbidden[]='require_once ?\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)';
	$forbidden[]='include ?\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)';
	$forbidden[]='include_once ?\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)';
	$forbidden[]='call_user_func ?\(("|\')assert("|\')';
	$forbidden[]='call_user_func ?\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)';
	$forbidden[]='\$_(POST|GET|REQUEST|COOKIE)\[([^\]]+)\]\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)\[';
	$forbidden[]='echo ?\(file_get_contents\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)';
	$forbidden[]='file_put_contents ?\((\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)\[([^\]]+)\],(\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)';
	$forbidden[]='fputs ?\(fopen\((.+),(\'|")w(\'|")\),(\'|"|\s*)\\$_(POST|GET|REQUEST|COOKIE)\[';
	$forbidden[]='SetHandlerapplication\/x-httpd-php';
	$forbidden[]='php_valueauto_prepend_file';
	$forbidden[]='php_valueauto_append_file';
	$r='';	
	foreach($forbidden as $v){
		preg_match("/$v/i",$c,$a);
		if(isset($a[0])){
			if($v=='exec ?\('){preg_match("/\->exec\(/i",$c,$b);if(count($a)==count($b)){continue;}}
			if($v=='exec ?\('){preg_match("/curl_exec\(/i",$c,$b);if(count($a)==count($b)){continue;}}
			if($v=='eval ?\('){preg_match('/eval ?\("\("\+v\+"\)"\)/i',$c,$b);if(count($a)==count($b)){continue;}}
			if($v=='eval ?\('){preg_match('/eval ?\(temp\)/i',$c,$b);if(count($a)==count($b)){continue;}}
			if($v=='eval ?\('){preg_match('/eval ?\("\("\+temp\+"\)"\)/i',$c,$b);if(count($a)==count($b)){continue;}}
			if($v=='eval ?\('){preg_match('/eval ?\("\("\+data\+"\)"\)/i',$c,$b);if(count($a)==count($b)){continue;}}
			if($v=='eval ?\('){preg_match('/eval ?\("\("\+str\+"\)"\)/i',$c,$b);if(count($a)==count($b)){continue;}}
			if($v=='eval ?\('){preg_match('/eval ?\("\("\+\$\(this\).*\+"\)"\)/i',$c,$b);if(count($a)==count($b)){continue;}}
			if($v=='eval ?\('){preg_match('/eval ?\(\$\(this\).*\)/i',$c,$b);if(count($a)==count($b)){continue;}}
			if($v=='popen ?\('){preg_match('/popen\(\$sendmail,"w"\)/i',$c,$b);if(count($a)==count($b)){continue;}}
			$r=$v;
			break;
		}
	}
	if($r!=''){
		$r='<div class=line><span class=path>'.$path.'</span><span class=code>'.$r.'</span><a href=./receive.php?target=index.safe&token='.$_POST['token'].'&path='.$path.' target=_blank class=act>view</a></div>';
	}
	return $r;	
}


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);	