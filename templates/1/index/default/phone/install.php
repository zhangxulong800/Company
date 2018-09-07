<script>
$(document).ready(function(){
	$('#install_label').insertBefore($('#zip_file_ele'));
});

function submit_hidden(id,cover){
	if(!arguments[1])cover='';
	v=$("#"+id).prop('value');
	v=v.substr(1);
	if(cover=='true'){$("#"+id).prop('value','');}
	$("#install_state").html("<span class='fa fa-spinner fa-spin'></span>");
	url='<?php echo $module['install_url'];?>&install='+v+"&cover="+cover;
	//monxin_alert(url);
	$("#install_state").load(url,function(){
		//monxin_alert($(this).html());
		if($(this).html().length>10){
			try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}


			$(this).html(v.info);
			if(v.state=='fail'){$(this).html('');}else{}
		}
	});
	
}
function cover_yes(){
	submit_hidden('zip','true');	
	
}
function cover_no(){
	$("#zip").prop('value','');
	$("#install_state").html('');
	
}

</script>
<div style="clear:both;">

<span id="install_label">请上传安装包(zip格式)</span>

<span id=install_state></span>
</div>