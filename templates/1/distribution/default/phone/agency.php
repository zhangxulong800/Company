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

    });
    </script>
    
    <style>

	.monxin_dir_tree{ border:0px; margin:0px; }
	.monxin_dir_tree li{ list-style:none; line-height:2rem;}
	.monxin_dir_tree li div{ padding-left:1rem;}
	.monxin_dir_tree li div:before{margin-right:5px; font: normal normal normal 1rem/1 FontAwesome; content:"\f007";}
	.monxin_dir_tree ul{ display:block;}
    #<?php echo $module['module_name'];?> { }
    #<?php echo $module['module_name'];?> .monxin_dir_tree{ }
    #<?php echo $module['module_name'];?> .monxin_dir_tree .level_1{ cursor:pointer;  }
    #<?php echo $module['module_name'];?> .monxin_dir_tree .level_2{margin-left:3rem;  cursor:pointer; opacity:0.7;}
    #<?php echo $module['module_name'];?> .monxin_dir_tree .level_3{margin-left:3rem;  opacity:0.5; }
	
	#<?php echo $module['module_name'];?> .monxin_dir_tree .level_2:hover > div{ }

    
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
      
      
    <ul class=monxin_dir_tree>
    	<li class="level_1">
           <div>我</div>
                <ul >
                
                  <?php echo   $module['list']?>
                  
                </ul>
              </li>
    </ul>
      
      
    </div>
</div>