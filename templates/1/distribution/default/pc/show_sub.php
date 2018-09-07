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
	.fixed_right_div{ display:none;}
	.monxin_dir_tree{ border:0px; margin:0px; }
	.monxin_dir_tree li{ list-style:none; line-height:2rem;}
	.monxin_dir_tree li div{ padding-left:1rem;}
	.monxin_dir_tree li div:before{margin-right:5px; font: normal normal normal 1rem/1 FontAwesome; content:"\f007";}
	.monxin_dir_tree ul{ display:block;}
    #<?php echo $module['module_name'];?> { padding:0px; margin:0px; padding-bottom:3rem; }
    #<?php echo $module['module_name'];?> .monxin_dir_tree{ }
    #<?php echo $module['module_name'];?> .monxin_dir_tree .level_0{ cursor:pointer;}
    #<?php echo $module['module_name'];?> .monxin_dir_tree .level_1{ cursor:pointer; margin-left:3rem; }
    #<?php echo $module['module_name'];?> .monxin_dir_tree .level_2{margin-left:3rem;  cursor:pointer; opacity:0.7;}
    #<?php echo $module['module_name'];?> .monxin_dir_tree .level_3{margin-left:3rem;  opacity:0.5; }
	
	#<?php echo $module['module_name'];?> .monxin_dir_tree .level_2:hover > div{ }

    #<?php echo $module['module_name'];?> .sum{ padding-left:5px; opacity:0.5;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
      
      
    <ul class=monxin_dir_tree>
    	<li class="level_0">
           <div><?php echo $_GET['username']?></div>
                  <ul class=level_1><?php echo   $module['list']?></ul>
              </li>
    </ul>
      
      
    </div>
</div>