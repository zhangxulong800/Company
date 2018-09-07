<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			return false;
		});
		
		$("#<?php echo $module['module_name'];?>_html span a").click(function(){	
			set_iframe_position($(window).width()-100,$(window).height()-200);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','./index.php?monxin=mall.express_price&id='+$(this).attr('href'));
			return false;	
		});
		$("#<?php echo $module['module_name'];?>_html input").change(function(){
			  if($(this).prop("checked")){
				  $(this).next().next().css('display','inline-block');	
			  }else{
				  $(this).next().next().css('display','none');
			  }
		});
		$("#<?php echo $module['module_name'];?>_html input").each(function(index, element) {
            if($(this).prop('checked')){$(this).next().next().css('display','inline-block');}
        });
		
        $("#<?php echo $module['module_name'];?>_html #exe_all").click(function(){
            if($("#<?php echo $module['module_name'];?>_html #exe_all").prop('checked')){
                $("#<?php echo $module['module_name'];?>_html input[type='checkbox']").prop("checked",true);
				$("#<?php echo $module['module_name'];?>_html a").css('display','inline-block');
            }else{
                $("#<?php echo $module['module_name'];?>_html input").prop("checked",false);
				$("#<?php echo $module['module_name'];?>_html a").css('display','none');
            }
            $("#<?php echo $module['module_name'];?>_html #exe_reverse").prop('checked',false);
        });
        
        $("#<?php echo $module['module_name'];?>_html #exe_reverse").click(function(){
             $("#<?php echo $module['module_name'];?>_html input[type='checkbox']").each(function(idx, item) {
                    $(item).prop("checked", !$(item).prop("checked"));
					if($(item).prop("checked")){
						$(item).next().next().css('display','inline-block');	
					}else{
						$(item).next().next().css('display','none');
					}
                })
            $("#<?php echo $module['module_name'];?>_html #exe_all").prop('checked',false);				
        });
    });
    
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
        $("#<?php echo $module['module_name'];?>_html #submit_state").html('');
        $("#<?php echo $module['module_name'];?>_html #submit").css('display','none');
        $("#<?php echo $module['module_name'];?>_html #executing").css('display','inline-block');	
        top_ajax_form('monxin_form','login_div','show_result');
        return false;
        }
        
    function show_result(){
        $("#<?php echo $module['module_name'];?>_html #executing").css('display','none');
        v=$("#<?php echo $module['module_name'];?>_html #login_div").html();
        //alert(v);
        try{json=eval("("+v+")");}catch(exception){alert(v);}
		

        $("#<?php echo $module['module_name'];?>_html #submit").css('display','inline-block');
        $("#<?php echo $module['module_name'];?>_html #submit_state").html(json.info);
            
    }
    </script>
    <style>
		#<?php echo $module['module_name'];?>_html{ margin:0.5rem; background:#fff; }
   		#<?php echo $module['module_name'];?>_html span{ width:300px; height:30px; display:inline-block; vertical-align:top; }
   		#<?php echo $module['module_name'];?>_html span a{ margin-left:6px;  font-size:1rem; display:none;}
		#<?php echo $module['module_name'];?>_html input{ height:13px;}
		#<?php echo $module['module_name'];?>_html #submit{ height:30px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    <div id=login_div style="display:none;" ></div>
    
    
    <form id="monxin_form" name="monxin_form" method="POST" action="<?php echo $module['action_url'];?>" onSubmit="return exe_check();">
    <?php echo @$_GET['name']?><br />
      <?php echo $module['list']?>
     <br /> <br />
     <input type='checkbox' name='exe_all' id='exe_all' value='' /><m_label for='exe_all'><?php echo self::$language['select_all'];?></m_label>
     <input type='checkbox' name='exe_reverse' id='exe_reverse' value='' /><m_label for='exe_reverse'><?php echo self::$language['reverse_select'];?></m_label>
     <input type="submit" name="submit" id="submit" value="<?php echo self::$language['submit'];?>" /><span class=loading id=executing  style="display:none;"> </span><span id=submit_state> </span>
    </form>
    
    
    </div>

</div>