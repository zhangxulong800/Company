<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .submit").css('display','none');
			$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			
            $.get('<?php echo $module['action_url'];?>&act=submit',function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
                if(v.state=='success'){
                	parent.update_reflash_time(<?php echo $_GET['id']?>,v.html);
					if(v.balance!=-1){
						$("#<?php echo $module['module_name'];?> .balance").html(v.balance);	
					}
                }else{
					$("#<?php echo $module['module_name'];?> .submit").css('display','inline-block');	
				}
            });
		});
		
    });
    
    </script>
    <style>
	.page-footer,.fixed_right_div{ display:none;}
	.page-content .container { width:100% !important; height:100%;}

    #<?php echo $module['module_name'];?>_html{  margin-top:80px; margin-bottom:80px; }
    #<?php echo $module['module_name'];?>_html b{ font-weight:normal; }
    </style>
	<div id="<?php echo $module['module_name'];?>_html">
    	<?php echo $module['info'];?>
        <br /> <br />
        <a href=# class=submit><?php echo self::$language['confirm'];?><?php echo self::$language['refresh'];?></a> <span></span> <?php echo $module['balance'];?>
    </div>

</div>
