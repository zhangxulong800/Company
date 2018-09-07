<?php
class FilterTemplate{
/**
 *	
 *	 模板过虑类
 *   作者 梁长期 925434309@qq.com
 *   config					系统配置数组
 *   language				语言数组
 *   dir					目标文件夹
 *   __construct($path,$to_dir='') $path=文件夹路径或ZIP文件路径，如何是ZIP文件，则$to_dir不能为空。$to_dir=解压并过虑后的模板存放位置。
 *   extract_zip($path)		解压ZIP文件，并返回文件所在临时目录。	
 *	 create_zip($path)		打包过虑后的文件夹，备用户下载。
 *   filter_dir($path)		删除不相关的文件，输出被删除的文件列表	
 *   filter_file($path)		提取相关文件，并调用 filter_code($path) 过虑越权代码，并输出越权代码。
 *   filter_code($path)		过虑越权代码，返回越权代码。
 *   get_match($reg,$str)	返回是否匹配，真或假
 *   
 */

	public $config;
	public $language;		
	public $dir;	
	private $template_name='';	
	function __construct($path,$to_dir=''){
		$this->config=require('config.php');
		//var_dump($this->config);
		$this->language=require('language/'.$this->config['web']['language'].'.php');	
		if(!isset($path)){return 'new '. __CLASS__ .$path.$this->language['need_params'];return false;}
		$is_zip=false;
		if(!empty($to_dir) && is_file($path)){
			$path=$this->extract_zip($path);
			$is_zip=true;
		}
		
		if(!is_dir($path)){return $path.$this->language['not_exist_dir'];return false;}

		require_once 'lib/Dir.class.php';	
		$this->dir=new Dir();
		//var_dump($this->dir);
		
		$result='';
		$result.=$this->filter_dir($path);
		$result.=$this->filter_file($path);
		
		if(!empty($to_dir) && $is_zip){
			//echo $path.'->'.$to_dir.'<br/>';
			$this->dir->copy_dir($path,$to_dir);
			//$this->dir->del_dir($path);
			$this->create_zip($to_dir.'/'.$this->template_name);
		}
		$_POST['FilterTemplate_result']=str_replace("'","\'",$result);
	}
	
	function extract_zip($path){
		$zip = new ZipArchive;
		if ($zip->open($path) === TRUE) {
			$temp_dir='./temp_dir/'.md5(time().rand(999,9999));
			$zip->extractTo($temp_dir);
			$zip->close();
			unlink($path);
			return $temp_dir;
		} else {
			return false;
		}
	}
	
	function create_zip($path){
		$zip = new ZipArchive;
		//$path=str_replace('\\','/',$path);
		//echo '<b>'.$path.'</b><hr/>';
		$res = $zip->open($path.'.zip', ZipArchive::CREATE);
		if ($res === TRUE) {
			$list=$this->dir->show_dir($path,'',true,true);
			//var_dump($list);
			foreach($list as $v){
				$for=iconv('utf-8','gbk',$v);
				$to=explode('templates/',$v);
				//print_r($v3);
				$to=iconv('utf-8','gbk',$to[1]);;
				//echo $for.'--'.$to.'<br/>';
				if(is_dir($for)){$zip->addEmptyDir($to);}else{$zip->addFile($for,$to);}
			}
			$zip->close();
			return true;
		} else {return false;}
	}
		
	function filter_dir($path){
		$filter_dir_result='';
		$r=$this->dir->filter_dir($path,array('php','gif','png','jpg','jpeg','txt','css','js','cur','db'));
		if(!empty($r)){
			$filter_dir_result.='<fieldset><legend>'.$this->language['exist_forbidden_file'].'</legend>'.$r.'</fieldset><br/>';
		}
		return $filter_dir_result;
	}

	function filter_file($path){
		$filter_file_result='';
		$list=$this->dir->show_dir($path,array('php'),true);
		//var_dump($list);
		$illegal='';
		if(isset($list[0])){$this->template_name=$this->get_template_name($list[0]);}
		foreach($list as $v){
			$v=iconv($this->dir->my_char,$this->dir->sys_char,$v);
			//echo '--- '.$v.' ---<br/>';
			
			if(is_file($v)){$illegal.=$this->filter_code($v);}
		}
		if(!empty($illegal)){
			$filter_file_result.='<fieldset><legend>'.$this->language['exist_forbidden_code'].'</legend>'.$illegal.'</fieldset><br/>';
		}
		return $filter_file_result;
			
	}

