<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
	function auto_edit_goods(){
		if(!$("#<?php echo $module['module_name'];?> .task_list .current").html()){
			set_current_css();
		}
		if(!$("#<?php echo $module['module_name'];?> .task_list .current:last").html()){
			clearInterval(t);
			return false;
		}
		
		$.get("<?php echo $module['action_url'];?>&act=get_url",{id:$("#<?php echo $module['module_name'];?> .task_list .current:last").attr('goods_id'),bar_code:$("#<?php echo $module['module_name'];?> .task_list .current:last").attr('bar_code')},function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			if(v.state=='fail'){
				console.log(data);
				auto_edit_goods();
			}
			
			if(v.state=='success'){
				$("#<?php echo $module['module_name'];?> #edit_goods").attr('src',$("#<?php echo $module['module_name'];?> .task_list .current:last").attr('href')+v.c_url+'&old_title='+v.old_title);
			}
			
			$("#<?php echo $module['module_name'];?> .task_list .current:last").next('a').addClass('current');
			//alert($("#<?php echo $module['module_name'];?> .task_list .current:last").next('a').html()+$("#<?php echo $module['module_name'];?> .task_list .current:last").next('a').attr('class'));
		
		});		
		
	}
	function set_current_css(){
		//alert('set_current_css');
		$("#<?php echo $module['module_name'];?> .task_list a").removeClass('current');
		$("#<?php echo $module['module_name'];?> .task_list a:first").addClass('current');
		$("#<?php echo $module['module_name'];?> .task_list .current").next().addClass('current');
	}
	var t;
    $(document).ready(function(){
		set_current_css();
		auto_edit_goods();
		t=setInterval("auto_edit_goods()",1000*40);
    });
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .goods_get_notice{ padding:10px; line-height:30px; text-align: center; width:80%; border:1px dashed #ccc; border-radius:10px; margin:auto; margin-bottom:20px;}
    #<?php echo $module['module_name'];?> .get_view{}
    #<?php echo $module['module_name'];?> .get_view .task_list{ display:inline-block; vertical-align:top; width:20%; height:300px; overflow:scroll;}
    #<?php echo $module['module_name'];?> .get_view .task_list a{ display:block; line-height:25px; white-space:nowrap;text-overflow: ellipsis; width:100%; overflow:hidden; border-bottom:1px dashed #ccc;}

	#<?php echo $module['module_name'];?> .get_view .task_list .current:before {font: normal normal normal 16px/1 FontAwesome; margin-right: 5px;
    content:"\f04b";}
    #<?php echo $module['module_name'];?> .get_view .goods_edit{display:inline-block; vertical-align:top; width:80%; overflow:hidden;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
		<div class=goods_get_notice><?php echo self::$language['goods_get_notice']?></div>
        <div class=get_view>
        	<div class=task_list><?php echo  $module['list']?></div><div class=goods_edit>
            	<iframe width="100%" height="950" id="edit_goods" frameborder="0" arginheight="0" marginwidth="0" src="">
</iframe>
            </div>
        </div>
        
    </div>
</div>
