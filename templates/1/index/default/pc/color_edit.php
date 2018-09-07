<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> [type='color']").each(function(index, element) {
            temp=$(this).prev('input').val();
			if(temp.indexOf('#')>-1){
				$(this).val(temp);	
			}
        });
		$("#<?php echo $module['module_name'];?> input[mc]").change(function(){
			temp=$(this).val();
			if(temp.indexOf('#')>-1){
				$(this).next('input').val(temp);	
			}else{
				$(this).next('input').val('');
			}
				
		});
		
		$("#<?php echo $module['module_name'];?> [type='color']").change(function(){
			if($(this).val()!=''){
				$(this).prev('input').val($(this).val());	
			}		
		});
		
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			
			obj=new Object();
			$("#<?php echo $module['module_name'];?> fieldset").each(function(index, element) {
                obj[$(this).attr('parent')]=new Object();
				$("#<?php echo $module['module_name'];?> fieldset[parent='"+$(this).attr('parent')+"'] input[type='text']").each(function(index, element) {
					obj[$(this).parent().parent().attr('parent')][$(this).attr('mc')]=$(this).val();
                });
            });
			
			$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=update',obj, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
			});
				
			
			return false;	
		});
		
    });
    
    </script>
    <style>
	#<?php echo $module['module_name'];?>{ }
	#<?php echo $module['module_name'];?> input[mc]{ width:50%;}
	#<?php echo $module['module_name'];?> .item{ width:30%; display:inline-block; vertical-align:top; line-height:3rem; overflow:hidden;}
	#<?php echo $module['module_name'];?> fieldset{ margin-bottom:1rem;}
	#<?php echo $module['module_name'];?> .stop{ display:none;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
        
        <div class="portlet-title">
            <div class="caption"><?php echo $module['monxin_table_name']?></div>
        </div>
        
   		<fieldset parent="head"><legend><?php echo self::$language['color_set']['head']?></legend>
        	<div class='item stop'><?php echo self::$language['color_set']['border']?>:<input type="text" mc=border value="<?php echo $color['head']['border']?>"  placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['background']?>:<input type="text" mc=background value="<?php echo $color['head']['background']?>"  placeholder="<?php echo self::$language['color_set']['background_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['text']?>:<input type="text" mc=text value="<?php echo $color['head']['text']?>"   placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        </fieldset>
   		<fieldset parent="container"><legend><?php echo self::$language['color_set']['container']?></legend>
        	<div  class='item stop'><?php echo self::$language['color_set']['border']?>:<input type="text" mc=container_border value="<?php echo $color['container']['border']?>"  placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['background']?>:<input type="text" mc=background value="<?php echo $color['container']['background']?>"  placeholder="<?php echo self::$language['color_set']['background_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['text']?>:<input type="text" mc=text value="<?php echo $color['container']['text']?>"   placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        </fieldset>
        
   		<fieldset parent="shape_head"><legend><?php echo self::$language['color_set']['shape_head']?></legend>
        	<div class=item><?php echo self::$language['color_set']['border']?>:<input type="text" mc=border value="<?php echo $color['shape_head']['border']?>"  placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['background']?>:<input type="text" mc=background value="<?php echo $color['shape_head']['background']?>"  placeholder="<?php echo self::$language['color_set']['background_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['text']?>:<input type="text" mc=text value="<?php echo $color['shape_head']['text']?>"   placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        </fieldset>

   		<fieldset parent="shape_bottom"><legend><?php echo self::$language['color_set']['shape_bottom']?></legend>
        	<div class=item><?php echo self::$language['color_set']['border']?>:<input type="text" mc=border value="<?php echo $color['shape_bottom']['border']?>"  placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['background']?>:<input type="text" mc=background value="<?php echo $color['shape_bottom']['background']?>"  placeholder="<?php echo self::$language['color_set']['background_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['text']?>:<input type="text" mc=text value="<?php echo $color['shape_bottom']['text']?>"   placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        </fieldset>
   
   
   		<fieldset parent="nv_1"><legend><?php echo self::$language['color_set']['nv_1']?></legend>
        	<div class=item><?php echo self::$language['color_set']['border']?>:<input type="text" mc=border value="<?php echo $color['nv_1']['border']?>"  placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['background']?>:<input type="text" mc=background value="<?php echo $color['nv_1']['background']?>"  placeholder="<?php echo self::$language['color_set']['background_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['text']?>:<input type="text" mc=text value="<?php echo $color['nv_1']['text']?>"   placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        </fieldset>
   		<fieldset parent="nv_1_hover"><legend><?php echo self::$language['color_set']['nv_1']?>:<?php echo self::$language['color_set']['hover']?></legend>
        	<div class=item><?php echo self::$language['color_set']['border']?>:<input type="text" mc=border value="<?php echo $color['nv_1_hover']['border']?>"  placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['background']?>:<input type="text" mc=background value="<?php echo $color['nv_1_hover']['background']?>"  placeholder="<?php echo self::$language['color_set']['background_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['text']?>:<input type="text" mc=text value="<?php echo $color['nv_1_hover']['text']?>"   placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        </fieldset>
   
   		<fieldset parent="nv_2"><legend><?php echo self::$language['color_set']['nv_2']?></legend>
        	<div class=item><?php echo self::$language['color_set']['border']?>:<input type="text" mc=border value="<?php echo $color['nv_2']['border']?>"  placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['background']?>:<input type="text" mc=background value="<?php echo $color['nv_2']['background']?>"  placeholder="<?php echo self::$language['color_set']['background_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['text']?>:<input type="text" mc=text value="<?php echo $color['nv_2']['text']?>"   placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        </fieldset>
   		<fieldset parent="nv_2_hover"><legend><?php echo self::$language['color_set']['nv_2']?>:<?php echo self::$language['color_set']['hover']?></legend>
        	<div class=item><?php echo self::$language['color_set']['border']?>:<input type="text" mc=border value="<?php echo $color['nv_2_hover']['border']?>"  placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['background']?>:<input type="text" mc=background value="<?php echo $color['nv_2_hover']['background']?>"  placeholder="<?php echo self::$language['color_set']['background_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['text']?>:<input type="text" mc=text value="<?php echo $color['nv_2_hover']['text']?>"   placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        </fieldset> 
   
   		<fieldset parent="nv_3"><legend><?php echo self::$language['color_set']['nv_3']?></legend>
        	<div class=item><?php echo self::$language['color_set']['border']?>:<input type="text" mc=border value="<?php echo $color['nv_3']['border']?>"  placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['background']?>:<input type="text" mc=background value="<?php echo $color['nv_3']['background']?>"  placeholder="<?php echo self::$language['color_set']['background_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['text']?>:<input type="text" mc=text value="<?php echo $color['nv_3']['text']?>"   placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        </fieldset>
   		<fieldset parent="nv_3_hover"><legend><?php echo self::$language['color_set']['nv_3']?>:<?php echo self::$language['color_set']['hover']?></legend>
        	<div class=item><?php echo self::$language['color_set']['border']?>:<input type="text" mc=border value="<?php echo $color['nv_3_hover']['border']?>"  placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['background']?>:<input type="text" mc=background value="<?php echo $color['nv_3_hover']['background']?>"  placeholder="<?php echo self::$language['color_set']['background_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['text']?>:<input type="text" mc=text value="<?php echo $color['nv_3_hover']['text']?>"   placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        </fieldset>
   
   		<fieldset parent="button"><legend><?php echo self::$language['color_set']['button']?></legend>
        	<div class=item><?php echo self::$language['color_set']['border']?>:<input type="text" mc=border value="<?php echo $color['button']['border']?>"  placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['background']?>:<input type="text" mc=background value="<?php echo $color['button']['background']?>"  placeholder="<?php echo self::$language['color_set']['background_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['text']?>:<input type="text" mc=text value="<?php echo $color['button']['text']?>"   placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        </fieldset>
   		<fieldset parent="button_hover"><legend><?php echo self::$language['color_set']['button']?>hover</legend>
        	<div class=item><?php echo self::$language['color_set']['border']?>:<input type="text" mc=border value="<?php echo $color['button_hover']['border']?>"  placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['background']?>:<input type="text" mc=background value="<?php echo $color['button_hover']['background']?>"  placeholder="<?php echo self::$language['color_set']['background_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['text']?>:<input type="text" mc=text value="<?php echo $color['button_hover']['text']?>"   placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        </fieldset>
   

   		<fieldset parent="module"><legend><?php echo self::$language['color_set']['module']?></legend>
        	<div class=item><?php echo self::$language['color_set']['border']?>:<input type="text" mc=border value="<?php echo $color['module']['border']?>"  placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['background']?>:<input type="text" mc=background value="<?php echo $color['module']['background']?>"  placeholder="<?php echo self::$language['color_set']['background_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['text']?>:<input type="text" mc=text value="<?php echo $color['module']['text']?>"   placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        </fieldset>
        
   		<fieldset parent="table"><legend><?php echo self::$language['color_set']['table']?></legend>
        	<div class=item><?php echo self::$language['color_set']['border']?>:<input type="text" mc=border value="<?php echo $color['table']['border']?>"  placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['table_head']?><?php echo self::$language['color_set']['background']?>:<input type="text" mc=thead_background value="<?php echo $color['table']['thead_background']?>"  placeholder="<?php echo self::$language['color_set']['background_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['table_head']?><?php echo self::$language['color_set']['text']?>:<input type="text" mc=thead_text value="<?php echo $color['table']['thead_text']?>"   placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
            
        	<div class=item><?php echo self::$language['color_set']['odd']?><?php echo self::$language['color_set']['background']?>:<input type="text" mc=odd_background value="<?php echo $color['table']['odd_background']?>"  placeholder="<?php echo self::$language['color_set']['background_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['odd']?><?php echo self::$language['color_set']['text']?>:<input type="text" mc=odd_text value="<?php echo $color['table']['odd_text']?>"   placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
			<br />
        	<div class=item><?php echo self::$language['color_set']['even']?><?php echo self::$language['color_set']['background']?>:<input type="text" mc=even_background value="<?php echo $color['table']['even_background']?>"  placeholder="<?php echo self::$language['color_set']['background_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['even']?><?php echo self::$language['color_set']['text']?>:<input type="text" mc=even_text value="<?php echo $color['table']['even_text']?>"   placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
			<br />
        	<div class=item>hover<?php echo self::$language['color_set']['background']?>:<input type="text" mc=hover_background value="<?php echo $color['table']['hover_background']?>"  placeholder="<?php echo self::$language['color_set']['background_placeholder']?>" /> <input type="color" /></div>
        	<div class=item>hover<?php echo self::$language['color_set']['text']?>:<input type="text" mc=hover_text value="<?php echo $color['table']['hover_text']?>"   placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
            
        </fieldset>
        
   
   		<fieldset parent="page"><legend><?php echo self::$language['color_set']['page']?></legend>
        	<div class=item><?php echo self::$language['color_set']['border']?>:<input type="text" mc=border value="<?php echo $color['page']['border']?>"  placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['background']?>:<input type="text" mc=background value="<?php echo $color['page']['background']?>"  placeholder="<?php echo self::$language['color_set']['background_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['text']?>:<input type="text" mc=text value="<?php echo $color['page']['text']?>"   placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
        	
            <div class=item>hover<?php echo self::$language['color_set']['background']?>:<input type="text" mc=hover_background value="<?php echo $color['page']['hover_background']?>"  placeholder="<?php echo self::$language['color_set']['background_placeholder']?>" /> <input type="color" /></div>
            
        	<div class=item><?php echo self::$language['color_set']['current']?><?php echo self::$language['color_set']['background']?>:<input type="text" mc=current_background value="<?php echo $color['page']['current_background']?>"  placeholder="<?php echo self::$language['color_set']['background_placeholder']?>" /> <input type="color" /></div>
        	<div class=item><?php echo self::$language['color_set']['current']?><?php echo self::$language['color_set']['text']?>:<input type="text" mc=current_text value="<?php echo $color['page']['current_text']?>"   placeholder="<?php echo self::$language['color_set']['color_placeholder']?>" /> <input type="color" /></div>
            
            
        </fieldset>
    </div>
	<a href="#" class=submit><?php echo self::$language['submit']?></a> <span class=state></span>
</div>
