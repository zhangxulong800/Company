<?php
		//echo $args[1];
		
		$attribute=format_attribute($args[1]);
		$id=$attribute['id'];
		if($id>0){
			$sql="select ".$attribute['field'].",`phone_content` from ".self::$table_pre."page where `id`='$id'";
			//echo $sql;
			$module=$pdo->query($sql,2)->fetch(2);
			$module['title']=de_safe_str(@$module['title']);
			if($_COOKIE['monxin_device']=='phone' && $module['phone_content']!=''){
				$module['content']=de_safe_str($module['phone_content']);
			}else{
				$module['content']=de_safe_str(@$module['content']);
			}
		}else{
			
			
			$module['title']=self::$language['functions']['diypage.show_content']['description'];	
			$module['content']=self::$language['functions']['diypage.show_content']['description'].'( '.self::$language['edit_mode_click_the_right_attribute_for_set_here_data'].' )';
		}
			
			$module['module_width']=$attribute['width'];
			$module['module_height']=$attribute['height'];
			$module['module_name']=str_replace("::","_",$method.'_'.$id);
			$module['module_save_name']=str_replace("::","_",$method.$args[1]);
			$module['count_url']="receive.php?target=".$method."&id=".$id;
			$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);	
