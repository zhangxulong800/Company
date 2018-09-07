<?php
				
		$module['program_option']=index::get_program_option($pdo);
		$program=@$_GET['program'];
		if(@$_GET['url']==''){$_GET['url']='index.index';}
		if(@$_GET['area']==''){echo ('area is null');return false;}
		$_GET['params']=str_replace('|||','&',@$_GET['params']);
		$_POST['share_module']='';
		function get_modules($program,$p_language){
			$m=require('./program/'.$program.'/module_config.php');
			$list='';
			foreach($m as $key=>$v){
				$key2=preg_replace('/(\(.*\))/','',$key);
				if($_GET['url']==$key || $_GET['url']==$key2  || $v['share']){
					//echo $key.'<br />';
					
					if(isset($p_language['functions'][$key2]['description'])){$name=$p_language['functions'][$key2]['description'];}elseif(isset($p_language['pages'][$key2]['name'])){$name=$p_language['pages'][$key2]['name'];}else{$name=$key;}
					$module_name=preg_replace('/\./','_',$key);
					
					if($_GET['url']==$key){$view_page=$key;}else{$_POST['share_module'].=$key.',';$view_page='index.edit_page_layout_view_module';}
					
					$url='./index.php?monxin='.$view_page.'&edit_page_layout_view_module='.$module_name.'&#'.$module_name;
					//echo $url;
					
					$list.="<a href='".$url."' target=_blank module_name='".$key."' class=module_a>".$name."</a>";	
				}
			}
			return $list;
		}
		
		
		$c='';
		if($program==''){
			$sql="select `name` from ".$pdo->index_pre."program order by `id` asc";
			$r=$pdo->query($sql,2);
			foreach($r as $v){
				//echo $v['name'].'<br />';
				if(!is_file('./program/'.$v['name'].'/config.php')){continue;}
				$p_config=require('./program/'.$v['name'].'/config.php');
				$p_language=require('./program/'.$v['name'].'/language/'.$p_config['program']['language'].'.php');
				$list=get_modules($v['name'],$p_language);
				if($list!=''){$c.="<fieldset><legend>".$p_language['program_name']."</legend>".$list."</fieldset>";}
				
				
			}

			//$sql="update ".$pdo->index_pre."page set `full`='".$_POST['share_module']."' where `url`='index.edit_page_layout_view_module'";
			//$pdo->exec($sql);
			
		}else{
			$p_config=require('./program/'.$program.'/config.php');
			$p_language=require('./program/'.$program.'/language/'.$p_config['program']['language'].'.php');
			$list=get_modules($program,$p_language);
			$c.="<fieldset><legend>".$p_language['program_name']."</legend>".$list."</fieldset>";
		}
		
			
		$module['list']="<div id=program_option>".self::$language['current']."：<select id=program name=program><option value=''>".self::$language['all']."</option>".$module['program_option']."</select></div>".$c;



		$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&url=".$_GET['url'].'&area='.$_GET['area'];
		$module['module_name']=str_replace("::","_",$method);
		
		
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
		

