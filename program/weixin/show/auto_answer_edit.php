<?php

if(!$this->check_wid_power($pdo,self::$table_pre)){echo self::$language['act_noPower'];return false;}
$wid=safe_str(@$_GET['wid']);
$sql="select `name` from ".self::$table_pre."account where `wid`='".$wid."'";
$r=$pdo->query($sql,2)->fetch(2);
$w_name=$r['name'];

$id=intval(@$_GET['id']);
if($id==0){echo 'id err';return false;}
$sql="select * from ".self::$table_pre."auto_answer where `id`='".$id."' and `wid`='".$wid."'";
$module['data']=$pdo->query($sql,2)->fetch(2);
if($module['data']['id']==''){echo 'id err';return false;}

$input_select='';
$_GET['key']=@$_GET['key'];
foreach(self::$language['input_type'] as $key=>$v){
	$input_select.='<a href="./index.php?monxin=weixin.auto_answer_edit&id='.$id.'&wid='.$_GET['wid'].'&key='.urlencode($_GET['key']).'&type='.$key.'" id=input_type_'.$key.'>'.$v.'</a>';	
}

$module['input_select']=$input_select;

$type=@$_GET['type'];
if($type==''){$type='text';}
$_GET['type']=$type;
switch($type){
    case 'text':
        break;
    case 'image':
		if($module['data']['image']!=''){
			$module['data']['image']='<a href="./program/weixin/image/'.$module['data']['image'].'" target="_blank"><img src="./program/weixin/image_thumb/'.$module['data']['image'].'" class=imgth_thumb /></a><br />';			
		}
		require "./plugin/html4Upfile/createHtml4.class.php";
		$html4Upfile=new createHtml4();
		$html4Upfile->echo_input("image",'auto','./temp/','true','false','jpg|gif|png|jpeg','1024','1');
		//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');
        break;
    case 'voice':
		if($module['data']['voice']!=''){
			$module['data']['voice']='<audio src="./program/weixin/voice/'.$module['data']['voice'].'" controls="controls">'.self::$language['your_browser_does_not_support_the_audio_tag'].'</audio><br />';			
		}
		require "./plugin/html5Upfile/createHtml5.class.php";
		$html5Upfile=new createHtml5();
		$html5Upfile->echo_input(self::$language,"voice",'auto','','./temp/','true','false','mp3|wma|wav|amr',1024*get_upload_max_size(),'1');
		//echo_input("house_model",'控件宽度(百分比或像素)','multiple','保存到文件夹','文件是否附加日期','是否原名保存','允许文件类型','文件最大值','文件最小值');			
        break;
    case 'video':
		if($module['data']['video']!=''){
			//echo 'video:'.$module['data']['video'];
			$module['data']['video']='<video src="./program/weixin/video/'.$module['data']['video'].'" controls="controls">'.self::$language['your_browser_does_not_support_the_audio_tag'].'</video><br />';			
		}
		require "./plugin/html5Upfile/createHtml5.class.php";
		$html5Upfile=new createHtml5();
		$html5Upfile->echo_input(self::$language,"video",'auto','','./temp/','true','false','3gp|rm|rmvb|wmv|avi|mpg|mpeg|mp4',1024*get_upload_max_size(),'1');
		//echo_input("house_model",'控件宽度(百分比或像素)','multiple','保存到文件夹','文件是否附加日期','是否原名保存','允许文件类型','文件最大值','文件最小值');			
        break;
    case 'single_news':
		$sql="select * from ".self::$table_pre."single_news where `key_id`='".$id."'";
		$module['single_news']=$pdo->query($sql,2)->fetch(2);
		if($module['single_news']['img']!=''){
			$module['single_news']['img']='<a href="./program/weixin/image/'.$module['single_news']['img'].'" target="_blank"><img src="./program/weixin/image_thumb/'.$module['single_news']['img'].'" class=imgth_thumb /></a><br />';			
		}
		
		require "./plugin/html4Upfile/createHtml4.class.php";
		$html4Upfile=new createHtml4();
		$html4Upfile->echo_input("img",'auto','./temp/','true','false','jpg|gif|png|jpeg','1024','1');
		//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');
        break;
    case 'news':
		require "./plugin/html4Upfile/createHtml4.class.php";
		$html4Upfile=new createHtml4();
		$module['list']='';
	
		$sql="select * from ".self::$table_pre."news where `key_id`='".$id."' order by `sequence` desc,`id` asc   limit 0,9";
		$r=$pdo->query($sql,2);
		$i=0;
		foreach($r as $v){
			$img='';
			if($v['img']!=''){
				if($i==0){
					$img='<img src="./program/weixin/image/'.$v['img'].'" class="rectangle_thumb" /><br />';
				}else{
					$img='<img src="./program/weixin/image_thumb/'.$v['img'].'" class="square_thumb" /><br />';
				}
			}
			
			$html4Upfile->echo_input("img_".$i,'auto','./temp/','true','false','jpg|gif|png|jpeg','1024','1');
			$module['list'].='<tr id=tr_'.$i.' data_id="'.$v['id'].'">
			<td><div class=img_up_div>'.$img.'<span id=img_'.$i.'_state></span></div></td>
			<td><input type=text id=title_'.$i.' name=title_'.$i.' class=title value="'.$v['title'].'" /> <span id=title_'.$i.'_state></span></td>
			<td><input type=text id=url_'.$i.' name=url_'.$i.' class=url  value="'.$v['url'].'" /> <span id=url_'.$i.'_state></span></td>
			<td><input type=text id=sequence_'.$i.' name=sequence_'.$i.' class=sequence value="'.$v['sequence'].'" /> <span id=sequence_'.$i.'_state></span></td>
  			<td class=operation_td><a href="#" onclick="return del('.$i.')"  class=del>'.self::$language['del'].'</a></td>
			</tr>';
			$i++;
		}
	
		for($i;$i<8;$i++){
			$html4Upfile->echo_input("img_".$i,'auto','./temp/','true','false','jpg|gif|png|jpeg','1024','1');
			$module['list'].='<tr id=tr_'.$i.' data_id=0>
			<td><div class=img_up_div><span id=img_'.$i.'_state></span></div></td>
			<td><input type=text id=title_'.$i.' name=title_'.$i.' class=title /> <span id=title_'.$i.'_state></span></td>
			<td><input type=text id=url_'.$i.' name=url_'.$i.' class=url /> <span id=url_'.$i.'_state></span></td>
			<td><input type=text id=sequence_'.$i.' name=sequence_'.$i.' class=sequence value='.(@$v['sequence']-$i).' /> <span id=sequence_'.$i.'_state></span></td>
  			<td class=operation_td><a href="#" onclick="return del('.$i.')"  class=del>'.self::$language['del'].'</a></td>
			</tr>';
		}
		
        break;
    case 'function':
		$sql="select * from ".self::$table_pre."function where `state`=1 order by `sequence` desc,`id` asc";
		$r=$pdo->query($sql,2);
		$temp='';
		foreach($r as $v){
			$temp.='<option value="'.$v['name'].'">'.$v['description'].'</option>';	
		}
		$module['function_option']=$temp;		
        break;
}


$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&type='.$type.'&id='.$id.'&wid='.$wid;
echo ' <div id="user_position_reset" style="display:none;"><a href="index.php"><span id=user_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href="index.php?monxin=index.user">'.self::$language['user_center'].'</a><a href="index.php?monxin=weixin.account_list">'.self::$language['pages']['weixin.account_list']['name'].'</a><a href="index.php?monxin=weixin.account_list&wid='.$wid.'">'.$w_name.'</a><a href="index.php?monxin=weixin.auto_answer_list&wid='.$wid.'">'.self::$language['pages']['weixin.auto_answer_list']['name'].'</a><span class=text>'.self::$language['pages']['weixin.auto_answer_edit']['name'].'</span></div>';	

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/input_'.$type.'_edit.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/input_'.$type.'_edit.php';}
		require($t_path);
