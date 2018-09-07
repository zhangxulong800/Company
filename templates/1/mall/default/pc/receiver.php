<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			return false;
		});
		$("#<?php echo $module['module_name'];?> .receiver a[iframe='1']").click(function(){
			set_iframe_position(1000,550);
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
			set_iframe_position(1000,550);
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
	#<?php echo $module['module_name'];?>{} 
	#<?php echo $module['module_name'];?>_html{} 

	#<?php echo $module['module_name'];?>_html .receiver{ }
	#<?php echo $module['module_name'];?>_html .receiver .content{ padding:20px;}
	#<?php echo $module['module_name'];?>_html .receiver .content .option{margin:0px; padding:0px; margin-bottom:20px; display:inline-block; vertical-align:top;vertical-align:top;width:23%; padding:1%; margin-right:2%; height:13.42rem;overflow:hidden;   border: #E4E4E4 solid 1px; text-align:left; line-height:30px;}
	#<?php echo $module['module_name'];?>_html .receiver .content .option:hover{}
	#<?php echo $module['module_name'];?>_html .receiver .content .option .receiver_head{ white-space:nowrap; border-bottom:1px solid  #DFDFDF; padding-bottom:5px; margin-bottom:5px;}
	#<?php echo $module['module_name'];?>_html .receiver .content .option .receiver_head .name{ display:inline-block; vertical-align:top; vertical-align:top; width:60%;  overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .receiver .content .option .receiver_head .tag{display:inline-block; vertical-align:top; vertical-align:top; width:40%;text-align:right; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .receiver .content .option .receiver_head .tag span{  padding:5px;}
	#<?php echo $module['module_name'];?>_html .receiver .content .option .button_div{ white-space:nowrap;}
	#<?php echo $module['module_name'];?>_html .receiver .content .option .button_div span{ display:  inline-block; vertical-align:top; line-height:25px; height:25px; overflow:hidden; font-size:1rem; width:50px; margin-right:10px; text-align:center;  border: #E4E4E4 solid 1px;  width:20%;	}
	
	#<?php echo $module['module_name'];?>_html .receiver .content .option .button_div .go_left{}
	#<?php echo $module['module_name'];?>_html .receiver .content .option .button_div .go_left:before{	font: normal normal normal 18px/1 FontAwesome;content: "\f104";}
	#<?php echo $module['module_name'];?>_html .receiver .content .option .button_div .go_left:hover{}
	#<?php echo $module['module_name'];?>_html .receiver .content .option .button_div .go_right{}
	#<?php echo $module['module_name'];?>_html .receiver .content .option .button_div .go_right:before{	font: normal normal normal 18px/1 FontAwesome;content: "\f105";}
	#<?php echo $module['module_name'];?>_html .receiver .content .option .button_div .go_right:hover{ }
	#<?php echo $module['module_name'];?>_html .receiver .content .new{ display:inline-block; vertical-align:top;width:23%; overflow:hidden; }
	#<?php echo $module['module_name'];?>_html .receiver .content .new .add{display:block; margin:0px; padding:0px; width:100%; height:100%; line-height:12.85rem;   text-align:center; border: #E4E4E4 solid 1px; }
	#<?php echo $module['module_name'];?>_html .receiver .content .new .add:hover{ }
	
	#<?php echo $module['module_name'];?>_html .detail{ width:100%; overflow:hidden; font-size:0.9rem; white-space:nowrap;text-overflow: ellipsis;}
	#<?php echo $module['module_name'];?>_html .area_id{ line-height:1.5rem;}	
	#set_monxin_iframe_div{top:40%; left:420px; }
	#monxin_iframe{ height:100px;width:500px; overflow:scroll;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
         <div class="portlet-title">
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