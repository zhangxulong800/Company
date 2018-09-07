<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
		$("#monxin_table_filter select").change(function(){
			monxin_table_filter($(this).attr('id'));	
		});
        $("#<?php echo $module['module_name'];?>_html .sequence").blur(function(){
            url='<?php echo $module['action_url'];?>&id='+this.id+"&sequence="+this.value;
            url=url.replace("sequence_","");
			$.get(url,function(data){});
        });
		        
		var state=get_param('state');
		if(state!=''){$("#state").prop('value',state);}
    });
    
    
    
    function monxin_table_filter(id){
            if($("#"+id).prop("value")!=-1){
                key=id.replace("_filter","");
                url=window.location.href;
                url=replace_get(url,key,$("#"+id).prop("value"));
                if(key!="search"){url=replace_get(url,"search","");}else{url=replace_get(url,"current_page","1");url=replace_get(url,"state","");}
                //monxin_alert(url);
                window.location.href=url;	
            }
    }
    
    function resend(id){
		$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
		
		$.get('<?php echo $module['action_url'];?>&act=resend',{id:id}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
			$("#state_"+id).html(v.info);
		});
	 	return false;	
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
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_table .content{width:440px;display:inline-block; margin-right:10px; overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .count{ width:40px; display:inline-block;}
    #<?php echo $module['module_name'];?>_table .time{ font-size:12px; width:120px;}
    #<?php echo $module['module_name'];?>_table .addressee{width:150px;height:40px; display:inline-block; margin-right:10px; overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .state{width:120px;}
    #<?php echo $module['module_name'];?>_table .sequence{width:30px; margin-right:20px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    <div class=table_scroll><table class="monxin_table_top_div" width="100%">
    	<tr>
        	<td align="left">    
			<span id=monxin_table_filter><?php echo self::$language['content_filter']?>:
    <?php echo $module['filter']?></span>
        <input type="text" name="search_filter" id="search_filter" placeholder="<?php echo self::$language['content']?>/<?php echo self::$language['addressee']?>" value="<?php echo @$_GET['search']?>" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> <span id="search_state"></span> 

            </td>
            <td align="right">
            <?php echo self::$language['sum']?>:<?php echo $module['sum_all']?> &nbsp; <?php echo self::$language['phone_msg_state'][1]?>:<?php echo $module['sum_1']?> &nbsp; <?php echo self::$language['phone_msg_state'][2]?>:<?php echo $module['sum_2']?> &nbsp; <?php echo self::$language['phone_msg_state'][3]?>:<?php echo $module['sum_3']?> &nbsp; 
            </td>
        </tr>
    </table></div>

        

    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td width="4%"><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['addressee']?></td>
                <td ><?php echo self::$language['content']?></td>
                <td ><?php echo self::$language['count']?></td>
                <td ><?php echo self::$language['time']?></td>
                <td ><?php echo self::$language['state']?></td>
                <td  style=" width:170px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
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
