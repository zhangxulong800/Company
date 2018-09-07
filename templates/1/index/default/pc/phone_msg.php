<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script src="./plugin/datePicker/index.php"></script>
    <script>
    $(document).ready(function(){
		
    });
    
    
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
        var addressee=$("#<?php echo $module['module_name'];?> #addressee");
        var content=$("#<?php echo $module['module_name'];?> #content");
        if(addressee.prop('value')==''){monxin_alert('<?php echo self::$language['please_select']?><?php echo self::$language['addressee']?>');addressee.focus();return false;}
        if(content.prop('value')==''){monxin_alert('<?php echo self::$language['please_input']?><?php echo self::$language['content']?>');}
        $("#<?php echo $module['module_name'];?> #submit_state").html("<span class='fa fa-spinner fa-spin'></span>");
        top_ajax_form('monxin_form','submit_state','show_result');
        return false;
        }
        
    
    function show_result(){
        $("#<?php echo $module['module_name'];?> #submit_state").css("display","none");
        v=$("#<?php echo $module['module_name'];?> #submit_state").html();
        //alert(v);
        try{json=eval("("+v+")");}catch(exception){alert(v);}
		

        if(json.state=='fail'){$("#<?php echo $module['module_name'];?> #submit_state").html(json.info);$("#<?php echo $module['module_name'];?> #submit_state").css("display","inline-block");}
        
            
    }
	
	function countSum(){
		v=$("#content").val();;
		$("#div_sum").html(v.length);
	}
	</script>
    
    
    
    
    <style>
    #<?php echo $module['module_name'];?>_html{ padding:20px;}
    #<?php echo $module['module_name'];?>_html #timing{ height:13px;}
    #<?php echo $module['module_name'];?> #content{ width:240px; height:180px;}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">
    <form id="monxin_form" name="monxin_form" method="POST" action="<?php echo $module['action_url'];?>" onSubmit="return exe_check();">
      <?php echo self::$language['addressee'];?>(<?php echo self::$language['phone'];?>)：<a href='./index.php?monxin=index.admin_users'><?php echo self::$language['select_please'];?></a> <br />
      <textarea name="addressee" id="addressee" style=" height:90px;width:99%;"><?php echo @$_POST['data']?></textarea>
   <?php echo self::$language['addressee'];?><?php echo self::$language['separated_by_commas'];?>
      <br /><br />
	  <?php echo self::$language['content'];?>：<br />
      
    <textarea name="content" id="content" onKeyUp='countSum()'></textarea><br />
目前字数：<b id=div_sum></b><br/>
1条短信内容为70个汉字,140个英文字符,超过会以多条短信发送.<br/><br/>
	<?php echo $module['timing'];?>
      <input type="submit" name="submit" id="submit" value="<?php echo self::$language['submit']?>" /><span id=submit_state></span>
    </form>
    </div>
</div>

