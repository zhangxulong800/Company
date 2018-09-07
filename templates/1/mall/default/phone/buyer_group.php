<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
       $("#<?php echo $module['module_name'];?> .submit").click(function(){
		 id=$(this).parent().parent().attr('id');
		 if($("#"+id+" .name").val()==''){$("#"+id+" .state").html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');$("#"+id+" .name").focus();return false;}  
		 if($("#"+id+" .credits").val()==''){$("#"+id+" .state").html('<?php echo self::$language['please_input']?><?php echo self::$language['upgrade']?><?php echo self::$language['need']?><?php echo self::$language['credits']?>');$("#"+id+" .credits").focus();return false;}  
		 if($("#"+id+" .discount").val()==''){$("#"+id+" .state").html('<?php echo self::$language['please_input']?><?php echo self::$language['shopping']?><?php echo self::$language['rebate']?>');$("#"+id+" .discount").focus();return false;}  
		 
		$("#"+id+" .state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$.get('<?php echo $module['action_url'];?>&act=update',{id:id.replace('tr_',''),name:$("#"+id+" .name").val(),credits:$("#"+id+" .credits").val(),discount:$("#"+id+" .discount").val()}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			$("#"+id+" .state").html(v.info);
		});

		return false;
		}); 
    });
    
    function add(){
        nameNew=$("#name_new");	
        creditsNew=$("#credits_new");
        discountNew=$("#discount_new");
        if(nameNew.prop('value')==''){$("#state_new").html();nameNew.focus();return false;}	
        if(creditsNew.prop('value')==''){$("#state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['credits']?>');creditsNew.focus();return false;}	
        if(discountNew.prop('value')==''){$("#state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['rebate']?>');discountNew.focus();return false;}	
        $("#state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=add',{name:nameNew.prop('value'),credits:creditsNew.prop('value'),discount:discountNew.prop('value')}, function(data){
			//alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#state_new").html(v.info);
            if(v.state=='success'){
                $("#state_new").html($("#state_new").html()+'<a href="javascript:window.location.reload();" class=refresh><?php echo self::$language['refresh']?></a>');
            }
    
        });
        	
        return false;
    }
    
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			id='tr_'+id;
			$("#"+id+" .state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id.replace('tr_','')}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#"+id+" .state").html(v.info);
                if(v.state=='success'){
                $("#"+id+" td").animate({opacity:0},"slow",function(){$("#"+id).css('display','none');});
                }
            });
        }
        	
        return false;
    }
    
    </script>
    <style>
	#<?php echo $module['module_name'];?>_html{}
    
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
        <div class="portlet-title">
        	<div class="caption"><?php echo $module['monxin_table_name']?></div>
   		</div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><?php echo self::$language['name']?></td>
                <td><?php echo self::$language['auto']?><?php echo self::$language['upgrade']?><?php echo self::$language['need']?><?php echo self::$language['store']?><?php echo self::$language['credits']?></td>
                <td><?php echo self::$language['store']?><?php echo self::$language['shopping']?><?php echo self::$language['rebate']?>(<?php echo self::$language['join_goods_front'][0]?>)</td>
                <td width="30%"  style="text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
            <tr id="group_new">
                <td  id="new_td_first" style="text-align:left;">
              <input type="text" name="name_new" id="name_new" class='group_name'/></td>
              <td><input type="text" name="credits_new" id="credits_new" value="0" class='credits'  /></td>
              <td><input type="text" name="discount_new" id="discount_new" class='discount' value="10" /></td>
              <td id="new_td_last" style="text-align:left;"><a href="#" onclick="return add()"  class='add'><?php echo self::$language['add']?></a> <span id=state_new  class='group_state'></span> </td>
            </tr>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    
    </div>

</div>
