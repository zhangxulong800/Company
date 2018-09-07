<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script charset="utf-8" src="editor/kindeditor.js"></script>
    <script charset="utf-8" src="editor/create.php?id=detail&program=<?php echo $module['class_name'];?>&language=<?php echo $module['web_language'];?>&items=emoticons|image|multiimage|media|insertfile"></script>
	<script>
	var new_msg_inter;
	function add_addressee_dom(id,name){
	   $("#<?php echo $module['module_name'];?> .talk_log_div").prepend('<div class="talk_log" id="log_'+id+'" ids=""></div>');
	   $("#<?php echo $module['module_name'];?> .talk_addressee .list").prepend('<div class="addressee selected" id="a_'+id+'"  online=1><a hef="#" class="user_icon"><img src="./program/index/user_icon/default.png"></a><div class="user_info"><a class="u_name">'+name+'</a><span class="u_last"></span></div><div class="time_act"><span class="time"></span><div class="user_act"><a class="del"></a><input type="checkbox" class="u_checkbox"></div></div></div>');
	}
	
	function get_addressee_ids(){
		ids='';
		$("#<?php echo $module['module_name'];?> .list .selected").each(function(index, element) {
            ids+=$(this).attr('id').replace('a_','')+',';
        });
		return ids;
	}
	
	function set_addressee(){
		var addressee_ids='';
		var addressee_name='';
		$("#<?php echo $module['module_name'];?> .list .selected").each(function(index, element) {
           addressee_ids+=$(this).attr('id').replace('a_','')+',';
		   id=$(this).attr('id');
           addressee_name+=$("#<?php echo $module['module_name'];?> #"+id+" .u_name").html()+',';    
        });
		
		$("#<?php echo $module['module_name'];?> .talk_top .with").html(addressee_name.substr(0,addressee_name.length-1));
		$("#<?php echo $module['module_name'];?> .talk_top .with").attr('addressee_ids',addressee_ids);
		
		$("#<?php echo $module['module_name'];?> .talk_log_div .talk_log").css('display','none');
		if($("#<?php echo $module['module_name'];?> .list .selected").length==1){
			id=$("#<?php echo $module['module_name'];?> .list .selected").attr('id').replace('a_','');
			$("#<?php echo $module['module_name'];?> .talk_log_div #log_"+id).css('display','block');
			update_info_stete(id);
			
		}else{
			$("#<?php echo $module['module_name'];?> .talk_log_div #batch_send").css('display','block');
		}
		$("#<?php echo $module['module_name'];?> .talk_log_div").scrollTop(100000000000); 
		//editor.focus();
	}
	
	function update_info_stete(id){
		ids=$("#<?php echo $module['module_name'];?> .talk_log_div #log_"+id).attr('ids');
		$.post('<?php echo $module['action_url'];?>&act=update_info_stete',{ids:ids},function(data){
			//console.log(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			if(v.state=='success'){
				r=parseInt($("#<?php echo $module['module_name'];?> .talk_addressee #a_"+id+" .new_sum").html())-v.effect;
				$("#<?php echo $module['module_name'];?> .talk_addressee #a_"+id+" .new_sum").html(r);
				if(r<1){$("#<?php echo $module['module_name'];?> .talk_addressee #a_"+id+" .new_sum").remove();}
			}
		});
	}
	
	function unset_addressee(){
		$("#<?php echo $module['module_name'];?> .list .selected").each(function(index, element) {
           id=$(this).attr('id');
		    if(!$("#<?php echo $module['module_name'];?> #"+id+" .u_checkbox").prop('checked')){$(this).removeClass('selected');}
        });
	}
	
    $(document).ready(function(){
		addressee=<?php echo $module['addressee'];?>;
		//addressee=parseJSON(addressee);
		str='';
		for(i in addressee){
			if(addressee[i]['icon']!=''){
				if(addressee[i]['icon'].indexOf('http')!==0){
					addressee[i]['icon']='./program/index/user_icon/'+addressee[i]['icon'];
				}	
			}else{
				addressee[i]['icon']='./program/index/user_icon/default.png';
			}
			if(addressee[i]['new']==0){
				addressee[i]['new']='';
			}else{
				addressee[i]['new']='<div class=new_sum>'+addressee[i]['new']+'</div>';
			}
			if(addressee[i]['last_msg']==''){addressee[i]['last_msg']='&nbsp;';}
			
			str+='<div class=addressee id=a_'+addressee[i]['id']+'  online='+addressee[i]['online']+'><a hef=# class="user_icon"><img src="'+addressee[i]['icon']+'" /></a><div class=user_info><a class=u_name>'+addressee[i]['name']+'</a><span class=u_last>'+addressee[i]['last_msg']+'</span></div>'+addressee[i]['new']+'<div class=time_act><span class=time>'+addressee[i]['last_time']+'</span><div class=user_act><a class=set_blacklist title="<?php echo self::$language['join']?><?php echo self::$language['blacklist']?>"></a><a class=del title="<?php echo self::$language['clear_log']?>"></a><input type=checkbox class=u_checkbox /></div></div></div>';
		}
		$("#<?php echo $module['module_name'];?> .talk_addressee .list").html(str);
		
		
		
		$(document).on('click',"#<?php echo $module['module_name'];?> .list  .addressee .user_act .del",function(){
			if(confirm("<?php echo self::$language['are_you_sure_you_want_it_cleaned']?>")){
				id=$(this).parent().parent().parent().attr('id').replace('a_','');
				$.post('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					if(v.state=='success'){
						$("#<?php echo $module['module_name'];?> #log_"+id).html('');
						$("#<?php echo $module['module_name'];?> #a_"+id+' .u_last').html('');
						$("#<?php echo $module['module_name'];?> #a_"+id+' .new_sum').remove();
						$("#<?php echo $module['module_name'];?> .talk_addressee .addressee:last").after($("#<?php echo $module['module_name'];?> .talk_addressee #a_"+id)); 
						/*
						$("#<?php echo $module['module_name'];?> .talk_top .with").attr('addressee_ids',$("#<?php echo $module['module_name'];?> .talk_top .with").attr('addressee_ids').replace(''+id+',',''));
						$("#<?php echo $module['module_name'];?> .talk_top .with").html($("#<?php echo $module['module_name'];?> .talk_top .with").html().replace($("#<?php echo $module['module_name'];?> #a_"+id+' .u_name').html(),''));
						$("#<?php echo $module['module_name'];?> #a_"+id).remove();
						$("#<?php echo $module['module_name'];?> #log_"+id).remove();
						*/
					}
				});
			}
			set_addressee();
			return false;
		});
		
		$(document).on('click',"#<?php echo $module['module_name'];?> .list  .addressee .user_act .set_blacklist",function(){
				id=$(this).parent().parent().parent().attr('id').replace('a_','');
				$.post('<?php echo $module['action_url'];?>&act=set_blacklist',{id:id}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					if(v.state=='success'){
						$("#<?php echo $module['module_name'];?> .talk_top .with").attr('addressee_ids',$("#<?php echo $module['module_name'];?> .talk_top .with").attr('addressee_ids').replace(''+id+',',''));
						$("#<?php echo $module['module_name'];?> .talk_top .with").html($("#<?php echo $module['module_name'];?> .talk_top .with").html().replace($("#<?php echo $module['module_name'];?> #a_"+id+' .u_name').html(),''));
						
						$("#<?php echo $module['module_name'];?> #blacklist_div tbody tr:last").after("<tr id='tr_"+id+"'><td>"+$("#<?php echo $module['module_name'];?> #a_"+id+' .u_name').html()+"</td><td class=operation_td><a href='#'  class='remove'><?php echo self::$language['remove'];?><?php echo self::$language['blacklist']?></a> <span id=state_"+id+" class='state'></span></td></tr>");
						
						$("#<?php echo $module['module_name'];?> #a_"+id).remove();
						$("#<?php echo $module['module_name'];?> #log_"+id).remove();
						
						
					}
				});
			set_addressee();
			return false;
		});
		
		$(document).on('click',"#<?php echo $module['module_name'];?> #blacklist_div  .remove",function(){
			id=$(this).parent().parent().attr('id').replace('tr_','');
			$.post('<?php echo $module['action_url'];?>&act=unset_blacklist',{id:id}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				if(v.state=='success'){
					add_addressee_dom(id,$("#<?php echo $module['module_name'];?> #tr_"+id+' td:first').html());
					$("#<?php echo $module['module_name'];?> #tr_"+id).remove();
				}
			});
			return false;
		});
		
		$(document).on('click',"#<?php echo $module['module_name'];?> .batch_div .del_stop",function(){
			ids=get_addressee_ids();
			if(ids==''){alert('<?php echo self::$language['please_select']?>');return false;}
			if(confirm("<?php echo self::$language['delete_confirm']?>")){
				$.post('<?php echo $module['action_url'];?>&act=del_selected',{ids:ids}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					if(v.state=='success'){
						success=v.ids.split("|");
						for(id in ids){
							//monxin_alert(ids[id]);
							if(in_array(ids[id],success)){
								$("#<?php echo $module['module_name'];?> #a_"+ids[id]).remove();
							}	
						}
					}
				});
			}
			set_addressee();
			return false;
		});
		$(document).on('click',"#<?php echo $module['module_name'];?> .list  .addressee .u_checkbox",function(){
			
			if($(this).prop('checked')){
				$(this).parent().parent().parent().addClass('selected');
			}else{
				$(this).parent().parent().parent().removeClass('selected');
			}
			set_addressee();
		});
		
		$(document).on('click',"#<?php echo $module['module_name'];?> .list  .addressee .user_info",function(){
			unset_addressee();
			if($(this).parent('.selected').attr('id')){
				$(this).parent().removeClass('selected');
			}else{
				$(this).parent().addClass('selected');
			}
			
			set_addressee();
		});
		$(document).on('click',"#<?php echo $module['module_name'];?> .list  .addressee .user_icon",function(){
			unset_addressee();
			$(this).parent().addClass('selected');
			set_addressee();
		});
		
		
		$("#<?php echo $module['module_name'];?> .select_all").click(function(){
			if($(this).prop('checked')){
				$("#<?php echo $module['module_name'];?> .list  .addressee").addClass('selected');
				$("#<?php echo $module['module_name'];?> .list  .addressee .u_checkbox").prop('checked',true);
			}else{
				$("#<?php echo $module['module_name'];?> .list  .addressee").removeClass('selected');
				$("#<?php echo $module['module_name'];?> .list  .addressee .u_checkbox").prop('checked',false);
			}
			set_addressee();
		});
		
		$("#<?php echo $module['module_name'];?> .new_address").keydown(function(event){
			if(event.keyCode==13){$("#<?php echo $module['module_name'];?> .add_address").trigger('click');}
		});
		
		$("#<?php echo $module['module_name'];?> .add_address").click(function(){
			v=$("#<?php echo $module['module_name'];?> .new_address").val();
            if(v!=''){
				$(this).next().html('');
				$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.post('<?php echo $module['action_url'];?>&act=add_address',{username:v}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					
					$("#<?php echo $module['module_name'];?> .add_address").next().html(v.info);
					if(v.state=='success'){
						add_addressee_dom(v.new_id,$("#<?php echo $module['module_name'];?> .new_address").val());
					}else{
						
					}
					
				});
				return false;	
			}
        });
		
		$("#<?php echo $module['module_name'];?> .add_new").click(function(){
			$('#add_div').modal({  
			   backdrop:true,  
			   keyboard:true,  
			   show:true  
			});  
			$("#add_div").css('margin-top',($(window).height()/5));		
			return false;
		});
		
		
		$("#<?php echo $module['module_name'];?> .blacklist").click(function(){
			$('#blacklist_div').modal({  
			   backdrop:true,  
			   keyboard:true,  
			   show:true  
			});  
			$("#blacklist_div").css('margin-top',($(window).height()/5));		
			return false;
		});
		
		
		
		$("#<?php echo $module['module_name'];?> .search").keyup(function(){
			key=$(this).val();
			if(key==''){
				$("#<?php echo $module['module_name'];?> .talk_addressee .list .addressee").css('display','block');
			}else{
				$("#<?php echo $module['module_name'];?> .talk_addressee .list .addressee").each(function(index, element) {
					if($(this).children('.user_info').children('.u_name').html().indexOf(key)!=-1){
						$(this).css('display','block');
					}else{
						$(this).css('display','none');
					}
				});
			}
		});
		
		$("#<?php echo $module['module_name'];?> .view_more a").click(function(){
			if($("#<?php echo $module['module_name'];?> .list .selected").length==1){
				current_id=$("#<?php echo $module['module_name'];?> .list .selected").attr('id');
				id=current_id.replace('a_','');
				if(1==1){
					//alert($("#log_"+id+' .no_log').attr('class'));
					if(!$("#log_"+id+' .no_log').attr('class')){
						info_id=$("#log_"+id+" .info:first").attr('id');
						if(info_id){
							info_id=info_id.replace('info_','');
							$.post('<?php echo $module['action_url'];?>&act=get_log',{id:id,info_id:info_id},function(data){
								if(data==''){$("#<?php echo $module['module_name'];?> #log_"+id+" .view_more").css('display','none');}
								$("#<?php echo $module['module_name'];?> .talk_log_div #log_"+id+" .time:first").before(data); 
								effect=$("#<?php echo $module['module_name'];?> .talk_log_div #log_"+id+" .effect").attr('effect');
								$("#<?php echo $module['module_name'];?> .talk_log_div #log_"+id+" .effect").remove();
								r=parseInt($("#<?php echo $module['module_name'];?> .talk_addressee #a_"+id+" .new_sum").html())-effect;
								$("#<?php echo $module['module_name'];?> .talk_addressee #a_"+id+" .new_sum").html(r);
								if(r<1){$("#<?php echo $module['module_name'];?> .talk_addressee #a_"+id+" .new_sum").remove();}
							});
						}	
						
					}
				}
			}
		});
		$("#<?php echo $module['module_name'];?> .close_talk_iframe").click(function(){
			parent.close_talk_iframe();
			return false;
		});
			
		$("#<?php echo $module['module_name'];?> .send").click(function(){
           	editor.sync();
					
			ids=$("#<?php echo $module['module_name'];?> .talk_top .with").attr('addressee_ids'); 
			msg=$("#<?php echo $module['module_name'];?> #detail").val(); 
			editor.html('');
			if(msg==''){return false;}
			if(ids==''){alert('<?php echo self::$language['please_select']?><?php echo self::$language['user']?>');return false;} 
		    str='<div class=me><div class=c><span class=content>'+msg+'</span><span class=horn></span></div><a class=icon><img src="<?php echo $module['my_icon'];?>" /></a></div>';
			
			if($("#<?php echo $module['module_name'];?> .list .selected").length==1){
				$("#<?php echo $module['module_name'];?> .talk_log_div #log_"+$("#<?php echo $module['module_name'];?> .list .selected").attr('id').replace('a_','')).append(str); 
				
				$("#<?php echo $module['module_name'];?> .talk_log_div").scrollTop($("#<?php echo $module['module_name'];?> .talk_log_div #log_"+$("#<?php echo $module['module_name'];?> .list .selected").attr('id').replace('a_','')).height()); 
			}else{
				$("#<?php echo $module['module_name'];?> .talk_log_div #batch_send").append(str); 
				$("#<?php echo $module['module_name'];?> .talk_log_div").scrollTop($("#<?php echo $module['module_name'];?> .talk_log_div #batch_send").height()); 
			}
			
			
			$.post('<?php echo $module['action_url'];?>&act=send',{ids:ids,msg:msg},function(data){
               try{v=eval("("+data+")");}catch(exception){console.log(data);}
				//console.log(data);
				if(v.state=='fail'){					
					if($("#<?php echo $module['module_name'];?> .list .selected").length==1){
						temp=ids.split(',');
						for(i in temp){
							$("#<?php echo $module['module_name'];?> #log_"+temp[i]+" .me:last").html($("#<?php echo $module['module_name'];?> #log_"+temp[i]+" .me:last").html()+v.info);
						}						
					}else{
						$("#<?php echo $module['module_name'];?> .talk_log_div #batch_send .me:last").html($("#<?php echo $module['module_name'];?> .talk_log_div #batch_send .me:last").html()+v.info); 
					}
				}
				
				if(v.fails!=''){
					temp=v.fails.split('|');
					for(i in temp){
						$("#<?php echo $module['module_name'];?> #log_"+temp[i]+" .me:last").html($("#<?php echo $module['module_name'];?> #log_"+temp[i]+" .me:last").html()+' <span class=black_notice><?php echo self::$language['black_notice']?></span>');
					}
				}
				
                
            });
			return false;
		});
		
			
			
		setInterval("bundenter()",100);
        setTimeout("editor.focus()",1000);
       new_msg_inter=setInterval("get_new_msg()",500);
		
		
		if(get_param('with')){
			$("#<?php echo $module['module_name'];?> .talk_addressee .addressee").each(function(index, element) {
                id=$(this).attr('id');
				if($("#<?php echo $module['module_name'];?> #"+id+" .u_name").html()=='<?php echo @$_GET['with']?>'){
					$("#<?php echo $module['module_name'];?> #"+id+" .u_name").trigger('click');
				}
            });
			
		}else{
			$("#<?php echo $module['module_name'];?> .talk_addressee .list .addressee:first-child .user_info").trigger('click');
		}
    });
	
	function bundenter(){
		editor.sync();
		msg=$("#<?php echo $module['module_name'];?> #detail").val(); 
		if(msg.indexOf('<br />')!==-1){
			$("#<?php echo $module['module_name'];?> .send").trigger('click');
		}
	}
	
	function get_new_msg(){
		$.get('<?php echo $module['action_url'];?>&act=get_new_msg&load_time=<?php echo $module['load_time'];?>',function(data){
			////
			//console.log(data);
			if(data=='<?php echo self::$language['act_noPower']?>'){window.location.href='./index.php?monxin=im.talk';}
		   try{v=eval("("+data+")");}catch(exception){console.log(data);}
		   if(v.info=='<span class=fail>token err</span>'){
			  if($("body").attr('iframe')==1){parent.close_talk_iframe(1);}else{clearInterval(new_msg_inter);}
			 }
		   for(i in v){
			   $("#notice_audio").attr('src','./program/im/new.wav').removeAttr('loop');
			   if(!$("#<?php echo $module['module_name'];?> .talk_log_div #log_"+v[i]['id']).attr('id')){
				   $("#<?php echo $module['module_name'];?> .talk_log_div").prepend('<div class="talk_log" id="log_'+v[i]['id']+'" ids="'+v[i]['ids']+'"></div>');
				   $("#<?php echo $module['module_name'];?> .talk_addressee .list").prepend('<div class="addressee selected" id="a_'+v[i]['id']+'"  online=1><a hef="#" class="user_icon"><img src="'+v[i]['icon']+'"></a><div class="user_info"><a class="u_name">'+v[i]['addressee']+'</a><span class="u_last">'+v[i]['last_msg']+'</span></div><div class="new_sum">'+v[i]['msg_sum']+'</div><div class="time_act"><span class="time">'+v[i]['last_time']+'</span><div class="user_act"><a class="del"></a><input type="checkbox" class="u_checkbox"></div></div></div>');
				   
				}else{
					$("#<?php echo $module['module_name'];?> .talk_log_div #log_"+v[i]['id']).attr('ids', $("#<?php echo $module['module_name'];?> .talk_log_div #log_"+v[i]['id']).attr('ids')+','+v[i]['ids']);
					$("#<?php echo $module['module_name'];?> .talk_addressee #a_"+v[i]['id']+'').attr('online',1);
					$("#<?php echo $module['module_name'];?> .talk_addressee #a_"+v[i]['id']+' .time').html(v[i]['last_time']);
					$("#<?php echo $module['module_name'];?> .talk_addressee #a_"+v[i]['id']+' .u_last').html(v[i]['last_msg']);
					if(!$("#<?php echo $module['module_name'];?> .talk_addressee #a_"+v[i]['id']+' .new_sum').attr('class')){
						
						 $('<div class=new_sum>0</div>').insertBefore("#<?php echo $module['module_name'];?> .talk_addressee #a_"+v[i]['id']+" .time_act");
					}
					$("#<?php echo $module['module_name'];?> .talk_addressee #a_"+v[i]['id']+' .new_sum').html(parseInt($("#<?php echo $module['module_name'];?> .talk_addressee #a_"+v[i]['id']+' .new_sum').html())+v[i]['msg_sum']);
					$("#<?php echo $module['module_name'];?> .talk_addressee .addressee:first").before($("#<?php echo $module['module_name'];?> .talk_addressee #a_"+v[i]['id'])); 
					
				}
			   
			   $("#<?php echo $module['module_name'];?> .talk_log_div #log_"+v[i]['id']).append(v[i]['msg']); 
			   $("#<?php echo $module['module_name'];?> .talk_log_div").scrollTop($("#<?php echo $module['module_name'];?> .talk_log_div #log_"+v[i]['id']).height()); 
			   if($("#<?php echo $module['module_name'];?> #log_"+v[i]['id']).css('display')=='block'){
				  // $("#<?php echo $module['module_name'];?> .talk_addressee #a_"+v[i]['id']+' .new_sum').remove();
				}
				if(parent.monxin_iframe_is_open()==false){
					parent.flash_im_talk_show();	
				}
			   
			}
			
		});
	}
    </script>
    <style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?>_html .talk_out_div{ width:60%; margin:auto; border:1px solid rgba(121,150,197,1);overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_top{ text-align:left; padding-left:10px; font-weight:bold; background-color:<?php echo $_POST['monxin_user_color_set']['nv_3']['background']?>; color:#fff; line-height:3rem;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_top .with{ display:inline-block; vertical-align:top; max-width:60%; overflow:hidden; white-space: nowrap; text-overflow: ellipsis;}
	
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body{}
	
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee{display:inline-block; vertical-align:top; width:35%; overflow:hidden; background:rgba(252,252,252,1);}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .list{ height:350px; overflow:scroll;overflow-x:hidden; }
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee{ position:relative; cursor:default;  padding-left:8px;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .current{ position:relative; background:rgba(237,229,229,1.00); cursor:default;  padding-left:8px;}

	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_icon{ display:inline-block; vertical-align:top; width:20%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_icon img{ width:90%; border-radius:5px; margin-top:2px;margin-bottom:2px;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_info{display:inline-block; vertical-align:top; width:50%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_info .u_name{ display:block;overflow:hidden; white-space: nowrap; text-overflow: ellipsis;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_info .u_last{display:block; font-size:0.9rem; opacity:0.7;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .new_sum{ width:1.2rem; height:1.2rem; line-height:1.2rem;  text-align:center;  position:absolute; top:0px;left:5px; background-color:red; color:#fff; border-radius:50%; font-size:0.8rem; padding:1px;} 
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .time_act{ width:30%; white-space:nowrap;  position:absolute; top:0px;right:5px; text-align: right;} 
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .time_act .user_act{ display:none;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee:hover{  background:rgba(237,237,237,1.00);}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee:hover .time_act .user_act{ display:block;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .time_act .time{display:block; font-size:0.8rem; opacity:0.5;}
	
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_act .set_blacklist{ cursor:pointer; }
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_act .set_blacklist:before {font: normal normal normal 1rem/1 FontAwesome;content:"\f070";  margin-right:5px; background:#E5A824; color:#fff; padding:3px; }
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_act .set_blacklist:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_act .del{ cursor:pointer; }
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_act .del:before {font: normal normal normal 1rem/1 FontAwesome;content: "\f014";  margin-right:5px; background:#E5A824; color:#fff; padding:3px; }
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_act .del:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_act .u_checkbox{ cursor:pointer;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .selected{ background:rgba(237,229,229,1.00);}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .selected .time_act .user_act{ display:block;}
	
	
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .batch_div{ text-align:left; padding:5px; padding-right:5px; font-size:0.9rem;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .batch_div .del:before {font: normal normal normal 1rem/1 FontAwesome;content: "\f014";  padding:5px;  cursor:pointer;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .batch_div .add_new{ display:inline-block; vertical-align:top; width:1.5rem; height:1.5rem; line-height:1.5rem; text-align:center; background:rgba(235,235,235,1); cursor:pointer; border-radius:3px; font-weight:bold;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .batch_div .add_new:hover{ background:rgba(239,104,34,1.00); color:#fff;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .batch_div .search{ display:inline-block; vertical-align:top; width:120px; margin-right:5px; height:1.5rem; line-height:1.5rem; border-radius:1rem; background:rgba(235,235,235,1); color:rgba(160,160,160,1);}
	
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main{display:inline-block; vertical-align:top; width:65%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log_div{ padding:10px; background-color:rgba(243,243,243,1); height:220px; overflow:scroll;overflow-x:hidden;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log_div .talk_log{ display:none;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .time{ text-align:center; font-size:0.8rem; color:rgba(139,139,139,1); }
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .info{ white-space:nowrap;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .you{}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .you .icon{ display:inline-block; vertical-align:top; width:6%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .you .icon img{ width:100%; border-radius:5px;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .you .c{ display:inline-block; width:90%; overflow:hidden; white-space:nowrap;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .you .c .horn{}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .you .c .horn:before {font: normal normal normal 18px/1 FontAwesome;margin-right:0px; padding-left:3px;content:"\f0d9";color:rgba(205,215,226,1);	}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .you .c .content{ color:rgba(37,36,36,1); background:rgba(205,215,226,1); border-radius:5px; display:inline-block; vertical-align:top;padding:5px;white-space:normal; max-width:90%; overflow:hidden; text-align:left; }
	
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .me{ text-align:right;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .me .icon{ display:inline-block; width:6%; overflow:hidden;vertical-align:top;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .me .icon img{ width:100%; border-radius:5px;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .me .c{ display:inline-block; width:90%; overflow:hidden; white-space:nowrap;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .me .c .horn{}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .me .c .horn:before {font: normal normal normal 18px/1 FontAwesome;margin-left:0px; padding-right:3px;content:"\f0da";color:rgba(205,215,226,1);	}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .me .c .content{ color:rgba(37,36,36,1); background:rgba(205,215,226,1); border-radius:5px; display:inline-block; vertical-align:top;padding:5px; white-space:normal;text-align:left; max-width:90%; overflow:hidden;}
	
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .c img{ max-width:300px;}
	
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .input_div{}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .input_div .input_c{ display:block; height:5rem; width:100%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .input_div .act_div{ text-align:right; padding-top:5px;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .input_div .act_div .send{ padding-left:10px; padding-right:10px; line-height:2rem; display:inline-block;  vertical-align:top; cursor:pointer; border-radius:2px; border:1px solid #ccc; margin-right:0.8rem;  margin-bottom:4px;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .input_div .act_div .send:hover{ background-color:rgba(121,150,197,1); color:#fff; }
	.view_more{ text-align:center;}
	.view_more a{ cursor:pointer;}
	.view_more a:before {font: normal normal normal 18px/1 FontAwesome;content:"\f141";	}
	.blacklist{ cursor:pointer;}
	.batch_send_notice{ text-align:center; font-size:1.8rem; margin-top:20%;}
	.ke-container{ border:none;}
	.ke-statusbar{ display:none;}
	.operation_td{ text-align:left;}
	.add_address{ cursor:pointer;}
	[online='0'] .user_icon{      -webkit-filter: grayscale(100%);     -moz-filter: grayscale(100%);     -ms-filter: grayscale(100%);     -o-filter: grayscale(100%);          filter: grayscale(100%); 	     filter: gray; }

	[iframe='1'] #<?php echo $module['module_name'];?>_html .talk_out_div{ width:100%;}
	.close_talk_iframe{ float:right; padding-right:10px; cursor:pointer;}
	.close_talk_iframe:before {font: normal normal normal 18px/1 FontAwesome;content:"\f066";}
	#im_talk_show{ display:none;}
	.page-container{ width:100%; overflow:hidden; padding-right:0px;}
	#index_user_position{ display:none;}
	[m_container='m_container']{ padding-left:0px;}
	#html5_up_ele{ display:none;}
    </style>    
	<div id="<?php echo $module['module_name'];?>_html">
		<div class=talk_out_div>
        	<div class=talk_top><?php echo self::$language['with']?> <span class=with addressee_ids=''></span> <?php echo self::$language['dialogue']?> <span class=close_talk_iframe></span></div>
            <div class=talk_body>
            	<div class=talk_addressee>
                    <div class=batch_div><input type=text placeholder="<?php echo self::$language['search']?>" class=search /><a class=add_new title="<?php echo self::$language['add']?>">+</a> <a class=blacklist title="<?php echo self::$language['blacklist']?>"><?php echo self::$language['blacklist']?></a> <?php echo self::$language['select_all'];?><input type="checkbox" class=select_all /></div>
                 	<div class=list>
                        

                    </div>
                    
                </div><div class=talk_main>
                	<div class=talk_log_div>
                    	<?php echo $module['talk_log'];?>
                        <div class=talk_log id=batch_send>
                            <div class=batch_send_notice><?php echo self::$language['mass']?></div>
                        </div>
                            
                    </div>
                	
                    <div class=input_div>
                    	<textarea placeholder="please input ..." class=input_c  name="detail" id="detail" style="display:none; width:100%; height:70px;"></textarea>
                        <div class=act_div><a class=send><?php echo self::$language['send']?>(Enter)</a></div>
                    </div>
                </div>
            </div>
        </div>
        
    
        <!-- 模态框（Modal） -->
        <div class="modal fade" id="add_div" tabindex="-1" role="dialog" 
           aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
              <div class="modal-content">
                 <div class="modal-header">
                    <button type="button" class="close" 
                       data-dismiss="modal" aria-hidden="true">
                          &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                       <b>添加联系人</b>
                    </h4>
                 </div>
                 <div class="modal-body" style=" text-align:center; line-height:50px;">
                    	<input type="text" class=new_address  placeholder="<?php echo self::$language['username']?>/<?php echo self::$language['phone']?>"  /> <a class=add_address><?php echo self::$language['add']?></a> <span clss=state></span>
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-default" 
                       data-dismiss="modal"><?php echo self::$language['close']?>
                    </button>
                    
                 </div>
              </div>
        </div></div>
        
        
        
    
        <!-- 模态框（Modal） -->
        <div class="modal fade" id="blacklist_div" tabindex="-1" role="dialog" 
           aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
              <div class="modal-content">
                 <div class="modal-header">
                    <button type="button" class="close" 
                       data-dismiss="modal" aria-hidden="true">
                          &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                       <b><?php echo self::$language['blacklist']?></b>
                    </h4>
                 </div>
                 <div class="modal-body" style=" text-align:center; line-height:50px;">
                    	
                                        
                    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <td ><?php echo self::$language['username']?></td>
                                <td  style=" width:170px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
                            </tr>
                        </thead>
                        <tbody>
                    <?php echo $module['blacklist']?>
                        </tbody>
                    </table></div>
                                        
                                        
                        
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-default" 
                       data-dismiss="modal"><?php echo self::$language['close']?>
                    </button>
                    
                 </div>
              </div>
        </div></div>
        
                
        
    </div>

</div>
