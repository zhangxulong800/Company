<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
	
		$("#<?php echo $module['module_name'];?> .icon img").each(function(index, element) {
			if($(this).attr('wsrc')!='./program/ci/img/'){$(this).attr('src',$(this).attr('wsrc'));}else{$(this).attr('src','./no_picture.png');}
			if($(this).attr('wsrc')=='./program/ci/img/'){
				$(this).parent().parent().css('display','none');
				$(this).parent().parent().next().css('width','100%');
				$("#<?php echo $module['module_name'];?> .i_attribute").css('padding-left','0px');
			}
		});
		baguetteBox.run('#<?php echo $module['module_name'];?>', {
			animation: 'fadeIn',
		});		
		$(".load_js_span").each(function(index, element) {
            $(this).load($(this).attr('src'));
        });
		$.get("<?php echo $module['count_url']?>");
    });
    
        
    </script>

	<style>
    #<?php echo $module['module_name'];?>{ padding-left:10px; margin-bottom:50px;}
    #<?php echo $module['module_name'];?> div{ line-height:35px;}
    #<?php echo $module['module_name'];?> .m_label{ display:inline-block; width:12%; white-space:nowrap; text-align:right; overflow:hidden; padding-right:10px;box-shadow:none; vertical-align:middle; opacity:0.6;}
    #<?php echo $module['module_name'];?> .input_span{ display:inline-block; width:78%; overflow:hidden; vertical-align:top;}
    #<?php echo $module['module_name'];?> legend{}
    #<?php echo $module['module_name'];?> .img_thumb{ max-height:150px; margin:10px;}
	
	#<?php echo $module['module_name'];?> .i_title{padding-left:10px; font-weight:bold; font-size:20px;}
	#<?php echo $module['module_name'];?> .i_head .icon{ padding-left:10px;display:inline-block; vertical-align:top;width:20%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .i_head .icon img{ width:98%;}
	#<?php echo $module['module_name'];?> .i_head .other{ display:inline-block; vertical-align:top;width:78%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .i_head .other .line{ line-height:35px; }
	#<?php echo $module['module_name'];?> .i_head .other .line .m_label_stop{ display:inline-block; width:80px; text-align:right; overflow:hidden; padding-right:10px;}
	#<?php echo $module['module_name'];?> .i_head .other .number{ font-weight:bold;  font-size:20px; margin-right:5px;}
	#<?php echo $module['module_name'];?> .i_head .other .contact{font-weight:bold;   margin-right:5px;}
	
	#<?php echo $module['module_name'];?> .i_attribute{padding-left:20%;}
	#<?php echo $module['module_name'];?> .i_content{padding-left:10px;}
	#<?php echo $module['module_name'];?> .i_content .content_label{ border-bottom:#999 solid 1px; font-weight:bold;}
	#<?php echo $module['module_name'];?> .i_content{ padding:10px;}
	#<?php echo $module['module_name'];?> .i_content img{ max-width:100%; height:auto;}
	#<?php echo $module['module_name'];?> .contact_remark{ margin-top:10px; opacity:0.6;}
	
	
	
	
	
	
	
	
