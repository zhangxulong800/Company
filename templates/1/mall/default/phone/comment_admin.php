<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){		
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			return false;
		});
		$("#<?php echo $module['module_name'];?> .edit").click(function(){
			set_iframe_position($(window).width()-100,$(window).height()-200);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src',$(this).attr('href'));
			//alert($("#monxin_iframe").attr('src'));
			return false;	
		});
		
		
    });
    
    
    function update_comment(id,content){
		$("#<?php echo $module['module_name'];?> #tr_"+id+ " .seller").html('<span class=time><?php echo self::$language['a_moment_ago'];?></span><span class=content>'+content+'</span><span class=point>&nbsp;</span><span class=username><?php echo self::$language['myself'];?></span>');
	}
	
    </script>
	<style>
	#set_monxin_iframe_div{top:40%; left:420px; }
	#monxin_iframe{ height:100px;width:500px; overflow:scroll;}
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .goods_title{ display:block;  text-align:left;}
    #<?php echo $module['module_name'];?> .buyer{ text-align:left;}
    #<?php echo $module['module_name'];?> .buyer .username{text-align:left;}
    #<?php echo $module['module_name'];?> .buyer .point{ display:inline-block; vertical-align:top;}
	#<?php echo $module['module_name'];?> .buyer .point:after{  font: normal normal normal 1rem/1 FontAwesome; content:"\f0d9";color:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>;}

    #<?php echo $module['module_name'];?> .buyer .content{ display:inline-block; vertical-align:top; padding-left:10px;  padding-right:10px; border-radius:5px;  font-size:1rem; max-width:70%;background:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['text']?>;}
    #<?php echo $module['module_name'];?> .buyer .level{ padding-left:10px;}
    #<?php echo $module['module_name'];?> .buyer .time{padding-left:10px;  font-size:13px;}
	
    #<?php echo $module['module_name'];?> .seller{ padding-left:100px; text-align:right;}
    #<?php echo $module['module_name'];?> .seller .username{text-align:left;}
    #<?php echo $module['module_name'];?> .seller .point{display:inline-block; width:6px; vertical-align:top; overflow:hidden;}
	#<?php echo $module['module_name'];?> .seller .point:before{margin-right:8px;  font: normal normal normal 1rem/1 FontAwesome; content:"\f0da";color:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>;}
    #<?php echo $module['module_name'];?> .seller .content{ display:inline-block; vertical-align:top; padding-left:10px;  padding-right:10px; border-radius:5px;  font-size:1rem; max-width:70%;background:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['text']?>;}
    #<?php echo $module['module_name'];?> .seller .time{padding-right:10px;  font-size:13px;}
	
	
	
    #<?php echo $module['module_name'];?> .seller{ text-align:left; margin-top:0.6rem;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['username']?>/<?php echo self::$language['content']?>"  class="form-control" ></m_label></div></div></div>
    
    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['content'];?></td>
                <td  style=" text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
