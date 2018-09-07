<?php

if(!$this->check_wid_power($pdo,self::$table_pre)){echo self::$language['act_noPower'];return false;}
$wid=safe_str(@$_GET['wid']);
$sql="select `name` from ".self::$table_pre."account where `wid`='".$wid."'";
$r=$pdo->query($sql,2)->fetch(2);
$w_name=$r['name'];


$input_select='';
$_GET['key']=@$_GET['key'];
foreach(self::$language['input_type'] as $key=>$v){
	$input_select.='<a href="./index.php?monxin=weixin.auto_answer_add&wid='.$_GET['wid'].'&key='.urlencode($_GET['key']).'&type='.$key.'" id=input_type_'.$key.'>'.$v.'</a>';	
}

$module['input_select']=$input_select;

$type=@$_GET['type'];
if($type==''){$type='text';}
$_GET['type']=$type;

switch($type){
    case 'text':
        break;
    case 'image':
		require "./plugin/html4Upfile/createHtml4.class.php";
		$html4Upfile=new createHtml4();
		$html4Upfile->echo_input("image",'auto','./temp/','true','false','jpg|gif|png|jpeg','1024','1');
		//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');
        break;
    case 'voice':
		require "./plugin/html5Upfile/createHtml5.class.php";
		$html5Upfile=new createHtml5();
		$html5Upfile->echo_input(self::$language,"voice",'auto','','./temp/','true','false','mp3|wma|wav|amr',1024*get_upload_max_size(),'1');
		//echo_input("house_model",'控件宽度(百分比或像素)','multiple','保存到文件夹','文件是否附加日期','是否原名保存','允许文件类型','文件最大值','文件最小值');			
        break;
    case 'video':
		require "./plugin/html5Upfile/createHtml5.class.php";
		$html5Upfile=new createHtml5();
		$html5Upfile->echo_input(self::$language,"video",'auto','','./temp/','true','false','3gp|rm|rmvb|wmv|avi|mpg|mpeg|mp4',1024*get_upload_max_size(),'1');
		//echo_input("house_model",'控件宽度(百分比或像素)','multiple','保存到文件夹','文件是否附加日期','是否原名保存','允许文件类型','文件最大值','文件最小值');			
        break;
    case 'single_news':
		require "./plugin/html4Upfile/createHtml4.class.php";
		$html4Upfile=new createHtml4();
		$html4Upfile->echo_input("img",'auto','./temp/','true','false','jpg|gif|png|jpeg','1024','1');
		//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');
        break;
    case 'news':
		require "./plugin/html4Upfile/createHtml4.class.php";
		$html4Upfile=new createHtml4();
		$module['list']='';
		for($i=0;$i<8;$i++){
			$html4Upfile->echo_input("img_".$i,'auto','./temp/','true','false','jpg|gif|png|jpeg','1024','1');
			$module['list'].='<tr id=tr_'.$i.'>
			<td><div class=img_up_div><span id=img_'.$i.'_state></span></div></td>
			<td><input type=text id=title_'.$i.' name=title_'.$i.' class=title /> <span id=title_'.$i.'_state></span></td>
			<td><input type=text id=url_'.$i.' name=url_'.$i.' class=url /> <span id=url_'.$i.'_state></span></td>
			<td><input type=text id=sequence_'.$i.' name=sequence_'.$i.' class=sequence value='.(100-($i.$i)).' /> <span id=sequence_'.$i.'_state></span></td>
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
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&type='.$type.'&wid='.$wid;
echo ' <div id="user_position_reset" style="display:none;"><a href="index.php"><span id=user_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href="index.php?monxin=index.user">'.self::$language['user_center'].'</a><a href="index.php?monxin=weixin.account_list">'.self::$language['pages']['weixin.account_list']['name'].'</a><a href="index.php?monxin=weixin.account_list&wid='.$wid.'">'.$w_name.'</a><a href="index.php?monxin=weixin.auto_answer_list&wid='.$wid.'">'.self::$language['pages']['weixin.auto_answer_list']['name'].'</a><span class=text>'.self::$language['pages']['weixin.auto_answer_add']['name'].'</span></div>';	

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/input_'.$type.'_add.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/input_'.$type.'_add.php';}
		require($t_path);

