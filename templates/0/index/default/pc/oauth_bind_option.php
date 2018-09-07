<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>">
<script>
 $(document).ready(function(){
	 $("#<?php echo $module['module_name'];?>_html .skip").css('opacity',1);
	 $("#<?php echo $module['module_name'];?> .skip").click(function(){
		 //alert($(this).css('opacity'));
		 if($(this).css('opacity')!=1){return false;}
		 $(this).css('opacity','0.5');
		$("#<?php echo $module['module_name'];?>_html .new,#<?php echo $module['module_name'];?>_html .old").css('display','none');
		$("#<?php echo $module['module_name'];?>_html .skip").html('<span class=\'fa fa-spinner fa-spin\'></span> <?php echo self::$language['landing']?>');
		
		$.get('<?php echo $module['action_url'];?>',function(data){
			//alert(data);
			if(data=="<script>window.close();<\/script>"){window.close();}else{
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .skip").html(v.info);
				$("#<?php echo $module['module_name'];?>_html .skip").css('opacity',1);
			}
			 
		});		 
		 return false;
	 });
	 
 });
</script>
<style>
#<?php echo $module['module_name'];?>{ text-align:center;}
#<?php echo $module['module_name'];?>_html .title{ font-size:24px; font-weight:bolder; line-height:60px;}
#<?php echo $module['module_name'];?>_html .body{}
#<?php echo $module['module_name'];?>_html .body .icon{ width:70px; height:70px;overflow:hidden; border-radius:35px;  border:2px solid #CCC;}
#<?php echo $module['module_name'];?>_html .body .nickname{ line-height:40px; font-weight:bold;}
#<?php echo $module['module_name'];?>_html .body .notice{line-height:30px; font-size:13px;}
#<?php echo $module['module_name'];?>_html .body a{ margin:auto; margin-top:10px; margin-bottom:10px; display:block; width:200px; line-height:40px;border-radius:5px;  border:1px solid #CCC;}
#<?php echo $module['module_name'];?>_html .body a:hover{ opacity:0.8;}
#<?php echo $module['module_name'];?>_html .body .new{ background:#F00; }
#<?php echo $module['module_name'];?>_html .loading{margin-top:10px;}

</style>
    <div id="<?php echo $module['module_name'];?>_html">
		<div class=title><?php echo $module['title']?></div>
        <div class=body>
        	<img src=<?php echo $module['icon']?>  class=icon />
            <div class=nickname><?php echo $module['nickname']?></div>
            <div class=notice><?php echo $module['notice'];?></div>
            <a href=./index.php?monxin=index.reg_user&group_id=<?php echo $module['default_group_id']?>&oauth=1 class=new><?php echo self::$language['bind'];?><?php echo self::$language['new_account'];?></a>
            <a href=./index.php?monxin=index.login&oauth=1 class=old><?php echo self::$language['bind'];?><?php echo self::$language['existing_account'];?></a>
            <?php echo $module['skip'];?>
			<br /><br />
        </div>
    </div>
</div>