	static function get_match($reg,$str){
		preg_match($reg,$str,$r);
		//print_r($r);
		if(!empty($r[0])){return true;}else{return false;}
	}
	
 	static function filter_code($path){
		$illegal='';
		//匹配php代码
		$php_reg='#<\?(?:php)?(.*)\?>#iUs';
		//数组下标正则
		$array_key='\s*\[\s*(?:\'\w*_?\'|\d*|.*)\s*\]\s*';
		//备注
		$allow_code[]='#^(?:php)?\s*(/\*.*\*/)\s*$#iUs';
		//echo $v[]
		$allow_code[]='#^(?:php)?\s*echo\s*\$v'.$array_key.';?\s*$#iU';
		//$v[]->$v[]()
		$allow_code[]='#^(?:php)?\s*\$v'.$array_key.'\s*->\s*\$v'.$array_key.'\(\);?\s*$#iU';
		//echo $head[]
		$allow_code[]='#^(?:php)?\s*echo\s*\$head'.$array_key.';?\s*$#iU';
		//echo $language[]
		$allow_code[]='#^(?:php)?\s*echo\s*\$language'.$array_key.';?\s*$#iU';
		//echo $module[]
		$allow_code[]='#^(?:php)?\s*echo\s*\s*@?\$module'.$array_key.';?\s*$#iU';
		//echo $module[]*100
		$allow_code[]='#^(?:php)?\s*echo\s*\s*@?\$module'.$array_key.'\*[0-9]*;?\s*$#iU';
		//echo $module[][]
		$allow_code[]='#^(?:php)?\s*echo\s*\s*@?\$module'.$array_key.$array_key.';?\s*$#iU';
		//echo $module[][][]
		$allow_code[]='#^(?:php)?\s*echo\s*\s*@?\$module'.$array_key.$array_key.$array_key.';?\s*$#iU';
		
		//echo replace_str('***',$module[])
		$sub_reg="'[-a-z=<>\"\s,]*'";
		$allow_code[]='#^(?:php)?\s*echo\s*\s*replace_str\('.$sub_reg.',\$module'.$array_key.'\);?\s*$#iU';
		//echo replace_str('***',$module[][])
		$allow_code[]='#^(?:php)?\s*echo\s*\s*replace_str\('.$sub_reg.',\$module'.$array_key.$array_key.';?\s*$#iU';
		//echo replace_str('***',$module[][][])
		$allow_code[]='#^(?:php)?\s*echo\s*\s*@?\$module'.$array_key.$array_key.$array_key.';?\s*$#iU';
		$allow_code[]='#^(?:php)?\s*echo\s*\s*replace_str\('.$sub_reg.',\$module'.$array_key.$array_key.$array_key.';?\s*$#iU';
		
		//foreach($module[] as $v){
		$allow_code[]='#^(?:php)?\s*foreach\s*\(\s*\$module'.$array_key.'as\s*\$v\s*\)\s*{\s*$#iU';
		//foreach($modules[] as $v){
		$allow_code[]='#^(?:php)?\s*foreach\s*\(\s*\$modules'.$array_key.'as\s*\$v\s*\)\s*{\s*$#iU';
		//module::$v()
		$allow_code[]='#^(?:php)?\s*module::\$v\(\s*\)\s*$#iU';
		//}
		$allow_code[]='#^(?:php)?\s*}\s*$#iU';
		//if(!empty($module[]){
		$allow_code[]='#^(?:php)?\s*if\s*\(\s*!?empty\s*\(\s*\$module'.$array_key.'\)\s*\)\s*{\s*$#iU';
		//if($v[]==''){ 或 if($v[]!=''){ 
		$allow_code[]='#^(?:php)?\s*if\s*\(\s*\$v'.$array_key.'(?:!|=)=\s*(?:\'\w*\'|\d*)\s*\)\s*{\s*$#iU';
		//if($module[]==''){ 或 if($module[]!=''){ 
		$allow_code[]='#^(?:php)?\s*if\s*\(\s*\$module'.$array_key.'(?:!|=)=\s*(?:\'\w*\'|\d*)\s*\)\s*{\s*$#iU';
		//}else{
		$allow_code[]='#^(?:php)?\s*}\s*else\s*{\s*$#iU';


	
		//echo self::$language['']
		$allow_code[]='#^(?:php)?\s*echo\s*self::\$language'.$array_key.';?\s*$#iU';
		
		
		//echo self::$language['']['']
		$allow_code[]='#^(?:php)?\s*echo\s*self::\$language'.$array_key.$array_key.';?\s*$#iU';
		//echo self::$language['']['']['']
		$allow_code[]='#^(?:php)?\s*echo\s*self::\$language'.$array_key.$array_key.$array_key.';?\s*$#iU';
		
		//echo get_template_dir(__FILE__)
		$allow_code[]='#^(?:php)?\s*echo\s*get_template_dir\s*\(__FILE__\);?\s*$#iU';
		//echo get_monxin_table_css_dir(__FILE__)
		$allow_code[]='#^(?:php)?\s*echo\s*get_monxin_table_css_dir\s*\(__FILE__\);?\s*$#iU';
		//echo get_monxin_table_js_dir(__FILE__)
		$allow_code[]='#^(?:php)?\s*echo\s*get_monxin_table_js_dir\s*\(__FILE__\);?\s*$#iU';
		//echo @$_GET['id']
		$allow_code[]='#^(?:php)?\s*echo\s*@?\$_GET'.$array_key.';?\s*$#iU';
		//echo @$_POST['id']
		$allow_code[]='#^(?:php)?\s*echo\s*@?\$_POST'.$array_key.';?\s*$#iU';
		
		//monxin_var_dump()
		$allow_code[]='#^(?:php)?\s*monxin_var_dump\s*\(\s*self::\$language\s*\);?\s*$#iU';
		$allow_code[]='#^(?:php)?\s*monxin_var_dump\s*\(\s*\$module\s*\);?\s*$#iU';
		$allow_code[]='#^(?:php)?\s*monxin_var_dump\s*\(\s*\$_GET\s*\);?\s*$#iU';
		$allow_code[]='#^(?:php)?\s*monxin_var_dump\s*\(\s*\$_POST\s*\);?\s*$#iU';
		$allow_code[]='#^(?:php)?\s*monxin_var_dump\s*\(\s*\$_COOKIE\s*\);?\s*$#iU';
	
	
		$c=file_get_contents($path);
		preg_match_all($php_reg,$c,$arr);
	
/*		echo '<pre>';
		print_r($arr);
		print_r($allow_code);
		echo '</pre>';
*/		
		$illegal='';
		foreach($arr[1] as $v){
			$check=false;
			//echo $v.'<hr/><hr/>';
			foreach($allow_code as $reg){
			//echo '<hr>'.$reg.'='.$v;
			if(self::get_match($reg,$v)){$check=true;break 1;}
			}
			if(!$check){ $c=str_replace('<?'.$v.'?>','',$c);$illegal.='<div class=php_code>&lt;?'.$v.'?&gt;</div>';}
		}
		
		$start_label=intval(strrpos($c,'<?'));
		$end_label=intval(strrpos($c,'?>'));
		if($start_label>=$end_label){
			$c=substr($c,0,$start_label);
		}
		file_put_contents($path,$c);
		if(@$this){
			$path=iconv($this->dir->sys_char,$this->dir->my_char,$path);
			$path=$this->trim_path($path);
		}
		if($illegal!=''){$illegal='<br/><b>'.$path.'</b><br/>'.$illegal;}
		//echo $illegal.'<br/>';
		return $illegal;
		
	}
	function trim_path($path){
		$temp=explode('/',$path);
		  $path=$temp[count($temp)-1];
		return $path;
	}
	function get_template_name($path){
		$temp=explode('/',$path);
		//var_dump($temp);
		array_shift($temp);
		array_shift($temp);
		array_shift($temp);
		return array_shift($temp);
	}
}
?>