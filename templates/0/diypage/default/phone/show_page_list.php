<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left save_name="<?php echo $module['module_save_name'];?>"  style="width:100%;" >
    <script>
    $(document).ready(function(){
        $("#<?php echo $module['module_name'];?> .page_list_div a:odd").attr('class','odd');
        $("#<?php echo $module['module_name'];?> .page_list_div a:even").attr('class','even');
        
    });
    
    
    </script>
	<style>
	#<?php echo $module['module_name'];?>{ margin:5px; padding:0px;}
	#<?php echo $module['module_name'];?>_html{  border:1px solid #e7e7e7;}
    #<?php echo $module['module_name'];?> .page_list_div{ text-align:left;}
    #<?php echo $module['module_name'];?> .page_list_div a{  line-height:3rem; display:inline-block;width:<?php echo $module['sub_module_width'];?>; overflow:hidden; text-align:left;  border-bottom:1px solid #e7e7e7;}
    #<?php echo $module['module_name'];?> .page_list_div a:hover{ border-bottom:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?> 1px solid;}
    #<?php echo $module['module_name'];?> .page_list_div .odd{ background:#fff;}
    #<?php echo $module['module_name'];?> .page_list_div .even{ background:#f9f9f9;}
    #<?php echo $module['module_name'];?> .page_list_div span{ padding-left:10px; display:inline-block;}
    #<?php echo $module['module_name'];?> .page_list_div .title{ width:50%; text-align:left;}
    #<?php echo $module['module_name'];?> .page_list_div .time{ width:20%; text-align:center; }
    #<?php echo $module['module_name'];?> .page_list_div .visit{  width:20%; text-align:center;  }
    #<?php echo $module['module_name'];?> .page_list_div .list_head{ line-height:3rem;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;	}
	.page_row{ padding-left:0.5rem; padding-right:0.5rem;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
    <div class="page_list_div"><?php echo $module['list']?></div>
    <?php echo $module['page']?>
    </div>
</div>
