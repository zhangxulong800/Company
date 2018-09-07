<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <link rel="stylesheet" href="./plugin/bigcolorpicker/css/jquery.bigcolorpicker.css" type="text/css" />
	<script type="text/javascript" src="./plugin/bigcolorpicker/js/jquery.bigcolorpicker.js"></script>
	<script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?>_html #program").change(function(){
			url=window.location.href;
			url=replace_get(url,'program',$(this).prop("value"));
			window.location.href=url;	
		});
		$("#<?php echo $module['module_name'];?>_html #program").prop('value',get_param('program'));
		
        
        
        $(".save").click(function(){
            id=$(this).attr('href');
			file_name=$("#"+id+"_file_name").val();
			name=$("#"+id+"_name").val();
			if(file_name==''){$("#"+id+"_file_name").focus();return false;}
			if(name==''){$("#"+id+"_name").focus();return false;}
			file_name=replace_quot(file_name);
			name=replace_quot(name);
            json="{'id':'"+id+"','file_name':'"+file_name+"','name':'"+name+"'}";
            try{json=eval("("+json+")");}catch(exception){alert(json);}
            $("#"+id+"_state").html("<span class='fa fa-spinner fa-spin'></span>");
            $("#"+id+"_state").load('<?php echo $module['action_url'];?>&act=save',json,function(){
				//monxin_alert($(this).html());
                if($(this).html().length>10){
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}


                    $(this).html(v.info);
                }
            });
			return false;
        });
        $(".del").click(function(){
            id=$(this).attr('href');
            json="{'id':'"+id+"'}";
            try{json=eval("("+json+")");}catch(exception){alert(json);}
            $("#"+id+"_state").html("<span class='fa fa-spinner fa-spin'></span>");
            $("#"+id+"_state").load('<?php echo $module['action_url'];?>&act=del',json,function(){
				//monxin_alert($(this).html());
                if($(this).html().length>10){
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}
					
                    $(this).html(v.info);
                    if(v.state=='success'){
						$("#"+id).animate({opacity:0},"slow",function(){$("#"+id).css('display','none');});
						}
                }
            });
			return false;
        });
        
        $(".add").click(function(){
            id=$(this).attr('href');
			file_name=$("#"+id+"_file_name").val();
			name=$("#"+id+"_name").val();
			if(file_name==''){$("#"+id+"_file_name").focus();return false;}
			if(name==''){$("#"+id+"_name").focus();return false;}
			file_name=replace_quot(file_name);
			name=replace_quot(name);
            json="{'id':'"+id+"','file_name':'"+file_name+"','name':'"+name+"'}";
            try{json=eval("("+json+")");}catch(exception){alert(json);}
            $("#"+id+"_state").html("<span class='fa fa-spinner fa-spin'></span>");
            $("#"+id+"_state").load('<?php echo $module['action_url'];?>&act=add',json,function(){
				//monxin_alert($(this).html());
                if($(this).html().length>10){
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}


                    $(this).html(v.info);
                }
            });
			return false;
        });
        
        
            
    });
    </script>
    

	<style>
    #<?php echo $module['module_name'];?>_html{line-height:40px; padding:20px;}
	#<?php echo $module['module_name'];?>_html div{ border-bottom: 1px dashed #CCCCCC;}
	#<?php echo $module['module_name'];?>_html div span{}
    #<?php echo $module['module_name'];?>_html legend{ }
    #<?php echo $module['module_name'];?>_html .save{ font-size:16px; }
    #<?php echo $module['module_name'];?>_html .edit{ font-size:16px; }
    #<?php echo $module['module_name'];?>_html .del{ font-size:16px; }
    #<?php echo $module['module_name'];?>_html .add{ font-size:16px; }
	#<?php echo $module['module_name'];?>_html fieldset{ margin-bottom:20px;}
    #<?php echo $module['module_name'];?>_html .file_name{ text-align:right; margin-left:5px;}
	#<?php echo $module['module_name'];?>_html .file_name_span{display:inline-block; padding-left:20px;}
    #<?php echo $module['module_name'];?>_html .name{ margin-left:5px;}
	#<?php echo $module['module_name'];?>_html .name_span{display:inline-block; padding-left:20px;}
	#<?php echo $module['module_name'];?>_html input{ width:60%;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
        <div class="portlet-title" style="border-bottom: 1px solid #eee; margin-bottom:10px;">
        	<div class="caption" ><?php echo $module['monxin_table_name']?></div>
   	    </div>

   <div id=program_option><?php echo self::$language['current']?>：<select id=program name=program><option value=""><?php echo self::$language['all']?></option><option value="os_language"><?php echo self::$language['os_language']?></option><?php echo $module['program_option'];?></select></div>
    <?php echo $module['list'];?>
    </div>

</div>