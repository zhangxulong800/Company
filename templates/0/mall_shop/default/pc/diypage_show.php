<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left style="width:100%;" >
<script>
$(document).ready(function(){
	if($("#<?php echo $module['module_name'];?> .navigate").attr('template')){
		$("#<?php echo $module['module_name'];?> .navigate").attr('href',$("#<?php echo $module['module_name'];?> .navigate").attr('template'));	
	}
	if($("#<?php echo $module['module_name'];?> #map").attr('template')){
		$("#<?php echo $module['module_name'];?> #map").attr('src',$("#<?php echo $module['module_name'];?> #map").attr('template'));	
	}
	
	$(".my_contact_info .my_wx .wx_line .wx_name").click(function(){
		if($(this).next('.wx_qr_div').css('display')=='none'){
			$(this).next('.wx_qr_div').css('display','block');
		}else{
			$(this).next('.wx_qr_div').css('display','none');
		}
		return false;
	});	

	$.get("<?php echo $module['count_url']?>");
});
</script>


<style>

#<?php echo $module['module_name'];?>{}
#<?php echo $module['module_name'];?>_html{}
#<?php echo $module['module_name'];?>_html a{ }
#<?php echo $module['module_name'];?> .title{ font-size:40px;  font-family:"SimHei"; text-align:center; height:100px; line-height:120px; border-bottom:1px solid #ccc; overflow:hidden; display:none;}
#<?php echo $module['module_name'];?> .content{  margin-top:10px; line-height:35px;}
#<?php echo $module['module_name'];?> .content img{max-width:95%;}
#<?php echo $module['module_name'];?>_html .position{ clear:both; border-bottom:2px solid #ff9600;margin:auto; font-weight:bold; padding-bottom:5px; margin-top:5px; padding-left:15px;  margin-bottom:10px;}
#<?php echo $module['module_name'];?>_html .position a{ display:inline-block;  line-height:1rem;  height:1rem; padding-right:1rem; margin-right:5px; font-weight:lighter; }
#<?php echo $module['module_name'];?>_html .position a:after{ font: normal normal normal 1rem/1 FontAwesome;	margin:0 5px;	content: "\f105";}
#<?php echo $module['module_name'];?>_html .position a:hover{ font-weight:bold;}

.my_contact_info{}
.my_contact_info .my_tel{ display:inline-block; vertical-align:top; width:33%;}
.my_contact_info .my_tel .my_head{  line-height:2.85rem; }
.my_contact_info .my_tel .my_head:before{font: normal normal normal 1.3rem/1 FontAwesome; content: "\f098";margin-right:3px; color:#ccc;} 
.my_contact_info .my_tel .my_content{ margin:10px;  font-size:1rem; font-weight:bold; line-height:40px;}
.my_contact_info .my_tel .my_content a{ }
.my_contact_info .my_qq{ display:inline-block; vertical-align:top; width:33%;}
.my_contact_info .my_qq .my_head{ line-height:2.85rem; }
.my_contact_info .my_qq .my_head:before{font: normal normal normal 1.3rem/1 FontAwesome; content: "\f1d6";margin-right:3px; color:#ccc;} 
.my_contact_info .my_qq #my_qq{ font-size:1rem;line-height:2.85rem;}
.my_contact_info .my_qq #my_qq a{ text-decoration:none;}
.my_contact_info .my_qq #my_qq a:hover{}


.my_contact_info .my_wx{ display:inline-block; vertical-align:top; width:33%;}
.my_contact_info .my_wx .my_head{ line-height:2.85rem; }
.my_contact_info .my_wx .my_head:before{font: normal normal normal 1.3rem/1 FontAwesome; content: "\f1d7";margin-right:3px; color:#ccc;} 
.my_contact_info .my_wx #my_wx{ font-size:1rem;line-height:2.85rem;}
.my_contact_info .my_wx #my_wx a{ text-decoration:none;}
.my_contact_info .my_wx #my_wx a:hover{}

.my_contact_info .my_wx .wx_line .wx_name{ cursor:pointer;}
.my_contact_info .my_wx .wx_line .wx_name:hover{ opacity:0.8;}
.my_contact_info .my_wx .wx_line .wx_name:before { font: normal normal normal 14px/1 FontAwesome;   margin-right: 7px;    content: "\f029";}
.my_contact_info .my_wx .wx_line .wx_qr_div{ display:none;}
.my_contact_info .my_wx .wx_line .wx_qr_div img{ height:100px;}


.my_contact_info .address{ margin-top:20px;}
.my_contact_info .address .my_head{ line-height:2.85rem; }
.my_contact_info .address .my_head:before{font: normal normal normal 1.3rem/1 FontAwesome; content: "\f041";margin-right:3px; color:#ccc;	} 
.my_contact_info .address .my_content{ font-size:1rem;}
.my_contact_info .address .my_content a{}

</style>


<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
<div id="show_count" style="display:none;"></div>
<div class=position><?php echo $module['position'];?></div>
<div class=title><?php echo $module['title']?></div>
<div class=content><?php echo $module['content']?></div>
</div>
</div>