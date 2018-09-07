<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		
    });
    
    
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
		$("#<?php echo $module['module_name'];?>_html .state").html('');
        $("#<?php echo $module['module_name'];?> #submit_state").html("<span class=\'fa fa-spinner fa-spin\'></span>");
		
        top_ajax_form('monxin_form','submit_state','show_result');
		return false;
        }
        
    
    function show_result(){
        v=$("#<?php echo $module['module_name'];?> #submit_state").html();
       	alert(v);
        try{json=eval("("+v+")");}catch(exception){alert(v);}
		
		$("#<?php echo $module['module_name'];?> #submit_state").html(json.info);
		if(json.id){
			$("#<?php echo $module['module_name'];?> #submit_state").html('<span class=fail><?php echo self::$language['fail'];?></span>');
			$("#<?php echo $module['module_name'];?> #"+json.id).next('span').html(json.info);
		}
		if(json.state=='success'){
			$("#<?php echo $module['module_name'];?>_html").html('<div id=r_div>'+json.info+' <a href="./index.php?monxin=travel.line_detail&id=<?php echo @$_GET['id'];?>" class=return_button><?php echo self::$language['return'];?></a></div>');
		}
    }
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?> .line_div{ white-space:nowrap; line-height:3rem;}
    #<?php echo $module['module_name'];?> .line_div .m_label{display:inline-block; width:20%; margin-left:2%; text-align:right; vertical-align:top;}
    #<?php echo $module['module_name'];?> .line_div .input_span{ display:inline-block;width:78%; margin-left:2%;}
    #<?php echo $module['module_name'];?> .line_div .input_span input{width:100%;}
    #<?php echo $module['module_name'];?> .line_div .input_span #start_number{width:100px;}
    #<?php echo $module['module_name'];?> .line_div .input_span #add_step{width:100px;}
    #<?php echo $module['module_name'];?> .line_div .input_span #end_number{width:100px;}
    #<?php echo $module['module_name'];?> .line_div .input_span #detail_update_cycle{width:300px;}
    #<?php echo $module['module_name'];?> .line_div .input_span #list_update_cycle{width:300px;}
    #<?php echo $module['module_name'];?> .line_div .input_span #save_to{width:400px;}
    #<?php echo $module['module_name'];?> .line_div .input_span #submit{width:100px;}
	#<?php echo $module['module_name'];?> .line_div #detail_url_reg{ min-height:100px; }
    #<?php echo $module['module_name'];?> .line_div #detail_url_reg_result input{width:60px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    
    <form id="monxin_form" name="monxin_form" method="POST" action="<?php echo $module['action_url'];?>" onSubmit="return exe_check();">
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['regular_name'];?></span>
        	<span class=input_span><input type="text" id="name" name="name" /> <span class=state></span></span>
        </div>
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['list_url'];?></span>
        	<span class=input_span><input type="text" id="list_url" name="list_url" /> <span class=state></span></span>
        </div>
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['list_url'];?></span>
        	<span class=input_span>
			<?php echo self::$language['start_number'];?>:<input type="text" id="start_number" name="start_number" /> <span class=state></span> 
			<?php echo self::$language['add_step'];?>:<input type="text" id="add_step" name="add_step" /> <span class=state></span> 
			<?php echo self::$language['end_number'];?>:<input type="text" id="end_number" name="end_number" /> <span class=state></span> 
            
            </span>
        </div>
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['list_update_cycle'];?></span>
        	<span class=input_span><input type="text" id="list_update_cycle" name="list_update_cycle" /> <span class=state></span> 0=<?php echo self::$language['diy'];?></span>
        </div>
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['page_charset'];?></span>
        	<span class=input_span><input type="text" id="page_charset" name="page_charset" /> <span class=state></span></span>
        </div>
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['detail_url_reg'];?></span>
        	<span class=input_span><textarea type="text" id="detail_url_reg" name="detail_url_reg" style="width:90%;" ></textarea> <span class=state></span></span>
        </div>
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['detail_url_reg_result'];?></span>
        	<span class=input_span id=detail_url_reg_result >
            detail_url=<input type="text" id="detail_url" name="detail_url" /> <span class=state></span>   &nbsp; &nbsp;
            detail_title=<input type="text" id="detail_title" name="detail_title" /> <span class=state></span>   &nbsp; &nbsp;
            detail_icon=<input type="text" id="detail_icon" name="detail_icon" /> <span class=state></span>   &nbsp; &nbsp;
            
            </span>
        </div>

    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['detail_url_prefix'];?></span>
        	<span class=input_span><input type="text" id="detail_url_prefix" name="detail_url_prefix" /> <span class=state></span></span>
        </div>
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['detail_update_cycle'];?></span>
        	<span class=input_span><input type="text" id="detail_update_cycle" name="detail_update_cycle" /> <span class=state></span> 0=<?php echo self::$language['diy'];?></span>
        </div>
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['save_to'];?></span>
        	<span class=input_span><input type="text" id="save_to" name="save_to" /> <span class=state></span> &nbsp; &nbsp; <?php echo self::$language['save_to_demo'];?></span>
        </div>
    	<div class=line_div>
        	<span class=m_label>&nbsp;</span>
        	<span class=input_span><input type="submit" name="submit" id="submit" value="<?php echo self::$language['submit']?>" /><span id=submit_state  class=state></span></span>
        </div>
    
      
    </form>
    
    </div>
</div>

