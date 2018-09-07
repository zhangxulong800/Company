<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
        $("#<?php echo $module['module_name'];?> .sequence").keydown(function(event){
            return isNumeric(event.keyCode);
        });
		$("#<?php echo $module['module_name'];?>_html .data_state").each(function(index, element) {
            $(this).val($(this).attr('monxin_value'));
        });
		$(".load_js_span").each(function(index, element) {
            $(this).load($(this).attr('src'));
        });
		
		$("#<?php echo $module['module_name'];?> .reset_token").click(function(){
			id=$(this).attr('d_id');
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=reset_token',{id:id}, function(data){
                try{v=eval("("+data+")");}catch(exception){alert(data);}			
                $("#state_"+id).html(v.info);
            });
			return false;
		});
				
    });    
    function del(id){
        if(confirm("<?php echo self::$language['del_account_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        return false;	
        
    }
    
    
    </script>
    <style>
    #<?php echo $module['module_name'];?> .time{ font-size:12px; width:120px;}
    #<?php echo $module['module_name'];?> .sequence{width:40px;}
	#<?php echo $module['module_name'];?> .qr_code_img{ border:none; width:160px;}
	#<?php echo $module['module_name'];?> .m_label{ display:inline-block; padding-right:5px; text-align:right; width:100px;}
	#<?php echo $module['module_name'];?>_html .menu_a{ width:80px; height:30px; font-size:18px; }
	#<?php echo $module['module_name'];?>_html .menu_a:hover{opacity:1.0; filter:alpha(opacity=100);}
	#<?php echo $module['module_name'];?>_html .menu_a .b_start{ background-image: url(<?php echo get_template_dir(__FILE__);?>img/menu_a_icon.png); width:30px; display:inline-block; height:30px; line-height:28px;}
	#<?php echo $module['module_name'];?>_html .menu_a .b_middle{  background-image:url(img/button30_middle_bg1.png); display:inline-block;  height:30px; line-height:28px; text-align:left;}
	#<?php echo $module['module_name'];?>_html .menu_a .b_middle:hover{  text-decoration:underline;}
	#<?php echo $module['module_name'];?>_html .menu_a .b_end{ background-image:url(img/button30_end_bg1.png); display:inline-block; width:5px; height:30px; line-height:28px;}
	
	#<?php echo $module['module_name'];?>_html .auto_answer_a{ width:80px; height:30px; font-size:18px; }
	#<?php echo $module['module_name'];?>_html .auto_answer_a:hover{opacity:1.0; filter:alpha(opacity=100);}
	#<?php echo $module['module_name'];?>_html .auto_answer_a .b_start{ background-image: url(<?php echo get_template_dir(__FILE__);?>img/auto_answer_a_icon.png); width:30px; display:inline-block; height:30px; line-height:28px;}
	#<?php echo $module['module_name'];?>_html .auto_answer_a .b_middle{  background-image:url(img/button30_middle_bg1.png); display:inline-block;  height:30px; line-height:28px; text-align:left;}
	#<?php echo $module['module_name'];?>_html .auto_answer_a .b_middle:hover{  text-decoration:underline;}
	#<?php echo $module['module_name'];?>_html .auto_answer_a .b_end{ background-image:url(img/button30_end_bg1.png); display:inline-block; width:5px; height:30px; line-height:28px;}
	
	#<?php echo $module['module_name'];?>_html .user_a{ width:80px; height:30px; font-size:18px; }
	#<?php echo $module['module_name'];?>_html .user_a:hover{opacity:1.0; filter:alpha(opacity=100);}
	#<?php echo $module['module_name'];?>_html .user_a .b_start{ background-image: url(<?php echo get_template_dir(__FILE__);?>img/user_a_icon.png); width:30px; display:inline-block; height:30px; line-height:28px;}
	#<?php echo $module['module_name'];?>_html .user_a .b_middle{  background-image:url(img/button30_middle_bg1.png); display:inline-block;  height:30px; line-height:28px; text-align:left;}
	#<?php echo $module['module_name'];?>_html .user_a .b_middle:hover{  text-decoration:underline;}
	#<?php echo $module['module_name'];?>_html .user_a .b_end{ background-image:url(img/button30_end_bg1.png); display:inline-block; width:5px; height:30px; line-height:28px;}
	
	#<?php echo $module['module_name'];?>_html .dialog_a{ width:80px; height:30px; font-size:18px; }
	#<?php echo $module['module_name'];?>_html .dialog_a:hover{opacity:1.0; filter:alpha(opacity=100);}
	#<?php echo $module['module_name'];?>_html .dialog_a .b_start{ background-image: url(<?php echo get_template_dir(__FILE__);?>img/dialog_a_icon.png); width:30px; display:inline-block; height:30px; line-height:28px;}
	#<?php echo $module['module_name'];?>_html .dialog_a .b_middle{  background-image:url(img/button30_middle_bg1.png); display:inline-block;  height:30px; line-height:28px; text-align:left;}
	#<?php echo $module['module_name'];?>_html .dialog_a .b_middle:hover{  text-decoration:underline;}
	#<?php echo $module['module_name'];?>_html .dialog_a .b_end{ background-image:url(img/button30_end_bg1.png); display:inline-block; width:5px; height:30px; line-height:28px;}
	
	
    </style>
    <div id=<?php echo $module['module_name'];?>_html  monxin-table=1>
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <input type="text" name="search_filter" id="search_filter" placeholder="<?php echo self::$language['name']?>/<?php echo self::$language['weixin_account']?>/<?php echo self::$language['weixin_id']?>" value="<?php echo @$_GET['search']?>"  style="width:60%;" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> <span id="search_state"></span>
        <a href="index.php?monxin=<?php echo $module['class_name'];?>.account_add" class="add"><?php echo self::$language['add']?><?php echo self::$language['weixin_account']?></a>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['qr_code']?></td>
                <td ><?php echo self::$language['info']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td  style=" width:570px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
