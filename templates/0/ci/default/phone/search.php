<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		if(get_param('monxin')=='' || get_param('monxin')=='index.index' ||  get_param('monxin')=='ci.newest'){
			$("#<?php echo $module['module_name'];?> .for_index_search").css('display','block');
			if($("#mySwipe").offset()){
				setTimeout('reset_index_search_top()',200);
				$(".for_index_search").css('top','0px');
			}
			$(window).scroll(function() {
			  	if($(window).scrollTop()>$("#<?php echo $module['module_name'];?> .for_index_search").height()){
					$("#<?php echo $module['module_name'];?> .for_index_search").addClass('for_index_search_fixed');
				}else{
					$("#<?php echo $module['module_name'];?> .for_index_search").removeClass('for_index_search_fixed');
				}
			});
		}else{
			$("#<?php echo $module['module_name'];?> .show_search_div").css('display','block');	
			$("#<?php echo $module['module_name'];?> .show_search_div input").focus();
			$(".monxin_head,.cart_goods_sum,.monxin_bottom_switch").css('display','none');
			$(".monxin_head").css('margin-top','-1000px');
		}
		
		$("#<?php echo $module['module_name'];?> .for_index_search .search_input_span input").focus(function(){
			window.location.href='./index.php?monxin=ci.search';
			return false;
		});
		$("#<?php echo $module['module_name'];?> .for_index_search .search_input_span input").click(function(){
			window.location.href='./index.php?monxin=ci.search';
			return false;
		});
		$("#<?php echo $module['module_name'];?> .for_index_search .search_input_span input").change(function(){
			window.location.href='./index.php?monxin=ci.search';
			return false;
		});
		$("[monxin='ci.search']").click(function(){
			window.location.href='./index.php?monxin=ci.search';
			return false;
		});
		
		
		$("#<?php echo $module['module_name'];?> .show_search_div .return_div").click(function(){
			window.history.back(-1); 
			return false;
		});
		
		
		
		
		
		$("#<?php echo $module['module_name'];?> .show_search_div input").keyup(function(event){
			keycode=event.which;
			if(keycode==13){
				exe_ci_search();
			}	
		});	
		$("#<?php echo $module['module_name'];?> .show_search_div .button_div").click(function(){
			exe_ci_search();
			return false;
		});
		    
    });
	function reset_index_search_top(){
		$(".for_index_search").css('top','0px');
	}
	
	function exe_ci_search(){
		if($(".show_search_div .search").val()==''){return false;}
		url='./index.php?monxin='+$(".show_search_div .type").val()+'&search='+encodeURI($(".show_search_div input").val());
		window.location.href=url;	
	}
    </script>
    
    <style>
	#index_phone_bottom .monxin_head a{ display:none !important;}
	#<?php echo $module['module_name'];?>{ margin-top:0px; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html{ display:none;}
	#<?php echo $module['module_name'];?>_html .search_input_div #search{ border:none; text-indent:10px;  height:60px; margin-left:10px;   width:65%; font-size:50px; border-radius:10px;}
    #<?php echo $module['module_name'];?>_html .search_input_div .search_ci{  margin-right:30px;}
    #<?php echo $module['module_name'];?>_html .search_input_div .search_shop{margin-top:20px;}
	
	
	#mySwipe .next_prev{ }
	#mySwipe .pagination{ display:none;}
	#mySwipe .up_text{top:-86% !important;}
	#<?php echo $module['module_name'];?> .for_index_search{ display:none;  padding-top:0.5rem; padding-bottom:2px;  z-index:99999999; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; width:100%; line-height:1.6rem;}
	#<?php echo $module['module_name'];?> .for_index_search_fixed{position: fixed;top:-0.5rem; }
	#<?php echo $module['module_name'];?> .for_index_search span{ display:inline-block; vertical-align:top; }
	#<?php echo $module['module_name'];?> .for_index_search .logo_span{ width:20%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .for_index_search .logo_span img{ width:100%;}
	#<?php echo $module['module_name'];?> .for_index_search .search_input_span{width:67%; overflow:hidden;  border-radius:5px; border:#F6F6F6 solid 1px; background:#fff;}
	#<?php echo $module['module_name'];?> .for_index_search .search_input_span:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f002"; padding-right:3px;  padding-left:3px; color:#ccc;}
	#<?php echo $module['module_name'];?> .for_index_search .search_input_span input{width:80%;border:none; outline:none;}
	#<?php echo $module['module_name'];?> .for_index_search .type_span{width:12%; overflow:hidden;  text-align:center;}
	#<?php echo $module['module_name'];?> .for_index_search .type_span a{ display:block; }
	#<?php echo $module['module_name'];?> .for_index_search .type_span a:before{font: normal normal normal 2rem/1 FontAwesome; content:"\f0c9"; padding-right:3px;  padding-left:3px; color:#fff;}
	
	#<?php echo $module['module_name'];?> .show_search_div{ display:none; position: fixed; width:100%; height:100%; top:0px; left:0px;  	 }
	
	#<?php echo $module['module_name'];?> .show_search_div .top_input_div{  padding:5px; line-height:1.5rem; box-shadow: 0px 2px 5px 2px rgba(0, 0, 0, 0.1);background-color: #F6F6F6; }
	#<?php echo $module['module_name'];?> .show_search_div .top_input_div div{ display:inline-block; vertical-align:top; text-align:center;}
	#<?php echo $module['module_name'];?> .show_search_div .top_input_div .return_div{ width:10%;}
	#<?php echo $module['module_name'];?> .show_search_div .top_input_div .return_div:before{font: normal normal normal 2rem/1 FontAwesome; content:"\f104";   color: #CCC;}
	#<?php echo $module['module_name'];?> .show_search_div .top_input_div .input_div{width:77%; overflow:hidden;  border-radius:5px; border:#F6F6F6 solid 1px; border:1px #CCCCCC solid; background:#fff;}
	#<?php echo $module['module_name'];?> .show_search_div .top_input_div .input_div select{ display:inline-block; width:25%;border:none; outline:none; padding-left:1rem;border:0px; border- margin:5px; text-align:left;}
	#<?php echo $module['module_name'];?> .show_search_div .top_input_div .input_div input{display:inline-block;width:99%;border:none; outline:none; padding-left:0.3rem;}
	#<?php echo $module['module_name'];?> .show_search_div .top_input_div .button_div{ width:10%;line-height:1.5rem; padding-top:7px;}
	
	#<?php echo $module['module_name'];?> .show_search_div .hot_search_div{ padding:1rem;}
	#<?php echo $module['module_name'];?> .show_search_div .hot_search_div .title{ line-height:3rem }
	#<?php echo $module['module_name'];?> .show_search_div .hot_search_div .list{ line-height:2rem;}
	#<?php echo $module['module_name'];?> .show_search_div .hot_search_div .list a{ display: inline-block; vertical-align:top; padding-left:0.5rem; padding-right:0.5rem; border-radius:0.3rem; border:#CCC solid 1px; margin-right:1rem; margin-bottom:0.6rem;}
	#<?php echo $module['module_name'];?> .type{  display:none !important;}
    </style>
    <div class=for_index_search>
    	<span class=logo_span><img src=./phone_logo.png /></span><span class=search_input_span><input type="text" placeholder="<?php echo $module['monxin_search_placeholder']?>" /></span><span class=type_span ><a href=./index.php?monxin=ci.show_type></a></span>
    </div>
    
    <div class=show_search_div>
    	<div class=top_input_div>
        	<div class=return_div></div><div class=input_div>
           
         		<select class=type><option value="ci.list">信息</option><option value="ci.shop_list"><?php echo self::$language['shop'];?></option><option value="ci.list">信息</option></select><input type="text"  class='search'  placeholder="<?php echo $module['monxin_search_placeholder']?>" />
            </div><div class=button_div><?php echo self::$language['search'];?></div>
        </div>
        <div class=hot_search_div>
        	<div class=title><?php echo  self::$language['hot_search']?></div>
            <div class=list><?php echo $module['list'];?></div>
        </div>
    </div>
    
    <div id="<?php echo $module['module_name'];?>_html"></div>
</div>