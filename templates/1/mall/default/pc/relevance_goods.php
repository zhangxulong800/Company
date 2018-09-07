<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
	
		$("#<?php echo $module['module_name'];?> .delete_me").click(function(){
			$(this).parent().remove();
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .move_to_left").click(function(){
			a=$(this).parent();
			b=a.prev();
			a.insertBefore(b);
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .move_to_right").click(function(){
			a=$(this).parent();
			b=a.next();
			a.insertAfter(b);
			return false;	
		});
	

    });
    
    
    
    function e_submit(){
		//alert('dd');
		var ids='';
		$("#<?php echo $module['module_name'];?>_html .goods_div").each(function(index, element) {
            ids+=','+$(this).attr('id').replace(/goods_div_/,'');
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
    #<?php echo $module['module_name'];?>_html .goods_div{ display:inline-block; vertical-align:top; width:19%; margin-bottom:1rem; margin-right:1%; vertical-align:top; overflow:hidden; line-height:20px;  text-align:center;  padding:10px; border:4px solid #ddd;}
    #<?php echo $module['module_name'];?>_html .goods_div .goods_a{ display:block;height:12.88rem; overflow:hidden; font-size:1rem; line-height:19px; }
    #<?php echo $module['module_name'];?>_html .goods_div .goods_a:hover img{ opacity:0.8;}
    #<?php echo $module['module_name'];?>_html .goods_div .goods_a img{  height:11.42rem; max-width:11.42rem;}
	#<?php echo $module['module_name'];?>_html #add{ height:17.65rem;}
	#<?php echo $module['module_name'];?>_html #add:before{
	font: normal normal normal 55px/1 FontAwesome;
	line-height:200px;
	content: "\f067";}
	#<?php echo $module['module_name'];?>_html #add:hover{ }
	#<?php echo $module['module_name'];?>_html #save_div{ line-height:100px; text-align:center;}
	#<?php echo $module['module_name'];?>_html .move_to_left{display:inline-block; vertical-align:top;width:30%; text-align:center;	}
	#<?php echo $module['module_name'];?>_html .move_to_left:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f104";}
	#<?php echo $module['module_name'];?>_html .move_to_left:hover{opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .move_to_right{display:inline-block; vertical-align:top;width:30%; text-align:center; }
	#<?php echo $module['module_name'];?>_html .move_to_right:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f105";}
	#<?php echo $module['module_name'];?>_html .move_to_right:hover{opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .delete_me{ display:inline-block; vertical-align:top; width:30%; text-align:center;}
	#<?php echo $module['module_name'];?>_html .delete_me:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f014";}
	#<?php echo $module['module_name'];?>_html .delete_me:hover{opacity:0.8;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html">
		<?php echo $module['data'];?><a href="./index.php?monxin=mall.goods_admin&goods_id=<?php echo $_GET['goods_id'];?>&act=relevance_goods" class=goods_div id=add>&nbsp;</a>
       <div id=save_div><a href="#" onclick="return e_submit();" class="submit"><?php echo self::$language['save']?></a> <span id="submit_state"></span></div>
    </div>

</div>
