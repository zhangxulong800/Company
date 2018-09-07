<?php
if(@$_GET['act']==''){exit('act is null');}
if(intval(@$_GET['id'])==0){exit('id is null');}
$_GET['id']=intval($_GET['id']);

		function admin_group_get_list($pdo,$language,$parent,$module_name){
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
				if($v['reg_able']==1){$reg_able='checked';}else{$reg_able='';}
				if($v['require_login']==1){$require_login='checked';}else{$require_login='';}
				if($v['require_check']==1){$require_check='checked';}else{$require_check='';}
				$list.="<tr id='tr_".$v['id']."'>
				<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
				<td width=320><span class='name' style='width:".(100-$v['deep']*10+10)."%;' >".$v['name']."</span></td><td  class=blank><span>&nbsp;</span></td>
			</tr>
	";	
			$list.=admin_group_get_list($pdo,$language,$v['id'],$module_name);
		}
			
			return $list;
		}
								
		$count=1;
		$module['parent']=index::get_group_select($pdo,'-1',0);
		$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&power=".$_GET['act'].'&id='.$_GET['id'];
		$name_count=0;
		$last_width=100;
		$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
		
		if($_GET['act']!='read_power'){
			$module['list']='';
		}else{
			$module['list']="<tr id='tr_0'>
				<td><input type='checkbox' name='0' id='0' class='id' /></td>
				<td width='320px'><span class='name' style='width:100%;' >".self::$language['unlogin_user']."</span></td><td  class=blank><span>&nbsp;</span></td>
			</tr>";
		}
		
		
		$module['list'].=admin_group_get_list($pdo,self::$language,0,$module['module_name']);
		
		$sql="select `".$_GET['act']."`,`name` from ".self::$table_pre."type where `id`='".$_GET['id']."'";
		//echo $sql;
		$r=$pdo->query($sql,2)->fetch(2);
		$module['ids']=$r[$_GET['act']];
		
echo ' <div id="user_position_reset" style="display:none;"><a href="index.php"><span id=user_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href="index.php?monxin=index.user">'.self::$language['user_center'].'</a><a href="index.php?monxin=form.table_admin">'.self::$language['program_name'].'</a><a href="index.php?monxin=talk.type_admin&id='.@$_GET['id'].'">'.$r['name'].'</a><span class=text>'.self::$language[$_GET['act']].self::$language['power'].'</span></div>';	

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);