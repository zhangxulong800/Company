<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		$( ".existing,.available" ).sortable({
		  connectWith: ".existing,.available"
		}).disableSelection();	
		
		if(get_param('id')){
			$("#group_"+get_param('id')).addClass('current');
		}else{
			$("#left_groups a:first").addClass('current');	
		}
		temp=$("#<?php echo $module['module_name'];?> .existing").attr('data').split(',');
		for(var t in temp){
			if(temp[t]){
				v=temp[t].replace('.','__');
				if(v.length>3){$(".existing").append($('.available div[m_name='+v+']'));}
			}
		}

		
        $("#<?php echo $module['module_name'];?> .add").click(function(){
			user_sum='';
			$("#<?php echo $module['module_name'];?>_html .existing div").each(function(index, element) {
                user_sum+=$(this).attr('m_name')+',';
            });
			$(this).addClass('btn disabled');
			$(this).attr('old_html',$(this).html());
			$(this).html($(this).attr('old_html')+' <i class="fa fa-spinner fa-pulse"></i> <?php echo self::$language['executing']?>');
			$.post('<?php echo $module['action_url'];?>&act=update',{user_sum:user_sum}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				 $("#<?php echo $module['module_name'];?> .add").html($("#<?php echo $module['module_name'];?> .add").attr('old_html')+' '+v.info);
				 $(this).removeClass('btn disabled');
				
			});
			return false;
        });
		
		$(".existing").height($(".available").height());
    });

    </script>
    <style>
		#<?php echo $module['module_name'];?>_html{}
		#<?php echo $module['module_name'];?>_html img{ width:30px; height:30px; }
   		#<?php echo $module['module_name'];?>_html span{ width:150px; height:30px; display:inline-block; }
        #<?php echo $module['module_name'];?>_html #left_groups{min-width:200px; _width:200px;vertical-align:text-top;}
        #<?php echo $module['module_name'];?>_html #left_groups a{ display:block; text-align:left; background-color:#F60; padding:5px; margin:5px; padding-right:0px;  color:#FFF; font-size:20px; line-height:30px; margin-right:-5px; padding-left:10px; background-position:right; background-repeat:repeat-y;}
	    #<?php echo $module['module_name'];?>_html #left_groups a:hover{ opacity:0.8;}
        #<?php echo $module['module_name'];?>_html #left_groups .current{ display:block; text-align:left; background: #EFEFEF; margin:5px; margin-right:-5px;  color:#383838; line-height:35px; padding-left:10px; font-size:20px;}
        #<?php echo $module['module_name'];?>_html #right_td{ line-height:35px; padding-left:60px; background-color:#EFEFEF; padding:20px; }
        #<?php echo $module['module_name'];?>_html #submit{ height:25px; line-height:20px;}
		input{ height:13px;}
		#right_td .existing{ display:inline-block; vertical-align:top; width:30%; min-height:500px; overflow:hidden; clear:both;}
		#right_td .available{ display:inline-block; vertical-align:top; width:60%;min-height:500px; height:100%;overflow:hidden;float: right;margin-right: 5%;}
		#<?php echo $module['module_name'];?>_html .existing_lable{ float:left; width:30%;border-bottom:#999 1px solid; line-height:40px; height:40px;white-space: nowrap; }
		#<?php echo $module['module_name'];?>_html .available_lable{ float:right;margin-right: 5%; width:50%; border-bottom:#999 1px solid; line-height:40px; height:40px; white-space:nowrap; }
		#right_td .existing_lable .add{ line-height:20px;}
		#right_td .existing_lable [old_class=add]{ float:right; line-height:20px;}
		.top_label{}
		.ui-sortable{ background-color:#FFF;}
		
		#<?php echo $module['module_name'];?>_html .b_1{cursor:move; text-align:center; width:70px; height:70px; overflow:hidden; padding:0.5rem; display:inline-block; vertical-align:top; font-weight:bold;}
		#<?php echo $module['module_name'];?>_html .b_1 img{ display:block; margin:auto; width:30px; height:30px; background:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>; border-radius:2px;}
				#<?php echo $module['module_name'];?>_html .b_1:hover img{ background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>;}
		#<?php echo $module['module_name'];?>_html .b_2{cursor:move; text-align:center; width:70px; height:70px; overflow:hidden; padding:0.5rem;	 display:inline-block; vertical-align:top; font-size:0.8rem;}
		#<?php echo $module['module_name'];?>_html .b_2 img{ display:block; margin:auto; width:30px; height:30px; background:<?php echo $_POST['monxin_user_color_set']['nv_2']['background']?>; border-radius:2px;}
				#<?php echo $module['module_name'];?>_html .b_2:hover img{ background:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>;}

		#<?php echo $module['module_name'];?>_html .li_1{ clear:both; display:none; list-style:none;}
		#<?php echo $module['module_name'];?>_html .li_2{ clear:both; list-style:none; width:100%; height:1px; line-height:1px; background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
        <div class="portlet-title" style="border-bottom: 1px solid #eee; margin-bottom:10px;">
        	<div class="caption" ><?php echo $module['monxin_table_name']?></div>
   	    </div>
        <div class=table_scroll><table cellpadding="0" cellspacing="0" width="100%"><tbody>
        <tr><td id="left_groups" width="32%" align="right" style="background-color:#FFF;">
        <?php echo $module['groups']?>
        </td><td id="right_td" valign="top">
        	<div class=top_label><span class=existing_lable><?php echo self::$language['has']?><?php echo self::$language['add']?> <a href=#   disabled="disabled"  role="button" class="add"><?php echo  self::$language['save']?></a></span><span class=available_lable><?php echo self::$language['stay']?><?php echo self::$language['add']?></span></div>
        	<div class=existing  data="<?php echo $module['existing'];?> "></div>
            <div class=available><?php echo $module['list'];?> </div>
   		
        </td></tr></tbody></table></div>
        
    
    
    </div>

</div>