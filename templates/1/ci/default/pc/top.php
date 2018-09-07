<script src="./plugin/datePicker/index.php"></script>
<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .type a").each(function(index, element) {
			if($(this).attr('class')!='set'){$(this).html($(this).html()+' >');}
        });
		$("#<?php echo $module['module_name'];?> .top_price").blur(function(){
			if(parseFloat($(this).prop('value'))<parseFloat($("#<?php echo $module['module_name'];?> .remark b").html())){
				$(this).prop('value',$("#<?php echo $module['module_name'];?> .remark b").html());	
			}
			update_costs();	
		});
		$("#<?php echo $module['module_name'];?> .day_option input,m_label").click(function(){
			$(this).parent().parent().attr('value',$(this).parent().attr('value'));
			update_costs();
		});
		
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			if($("#<?php echo $module['module_name'];?> .top_price").prop('value')==''){alert('<?php echo self::$language['please_input'];?><?php echo self::$language['top_min_price'];?>');$("#<?php echo $module['module_name'];?> .top_price").focus();return false;}
			if($("#<?php echo $module['module_name'];?> #day").attr('value')==0){alert('<?php echo self::$language['please_select'];?><?php echo self::$language['promotion_duration'];?>');return false;}
			$("#<?php echo $module['module_name'];?> .submit").css('display','none');
			$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			
            $.get('<?php echo $module['action_url'];?>&act=submit',{top_price:$("#<?php echo $module['module_name'];?> .top_price").prop('value'),day:$("#<?php echo $module['module_name'];?> #day").attr('value'),top_start:$("#<?php echo $module['module_name'];?> .top_start").prop('value')},function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
                if(v.state=='success'){
                	parent.update_reflash_time(<?php echo $_GET['id']?>,v.html);
					if(v.balance!=-1){
						$("#<?php echo $module['module_name'];?> .balance").html(v.balance);	
					}
                }else{
					$("#<?php echo $module['module_name'];?> .submit").css('display','inline-block');	
				}
            });
		});
		
		function update_costs(){
			if($("#<?php echo $module['module_name'];?> .top_price").val()!='' && $("#<?php echo $module['module_name'];?> #day").attr('value')!=0){
				$("#<?php echo $module['module_name'];?> .costs").html($("#<?php echo $module['module_name'];?> .top_price").val()*$("#<?php echo $module['module_name'];?> #day").attr('value'));
				if(parseFloat($("#<?php echo $module['module_name'];?> .costs").html())>parseFloat($("#<?php echo $module['module_name'];?> .balance").html())){
					$("#<?php echo $module['module_name'];?> .submit").css('display','none');
				}else{
					$("#<?php echo $module['module_name'];?> .submit").css('display','inline-block');
				}
			}	
		}
    });
    
	
    </script>
    <style>
	.page-footer,.fixed_right_div{ display:none;}
    #<?php echo $module['module_name'];?>_html{ width:700px; margin-top:10px; margin-left:100px;}
	#<?php echo $module['module_name'];?>_html .info{ line-height:30px;}
    #<?php echo $module['module_name'];?>_html b{ font-weight:normal; }
    #<?php echo $module['module_name'];?>_html b a{ }
	
	#<?php echo $module['module_name'];?>_html .line{line-height:40px;}
	#<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align:top; }
	#<?php echo $module['module_name'];?>_html .line .input_span{display:inline-block; vertical-align:top; width:70%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .line .input_span input{ padding-left:5px;}
	#<?php echo $module['module_name'];?>_html .line .input_span input[type=radio]{ margin-top:0.6rem;}
	#<?php echo $module['module_name'];?>_html .remark{}
	#<?php echo $module['module_name'];?>_html .day_option{ line-height:30px;}
	#<?php echo $module['module_name'];?>_html .day_option input{ display: inline-block; vertical-align:top; border:none;}
	#<?php echo $module['module_name'];?>_html .costs{ }
    </style>
	<div id="<?php echo $module['module_name'];?>_html">
    	<div class=info><?php echo $module['info'];?></div>
        <div class=line><span class=m_label><?php echo self::$language['day_offer'];?>：</span><span class=input_span><input type="text" class=top_price onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" /><?php echo self::$language['yuan'];?> <span class=state></span> <span class=remark><?php echo self::$language['top_min_price'];?><b><?php echo $module['top_min_price']?></b><?php echo self::$language['yuan'];?> </span></span></div>
        <div class=line><span class=m_label><?php echo self::$language['promotion_duration'];?>：</span><span class=input_span id=day value="0"><?php echo $module['list']?></span></div>
        <div class=line><span class=m_label><?php echo self::$language['start_time'];?>：</span><span class=input_span><input type="text" value="<?php echo $module['time']?>" class=top_start id=top_start  onclick=show_datePicker(this.id,'date_time') onblur= hide_datePicker()  /> <span class=state></span></span></div>
        <div class=line><span class=m_label><?php echo self::$language['costs'];?>：</span><span class=input_span><span class=costs></span></span></div>
        <br /> <br />
        <a href=# class=submit><?php echo self::$language['confirm'];?><?php echo self::$language['pay_promotion'];?></a> <span></span> <?php echo $module['balance'];?>
    </div>

</div>
