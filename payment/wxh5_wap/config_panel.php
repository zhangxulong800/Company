<?php
header('Content-Type:text/html;charset=utf-8');
ini_set('session.save_path', '../../config/session/');
session_start();
$config=require("./config.php");
require_once '../../config/functions.php';
if(!@in_array("index.payment",@$_SESSION['monxin']['function'])){exit('noPower');}	



if(@$_GET['act']=='submit'){
		$_POST=monxin_trim($_POST);
		@require "../../plugin/set_magic_quotes_gpc_off/set_magic_quotes_gpc_off.php";
		if(@$_POST['provider_name']==''){exit("{'state':'fail','errType':'provider_name','errInfo':'不能为空'}");}
		if(@$_POST['for']!='pc' && @$_POST['for']!='phone'){exit("{'state':'fail','errType':'for','errInfo':'不能为空'}");}
		if(@$_POST['state']!='opening' && @$_POST['state']!='closed'){exit("{'state':'fail','errType':'state','errInfo':'不能为空'}");}
		if(!is_numeric(@$_POST['rate'])){exit("{'state':'fail','errType':'rate','errInfo':'必须是数字'}");}
		if(!is_numeric(@$_POST['mchid'])){exit("{'state':'fail','errType':'mchid','errInfo':'必须是数字'}");}
		
		$config['provider_name']=$_POST['provider_name'];
		$config['state']=$_POST['state'];
		$config['rate']=$_POST['rate'];
		$config['appid']=$_POST['appid'];
		$config['appsecret']=$_POST['appsecret'];
		$config['mchid']=$_POST['mchid'];
		$config['key']=$_POST['key'];
		$config['for']=$_POST['for'];
		
		
		if(file_put_contents('./config.php','<?php return '.var_export($config,true).'?>')){
			$mb=file_get_contents('./wechatPayConf_template.php');
			foreach($config as $k=>$v){
				$mb=str_replace('{'.$k.'}',$v,$mb);
			}
			if(file_put_contents('./wechatPayConf.php',$mb)){
				$mb=file_get_contents('./lib/WxPay.Config_template.php');
				foreach($config as $k=>$v){
					$mb=str_replace('{'.$k.'}',$v,$mb);
				}
				if(file_put_contents('./lib/WxPay.Config.php',$mb)){
					exit("{'state':'success','errType':'exe_success','errInfo':'成功'}");
				}else{
					exit("{'state':'fail','errType':'exe_fail','errInfo':'失败'}");					
				}
					
				
				
				
				exit("{'state':'success','errType':'exe_success','errInfo':'成功'}");
			}else{
				exit("{'state':'fail','errType':'exe_fail','errInfo':'失败'}");					
			}
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
       // top_ajax_form('monxin_form','submit_state','show_result');

       // return false;
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
body{ line-height:40px;}
.label{ display:inline-block; width:300px; text-align:right; padding-right:5px;}
input{ width:35%;}
</style>
<form action="./config_panel.php?act=submit" method="post" enctype="multipart/form-data" name="monxin_form" id="monxin_form" onSubmit="return exe_check();">
  <div style="text-align:center"><a href=http://www.monxin.com/index.php?monxin=talk.content&key=page_tutorial|index.payment.weixin target=_blank>配置教程</a></div>

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
  <span class="label">AppID(应用ID)</span><span class="input"><input type="text" name="appid" id="appid" value="<?php echo $config['appid'];?>"><span id=appid_state></span></span><br />
  <span class="label">AppSecret(应用密钥)</span><span class="input"><input type="text" name="appsecret" id="appsecret" value="<?php echo $config['appsecret'];?>"><span id=appsecert_state></span></span><br />  
  <span class="label">微信支付商户号</span><span class="input"><input type="text" name="mchid" id="mchid" value="<?php echo $config['mchid'];?>"><span id=mchid_state></span></span><br />
  
  <span class="label">商户支付密钥</span><span class="input"><input type="text" name="key" id="key" value="<?php echo $config['key'];?>"><span id=key_state></span></span><br />
     
  
  <span class="label">&nbsp;</span><span class="input"><input type="submit" name="button" id="button" value="提交"><span id=submit_state></span></span><br />
</form>
</body>
</html>
