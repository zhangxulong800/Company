<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){

    });
	
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>{ padding:0.5rem; }
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
    #<?php echo $module['module_name'];?>_html .goods_div .goods{ display:block line-height:2rem; text-align:center;  padding:10px; line-height:1.5rem; border-bottom:1px dashed #CCCCCC;	}
    #<?php echo $module['module_name'];?>_html .goods_div .goods .icon{ display:inline-block; vertical-align:top; width:30%; text-align:center; overflow:hidden;}	
    #<?php echo $module['module_name'];?>_html .goods_div .goods .icon img{ width:90%;}	
    #<?php echo $module['module_name'];?>_html .goods_div .goods .other{ display:inline-block; vertical-align:top; width:70%; text-align:left; overflow:hidden;}	
    #<?php echo $module['module_name'];?>_html .goods_div .goods .other textarea{ width:100%;}	
    #<?php echo $module['module_name'];?>_html .goods_div .goods .other .goods_name{ display:block; height:3.5rem;}	
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
        <div class="portlet-title">
            <div class="caption"><?php echo self::$language['have_recommendation']?></div>
            <div class="actions"><a href=./index.php?monxin=mall.goods_list&recommendation=1 target="_blank" class=increase  user_color=button><?php echo self::$language['buy_recommendation_goods'];?> <i class="fa fa-angle-double-right"></i></a></div>
        </div>
		<div class=goods_div>
        	<?php echo $module['list'];?>
        </div>

    </div>
</div>

