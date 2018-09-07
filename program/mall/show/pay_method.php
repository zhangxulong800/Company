<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$list='';

foreach(self::$config['pay_method_sequence'] as $k=>$v){
	if($k=='cash' || $k=='credit'){continue;}
	if(self::$config['pay_method'][$k]){$checked='checked';}else{$checked='';}
	$edit='';
	if($k=='bank_transfer'){$edit=" <a href='./index.php?monxin=index.payment' target=_blank class=edit>".self::$language['edit']."</a>";}
	if($k=='online_payment'){$edit=" <a href='./index.php?monxin=index.payment' target=_blank class=edit>".self::$language['edit']."</a>";}
	if($k=='cash_on_delivery'){$edit=" <a href='./index.php?monxin=mall.pay_method#cash_on_delivery_remark' class=edit>".self::$language['edit']."</a>";}
	$list.='<tr id="tr_'.$v['id'].'">
			<td><span class=name>'.self::$language['pay_method'][$k].'</span></td>
			<td><input type="checkbox" id="visible_'.$k.'" class="visible" '.$checked.' /></td>
		 	<td><input type="text" id="sequence_'.$k.'"  value="'.$v.'"  class="sequence" /></td>
		 	<td class=operation_td><a href="#" onclick="return update(\''.$k.'\')"  class="submit">'.self::$language['submit'].'</a> <span id=state_'.$k.' class="state"></span> '.$edit.'</td>
		';
}
$module['list']=$list;

$module['pay_time_limit']=self::$config['pay_time_limit'];
$module['cash_on_delivery']=file_get_contents('./program/mall/cash_on_delivery.txt');

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
