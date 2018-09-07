<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left save_name="<?php echo $module['module_save_name'];?>"   style="width:100%;">
    <script>
    $(document).ready(function(){
        
    });
    
    
    </script>
	<style>
	#<?php echo $module['module_name'];?>{ margin:5px; padding:0px;}
	#<?php echo $module['module_name'];?> .remark{ line-height:2.14rem;}
    #<?php echo $module['module_name'];?> .thumbs_div{ line-height:1.42rem; text-align:left; }
    #<?php echo $module['module_name'];?> .thumbs_div a{ margin-bottom:3.57rem; margin-top:1.42rem; margin-left:2%; margin-right:2%;  display:inline-block; vertical-align:top;  width:<?php echo $module['sub_module_width'];?>; overflow:hidden; text-align:center;  border:1px solid #e7e7e7; }
    #<?php echo $module['module_name'];?> .thumbs_div a:hover{ border:1px solid #ddd; }
    #<?php echo $module['module_name'];?> .thumbs_div a span{ display:block; line-height:30px;}
    #<?php echo $module['module_name'];?> .thumbs_div a span .m_label{ display:inline-block;}
    #<?php echo $module['module_name'];?> .thumbs_div a .title{ display:block; font-size:1.1rem; height:2.14rem; line-height:2.14rem; display:block; overflow:hidden;}
    #<?php echo $module['module_name'];?> .thumbs_div a .time{ display:inline-block; float:left; padding-left:10px; line-height:2.85rem;}
    #<?php echo $module['module_name'];?> .thumbs_div a .time .time_symbol{display:inline-block;  display:none;}
	
	#<?php echo $module['module_name'];?> .thumbs_div a .visit{display:inline-block;font-size:0.86rem; width:30%;  line-height:2.85rem;text-align:right; float:right;}
	#<?php echo $module['module_name'];?> .thumbs_div a .visit .visit_symbol{display:inline-block; line-height:1.42rem;}
	#<?php echo $module['module_name'];?> .thumbs_div a .visit .visit_symbol:before{margin-left:5px; font: normal normal normal 1rem/1 FontAwesome; content:"\f0a6"; opacity:0.6;}
	
    #<?php echo $module['module_name'];?> .thumbs_div a .thumb_img{ vertical-align:middle;height:<?php echo $module['image_height'];?>;max-width:<?php echo $module['image_height'];?>; margin:0.5rem; margin-bottom:0px;}
    #<?php echo $module['module_name'];?> .thumbs_div a .thumb_img:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?> .thumbs_div div{}
	.page_row{ padding-left:0.5rem; padding-right:0.5rem;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
    <div class=remark><?php echo @$module['remark'];?></div>
    <div class="thumbs_div"><?php echo $module['list']?></div>
    <?php echo $module['page']?>
    </div>
</div>
