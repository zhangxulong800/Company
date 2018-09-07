<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
        $(".monxin_dir_tree li").click(function(){
            if($(this).children('ul').html()){
                if($(this).children('ul').css('display')=='none'){
                    $(this).children('ul').css('display','block');
                }else{
                    $(this).children('ul').css('display','none');
                }	
            }
            return false;	
        });
		
		$("#<?php echo $module['module_name'];?> li div").each(function(index, element) {
			if($(this).next('ul').children('li').length>0){$(this).html($(this).html()+'<span class=sum>'+$(this).next('ul').children('li').length+'</span>');}
            
        });
    });
    </script>
    
    <style>

	.monxin_dir_tree{ border:0px; margin:0px; }
	.monxin_dir_tree li{ list-style:none; line-height:2rem;}
	.monxin_dir_tree li div{ padding-bottom:0.5rem;}
	.monxin_dir_tree li div_stop:before{margin-right:5px; font: normal normal normal 1rem/1 FontAwesome; content:"\f007";}
	.monxin_dir_tree li div img{overflow:hidden; background: rgba(228,228,228,1.00); margin-right:2px;}
	.monxin_dir_tree ul{ display:block;}
    #<?php echo $module['module_name'];?> { }
    #<?php echo $module['module_name'];?> .monxin_dir_tree{ }
    #<?php echo $module['module_name'];?> .monxin_dir_tree .level_0{ cursor:pointer;}
    #<?php echo $module['module_name'];?> .monxin_dir_tree .level_1{ cursor:pointer; margin-left:1.5rem; border-left:1px dashed #ccc; }
    #<?php echo $module['module_name'];?> .monxin_dir_tree .level_2{margin-left:2.2rem;  cursor:pointer; opacity:0.7; border-left:1px dashed #ccc; }
    #<?php echo $module['module_name'];?> .monxin_dir_tree .level_3{margin-left:2rem;  opacity:0.5;border-left:1px dashed #ccc; }
	
	
    #<?php echo $module['module_name'];?> .monxin_dir_tree .level_1 div:before {content: "--"; color:#ccc;}
	 
	 #<?php echo $module['module_name'];?> .monxin_dir_tree .level_1 > li:last-child{ margin-left:-1px; background:#fff; background:url(<?php echo get_template_dir(__FILE__);?>/img/2.png); background-repeat:no-repeat;}
	 #<?php echo $module['module_name'];?> .monxin_dir_tree .level_1 > li:last-child div:before { padding-left:1rem;content: ""; }
	
	 #<?php echo $module['module_name'];?> .monxin_dir_tree .level_2 > li:last-child{ margin-left:-1px; background:#fff; background:url(<?php echo get_template_dir(__FILE__);?>/img/2.png); background-repeat:no-repeat;}
	 #<?php echo $module['module_name'];?> .monxin_dir_tree .level_2 > li:last-child div:before { padding-left:1rem;content: ""; }
	
	 #<?php echo $module['module_name'];?> .monxin_dir_tree .level_3 > li:last-child{ margin-left:-1px; background:#fff; background:url(<?php echo get_template_dir(__FILE__);?>/img/2.png); background-repeat:no-repeat;}
	 #<?php echo $module['module_name'];?> .monxin_dir_tree .level_3 > li:last-child div:before { padding-left:1rem;content: ""; }
	
    #<?php echo $module['module_name'];?> .monxin_dir_tree .level_0 >div >img{ height:3rem; width:3rem; border-radius:1.5rem; background:rgba(224,224,224,1.00);}
    #<?php echo $module['module_name'];?> .monxin_dir_tree .level_1 >li >div >img{ height:2.6rem; width:2.6rem; border-radius:1.3rem;}
    #<?php echo $module['module_name'];?> .monxin_dir_tree .level_2 >li >div >img{ height:2.2rem; width:2.2rem; border-radius:1.1rem;}
    #<?php echo $module['module_name'];?> .monxin_dir_tree .level_3  >li>div >img{ height:1.8rem; width:1.8rem; border-radius:0.8rem;}
	
	#<?php echo $module['module_name'];?> .monxin_dir_tree .level_2:hover > div{ }

    #<?php echo $module['module_name'];?> .sum{ display:inline-block; vertical-align:top; min-width:1.2rem; height:1.2rem; line-height:1.2rem; border-radius:0.6rem; padding-left:4px; padding-right:4px; background:#FF4F4F; color:#fff; font-size:0.8rem; text-align:center; margin-top:6px; margin-left:3px; overflow:auto;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
      
      
    <ul class=monxin_dir_tree>
    	<li class="level_0">
           <div><img src="<?php echo $module['my_icon'];?>" />我</div>
                  <ul class=level_1><?php echo   $module['list']?></ul>
              </li>
    </ul>
      
      
    </div>
</div>