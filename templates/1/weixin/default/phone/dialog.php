<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left save_name="<?php echo $module['module_save_name'];?>"  >
    <script src="./plugin/datePicker/index.php"></script>
	
    
    <script>
    $(document).ready(function(){
		$(".load_js_span").each(function(index, element) {
           // $(this).load($(this).attr('src'));
			$.ajax({type: "get",url:$(this).attr('src'),cache:false,async:true});
		});
		$("#<?php echo $module['module_name'];?> .answer_user").each(function(index, element) {
            if($(this).html()=='()'){$(this).parent('div').css('display','none');}
        });
		
    });
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				

                $("#state_"+id).html(v.info);
                if(v.state=='success'){
                $("#div_"+id+"").animate({opacity:0},"slow",function(){$("#div_"+id).css('display','none');});
                }
            });
        }
        return false; 	
        
    }
    
    </script>
	<style>
    #<?php echo $module['module_name'];?>{ margin:auto; margin-top:2rem;}
	#<?php echo $module['module_name'];?>_html .filter{ border-bottom:1px solid #CCC;}
    #<?php echo $module['module_name'];?>_html{  margin-left:auto; margin-right:auto;}
	#<?php echo $module['module_name'];?>_html{} .clear{ clear:both;}
	#<?php echo $module['module_name'];?>_html .left_div{ float:left;}
	#<?php echo $module['module_name'];?>_html .left_div .from_info{ margin-bottom:30px; text-align:left;}
	#<?php echo $module['module_name'];?>_html .left_div .from_info img{ height:35px; margin-bottom:-12px;}
	#<?php echo $module['module_name'];?>_html .right_div .from_info{ margin-bottom:30px; text-align:right;}
	#<?php echo $module['module_name'];?>_html .right_div .from_info img{ height:35px; margin-bottom:-12px;}
	#<?php echo $module['module_name'];?>_html .name{}
	#<?php echo $module['module_name'];?>_html .icon{ display:inline-block; height:35px;}
	#<?php echo $module['module_name'];?>_html .time:before {font: normal normal normal 18px/1 FontAwesome;margin-right: 5px;margin-left:10px;content: "\f017";}
	#<?php echo $module['module_name'];?>_html .del_dialog:before {font: normal normal normal 18px/1 FontAwesome;margin-left: 5px;content: "\f014";}
	#<?php echo $module['module_name'];?>_html .left_div .web_c{ text-align:left; padding-right:1rem;}
    #<?php echo $module['module_name'];?>_html .left_div .web_c .c{ display:inline-block; margin-bottom:-0.6rem; text-align:left; margin-top:20px; max-width:60%; padding:0.5rem; border-radius:0.5rem; background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['text']?>;}
	#<?php echo $module['module_name'];?>_html .left_div .web_c:after{font: normal normal normal 18px/1 FontAwesome;margin-right: 5px;content:"\f0d7"; color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; padding-left:1rem; display:block; }
	
	#<?php echo $module['module_name'];?>_html .right_div .web_c{ text-align:right; padding-right:1rem;}
    #<?php echo $module['module_name'];?>_html .right_div .web_c .c{ display:inline-block; margin-bottom:-0.4rem; text-align:right; margin-top:20px; max-width:60%; padding:0.5rem; border-radius:0.5rem; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
	#<?php echo $module['module_name'];?>_html .right_div  .web_c:after{font: normal normal normal 18px/1 FontAwesome;margin-right: 5px;content:"\f0d7"; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; padding-right:1rem; display:block; }


	.send_image{ max-width:90%;}
	</style>
    <div id="<?php echo $module['module_name'];?>_html" >
	
		<div class="filter">
        <?php echo self::$language['content_filter']?>:
        <input type="text" name="search_filter" id="search_filter" placeholder="<?php echo self::$language['content']?>"  value="<?php echo @$_GET['search'];?>" />
        <a href="#" onclick="return e_search();" class="search"><span class=b_start> </span><span class=b_middle><?php echo self::$language['search']?></span><span class=b_end> </span></a> <span id="search_state"></span>
        <span id=time_limit><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
        <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><span class=b_start> </span><span class=b_middle><?php echo self::$language['submit']?></span><span class=b_end> </span></a></span>
         </div>

     <?php echo $module['list']?>              
    <?php echo $module['page']?>
    </div>
</div>