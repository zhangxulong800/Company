<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			$(this).next().html('');
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.post('<?php echo $module['action_url'];?>',{title_label:$("#<?php echo $module['module_name'];?> .title_label").val(),title_placeholder:$("#<?php echo $module['module_name'];?> .title_placeholder").val(),content_label:$("#<?php echo $module['module_name'];?> .content_label").val(),content_placeholder:$("#<?php echo $module['module_name'];?> .content_placeholder").val(),icon_label:$("#<?php echo $module['module_name'];?> .icon_label").val()}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
				
            });
			return false;	
		});
    });
    
    
    </script>
    
    <style>
	.fixed_right_div{ display:none;}
    #<?php echo $module['module_name'];?>_html{ padding:20px; padding-top:10px;}
    #<?php echo $module['module_name'];?>_html .line{ line-height:50px;}
    #<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align:top; text-align:right; padding-right:10px;  width:30%; overflow:hidden; }
    #<?php echo $module['module_name'];?>_html .line .input_span{ display:inline-block; vertical-align:top;width:65%; overflow:hidden; }
	#<?php echo $module['module_name'];?>_html .line input{ width:50%;}
	#<?php echo $module['module_name'];?>_html .line textarea{ width:50%; height:60px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	<div class=line><span class=m_label><?php echo self::$language['title'];?> <?php echo self::$language['alias'];?></span><span class=input_span><input type=text class=title_label value="<?php echo $module['title_label'];?>" placeholder="如：商品名称、小区名、职位名称..." /> </span></div>
    	<div class=line><span class=m_label><?php echo self::$language['title'];?> <?php echo self::$language['input_placeholder'];?></span><span class=input_span><input type=text class=title_placeholder value="<?php echo $module['title_placeholder'];?>" placeholder="如：如服务员3000包食宿..." /> </span></div>

    	<div class=line><span class=m_label><?php echo self::$language['detail'];?> <?php echo self::$language['alias'];?></span><span class=input_span><input type=text class=content_label value="<?php echo $module['content_label'];?>" placeholder="如：商品介绍、房源描述、任职要求 ..." /> </span></div>
    	<div class=line><span class=m_label><?php echo self::$language['detail'];?> <?php echo self::$language['input_placeholder'];?></span><span class=input_span><textarea type=text class=content_placeholder placeholder="如：岗位职则.." ><?php echo $module['content_placeholder'];?></textarea> </span></div>

    	<div class=line><span class=m_label><?php echo self::$language['icon_label'];?></span><span class=input_span><input type=text class=icon_label value="<?php echo $module['icon_label'];?>" placeholder="如：主图、相片 ..." /> </span></div>

    	<div class=line><span class=m_label>&nbsp;</span><span class=input_span><a href=# class=submit><?php echo self::$language['submit']?></a> <span></span>  </span></div>
		  
    
    </div>
</div>

