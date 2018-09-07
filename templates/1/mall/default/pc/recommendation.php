<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){

    });
	
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>{ line-height:3rem; }
    #<?php echo $module['module_name'];?> input{ margin-left:5px; margin-right:5px; text-align:right; width:4rem; padding-right:5px;}
    #<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?>_html .remark{ display:inline-block; vertical-align:top; border-radius:15px;   line-height:40px;  padding-left:10px; padding-right:10px;}
	#<?php echo $module['module_name'];?>_html .renew{  margin:auto; display:none;}
	#<?php echo $module['module_name'];?>_html .line{ line-height:50px;}
	#<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align:top; width:12%; text-align:right; }
	#<?php echo $module['module_name'];?>_html .line .input{display:inline-block; vertical-align:top; }
	
	#<?php echo $module['module_name'];?>_html .add_deposit{ display:inline-block; vertical-align:top; margin-top:10px; margin-left:20px; border-radius:15px;   height:30px; line-height:30px; padding-left:10px; padding-right:10px;}
	#<?php echo $module['module_name'];?>_html .add_deposit:hover{  }
	#<?php echo $module['module_name'];?>_html .increase{ display:inline-block; line-height:2rem; padding:5px; border-radius:5px;  }
	#<?php echo $module['module_name'];?>_html .increase:hover{ }
	#<?php echo $module['module_name'];?>_html .increase:before{ font: normal normal normal 1rem/1 FontAwesome; content:"\f07a"; padding-right:3px;}
	#<?php echo $module['module_name'];?>_html .goods_div{ padding:10px;}
    #<?php echo $module['module_name'];?>_html .goods_div .goods{ display:inline-block; vertical-align:top; width:18%; margin-bottom:1rem; margin-right:1%; vertical-align:top; overflow:hidden; line-height:2rem; text-align:center;  padding:10px; border:4px solid #ddd;	}
    #<?php echo $module['module_name'];?>_html .goods_div .goods_a{ display:block; overflow:hidden; font-size:1rem; line-height:19px; }
    #<?php echo $module['module_name'];?>_html .goods_div .goods_a:hover img{ opacity:0.8;}
    #<?php echo $module['module_name'];?>_html .goods_div .goods_a img{  height:11.42rem; max-width:11.42rem;}
	#<?php echo $module['module_name'];?>_html .goods_div .goods_a .goods_name{ display:block; height:2.8rem; overflow:hidden; font-size:0.9rem;}
	textarea{ height:10rem; line-height:1.5rem;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
        <div class="portlet-title">
            <div class="caption"><?php echo self::$language['have_recommendation']?></div>
            <div class="actions"><a href=./index.php?monxin=mall.goods_list&recommendation=1 target="_blank" class=increase user_color=button><?php echo self::$language['buy_recommendation_goods'];?></a></div>
        </div>
		<div class=goods_div>
        	<?php echo $module['list'];?>
        </div>

    </div>
</div>

