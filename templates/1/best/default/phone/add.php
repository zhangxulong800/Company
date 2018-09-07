<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .quantity").change(function(){
			quantity=$(this).val();
			exist=($("#<?php echo $module['module_name'];?> .paragraph").length-1);
			v=quantity-exist;
			if(v==0){return false;}
			if(v>0){
				html='';
				for(i=exist;i<quantity;i++){
					html+='<div class=paragraph><span class=m_label><input type="text" class=p_title placeholder="<?php echo self::$language['paragraph'];?><?php echo self::$language['title']?>" /></span><span class=m_input><input type="hidden" class=p_content value=0 /><a href=# class=p_content_button><?php echo self::$language['content']?></a><span class=move></span></span></div>';
				}
				$("#<?php echo $module['module_name'];?> .content_div").append(html);
			}else{
				
				$("#<?php echo $module['module_name'];?> .paragraph").each(function(index, element) {
					//alert(index+'>'+v);
                    if(index>quantity){$(this).remove();}
                });	
			}
			
			$( ".content_div" ).sortable({
			  connectWith: ".content_div"
			}).disableSelection();	
		});
		
		
		$(document).on('click','#<?php echo $module['module_name'];?> .p_content_button',function(){
			index=($(this).parent().parent().index());
			id=$(this).prev('input').val();
			set_iframe_position($(window).width()-100,$(window).height()-20);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','./index.php?monxin=best.paragraph&id='+id+'&index='+index);
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> #submit").click(function(){
			var type=$("#<?php echo $module['module_name'];?> #type");
			var title=$("#<?php echo $module['module_name'];?> #title");
			if(type.prop('value')<1){monxin_alert('<?php echo self::$language['please_select']?><?php echo self::$language['belong']?>');type.focus();return false;}
			if(title.prop('value')==''){monxin_alert('<?php echo self::$language['please_input']?><?php echo self::$language['title']?>');title.focus();return false;}
			paragraph_title=new Object();
			paragraph_content=new Object();
			$("#<?php echo $module['module_name'];?> .paragraph").each(function(index, element) {
                if($(this).children('.m_label').children('.p_title').val()!=''){
					paragraph_title[index]=$(this).children('.m_label').children('.p_title').val();
					paragraph_content[index]=$(this).children('.m_input').children('.p_content').val();
				}
            });
			
			$("#<?php echo $module['module_name'];?> #submit").next('.state').html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=add',{type:type.prop('value'),title:title.prop('value'),link:$("#<?php echo $module['module_name'];?> #link").val(),key:$("#<?php echo $module['module_name'];?> #key").val(),paragraph_title:paragraph_title,paragraph_content:paragraph_content}, function(data){
				//alert(data);
				v=eval("("+data+")");
				$("#<?php echo $module['module_name'];?> #submit").next('.state').html(v.info);
				if(v.url){window.location.href=v.url;}
			});
			return false;	
		});
    });
    
	function set_p_id(id,index){
		if($("#<?php echo $module['module_name'];?> .p_content[value="+id+"]").val()==id){return true;}
		$("#<?php echo $module['module_name'];?> .content_div .paragraph").eq(index).children('.m_input').children('.p_content').val(id);	
	}
    </script>
    
    
    
    
    <style>
    #<?php echo $module['module_name'];?>_html{ padding:20px;}
    #<?php echo $module['module_name'];?> #parent{}
    #<?php echo $module['module_name'];?> #title{ width:600px;}
    #<?php echo $module['module_name'];?> #link{ width:600px;}
    #<?php echo $module['module_name'];?> #key{ width:600px;}
    #<?php echo $module['module_name'];?> .quantity{ width:3rem; text-align:center;}
    #<?php echo $module['module_name'];?> .content_div{}
	#<?php echo $module['module_name'];?> .content_div .paragraph{  line-height:3rem;white-space:nowrap;}
	#<?php echo $module['module_name'];?> .content_div .paragraph .m_label{ display:inline-block; vertical-align:top; width:70%; text-align:left;}
	#<?php echo $module['module_name'];?> .content_div .paragraph .m_input{display:inline-block; vertical-align:top; text-align:left;margin-left:5px;white-space:nowrap; }
	#<?php echo $module['module_name'];?> .content_div .paragraph .p_title{ width:100%;}
	#<?php echo $module['module_name'];?> .content_div .paragraph .p_content_button{}
	#<?php echo $module['module_name'];?> .content_div .paragraph .p_content_button:hover{ font-weight:bold; }
	#<?php echo $module['module_name'];?> .content_div .paragraph .p_content_button:before{font: normal normal normal 1rem/1 FontAwesome;margin-right:2px;content: "\f044";}
	#<?php echo $module['module_name'];?> .content_div .paragraph .move{ float:right; cursor:move; width:5rem; text-align:center;}
	#<?php echo $module['module_name'];?> .content_div .paragraph .move:before{font: normal normal normal 1rem/1 FontAwesome;margin-right:2px;content: "\f047";}
	
	
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">
      <?php echo self::$language['belong'];?>：<select id="type" name="type">
      <option value="-1"><?php echo self::$language['please_select']?></option>
      <?php echo $module['parent'];?></select> <a href="index.php?monxin=best.type"><?php echo self::$language['create']?></a><br /><br />
      <?php echo self::$language['title'];?>：<input type="text" name="title" id="title" /><br /><br />
      <?php echo self::$language['link'];?>：<input type="text"  placeholder="<?php echo self::$language['link_notice']?>" name="link" id="link" /><br /><br />
      <?php echo self::$language['key'];?>：<input type="text"  placeholder="<?php echo self::$language['key_notice']?>" name="key" id="key"  /><br /><br />
      <?php echo self::$language['paragraph'];?>：<input type="text" class=quantity /> <?php echo self::$language['a']?><hr />
      <div class=content_div>
      	<div class=paragraph><span class=m_label><?php echo self::$language['paragraph'];?><?php echo self::$language['title']?></span><span class=m_input><?php echo self::$language['paragraph'];?><?php echo self::$language['content']?></span></div>
      	
        
      </div>
    <br />
    
    
    <a name="submit" id="submit" class=submit href=# ><?php echo self::$language['submit']?></a><span class=state></span>
    </div>
</div>

