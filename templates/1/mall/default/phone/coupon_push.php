<div id=<?php echo $module['module_name'];?>   monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./plugin/datePicker/index.php"></script>
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> ."+get_param('type')+"_div").css('display','block');
		
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			if(get_param('type')=='group'){
				$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.post('<?php echo $module['action_url'];?>&act=push',{group:$("#<?php echo $module['module_name'];?> .group").val()}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					$("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
					 parent.update_draws('<?php echo $_GET['id']?>',v.draws);
				});
					
			}else{
				if($("#<?php echo $module['module_name'];?> .usernames").val()==''){
					$("#<?php echo $module['module_name'];?> .usernames").focus();
					$("#<?php echo $module['module_name'];?> .submit").next().html('<?php echo self::$language['please_input']?>');	
					return false;
				}
				$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.post('<?php echo $module['action_url'];?>&act=push',{usernames:$("#<?php echo $module['module_name'];?> .usernames").val()}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					$("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
					 parent.update_draws('<?php echo $_GET['id']?>',v.draws);
				});
			}
			
			return false;	
		});
    });
    </script>
	<style>
	.fixed_right_div,.page-footer,#mall_cart{ display:none !important;}
	.page-content .container { width:100% !important; height:100%;}
    #<?php echo $module['module_name'];?>{ padding-bottom:50px;}
    #<?php echo $module['module_name'];?> .group_div{ display:none;}
    #<?php echo $module['module_name'];?> .username_div{ display:none;}
    #<?php echo $module['module_name'];?> .username_div .usernames{ width:100%; height:200px;}
	#<?php echo $module['module_name'];?> .submit_div{ line-height:60px;}
	#<?php echo $module['module_name'];?> .group{ margin-top:20px; margin-bottom:20px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
        <div class="portlet-title">
        	<div class="caption"><?php echo $module['name']?></div>
   		</div>
		<div class=group_div>
        	<div ><?php echo self::$language['buyer_group']?></div>
            <select class=group><option value="0"><?php echo self::$language['all']?></option><?php echo $module['list'];?></select>
        </div>
		<div class=username_div>
        	<div ><?php echo self::$language['username']?> <?php echo self::$language['multi_separated_by_commas']?></div>
            <textarea class=usernames></textarea>
        </div>
        <div class="submit_div"><a class="submit" href="#" ><?php echo self::$language['push']?></a> <span class=state></span></div>
        
   
    </div>
</div>
