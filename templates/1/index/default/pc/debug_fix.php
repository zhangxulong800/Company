<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
		$("#monxin_table_filter select").change(function(){
			monxin_table_filter($(this).attr('id'));	
		});
		var state=get_param('state');
		if(state!=''){$("#state").prop('value',state);}
    });
    
    
    
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
			
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        	
        return false;
    }
	function exe_set_1(id){
		$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
		
		$.get('<?php echo $module['action_url'];?>&act=set_1',{id:id}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
			$("#state_"+id).html(v.info);
		});
		
	}
	
    function set_1(id){
		if($("#set_1_"+id).html()=='<?php echo self::$language['force_fix'];?>'){
			if(confirm("<?php echo self::$language['force_fix_confirm']?>")){
				exe_set_1(id);
			}
		}else{
			exe_set_1(id);
		}
        return false;
    }
    
	function e_inquiry(){
		$("#<?php echo $module['module_name'];?> #inquiry_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
		
		$.get('<?php echo $module['action_url'];?>&act=inquiry',function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
			$("#inquiry_state").html(v.info+'<a href="javascript:window.location.reload();" class=refresh><?php echo self::$language['refresh']?></a>');			
		});
		return false;
	}
    
	function e_batch_fix(){
		$("#<?php echo $module['module_name'];?> #batch_fix_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
		
		$.get('<?php echo $module['action_url'];?>&act=batch_fix',function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
			$("#batch_fix_state").html(v.info+'<a href="javascript:window.location.reload();" class=refresh><?php echo self::$language['refresh']?></a>');			
		});
		return false;
	}
    
    
    
    
    function del_select(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
        idss=ids;
        ids=ids.split("|");	
        for(id in ids){
            if(ids[id]!=''){$("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');}	
        }
            $.get('<?php echo $module['action_url'];?>&act=del_select',{ids:idss}, function(data){
				//monxin_alert(data);
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#state_select").html(v.info);
                if(v.state=='success'){
                //monxin_alert(ids);	
                success=v.ids.split("|");
                for(id in ids){
                   //monxin_alert(ids[id]);
                    if(in_array(ids[id],success)){
                        $("#state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
                        $("#tr_"+ids[id]).css('display','none');
                    }else{
                        $("#state_"+ids[id]).html("<?php echo self::$language['fail'];?>");	
                    }	
                }
                }
            });
        }	
        return false;	
    }    
    </script>
	<style>
    #<?php echo $module['module_name'];?>_html{ padding-top:10px;}
    #<?php echo $module['module_name'];?>_html .detail{ display:block; width:500px; overflow:hidden;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>  
        <div class="portlet-title" style="border-bottom: 1px solid #eee; margin-bottom:10px;">
        	<div class="caption" ><?php echo $module['monxin_table_name']?></div>
   	    </div>

    <div class=table_scroll><table class="monxin_table_top_div" width="100%">
    	<tr>
        	<td align="left">    
			<span id=monxin_table_filter><?php echo self::$language['content_filter']?>:
    <?php echo $module['filter']?></span>
        <input type="text" name="search_filter" id="search_filter" placeholder="<?php echo self::$language['file_path']?>" value="<?php echo @$_GET['search']?>" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> <span id="search_state"></span> 
        &nbsp;  &nbsp; 
         <a href="#" onclick="return e_inquiry();" class="inquiry"><?php echo self::$language['inquiry_debug']?></a> <span id="inquiry_state"></span> 
         &nbsp; &nbsp; 
         <a href="#" onclick="return e_batch_fix();" class="inquiry"><?php echo self::$language['batch_fix']?></a> <span id="batch_fix_state"></span> 

            </td>
            <td align="right">&nbsp;</td>
        </tr>
    </table></div>
    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td width="4%"><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['file_path']?></td>
                <td ><?php echo self::$language['state']?></td>
                <td ><?php echo self::$language['fixer']?></td>
                <td ><?php echo self::$language['time']?></td>
                <td  style=" width:300px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <div class=batch_operation_div>
    			<span class="corner">&nbsp;</span>
    
                <a href="#" class="select_all" onclick="return select_all();"><?php echo self::$language['select_all']?></a>
                <a href="#" class="reverse_select" onclick="return reverse_select();"><?php echo self::$language['reverse_select']?></a>
                 <?php echo self::$language['selected']?>:
                 <a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a> 
                  <span id="state_select"></span>
                  </div>
    <?php echo $module['page']?>
    </div>
</div>
