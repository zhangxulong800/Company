<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left save_name="<?php echo $module['module_save_name'];?>"  >
	<script>
    $(document).ready(function(){
		$.get("<?php echo $module['count_url']?>");
    });
    </script>
    <style>
	#<?php echo $module['module_name'];?>{ padding:0px;}
	#<?php echo $module['module_name'];?>_html{ }
	#<?php echo $module['module_name'];?>_html img{max-width:90%;}
	#<?php echo $module['module_name'];?>_html .main_div{}
	#<?php echo $module['module_name'];?>_html .main_div .title{font-size:1.2rem; height:3.5rem;line-height:3.5rem; text-align:center;font-weight:bold;}
	#<?php echo $module['module_name'];?>_html .main_div .main_img{ text-align:center;margin-bottom:20px;}
	#<?php echo $module['module_name'];?>_html .main_div .main_img img{ max-height:30rem;}
	
	#<?php echo $module['module_name'];?>_html .detail_div{ margin:20px;}
	#<?php echo $module['module_name'];?>_html .detail_div .m_label{border-bottom:#009ee7 solid 2px ; font-size:20px;}
	#<?php echo $module['module_name'];?>_html .detail_div .m_label:after{font: normal normal normal 1rem/1 FontAwesome; content:"\f0da"; padding-left:3px; opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .detail_div .detail{ line-height:1.2rem;}
	#<?php echo $module['module_name'];?>_html .detail_div .detail img{width:100%;}
    </style>
    <div id=<?php echo $module['module_name'];?>_html>
    
    <div class=main_div>
    	<div class=title><?php echo $module['title']?></div>
        <div class=main_img><img src='<?php echo $v['src']?>' /></div>
    	
    </div>
    <div class=detail_div>
    	<div class=m_label><?php echo self::$language['product_description']?></div>
        <div class=detail><?php echo $module['content']?></div>
    </div>
    
    
</div>
