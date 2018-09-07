<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
        $('#up_new_ele').insertBefore($('#up_new_state'));        
        $("#dir_input").keyup(function(event){
            keycode=event.which;
            if(keycode==13){go_dir();}	
        });
    });
  
    
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del&dir=<?php echo @$_GET['dir'];?>',{id:id}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#state_"+id).html(v.info);
                if(v.state=='success'){
				id=id.replace(/\./g,'__');
				//monxin_alert(id);
              	$("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id+" td").css('display','none');});
                }else{
					monxin_alert(v.info);	
				}
            });
        }
        	
        
    }
    function replace(id){
        monxin_alert(id);
		
    }
	
	function go_dir(){
		dir=$("#dir_input").val();
		window.location.href='./index.php?monxin=index.template_edit&dir='+dir;
			
	}
	function submit_hidden(id){
		$("#up_new_fieldset_failedList").css('display','none');
		$("#up_new_fieldset_succeedList").css('display','none');
		str=$("#"+id).val();
		//monxin_alert(str);
		$("#up_new_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.post("<?php echo $module['action_url'];?>&act=up_new&dir=<?php echo @$_GET['dir'];?>",{v:str},function(data){
            //monxin_alert(data);
                        try{v=eval("("+data+")");}catch(exception){alert(data);}
			

			$("#up_new_state").html(v.info);	
			if(v.state=='success'){monxin_alert(v.info);window.location.reload();}		
        });	
	}
    </script>
	<style>
    #<?php echo $module['module_name'];?>_html{}
        
    #<?php echo $module['module_name'];?>_table .content{width:440px;display:inline-block; margin-right:10px; overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .count{ width:40px; display:inline-block;}
    #<?php echo $module['module_name'];?>_table .time{ font-size:12px; width:250px;}
    #<?php echo $module['module_name'];?>_table .addressee{width:150px;height:40px; display:inline-block; margin-right:10px; overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .state{width:120px;}
    #<?php echo $module['module_name'];?>_table .sequence{width:30px; margin-right:20px;}
    #<?php echo $module['module_name'];?>_table .name{ text-align:left; padding-right:20px;}
    #<?php echo $module['module_name'];?>_table .size{width:150px;}
    #<?php echo $module['module_name'];?>_html .dir_link{ background-image:url(<?php echo get_template_dir(__FILE__);?>img/file_icon_dir.png); background-repeat:no-repeat; padding-left:17px; line-height:17px;}
	.dir_link a:hover{ font-weight:bold;}
	#up_div{}
	#up_new_file{ border:none;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>

    <div class="filter">
    <div class=table_scroll><table width="100%"><tr><td>
 <div class=dir_link><span class=dir>&nbsp;</span><a href='./index.php?monxin=index.template_edit&dir='>templates</a> / <?php echo $module['dir'];?></div>
    <div style="display:none;"><span><?php echo self::$language['folder'];?></span> <input id=dir_input type="text" value="<?php echo @$_GET['dir'];?>" style="width:300px;"> <a href=# onclick="return go_dir()"><?php echo self::$language['go']?></a></div> 
        </td><td align="right">
            <div id=up_div><span><?php echo self::$language['upload'];?><?php echo self::$language['file'];?></span> <span id=up_new_state></span></div>

        </td></tr></table></div>
   
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td class="name">&nbsp;<?php echo self::$language['name']?></td>
                <td ><?php echo self::$language['size'];?></td>
                <td ><?php echo self::$language['modify'];?><?php echo self::$language['time']?></td>
                <td  style=" width:470px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    </div>
</div>
