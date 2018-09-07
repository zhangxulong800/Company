<?php
header('Content-Type:text/html;charset=utf-8');
ini_set('session.save_path', '../../config/session/');
session_start();
if(!@in_array("scanpay.payee",@$_SESSION['monxin']['function'])){exit('noPower');}	

?>
<!DOCTYPE html>
<head>
<meta charset="utf-8" />
<script src="../../public/jquery.js"></script>
<script src="../../public/sys_head.js"></script>
<script src="../../public/top_ajax_form.js"></script>
<script> 
$(document).ready(function(){
	parent.set_type_data_height($('body').height());
	data=parent.return_exits_data();
	if(data.app_id){
		$(".app_id").prop('value',data.app_id);	
		$(".private_key").prop('value',data.private_key.replace(/<br \/>/g,"\n"));	
		$(".public_key").prop('value',data.public_key.replace(/<br \/>/g,"\n"));	
	}
});

function check_config_content(){
	$(".state").html('');
	if($(".app_id").val()==''){$(".app_id").next('.state').html('<span class=fail>请输入</span>');$(".app_id").focus();return false;}
	if(!$.isNumeric($(".app_id").val())){$(".app_id").next('.state').html('<span class=fail>只能输入数字</span>');$(".app_id").focus();return false;}
	if($(".private_key").val()==''){$(".private_key").next('.state').html('<span class=fail>请输入</span>');$(".private_key").focus();return false;}
	return true;
}
function assemble_data(){
	data='{ "app_id": "'+$(".app_id").val()+'", "private_key": "'+$(".private_key").val()+'", "public_key": "'+$(".public_key").val()+'" }';
	return data;
}

</script>
</head>
<body>
<style>
body{ line-height:40px;}
.line{ line-height:3rem;}
.line .m_label{ display: inline-block; vertical-align:top; width:18%; padding-right:5px; text-align:right;}
.line .m_input{  display: inline-block; vertical-align:top; width:80%;}

.line .m_input input{ width:65%;}
textarea{ width:65%; height:10rem;}
</style>
        <div class=line><span class=m_label>&nbsp;</span><span class=m_input><a href=http://www.monxin.com/index.php?monxin=talk.content&key=page_tutorial|scanpay.payee.alipay target=_blank>配置教程</a></span></div>
        <div class=line><span class=m_label>APPID:</span><span class=m_input><input type="text" class="app_id"  /> <span class=state></span></span></div>
        <div class=line><span class=m_label>应用私钥:</span><span class=m_input><textarea class="private_key"></textarea> <span class=state></span></span></div>
        <div class=line><span class=m_label>支付宝公钥:</span><span class=m_input><textarea class="public_key"></textarea> <span class=state></span></span></div>

</body>
</html>
