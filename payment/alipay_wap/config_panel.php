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
		//if(!is_email(@$_POST['username'])){exit("{'state':'fail','errType':'username','errInfo':'必须是邮箱'}");}
		if(!is_numeric(@$_POST['id'])){exit("{'state':'fail','errType':'id','errInfo':'必须是数字'}");}
		if(@$_POST['key']==''){exit("{'state':'fail','errType':'key','errInfo':'不能为空'}");}
		
		$config['provider_name']=$_POST['provider_name'];
		$config['state']=$_POST['state'];
		$config['rate']=$_POST['rate'];
		$config['username']=$_POST['username'];
		$config['id']=$_POST['id'];
		$config['key']=$_POST['key'];
		$config['for']=$_POST['for'];
		if($_FILES['private_key_path']['tmp_name']!=''){
			$private_key_path=md5(time().get_verification_code(5));
			move_uploaded_file($_FILES['private_key_path']['tmp_name'],'./key/'.$private_key_path.'.pem');
			if(is_file('./key/'.$private_key_path.'.pem')){
				@unlink($config['private_key_path']);
				$config['private_key_path']='./key/'.$private_key_path.'.pem';
			}
			
		}
		
		
		
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
input{width:35%;}
</style>
<form action="./config_panel.php?act=submit" method="post" enctype="multipart/form-data" name="monxin_form" id="monxin_form" onSubmit="return exe_check();">
  <div style="text-align:center"><a href=http://www.monxin.com/index.php?monxin=talk.content&key=page_tutorial|index.payment.alipay_wap target=_blank>配置教程</a></div>

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
  <span class="label">支付宝账号</span><span class="input"><input type="text" name="username" id="username" value="<?php echo $config['username'];?>"><span id=username_state></span></span><br />
  <span class="label">合作者身份(partner ID)</span><span class="input"><input type="text" name="id" id="id" value="<?php echo $config['id'];?>"><span id=id_state></span></span><br />
  <span class="label">交易安全校验码(key)</span><span class="input"><input type="text" name="key" id="key" value="<?php echo $config['key'];?>"><span id=key_state></span></span><br />
  <span class="label">商户私钥(rsa_private_key.pem)</span><span class="input">
  <input type="file" name="private_key_path" id="private_key_path">
  <span id=rsa_private_key_state></span>  <a href=<?php echo $config['private_key_path'];?> target=_blank>查看<a></span><br />
  <span class="label">&nbsp;</span><span class="input"><input type="submit" name="button" id="button" value="提交"><span id=submit_state></span></span><br />
</form>
</body>
</html>
