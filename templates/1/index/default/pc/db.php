<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
        $('#upfile_ele').insertBefore($('#upfile_state'));
        $('#upfile_ele').css('display','inline-block');
    });

	function submit_hidden(id){
		$('#'+id+'_state').html('');
		$("#"+id+"_fieldset_failedList").css('display','none');
		$("#"+id+"_fieldset_succeedList").css('display','none');
		
        obj=document.getElementById(id);
		if(obj.value!=''){
			$('#'+id+'_state').html("<span class=success><?php echo self::$language['success'];?></span> <a class=refresh href='javascript:window.location.reload();'><?php echo self::$language['refresh'];?></a>");
			//monxin_alert('<?php echo self::$language['success'];?>');	
			//window.location.reload();
		}
        
	}

    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
				//monxin_alert(data);
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#state_"+id).html(v.info);
					
                 if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        return false;	
        
    }

    function recover(id){
		if(confirm("<?php echo self::$language['confirm']?><?php echo self::$language['recover']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=recover',{id:id}, function(data){
				monxin_alert(data);
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#state_"+id).html(v.info);
            });
		}
        	
        return false;	
    }

    function e_backup(){
		$("#act_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$.get('<?php echo $module['action_url'];?>&act=backup', function(data){
			//monxin_alert(data);
			            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

			$("#act_state").html(v.info+"<a class=refresh href='javascript:window.location.reload();'><?php echo self::$language['refresh'];?></a>");
		});
		return false;		
    }
    function e_repair(){
		$("#act_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$.get('<?php echo $module['action_url'];?>&act=repair', function(data){
			//monxin_alert(data);
			            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

			$("#act_state").html(v.info);
		});
		return false;		
    }
    function e_optimize(){
		$("#act_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$.get('<?php echo $module['action_url'];?>&act=optimize', function(data){
			//monxin_alert(data);
			            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

			$("#act_state").html(v.info);
		});
		return false;		
    }

    </script>
    
    <style>
    #<?php echo $module['module_name'];?>_html{line-height:40px;}
    #<?php echo $module['module_name'];?>_html .name{ text-align:left;}
    #<?php echo $module['module_name'];?>_html #upfile_ele input{  }
	.filter #up_div {line-height:0;}
	#upfile_file{ border:none;}
	#upfile_up_info {line-height:18px;}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
        <div class="portlet-title">
        	<div class="caption" ><?php echo $module['monxin_table_name']?></div>
		</div>

    <div class=table_scroll><table class="filter" style="width:100%;">
    	<tr>
        	<td align="left">
            <div>
        <a href=# class=backup onclick="return e_backup();"><?php echo self::$language['backup']?><?php echo self::$language['database']?></a>
        <a href=# class=optimize onclick="return e_optimize();"><?php echo self::$language['optimize']?><?php echo self::$language['database']?></a>
        <a href=# class=repair onclick="return e_repair();"><?php echo self::$language['repair']?><?php echo self::$language['database']?></a> <span id=act_state></span></div>
        	</td>
            <td align="right";>
            <div id=up_div style="text-align:right;" ><?php echo self::$language['upload'];?><?php echo self::$language['backup'];?><?php echo self::$language['file'];?> <span id=upfile_state></span></div>
        	</td>
        </tr>
    </table></div>
    	
        
        
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td style="text-align:left; padding-left:10px;"> <?php echo self::$language['backup']?><?php echo self::$language['file'];?></td>
                <td ><?php echo self::$language['size'];?></td>
                <td ><?php echo self::$language['time'];?></td>
                <td style="text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    </div>
</div>

