<?php
		function visitor_position_get_parent($pdo,$id){
			$list='';
			if($id!=0){
				$sql2="select `name`,`url`,`parent_id` from ".$pdo->index_pre."navigation where `id`='$id'" ;
				$v2=$pdo->query($sql2,2)->fetch(2);
				if($v2['name']!=''){
					if($v2['parent_id']!=0){
						$sql3="select `name`,`url`,`parent_id` from ".$pdo->index_pre."navigation where `id`='".$v2['parent_id']."'" ;
						$v3=$pdo->query($sql3,2)->fetch(2);
						if($v3['name']!=''){
							$list.="<a href='".$v3['url']."'>".$v3['name']."</a>";
						}
					}
					$list.="<a href='".$v2['url']."'>".$v2['name']."</a>";		
				}
			}
			return $list;
		}		
		
		$module['list']="<span id=current_position_text>".self::$language['current_position']."</span><a href='./index.php'><span id=visitor_position_icon>&nbsp;</span>".self::$config['web']['name']."</a>";
		$url=GetCurUrl();
		$temp=explode("?",$url);
		$page=@$_GET['monxin'];		
		if(count($temp)==2){
			$pre="index.php?";
			$query_str=$pre.@$temp[1];
			$find=false;
			$key=array();
			$key[]="%$query_str";
			$key[]="%$query_str%";
			$temp=explode("&",$query_str);
			if(count($temp)>=4){$key[]="%".$temp[0]."&".$temp[1]."&".$temp[2]."&".$temp[3]."%";}
			if(count($temp)>=3){$key[]="%".$temp[0]."&".$temp[1]."&".$temp[2]."%";}
			if(count($temp)>=2){$key[]="%".$temp[0]."&".$temp[1]."%";}
			if(count($temp)>=1){$key[]="%".$temp[0]."%";}
			$key=array_unique($key);
			$key=array_values($key);
			//var_dump($key);
			for($i=0;$i<count($key);$i++){
				//echo $i."=".$key[$i]."<br>";
				$sql="select `name`,`url`,`parent_id` from ".$pdo->index_pre."navigation where `url` like '".safe_str($key[$i])."' order by `parent_id` asc limit 0,1" ;
				$v=$pdo->query($sql,2)->fetch(2);
				if($v['name']!=''){break;}
			}
			if($v['name']!=''){
				$module['list'].=visitor_position_get_parent($pdo,$v['parent_id']);
			}
		}
		
		$module['list']=str_replace("\r\n",'',$module['list']);
		
		$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
	
