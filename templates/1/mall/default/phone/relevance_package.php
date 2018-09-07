<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
	
		$("#<?php echo $module['module_name'];?> .delete_me").click(function(){
			$(this).parent().parent().remove();
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .move_to_left").click(function(){
			a=$(this).parent().parent();
			b=a.prev();
			a.insertBefore(b);
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .move_to_right").click(function(){
			a=$(this).parent().parent();
			b=a.next();
			a.insertAfter(b);
			return false;	
		});
	

    });
    
    
    
    function e_submit(){
		//alert('dd');
		var ids='';
		$("#<?php echo $module['module_name'];?>_html .package_div").each(function(index, element) {
            ids+=','+$(this).attr('id').replace(/package_div_/,'');
        });       
		//alert(ids); 
        $("#<?php echo $module['module_name'];?> #submit_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{ids:ids}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #submit_state").html(v.info);
        });
        	
       return false; 
    }
	


    </script>
    <style>
    #<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?>_html .package_div{ display:inline-block; vertical-align:top; border:#ccc solid 1px; margin:10px; margin-top:20px; padding:10px;}
	#<?php echo $module['module_name'];?>_html .add_symbol{ display:inline-block; }
	#<?php echo $module['module_name'];?>_html .add_symbol:before{font: normal normal normal 3rem/1 FontAwesome; content:"\f067"; height:10; line-height:10rem;}
	#<?php echo $module['module_name'];?>_html .equal_symbol{ display:inline-block; vertical-align:top; height:10rem; line-height:10rem;vertical-align:middle;}
	#<?php echo $module['module_name'];?>_html .equal_symbol:before{font: normal normal normal 3rem/1 monxin; content:"\f00c";}
	#<?php echo $module['module_name'];?>_html .result_div{ display:inline-block; vertical-align:top;vertical-align: middle;width:40%; margin-bottom:1rem; overflow:hidden; margin:10px; text-align:left;  border:2px solid #ddd; padding:20px;} 
    #<?php echo $module['module_name'];?>_html .goods_div{ display:inline-block; vertical-align:top; width:42%; margin-bottom:1rem; margin-right:1%; vertical-align:top; overflow:hidden; line-height:2rem; height:12rem;  text-align:center;  padding:10px; border:4px solid #ddd;}
    #<?php echo $module['module_name'];?>_html .goods_div .goods_a{ display:block; overflow:hidden; font-size:1rem; line-height:19px; }
    #<?php echo $module['module_name'];?>_html .goods_div .goods_a:hover img{ opacity:0.8;}
    #<?php echo $module['module_name'];?>_html .goods_div .goods_a img{  height:6rem; max-width:6rem;}
    #<?php echo $module['module_name'];?>_html .goods_div .money_symbol{  font-weight:bold; font-size:13px;}
    #<?php echo $module['module_name'];?>_html .goods_div .money_value{  font-weight:bold; font-size:13px;}
    #<?php echo $module['module_name'];?>_html .goods_div .goods_name{  height:40px; overflow:hidden; display:inline-block; vertical-align:top;}

	#<?php echo $module['module_name'];?>_html #new{ width:40%;}
	#<?php echo $module['module_name'];?>_html #add{ display:inline-block; border:none; padding:0;width:100%; margin-bottom:1rem; }
	#<?php echo $module['module_name'];?>_html #add:before{	font: normal normal normal 55px/1 FontAwesome;	line-height:10rem;	content: "\f067";}
	#<?php echo $module['module_name'];?>_html #add:hover{}
	#<?php echo $module['module_name'];?>_html #save_div{ line-height:100px; text-align:center;}
	#<?php echo $module['module_name'];?>_html #save_div{ line-height:100px; text-align:center;}
	#<?php echo $module['module_name'];?>_html .move_to_left{display:inline-block; vertical-align:top;width:30%; text-align:center;	}
	#<?php echo $module['module_name'];?>_html .move_to_left:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f106";}
	#<?php echo $module['module_name'];?>_html .move_to_left:hover{opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .move_to_right{display:inline-block; vertical-align:top;width:30%; text-align:center; }
	#<?php echo $module['module_name'];?>_html .move_to_right:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f107";}
	#<?php echo $module['module_name'];?>_html .move_to_right:hover{opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .delete_me{ display:inline-block; vertical-align:top; width:30%; text-align:center;}
	#<?php echo $module['module_name'];?>_html .delete_me:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f014";}
	#<?php echo $module['module_name'];?>_html .delete_me:hover{opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .discount_value{  font-weight:bold; font-size:24px; font-family:Georgia, "Times New Roman", Times, serif;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html">
		<?php echo $module['data'];?>
       <div id=save_div><a href="#" onclick="return e_submit();" class="submit"><?php echo self::$language['save']?></a> <span id="submit_state"></span></div>
    </div>

</div>
