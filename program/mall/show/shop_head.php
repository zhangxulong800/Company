<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['class_name']=self::$config['class_name'];
$module['web_language']=self::$config['web']['language'];
$type=@$_GET['type'];
$type=($type=='phone')?'phone':'pc';
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&type='.$type;

$sql="select `id`,`head_pc`,`head_phone` from ".self::$table_pre."shop where `username`='".$_SESSION['monxin']['username']."' and `state`=2 order by `id` desc limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){echo 'no shop';return false;}
$module['head_pc']=$r['head_pc'];
$module['head_phone']=$r['head_phone'];

echo " <script>
$(document).ready(function(){
$('#edit_page_layout_div').attr('id','').css('display','none');
        
    });
    </script>
    
";

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'_'.$type.'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'_'.$type.'.php';}
		require($t_path);	
