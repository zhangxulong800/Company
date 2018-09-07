<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> select").each(function(index, element) {
            if($(this).attr('monxin_monxin')!=''){
				$(this).prop('value',$(this).attr('monxin_monxin'));
			}
        });
		
    });
  
	
    
    </script>
	<style>
	.fixed_right_div{ display:none !important;}
	#<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{ } 
    #<?php echo $module['module_name'];?>_html .line{ line-height:2rem;white-space:nowrap;} 
    #<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align: top; width:20%; text-align:right; padding-right:10px; box-shadow:none;} 
    #<?php echo $module['module_name'];?>_html .line .value{ display:inline-block; vertical-align:top; width:80%;  vertical-align:top; white-space: normal;} 
    #<?php echo $module['module_name'];?>_html .line .value input{ width:300px;} 
    #<?php echo $module['module_name'];?>_html {} 
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
       <div class="portlet-title">
            <div class="caption"><?php echo $module['data']['g_title'];?></div>
   	    </div>
  
    	<div class=line><span class=m_label><?php echo self::$language['goods_price'];?>：</span><span class=value><?php echo $module['data']['goods_price'];?> <span class=state></span></span></div>
       
    	<div class=line><span class=m_label><?php echo self::$language['final_price'];?>：</span><span class=value><?php echo $module['data']['final_price'];?></span></div>
        
        
    	<div class=line><span class=m_label><?php echo self::$language['invitation'];?>：</span><span class=value><?php echo $module['data']['invitation'];?></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['min_money'];?>：</span><span class=value><?php echo $module['data']['min_money'];?></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['max_money'];?>：</span><span class=value><?php echo $module['data']['max_money'];?></span></div>
        
        
        
        <div class=line><span class=m_label><?php echo self::$language['bargain_quantity'];?>：</span><span class=value><span class=bargain_quantity><?php echo $module['data']['quantity'];?></span></span></div>
        
        
        
    	<div class=line><span class=m_label><?php echo self::$language['method_name'];?>：</span><span class=value><?php echo $module['data']['method'];?></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['bargain_type'];?>：</span><span class=value><?php echo $module['data']['type'];?></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['new_name'];?>：</span><span class=value><?php echo $module['data']['new'];?></span></div>
                
        
        
        
        
    	<div class=line><span class=m_label><?php echo self::$language['limit_hour'];?>：</span><span class=value><?php echo $module['data']['hour'];?></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['start_time'];?>：</span><span class=value><?php echo $module['data']['start_time'];?></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['end_time'];?>：</span><span class=value><?php echo $module['data']['end_time'];?></span></div>
        
    </div>
</div>
