<?php
		function admin_group_get_list($pdo,$language,$parent,$module_name,$exists,$default_credits){
			$sql="select * from ".$pdo->index_pre."group";
			$where=" and `parent`='$parent'";
			$order=" order by `sequence` desc";
			$sql=$sql.$where.$order;
			$sql=str_replace("_group and","_group where",$sql);
			//echo($sql);
			//exit();
			$r=$pdo->query($sql,2);
			$list='';
			foreach($r as $v){
				if(isset($exists[$v['id']])){$credits=$exists[$v['id']];}else{$credits=$default_credits;}
				$list.="<tr>
				<td width=320><div class=name style='width:".(100-$v['deep']*10+10)."%;'>".$v['name']."</div></td>
			  <td><input type='text' d_id=".$v['id']." value='".$credits."' class='credits' /> <span class=state></span></td>
			</tr>
	";	
			$list.=admin_group_get_list($pdo,$language,$v['id'],$module_name,$exists,$default_credits);
		}
			
			return $list;
		}
								
		$count=1;
		$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
		$name_count=0;
		$last_width=100;
		$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
		
		$sql="select `group_id`,`credits` from ".self::$table_pre."group_set";
		$r=$pdo->query($sql,2);
		$exists=array();
		foreach($r as $v){
			$exists[$v['group_id']]=$v['credits'];	
		}
		

		$module['list']=admin_group_get_list($pdo,self::$language,0,$module['module_name'],$exists,self::$config['give_credits']);
		
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);