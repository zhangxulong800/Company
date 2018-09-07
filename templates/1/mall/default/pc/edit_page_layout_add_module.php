<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){  
	
		$("#<?php echo $module['module_name'];?>_html #program").change(function(){
			url=window.location.href;
			url=replace_get(url,'program',$(this).prop("value"));
			window.location.href=url;	
		});
		$("#<?php echo $module['module_name'];?>_html #program").prop('value',get_param('program'));
		
	
        $(".module_a").click(function(){
			$(".module_a").removeClass('module_a_selected');
			$(this).addClass('module_a_selected');
			//if($.browser.msie){return true;}
			$("#view_module").attr('src',$(this).attr('href'));
			return false;	
        });
		
		$(".add").click(function(){
			module_name=$(".module_a_selected").attr('module_name');
			//monxin_alert(module_name);
			if(!module_name){monxin_alert('<?php echo self::$language['select_please'];?><?php echo self::$language['module'];?>');}
			$("#add_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');

			$.post("<?php echo $module['action_url'];?>&act=add_module", { module_name:module_name},function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					

					$("#add_state").html(v.info);
					if(v.state=='success'){
						monxin_alert(v.info);
						url='&<?php echo $_GET['params']?>';
						url=url.replace(/\|\|\|/g,'&');
						//alert(url);
						window.location.href='index.php?'+url;	 
					}
			});
			return false;	
		});
		url='<?php echo $_GET['url'];?>';
		url+='&<?php echo $_GET['params']?>';
		url='index.php?'+url;	
		url=url.replace(/\|\|\|/g,'&');
		$("#<?php echo $module['module_name'];?>_html .return_button").attr('href',url);
            
    });
    </script>
    

	<style>
    #<?php echo $module['module_name'];?>_html{line-height:40px;}
    #<?php echo $module['module_name'];?>_html legend{ }
	#<?php echo $module['module_name'];?>_html fieldset{ margin-bottom:20px;}
	#<?php echo $module['module_name'];?>_html #moudle_list{ width:100%; height:200px; overflow-y:scroll;}
	.module_a{ display:inline-block; width:250px; height:40px; overflow:hidden;  text-align:center;}
	.module_a:hover{ display:inline-block; width:250px; height:40px; overflow:hidden;  border-radius:5px; }
	.module_a_selected{ display:inline-block; width:250px; height:40px; overflow:hidden;  border-radius:5px; 	 list-style:circle;}
	#view_module{ width:100%; height:600px;}
	#operation_div{ border-bottom:10px solid #fff; height:50px; line-height:50px; margin-bottom:30px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	<div id=moudle_list><?php echo $module['list'];?></div>
        <div align="center" id=operation_div><a href="#" class="return_button"><?php echo self::$language['return']?></a> <a href="" class=add><?php echo self::$language['add'];?></a><span id=add_state></span></div>
       <iframe  id=view_module frameborder=0 src='' marginwidth=0 marginheight=0 vspace=0 hspace=0 allowtransparency=true></iframe>
    </div>

</div>