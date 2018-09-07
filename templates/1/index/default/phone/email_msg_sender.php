<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
        $("#<?php echo $module['module_name'];?>_html .sequence").blur(function(){
            url='<?php echo $module['action_url'];?>&id='+this.id+"&sequence="+this.value;
            url=url.replace("sequence_","");
			id=this.id
			
			$("#"+id).css('display','none');
			$("#"+id+"_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');	
			$.get(url,function(data){
				
				$("#"+id+"_state").html('<span class=success>&nbsp;</span>');	
			});
        });
		
        $("#<?php echo $module['module_name'];?>_html .exe_send").click(function(){
            url='<?php echo $module['action_url'];?>&id='+this.id+"&act=exe_send";
            url=url.replace("exe_send_","");
			id=this.id
			
			$.get(url,function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#"+id).css('display','none');
                $("#"+id+"_state").html(v.info);
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
    #<?php echo $module['module_name'];?>_table .title{display:inline-block; overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .time{ font-size:12px; width:120px;}
    #<?php echo $module['module_name'];?>_table .addressee{display:inline-block; overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .state{}
    #<?php echo $module['module_name'];?>_table .sequence{width:30px; margin-right:20px;}
    #<?php echo $module['module_name'];?> #index_email_msg_sender_table a:hover{  text-decoration:underline;}
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
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search" placeholder="<?php echo self::$language['title']?>/<?php echo self::$language['content']?>/<?php echo self::$language['addressee']?>"  class="form-control" ></m_label></div></div></div>
    <div class="filter"><?php echo self::$language['content_filter']?>:
     <?php echo $module['filter']?>
 &nbsp;  <a href="index.php?monxin=index.robot&act=email&second=65" target="_blank" class="open"><?php echo self::$language['open_email_robot']?></a> 
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td width="4%"><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['addressee']?></td>
                <td ><?php echo self::$language['title']?></td>
                <td ><?php echo self::$language['time']?></td>
                <td ><?php echo self::$language['state']?></td>
                <td ><?php echo self::$language['priority']?></td>
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
