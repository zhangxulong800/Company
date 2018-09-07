<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){  
        $('#up_template_ele').insertBefore($('#up_template_state'));
    });
    
	function submit_hidden(id){
		$("#up_template_fieldset_failedList").css('display','none');
		$("#up_template_fieldset_succeedList").css('display','none');
		str=$("#"+id).val();
		$("#up_template_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.post("<?php echo $module['action_url'];?>&act=up_template",{v:str},function(data){
            monxin_alert(data);
                        try{v=eval("("+data+")");}catch(exception){alert(data);}
			

			$("#up_template_state").html(v.info);
			if(v.state=='success'){
				monxin_alert(v.info);
				window.history.go(-1);	
			}
						
        });	
	}
            
    </script>
	<style>
    #<?php echo $module['module_name'];?>_html{line-height:60px;}
    #<?php echo $module['module_name'];?>_html .m_label{ display:inline-block; width:100px; text-align:right;}
    #<?php echo $module['module_name'];?>_html .input{ display:inline-block; width:800px;  padding-left:10px;}
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
	<div id='warning'><?php echo self::$language['upgrade'];?><?php echo self::$language['notice'];?>:<?php echo self::$language['the_new_version_will_overwrite_the_current_version_of_the_file'];?></div>
    
    <div><span class="m_label"><?php echo self::$language['step_1'];?></span><span class=input><?php echo self::$language['download_the_compatible_template_from_Monxin_server'];?> <a href="<?php echo $module['download_url'];?>" target="_blank"><?php echo self::$language['click'];?><?php echo self::$language['download'];?></a></span></div>
    <hr />
    <div style="line-height:20px;"><span class="m_label"><?php echo self::$language['step_2'];?></span><span class=input><?php echo self::$language['upload_compatible_template_to_the_website'];?> <span id='up_template_state'></span></span></div>

    </div>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
</div>