<?php
			$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
			$_GET['search']=safe_str(@$_GET['search']);
			$_GET['search']=trim($_GET['search']);
			$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
			$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

			$sql="select * from ".$pdo->index_pre."site_msg";
			
			$where="";
			$_GET['addressee_state']=intval(@$_GET['addressee_state']);
			if($_GET['addressee_state']!=0){$where=" and `addressee_state`='".$_GET['addressee_state']."'";}
			if($_GET['search']!=''){$where=" and (`title` like '%".$_GET['search']."%' or `content` like '%".$_GET['search']."%' or `addressee` like  '%".$_GET['search']."%')";}
			$where.=" and `sender_state`!='3' and `sender`='".$_SESSION['monxin']['username']."'";
			if(@$_GET['order']==''){
				$order=" order by `id` desc";
			}else{
				$_GET['order']=safe_str($_GET['order']);
				$temp=safe_order_by($_GET['order']);
				if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
					
			}
			$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
				$sum_sql=$sql.$where;
				$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
				$sum_sql=str_replace("_site_msg and","_site_msg where",$sum_sql);
				$r=$pdo->query($sum_sql,2)->fetch(2);
				$sum=$r['c'];
			$sql=$sql.$where.$order.$limit;
			$sql=str_replace("_site_msg and","_site_msg where",$sql);
			//echo($sql);
			//exit();
			$r=$pdo->query($sql,2);
			$list='';
			foreach($r as $v){
				$list.="<tr id='tr_".$v['id']."'>
				<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
			 	<td><span class=addressee>".$v['addressee']."(".get_real_name($pdo,get_user_id($pdo,$v['addressee'])).")</span></td>
				<td><a href='index.php?monxin=index.site_msg_detail&id=".$v['id']."' target=_blank class=title>".$v['title']."</a></td>
			 	<td><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</span></td>
			 	<td><span  class=state>".self::$language['site_msg_state'][$v['addressee_state']]."</span></td>
			 	<td class=operation_td><a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
			</tr>
	";	
			}
		if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}
		$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
		$module['filter']="<select id='addressee_state' name='addressee_state'><option value='-1'>".self::$language['state']."</option><option value='' selected>".self::$language['all']."</option><option value='1'>".self::$language['site_msg_state'][1]."</option><option value='2'>".self::$language['site_msg_state'][2]."</option></select>";
		$module['list']=$list;
		$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);
		
		
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);	