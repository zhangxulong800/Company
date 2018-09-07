<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		//alert($("html").attr('browser'));
		//alert($("html").attr('platform'));
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			return false;
		});
		$("#<?php echo $module['module_name'];?> .receiver a[iframe='1']").click(function(){
			set_iframe_position($(window).width(),$(window).height());
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src',$(this).attr('href'));
			return false;	
		});
		$(document).on('click', "#<?php echo $module['module_name'];?> .receiver .content .option",function() {
			$("#<?php echo $module['module_name'];?> .receiver").attr('receiver_id',$(this).attr('id').replace(/receiver_/,''));
			$("#<?php echo $module['module_name'];?> .receiver .content .option").attr('class','option');
			$(this).addClass('selected');
			return false;	
		});
		$(document).on('click', "#<?php echo $module['module_name'];?>  .receiver .content .edit",function() {
			set_iframe_position($(window).width(),$(window).height());
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','./index.php?monxin=mall.receiver_edit&buy_method=<?php echo @$_GET['buy_method'];?>&id='+$(this).parent().parent().attr('id').replace(/receiver_/,''));
			return false;	
		});
		
		
		
		$("#<?php echo $module['module_name'];?> .del").click(function(){
			if(confirm("<?php echo self::$language['delete_confirm']?>")){
				temp=$(this).parent().parent().attr('id').replace(/receiver_/,'');
				$(this).parent().parent().remove();
				$.get('<?php echo $module['action_url'];?>&act=del',{id:temp});
			}
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .go_left").click(function(){
			a=$(this).parent().parent();
			b=a.prev();
			a.insertBefore(b);
			set_sequence();
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .go_right").click(function(){
			a=$(this).parent().parent();
			b=a.next();
			a.insertAfter(b);
			set_sequence();
			return false;	
		});
			
	});
	function set_sequence(){
		temp='';
		$("#<?php echo $module['module_name'];?> .option").each(function(index, element) {
            temp+=$(this).attr('id').replace(/receiver_/,'')+':'+index+',';
        });
		$.post('<?php echo $module['action_url'];?>&act=set_sequence',{data:temp});
	}
	
	function  close_select_window(){
		$("#fade_div").css('display','none');
		$("#set_monxin_iframe_div").css('display','none');
		if( getCookie('receiver_id')!=''){
			$("<a href='#' class='option' id=receiver_"+getCookie('receiver_id')+"><span class='fa fa-spinner fa-spin'> <?php echo self::$language['loading']?></span></a>").insertBefore("#<?php echo $module['module_name'];?> .receiver .content .new");
			
            $.get('<?php echo $module['action_url'];?>&act=get_receiver&id='+getCookie('receiver_id'), function(data){
				$("#<?php echo $module['module_name'];?> .receiver .content .option").attr('class','option');
                $("#<?php echo $module['module_name'];?> .receiver .content #receiver_"+getCookie('receiver_id')).html(data).addClass('selected');
				$("#<?php echo $module['module_name'];?> .receiver").attr('receiver_',getCookie('receiver_id'));
            });
		}
		
	}
	
	function  close_select_window2(){
		$("#fade_div").css('display','none');
		$("#set_monxin_iframe_div").css('display','none');
		if( getCookie('receiver_id')!=''){
            $.get('<?php echo $module['action_url'];?>&act=get_receiver&id='+getCookie('receiver_id'), function(data){
                $("#<?php echo $module['module_name'];?> .receiver .content #receiver_"+getCookie('receiver_id')).html(data).addClass('selected');
				$("#<?php echo $module['module_name'];?> .receiver").attr('receiver_',getCookie('receiver_id'));
            });
		}
		
	}
    </script>
    <style>
	#<?php echo $module['module_name'];?>{     background-color: rgb(243, 243, 243);} 
	#<?php echo $module['module_name'];?>_html{} 

	#<?php echo $module['module_name'];?>_html .receiver{ }
	#<?php echo $module['module_name'];?>_html .receiver .content{}
	#<?php echo $module['module_name'];?>_html .receiver .content .option{ padding:0.3rem;  display: block; width:100%; margin-bottom:1rem;   border: #E4E4E4 solid 1px; text-align:left; line-height:30px;box-shadow: 0px 2px 5px 2px rgba(0, 0, 0, 0.1); background:#fff;}
	#<?php echo $module['module_name'];?>_html .receiver .content .option .receiver_head{ white-space:nowrap; border-bottom:1px solid  #DFDFDF; padding-bottom:5px; margin-bottom:5px;}
	#<?php echo $module['module_name'];?>_html .receiver .content .option .receiver_head .name{ display:inline-block; vertical-align:top; vertical-align:top; width:60%;  overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .receiver .content .option .receiver_head .tag{display:inline-block; vertical-align:top; vertical-align:top; width:40%;text-align:right; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .receiver .content .option .receiver_head .tag span{  padding:5px;}
	#<?php echo $module['module_name'];?>_html .receiver .content .option .button_div span{ display:  inline-block; vertical-align:top; line-height:25px; height:25px; overflow:hidden; font-size:1rem; width:50px; margin-right:10px; text-align:center;  border: #E4E4E4 solid 1px;  width:20%;	}
	
	#<?php echo $module['module_name'];?>_html .receiver .content .option .button_div .go_left{}
	#<?php echo $module['module_name'];?>_html .receiver .content .option .button_div .go_left:before{	font: normal normal normal 18px/1 FontAwesome;content: "\f106";}
	#<?php echo $module['module_name'];?>_html .receiver .content .option .button_div .go_left:hover{}
	#<?php echo $module['module_name'];?>_html .receiver .content .option .button_div .go_right{}
	#<?php echo $module['module_name'];?>_html .receiver .content .option .button_div .go_right:before{	font: normal normal normal 18px/1 FontAwesome;content: "\f107";}
	#<?php echo $module['module_name'];?>_html .receiver .content .option .button_div .go_right:hover{ }
	#<?php echo $module['module_name'];?>_html .receiver .content .new{padding:0.3rem;  display: block; width:100%; margin-bottom:2rem;   border: #E4E4E4 solid 1px; text-align:left; line-height:30px;box-shadow: 0px 2px 5px 2px rgba(0, 0, 0, 0.1); }
	#<?php echo $module['module_name'];?>_html .receiver .content .new .add{ }
	
		
	#set_monxin_iframe_div{top:40%; left:420px; }
	#monxin_iframe{ height:100px;width:500px; overflow:scroll;}
	html[platform='iPhone'] #set_monxin_iframe_div{ z-index:99999999999999; position: absolute !important;text-align:right;display:none; }
	#close_button{ display:none;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
         <div class="portlet-title" style="box-shadow: 0px 2px 5px 2px rgba(0, 0, 0, 0.1);  padding-left:0.5rem; display:none;">
            <div class="caption"><?php echo $module['monxin_table_name']?></div>
		</div>

        <div class=receiver>
            <div class=content>
                <?php echo $module['receiver'];?>
                <div class="new">
                    <a href="./index.php?monxin=mall.receiver_add&buy_method=<?php echo @$_GET['buy_method'];?>" iframe="1" class=add><?php echo self::$language['use_new_address'];?></a>
                </div>
            </div>
        </div>
        
    </div>
</div>