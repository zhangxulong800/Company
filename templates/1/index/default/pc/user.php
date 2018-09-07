<div id=<?php echo $module['module_name'];?>   monxin-module="<?php echo $module['module_name'];?>" align=left >
<div class=newest_user_msg style="display:none;"><?php echo $module['msg'];?></div>
    <script>
    $(document).ready(function(){
		if($(".quick_button").html()<10){$(".quick_button").css('display','none');}
    });	
	
	</script>
    

<style>
#<?php echo $module['module_name'];?>{ width:99.7%;}
.quick_button{ background:#fff; border-radius:3px; padding-top:1.5rem;}
.quick_button a{ display:inline-block; width:12%; height:100px; text-align:center; overflow:hidden;    white-space: nowrap;  text-overflow: llipsis; line-height:2rem;}
.quick_button a:hover{ opacity:0.8;}
.quick_button a img{ display:block; margin:auto; width:50px; height:50px; background:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>; border-radius:5px;}

.quick_button a:nth-child(1) img{ background:rgba(52,182,175,1);}
.quick_button a:nth-child(2) img{ background:rgba(242,161,47,1);}
.quick_button a:nth-child(3) img{ background:rgba(255,51,51,1);}
.quick_button a:nth-child(4) img{ background:rgba(239,194,79,1);}
.quick_button a:nth-child(5) img{ background:rgba(255,92,152,1);}
.quick_button a:nth-child(6) img{ background:rgba(255,144,82,1);}
.quick_button a:nth-child(7) img{ background:rgba(144,215,108,1);}
.quick_button a:nth-child(8) img{ background:rgba(43,193,2,1);}
.quick_button a:nth-child(9) img{ background:rgba(52,182,175,1);}
.quick_button a:nth-child(10) img{ background:rgba(242,161,47,1);}
.quick_button a:nth-child(11) img{ background:rgba(255,51,51,1);}
.quick_button a:nth-child(12) img{ background:rgba(239,194,79,1);}
.quick_button a:nth-child(13) img{ background:rgba(255,92,152,1);}
.quick_button a:nth-child(14) img{ background:rgba(255,144,82,1);}
.quick_button a:nth-child(15) img{ background:rgba(144,215,108,1);}
.quick_button a:nth-child(16) img{ background:rgba(43,193,2,1);}

</style>
<div class=quick_button><?php echo $module['quick_button'];?></div>
</div>