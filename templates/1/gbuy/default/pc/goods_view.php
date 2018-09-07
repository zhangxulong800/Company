<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script src="./plugin/datePicker/index.php"></script>
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> select").each(function(index, element) {
            if($(this).attr('monxin_value')!=''){
				$(this).prop('value',$(this).attr('monxin_value'));
			}
        });
		
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .state").html('');
			obj=new Object();
			is_null=false;
			$("#<?php echo $module['module_name'];?> input").each(function(index, element) {
                if($(this).val()==''){
					$("#<?php echo $module['module_name'];?> #"+$(this).attr('id')).focus();
					$("#<?php echo $module['module_name'];?> #"+$(this).attr('id')).next().html('<span class=fail><?php echo self::$language['is_null'];?></span>');	
					$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=fail><?php echo self::$language['fail'];?></span>');
					is_null=true;
					return false;
				}
				obj[$(this).attr('id')]=$(this).val();
				
            });
			if(is_null){return false;}
			
			$(this).css('display','none');
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=set',obj, function(data){
				
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				if(v.id){
					$("#<?php echo $module['module_name'];?> #"+v.id).focus();
					$("#<?php echo $module['module_name'];?> #"+v.id).next().html(v.info);	
					$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=fail><?php echo self::$language['fail'];?></span>');
				}else{
					$("#<?php echo $module['module_name'];?> .submit").next().html(v.info+' <a href=./index.php?monxin=gbuy.shop_goods><?php echo self::$language['return']?></a>');
				}
				if(v.state=='success'){
					
						
				}else{
					$("#<?php echo $module['module_name'];?> .submit").css('display','inline-block');
				}
				
			});
			
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> input").change(function(){
			update_quantity();
		});
		
		update_quantity();
    });
	
	function update_quantity(){
		p=(parseFloat($("#<?php echo $module['module_name'];?> #min_money").val())+parseFloat($("#<?php echo $module['module_name'];?> #max_money").val()))/2;
		v=(<?php echo $module['data']['goods_price'];?>-parseFloat($("#<?php echo $module['module_name'];?> #final_price").val()))/p;
		v=parseInt(v);
		$("#<?php echo $module['module_name'];?> .gbuy_quantity").html(v);
		
	}
	
    
    </script>
	<style>
	.fixed_right_div{ display:none !important;}
	#<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{ } 
    #<?php echo $module['module_name'];?>_html .line{ line-height:50px;white-space:nowrap;} 
    #<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align: top; width:40%; text-align:right; padding-right:10px; box-shadow:none;} 
    #<?php echo $module['module_name'];?>_html .line .value{ display:inline-block; vertical-align:top; width:60%;  vertical-align:top; white-space: normal;} 
    #<?php echo $module['module_name'];?>_html .line .value input{ width:300px;} 
    #<?php echo $module['module_name'];?>_html {} 
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
       <div class="portlet-title">
            <div class="caption"><?php echo $module['monxin_table_name']?></div>
   	    </div>
  
    	<div class=line><span class=m_label><?php echo self::$language['goods_name'];?>：</span><span class=value><?php echo $module['data']['g_title'];?> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['goods_price'];?>：</span><span class=value><?php echo $module['data']['goods_price'];?> <span class=state></span></span></div>
       
    	<div class=line><span class=m_label><?php echo self::$language['g_price'];?>：</span><span class=value><?php echo $module['data']['price'];?></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['g_number'];?>：</span><span class=value><?php echo $module['data']['number'];?></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['limit_hour'];?>：</span><span class=value><?php echo $module['data']['hour'];?></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['g_earn'];?>：</span><span class=value><?php echo $module['data']['earn'];?></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['start_time'];?>：</span><span class=value><?php echo $module['data']['start_time'];?></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['end_time'];?>：</span><span class=value><?php echo $module['data']['end_time'];?></span></div>
        

        
    </div>
</div>