/*!
 * baguetteBox.js
 * @author  feimosi
 * @version 1.1.1
 * @url https://github.com/feimosi/baguetteBox.js
 */#baguetteBox-overlay{display:none;opacity:0;position:fixed;overflow:hidden;top:0;left:0;width:100%;height:100%;z-index:1000000;background-color:rgba(0,0,0,.8);-webkit-transition:opacity .5s ease;transition:opacity .5s ease}#baguetteBox-overlay.visible{opacity:1}#baguetteBox-overlay .full-image{display:inline-block;position:relative;width:100%;height:100%;text-align:center}#baguetteBox-overlay .full-image figure{display:inline;margin:0;height:100%}#baguetteBox-overlay .full-image img{display:inline-block;width:auto;height:auto;max-height:100%;max-width:100%;vertical-align:middle;-webkit-box-shadow:0 0 8px rgba(0,0,0,.6);-moz-box-shadow:0 0 8px rgba(0,0,0,.6);box-shadow:0 0 8px rgba(0,0,0,.6)}#baguetteBox-overlay .full-image figcaption{display:block;position:absolute;bottom:0;width:100%;text-align:center;line-height:1.8;background-color:rgba(0,0,0,.6);font-family:sans-serif}#baguetteBox-overlay .full-image:before{content:"";display:inline-block;height:50%;width:1px;margin-right:-1px}#baguetteBox-slider{position:absolute;left:0;top:0;height:100%;width:100%;white-space:nowrap;-webkit-transition:left .4s ease,-webkit-transform .4s ease;transition:left .4s ease,-moz-transform .4s ease;transition:left .4s ease,transform .4s ease}#baguetteBox-slider.bounce-from-right{-webkit-animation:bounceFromRight .4s ease-out;animation:bounceFromRight .4s ease-out}#baguetteBox-slider.bounce-from-left{-webkit-animation:bounceFromLeft .4s ease-out;animation:bounceFromLeft .4s ease-out}.baguetteBox-button#next-button,.baguetteBox-button#previous-button{top:50%;top:calc(50% - 30px);width:44px;height:60px}.baguetteBox-button{position:absolute;cursor:pointer;outline:0;padding:0;margin:0;border:0;-moz-border-radius:15%;border-radius:15%;background-color:rgba(50,50,50,.5);font:1.6em sans-serif;-webkit-transition:background-color .4s ease;transition:background-color .4s ease}.baguetteBox-button:hover{background-color:rgba(50,50,50,.9)}.baguetteBox-button#next-button{right:2%}.baguetteBox-button#previous-button{left:2%}.baguetteBox-button#close-button{top:20px;right:2%;right:calc(2% + 6px);width:30px;height:30px}.baguetteBox-button svg{position:absolute;left:0;top:0}.spinner{width:40px;height:40px;display:inline-block;position:absolute;top:50%;left:50%;margin-top:-20px;margin-left:-20px}.double-bounce1,.double-bounce2{width:100%;height:100%;-moz-border-radius:50%;border-radius:50%;opacity:.6;position:absolute;top:0;left:0;-webkit-animation:bounce 2s infinite ease-in-out;animation:bounce 2s infinite ease-in-out}.double-bounce2{-webkit-animation-delay:-1s;animation-delay:-1s}@-webkit-keyframes bounceFromRight{0%{margin-left:0}50%{margin-left:-30px}100%{margin-left:0}}@keyframes bounceFromRight{0%{margin-left:0}50%{margin-left:-30px}100%{margin-left:0}}@-webkit-keyframes bounceFromLeft{0%{margin-left:0}50%{margin-left:30px}100%{margin-left:0}}@keyframes bounceFromLeft{0%{margin-left:0}50%{margin-left:30px}100%{margin-left:0}}@-webkit-keyframes bounce{0%,100%{-webkit-transform:scale(0);transform:scale(0)}50%{-webkit-transform:scale(1);transform:scale(1)}}@keyframes bounce{0%,100%{-webkit-transform:scale(0);-moz-transform:scale(0);transform:scale(0)}50%{-webkit-transform:scale(1);-moz-transform:scale(1);transform:scale(1)}}
 
h1, h2, h3 .gallery {
    text-align: center;
}



.gallery:after {
    content: '';
    display: block;
    height: 2px;
    margin: .5em 0 1.4em;
    background: -webkit-linear-gradient(left, rgba(0, 0, 0, 0) 0%, rgba(77,77,77,1) 50%, rgba(0, 0, 0, 0) 100%);
    background: linear-gradient(to right, rgba(0, 0, 0, 0) 0%, rgba(77,77,77,1) 50%, rgba(0, 0, 0, 0) 100%);
}

.gallery img {
    height: 100%;
}

.gallery a {
    width: 240px;
    height: 180px;
    display: inline-block;
    overflow: hidden;
    margin: 4px 6px;
    box-shadow: 0 0 4px -1px #000;
}
   </style>
<script src="<?php echo get_template_dir(__FILE__);?>baguettebox.min.js"></script>
<script type="text/javascript">

</script>
    <div id="<?php echo $module['module_name'];?>_html">
    	<div class="i_title"><?php echo $module['data']['title'];?></div>
    	<div class=i_head>
        	<div class=icon><a href='./program/ci/img/<?php echo $module['data']['icon']?>'><img wsrc='./program/ci/img/<?php echo $module['data']['icon']?>' /></a></div><div class=other>
            	<div class="line"><span class=m_label><?php echo self::$language['circle']?></span><span class=input_span><span class=circle><?php echo $module['data']['circle'];?></span></span></div>
            	<?php echo $module['price'];?>
            	<div class="line price"><span class=m_label><span class=m_label_start> </span><span class=m_label_middle><?php echo self::$language['contact_2']?></span><span class=m_label_end> </span></span><span class=input_span><span class=linkman><?php echo $module['data']['linkman'];?></span> <span class=contact><?php echo $module['data']['contact'];?></span></span></div>
                <div class="line reflash"><span class=m_label><span class=m_label_start> </span><span class=m_label_middle><?php echo self::$language['time']?></span><span class=m_label_end> </span></span><span class=input_span><?php echo $module['data']['reflash'];?></span></div>
            	<div class="line visit"><span class=m_label><span class=m_label_start> </span><span class=m_label_middle><?php echo self::$language['browse']?></span><span class=m_label_end> </span></span><span class=input_span><?php echo $module['data']['visit'];?><span class=unit><?php echo self::$language['visit_unit'];?></span></span></div>
            	<div class="line visit"><span class=m_label><span class=m_label_start> </span><span class=m_label_middle><?php echo self::$language['share']?></span><span class=m_label_end> </span></span><span class=input_span>
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
