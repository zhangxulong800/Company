<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		$("#edit_page_layout_div").remove();
		$("#<?php echo $module['module_name'];?> .barcode").focus();
		$("#<?php echo $module['module_name'];?> .barcode").keyup(function(event){
            if(event.keyCode==13 && $(this).val()!=''){
				$(this).next().html('');
				$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=submit',{barcode:$(this).val()}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					
					$("#<?php echo $module['module_name'];?> .barcode").next().html(v.info);
					if(v.state=='success'){
						$("#<?php echo $module['module_name'];?> #goods_info_span").html(v.html);
						$("#<?php echo $module['module_name'];?> .temp_html").html(v.print_html);
						$("#<?php echo $module['module_name'];?> .quantity").focus();
						$("#<?php echo $module['module_name'];?> .goods_unit").html($("#<?php echo $module['module_name'];?> .temp_html .unit").html());
						//window.print_tag.set_and_print();
					}else{
						$("#<?php echo $module['module_name'];?> #goods_info_span").html('');
					}
				});
				return false;	
			}
        });
		
		$("#<?php echo $module['module_name'];?> .quantity").keyup(function(event){
			if($("#<?php echo $module['module_name'];?> .goods_unit").html()==''){alert('<?php echo self::$language['please_get_the_goods_information'];?>');return false;}
			if($(this).val()==''){$("#<?php echo $module['module_name'];?> .format_unit").css('display','none');return false;}
            if(event.keyCode==13 && $(this).val()!=''){
				$(this).val($(this).val().replace(/ /g,''));
				$(this).val($(this).val().replace(/\+/,''));
				$(this).val($(this).val().replace(/g/,''));
				$(this).val(parseInt($(this).val()));
				if(!$.isNumeric($(this).val())){alert('<?php echo self::$language['must_be'];?><?php echo self::$language['number'];?>'); return false;}
				$("#<?php echo $module['module_name'];?> .goods_quantity").html($(this).val()/$("#<?php echo $module['module_name'];?> .unit_gram").prop('value'));
				$("#<?php echo $module['module_name'];?> .format_unit").css('display','inline-block');
				temp=$("#<?php echo $module['module_name'];?> .temp_html").html();
				temp=temp.replace(/{quantity}/g,$("#<?php echo $module['module_name'];?> .goods_quantity").html());
				sum_money=$("#<?php echo $module['module_name'];?> .price_value").html()*$("#<?php echo $module['module_name'];?> .goods_quantity").html();
				sum_money=sum_money.toFixed(2);
				temp=temp.replace(/{sum_money}/,sum_money);
				window.print_tag.set_and_print(temp);
				return false;	
			}
        });
    });
    </script>
    <style>
	#<?php echo $module['module_name'];?>{} 
	#<?php echo $module['module_name'];?> .left{ padding-top:100px; display:inline-block; vertical-align:top; width:70%;} 
	#<?php echo $module['module_name'];?> .left .line{ line-height:70px;} 
	#<?php echo $module['module_name'];?> .left .line .m_label{ display:inline-block; vertical-align:top; width:30%; text-align:right; padding-right:10px;} 
	#<?php echo $module['module_name'];?> .left .line .input_span{display:inline-block; vertical-align:top; width:65%; text-align:left; } 
	#<?php echo $module['module_name'];?> .right{ display:inline-block; vertical-align:top; width:28%;} 
	#<?php echo $module['module_name'];?> .iframe_div{ padding-left:20px;  height:650px;} 
	
	#<?php echo $module['module_name'];?> .goods_title{ font-weight:bold;}
	#<?php echo $module['module_name'];?> .goods_img{}
	#<?php echo $module['module_name'];?> .goods_img img{height:300px;}
	#<?php echo $module['module_name'];?> .format_unit{ display:none;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
		<div class=left>
            <div class=line><span class=m_label><?php echo self::$language['bar_code'];?></span><span class=input_span><input type="text" class="barcode" /> <span class=state></span></span></div>
            <div class=line><span class=m_label><?php echo self::$language['weight'];?></span><span class=input_span><input type="text" class="quantity" /> <?php echo self::$language['gram'];?> <div class="format_unit"> = <span class=goods_quantity></span><span class=goods_unit></span></div> </span></div>
            <div class=goods_info>
            	 <div class=line><span class=m_label>&nbsp;</span><span class=input_span id=goods_info_span>
                 	
                    </span></div>
                 
            </div>
        </div><div class=right>
        	<div class=temp_html  style="display:none;"></div>
            <div class=iframe_div><iframe width="100%" id="print_tag" name="print_tag" height="600px;" id="map" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="./index.php?monxin=mall.scale_tag_print" >
</iframe></div>
        </div>
    </div>
</div>