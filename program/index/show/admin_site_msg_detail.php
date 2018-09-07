<?php
		$id=intval(@$_GET['id']);
		if($id>0){
			$sql="select `time`,`sender`,`addressee`,`title`,`content` from ".$pdo->index_pre."site_msg where `id`='$id'";
			$module=$pdo->query($sql,2)->fetch(2);
			$module['sender']=$module['sender']."(".get_real_name($pdo,get_user_id($pdo,$module['sender'])).":".get_user_group_name($pdo,$module['sender']).")";
			$module['addressee']=$module['addressee']."(".get_real_name($pdo,get_user_id($pdo,$module['addressee'])).":".get_user_group_name($pdo,$module['addressee']).")";
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
