<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$('#bg_ele').insertBefore($('#bg_state'));
		$("#<?php echo $module['module_name'];?> [field]" ).draggable(); 
		$("#<?php echo $module['module_name'];?> .content_set div" ).resizable();
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .submit").next('.state').html('');
			if($("#<?php echo $module['module_name'];?> .width").val()==''){alert('<?php echo self::$language['please_input']?><?php echo self::$language['express_layout']['width']?>');$("#<?php echo $module['module_name'];?> .width").focus();return false;}
			if($("#<?php echo $module['module_name'];?> .height").val()==''){alert('<?php echo self::$language['please_input']?><?php echo self::$language['express_layout']['height']?>');$("#<?php echo $module['module_name'];?> .height").focus();return false;}
			var obj=new Object();
			obj['width']=$("#<?php echo $module['module_name'];?> .width").val();
			obj['height']=$("#<?php echo $module['module_name'];?> .height").val();
			
			$("#<?php echo $module['module_name'];?> [field]").each(function(index, element) {
				left=px_to_percent($(this).css('left'),$(this).parent().width());
				p_top=px_to_percent($(this).css('top'),$(this).parent().height());
				width=px_to_percent($(this).css('width'),$(this).parent().width());
				height=px_to_percent($(this).css('height'),$(this).parent().height());
                obj[$(this).attr('field')]='{"left":'+left+',"top":'+p_top+',"width":'+width+',"height":'+height+'}';
				//alert(obj[$(this).attr('field')]);
            });
			
			
			$("#<?php echo $module['module_name'];?> .submit").next('.state').html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=update',obj, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> .submit").next('.state').html(v.info);
			});
			return false;	
		});
    });
	
	function px_to_percent(a,b){
		//alert(a+','+b);
		if(a.indexOf('px')===-1){return a.replace(/%/,'');}
		a=parseFloat(a.replace(/px/,''));
		return a/b*100;	
	}
	
    function submit_hidden(id){
        //monxin_alert(id);
        obj=document.getElementById(id);
		//monxin_alert(obj.value);
        if(obj.value==''){}
        json="{'"+obj.id+"':'"+replace_quot(obj.value)+"'}";
        try{json=eval("("+json+")");}catch(exception){alert(json);}
        $("#"+obj.id+"_state").html("<span class='fa fa-spinner fa-spin'></span>");
        $("#"+obj.id+"_state").load('<?php echo $module['action_url'];?>&act=bg',json,function(){
            if($(this).html().length>10){
               //alert($(this).html());
                try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}
                $(this).html(v.info);
               	if(v.state=='success'){$("#bg_img").attr('src',$("#bg_img").attr('src')+'?&=re'+Math.random());$("#<?php echo $module['module_name'];?> .content_set").css('background','url('+$("#bg_img").attr('src')+')').css('background-size','contain');}
                
            }
        });
        
    }
    
    </script>
	<style>
    #<?php echo $module['module_name'];?> {}
    #<?php echo $module['module_name'];?> .bg_set{ margin-bottom:1rem;}
    #<?php echo $module['module_name'];?> .bg_set img{ height:3rem;}
    #<?php echo $module['module_name'];?> .content_set{ width:<?php echo $module['data']['width_css']?>rem;height:<?php echo $module['data']['height_css']?>rem; background:url(./program/mall/express_bg/<?php echo $_GET['id']?>.png); background-size:contain; position:relative;}
	#<?php echo $module['module_name'];?> .content_set div{ position: absolute; background-color: #090; color:#fff; opacity:0.6; cursor:move; }
	#<?php echo $module['module_name'];?> .content_set div:hover{ opacity:0.9;}
	#<?php echo $module['module_name'];?> .content_set .shipper_name{ left:14.5%; top:18.5%; width:8%; height:5%;}
	#<?php echo $module['module_name'];?> .content_set .shipper_tel{ left:28.2%; top:42%; width:8%; height:5%;}
	#<?php echo $module['module_name'];?> .content_set div .ui-resizable-se{z-index: 90;  position: absolute; bottom:2px;right:5px; width:1rem; height:1rem; float:right; cursor:se-resize;}
	#<?php echo $module['module_name'];?> .content_set div .ui-resizable-se:before {font: normal normal normal 18px/1 FontAwesome;margin-right: 5px;content: "\f012";}
	#<?php echo $module['module_name'];?> .content_set div .ui-resizable-s{ display:none;}
	#<?php echo $module['module_name'];?> .content_set div .ui-resizable-e{ display:none;}
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
        <div class=bg_set>
        	<?php echo self::$language['express_layout']['width']?>:<input type="text" class=width value="<?php echo $module['data']['width']?>" /> &nbsp; &nbsp;
        	<?php echo self::$language['express_layout']['height']?>:<input type="text" class=height value="<?php echo $module['data']['height']?>" /> &nbsp; &nbsp;
            <?php echo self::$language['express_layout']['background']?> <img id=bg_img src='./program/mall/express_bg/<?php echo $_GET['id']?>.png' /> <span id="bg_state" /></span>
             &nbsp; &nbsp; <a href=# class=submit><?php echo self::$language['save']?></a> <span class=state></span>
        </div>
        <div class=content_set>
            <?php echo $module['list'];?>    	
        </div>
        

    <script>

   </script>
    </div>
    
</div>
