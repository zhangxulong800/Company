<?php
		$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
		$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
		
		
		function get_list($pdo,$language,$table_pre,$class){
			global $sum,$module;
			$parent=intval(@$_GET['parent']);
			$obj=new $class($pdo);
			$sql="select * from ".$table_pre."type where `parent`='$parent'";
			$order=" order by `visible` desc,`sequence` desc";
			$sql=$sql.$order;
			//echo($sql);
			//exit();
			$r=$pdo->query($sql,2);
			$list='';
			foreach($r as $v){
				$v['name']=de_safe_str($v['name']);
					$sql2="select count(id) as c from ".$table_pre."type where `parent`=".$v['id']."";
					$r2=$pdo->query($sql2,2)->fetch(2);
					$show_sub='';
					if($r2['c']>0){$show_sub="<a href='./index.php?monxin=mall.type&parent=".$v['id']."' >".$language['sub']."</a> ";}				
				if($v['visible']==1){$checked='checked';}else{$checked='';}
				$list.="<tr id='tr_".$v['id']."'  parentid='".$v['parent']."'>
				<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
				<td><select name='parent_".$v['id']."' id='parent_".$v['id']."'  class='parent'>
				<option value='0'>--".$language['none']."--</option>
				".$obj->get_parent($pdo,$v['id'],2,true)."
				</select></td>
				<td><input type='text' name='name_".$v['id']."' id='name_".$v['id']."' value='".$v['name']."'  class='name' style='width:".get_name_width($pdo,$v['id'],$table_pre)."%;' /></td>
				<td><a href=# id=icon_".$v['id']." class=icon><img src='./program/mall/type_icon/".$v['id'].".png'></a></td>
			  <td><input type='text' name='url_".$v['id']."' id='url_".$v['id']."' value='".$v['url']."' class='url' /></td>
			  <td><input type='text' name='t_cid_".$v['id']."' id='t_cid_".$v['id']."' value='".$v['t_cid']."' class='t_cid' /></td>
			  <td><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."' class='sequence' /></td>
			  <td><input type='checkbox' name='visible_".$v['id']."' id='visible_".$v['id']."'  class='visible' $checked /></td>
			  <td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".$language['submit']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".$language['del']."</a> <span id=state_".$v['id']." class='state'></span><br /><a href=./index.php?monxin=mall.type_remark&id=".$v['id']." class=remark>".$language['ad']."</a> <a href=./index.php?monxin=mall.type_price&id=".$v['id']." class=type_price>".$language['type_price']."</a> ".$show_sub."<br /><a href='./index.php?monxin=mall.type_brand&type=".$v['id']."' >".$language['brand']."</a> <a href='./index.php?monxin=mall.type_attribute&type=".$v['id']."' >".$language['attribute']."</a> <a href='./index.php?monxin=mall.type_option&type=".$v['id']."' >".$language['option']."</a></td>
			</tr>
	";	
			}
			return $list;
		}
		
		function get_name_width($pdo,$id,$table_pre){
			$sql="select `parent`,`id` from ".$table_pre."type where `id`='$id'";
			$v=$pdo->query($sql,2)->fetch(2);
			if($v['parent']==0){return 97;}	
			$sql="select `parent`,`id` from ".$table_pre."type where `id`='".$v['parent']."'";
			$v=$pdo->query($sql,2)->fetch(2);
			if($v['parent']==0){return 77;}	
			$sql="select `parent`,`id` from ".$table_pre."type where `id`='".$v['parent']."'";
			$v=$pdo->query($sql,2)->fetch(2);
			if($v['parent']==0){return 57;}	
			//return 100;
		}
		
		$module['parent']=$this->get_parent($pdo,-1,2,true);
		$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
		$sum=0;
		$module['list']=get_list($pdo,self::$language,self::$table_pre,$class);		

		echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=mall.type">'.self::$language['pages']['mall.type']['name'].'</a>'.$this->get_type_user_position($pdo,intval(@$_GET['parent'])).'<span class=text></span></div>';
		
		
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);	
