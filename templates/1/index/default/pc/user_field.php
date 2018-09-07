<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
        $("#<?php echo $module['module_name'];?>_html #group_"+get_param('id')).attr('class','current').css('width',$("#group_"+get_param('id')).width()+5);
        page=get_param("monxin").replace(".","_");
	   	$("#<?php echo $module['module_name'];?>_html #left_groups a:first-child").css('margin-top',0).css('padding-top',0);
	   	$("#<?php echo $module['module_name'];?>_html #left_groups a:last-child").css('margin-bottom',0).css('padding-bottom',0);
        $("#<?php echo $module['module_name'];?>_html #exe_all").click(function(){
            if($("#<?php echo $module['module_name'];?>_html #exe_all").attr('checked')){
                $("#<?php echo $module['module_name'];?>_html input[type='checkbox']").attr("checked",true);
            }else{
                $("#<?php echo $module['module_name'];?>_html input").attr("checked",false);
            }
            $("#<?php echo $module['module_name'];?>_html #exe_reverse").attr('checked',false);
        });
        
        $("#<?php echo $module['module_name'];?>_html #exe_reverse").click(function(){
             $("#<?php echo $module['module_name'];?>_html input[type='checkbox']").each(function(idx, item) {
                    $(item).attr("checked", !$(item).attr("checked"));
                })
            $("#<?php echo $module['module_name'];?>_html #exe_all").attr('checked',false);				
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
        //monxin_alert(v);
        try{json=eval("("+v+")");}catch(exception){alert(v);}
		try{eval(json.state+"_sound()");}catch(e){}

        $("#<?php echo $module['module_name'];?>_html #submit").css('display','inline-block');
        $("#<?php echo $module['module_name'];?>_html #submit_state").html(json.info);
            
    }
    </script>
    <style>
		#<?php echo $module['module_name'];?>_html{}
   		#<?php echo $module['module_name'];?>_html span{ width:150px; height:30px; display:inline-block; }
        #<?php echo $module['module_name'];?>_html #left_groups{min-width:200px; _width:200px;vertical-align:text-top;}
        #<?php echo $module['module_name'];?>_html #left_groups a{ display:block; text-align:left;  padding:5px; margin:5px; padding-right:0px;   font-size:20px; line-height:30px; margin-right:-5px; padding-left:10px; background-position:right; background-repeat:repeat-y;}
	    #<?php echo $module['module_name'];?>_html #left_groups a:hover{ }
        #<?php echo $module['module_name'];?>_html #left_groups .current{ display:block; text-align:left; background:#ccc; margin:5px; margin-right:-5px;   line-height:35px; padding-left:10px; font-size:20px;}
        #<?php echo $module['module_name'];?>_html #right_td{background:#ccc; line-height:35px; padding-left:60px; }
        #<?php echo $module['module_name'];?>_html .right_td_chrome{width:100%; }
        #<?php echo $module['module_name'];?>_html .right_td_ie{ }
        #<?php echo $module['module_name'];?>_html #submit{ height:25px; line-height:20px;}
		input{ height:13px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    <div id=login_div style="display:none;" ></div>
    
    
    
        <div class=table_scroll><table cellpadding="0" cellspacing="0" width="100%"><tbody>
        <tr><td id="left_groups" width="32%" align="right">
        <?php echo $module['groups']?>
        </td><td id="right_td" valign="top">
    <form id="monxin_form" name="monxin_form" method="POST" action="<?php echo $module['action_url'];?>" onSubmit="return exe_check();">
    <?php echo @$_GET['name']?><br />
      <?php echo $module['list']?>
     <br />
     <input type='checkbox' name='exe_all' id='exe_all' value='' /><label for='exe_all'><?php echo self::$language['select_all'];?></label>
     <input type='checkbox' name='exe_reverse' id='exe_reverse' value='' /><label for='exe_reverse'><?php echo self::$language['reverse_select'];?></label>
     <input type="submit" name="submit" id="submit" value="<?php echo self::$language['submit'];?>" /><span class=loading id=executing  style="display:none;"> </span><span id=submit_state> </span>
    </form>
        </td></tr></tbody></table></div>
    
    
    </div>

</div>