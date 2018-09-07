<?php
/**
 *	文件夹操作类 
 *  作者 梁长期 925434309@qq.com
 *	注意事项，不支持中文目录。
 *	
 *	del_dir($path) 							删除文件夹，返回 真或假
 *	copy_dir($from_dir,$to_dir)				复制文件夹，返回 真或假
 *	get_dir_size($path)						统计文件夹大小，返回 大小
 *	filter_dir($path,array('php','txt','gif','png','jpg','jpeg')) 
 *  （危险方法，小心使用）过虑文件夹，删除 后缀 未在 数组中 声明 的文件，返回空字符=未检测到非法文件，返回字符串=删除结果,以'<br/>'分隔
 *	show_dir($path,$postfix=array(),$sub=false,$require_dir=false)
 *  返回目录文件及文件夹，返回数组。$postfix（空字符或数组）用于返回指定后缀的文件，空字符则不指定，返回数组。$sub（可选）是否返回子目的文件，返回字数组。$require_dir是否要返回目录数据
 *	search_name($path,$key) 				搜索指定目录,符合关键词的文件及文件夹，返回数组。
 *	search_text($path,$key) 				搜索指定目录,文件内容符合关键词的text类型文件，返回数组$key=文件路径，$v=出现次数。
 *	glob_search($key)						显示出符合要求的文件 glob函数操作，返回数组。
 */

class Dir{
	public $sys_char='gbk';
	public $my_char='utf-8';
	function del_dir($path){
		$path=$this->check_path($path);
		if(!$path){return false;}
		$array=scandir($path);
		foreach($array as $v){
			if(is_dir($path.$v) && $v!='.' && $v!='..'){$this->del_dir($path.$v);}
			if(is_file($path.$v)){unlink($path.$v);}
		}
	  	return rmdir($path);
	}
	
	function copy_dir($from_dir,$to_dir){
		$from_dir=$this->check_path($from_dir);
		if(!$from_dir){return false;}
		$to_dir=$this->check_path2($to_dir);
		try{
			if(!file_exists($to_dir)){@mkdir($to_dir);}
			$array=scandir($from_dir);
			foreach($array as $v){
				if(is_dir($from_dir.$v) && $v!='.' && $v!='..'){$this->copy_dir($from_dir.$v,$to_dir.$v);}
				if(is_file($from_dir.$v)){@copy($from_dir.$v,$to_dir.$v);}
			}
		return true;	
		}catch (Exception $e){return false;}
	}

	function get_dir_size($path){
		$path=$this->check_path($path);
		if(!$path){return 0;}
		$array=scandir($path);
		$size=0;
		foreach($array as $v){
			if(is_dir($path.$v) && $v!='.' && $v!='..'){$size +=$this->get_dir_size($path.$v);}
			if(is_file($path.$v)){$size += filesize($path.$v);}
		}
		return $size;
	}
	

	function filter_dir($path,$postfix){//删除无关文件
		$path=$this->check_path($path);
		if(!$path){return false;}
		if(!is_array($postfix)){return false;}
		foreach($postfix as $v){$temp[]=strtolower($v);}
		$forbidden_files='';
		$postfix=$temp;
		$array=scandir($path);
		foreach($array as $v){
			if(is_dir($path.$v) && $v!='.' && $v!='..'){$forbidden_files.=$this->filter_dir($path.$v,$postfix);}
			if(is_file($path.$v)){
				$temp=explode('.',$v);
				if(!in_array(strtolower($temp[count($temp)-1]),$postfix)){
					$path.$v.'<br/>';
					if(unlink($path.$v)){$result='deleted';}else{$result='undeleted';}
					if('/'!=DIRECTORY_SEPARATOR){$v=iconv($this->sys_char,$this->my_char,$v);}
					$forbidden_files.=$path.$v.' <b>'.$result.'</b><br/>';}
			}
		}
		
		return $forbidden_files;	
	}


