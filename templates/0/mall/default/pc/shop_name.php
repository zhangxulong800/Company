<div id=<?php echo $module['module_name'];?>   monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
         if('<?php echo $module['shop_master']?>'==1){$(".edit_mall_layout_button").css('display','block');}
		 $("#<?php echo $module['module_name'];?> .shop_qr .qr_img_div").css('top', ($("#<?php echo $module['module_name'];?> .shop_qr").offset().top+ $("#<?php echo $module['module_name'];?> .shop_qr").height()-43));
		 
		$("#<?php echo $module['module_name'];?> .satisfaction").each(function(index, element) {
            v=Math.ceil(parseFloat($(this).attr('value'))/10);
			$(this).addClass('satisfaction_'+v);
        });
		 
		 
    });
    </script>
    

    <style>
	#<?php echo $module['module_name'];?>{display:inline-block; width:370px; height:8rem; padding-top:1rem; margin-left:10px; overflow:hidden; box-shadow: none ;padding-right: 0;}
	#<?php echo $module['module_name'];?>_html{ height:130px; vertical-align:top; }
	#<?php echo $module['module_name'];?>_html .name{/* margin-top:20px;*/ line-height:2rem;  font-size:1.5rem; font-weight:bold;}
    #<?php echo $module['module_name'];?>_html .shop_info{ display:inline-block; vertical-align:top;  overflow:hidden; padding-right:30px;}
 #<?php echo $module['module_name'];?>_html .shop_info a{margin-right:10px;}
    #<?php echo $module['module_name'];?>_html .shop_qr{display:inline-block; vertical-align:top; width:70px; height:100px; overflow:hidden; /*background:url(<?php echo get_template_dir(__FILE__);?>img/shop_qr_bg_hide.png) no-repeat 50% 50%;*/}
	#<?php echo $module['module_name'];?>_html .shop_qr:hover{}
	#<?php echo $module['module_name'];?>_html .shop_qr:hover .qr_img_div{ display:block;}
    #<?php echo $module['module_name'];?>_html .shop_qr .shop_qr_switch{ padding-top:12px; color:#999;  }
	#<?php echo $module['module_name'];?>_html .shop_qr .shop_qr_switch:after{ display:block;font: normal normal normal 28px/1 FontAwesome; content: "\F029";margin-left: 2px; }
	#<?php echo $module['module_name'];?>_html .shop_qr .shop_qr_switch:hover{}
	#<?php echo $module['module_name'];?>_html .shop_qr .qr_img_div{ z-index:9999; position: absolute; display:none;  border:#CCC 2px solid; width:160px; height:160px;}
	#<?php echo $module['module_name'];?>_html .shop_qr .qr_img_div img{width:100%;}
	#<?php echo $module['module_name'];?>_html .deposit_satisfaction{ line-height:20px !important;  }
	#<?php echo $module['module_name'];?>_html .m_label{ font-size:1rem; box-shadow:none; color:#666;}
	#<?php echo $module['module_name'];?>_html .value{ font-size:18px; font-family:Georgia; color:red;}
	#<?php echo $module['module_name'];?>_html .deposit{   }
	#<?php echo $module['module_name'];?>_html .satisfaction{ font-size:0.8rem;}
	#<?php echo $module['module_name'];?>_html .draws_coupon{ display:inline-block; font-weight:normal;  }
	#<?php echo $module['module_name'];?>_html .draws_coupon img{ height:1.4rem;}
	#<?php echo $module['module_name'];?>_html .draws_coupon:hover{ opacity:0.5;}
	#<?php echo $module['module_name'];?>_html .talk:before{font: normal normal normal 1.2rem/1 FontAwesome; content:"\f0e6"; }
   #<?php echo $module['module_name'];?>_html .talk:hover{ color:red;}
   #<?php echo $module['module_name'];?>_html .deposit{ font-size:0.8rem;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	<div class=shop_info>
        	<div class=name><?php echo $module['name']?>  <?php echo $module['coupon']?></div>
        	<div class=deposit_satisfaction>
            	<div class=satisfaction  value="<?php echo $module['satisfaction']?>"></div></div>
            	<div class=deposit><?php echo $module['credits_rate'];?></div>
            <?php echo $module['talk'];?>
        </div><div class=shop_qr>
        	<div class="shop_qr_switch"><?php echo self::$language['mobile_shop']?></div>
           
            <div class=qr_img_div><img src="./program/mall/shop_qr/<?php echo $module['shop_id']?>.png" /></div>
        </div>
    </div>
</div>