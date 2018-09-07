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
	if(data.appid){
		$(".appid").prop('value',data.appid);	
		$(".appsecret").prop('value',data.appsecret);	
		$(".mchid").prop('value',data.mchid);	
		$(".key").prop('value',data.key);	
	}
});

function check_config_content(){
	$(".state").html('');
	state=true;
	$("input").each(function(index, element) {
        if($(this).val()==''){$(this).next('.state').html('<span class=fail>请输入</span>');$(this).focus();state=false; return false;}
    });
	return state;
}
function assemble_data(){
	data='{ "appid": "'+$(".appid").val()+'","appsecret": "'+$(".appsecret").val()+'","mchid": "'+$(".mchid").val()+'","key": "'+$(".key").val()+'" }';
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
textarea{ width:65%; height:5rem;}
</style>
        <div class=line><span class=m_label>&nbsp;</span><span class=m_input><a href=http://www.monxin.com/index.php?monxin=talk.content&key=page_tutorial|scanpay.payee.weixin target=_blank>配置教程</a></span></div>
        <div class=line><span class=m_label>AppID(应用ID):</span><span class=m_input><input type="text" class="appid"  /> <span class=state></span></span></div>
        <div class=line><span class=m_label>AppSecret(应用密钥):</span><span class=m_input><input type="text" class="appsecret" /> <span class=state></span></span></div>
        <div class=line><span class=m_label>MCHID(商户号):</span><span class=m_input><input type="text" class="mchid" /> <span class=state></span></span></div>
        <div class=line><span class=m_label>KEY(商户支付密钥):</span><span class=m_input><input type="text" class="key" /> <span class=state></span></span></div>

</body>
</html>
