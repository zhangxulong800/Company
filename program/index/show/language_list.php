<?php
		
		$module['program_option']=index::get_program_option($pdo);
		
		function echo_html($language,$program){
			if($program!='os_language'){
				$program_config=require './program/'.$program.'/config.php';
				$program_language=require './program/'.$program.'/language/'.$program_config['program']['language'].'.php';			
				$list='<fieldset><legend>'.$program_language['program_name'].'</legend>';
				$r=scandir('./program/'.$program.'/language/');
				foreach($r as $v){
					if(is_file('./program/'.$program.'/language/'.$v)){
						$v=str_replace(".php",'',$v);
						$v=str_replace(".PHP",'',$v);
						$list.='<div id='.$program.'__'.$v.'>
						<span class="file_name_span">'.$language['file_name'].'<input type="text" value=\''.$v.'\' id="'.$program.'__'.$v.'_file_name" class="file_name">.php</span>
						<span class="name_span">'.$language['language_name'].'<input type="text" value=\''.@$program_language['language_dir'][$v].'\' id="'.$program.'__'.$v.'_name" class="name"></span>
						<span class=span>
						<a href="'.$program.'__'.$v.'" class=save >'.$language['save'].'</a> 
						<a href="./index.php?monxin=index.language_edit&path='.$program.'__'.$v.'" class=edit >'.$language['edit'].'</a> 
						<a href="'.$program.'__'.$v.'" class=del >'.$language['del'].'</a>
						<span id='.$program.'__'.$v.'_state></span>
						</span></div>';	
					}	
				}
				$list.='<div id='.$program.'_add>
				<span class="file_name_span">'.$language['file_name'].'<input type="text" value="" id="'.$program.'__add_file_name" class="file_name">.php</span>
				<span class="name_span">'.$language['language_name'].'<input type="text" value="" id="'.$program.'__add_name" class="name"></span>
				<span class=span>
				<a href="'.$program.'__add" class=add >'.$language['add_language'].'</a> 
				<span id='.$program.'__add_state></span>
				</span></div>';	
				
				$list.='</fieldset>';
			}else{
				$config=require('./config.php');
				$language=require('./language/'.$config['web']['language'].'.php');
				$list='<fieldset><legend>'.$language[$program].'</legend>';
				$r=scandir('./language/');
				//var_dump($language['language_dir']);
				foreach($r as $v){
					if(is_file('./language/'.$v)){
						$v=str_replace(".php",'',$v);
						$v=str_replace(".PHP",'',$v);
						$list.='<div id='.$program.'__'.$v.'>
						<span class="file_name_span">'.$language['file_name'].'<input type="text" value=\''.$v.'\' id="'.$program.'__'.$v.'_file_name" class="file_name">.php</span>
						<span class="name_span">'.$language['language_name'].'<input type="text" value=\''.@$language['language_dir'][$v].'\' id="'.$program.'__'.$v.'_name" class="name"></span>
						<span class=span>
						<a href="'.$program.'__'.$v.'" class=save >'.$language['save'].'</a> 
						<a href="./index.php?monxin=index.language_edit&path='.$program.'__'.$v.'" class=edit >'.$language['edit'].'</a> 
						<a href="'.$program.'__'.$v.'" class=del >'.$language['del'].'</a>
						<span id='.$program.'__'.$v.'_state></span>
						</span></div>';	
					}	
				}
				$list.='<div id='.$program.'_add>
				<span class="file_name_span">'.$language['file_name'].'<input type="text" value="" id="'.$program.'__add_file_name" class="file_name">.php</span>
				<span class="name_span">'.$language['language_name'].'<input type="text" value="" id="'.$program.'__add_name" class="name"></span>
				<span class=span>
				<a href="'.$program.'__add" class=add >'.$language['add_language'].'</a> 
				<span id='.$program.'__add_state></span>
				</span></div>';	
				$list.='</fieldset>';
			}
			
			return $list;	
		}
		
		if(@$_GET['program']!=''){
			$program=@$_GET['program'];
			if(is_dir("./program/".$program."/") || $program=='os_language'){
				$module['list']=echo_html(self::$language,$program);
			}
			
		}else{
			$module['list']=echo_html(self::$language,'os_language');
			$sql="select `name` from ".$pdo->index_pre."program order by `id` asc";
			$r=$pdo->query($sql,2);
			foreach($r as $v){
				$module['list'].=echo_html(self::$language,$v['name']);	
			}
			
				
		}




		$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
		$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
		
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);

