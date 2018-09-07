<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		if(''!='<?php echo @$_GET['id'];?>'){
			$("#<?php echo $module['module_name'];?> #next_button").attr('class','next_able').attr('href','./index.php?monxin=mall.goods_<?php echo @$_GET['act']?>&type=<?php echo @$_GET['id'];?>&id=<?php echo @$_GET['goods_id'];?>');	
		}
		$("#<?php echo $module['module_name'];?> #option_div select").each(function(index, element) {
           // if($(this).attr('monxin_value')!=''){$(this).val($(this).attr('monxin_value'));}
        });
		$("#<?php echo $module['module_name'];?> #lately").change(function(){
			if($(this).val()>0){window.location.href='./index.php?monxin=mall.goods_<?php echo @$_GET['act']?>&id=<?php echo @$_GET['goods_id'];?>&type='+$(this).val();}	
		});
		$(document).on('change',"#<?php echo $module['module_name'];?> #select_1",function(){
			$.get('<?php echo $module['action_url'];?>&act=get_sub',{parent:$(this).prop('value')}, function(data){
				$("#<?php echo $module['module_name'];?> #select_2").html('<option value=""><?php echo self::$language['please_select']?></option>'+data);
				if(data=='<option value="-1"><?php echo self::$language['no_sub_type'];?></option>'){
					$("#<?php echo $module['module_name'];?> #next_button").attr('class','next_able');	
				}else{
					$("#<?php echo $module['module_name'];?> #next_button").attr('class','next_disable');
				}
			});
			$("#<?php echo $module['module_name'];?> #next_button").attr('href','./index.php?monxin=mall.goods_<?php echo @$_GET['act']?>&id=<?php echo @$_GET['goods_id'];?>&type='+$(this).val());
		});
		$(document).on('change',"#<?php echo $module['module_name'];?> #select_2",function(){
			$.get('<?php echo $module['action_url'];?>&act=get_sub',{parent:$(this).prop('value')}, function(data){
				$("#<?php echo $module['module_name'];?> #select_3").html('<option value=""><?php echo self::$language['please_select']?></option>'+data);
				if(data=='<option value="-1"><?php echo self::$language['no_sub_type'];?></option>'){
					$("#<?php echo $module['module_name'];?> #next_button").attr('class','next_able');	
				}else{
					$("#<?php echo $module['module_name'];?> #next_button").attr('class','next_disable');
				}
			});
			if($(this).val()>0){$("#<?php echo $module['module_name'];?> #next_button").attr('href','./index.php?monxin=mall.goods_<?php echo @$_GET['act']?>&id=<?php echo @$_GET['goods_id'];?>&type='+$(this).val());}
		});
		$(document).on('change',"#<?php echo $module['module_name'];?> #select_3",function(){
			$("#<?php echo $module['module_name'];?> #next_button").attr('class','next_able');	
			if($(this).val()>0){$("#<?php echo $module['module_name'];?> #next_button").attr('href','./index.php?monxin=mall.goods_<?php echo @$_GET['act']?>&id=<?php echo @$_GET['goods_id'];?>&type='+$(this).val());}
		});
		$("#<?php echo $module['module_name'];?> #next_button").click(function(){
			if($(this).attr('class')=='next_disable'){
				if($("#<?php echo $module['module_name'];?> #select_1").val()==null){alert('<?php echo self::$language['please_select'];?><?php echo self::$language['class_1'];?>');return false;}
				if($("#<?php echo $module['module_name'];?> #select_2").val()==null){alert('<?php echo self::$language['please_select'];?><?php echo self::$language['class_2'];?>');return false;}
				if($("#<?php echo $module['module_name'];?> #select_3").val()==null){alert('<?php echo self::$language['please_select'];?><?php echo self::$language['class_3'];?>');return false;}
				return false;
			}
		});
    });
    
    </script>
    <style>
    #<?php echo $module['module_name'];?>_html{ width:90%; margin:auto; line-height:3rem;}
    #<?php echo $module['module_name'];?>_html .class_div{width:30%; display:inline-block; vertical-align:top; vertical-align:top; text-align:center;}
	
	#<?php echo $module['module_name'];?>_html #option_div select{
		_width:150px;
		min-width:150px;

	}
	#<?php echo $module['module_name'];?>_html #next_div{text-align:center;}
	#<?php echo $module['module_name'];?>_html #next_button{ display:block; border-radius:1rem;}
	#<?php echo $module['module_name'];?>_html .next_disable{ background-color:#ccc;  }
	#<?php echo $module['module_name'];?>_html .next_disable:hover{}
	#<?php echo $module['module_name'];?>_html .next_able{   background:<?php echo $_POST['monxin_user_color_set']['button']['background']?>;color:<?php echo $_POST['monxin_user_color_set']['button']['text']?>; }
	#<?php echo $module['module_name'];?>_html #lately_div{ text-align:center;}
	#<?php echo $module['module_name'];?>_html #lately_div select{ width:80%;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html">
	<?php echo $module['lately'];?>
    <div id=option_div>
    <div di=div_1 class=class_div>
    	<div class=title><?php echo self::$language['class_1'];?></div>
        <select id=select_1 name=select_1  monxin_value='<?php echo $module['class_1_value'];?>' ><option value=""><?php echo self::$language['please_select']?></option><?php echo $module['class_1'];?></select>
    </div>
    <div di=div_2 class=class_div>
    	<div class=title><?php echo self::$language['class_2'];?></div>
        <select id=select_2 name=select_2 monxin_value='<?php echo $module['class_2_value'];?>' ><?php echo $module['class_2'];?></select>
    </div>
    <div di=div_3 class=class_div>
    	<div class=title><?php echo self::$language['class_3'];?></div>
        <select id=select_3 name=select_3  monxin_value='<?php echo $module['class_3_value'];?>' ><?php echo $module['class_3'];?></select>
    </div>
	
    <div id=next_div><a href=./index.php?monxin=mall.goods_<?php echo @$_GET['act']?> id=next_button class=next_disable><?php echo self::$language['next'];?></a></div>

    </div>
    </div>

</div>
