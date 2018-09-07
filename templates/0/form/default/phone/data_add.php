<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?>").height($(window).height()-<?php echo $module['data']['css_pc_top_int']?>+100);
		
		$("#<?php echo $module['module_name'];?> select").each(function(index, element) {
            if($(this).attr('monxin_value')){$(this).val($(this).attr('monxin_value'));}
        });
		$("#<?php echo $module['module_name'];?> monxin_radio").each(function(index, element) {
            if($(this).attr('monxin_value')){
				$("#"+$(this).attr('id')+' input[value="'+$(this).attr('monxin_value')+'"]').prop('checked',true);	
			}
        });
		$("#<?php echo $module['module_name'];?> monxin_checkbox").each(function(index, element) {
            if($(this).attr('monxin_value')){
				temp=$(this).attr('monxin_value').split('/');
				for(v in temp){
					$("#"+$(this).attr('id')+' input[value="'+temp[v]+'"]').prop('checked',true);	
				}
			}
        });
		$("monxin_radio input").click(function(){
			$(this).parent('monxin_radio').val($(this).val());	
			
		});
		$("monxin_checkbox input").click(function(){
			id=$(this).parent('monxin_checkbox').attr('id');
			v='';
			$("#"+id+" input").each(function(index, element) {
                if($(this).prop('checked')){v+=$(this).val()+'/';}
            });
			$("#"+id).val(v);
		});
		$("#<?php echo $module['module_name'];?>_html input").keydown(function(event){
			if(event.keyCode==13 && event.target.tagName!='TEXTAREA'){return exe_monxin_form_submit();}		  	
		});
		$("#<?php echo $module['module_name'];?> #submit").click(function(){
			exe_monxin_form_submit();
			return false;
		});
		
        $("input[type='radio']").css('border','none');
        $("input[type='checkbox']").css('border','none');
		
		
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			t=$("#monxin_iframe").attr('src');
			t=t.split('?id=');
			t=t[1].split('&');
			t=t[0];
			temp=getCookie('map_'+t);
			if(temp){
				$("#<?php echo $module['module_name'];?> #"+t).val(getCookie('map_'+t).replace(/%2C/g,','));
			}
			return false;
		});
		$("#<?php echo $module['module_name'];?> input[monxin_type='map']").focus(function(){
			set_iframe_position(800,500);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','http://<?php echo $module['map_api'];?>.monxin.com/get_point.php?id='+$(this).attr('id')+'&point='+$(this).val());
			return false;	
		});
		
    });
    
	function exe_monxin_form_submit(){
			err=false;
			try{if(editor){editor.sync();}}catch(e){}
			
			
			$("#<?php echo $module['module_name'];?> span").each(function(index, element) {
                if($(this).html()=='<?php echo self::$language['is_null'];?>' || $(this).html()=='<?php echo self::$language['not_match'];?>' || $(this).html()=='<?php echo self::$language['exist_same'];?>'){$(this).html('');}
            });
			$("#<?php echo $module['module_name'];?> span[class='state']").each(function(index, element) {
               $(this).html('');
            });
			var obj=new Object();
			$(".monxin_input").each(function(index, element){
				if($(this).prop('value')==undefined){$(this).prop('value','');}
				if( $(this).prop('value')=='' && $(this).attr('monxin_required')==='1'){$("#"+$(this).attr('id')+'_state').html('<span class=fail><?php echo self::$language['is_null'];?></span>');$(this).focus();err=true;return false;}
				if($(this).attr('check_reg')!=''  && $(this).attr('monxin_required')==='1'){
temp=$(this).attr('check_reg');
　　					if($(this).prop('value').match(eval(temp))==null){$("#"+$(this).attr('id')+'_state').html('<span class=fail><?php echo self::$language['not_match'];?></span>');$(this).focus();err=true;return false;}
				}
               obj[$(this).attr('id')]=$(this).prop('value');
			   //alert($(this).attr('id'));
            });
			if(err){return false;}
			//return false;
			
			$("#<?php echo $module['module_name'];?> #submit").next('span').html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post("<?php echo $module['action_url'];?>&act=add",obj,function(data){
				$("#<?php echo $module['module_name'];?> #submit").next('span').html('');
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				if(v.state=='fail'){
					if(v.id){
						$("#"+v.id).focus();
						$("#"+v.id+'_state').html(v.info);	
					}else{
						$("#<?php echo $module['module_name'];?> #submit").next('span').html(v.info);
					}
				}else{
					$("#<?php echo $module['module_name'];?>_html").css('text-align','center');
					$("#<?php echo $module['module_name'];?>_html").html(v.info);
				}
	
			});	
	}
        
    </script>
    <script src="./plugin/datePicker/index.php"></script>
	<?php echo $module['data']['css_diy']?>
	<style>
	<?php echo $module['data']['bg_css']?>  
   
	.page-content{ background:none !important;}
	
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?> #gender input{ }
	#<?php echo $module['module_name'];?> #authcode_img{ height:25px;}
    #<?php echo $module['module_name'];?> div{ line-height:3rem; white-space:nowrap;}
    #<?php echo $module['module_name'];?> .m_label{ display:inline-block; width:14%; text-align:right; overflow:hidden; padding-right:5px; }
	#<?php echo $module['module_name'];?> .m_label .required{ color:red; }
    #<?php echo $module['module_name'];?> .input_span{ display:inline-block; width:82%; overflow:hidden; white-space:normal;}
    #<?php echo $module['module_name'];?> legend{ }
	#<?php echo $module['module_name'];?> .form_title_div{border-bottom:1px solid #ccc; margin-bottom:10px; width:100%;}
	#<?php echo $module['module_name'];?> .form_title{font-size:20px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
	<div class=form_title_div ><span class=m_label> </span><span class=input_span><div class=form_title><?php echo $module['data']['description']?></div></span></div>    
    <?php echo $module['fields'];?>
	<div><span class=m_label> </span><span class=input_span><a href="#" id=submit class="submit"><span class=b_start> </span><span class=b_middle><?php echo self::$language['submit'];?></span><span class=b_end> </span></a> <span></span></span></div>    
    </div>
    <br /><br /><br /><br />
</div>
