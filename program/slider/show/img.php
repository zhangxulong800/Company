<?php
$id=intval(@$_GET['id']);
if($id>0){
	$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&group_id='.$id;
	$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
	
	$sql="select `height`,`width`,`title` from ".self::$table_pre."group where `id`=$id";
	$r=$pdo->query($sql,2)->fetch(2);
	$module['group_title']=$r['title'];
	$module['group_height']=$r['height'];
	$module['group_width']=$r['width'];
	$sql="select * from ".self::$table_pre."img where `group_id`=$id order by `sequence` desc,`id` asc";
	$r=$pdo->query($sql,2);
	$list='';
			foreach($r as $v){
				$list.="<tr id='tr_".$v['id']."'>
				<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
				<td>
					<div>".self::$language['up_content']."</div><textarea type='text' name='name_".$v['id']."' id='name_".$v['id']."' class='name'>".$v['name']."</textarea><br  />
					<a href=# class=slider_img  file='./program/slider/img/".$v['id'].".jpg' ><img src='./program/slider/img/".$v['id'].".jpg' /></a>
				</td>
			  <td class=operation_td>
			  
			  <span class=m_label>".self::$language['url']."</span><input type='text' name='url_".$v['id']."' id='url_".$v['id']."' value='".$v['url']."'  class='url' /><br  />
			  <span class=m_label>".self::$language['target']."</span><select name='target_".$v['id']."' id='target_".$v['id']."' class='target'>
			  ".get_select_value($pdo,'target',$v['target'])."
			  </select><br  />
			  <span class=m_label>".self::$language['sequence']."</span><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."'  class='sequence' /><br  />
			  <a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
			</tr>
	";	
			}
		if($list==''){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
		$module['list']=$list;
	
	require "./plugin/html4Upfile/createHtml4.class.php";
	$html4Upfile=new createHtml4();
	$html4Upfile->echo_input("img_new",'400px','./temp/','false','false','jpg|png|gif','1024','1','');
	//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');
	
			$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
}else{
	echo (self::$language['need_params']);	
}
