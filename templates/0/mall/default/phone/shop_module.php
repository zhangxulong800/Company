<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" monxin-module="<?php echo $module['module_name'];?>"   goods_module="<?php echo $module['module_diy']?>" align=left >
    <script>
    $(document).ready(function(){
    });
    
    </script>
    <style>
	#<?php echo $module['module_name'];?>{ width:<?php echo $module['module_width'];?>; height:<?php echo $module['module_height'];?>;display:inline-block; vertical-align:top;vertical-align:top; overflow:hidden; padding:0px !important; margin-bottom:1rem;border:1px solid #e7e7e7;   border:0px; background:none;}
	#<?php echo $module['module_name'];?>_html { }
	#<?php echo $module['module_name'];?>_html .module_title { text-align:center;  line-height:40px; font-size:1.2rem; font-weight:bold;}
#<?php echo $module['module_name'];?>_html .module_title:before{ content:"——"; font-weight:bold;  padding-right:1rem; color:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>;}
#<?php echo $module['module_name'];?>_html .module_title:after{  content:"——"; font-weight:bold;  padding-left:1rem;color:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>;}
	#<?php echo $module['module_name'];?>_html .module_title .more{ display:none;}
	#<?php echo $module['module_name'];?>_html .list_out{overflow-x:scroll; background-color:#fff;}
	#<?php echo $module['module_name'];?>_html .list{ white-space:nowrap;}
	#<?php echo $module['module_name'];?>_html .list a{ display:inline-block; vertical-align:top; width:25%; overflow:hidden; text-align:center; border:1px solid #F0F0F0; border-left:none; border-top:none;}
	#<?php echo $module['module_name'];?>_html .list a:nth-child(1){border:1px solid #F0F0F0;}
	#<?php echo $module['module_name'];?>_html .list a:nth-child(2){border-top:1px solid #F0F0F0;}
	#<?php echo $module['module_name'];?>_html .list a:nth-child(3){border-top:1px solid #F0F0F0;}
	#<?php echo $module['module_name'];?>_html .list a:nth-child(4){border-top:1px solid #F0F0F0;}
	#<?php echo $module['module_name'];?>_html .list a:nth-child(5){border-left:1px solid #F0F0F0;}
	#<?php echo $module['module_name'];?>_html .list a img{ width:80px; height:80px;}
	#<?php echo $module['module_name'];?>_html .list a img:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .list a span{ display:block; line-height:30px; font-size:0.9rem;}
	#<?php echo $module['module_name'];?>_html .list{}
	
	
	
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    	<div class=module_title style=" display:<?php echo $module['title_show'];?>; "><a class=name href=<?php echo $module['title_link']?>  target="<?php echo $module['target'];?>"><?php echo $module['title'];?></a><a class=more href=<?php echo $module['title_link']?> target="<?php echo $module['target'];?>"><?php echo self::$language['more'];?></a></div>

    	<div class=list_out><div class=list><?php echo $module['list']?></div></div>
        
    </div>

</div>