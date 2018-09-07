<?php
		$id=intval(@$_GET['id']);
		if($id>0){
			$sql="select `time`,`sender`,`title`,`content` from ".$pdo->index_pre."email_msg where `id`='$id' and (`addressee`='".$_SESSION['monxin']['username']."' or `sender`='".$_SESSION['monxin']['username']."')";
			$module=$pdo->query($sql,2)->fetch(2);
			$module=de_safe_str($module);
			$module['time']=get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$module['time']);
			$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
			$module['set_read_url']="receive.php?target=".$method."&id=".$id;
			if(isset($module['title'])){
				$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
			}
				
		}else{
			echo (self::$language['need_params']);
		}
