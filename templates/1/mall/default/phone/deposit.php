<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .add_deposit").click(function(){
			if($("#<?php echo $module['module_name'];?> .renew").css('display')=='none'){
				$("#<?php echo $module['module_name'];?> .renew").css('display','block');
			}else{
				$("#<?php echo $module['module_name'];?> .renew").css('display','none');
			}		
			return false;
		});
		$("#<?php echo $module['module_name'];?>_html .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .state").html('');
			$("#<?php echo $module['module_name'];?>_html .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=add_deposit&money='+$("#<?php echo $module['module_name'];?>_html .money").val(), function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?>_html .submit").next().html(v.info);
				
				if(v.state=='success'){
					$("#<?php echo $module['module_name'];?> .deposit").html(parseFloat($("#<?php echo $module['module_name'];?>_html .money").val())+parseFloat($("#<?php echo $module['module_name'];?> .deposit").html()));
					$("#<?php echo $module['module_name'];?> .renew").html(v.info).css('text-align','center').css('line-height','100px');		
				}
								
			});
			return false;	
		});
    });
	
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>{ }
    #<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?>_html .remark{ display:inline-block; vertical-align:top; border-radius:15px;   line-height:40px;  padding-left:10px; padding-right:10px;}
	#<?php echo $module['module_name'];?>_html .renew{  margin:auto; display:none;}
	#<?php echo $module['module_name'];?>_html .line{ line-height:50px;}
	#<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align:top; width:32%; text-align:right; }
	#<?php echo $module['module_name'];?>_html .line .input{display:inline-block; vertical-align:top; }
	
	#<?php echo $module['module_name'];?>_html .add_deposit{ display:inline-block; vertical-align:top; margin-top:10px; margin-left:20px; border-radius:15px;   height:30px; line-height:30px; padding-left:10px; padding-right:10px;}
	#<?php echo $module['module_name'];?>_html .add_deposit:hover{  }
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
		 <div class="alert alert-success" role="alert"><?php echo self::$language['deposit_remark'];?><br /><?php echo self::$language['min_deposit']?>: <?php echo $module['min_deposit']?> <?php echo self::$language['yuan']?></div>
        <div class=line style="margin-top:20px;"><span class=m_label><?php echo self::$language['paid_deposit']?>：</span><span class=input><b class=deposit><?php echo $module['deposit'];?></b> <?php echo self::$language['yuan']?> <a href=# class="add_deposit"  user_color=button><?php echo self::$language['add_deposit']?></a></span></div>
        <div class=renew>
        	<div class=line><span class=m_label><?php echo self::$language['money']?>：</span><span class=input><input type=text class=money /> <?php echo self::$language['yuan']?> </span></div>
        	
            <div class=line><span class=m_label>&nbsp;</span><span class=input><a href=# class=submit><?php echo self::$language['agreement_and_payment']?></a> <span class=state></span></span></div>
        </div>       
    </div>
</div>

