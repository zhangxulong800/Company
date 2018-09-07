<div id=<?php echo $module['module_name'];?>  monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./plugin/datePicker/index.php"></script>
    <script>
    $(document).ready(function(){
		
		if(get_param('check_code_state')!=2){
			$("#<?php echo $module['module_name'];?> .nav-tabs a[check_code_state='1']").parent().addClass('active');
		}else{
			$("#<?php echo $module['module_name'];?> .nav-tabs a[check_code_state='2']").parent().addClass('active');
		}
		
		$("#<?php echo $module['module_name'];?> #check_code").keyup(function(){
			if(event.keyCode==13){inquiry_check_code();}
		});
		
		$("#<?php echo $module['module_name'];?> #check_code").next('a').click(function(){
			inquiry_check_code();
			return false;	
		});
		
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			return false;
		});

		$(document).on('click',"#<?php echo $module['module_name'];?>  .exe_check", function() {
				id=$(this).attr('d_id');
				$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=exe_check',{id:id,check_code:$("#<?php echo $module['module_name'];?> #check_code").val()}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					
					$("#state_"+id).html(v.info);
					if(v.state=='success'){
						$("#tr_"+id+" .operation_td").html('');
						$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state").html('<?php echo self::$language['order_state'][6];?>');
					}
				});
			return false; 	
		});
		
		
		$(window).scroll(function(){
			if($(window).scrollTop()>350){
				$(".sort .sort_inner").css('width',$("#<?php echo $module['module_name'];?>").width());
				$(".sort").css('width','100%').css('left','0px');
				$(".sort").css('position','fixed').css('top','0px').css('margin-top','0px').css('box-shadow','0 0 5px #888');
			}else{
				$(".sort").css('position','static').css('margin-top','10px').css('box-shadow','none');
			}		
		});


		$("#<?php echo $module['module_name'];?> .order_tr").each(function(index, element) {
            $(this).children('div').css('height',$(this).height());
        });
    });
    
    function select_all(){
		//monxin_alert('select_all');
        $(" tbody .id").prop('checked',true);
        $(" tbody .goods_id").prop('checked',true);
        $(" tbody tr").addClass('checked');
        return false;	
    }
    function reverse_select(){
        $(" tbody .id").each(function(){
            $(this).prop("checked",!this.checked);
            if($(this).prop('checked')){
                $("#tr_"+this.id).addClass('checked');
				$("#tr_"+this.id+" .goods_id").prop('checked',true);
            }else{
                $("#tr_"+this.id).removeClass('checked');
				$("#tr_"+this.id+" .goods_id").prop('checked',false);
            }
                  
        });
       return false; 	
    }
    
    function get_ids(){
        ids='';
        $("#<?php echo $module['module_name'];?> .id").each(function(){
            if($(this).prop("checked")){ids+=this.id+"|";}              
        });
        return ids;
    }
    function get_goods_ids(){
        ids='';
        $("#<?php echo $module['module_name'];?> .goods_id").each(function(){
            if($(this).prop("checked")){ids+=this.id+"|";}              
        });
        return ids;
    }
	
	function inquiry_check_code(){
		//if($("#<?php echo $module['module_name'];?> #check_code").val()==''){return false;}
		window.location.href='./index.php?monxin=mall.check_code&check_code_state=1&check_code='+$("#<?php echo $module['module_name'];?> #check_code").val();
	}
	
    </script>
	<style>
	#<?php echo $module['module_name'];?> .light{ background:<?php echo $_POST['monxin_user_color_set']['module']['background']?>;}
    #<?php echo $module['module_name'];?>{background:<?php echo $_POST['monxin_user_color_set']['container']['background']?>  !important;}
	#<?php echo $module['module_name'];?> input {margin:0 5px;}
    #<?php echo $module['module_name'];?> .add_comment{ padding-left:10px; font-style:oblique;}
    #<?php echo $module['module_name'];?> .m_row,.filter{ background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; padding:0.3rem;} 
    #<?php echo $module['module_name'];?> .filter{} 
	
	
	.mall_order{ background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; margin-top:1rem;margin-bottom:1rem;box-shadow: 0px 2px 5px 2px rgba(0, 0, 0, 0.1);padding:0.5rem;}
	.mall_order .order_head{ line-height:2rem; border-bottom: 1px solid  #EEE; }
	.mall_order .order_head .shop_name{ display:inline-block; vertical-align:top; width:50%;}
	.mall_order .order_head .shop_name:after{margin-left:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f105"; }
	.mall_order .order_head .order_state{display:inline-block; vertical-align:top; width:50%; text-align:right; font-weight:bold; color:red;}
	.preferential_td{text-align:right; line-height:3rem;}
	.preferential_td div{ display:inline-block;}
	.preferential_td .big_money{ color:#F00; }
	.operation_td{ text-align:right;}
	.goods_td{}
	.goods_td .goods_info{ padding:0.3rem;  margin-bottom:0.5rem;}
	.goods_td .goods_info .goods_div{ border-bottom: 1px #CCCCCC dashed; padding-top:0.3rem; padding-bottom:0.3rem;}
	.goods_td .goods_info .icon{ display:inline-block; vertical-align:top; width:20%; text-align:center;}
	.goods_td .goods_info .icon img{ width:80%;}
	.goods_td .goods_info .other{display:inline-block; vertical-align:top; width:80%; color:#999; }
	.goods_td .goods_info .other a{ color:#999; }
	.goods_td .goods_info .other .title{ line-height:1.5rem; height:3rem; overflow:hidden; }
	.goods_td .goods_info .other .price{ 		}
	.state_remark{ display: block; text-align:right; line-height:3rem;}	
	.state_remark br{ display:none;}	
	.state_remark div{  display:inline-block;}	
	.state_remark a{ display:inline-block; margin-left:0.5rem; padding-left:0.5rem; padding-right:0.5rem; line-height:2rem; border-radius:0.3rem; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?> !important;}	
	.preferential_way{ padding-right:1rem;}
	.preferential_way br{ display:none;}
	.right_notice{ display:none;}
	.express_code{ display:none;}
	#<?php echo $module['module_name'];?> .edit_a{ display:inline-block; height:20px; width:20px; }
	#<?php echo $module['module_name'];?> .edit_b{ display:inline-block; height:20px; width:20px;}
	#<?php echo $module['module_name'];?> .edit_a:before{margin-left:3px; color:#F90; font: normal normal normal 1rem/1 FontAwesome; content:"\f044";}
	#<?php echo $module['module_name'];?> .edit_b:before{margin-left:3px; color:#F90; font: normal normal normal 1rem/1 FontAwesome; content:"\f040";}
    .refund{ margin-left:10px; opacity:0.5;}
	#<?php echo $module['module_name'];?> .caption{ display:block; width:100%;}
	#<?php echo $module['module_name'];?> .portlet-title{ border-bottom:none !important;}
	#<?php echo $module['module_name'];?> .caption:before{ display:none;}
	#<?php echo $module['module_name'];?> .inquiry_div{ text-align:right; }
	#<?php echo $module['module_name'];?> .inquiry_div input{ 	 }
	#<?php echo $module['module_name'];?> .exe_check{}
	#<?php echo $module['module_name'];?> .exe_check:before{margin-left:2px; font: normal normal normal 1rem/1 FontAwesome; content:"\f046";}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    
    <div class=right_notice><span>&nbsp;</span><span class=m>&nbsp;wertgh 444</span><span class=e>&nbsp;</span></div>
    
    
    <div  class="portlet light" >
    	<div class=inquiry_div><input type="text" id=check_code name=check_code placeholder="<?php echo self::$language['check_code_2']?>" value="<?php echo @$_GET['check_code']?>" /><a class=submit href="#"><?php echo self::$language['inquiry'];?></a></div>

    	<div class="portlet-title">
            <div class="caption">
            
            <ul class="nav nav-tabs">
      <li role="presentation"><a check_code_state=1 href="./index.php?monxin=mall.check_code&check_code_state=1"><?php echo self::$language['check_code_option'][1]?></a></li>
      <li role="presentation"><a check_code_state=2  href="./index.php?monxin=mall.check_code&check_code_state=2"><?php echo self::$language['check_code_option'][2]?></a></li>
       
	</ul>
   
           
            </div>
    	</div>
    </div>
    
	<?php echo $module['list']?>
    <?php echo $module['page']?>
    </div>
</div>
