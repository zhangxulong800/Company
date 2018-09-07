<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left style="width:100%;" save_name="<?php echo $module['module_save_name'];?>" >
<script>
$(document).ready(function(){
		$("#<?php echo $module['module_name'];?> #submit").click(function(){
			$("#<?php echo $module['module_name'];?> input[type='checkbox']").each(function(index, element) {
                if($(this).prop('checked')){$(this).val(1);}else{$(this).val(0);}
            });
			
			$(this).next('span').html('<span class=\'fa fa-spinner fa-spin\'></span>');
			
			$.post('<?php echo $module['action_url'];?>&act=update', { admin_phone_msg:$("#admin_phone_msg").val(),admin_phone_account:$("#admin_phone_account").val(),admin_email_account:$("#admin_email_account").val(),admin_email_msg:$("#admin_email_msg").val(),phone_msg:$("#phone_msg").val(),email_msg:$("#email_msg").val()},function(data){
				//alert(data);	
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> #submit").next('span').html(v.info);
			});	
		});
		
	

});
</script>
    

<style>
    #<?php echo $module['module_name'];?>_html{ padding:10px;}
    #<?php echo $module['module_name'];?>_html #admin_phone_msg{ height:13px;}
    #<?php echo $module['module_name'];?>_html #admin_email_msg{ height:13px;}
    #<?php echo $module['module_name'];?>_html #phone_msg{ height:13px;}
    #<?php echo $module['module_name'];?>_html #email_msg{ height:13px;}
    #<?php echo $module['module_name'];?>_html div{ line-height:60px;}
    #<?php echo $module['module_name'];?> .m_label{ display:inline-block; width:150px; text-align:right; padding-right:10px;}
</style>


<div id="<?php echo $module['module_name'];?>_html">
      <div>
      <span class=m_label><?php echo self::$language['message_alert'];?>:</span><span class=input_span>
      <input type="checkbox" name="admin_phone_msg" id="admin_phone_msg" <?php echo $module['admin_phone_msg'];?> /><?php echo self::$language['phone_msg'];?> <input type="text" placeholder="<?php echo self::$language['mobile_number'];?>" name="admin_phone_account" id="admin_phone_account" value="<?php echo $module['alert']['admin_phone_account'];?>" /> &nbsp; &nbsp;
      <input type="checkbox" name="admin_email_msg" id="admin_email_msg" <?php echo $module['admin_email_msg'];?> /><?php echo self::$language['email_msg'];?>  <input type="text" placeholder="<?php echo self::$language['email'];?>" name="admin_email_account" id="admin_email_account"  value="<?php echo $module['alert']['admin_email_account'];?>" /></span>
      </div>
      <div><span class=m_label><?php echo self::$language['reply_alert'];?>:</span><span class=input_span><input type="checkbox" name="phone_msg" id="phone_msg" <?php echo $module['phone_msg'];?> /><?php echo self::$language['phone_msg'];?> <input type="checkbox" name="email_msg" id="email_msg"  <?php echo $module['email_msg'];?> /><?php echo self::$language['email_msg'];?> </span></div>
   	  <div><span class="m_label">&nbsp;</span><span class=input_span>
      		<a href="#" id=submit class="submit"><?php echo self::$language['submit'];?></a> <span></span>
      </span></div> 

</div>
</div>