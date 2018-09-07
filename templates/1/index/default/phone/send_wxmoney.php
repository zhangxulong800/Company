<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script charset="utf-8" src="editor/kindeditor.js"></script>
    <script charset="utf-8" src="editor/create.php?id=content&program=<?php echo $module['class_name'];?>&language=<?php echo $module['web_language']?>"></script>
    <script>
    $(document).ready(function(){
		
        $("#<?php echo $module['module_name'];?> #submit").click(function(){
			$("#<?php echo $module['module_name'];?> .state").html('');
			is_null=false;
			obj=new Object();
			$("#<?php echo $module['module_name'];?> textarea").each(function(index, element) {
                if($(this).val()==''){$(this).next('.state').html('<span class=fail><?php echo self::$language['is_null']?></span>');is_null=true; return false;}
				obj[$(this).attr('id')]=$(this).val();
            });
			
			$("#<?php echo $module['module_name'];?> input").each(function(index, element) {
                if($(this).val()==''){$(this).next('.state').html('<span class=fail><?php echo self::$language['is_null']?></span>');is_null=true; return false;}
				obj[$(this).attr('id')]=$(this).val();
            });
			
			if(is_null){$("#submit_state").html("<span class=fail><?php echo self::$language['is_null']?></span>");return false;}
            $("#submit_state").html("<span class='fa fa-spinner fa-spin'></span>");
            $("#submit_state").load('<?php echo $module['action_url'];?>&act=submit',obj,function(){
                if($(this).html().length>10){
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}
                    $(this).html(v.info);
					if(v.state=='success'){
						$(this).html(v.info+' <a href=./index.php?monxin=index.wxpay><?php echo self::$language['view']?></a>');
					}else{
						if(v.id){
							$("#<?php echo $module['module_name'];?> #"+v.id).next('.state').html(v.info);	
						}	
					}
				}
            });
			return false;
        });
		
		
    });
    </script>
    
    
    
    
    <style>
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?> .ke-container{ border-radius:3px;}
    #<?php echo $module['module_name'];?> #title{ width:600px;}
    #<?php echo $module['module_name'];?> #content{}
	#<?php echo $module['module_name'];?> .line{  line-height:30px; height:50px;}
	#<?php echo $module['module_name'];?> .line .m_label{ display:inline-block; vertical-align: middle; width:15%; text-align:right; padding-right:10px; box-shadow:none; }
	#<?php echo $module['module_name'];?> .line .value{ display:inline-block; vertical-align: middle; width:80%;}
	#<?php echo $module['module_name'];?> .line .value input {}
	
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
    	<div class=line style="min-height:130px; overflow:auto;"><span class=m_label><?php echo self::$language['addressee'];?>(<?php echo self::$language['username'];?>)</span><span class=value>
        <textarea name="addressee" id="addressee" style=" height:90px; display:block; width:80%;"><?php echo @$_POST['data']?></textarea>  <span class=state></span>  <?php echo self::$language['addressee'];?><?php echo self::$language['separated_by_commas'];?> <a href='./index.php?monxin=index.admin_users' class="add"><?php echo self::$language['select_please'];?></a>
        
        </span></div>
    	<div class=line><span class=m_label><?php echo self::$language['sender_name'];?></span><span class=value><input type="text" value="<?php echo $module['web_name'];?>" name="sender" id="sender"  /> <span class=state></span></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['red_pack_wishing'];?></span><span class=value><input type="text" name="wishing" id="wishing" value="<?php echo self::$language['red_pack_wishing_default']?>" /></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['red_pack_min'];?></span><span class=value><input type="text" name="pack_min" id="pack_min" value=1  /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['red_pack_max'];?></span><span class=value><input type="text" name="pack_max" id="pack_max"  value="1" /> <span class=state></span></span></div>
        <div class="line"><span class=m_label></span><span class=value><a href="#" id=submit class="submit_button" user_color='button'><?php echo self::$language['submit']?></a><span id=submit_state></span></span></div>
    </div>
</div>