	function show_dir($path,$postfix=array(),$sub=false,$require_dir=false){
		//var_dump($sub);
		$path=$this->check_path($path);
		if(!$path){return false;}
		$array=scandir($path);
		$list=array();
		$array1=array();
		$array2=array();
		$array3=array();
		foreach($array as $v){
			if($v!='' && $v!='.' && $v!='..'){
				$v2=$v;
				if('/'!=DIRECTORY_SEPARATOR){$v=iconv($this->sys_char,$this->my_char
,$v);}
				if(is_dir($path.$v2)){
					if($sub){
						$array3=$this->show_dir($path.$v,$postfix,$sub);
						if($require_dir){$list[]=$path.$v;}
						if(is_array($array3)){
						foreach($array3 as $temp){
							$list[]=$temp;
							}	
						}
					}else{
						$list[]=$path.$v;	
					}
				}else{
					if(is_array($postfix)){
						$temp=explode('.',$v);
						if(@in_array(strtolower($temp[count($temp)-1]),$postfix)){$list[]=$path.$v;}	
					}else{
						$list[]=$path.$v;
					}
					
				}
			}	
		}
		if(is_array($list)){
			foreach($list as $v){
				$v2=$v;
				if('/'!=DIRECTORY_SEPARATOR){$v2=iconv($this->my_char
,$this->sys_char,$v);}
				if(is_dir($v2)){
					$array1[]=$v;	
				}else{
					$array2[]=$v;	
				}	
			}	
		$list=array_merge($array1,$array2);
		}
		//$list=array_unique($list);
		
		return $list;
	}
	
	function search_name($path,$key){
		if(!isset($key)){return false;}
		if(empty($key)){return false;}
		if(!isset($path)){return false;}
		if(!is_dir($path)){return false;}
		$list=$this->show_dir($path,'',true);
		$r=array();
		$key=trim($key);
		$key=str_replace('  ',' ',$key);
		$key=str_replace('.','\.',$key);
		$key=str_replace('*','.*',$key);
		$key=str_replace(' ','.*',$key);
		$key='#.*'.$key.'.*#iU';
		//echo $key;
		//var_dump($list);
		foreach($list as $v){
			//echo $key.'=='.$v.'<br>';
			if($this->get_match($key,$v)){$r[]=$v;}	
		}
		return $r;
		
	}
	
	function search_text($path,$key){
		if(!isset($key)){return false;}
		if(empty($key)){return false;}
		if(!isset($path)){return false;}
		if(!is_dir($path)){return false;}
		$list=$this->show_dir($path,array('php'),true);
		$r=array();
		$key=trim($key);
		$key=str_replace('  ',' ',$key);
		$key=str_replace('.','\.',$key);
		$key=str_replace('*','.*',$key);
		$key=str_replace(' ','.*',$key);
		$key='#.*('.$key.').*#iU';
		//echo $key;
		//var_dump($list);
		foreach($list as $v){
			$v2=$v;
			if('/'!=DIRECTORY_SEPARATOR){$v2=iconv($this->my_char
,$this->sys_char,$v);}
			if(!is_dir($v2)){
				//echo $key.'=='.$v.'<br>';
				$c=file_get_contents($v2);
				///$c=iconv($this->sys_char,$this->my_char,$c);
				$count=$this->get_match_count($key,$c);
				if($count>0){$r[$v]=$count;}				
			}
		}
		arsort($r);
		return $r;
		
	}
	
	private function get_match_count($reg,$str){
		//echo $reg.'--'.$str.'<br>';
		preg_match_all($reg,$str,$r);
		//var_dump($r);
		if(count($r)==2){return count($r[1]);}else{return 0;}
		
	}
	private function get_match($reg,$str){
		//echo $reg.'--'.$str.'<br>';
		preg_match($reg,$str,$r);
		//var_dump($r);
		if(!empty($r[0])){return true;}else{return false;}
	}
	
	
	private function check_path($path){
		
		if(empty($path)){return false;}
		$path=rtrim($path,'/');
		$path.='/';
		//echo $path;
		if(!is_dir($path)){return false;}else{return $path;}	
	}
	private function check_path2($path){
		
		if(empty($path)){return false;}
		$path=rtrim($path,'/');
		$path.='/';
		//echo $path;
		return $path;	
	}
	
	function glob_search($key){
		$array=glob($key);
		$array1=array();
		$array2=array();
		foreach($array as $v){
			if('/'!=DIRECTORY_SEPARATOR){$v=iconv($this->sys_char,$this->my_char,$v);}
			if(is_dir($v)){
				$array1[]=$v;				
			}else{
				$array2[]=$v;	
			}	
		}	
		$list=array_merge($array1,$array2);
		return $list;
	}

}
?>