<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" monxin-module="<?php echo $module['module_name'];?>"   goods_module="<?php echo $module['module_diy']?>" align=left >
    <script>
    $(document).ready(function(){
    });
    
    </script>
    <style>
	#<?php echo $module['module_name'];?>{ width:<?php echo $module['module_width'];?>; height:<?php echo $module['module_height'];?>;display:inline-block; vertical-align:top;vertical-align:top; overflow:hidden; padding:0px !important; margin-bottom:1rem;border:1px solid #e7e7e7;   border:0px; background:none;}
	#<?php echo $module['module_name'];?>_html {}
	#<?php echo $module['module_name'];?>_html .module_title { text-align:center;  line-height:40px; font-size:1.2rem; font-weight:bold;}
#<?php echo $module['module_name'];?>_html .module_title:before{ content:"——"; font-weight:bold;  padding-right:1rem; color:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>;}
#<?php echo $module['module_name'];?>_html .module_title:after{  content:"——"; font-weight:bold;  padding-left:1rem;color:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>;}
	
	#<?php echo $module['module_name'];?>_html .module_title .name{ margin:auto; display:inline-block;}
	#<?php echo $module['module_name'];?>_html .module_title .more{ display:none;}
	#<?php echo $module['module_name'];?>_html .list{ background-color:#fff;}
	#<?php echo $module['module_name'];?>_html .list a{ display:inline-block; vertical-align:top; width:12.5%; overflow:hidden; text-align:center; border-right:4px solid <?php echo $_POST['monxin_user_color_set']['container']['background']?>;}
	#<?php echo $module['module_name'];?>_html .list a img{  height:120px; width:120px;}
	#<?php echo $module['module_name'];?>_html .list a img:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .list a span{ display:block; line-height:30px; font-size:1.1rem; display:none;}
	#<?php echo $module['module_name'];?>_html .list{}
	
	
	
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    		<div class=module_title style=" display:<?php echo $module['title_show'];?>; "><a class=name href=<?php echo $module['title_link']?>  target="<?php echo $module['target'];?>"><?php echo $module['title'];?></a><a class=more href=<?php echo $module['title_link']?> target="<?php echo $module['target'];?>"><?php echo self::$language['more'];?></a></div>

    	<div class=list><?php echo $module['list']?></div>
        
    </div>

</div>