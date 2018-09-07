<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){		
        
        $("input").blur(function(){
            	
            json="{'"+this.id+"':'"+replace_quot(this.value)+"'}";
            try{json=eval("("+json+")");}catch(exception){alert(json);}
            $("#"+this.id+"_state").html("<span class='fa fa-spinner fa-spin'></span>");
            $("#"+this.id+"_state").load('<?php echo $module['action_url'];?>&update='+this.id,json,function(){
                if($(this).html().length>10){
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}


                    $(this).html(v.info);
                    if(v.state=='fail'){$(this).html('');}else{}
                }
            });
        });
            
    });
    </script>
    

	<style>
    #<?php echo $module['module_name'];?>_html{line-height:40px;}
    #<?php echo $module['module_name'];?>_html .return{ height:35px;}
    #<?php echo $module['module_name'];?>_html legend{ }
	#<?php echo $module['module_name'];?>_html fieldset{ margin-bottom:20px; }
    #<?php echo $module['module_name'];?>_html .input_text{width:400px;}
    #<?php echo $module['module_name'];?>_html div{ }
    #<?php echo $module['module_name'];?>_html .m_label{width:60%; display:inline-block;  text-align:right;white-space: normal;}
    #<?php echo $module['module_name'];?>_html .content{ display:inline-block; width:38%; padding-left:10px;}
    #<?php echo $module['module_name'];?>_html .content input{width:80%;}
	#<?php echo $module['module_name'];?>_table .odd{ }
	#<?php echo $module['module_name'];?>_table .even{ }
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
        <div class="portlet-title" style="border-bottom: 1px solid #eee; margin-bottom:10px;">
        	<div class="caption" ><?php echo $module['monxin_table_name']?></div>
   	    </div>
    <div class="return" style="display:none;"><a href="javascript:history.go(-1);" class="return_button"><?php echo self::$language['return']?></a></div>
    <?php echo $module['list'];?>
    <div class="return"><a href="javascript:history.go(-1);" class="return_button"><?php echo self::$language['return']?></a></div>
    </div>

</div>