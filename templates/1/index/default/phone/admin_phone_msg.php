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
		$("#available_SMS").click(function(){
			
			$("#available_SMS").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get("<?php echo $module['action_url'];?>&act=inquiry",function(data){
				
				$("#available_SMS").html(data);	
			});
			return false;	
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
        	
    }    
    </script>
	<style>
    #<?php echo $module['module_name'];?>_html{} 
    #<?php echo $module['module_name'];?>_html #available_SMS{ display:inline-block; margin-left:5px;}   
    #<?php echo $module['module_name'];?>_table .content{display:inline-block; margin-right:10px; overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .count{ width:40px; display:inline-block;}
    #<?php echo $module['module_name'];?>_table .time{ font-size:12px; width:120px;}
    #<?php echo $module['module_name'];?>_table .sender{height:40px; display:inline-block; margin-right:10px; overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .addressee{height:40px; display:inline-block; margin-right:10px; overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .state{}
    #<?php echo $module['module_name'];?>_table .sequence{width:30px; margin-right:20px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['content']?>/<?php echo self::$language['addressee']?>/<?php echo self::$language['username']?>"class="form-control" ></m_label></div></div></div>
    <table class=top_div width="100%">
    	<tr>
        	<td align="left">
			<span id=monxin_table_filter><?php echo self::$language['content_filter']?>:
    <?php echo $module['filter']?></span>
            </td>
            <td align="right">
			<?php echo self::$language['sum']?>:<?php echo $module['sum_all']?> &nbsp; <?php echo self::$language['phone_msg_state'][1]?>:<?php echo $module['sum_1']?> &nbsp; <?php echo self::$language['phone_msg_state'][2]?>:<?php echo $module['sum_2']?> &nbsp; <?php echo self::$language['phone_msg_state'][3]?>:<?php echo $module['sum_3']?> &nbsp; <?php echo self::$language['phone_msg_state'][4]?>:<?php echo $module['sum_4']?> &nbsp;
            </td>
        </tr>
    </table>
    
        

    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['sender']?></td>
                <td ><?php echo self::$language['content']?></td>
                <td ><?php echo self::$language['addressee']?></td>
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
    <?php echo $module['page']?>
    </div>
</div>
