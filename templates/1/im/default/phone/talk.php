<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script type="text/javascript" src="./public/jquery.touchSwipe.min.js"></script>
	<script>
	
	var new_msg_inter;
	function add_addressee_dom(id,name){
	   $("#<?php echo $module['module_name'];?> .talk_log_div").prepend('<div class="talk_log" id="log_'+id+'" ids=""></div>');
	   $("#<?php echo $module['module_name'];?> .talk_addressee .list").prepend('<div class="addressee selected" id="a_'+id+'"  online=1><a hef="#" class="user_icon"><img src="./program/index/user_icon/default.png"></a><div class="user_info"><a class="u_name">'+name+'</a><span class="u_last"></span></div><div class=time_act><a class=checkbox_a><input type=checkbox class=u_checkbox /></a></div><div class=user_act><a class=set_blacklist title="<?php echo self::$language['join']?><?php echo self::$language['blacklist']?>"><?php echo self::$language['join']?><?php echo self::$language['blacklist']?></a><a class=del title="<?php echo self::$language['clear_log']?>"><?php echo self::$language['clear_log']?></a></div></div>');
	   bind_swipe();
	}
	
	function get_addressee_ids(){
		ids='';
		$("#<?php echo $module['module_name'];?> .list .selected").each(function(index, element) {
            ids+=$(this).attr('id').replace('a_','')+',';
        });
		return ids;
	}
	
	function set_addressee(not_go_log){
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
		if(addressee_ids!='' && !not_go_log){go_log_div();}
		
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
			
			str+='<div class=addressee id=a_'+addressee[i]['id']+'  online='+addressee[i]['online']+'><a hef=# class="user_icon"><img src="'+addressee[i]['icon']+'" /></a><div class=user_info><a class=u_name>'+addressee[i]['name']+'</a><span class=u_last>'+addressee[i]['last_msg']+'</span></div>'+addressee[i]['new']+'<div class=time_act><span class=time>'+addressee[i]['last_time']+'</span><a class=checkbox_a><input type=checkbox class=u_checkbox /></a></div><div class=user_act><a class=set_blacklist title="<?php echo self::$language['join']?><?php echo self::$language['blacklist']?>"><?php echo self::$language['join']?><?php echo self::$language['blacklist']?></a><a class=del title="<?php echo self::$language['clear_log']?>"><?php echo self::$language['clear_log']?></a></div></div>';
		}
		$("#<?php echo $module['module_name'];?> .talk_addressee .list").html(str);
		
		$("#<?php echo $module['module_name'];?> .talk_addressee .list").height($(window).height()*0.8);
		
		$(document).on('click',"#<?php echo $module['module_name'];?> .list  .addressee .user_act .del",function(){
			if(confirm("<?php echo self::$language['delete_confirm']?>")){
				id=$(this).parent().parent().attr('id').replace('a_','');
				$.post('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					if(v.state=='success'){
						$("#<?php echo $module['module_name'];?> #log_"+id).html('');
						$("#<?php echo $module['module_name'];?> #a_"+id+' .u_last').html('');
						$("#<?php echo $module['module_name'];?> #a_"+id+' .new_sum').remove();
						$("#<?php echo $module['module_name'];?> .talk_addressee .addressee:last").after($("#<?php echo $module['module_name'];?> .talk_addressee #a_"+id)); 
						$("#<?php echo $module['module_name'];?> #a_"+id+'').remove();

						/*
						$("#<?php echo $module['module_name'];?> .talk_top .with").attr('addressee_ids',$("#<?php echo $module['module_name'];?> .talk_top .with").attr('addressee_ids').replace(''+id+',',''));
						$("#<?php echo $module['module_name'];?> .talk_top .with").html($("#<?php echo $module['module_name'];?> .talk_top .with").html().replace($("#<?php echo $module['module_name'];?> #a_"+id+' .u_name').html(),''));
						$("#<?php echo $module['module_name'];?> #a_"+id).remove();
						$("#<?php echo $module['module_name'];?> #log_"+id).remove();
						*/
					}
				});
			}
			set_addressee(1);
			return false;
		});
		
		
		$(document).on('click',"#<?php echo $module['module_name'];?> .clear_log_2",function(){
			if(confirm("<?php echo self::$language['are_you_sure_you_want_it_cleaned']?>")){
				id=$(".with").attr('addressee_ids').split(',');
				id=id[0];
				$.post('<?php echo $module['action_url'];?>&act=del_log',{id:id}, function(data){
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
			set_addressee(1);
			return false;
		});
		
		$(document).on('click',"#<?php echo $module['module_name'];?> .list  .addressee .user_act .set_blacklist",function(){
				id=$(this).parent().parent().attr('id').replace('a_','');
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
			set_addressee(1);
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
						bind_swipe();
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
			set_addressee(1);
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
			set_addressee(1);
		});
		
		$("#<?php echo $module['module_name'];?> .batch_send").click(function(){
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
								console.log(data);
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
			
		$("#<?php echo $module['module_name'];?> .send").click(function(){
			ids=$("#<?php echo $module['module_name'];?> .talk_top .with").attr('addressee_ids'); 
			msg=$("#<?php echo $module['module_name'];?> #detail").val(); 
			if(msg==''){return false;}
			if(ids==''){alert('<?php echo self::$language['please_select']?><?php echo self::$language['user']?>');return false;} 
			$("#<?php echo $module['module_name'];?> #detail").val('');
		    str='<div class=me><div class=c><span class=content>'+msg+'</span><span class=horn></span></div><a class=icon><img src="<?php echo $module['my_icon'];?>" /></a></div>';
			
			if($("#<?php echo $module['module_name'];?> .list .selected").length==1){
				$("#<?php echo $module['module_name'];?> .talk_log_div #log_"+$("#<?php echo $module['module_name'];?> .list .selected").attr('id').replace('a_','')).append(str); 
				
			}else{
				$("#<?php echo $module['module_name'];?> .talk_log_div #batch_send").append(str); 
			}
			$("body").scrollTop($("#<?php echo $module['module_name'];?> .talk_log_div #log_"+$("#<?php echo $module['module_name'];?> .list .selected").attr('id').replace('a_','')).height()); 
			$("#<?php echo $module['module_name'];?> .send").css('display','none');
			$("#<?php echo $module['module_name'];?> .other").css('display','inline-block');
			
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
		
		$("#<?php echo $module['module_name'];?>_html .talk_out_div .talk_top .return_list").click(function(){
			return_list_div();
		});
		
		$("#<?php echo $module['module_name'];?> #detail").keyup(function(){
			if($(this).val()!=''){
				$("#<?php echo $module['module_name'];?> .other").css('display','none');
				$("#<?php echo $module['module_name'];?> .send").css('display','inline-block');
			}else{
				$("#<?php echo $module['module_name'];?> .send").css('display','none');
				$("#<?php echo $module['module_name'];?> .other").css('display','inline-block');
			}
			
		});
		
		
		$("#<?php echo $module['module_name'];?> #detail").keyup(function(event){
            if(event.keyCode==13 && $(this).val()!=''){
				$("#<?php echo $module['module_name'];?> .send").trigger('click');
			}
        });


		temp='';
		for(i=0;i<30;i++){
			temp+='<img src="./editor/plugins/emoticons/images/'+i+'.gif" />';
		}
		$("#<?php echo $module['module_name'];?> .expression_div").html(temp);
		
		$("#<?php echo $module['module_name'];?> .expression").click(function(){
			if($("#<?php echo $module['module_name'];?> .expression_div").css('display')=='none'){
				$("#<?php echo $module['module_name'];?> .expression_div").css('display','block');
			}else{
				$("#<?php echo $module['module_name'];?> .expression_div").css('display','none');
			}
			$("#<?php echo $module['module_name'];?> .other_div").css('display','none');
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> .other").click(function(){
			$("#html5_up_file").trigger('click');	
			return false;
			if($("#<?php echo $module['module_name'];?> .other_div").css('display')=='none'){
				$("#<?php echo $module['module_name'];?> .other_div").css('display','block');
			}else{
				$("#<?php echo $module['module_name'];?> .other_div").css('display','none');
			}
			$("#<?php echo $module['module_name'];?> .expression_div").css('display','none');
		});
		
		$("#html5_up_file").change(function(){
			
		    str='<div class="me uploading"><div class=c><span class=content><?php echo self::$language['uploading']?></span><span class=horn></span></div><a class=icon><img src="<?php echo $module['my_icon'];?>" /></a></div>';
			
			if($("#<?php echo $module['module_name'];?> .list .selected").length==1){
				if(!$("#<?php echo $module['module_name'];?> .talk_log_div #log_"+$("#<?php echo $module['module_name'];?> .list .selected").attr('id').replace('a_','')+" .me:last").attr('class')=='me me upload_fail'){
					$("#<?php echo $module['module_name'];?> .talk_log_div #log_"+$("#<?php echo $module['module_name'];?> .list .selected").attr('id').replace('a_','')).append(str);
				}
				 
				
			}else{
				if(!$("#<?php echo $module['module_name'];?> .talk_log_div #batch_send .me:last").attr('class')=='me me upload_fail'){
					$("#<?php echo $module['module_name'];?> .talk_log_div #batch_send").append(str); 
				}
				
			}
			$("body").scrollTop($("#<?php echo $module['module_name'];?> .talk_log_div #log_"+$("#<?php echo $module['module_name'];?> .list .selected").attr('id').replace('a_','')).height()); 
			
		});
		
		
		$("#<?php echo $module['module_name'];?> .other_div .album_value").change(function(){
			 var objUrl = getObjectURL(this.files[0]) ;
			 console.log("objUrl = "+objUrl) ;
			 if (objUrl) {
			 	$("#<?php echo $module['module_name'];?> #detail").val('<img src="'+objUrl+'" />');
				$("#<?php echo $module['module_name'];?> .send").trigger('click');
			 }
		});
		
		//建立一個可存取到該file的url
		function getObjectURL(file) {
			var url = null ; 
			if (window.createObjectURL!=undefined) { // basic
			url = window.createObjectURL(file) ;
			} else if (window.URL!=undefined) { // mozilla(firefox)
			url = window.URL.createObjectURL(file) ;
			} else if (window.webkitURL!=undefined) { // webkit or chrome
			url = window.webkitURL.createObjectURL(file) ;
			}
			return url ;
		}		
				
		
		
		
		$("#<?php echo $module['module_name'];?> .expression_div img").click(function(){
			$("#<?php echo $module['module_name'];?> #detail").val($("#<?php echo $module['module_name'];?> #detail").val()+'<img src='+$(this).attr('src')+' />');
			$("#<?php echo $module['module_name'];?> .send").trigger('click');
			$("#<?php echo $module['module_name'];?> .expression_div").css('display','none');
		});
		
		$("#<?php echo $module['module_name'];?> .other_div .album").click(function(e){
			 e.preventDefault();
			$("#<?php echo $module['module_name'];?> .other_div .album_value").trigger('click');	
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> .other_div .video").click(function(e){
			 e.preventDefault();
			$("#<?php echo $module['module_name'];?> .other_div .video_value").trigger('click');	
			return false;
		});
		$("#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log_div").attr('min-height',$(window).height());
		
		if(get_param('with')){
			$("#<?php echo $module['module_name'];?> .talk_addressee .addressee").each(function(index, element) {
                id=$(this).attr('id');
				if($("#<?php echo $module['module_name'];?> #"+id+" .u_name").html()=='<?php echo @$_GET['with']?>'){
					$("#<?php echo $module['module_name'];?> #"+id+" .u_name").trigger('click');
				}
            });
			
		}
		
		$("#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log_div").css('min-height',$(window).height()*1);
			
		setInterval("bundenter()",100);
        new_msg_inter=setInterval("get_new_msg()",500);
		
		//$("#<?php echo $module['module_name'];?> .talk_addressee .list .addressee:first-child .user_info").trigger('click');
		
		bind_swipe();
	
		$(document).on('click',"#<?php echo $module['module_name'];?> .list  .addressee",function(){
			
		});
	
    });
	
	function bind_swipe(){
		$(".addressee").swipe( {
			swipe:function(event, direction, distance, duration, fingerCount) {
				if(direction=='left'){
					$(this).css('left','-200px');
					$(this).children('.user_act').css('display','inline-block');
				}
				if(direction=='right'){
					$(this).css('left','0px').css('margin-right','0px');
					$(this).children('.user_act').css('display','none');
				}
				if(direction=='up'){
					$("#<?php echo $module['module_name'];?>  .list").scrollTop($("#<?php echo $module['module_name'];?>  .list").scrollTop()+distance);
				}
				if(direction=='down'){
					$$("#<?php echo $module['module_name'];?>  .list").scrollTop($("#<?php echo $module['module_name'];?>  .list").scrollTop()-distance);
				}
		
		},
		});
			
		$("#<?php echo $module['module_name'];?> .addressee").click(function(event){
			unset_addressee();
			if($(this).attr('id')){
				$(this).removeClass('selected');
			}else{
				$(this).addClass('selected');
			}
			if(event.target.tagName=='INPUT'){set_addressee(1);}else{set_addressee(0);}
			
		});
		
	}
	
	function go_log_div(){
		$("#<?php echo $module['module_name'];?> .talk_log_div").scrollTop(100000000000); 
		$("#<?php echo $module['module_name'];?> .talk_addressee").css('display','none');
		$("#<?php echo $module['module_name'];?> .talk_main").css('display','block');
		$("#index_phone_bottom").css('display','none');
		$(".page-footer").css('display','none');
		
		$("body").scrollTop($(window).height()); 
		
	}
	
	function return_list_div(){
		$("#<?php echo $module['module_name'];?> .talk_addressee").css('display','block');
		$("#<?php echo $module['module_name'];?> .talk_main").css('display','none');
		$("#index_phone_bottom").css('display','block');
		$(".page-footer").css('display','block');
	}
	
	function bundenter(){
		msg=$("#<?php echo $module['module_name'];?> #detail").val(); 
		if(msg.indexOf('<br />')!==-1){
			$("#<?php echo $module['module_name'];?> .send").trigger('click');
		}
	}
	
	function get_new_msg(){
		$.get('<?php echo $module['action_url'];?>&act=get_new_msg&load_time=<?php echo $module['load_time'];?>',function(data){
			if(data=='<?php echo self::$language['act_noPower']?>'){window.location.href='./index.php?monxin=im.talk';}
		   try{v=eval("("+data+")");}catch(exception){console.log(data);}
		   if(v.info=='<span class=fail>token err</span>'){
			   clearInterval(new_msg_inter);
			  
			 }
		   for(i in v){
			   $("#notice_audio").attr('src','./program/im/new.wav').removeAttr('loop');
			   if(!$("#<?php echo $module['module_name'];?> .talk_log_div #log_"+v[i]['id']).attr('id')){
				   $("#<?php echo $module['module_name'];?> .talk_log_div").prepend('<div class="talk_log" id="log_'+v[i]['id']+'" ids="'+v[i]['ids']+'"></div>');
				   $("#<?php echo $module['module_name'];?> .talk_addressee .list").prepend('<div class="addressee selected" id="a_'+v[i]['id']+'"  online=1><a hef="#" class="user_icon"><img src="'+v[i]['icon']+'"></a><div class="user_info"><a class="u_name">'+v[i]['addressee']+'</a><span class="u_last">'+v[i]['last_msg']+'</span></div><div class="new_sum">'+v[i]['msg_sum']+'</div><div class="time_act"><span class="time">'+v[i]['last_time']+'</span><a class=checkbox_a><input type=checkbox class=u_checkbox /></a></div><div class=user_act><a class=set_blacklist title="<?php echo self::$language['join']?><?php echo self::$language['blacklist']?>"><?php echo self::$language['join']?><?php echo self::$language['blacklist']?></a><a class=del title="<?php echo self::$language['clear_log']?>"><?php echo self::$language['clear_log']?></a></div></div>');
				   
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
					$("#<?php echo $module['module_name'];?> .talk_addressee .addressee:first").css('left','0px');
					$("#<?php echo $module['module_name'];?> .talk_addressee .addressee:first").children('.user_act').css('display','none');;
					
				}
			   
			   $("#<?php echo $module['module_name'];?> .talk_log_div #log_"+v[i]['id']).append(v[i]['msg']); 
			   $("body").scrollTop($("#<?php echo $module['module_name'];?> .talk_log_div #log_"+$("#<?php echo $module['module_name'];?> .list .selected").attr('id').replace('a_','')).height()); 

			   if($("#<?php echo $module['module_name'];?> #log_"+v[i]['id']).css('display')=='block'){
				  // $("#<?php echo $module['module_name'];?> .talk_addressee #a_"+v[i]['id']+' .new_sum').remove();
				}
			   
			}
			bind_swipe();
		});
	}
	
	
	function  submit_hidden(id){
		temp=$("#"+id).val();
		temp=temp.split('|');
		str='';
		for(i in temp){
			if(temp[i]==''){continue;}
			t=temp[i].split('.');
			if(t[1]=='jpg' || t[1]=='gif' || t[1]=='png' || t[1]=='jpeg'){
				str+='<img src="./program/im/img/'+temp[i]+'" />';
			}else{
				str+='<video src="./program/im/img/'+temp[i]+'" controls="controls">您的浏览器不支持 video 标签</video>';
			}
		}
		$("#<?php echo $module['module_name'];?> #detail").val(str);
		$("#<?php echo $module['module_name'];?> .send").trigger('click');
	}
	
		function top_html5_show_failedList(v,input_id){
		    str='<div class="me upload_fail"><div class=c><span class=content>'+v+'</span><span class=horn></span></div><a class=icon><img src="<?php echo $module['my_icon'];?>" /></a></div>';
			
			if($("#<?php echo $module['module_name'];?> .list .selected").length==1){
				$("#<?php echo $module['module_name'];?> .talk_log_div #log_"+$("#<?php echo $module['module_name'];?> .list .selected").attr('id').replace('a_','')).append(str); 
				
			}else{
				$("#<?php echo $module['module_name'];?> .talk_log_div #batch_send").append(str); 
			}
			$("body").scrollTop($("#<?php echo $module['module_name'];?> .talk_log_div #log_"+$("#<?php echo $module['module_name'];?> .list .selected").attr('id').replace('a_','')).height()); 
			
		}
	
    </script>
    <style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?>_html .talk_out_div{ }
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_top{ text-align:left; padding-left:10px; font-weight:bold; background-color:<?php echo $_POST['monxin_user_color_set']['nv_3']['background']?>; color:#fff; line-height:3rem; white-space:nowrap; position:fixed; top:0px; left:0px; width:100%;     box-shadow: 0 0 3px #b0b0b0;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_top .return_list{display:inline-block; vertical-align:top; width:10%; overflow:hidden;  }
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_top .return_list:before {font: normal normal normal 1rem/1 FontAwesome;content:"\f053";  margin-right:5px; color:#fff; padding:3px; }
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_top .top_middle{display:inline-block; vertical-align:top; width:80%; overflow:hidden; }
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_top .return_home{display:inline-block; vertical-align:top; width:10%; overflow:hidden; text-align:right;  }
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_top .return_home:before {font: normal normal normal 1rem/1 FontAwesome;content:"\f015"; color:#fff; margin-right:10px;}
	
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_top .with{ display:inline-block; vertical-align:top; max-width:60%; overflow:hidden; white-space: nowrap; text-overflow: ellipsis;}
	
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body{}
	
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee{display:block;  background:rgba(252,252,252,1);}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .list{ height:330px; width:100%; overflow:scroll;overflow-x:hidden; }
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee{ position:relative; cursor:default;  padding-left:8px; white-space:nowrap; border-bottom: 1px dashed #ccc; margin-bottom:3px;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .current{ position:relative; background:rgba(237,229,229,1.00); cursor:default;  padding-left:8px;}

	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_icon{ display:inline-block; vertical-align:top; width:15%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_icon img{ width:90%; border-radius:5px; margin-top:2px;margin-bottom:2px;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_info{display:inline-block; vertical-align:top; width:58%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_info .u_name{ display:block;overflow:hidden; white-space: nowrap; text-overflow: ellipsis; line-height:1.6rem; padding-top:0.2rem;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_info .u_last{display:block; font-size:0.9rem; opacity:0.7; line-height:1.4rem; padding-bottom:0.2rem;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .new_sum{ width:1.2rem; height:1.2rem; line-height:1.2rem;  text-align:center;  position:absolute; top:0px;left:5px; background-color:red; color:#fff; border-radius:50%; font-size:0.8rem; padding:1px;} 
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .time_act{ display:inline-block; width:27%; white-space:nowrap; right:10px; text-align: right;} 
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_act{ display:inline-block; vertical-align:top; width:200px; overflow:hidden; display:none;   line-height:4rem;   border-bottom: 1px dashed #ccc;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee:hover{  background:rgba(237,237,237,1.00);}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .time_act .time{display:block; font-size:0.9rem; opacity:0.5;}
	
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_act a{ display:inline-block; vertical-align:top; color:#fff; text-align:center;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_act .set_blacklist{ cursor:pointer;background-color:#c7c7cd; width:55%; }
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_act .set_blacklist:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_act .del{ cursor:pointer; background:#ff9d00; width:45%; }
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_act .del:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .addressee .user_act .checkbox_a{ cursor:pointer;background:#ff3a30; width:19%;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .selected{ background:rgba(237,229,229,1.00);}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .selected .time_act .user_act{ display:block;}
	
	
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .batch_div{ text-align:left; padding:5px; padding-right:5px; background-color:<?php echo $_POST['monxin_user_color_set']['nv_3']['background']?>; color:#fff;  white-space:nowrap;   box-shadow: 0 0 3px #b0b0b0; line-height:1.6rem;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .batch_div a{ color:#fff;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .batch_div .del:before {font: normal normal normal 1rem/1 FontAwesome;content: "\f014";  padding:5px;  cursor:pointer;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_addressee .batch_div .search{ display:inline-block; vertical-align:top; height:1.5rem; line-height:1.5rem; border-radius:0.3rem;color:rgba(160,160,160,1);}
	
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main{display:none;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log_div{ padding:10px; background-color:rgba(243,243,243,1); padding-top:3.5rem;padding-bottom:6rem;  min-height:500px; height:auto; }
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log_div .talk_log{ display:none;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .time{ text-align:center; font-size:0.8rem; color:rgba(139,139,139,1); }
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .info{ white-space:nowrap;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .you{}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .you .icon{ display:inline-block; vertical-align:top; width:10%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .you .icon img{ width:100%; border-radius:5px;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .you .c{ display:inline-block; width:86%; overflow:hidden; white-space:nowrap;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .you .c .horn{}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .you .c .horn:before {font: normal normal normal 18px/1 FontAwesome;margin-right:0px; padding-left:3px;content:"\f0d9";color:rgba(205,215,226,1);	}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .you .c .content{ color:rgba(37,36,36,1); background:rgba(205,215,226,1); border-radius:5px; display:inline-block; vertical-align:top;padding:5px;white-space:normal; max-width:90%; overflow:hidden; text-align:left;}
	
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .me{ text-align:right; margin-bottom:0.3rem;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .me .icon{ display:inline-block; width:10%; overflow:hidden;vertical-align:top;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .me .icon img{ width:100%; border-radius:5px;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .me .c{ display:inline-block; width:86%; overflow:hidden; white-space:nowrap;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .me .c .horn{}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .me .c .horn:before {font: normal normal normal 18px/1 FontAwesome;margin-left:0px; padding-right:3px;content:"\f0da";color:rgba(205,215,226,1);	}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .me .c .content{ color:rgba(37,36,36,1); background:rgba(205,215,226,1); border-radius:5px; display:inline-block; vertical-align:top;padding:5px; white-space:normal; max-width:90%; overflow:hidden; text-align:left;}
	
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .c img{ max-width:100%;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .talk_log .c video{ max-width:100%;}
	
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .input_div{ line-height:2rem;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .input_div .input_c{ display:block; height:5rem; width:100%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .input_div .act_div{ text-align:right; padding-top:5px;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .input_div .act_div .send{ padding-left:10px; padding-right:10px; line-height:2rem; display:inline-block;  vertical-align:top; cursor:pointer; border-radius:2px; border:1px solid #ccc; margin-right:0.8rem;}
	#<?php echo $module['module_name'];?>_html .talk_out_div .talk_body .talk_main .input_div .act_div .send:hover{ background-color:rgba(121,150,197,1); color:#fff; }
	.view_more{ text-align:center;}
	.view_more a{ cursor:pointer;}
	.view_more a:before {font: normal normal normal 18px/1 FontAwesome;content:"\f141";	}
	.blacklist{ cursor:pointer;}
	.batch_send_notice{ text-align:center; font-size:1.8rem; margin-top:20%;}
	.ke-container{ border:none;}
	.ke-statusbar{ display:none;}
	.operation_td{ text-align:left;}
	.fixed_right_div{ display:none;}
	.add_address{ cursor:pointer;}
	[online='0'] .user_icon{      -webkit-filter: grayscale(90%);     -moz-filter: grayscale(90%);     -ms-filter: grayscale(90%);     -o-filter: grayscale(90%);          filter: grayscale(90%); 	     filter: gray; }
	
	#<?php echo $module['module_name'];?> .input_div{ position:fixed; left:0px; bottom:0px; width:100%; background:rgba(235,235,235,1); box-shadow: 0 0 3px #b0b0b0;}
	#<?php echo $module['module_name'];?> .input_div a{ cursor:pointer;}
	#<?php echo $module['module_name'];?> .input_div .recording{ display:inline-block; vertical-align:top; width:10%; overflow:hidden; text-align:center; display:none;}
	#<?php echo $module['module_name'];?> .input_div .recording:before {font: normal normal normal 18px/1 FontAwesome;content:"\f028";}
	#<?php echo $module['module_name'];?> .input_div .middle_input{ }
	#<?php echo $module['module_name'];?> .input_div .middle_input{ display:inline-block; vertical-align:top; width:80%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .input_div .button_div{ display:inline-block; vertical-align:top; width:20%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .input_div .button_div .expression:before {font: normal normal normal 18px/1 FontAwesome;content:"\f11a";}
	#<?php echo $module['module_name'];?> .input_div .button_div .other:before {font: normal normal normal 18px/1 FontAwesome;content:"\f067";}
	#<?php echo $module['module_name'];?> .input_div .button_div .send { border-radius:3px; display:none;}
	#<?php echo $module['module_name'];?> .input_div .button_div{ display:inline-block; vertical-align:top; width:20%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .input_div .button_div a{ display:inline-block; vertical-align:top; width:50%; overflow:hidden; text-align:center;}
	#<?php echo $module['module_name'];?> .input_div{ padding:3px;}
	#<?php echo $module['module_name'];?> #detail{ resize:none; height:2rem;}
	
	#<?php echo $module['module_name'];?> .expression_div{ display:none; }
	#<?php echo $module['module_name'];?> .expression_div img{ display:inline-block; vertical-align:top; margin:5px;}
	
	#<?php echo $module['module_name'];?> .other_div{ display:none;}
	#<?php echo $module['module_name'];?> .other_div a{ display:inline-block; vertical-align:top; width:20%; overflow:hidden; margin-left:2%; margin-right:2%;}
	#<?php echo $module['module_name'];?> .other_div a .album div:before {font: normal normal normal 18px/1 FontAwesome;content:"\f1c5";}
	
	#<?php echo $module['module_name'];?>  .blacklist{ display:inline-block; margin-top:5px; width:15%; text-align:center; overflow:hidden;}
	#<?php echo $module['module_name'];?>  .search{display:inline-block; margin:0px; margin-top:5px;  width:38%; text-align:center; overflow:hidden;}
	#<?php echo $module['module_name'];?>  .right_but_div{display:inline-block; vertical-align:top; width:48%; text-align:center; overflow:hidden;}
	#<?php echo $module['module_name'];?>  .right_but_div .add_new{ display:inline-block;width:25%;}
	.page-container{ min-height:5rem;}
	
	#<?php echo $module['module_name'];?> .other_div{ text-align:center; border-top: 1px solid #dcdcdc; padding-top:5px; margin-top:5px; }
	#<?php echo $module['module_name'];?> .other_div .album{}
	#<?php echo $module['module_name'];?> .other_div .video{}
	.inputs_div{ display:none;}
	#html5_up_ele{ display:none !important;}
	
	#<?php echo $module['module_name'];?> input[type='checkbox']{display:inline-block;width:1.2rem; height:1.2rem; margin-right:5px;}
	
	#<?php echo $module['module_name'];?>  #detail{ height:5rem;}
	#<?php echo $module['module_name'];?> .input_div .middle_input{ width:70%;}
	#<?php echo $module['module_name'];?> .input_div .button_div{width:30%; text-align:left;}
	#<?php echo $module['module_name'];?> .input_div .button_div >a{ display:inline-block;width:42%; border:1px solid <?php echo $_POST['monxin_user_color_set']['nv_3']['background']?>; margin:3px;}
	#<?php echo $module['module_name'];?> .input_div .button_div .clear_log_2{ display:inline-block;width:94%;}
    </style>    
	<div id="<?php echo $module['module_name'];?>_html">
		<div class=talk_out_div>
        	
            <div class=talk_body>
            	<div class=talk_addressee>
                    <div class=batch_div><a class=blacklist title="<?php echo self::$language['blacklist']?>"><?php echo self::$language['blacklist']?></a><input type=text placeholder="<?php echo self::$language['search']?>" class=search /><div class=right_but_div><a class=add_new title="<?php echo self::$language['add']?>"><?php echo self::$language['add']?></a><a class=batch_send><?php echo self::$language['selected_item']?><?php echo self::$language['mass']?></a> <span style="display:inline-block;"><?php echo self::$language['select_all'];?><input type="checkbox" class=select_all /></span></div></div>
                 	<div class=list>
                        

                    </div>
                    
                </div><div class=talk_main>
                	<div class=talk_top><a class=return_list></a><div class=top_middle><?php echo self::$language['with']?> <span class=with addressee_ids=''></span> <?php echo self::$language['dialogue']?></div><a class=return_home href="./index.php"></a></div>
                	<div class=talk_log_div>
                    	<?php echo $module['talk_log'];?>
                        <div class=talk_log id=batch_send>
                            <div class=batch_send_notice><?php echo self::$language['mass']?></div>
                        </div>
                            
                    </div>
                	
                    <div class=input_div>
                    	<div class=recording></div><div class=middle_input>
                        	<textarea placeholder="<?php echo self::$language['what_do_you_say'];?>" class=input_c  name="detail" id="detail" ></textarea><a class=recording_button></a>
                        </div><div class=button_div><a class=expression></a><a class=other></a><a class=send user_color=button><?php echo self::$language['send']?></a><a class=clear_log_2><?php echo self::$language['clear_log_2']?></a></div>
                    	<div class=expression_div>
                        	
                        </div>
						
                    	<div class=other_div>
                        	<div class=inputs_div><input type="file" class="album_value"  multiple="multiple"  /><input type="file" class="video_value"  /></div>
                        	<a class=album><div><img src="<?php echo get_template_dir(__FILE__)?>img/album.png" /></div><span>相册</span></a><a class=video><div><img src="<?php echo get_template_dir(__FILE__)?>img/video.png" /></div><span>视频</span></a>
                        </div>
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
