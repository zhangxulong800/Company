<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
	<link rel="stylesheet" href="./public/swipebox/index.css">
	<script src="./public/swipebox/index.js"></script>
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .icon img").each(function(index, element) {
			if($(this).attr('wsrc')!='./program/ci/img/'){$(this).attr('src',$(this).attr('wsrc'));}else{$(this).attr('src','./no_picture.png');}
			if($(this).attr('wsrc')=='./program/ci/img/'){
				$(this).parent().parent().css('display','none');
				$(this).parent().parent().next().css('width','100%');
				$("#<?php echo $module['module_name'];?> .i_title").css('margin-left','10%').css('padding-left','10px');
			}
		});
		$(".load_js_span").each(function(index, element) {
            $(this).load($(this).attr('src'));
        });
		$("#<?php echo $module['module_name'];?>_html a img").each(function(index, element) {
            $(this).parent().addClass('swipebox');
        });
		
		/* Basic Gallery */
		$("#<?php echo $module['module_name'];?>_html .swipebox" ).swipebox();
		/* Video */
		$( '.swipebox-video' ).swipebox();
		
		$.get("<?php echo $module['count_url']?>");
    });
    
        
    </script>

	<style>
    #<?php echo $module['module_name'];?>{ line-height:1.6rem; }
	#<?php echo $module['module_name'];?> .line{border-bottom:1px #F4F4F4 solid;}
    #<?php echo $module['module_name'];?> div{ margin-bottom:8px; }
    #<?php echo $module['module_name'];?> .m_label{ display:inline-block; vertical-align:top; width:25%; text-align:right; overflow:hidden; padding-right:5px;opacity:0.6;}
    #<?php echo $module['module_name'];?> .input_span{ display:inline-block;vertical-align:top;  width:74%; overflow:hidden;}
    #<?php echo $module['module_name'];?> legend{}
    #<?php echo $module['module_name'];?> .img_thumb{ max-height:300px; margin:10px;}
	
	#<?php echo $module['module_name'];?> .i_title{ font-weight:bold; padding:0.5rem;}
	#<?php echo $module['module_name'];?> .i_head .icon{ display:block;}
	#<?php echo $module['module_name'];?> .i_head .icon img{ width:98%;}
	#<?php echo $module['module_name'];?> .i_head .other{ display:block;}
	#<?php echo $module['module_name'];?> .i_head .other .line{}
	#<?php echo $module['module_name'];?> .i_head .other .number{ font-weight:bold;   margin-right:5px;}
	#<?php echo $module['module_name'];?> .i_head .other .contact{font-weight:bold;   margin-right:5px;}
	
	#<?php echo $module['module_name'];?> .i_attribute{}
	#<?php echo $module['module_name'];?> .i_attribute > div{border-bottom:1px #F4F4F4 solid;}
	#<?php echo $module['module_name'];?> .i_content{padding-left:10px;}
	#<?php echo $module['module_name'];?> .i_content .content_label{ border-bottom:#ccc solid 1px; font-weight:bold;}
	#<?php echo $module['module_name'];?> .i_content{ padding:10px;}
	#<?php echo $module['module_name'];?> fieldset{ width:95% !important; padding:5px!important;}
	#<?php echo $module['module_name'];?> fieldset img{width:93%;}
	#<?php echo $module['module_name'];?> .i_content img{ max-width:100%; height:auto;}
	#<?php echo $module['module_name'];?> .contact_remark{ margin-top:10px; opacity:0.6;}
	#<?php echo $module['module_name'];?> .m_label_end{ display:none;}
   </style>
<script type="text/javascript">

</script>
    <div id="<?php echo $module['module_name'];?>_html">
    	
    	<div class=i_head>
        	<div class=icon><a href='./program/ci/img/<?php echo $module['data']['icon']?>'><img wsrc='./program/ci/img/<?php echo $module['data']['icon']?>' /></a></div><div class=other>
            	<div class="i_title"><?php echo $module['data']['title'];?></div>
            	<div class="line"><span class=m_label><?php echo self::$language['circle']?></span><span class=input_span><span class=circle><?php echo $module['data']['circle'];?></span></span></div>
				<?php echo $module['price'];?>
            	<div class="line price"><span class=m_label><?php echo self::$language['contact_2']?></span><span class=input_span><span class=linkman><?php echo $module['data']['linkman'];?></span> <span class=contact><?php echo $module['data']['contact'];?></span></span></div>
                <div class="line reflash"><span class=m_label><?php echo self::$language['time']?></span><span class=input_span><?php echo $module['data']['reflash'];?></span></div>
            	<div class="line visit"><span class=m_label><?php echo self::$language['browse']?></span><span class=input_span><?php echo $module['data']['visit'];?><span class=unit><?php echo self::$language['visit_unit'];?></span></span></div>
            	<div class="line visit"><span class=m_label><?php echo self::$language['share']?></span><span class=input_span>
                <div class="bshare-custom icon-medium" style="padding-bottom:5px;"><div class="bsPromo bsPromo2"></div><a title="分享到微信" class="bshare-weixin" href="javascript:void(0);"></a><a title="分享到QQ好友" class="bshare-qqim" href="javascript:void(0);"></a><a title="分享到QQ空间" class="bshare-qzone"></a><a title="分享到新浪微博" class="bshare-sinaminiblog"></a><a title="分享到腾讯微博" class="bshare-qqmb"></a><a title="分享到i贴吧" class="bshare-itieba" href="javascript:void(0);"></a><a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&uuid=&pophcol=2&lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
                </span></div>
            </div>
        </div>
        <div class="i_attribute"><?php echo $module['attribute'];?></div>
        <div class="i_content">
        	<div class=content_label><?php echo $module['content_label'];?></div>
            <div class=content><?php echo $module['data']['content']?></div>
            <div class=contact_remark><?php echo $module['contact_remark']?></div>
        </div>
    </div>
</div>
