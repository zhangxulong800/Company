<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> #submit").click(function(){
			args='';
			args+='relevance_package_div:'+$("#<?php echo $module['module_name'];?> .relevance_package_div").val()+'|';
			args+='relevance_goods_div:'+$("#<?php echo $module['module_name'];?> .relevance_goods_div").val()+'|';
			args+='goods_detail_div:'+$("#<?php echo $module['module_name'];?> .goods_detail_div").val()+'|';
			//args=args.replace(/\|/,'');
			
			url='<?php echo $module['action_url'];?>('+args+')';
			
			//alert(url);
			//return false;
			
			
			$(this).next('span').html('<span class=\'fa fa-spinner fa-spin\'></span>');
			
			$.get(url,function(data){
				//alert(data);	
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> #submit").next('span').html(v.info);
                if(v.state=='success'){
					alert('<?php echo self::$language['success'];?>');
                	window.location.href='./index.php?monxin='+get_param('url')+'&edit_page_layout=true&id='+get_param('id');
                }

			});	
		});
		
	});
	
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>_html{ padding:10px;}
    #<?php echo $module['module_name'];?>_html div{ line-height:60px;}
    #<?php echo $module['module_name'];?> .m_label{ display:inline-block; width:150px; text-align:right; padding-right:10px;}
    #<?php echo $module['module_name'];?> #content{}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
      <div><span class="m_label"><?php echo self::$language['preferential_packages']?></span><span class=input_span><input type=text class=relevance_package_div value="<?php echo $module['relevance_package_div']?>" /></span></div>
      <div><span class="m_label"><?php echo self::$language['related_goods']?></span><span class=input_span><input type=text class=relevance_goods_div value="<?php echo $module['relevance_goods_div']?>" /></span></div>
      <div><span class="m_label"><?php echo self::$language['goods_detail']?></span><span class=input_span><input type=text class=goods_detail_div value="<?php echo $module['goods_detail_div']?>" /></span></div>
   	  <div><span class="m_label">&nbsp;</span><span class=input_span>
      		<a href="#" id=submit class="submit"><?php echo self::$language['submit'];?></a> <span></span>
      </span></div> 


    </div>
</div>

