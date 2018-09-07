<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .info").each(function(index, element) {
            if(parseFloat($(this).children('.i_head').children('.amount').children('.v').html())>=5){$(this).addClass('info_5');}
            if(parseFloat($(this).children('.i_head').children('.amount').children('.v').html())>=10){$(this).addClass('info_10');}
            if(parseFloat($(this).children('.i_head').children('.amount').children('.v').html())>=20){$(this).addClass('info_20');}
            if(parseFloat($(this).children('.i_head').children('.amount').children('.v').html())>=30){$(this).addClass('info_30');}
            if(parseFloat($(this).children('.i_head').children('.amount').children('.v').html())>=50){$(this).addClass('info_50');}
            if(parseFloat($(this).children('.i_head').children('.amount').children('.v').html())>=100){$(this).addClass('info_100');}
            if(parseFloat($(this).children('.i_head').children('.amount').children('.v').html())>=500){$(this).addClass('info_500');}
            if(parseFloat($(this).children('.i_head').children('.amount').children('.v').html())>=1000){$(this).addClass('info_1000');}
        });
		
		$("#<?php echo $module['module_name'];?> .del").click(function(){
			if(confirm("<?php echo self::$language['delete_confirm']?>")){
				temp=$(this).parent().parent().attr('d_id');
				$(this).parent().parent().remove();
				$.get('<?php echo $module['action_url'];?>&act=del',{id:temp}, function(data){
					//alert(data);	
				});
			}
			return false;	
		});
	});
    </script>
    <style>
	#<?php echo $module['module_name'];?>{} 
	#<?php echo $module['module_name'];?>_html{} 
	#<?php echo $module['module_name'];?>_html .list{ margin-top:20px;} 
	#<?php echo $module['module_name'];?>_html .list .coupon{ display:inline-block; vertical-align:top;margin-bottom:2.2rem; margin-right:3%; width:22%;  overflow:hidden; box-shadow:2px 2px 10px #ccc; } 
	
	
	#<?php echo $module['module_name'];?>_html .list .coupon .info{ background-color:#f00 !important; color:#FFF;padding:10px;} 
	#<?php echo $module['module_name'];?>_html .list .coupon .info .i_head{ line-height:50px;white-space:nowrap;} 
	#<?php echo $module['module_name'];?>_html .list .coupon .info .i_head .amount{ font-size:20px; display:inline-block; vertical-align:top;  width:60%; overflow:hidden; } 
	#<?php echo $module['module_name'];?>_html .list .coupon .info .i_head .amount .v{ font-size:30px; font-weight:bold;}
	#<?php echo $module['module_name'];?>_html .list .coupon .info .i_head .join_goods{ display:inline-block; vertical-align:top; width:40%; overflow:hidden; text-align:right;} 
	#<?php echo $module['module_name'];?>_html .list .coupon .info .i_body{ font-size:0.8rem; line-height:1.4rem;} 
	#<?php echo $module['module_name'];?>_html .list .coupon .info .i_body .m_label{ color:#FFF;} 
	#<?php echo $module['module_name'];?>_html .list .coupon .info .i_body .m_value{} 
	#<?php echo $module['module_name'];?>_html .list .coupon .info .i_body .m_value a{ color:#FFF;} 
	#<?php echo $module['module_name'];?>_html .list .coupon .info .i_body .m_value a:hover{ opacity:0.8;} 
	
	
	#<?php echo $module['module_name'];?>_html .list .coupon .info_5{ background-color:#4f4fd9;}
	#<?php echo $module['module_name'];?>_html .list .coupon .info_10{ background-color:#7e07a9;}
	#<?php echo $module['module_name'];?>_html .list .coupon .info_20{ background-color:#439400;}
	#<?php echo $module['module_name'];?>_html .list .coupon .info_30{ background-color:#a68900;}
	#<?php echo $module['module_name'];?>_html .list .coupon .info_50{ background-color:#ff8700;}
	#<?php echo $module['module_name'];?>_html .list .coupon .info_100{ background-color:#ff6c00;}
	#<?php echo $module['module_name'];?>_html .list .coupon .info_500{ background-color:#009999;}
	#<?php echo $module['module_name'];?>_html .list .coupon .info_1000{ background-color:#9c02a7;}
	
	#<?php echo $module['module_name'];?>_html .list .coupon .goods{ background-color: #f7f7f7; text-align:center;padding:10px;} 
	#<?php echo $module['module_name'];?>_html .list .coupon .goods a{ display:inline-block; vertical-align:top; width:30%; overflow:hidden; margin-right:3%;} 
	#<?php echo $module['module_name'];?>_html .list .coupon .goods a:last-child{ margin-right:0px;}
	#<?php echo $module['module_name'];?>_html .list .coupon .goods a:hover{ opacity:0.8;} 
	#<?php echo $module['module_name'];?>_html .list .coupon .goods a img{ width:100%;} 
	#<?php echo $module['module_name'];?>_html .list .coupon .goods a span{ text-align:center; color:#9f9f9f;} 
	
	#<?php echo $module['module_name'];?>_html .list .coupon .act{ text-align:center; line-height:30px;} 
	#<?php echo $module['module_name'];?>_html .list .coupon .act a{ display:inline-block; vertical-align:top; width:50px; text-align:center;color:#9f9f9f;} 
	#<?php echo $module['module_name'];?>_html .list .coupon .act .go_shop{} 
	#<?php echo $module['module_name'];?>_html .list .coupon .act .go_shop:before {font: normal normal normal 16px/1 FontAwesome;content: "\f064";}
	#<?php echo $module['module_name'];?>_html .list .coupon .act .del{} 
	#<?php echo $module['module_name'];?>_html .list .coupon .act .del:before {font: normal normal normal 18px/1 FontAwesome;content: "\f014";}

    </style>
    <div id="<?php echo $module['module_name'];?>_html">
        <div class="portlet-title">
            <div class="caption"><?php echo self::$language['pages']['mall.coupon_usable']['name']?></div>
   	    </div>

        <div class=list>
        	<?php echo $module['list'];?>            
        </div>
        
    </div>
</div>