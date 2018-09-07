<div id=<?php echo $module['module_name'];?> monxin-module="<?php echo $module['module_name'];?>"  align=left >
    <script>
    $(document).ready(function(){
		//$("#visitor_position a:first").css('background-image','url("xx.png")').css('padding-left',0);
		$("#visitor_position span:first").css('color','#28A03A');
		$("#visitor_position_icon").css('display','none');
        if($("#visitor_position_reset").length>0){
            $('#visitor_position').html($('#visitor_position_reset').html());
        }else if($("#visitor_position_append").length>0){
			
            $('#visitor_position').html($('#visitor_position').html()+$("#visitor_position_append").html());
			//monxin_alert( $('#visitor_position').html());

        }
		
       // $("#<?php echo $module['module_name'];?>_html #visitor_position a:last").css("background-image","url(<?php echo get_template_dir(__FILE__);?>img/user_position_last_bg.png)");
            
    });
    </script>
    


	<style>
	#<?php echo $module['module_name'];?>{ margin-bottom:20px;	}
   #<?php echo $module['module_name'];?>_html #visitor_position{ clear:both; border-bottom:2px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; width:100%; margin:auto; font-weight:bold; padding-bottom:5px; margin-top:10px;  margin-bottom:10px;margin:auto;}
   #<?php echo $module['module_name'];?>_html #visitor_position a{ display:inline-block;  line-height:2rem;  height:2rem;  font-weight:lighter; }
   #<?php echo $module['module_name'];?>_html #visitor_position a:after{ font: normal normal normal 1rem/1 FontAwesome;	margin:0 5px;	content: "\f105";}
   #<?php echo $module['module_name'];?>_html #visitor_position a:hover{ font-weight:bold;}
   #<?php echo $module['module_name'];?>_html #visitor_position_append{ padding-left:22px;}
    </style>
    <div id=<?php echo $module['module_name'];?>_html class="container">
    <div id=visitor_position><?php echo $module['list']?></div>
    <!--
    附加位置条信息
    <div style="display:none;" id="visitor_position_append">my is append</div>
    <a href="#" style="display:none;" id="visitor_position_append">my is append</a>
    重置位置条信息
    <div id="visitor_position_reset" style="display:none;"><a href="#">postion_1</a><a href="#">postion_2</a> positon_3</div>
    -->
    </div>
</div>
