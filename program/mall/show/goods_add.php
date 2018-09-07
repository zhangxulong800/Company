<?php
if(intval(@$_GET['type'])==0){header('location:./index.php?monxin=mall.goods_add_option_type&act=add');exit;}
$_GET['type']=intval($_GET['type']);
$module['type']=$this->get_type_parent_text($pdo,$_GET['type']);
$module['brand_option']=$this->get_brand_option($pdo,$_GET['type']);
$module['grade_option']=$this->get_grade_option($pdo,SHOP_ID);
$module['habitat_option']=$this->get_habitat_option($pdo,SHOP_ID);
$module['contain_option']=$this->get_contain_option($pdo,SHOP_ID);
$module['attribute_html']=$this->get_attribute_html($pdo,$_GET['type']);
$module['option_html']=$this->get_option_html($pdo,$_GET['type']);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['class_name']=self::$config['class_name'];
$module['web_language']=self::$config['web']['language'];
$module['thumb_width']=self::$config['program']['thumb_width'];
$module['thumb_height']=self::$config['program']['thumb_height'];
$module['image_mark_option']=get_image_mark_option(self::$config['program']['imageMark'],self::$language);
$module['tags']=self::get_shop_tag_html($pdo);
$module['position']=self::get_goods_position_option($pdo);
$module['storehouse']=self::get_goods_storehouse_option($pdo);
$module['supplier']=self::get_goods_supplier_option($pdo);
$module['unit']=self::get_goods_unit_option($pdo);
$module['shop_type']=$this->get_shop_parent($pdo,-1,2);
$module['goods_state']=self::get_goods_state_option($pdo);




require "./plugin/html4Upfile/createHtml4.class.php";
$html4Upfile=new createHtml4();
echo '<div style="display:none;">';
$html4Upfile->echo_input("icon",'100%','./temp/','true','false','jpg|gif|png|jpeg',1024*10,'1');
echo '</div>';
//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');
//指定保存名时，要先设置权限 $_SESSION['replace_file']=true;  ，否则将无效


require "./plugin/html5Upfile/createHtml5.class.php";
$html5Upfile=new createHtml5();
echo '<div style="display:none;">';
$html5Upfile->echo_input(self::$language,"multi_angle_img",'100%','multiple','./temp/','true','false','jpg|gif|png|jpeg',1024*10,'1');
echo '</div>';
//echo_input(语言数组,"house_model",'控件宽度(百分比或像素)','multiple','保存到文件夹','文件夹是否附加日期','是否原名保存','允许文件类型','文件最大值','文件最小值');

$module['color_tr']='';
$module['move_color_input']='';
$module['option_table']='';
if(isset($_POST['option_type'])){
	$option_type=intval($_POST['option_type']);
	if(isset($_POST['option_color'])){	
		$sql="select * from ".self::$table_pre."color order by `sequence` desc";
		$r2=$pdo->query($sql,2);
		echo '<div style="display:none;">';
		foreach($r2 as $v){
			$module['color_tr'].='<tr id=tr_color_'.$v['id'].'><td><img src="./program/mall/color_icon/'.$v['id'].'.png" class=tr_color_icon /> <input type=text id=color_name_'.$v['id'].' value='.$v['name'].' class=color_name /></td><td><span class=state id=color_img_'.$v['id'].'_state></span></td><td id=color_img_'.$v['id'].'_td>&nbsp;</td></tr>';
			$html4Upfile->echo_input("color_img_".$v['id']."",'100%','./temp/','true','false','jpg|gif|png|jpeg','1024','1');
			$module['move_color_input'].='$("#color_img_'.$v['id'].'_ele").insertBefore($("#color_img_'.$v['id'].'_state"));';
	
		}
		echo '</div>';
		
		
	  if(isset($_POST['option_option'])){
		  $sql="select `option_name` from ".self::$table_pre."type where `id`=".$option_type;
		  $r=$pdo->query($sql,2)->fetch(2);
		  $module['option_table']='<table cellpadding="0" cellspacing="0" id="option_table">
					  <thead><tr><td>'.self::$language['color'].'</td><td>'.$r['option_name'].'</td><td>'.self::$language['quantity'].'<span class=require>*</span></td><td>'.self::$language['cost_price'].'<span class=require>*</span></td><td>'.self::$language['e_price'].'<span class=require>*</span></td><td>'.self::$language['w_price'].'<span class=require>*</span></td><td>'.self::$language['bar_code'].'</td><td>'.self::$language['store_code'].'</td><td>&nbsp;</td></tr></thead>
					  <tbody>
						  
					  </tbody>
				  </table>';
	  }else{
		  $module['option_table']='<table cellpadding="0" cellspacing="0" id="option_table">
					  <thead><tr><td>'.self::$language['color'].'</td><td>'.self::$language['quantity'].'<span class=require>*</span></td><td>'.self::$language['cost_price'].'<span class=require>*</span></td><td>'.self::$language['e_price'].'<span class=require>*</span></td><td>'.self::$language['w_price'].'<span class=require>*</span></td><td>'.self::$language['bar_code'].'</td><td>'.self::$language['store_code'].'</td><td>&nbsp;</td></tr></thead>
					  <tbody>
						  
					  </tbody>
				  </table>';
	  }
		  
		
	}else{
		$sql="select `option_name` from ".self::$table_pre."type where `id`=".$option_type;
		$r=$pdo->query($sql,2)->fetch(2);
		$module['option_table']='<table cellpadding="0" cellspacing="0" id="option_table">
					  <thead><tr><td>'.$r['option_name'].'</td><td>'.self::$language['quantity'].'<span class=require>*</span></td><td>'.self::$language['cost_price'].'<span class=require>*</span></td><td>'.self::$language['e_price'].'<span class=require>*</span></td><td>'.self::$language['w_price'].'<span class=require>*</span></td><td>'.self::$language['bar_code'].'</td><td>'.self::$language['store_code'].'</td><td>&nbsp;</td></tr></thead>
					  <tbody>
						  
					  </tbody>
				  </table>';
	}
	
}
$module['class_name']=self::$config['class_name'];
$module['web_language']=self::$config['web']['language'];

$module['buy_limit_option']='<option value="0">'.self::$language['unlimited'].'</option><option value="1">'.str_replace('{number}',1,self::$language['everyone_buy_limit']).'</option><option value="2">'.str_replace('{number}',2,self::$language['everyone_buy_limit']).'</option><option value="5">'.str_replace('{number}',5,self::$language['everyone_buy_limit']).'</option><option value="10">'.str_replace('{number}',10,self::$language['everyone_buy_limit']).'</option>';
$module['limit_cycle_option']='<option value="d">'.self::$language['per'].self::$language['d2'].'</option><option value="m">'.self::$language['per'].self::$language['m'].'</option><option value="y">'.self::$language['per'].self::$language['Y'].'</option>';

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
