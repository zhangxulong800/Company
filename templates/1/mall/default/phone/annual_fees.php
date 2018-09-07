<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .open_annual").click(function(){
			if($("#<?php echo $module['module_name'];?> .renew").css('display')=='none'){
				$("#<?php echo $module['module_name'];?> .renew").css('display','block');
			}else{
				$("#<?php echo $module['module_name'];?> .renew").css('display','none');
			}
			
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> .year").change(function(){
			$("#<?php echo $module['module_name'];?> .cost").html($(this).val()*<?php echo $module['shop_year_fees'];?>);	
		});
		
		$("#<?php echo $module['module_name'];?>_html .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .state").html('');
			$("#<?php echo $module['module_name'];?>_html .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=renew&year='+$("#<?php echo $module['module_name'];?>_html .year").val(), function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?>_html .submit").next().html(v.info);
				
				if(v.state=='success'){
					$("#<?php echo $module['module_name'];?> .date").html(v.date);
					$("#<?php echo $module['module_name'];?> .renew").html(v.info).css('text-align','center').css('line-height','100px');		
				}
								
			});
			return false;	
		});
    });
	
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>{ }
    #<?php echo $module['module_name'];?>_html{ padding:20px;}
	#<?php echo $module['module_name'];?>_html .no_annual{ line-height:100px; height:100px; text-align:center; font-size:20px;}
	#<?php echo $module['module_name'];?>_html .no_annual .open_annual{ display:inline-block; vertical-align:top; border-radius:15px;   height:40px; line-height:40px; margin-top:30px; padding-left:10px; padding-right:10px;}
	#<?php echo $module['module_name'];?>_html .no_annual .open_annual:hover{  }
	#<?php echo $module['module_name'];?>_html .is_annual{ text-align:center; font-size:20px;}
	#<?php echo $module['module_name'];?>_html .is_annual .open_annual{ display:inline-block; vertical-align:top; border-radius:15px;   line-height:2rem; margin-top:30px; padding-left:10px; padding-right:10px;}
	#<?php echo $module['module_name'];?>_html .is_annual .open_annual:hover{  }
	#<?php echo $module['module_name'];?>_html .renew{  margin:auto; display:none;}
	#<?php echo $module['module_name'];?>_html .renew .line{ line-height:50px;}
	#<?php echo $module['module_name'];?>_html .renew .line .m_label{ display:inline-block; vertical-align:top; width:50%; text-align:right; }
	#<?php echo $module['module_name'];?>_html .renew .line .input{display:inline-block; vertical-align:top; }
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
		 <?php echo $module['info'];?>
        <div class=renew>
        	<div class=line><span class=m_label><?php echo self::$language['duration']?>：</span><span class=input><select class=year><?php echo $module['year_option'];?></select></span></div>
        	<div class=line><span class=m_label><?php echo self::$language['cost']?>：</span><span class=input><b class=cost>365</b>元</span></div>
        	
            <div class=line><span class=m_label>&nbsp;</span><span class=input><a href=# class=submit><?php echo self::$language['submit']?></a> <span class=state></span></span></div>
        </div>       
    </div>
</div>

