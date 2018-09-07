<?php
if(!$this->check_wid_power($pdo,self::$table_pre)){echo self::$language['act_noPower'];return false;}
$wid=safe_str(@$_GET['wid']);

$sql="select `name` from ".self::$table_pre."account where `wid`='".$wid."'";
$r=$pdo->query($sql,2)->fetch(2);
$w_name=$r['name'];


if(isset($_POST['new'])){
	$new=json_decode($_POST['new'],1);
	$new=safe_str($new);
	$time=time();
	foreach($new as $k=>$v){
		if(!is_file($v['icon'])){continue;}
		$path=get_date_dir('./program/weixin/image/');
		$dir=str_replace('./program/weixin/image/','',$path);
		$v['icon']=safe_path($v['icon']);
		$icon=explode('/',$v['icon']);
		$v['icon_new']=$dir.$icon[count($icon)-1];
		$sql="insert into ".self::$table_pre."mass (`wid`,`title`,`icon`,`url`,`last_time`) values ('".$wid."','".$v['title']."','".$v['icon_new']."','".$v['url']."','".$time."')";
		if($pdo->exec($sql)){
			$new_id=$pdo->lastInsertId();
			copy($v['icon'],'./program/weixin/image/'.$v['icon_new'].'');
				$path2='./program/weixin/image/'.$v['icon_new'];
				$sql="select `AppId`,`AppSecret` from ".self::$table_pre."account where `wid`='".$wid."'";
				$r=$pdo->query($sql,2)->fetch(2);
				$access_token=self::get_access_token($pdo,$r['AppId'],$r['AppSecret'],$wid);
				if($access_token===false){exit("{'state':'fail','info':'<span class=fail>".self::$language['AppId'].self::$language['or'].self::$language['AppSecret'].self::$language['err']." </span>'}");}
				
				$path3='./temp.jpg';
				$image=new image();
				$image->thumb($path2,$path3,512,512);
				$tmpInfo=self::get_media_id($access_token,$path3);
				if(isset($tmpInfo['thumb_media_id'])){
					$sql="update ".self::$table_pre."mass set `media_id`='".$tmpInfo['thumb_media_id']."' where `id`=".$new_id;
					$pdo->exec($sql);
				}else{
					reset_weixin_info($wid,$pdo);
					$access_token=self::get_access_token($pdo,$r['AppId'],$r['AppSecret'],$wid);
					$tmpInfo=self::get_media_id($access_token,$path3);
					$sql="update ".self::$table_pre."mass set `media_id`='".$tmpInfo['thumb_media_id']."' where `id`=".$new_id;
					$pdo->exec($sql);
				}
			
		}
			
		
	}
}

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['state']=@$_GET['state'];
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."mass where `wid`='".$wid."'";

$where="";

if($_GET['search']!=''){$where=" and (`title` like '%".$_GET['search']."%')";}
if(@$_GET['order']==''){
	$order=" order by `sequence` desc,`id` desc";
}else{
	$_GET['order']=safe_str($_GET['order']);
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_mass and","_mass where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_mass and","_mass where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
	$del='';
	$del=" <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a>";
	$list.="<tr id='tr_".$v['id']."'>
	<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
	<td>
		<div class=info><span class=icon_span><img src='./program/weixin/image/".$v['icon']."' /></span><span class=title_url>
			<div><input type='text' name='title_".$v['id']."' id='title_".$v['id']."' value='".$v['title']."'  class='title' /></div>
			<div><input type='text' name='url_".$v['id']."' id='url_".$v['id']."' value='".$v['url']."'  class='url' /></div>
		</span></div>
	</td>
	<td><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."' class='sequence' /></td>
	<td>".$v['visit']."</td>
	<td><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['last_time'])."</span></td>
  <td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a> ".$del." <span id=state_".$v['id']." class='state'></span></td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&wid='.$wid;
$module['class_name']=self::$config['class_name'];
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

echo ' <div id="mass_position_reset" style="display:none;"><a href="index.php"><span id=mass_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href="index.php?monxin=index.mass">'.self::$language['user_center'].'</a><a href="index.php?monxin=weixin.account_list">'.self::$language['pages']['weixin.account_list']['name'].'</a><a href="index.php?monxin=weixin.account_list&wid='.$wid.'">'.$w_name.'</a><span class=text>'.self::$language['pages']['weixin.mass']['name'].'</span></div>';	

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

require "./plugin/html4Upfile/createHtml4.class.php";
$html4Upfile=new createHtml4();

$html4Upfile->echo_input("icon",'auto','./temp/','false','false','jpg|png','1024','1');
//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');
//指定保存名时，要先设置权限 $_SESSION['replace_file']=true;  ，否则将无效
