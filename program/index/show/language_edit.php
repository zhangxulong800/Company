<?php
		
		function echo_html($language,$parent,$key,$v){
			$id=str_replace(",",'__',$parent).'__'.$key;
			$id=str_replace(".",'_dot_',$id);
			$id=trim($id,'__');
			$parent=explode(',',$parent);
			if(count($parent)==1 && $parent[0]!=''){$language=@$language[$parent[0]];}else{$language=$language;}
			if(count($parent)==2){$language=$language[$parent[0]][$parent[1]];}
			if(count($parent)==3){$language=$language[$parent[0]][$parent[1]][$parent[2]];}
			if(count($parent)==4){$language=$language[$parent[0]][$parent[1]][$parent[2]][$parent[3]];}
			$div='<div id=div_'.$id.'><span class="m_label">'.$key.'/'.$language[$key].'</span><span class="content"><input type="text" id="'.$id.'" name="'.$id.'" value=\''.$v.'\' /><span id='.$id.'_state ></span></span></div>';
			return $div;
		}
		
		
		
		
		$path=@$_GET['path'];
		$path=explode("__",$path);
		if($path[0]=='os_language'){
			$url='./language/'.$path[1].'.php';
			$current_url='./language/'.self::$config['web']['language'].'.php';
		}else{
			$url='./program/'.$path[0].'/language/'.$path[1].'.php';
			$config=require('./program/'.$path[0].'/config.php');
			$current_url='./program/'.$path[0].'/language/'.$config['program']['language'].'.php';
		}
		if(is_file($url)){
			$language=require($url);
			$current_language=require($current_url);
			if($path[0]=='os_language'){$parent=self::$language['os_language'];}else{$parent=$current_language['program_name'];}
			$list='<fieldset><legend>'.$parent.'.'.$language['language_dir'][$path[1]].'</legend>';
			foreach($language as $key=>$v){
				if(is_array($v)){
					$list.='<fieldset><legend>'.$key.'</legend>';
					foreach($v as $key2=>$v2){
						if(is_array($v2)){
							$list.='<fieldset><legend>'.$key2.'</legend>';	
							foreach($v2 as $key3=>$v3){
								if(is_array($v3)){
									$list.='<fieldset><legend>'.$key2.'</legend>';	
									foreach($v3 as $key4=>$v4){
										$list.=echo_html($current_language,$key.','.$key2.','.$key3,$key4,$v4);
									}
									$list.='</fieldset>';	
								}else{
									$list.=echo_html($current_language,$key.','.$key2,$key3,$v3);
								}	
							}
							$list.='</fieldset>';
						}else{
							$list.=echo_html($current_language,$key,$key2,$v2);
						}	
					}
					$list.='</fieldset>';
				}else{
					$list.=echo_html($current_language,'',$key,$v);
				}
			}
			$list.='</fieldset>';
		}
		
		$module['list']=$list;
		$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&path='.@$_GET['path'];
		$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
		
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);

