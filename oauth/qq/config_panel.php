<?php
header('Content-Type:text/html;charset=utf-8');
ini_set('session.save_path', '../../config/session/');
session_start();
$config=require("./config.php");
require_once '../../config/functions.php';
if(!@in_array("index.oauth",@$_SESSION['monxin']['function'])){exit('noPower');}	



if(@$_GET['act']=='submit'){
	$_GET=monxin_trim($_GET);
	if(!is_numeric(@$_GET['sequence'])){exit("{'state':'fail','errType':'sequence','errInfo':'必须是数字'}");}
	$r=scandir('../');
	foreach($r as $v){
		if(is_dir('../'.$v) && $v!='.' && $v!='..' && $v!='qq'){
			$c=require('../'.$v.'/config.php');
			if($c['sequence']==$_GET['sequence']){exit("{'state':'fail','errType':'sequence','errInfo':'排序已存在，请不要重复'}");}
		}
	}
	@require "../../plugin/set_magic_quotes_gpc_off/set_magic_quotes_gpc_off.php";
	if(@$_GET['name']==''){exit("{'state':'fail','errType':'name','errInfo':'不能为空'}");}
	if(@$_GET['state']!='opening' && @$_GET['state']!='closed'){exit("{'state':'fail','errType':'state','errInfo':'不能为空'}");}
	if(!is_numeric(@$_GET['appid'])){exit("{'state':'fail','errType':'appid','errInfo':'必须是数字'}");}
	if(!is_numeric(@$_GET['sequence'])){exit("{'state':'fail','errType':'sequence','errInfo':'必须是数字'}");}
	if(@$_GET['appkey']==''){exit("{'state':'fail','errType':'appkey','errInfo':'不能为空'}");}
	
	$config['name']=$_GET['name'];
	$config['state']=$_GET['state'];
	$config['sequence']=$_GET['sequence'];
	$config['appid']=$_GET['appid'];
	$config['appkey']=$_GET['appkey'];
	
	if(file_put_contents('./config.php','<?php return '.var_export($config,true).'?>')){
		exit("{'state':'success','errType':'exe_success','errInfo':'成功'}");
	}else{
		exit("{'state':'fail','errType':'exe_fail','errInfo':'失败'}");	
	}
		
}


?>
<!DOCTYPE html>
<head>
<meta charset="utf-8" />
<script src="../../public/jquery.js"></script>
<script src="../../public/sys_head.js"></script>
<script src="../../public/top_ajax_form.js"></script>
<script> 
$(document).ready(function(){

});

   function exe_check(){
        //表单输入值检测... 如果非法则返回 false
		$(".input span").html('');
        $("#submit_state").html("<img src='../../templates/index/default/pc/img/monxin.gif'>");
        top_ajax_form('monxin_form','submit_state','show_result');

        return false;
        }
        
    
    function show_result(){
        v=$("#submit_state").html();
        json=eval("("+v+")");
		try{eval(json.state+"_sound()");}catch(e){}
       	$("#submit_state").html(json.errInfo);
		if(json.errType!=''){$("#"+json.errType+"_state").html(json.errInfo);}
    }

</script>
</head>
<body>
<style>
body{ line-height:40px; white-space:nowrap;}
.label{ display:inline-block; width:30%; text-align:right; padding-right:5px;}
input{width:35%;}
</style>
<form name="monxin_form" id="monxin_form" method="GET" action="./config_panel.php?act=submit" onSubmit="return exe_check();">
  <div style="text-align:center"><a href=http://www.monxin.com/index.php?monxin=talk.content&key=page_tutorial|index.oauth.qq target=_blank>配置教程</a></div>
  <span class="label">名称</span><span class="input"><input type="text" name="name" id="name" value="<?php echo $config['name'];?>" ><span id=name_state></span></span><br />
  <span class="label">状态</span><span class="input"><select name="state" id="state">
  <option value="opening" <?php if($config['state']=='opening'){echo 'selected';}?> >开启</option>
  <option value="closed" <?php if($config['state']=='closed'){echo 'selected';}?> >关闭</option>
  </select>
  <span id=state_state></span></span><br />
  <span class="label">排序</span><span class="input"><input type="text" name="sequence" id="sequence" value="<?php echo $config['sequence'];?>"><span id=sequence_state></span></span><br />
  <span class="label">appid</span><span class="input"><input type="text" name="appid" id="appid" value="<?php echo $config['appid'];?>"><span id=appid_state></span></span><br />
  <span class="label">appkey</span><span class="input"><input type="text" name="appkey" id="appkey" value="<?php echo $config['appkey'];?>"><span id=appkey_state></span></span><br />
  <span class="label">&nbsp;</span><span class="input"><input type="submit" name="button" id="button" value="提交"><span id=submit_state></span></span><br />
</form>
</body>
</html>
