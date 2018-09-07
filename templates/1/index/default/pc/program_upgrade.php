<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){  
        $('#up_patch_ele').insertBefore($('#up_patch_state'));
		$(".upgrade").click(function(){
			$(".upgrade").css('display','none');
			$("#upgrade_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=upgrade',function(data){
				monxin_alert(data);
				            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

				$("#upgrade_state").html(v.info);
				if(v.state=='fail'){
					$(".upgrade").css('display','inline-block');
				}else{
					monxin_alert(v.info);
					window.history.go(-1);	
				}
			});
			return false;	
		});
    });
    
	function submit_hidden(id){
		$("#up_patch_fieldset_failedList").css('display','none');
		$("#up_patch_fieldset_succeedList").css('display','none');
		str=$("#"+id).val();
		$("#up_patch_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.post("<?php echo $module['action_url'];?>&act=up_patch",{v:str},function(data){
            monxin_alert(data);
                        try{v=eval("("+data+")");}catch(exception){alert(data);}
			

			$("#up_patch_state").html(v.info);			
        });	
	}
            
    </script>
	<style>
    #<?php echo $module['module_name'];?>_html{line-height:60px;}
    #<?php echo $module['module_name'];?>_html .m_label{ display:inline-block; width:100px; text-align:right;}
    #<?php echo $module['module_name'];?>_html .input{ display:inline-block; width:800px;  padding-left:10px;}
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
	<div id='warning'><?php echo self::$language['upgrade'];?><?php echo self::$language['notice'];?>:<?php echo self::$language['in_order_to_avoid_data_loss_caused_by_accidental_please_backup_the_database_and_website_files_and_then_execute_the_operation'];?></div>
    
    <div><span class="m_label"><?php echo self::$language['step_1'];?></span><span class=input><?php echo self::$language['download_the_upgrade_patch_from_Monxin_server'];?> <a href="<?php echo $module['download_url'];?>" target="_blank"><?php echo self::$language['click'];?><?php echo self::$language['download'];?></a></span></div>
    <hr />
    <div style="line-height:20px;"><span class="m_label"><?php echo self::$language['step_2'];?></span><span class=input><?php echo self::$language['upload_patch_to_the_website'];?> <span id='up_patch_state'></span></span></div>
  <hr />
    <div><span class="m_label"><?php echo self::$language['step_3'];?></span><span class=input><a href="#" class=upgrade><?php echo self::$language['execute'];?><?php echo self::$language['upgrade'];?></a> <span id=upgrade_state></span></span></div>

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