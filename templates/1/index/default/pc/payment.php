<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script src="./plugin/datePicker/index.php"></script>
    <script>
    $(document).ready(function(){
        $("#submit_offline").click(function(){
            json="{'offline':'"+$("#offline").val()+"'}";
            try{json=eval("("+json+")");}catch(exception){alert(json);}

            $("#submit_state").html("<span class=\'fa fa-spinner fa-spin\'></span>");
            $("#submit_state").load('',json,function(){
                if($(this).html().length>10){
					
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}


                    $(this).html(v.info);
                    if(v.state=='fail'){$(this).html('');}else{}
                }
            });
			return false;
        });


    });	
	
	
   function exe_check(){
        //表单输入值检测... 如果非法则返回 false
        $("#submit_state").html("<span class=\'fa fa-spinner fa-spin\'></span>");
        top_ajax_form('monxin_form','submit_state','show_result');
 		return false;
        
        }
        
    
    function show_result(){
        v=$("#submit_state").html();
        try{json=eval("("+v+")");}catch(exception){alert(v);}
		
       	$("#submit_state").html(json.info);
    }
	
	</script>
    
    
    
    
    <style>
    #<?php echo $module['module_name'];?>_html{ padding-top:10px; }
    #<?php echo $module['module_name'];?> #content{ width:240px; height:180px;}
	#offline{ width:800px; height:80px;}
	#offline_div{width:900px; padding:10px; border:1px #ccc solid;}
	#online_div{width:900px; padding:10px; border:1px #ccc solid; border-radius:3px;}
	#online_div a{  margin:10px; display:inline-block; width:180px; height:100px; overflow:hidden;}
	#online_div img{display:block; border:0px; width:135px;}
	#<?php echo $module['module_name'];?>_html tr td{ padding-bottom:20px;}
	#<?php echo $module['module_name'];?>_html tr > td:first-child{ padding-right:5px;}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">
    
    <table cellpadding="10" cellspacing="1">
    <tr><td width="10%" align="right"><?php echo self::$language['offline_payment']?></td>
    <td width="90%">
    <div id=offline_div>
    <form name="monxin_form" id="monxin_form" method="POST" action="<?php echo $module['action_url'];?>&act=offline" onsubmit="">
<textarea id="offline" name="offline"><?php echo $module['offline'];?></textarea>
<br/><br/><span class=m_label><?php echo self::$language['pay_info'];?><?php echo self::$language['template'];?></span> <input type="text" id='pay_info' name='pay_info' value="<?php echo $module['pay_info'];?>" style="width:670px;"><br /><br />
<span class=m_label><?php echo self::$language['whether_to_open'];?></span><select id="offline_state" name="offline_state">
<option value="opening" <?php echo $module['opening'];?> ><?php echo self::$language['yes']?></option>
<option value="closed" <?php echo $module['closed'];?> ><?php echo self::$language['no']?></option>
</select>
   <a href="#" onclick="return exe_check();" class=submit><span class=b_start> </span><span class=b_middle><?php echo self::$language['submit']?></span><span class=b_end> </span></a> <span id=submit_state></span></form>
    
    </div>
    </td></tr>
    <tr><td align="right" valign="top"><br/><?php echo self::$language['online_payment']?></td>
    <td>
    <div id=online_div><?php echo $module['online']?></div>
    </td></tr>
    </table>
    
    
    </div>
</div>

