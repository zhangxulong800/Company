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
		
		
		$("#<?php echo $module['module_name'];?> .draws").click(function(){
			if(getCookie('monxin_nickname')==''){window.location.href='./index.php?monxin=index.login';}
			id=$(this).parent().parent().attr('d_id');
			$(this).css('display','none');
			$("#<?php echo $module['module_name'];?> [d_id="+id+"] .state").html('<span class=\'fa fa-spinner fa-spin\'> </span>');
			$.get('<?php echo $module['action_url'];?>&act=draws',{id:id}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> [d_id="+id+"] .state").html(v.info);
					
			});
			return false;	
		});
		
	});
    </script>
    <style>
	#<?php echo $module['module_name'];?>{} 
	#<?php echo $module['module_name'];?>_html{} 
	#<?php echo $module['module_name'];?>_html .list{ margin-top:20px;} 
	#<?php echo $module['module_name'];?>_html .list .coupon{ display:inline-block; vertical-align:top; margin-right:35px;margin-bottom:35px; height:135px; width:240px;  overflow:hidden; box-shadow:2px 2px 10px #ccc; } 
	
	
	#<?php echo $module['module_name'];?>_html .list .coupon .info{ background-color:#f00 !important; color:#FFF;padding:10px;} 
	#<?php echo $module['module_name'];?>_html .list .coupon .info .i_head{ line-height:50px;white-space:nowrap;} 
	#<?php echo $module['module_name'];?>_html .list .coupon .info .i_head .amount{ font-size:20px; display:inline-block; vertical-align:top;  width:60%; overflow:hidden; } 
	#<?php echo $module['module_name'];?>_html .list .coupon .info .i_head .amount .v{ font-size:30px; font-weight:bold;}
	#<?php echo $module['module_name'];?>_html .list .coupon .info .i_head .join_goods{ display:inline-block; vertical-align:top; width:40%; overflow:hidden; text-align:right;} 
	#<?php echo $module['module_name'];?>_html .list .coupon .info .i_body{ line-height:30px; font-size:0.8rem;} 
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
	
	#<?php echo $module['module_name'];?>_html .list .coupon .act{ text-align:center; line-height:30px; padding-top:15px; text-align:center; } 
	#<?php echo $module['module_name'];?>_html .list .coupon .act a{ display:inline-block;  width:50%; text-align:center; border-radius:10px; background-color:#F60; color:#FFF;} 

	#<?php echo $module['module_name'];?>_html .list .coupon:hover .i_body{ display:none;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
        <div class="portlet-title">
            <div class="caption"><?php echo self::$language['pages']['mall.coupon']['name']?></div>
   	    </div>

        <div class=list>
        	<?php echo $module['list'];?>            
        </div>
        
    </div>
</div>