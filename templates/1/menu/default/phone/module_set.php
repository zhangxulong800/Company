<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$('#bg_file_ele').insertBefore($('#bg'));
		
		$("#<?php echo $module['module_name'];?> #id").val('<?php echo $module['id'];?>');
		$("#<?php echo $module['module_name'];?> #template").val('<?php echo $module['template'];?>');
		$("#<?php echo $module['module_name'];?> #submit").click(function(){
			args='|'+'id:'+$("#<?php echo $module['module_name'];?> #id").val();
			args+='|'+'bg:'+$("#<?php echo $module['module_name'];?> #bg").val().replace(/\./g,'*');
			args+='|'+'template:'+$("#<?php echo $module['module_name'];?> #template").val();
			
			//args=args.replace(/\|/,'');
			
			url='<?php echo $module['action_url'];?>('+args+')';
			//alert(args);
			//return false;
			
			
			
			$(this).next('span').html('<span class=\'fa fa-spinner fa-spin\'></span>');
			
			$.get('<?php echo $module['action_url_img'];?>&act=update_img&old_img='+$("#<?php echo $module['module_name'];?> #bg").attr('old_value')+'&new_img='+$("#<?php echo $module['module_name'];?> #bg").val(),function(data){});
			$.get(url,function(data){
				//alert(data);	
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> #submit").next('span').html(v.info);
                if(v.state=='success'){
					alert('<?php echo self::$language['success'];?>');
                	window.location.href='./index.php?monxin='+get_param('url')+'&edit_page_layout=true&id='+get_param('id');
                }

			});	
			return false;
		});
		
		
		$("#<?php echo $module['module_name'];?> .del").on('click',function(){
			$("#<?php echo $module['module_name'];?> #img").val('');
			$(this).prev().css('display','none');
			$(this).css('display','none');
			return false;
		});
	});
	
	function submit_hidden(id){
		
		$("#<?php echo $module['module_name'];?> #bg").val($("#<?php echo $module['module_name'];?> #"+id).val());
		if($("#<?php echo $module['module_name'];?> .show_img").html()){
			$("#<?php echo $module['module_name'];?> .show_img img").attr('src','./temp/'+$("#<?php echo $module['module_name'];?> #"+id).val());
			$("#<?php echo $module['module_name'];?> .show_img").css('display','inline-block');
			$("#<?php echo $module['module_name'];?> .show_img").next().css('display','inline-block');
			
		}else{
			
			$("<a href='./temp/"+$("#<?php echo $module['module_name'];?> #"+id).val()+"' target=_blank class=show_img><img src='./temp/"+$("#<?php echo $module['module_name'];?> #"+id).val()+"' ></a>").insertAfter("#<?php echo $module['module_name'];?> #bg_file_ele");
		}	
	}
	
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>_html{ padding-top:10px;}
	#<?php echo $module['module_name'];?>_html #img_file_ele{ vertical-align:top; }
	#<?php echo $module['module_name'];?>_html .show_img{ vertical-align:top; }
    #<?php echo $module['module_name'];?>_html .show_img img{ border:none;  }
    #<?php echo $module['module_name'];?>_html .del{vertical-align:top; }
    #<?php echo $module['module_name'];?>_html div{ line-height:60px;}
    #<?php echo $module['module_name'];?> .m_label{ display:inline-block; vertical-align:top; width:20%; text-align:right; padding-right:10px;}
    #<?php echo $module['module_name'];?> #content{}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
   	  <div><span class="m_label"><?php echo self::$language['data_src'];?></span><span class=input_span>
      		<select id="id" name="id" monxin_value="<?php echo $module['id']?>"><?php echo $module['data_src_option'];?></select> <span></span> 
      </span></div> 

      
   	  <div><span class="m_label"><?php echo self::$language['template'];?></span><span class=input_span>
      		<select id="template" name="template" monxin_value="<?php echo $module['template']?>"><?php echo $module['template_option'];?></select><span></span>
      		</span>
      </span></div> 
      
   	  <div><span class="m_label"><?php echo self::$language['bg'];?></span><span class=input_span>
      		<input type="hidden" id="bg" name="bg" old_value="<?php echo @$module['bg'];?>" value="<?php echo @$module['bg'];?>" /> <span></span>
            <?php echo $module['img_show'];?>
      		</span>
      </span></div> 
      
   	  <div><span class="m_label">&nbsp;</span><span class=input_span>
      		<a href="#" id=submit class="submit"><?php echo self::$language['submit'];?></a> <span></span>
      </span></div> 


    </div>
</div>

