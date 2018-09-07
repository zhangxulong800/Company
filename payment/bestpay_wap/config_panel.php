<?php
header('Content-Type:text/html;charset=utf-8');

ini_set('session.save_path', '../../config/session/');
session_start();
$config=require("./config.php");
require_once '../../config/functions.php';
if(!@in_array("index.payment",@$_SESSION['monxin']['function'])){exit('noPower');}	



if(@$_GET['act']=='submit'){
		$_GET=monxin_trim($_GET);
		@require "../../plugin/set_magic_quotes_gpc_off/set_magic_quotes_gpc_off.php";
		if(@$_GET['provider_name']==''){exit("{'state':'fail','errType':'provider_name','errInfo':'不能为空'}");}
		if(@$_GET['for']!='pc' && @$_GET['for']!='phone'){exit("{'state':'fail','errType':'for','errInfo':'不能为空'}");}
		if(@$_GET['state']!='opening' && @$_GET['state']!='closed'){exit("{'state':'fail','errType':'state','errInfo':'不能为空'}");}
		if(!is_numeric(@$_GET['rate'])){exit("{'state':'fail','errType':'rate','errInfo':'必须是数字'}");}
		if(!is_email(@$_GET['username'])){exit("{'state':'fail','errType':'username','errInfo':'必须是邮箱'}");}
		if(!is_numeric(@$_GET['id'])){exit("{'state':'fail','errType':'id','errInfo':'必须是数字'}");}
		if(@$_GET['key']==''){exit("{'state':'fail','errType':'key','errInfo':'不能为空'}");}
		
		$config['provider_name']=$_GET['provider_name'];
		$config['state']=$_GET['state'];
		$config['rate']=$_GET['rate'];
		$config['username']=$_GET['username'];
		$config['id']=$_GET['id'];
		$config['key']=$_GET['key'];
		$config['for']=$_GET['for'];
		
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
        $("#submit_state").html("<img src='../../templates/index/default/pc/img/monxin.gif'>");
        top_ajax_form('monxin_form','submit_state','show_result');

        return false;
        }
        
    
    function show_result(){
        v=$("#submit_state").html();
        json=eval("("+v+")");
		
       	$("#submit_state").html(json.errInfo);
		if(json.errType!=''){$("#"+json.errType+"_state").html(json.errInfo);}
    }

</script>
</head>
<body>
<style>
body{ line-height:40px;}
.label{ display:inline-block; width:300px; text-align:right; padding-right:5px;}
input{width:35%;}
</style>
<form name="monxin_form" id="monxin_form" method="GET" action="./config_panel.php?act=submit" onSubmit="return exe_check();">
  <div style="text-align:center"><a href=http://www.monxin.com/index.php?monxin=talk.content&key=page_tutorial|index.payment.alipay target=_blank>配置教程</a></div>
  <span class="label">名称</span><span class="input"><input type="text" name="provider_name" id="provider_name" value="<?php echo $config['provider_name'];?>" ><span id=provider_name_state></span></span><br />
  <span class="label">合用于</span><span class="input"><select name="for" id="for">
  <option value="pc" <?php if($config['for']=='pc'){echo 'selected';}?> >电脑浏览器</option>
  <option value="phone" <?php if($config['for']=='phone'){echo 'selected';}?> >手机浏览器</option>
  </select>
  <span id=for_state></span></span><br />
  <span class="label">状态</span><span class="input"><select name="state" id="state">
  <option value="opening" <?php if($config['state']=='opening'){echo 'selected';}?> >开启</option>
  <option value="closed" <?php if($config['state']=='closed'){echo 'selected';}?> >关闭</option>
  </select>
  <span id=state_state></span></span><br />
  <span class="label">手续费</span><span class="input"><input type="text" name="rate" id="rate" value="<?php echo $config['rate'];?>" style="text-align:right; width:50px;">%<span id=rate_state></span></span><br />
  <span class="label" style="display:none;">支付宝账号</span><span class="input" style="display:none;"><input type="text" name="username" id="username" value="<?php echo $config['username'];?>"><span id=username_state></span></span><br />
  <span class="label">商户代码</span><span class="input"><input type="text" name="id" id="id" value="<?php echo $config['id'];?>"><span id=id_state></span></span><br />
  <span class="label">KEY</span><span class="input"><input type="text" name="key" id="key" value="<?php echo $config['key'];?>"><span id=key_state></span></span><br />
  <span class="label">&nbsp;</span><span class="input"><input type="submit" name="button" id="button" value="提交"><span id=submit_state></span></span><br />
</form>
</body>
</html>
