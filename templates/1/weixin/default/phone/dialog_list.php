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
	#<?php echo $module['module_name'];?>_html .user_info_td{ width:100%;}
	#<?php echo $module['module_name'];?>_html .icon_name{ height:90px; display:inline-block;}
	#<?php echo $module['module_name'];?>_html .icon{ line-height:65px; height:42px; width:50px; display:inline-block;}	
	#<?php echo $module['module_name'];?>_html .icon img{ height:55px;line-height:50px; }
	#<?php echo $module['module_name'];?>_html .name{line-height:30px; display:inline-block;;}
	#<?php echo $module['module_name'];?>_html .time{ background:none;background-image:url(<?php echo get_template_dir(__FILE__);?>img/feedback_time_icon.png); background-repeat:no-repeat; height:35px; display:inline-block; width:30%; line-height:35px; padding-left:40px;}
	#<?php echo $module['module_name'];?>_html .new{/* background-image:url(<?php echo get_template_dir(__FILE__);?>img/weixin_new_massage.png); background-repeat:no-repeat;*/ height:40px; display:inline-block;  line-height:45px; font-size:25px; text-align:center; border-radius:20px; padding-left:5px; padding-right:5px; min-width:30px;}
	#<?php echo $module['module_name'];?>_html .content_td .content_table tbody tr td{ line-height:20px; border:none; background:none;}
	#<?php echo $module['module_name'];?>_html [monxin-table] tbody tr { height:auto;}
	
	/*#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_1{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_content_1.png); background-repeat:no-repeat;  width:30px; height:30px; }
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_2{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_content_2.png); background-repeat:repeat-x; height:30px; }
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_3{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_content_3.png); background-repeat:no-repeat;  width:30px; height:30px; }
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_4{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_content_4.png); background-repeat:repeat-y;  width:30px; }
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_5{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_content_5.png); background-repeat:repeat;  min-width:400px; line-height:40px; text-align:left; padding-left:10px;}

	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_6{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_content_6.png); background-repeat:repeat-y;  width:30px;}
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_7{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_content_7.png); background-repeat:no-repeat;  width:30px; height:30px; }
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_8{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_content_8.png); background-repeat:repeat-x;  height:30px; }
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_9{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_content_9.png); background-repeat:no-repeat;  width:30px; height:30px; }*/
	
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_1{ display:none;}
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_2{ display:none;}
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_3{ display:none;}
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_4{ display:none;}
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_5{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_content_5.png); background-repeat:repeat;  min-width:400px; max-width:86%; display:inline-table; line-height:40px; text-align:left; padding:40px; border-radius:10px; border:1px solid #F60; margin-left:20px;}
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_5 a{ }
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_5 .receive_image{border:2px solid #fff; max-width:100%;}
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_5 .receive_location img{border:2px solid #fff; max-width:100%;}
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_5 .receive_link{ text-decoration:underline;}
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_5 .receive_link:hover{opacity:0.8;}
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_6{ display:none;}
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_7{ display:none;}
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_8{ display:none;}
	#<?php echo $module['module_name'];?>_html #weixin_dialog_list_table tbody tr td .td_9{ display:none;}
	
	#<?php echo $module['module_name'];?>_html .edit .b_start{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_chat_icon.png); background-repeat:no-repeat; line-height:40px;}
	#<?php echo $module['module_name'];?>_html .act_td .del .b_start{background:url(<?php echo get_template_dir(__FILE__);?>img/weixin_del_icon.png); background-repeat:no-repeat; line-height:40px;}
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
		<div class="filter">
        <?php echo self::$language['content_filter']?>:
        <input type="text" name="search_filter" id="search_filter" placeholder="openid/<?php echo self::$language['content']?>"  value="<?php echo @$_GET['search'];?>" />
        <a href="#" onclick="return e_search();" class="search"><span class=b_start> </span><span class=b_middle><?php echo self::$language['search']?></span><span class=b_end> </span></a> <span id="search_state"></span>
        <span id=time_limit><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
        <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><span class=b_start> </span><span class=b_middle><?php echo self::$language['submit']?></span><span class=b_end> </span></a></span>
         </div>
    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <div class=batch_operation_div>
    			<span class="corner"> </span>
    
                <a href="#" class="select_all" onclick="return select_all();"><span class=b_start> </span><span class=b_middle><?php echo self::$language['select_all']?></span><span class=b_end> </span></a>
                <a href="#" class="reverse_select" onclick="return reverse_select();"><span class=b_start> </span><span class=b_middle><?php echo self::$language['reverse_select']?></span><span class=b_end> </span></a>
                 <?php echo self::$language['selected']?>:
                 <a href="#" class="del" onclick="return del_select();"><span class=b_start> </span><span class=b_middle><?php echo self::$language['clear']?></span><span class=b_end> </span></a> 
                  <span id="state_select"></span>
                  </div>
    <?php echo $module['page']?>
    </div>
</div>