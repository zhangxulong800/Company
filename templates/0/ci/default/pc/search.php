<div id=<?php echo $module['module_name'];?> monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		$("body").click(function(event){
			
			if(event.target.className!='current_v'){$("#<?php echo $module['module_name'];?>_html .option .option_list").css('display','none');}
		});
		if(get_param('search')!=''){
			$("#<?php echo $module['module_name'];?>_html .option .current_v").attr('v',$("#<?php echo $module['module_name'];?> .option .option_list span[v='"+get_param('monxin')+"']").attr('v')).html($("#<?php echo $module['module_name'];?> .option .option_list span[v='"+get_param('monxin')+"']").html());	
		}
		
		$("#<?php echo $module['module_name'];?> #monxin").val($("#<?php echo $module['module_name'];?>_html .option .current_v").attr('v'));
		
		
		$("#<?php echo $module['module_name'];?>_html .option .current_v").click(function(){
			$(this).next('.option_list').css('top',$(this).parent().parent().offset().top+$(this).parent().parent().height()+2);
			if($(this).next('.option_list').css('display')=='none'){
				$(this).next('.option_list').css('display','block');
			}else{
				$(this).next('.option_list').css('display','none');
			}
			
			$("#<?php echo $module['module_name'];?> .option_list span[v='"+$(this).attr('v')+"']").css('display','none');
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> .option .option_list span").click(function(){
			$("#<?php echo $module['module_name'];?> .option .current_v").html($(this).html()).attr('v',$(this).attr('v'));
			$("#<?php echo $module['module_name'];?> .option .option_list span").css('display','block');
			$(this).css('display','none');
			$(this).parent().css('display','none');
			$("#<?php echo $module['module_name'];?> #monxin").val($(this).attr('v'));
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?>").width(container_width*0.35);
        $("#<?php echo $module['module_name'];?>_html #search").focus(function(){
			$(this).attr('placeholder','');
			return false;
		});    
        $("#<?php echo $module['module_name'];?>_html #search").blur(function(){
			$(this).attr('placeholder',$(this).attr('old_placeholder'));
			return false;
		}); 
		$("#<?php echo $module['module_name'];?> .searcch_button").click(function(){
			
			if($("#<?php echo $module['module_name'];?>_html #search").val()=='' && $("#<?php echo $module['module_name'];?>_html #search").attr('placeholder_url')!=''){
				window.location.href=$("#<?php echo $module['module_name'];?>_html #search").attr('placeholder_url');
				return false;
			}else{
				window.location.href='./index.php?monxin='+$("#<?php echo $module['module_name'];?>_html #monxin").val()+'&search='+$("#<?php echo $module['module_name'];?>_html #search").val();
			}
			return false;
		});		
    });
    </script>
    
    <style>
#top_layout_out #top_layout_inner #layout_top {white-space: nowrap;}

	#<?php echo $module['module_name'];?>{width:30%; height:10rem; padding-top:3rem; display:inline-block; vertical-align:top;white-space:nowrap; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .search_input_div{ border:2px <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>  solid; line-height:38px; height:38px; width:100%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .search_input_div .start{  display:inline-block; vertical-align:top; width:5%; height:38px; line-height:38px;display:none;}
	
	#<?php echo $module['module_name'];?>_html .search_input_div .search_middle{ display:inline-block; vertical-align:top; width:73%;}
	#<?php echo $module['module_name'];?>_html .search_input_div #search{ padding-left:10px; width:100%; height:38px; line-height:38px;  border:none; outline:none;}
	#<?php echo $module['module_name'];?>_html .search_input_div .searcch_button{padding: 0px;  display:inline-block; vertical-align:top; width:15%; height:36px; line-height:36px; border-radius:0px; border:0;  text-align:center; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
	#<?php echo $module['module_name'];?>_html .search_input_div .searcch_button:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .search_hot_div{ position:relative; line-height:36px; height:40px; overflow:hidden; left:0px; white-space:nowrap; text-overflow: ellipsis;}
	#<?php echo $module['module_name'];?>_html .search_hot_div a{ padding-right:10px;}
	#<?php echo $module['module_name'];?>_html .search_hot_div a:hover{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}

	#<?php echo $module['module_name'];?>_html .option{ display:inline-block; width:12%;  }
	#<?php echo $module['module_name'];?>_html .option .current_v{ padding-left:5px; cursor:pointer;}
	#<?php echo $module['module_name'];?>_html .option .current_v:after {font: normal normal normal 1rem/1 FontAwesome;margin-left: 5px;padding-right:5px;content:"\f0d7";  opacity:0.6;}
	#<?php echo $module['module_name'];?>_html .option .current_v:hover{ color:red;}
	#<?php echo $module['module_name'];?>_html .option .option_list{cursor:pointer; position:absolute; display:none; top:7.7rem; z-index:99999;  margin-left:-2px;line-height:2rem; }
	#<?php echo $module['module_name'];?>_html .option .option_list span{ display:block;background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['text']?>;padding-left:0.5rem; padding-right:1rem;}
	#<?php echo $module['module_name'];?>_html .option .option_list span:hover{background:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['text']?>;}


    </style>
    <div id="<?php echo $module['module_name'];?>_html">
      <form id="shop_goods_search" name="shop_goods_search" method="get" action="./index.php">
        <div class="search_input_div"><span class=start></span><span class=option><span class=current_v v='ci.list'>信息</span><div class=option_list><span v='mall.goods_list'>商品</span><span v='ci.list'>信息</span><span v='article.show_article_list'>文章</span></div></span><input type="hidden" name="monxin" id="monxin" value="mall.goods_list" /><span class="search_middle"><input type="text" name="search" id="search" value="<?php echo @$_GET['search']?>" placeholder="<?php echo $module['search_placeholder'];?>" old_placeholder="<?php echo $module['search_placeholder'];?>" placeholder_url="<?php echo $module['search_placeholder_url'];?>" /></span><a href="#" class=searcch_button><?php echo self::$language['search']?></a></div>
        <?php echo $module['hot_search_html'];?>
      </form>
    </div>
</div>


	