<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .free_shipping").each(function(index, element) {
            if($(this).attr('monxin_value')){$(this).prop('value',$(this).attr('monxin_value'));}
        });
		if('relevance_package'=='<?php echo @$_GET['act'];?>'){
			
			if(''=='<?php echo  @$_GET['package_ids'];?>'){
				$(".package_div").each(function(index, element) {
					$(this).children('#add').css('display','none');
					$(this).children('div').children('.operation_div').html('<a href="index.php?monxin=mall.relevance_package&goods_id=<?php echo @$_GET['goods_id']?>&relevance_new='+$(this).attr('id').replace(/package_div_/,'')+'" class=relevance><?php echo self::$language['relevance'];?></a>');
				});	
			}else{
				
				temp='<?php echo  @$_GET['package_ids'];?>';
				temp=temp.split(',');
				$(".package_div").each(function(index, element) {
					if($.inArray($(this).attr('id').replace(/package_div_/,''),temp)!=-1){
						$(this).children('#add').css('display','none');
						$(this).children('div').children('.operation_div').html('');
					}else{
						$(this).children('#add').css('display','none');
						$(this).children('div').children('.operation_div').html('<a href="index.php?monxin=mall.relevance_package&goods_id=<?php echo @$_GET['goods_id']?>&relevance_new='+$(this).attr('id').replace(/package_div_/,'')+'" class=relevance><?php echo self::$language['relevance'];?></a>');
					}
					
				});	
			}			
		}
		
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
	
		$("#<?php echo $module['module_name'];?> .submit").click(function(index, element){
			var id=$(this).parent().parent().parent().attr('id');
			var discount=$("#"+id+" .discount");
			if(discount.val()==''){discount.focus();$("#"+id+" .state").html('<span class=fail><?php echo self::$language['is_null'];?></span>');return false;}
			if(!$.isNumeric(discount.val())){discount.focus();$("#"+id+" .state").html('<span class=fail><?php echo self::$language['must_be'];?><?php echo self::$language['number'];?></span>');return false;}
			
			var ids='';
			$("#"+id+" .goods_div").each(function(index, element) {
				if($(this).attr('id')){ids+=','+$(this).attr('id').replace(/goods_div_/,'');}
			});       
			//alert(ids); 
			$("#"+id+" .state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=update',{ids:ids,free_shipping:$("#"+id+" .free_shipping").val(),discount:discount.val(),id:id.replace(/package_div_/,'')}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#"+id+" .state").html(v.info);
			});
				
		   return false; 
        });
		$("#<?php echo $module['module_name'];?> .del").click(function(index, element){
			if(confirm("<?php echo self::$language['delete_confirm']?>")){
			var id=$(this).parent().parent().parent().attr('id');
			$("#"+id+" .state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=del',{id:id.replace(/package_div_/,'')}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#"+id+" .state").html(v.info);
                if(v.state=='success'){
                	$("#"+id).animate({opacity:0},"slow",function(){$("#"+id).css('display','none');});
                }
			});
			}
		   return false; 
        });
    });
    
    


    </script>
    <style>
    #<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?>_html .package_div{ vertical-align:middle;  border:#ccc solid 1px; margin-bottom:20px; padding:10px;}
	#<?php echo $module['module_name'];?>_html .equal_symbol{ display:inline-block; vertical-align:top; height:15.6rem; line-height:15.6rem;vertical-align:middle;}
	#<?php echo $module['module_name'];?>_html .equal_symbol:before{font: normal normal normal 3rem/1 monxin; content:"\f00c";}
	#<?php echo $module['module_name'];?>_html .result_div{ display:inline-block; vertical-align:top;  vertical-align: middle;  width:200px; height:80px; line-height:80px; overflow:hidden; margin:10px; text-align:left;} 
	
    #<?php echo $module['module_name'];?>_html .goods_div{ display:inline-block; vertical-align:top; width:48%; margin-bottom:1rem; margin-right:1%; vertical-align:top; overflow:hidden; line-height:2rem; height:18.2rem;  text-align:center;  padding:10px; border:4px solid #ddd;}
    #<?php echo $module['module_name'];?>_html .goods_div .goods_a{ display:block; overflow:hidden; font-size:1rem; line-height:19px; }
    #<?php echo $module['module_name'];?>_html .goods_div .goods_a:hover img{ opacity:0.8;}
    #<?php echo $module['module_name'];?>_html .goods_div .goods_a img{  height:11.42rem; max-width:11.42rem;}
    #<?php echo $module['module_name'];?>_html .goods_div .money_symbol{  font-weight:bold; font-size:13px;}
    #<?php echo $module['module_name'];?>_html .goods_div .money_value{  font-weight:bold; font-size:13px;}
    #<?php echo $module['module_name'];?>_html .goods_div .goods_name{  white-space:nowrap; overflow:hidden; text-overflow: ellipsis;}
	#<?php echo $module['module_name'];?>_html #add{}
	#<?php echo $module['module_name'];?>_html #add:before{font: normal normal normal 3rem/1 FontAwesome; content:"\f067"; height:15.6rem; line-height:15.6rem;}
	#<?php echo $module['module_name'];?>_html #add:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?>_html #save_div{ line-height:100px; text-align:center;}
	#<?php echo $module['module_name'];?>_html .discount{ width:50px;}
	
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
	#<?php echo $module['module_name'];?>_html .relevance{display:inline-block; vertical-align:top; height:30px; line-height:30px;}    
	#<?php echo $module['module_name'];?>_html .relevance:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f0c1";}
    </style>
	<div id="<?php echo $module['module_name'];?>_html">
    	
       <?php echo $module['list'];?>
       <?php echo $module['page'];?>
    </div>

</div>
