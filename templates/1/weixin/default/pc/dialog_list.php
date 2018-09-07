<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./plugin/datePicker/index.php"></script>
    
    
    <script>
    $(document).ready(function(){
		$("[monxin-table] tr").removeClass('even');
		$("[monxin-table] tr").removeClass('odd');
        $("#<?php echo $module['module_name'];?> .data_state").each(function(index, element) {
            if($(this).prop('value')==1){$(this).prop('checked',true);}
        });
        $("#<?php echo $module['module_name'];?> .data_state").click(function(){
            id=this.id;
            id=id.replace("data_state_","");
            if($(this).prop('checked')){state=1;}else{state=0;}
            $.get('<?php echo $module['action_url'];?>&act=update_state',{id:id,state:state});
		});
    });
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
				////alert(data);
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
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#state_select").html(v.info);
                if(v.state=='success'){
                //monxin_//alert(ids);	
                success=v.ids.split("|");
                for(id in ids){
                    //monxin_//alert(ids[id]);
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
    #<?php echo $module['module_name'];?>_table .name{}
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td{ border-left:none; padding:0px;}
	#<?php echo $module['module_name'];?>_html .user_info_td{ width:100px;}
	#<?php echo $module['module_name'];?>_html .icon_name{text-align:right; height:90px;}
	#<?php echo $module['module_name'];?>_html .icon{ line-height:65px; height:30px; width:30px; display:inline-block;}	
	#<?php echo $module['module_name'];?>_html .icon img{ height:28px;line-height:30px; }
	#<?php echo $module['module_name'];?>_html .name{line-height:30px; display:inline-block;;}
	#<?php echo $module['module_name'];?>_html .time{ background:none;background-image:url(<?php echo get_template_dir(__FILE__);?>img/feedback_time_icon.png); background-size:18px 18px; background-repeat:no-repeat; height:30px; display:block; width:115px; line-height:18px;text-align:right;}
	#<?php echo $module['module_name'];?>_html .new{ /*background-image:url(<?php echo get_template_dir(__FILE__);?>img/weixin_new_massage.png); background-repeat:no-repeat; padding-left:15px;*/height:30px; display:inline-block; line-height:30px; font-size:18px;  border-radius:20px; padding-left:5px; padding-right:5px;}
	#<?php echo $module['module_name'];?>_html .content_td .content_table tbody tr td{ line-height:20px; border:none; background:none;}
	#<?php echo $module['module_name'];?>_html [monxin-table] tbody tr { height:auto;}
	
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_1{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_content_1.png); background-repeat:no-repeat;  width:30px; height:30px; }
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_2{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_content_2.png); background-repeat:repeat-x; height:30px; }
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_3{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_content_3.png); background-repeat:no-repeat;  width:30px; height:30px; }
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_4{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_content_4.png); background-repeat:repeat-y;  width:30px; }
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_5{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_content_5.png); background-repeat:repeat;  min-width:400px; max-width:900px; display:inline-table; line-height:40px; text-align:left; padding-left:10px;}
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_5 a{ }
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_5 .receive_image{border:2px solid #fff; max-width:100%;}
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_5 .receive_location img{border:2px solid #fff; max-width:100%;}
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_5 .receive_link{ text-decoration:underline;}
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_5 .receive_link:hover{opacity:0.8;}
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_6{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_content_6.png); background-repeat:repeat-y;  width:30px;}
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_7{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_content_7.png); background-repeat:no-repeat;  width:30px; height:30px; }
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_8{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_content_8.png); background-repeat:repeat-x;  height:30px; }
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_9{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_content_9.png); background-repeat:no-repeat;  width:30px; height:30px; }
	#<?php echo $module['module_name'];?>_html .edit .b_start{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_chat_icon.png); background-repeat:no-repeat; background-size:25px 25px;}
	#<?php echo $module['module_name'];?>_html .act_td .del .b_start{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_del_icon.png); background-repeat:no-repeat; background-size:25px 25px;}
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['clear']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"   placeholder="openid/<?php echo self::$language['content']?>" class="form-control" ></m_label></div></div></div>
    
    
		<div class="filter" >
        <span id=time_limit style="margin-bottom:20px;"><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
        <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><span class=b_start> </span><span class=b_middle><?php echo self::$language['submit']?></span><span class=b_end> </span></a></span>
         </div>
    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td><?php echo self::$language['content'];?></td>
                <td><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>