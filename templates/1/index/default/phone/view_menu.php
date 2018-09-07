<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?>_html #program").change(function(){
			url=window.location.href;
			url=replace_get(url,'program',$(this).prop("value"));
			window.location.href=url;	
		});
		$("#<?php echo $module['module_name'];?>_html #program").prop('value',get_param('program'));
                
        $("#<?php echo $module['module_name'];?>_html .menu_sequence").blur(function(){
            $("#<?php echo $module['module_name'];?>_html #sequence_state").html("<span class='fa fa-spinner fa-spin'></span>");
            url='<?php echo $module['action_url'];?>&id='+this.id+"&sequence="+this.value;
            url=url.replace("sequence_","");
            $("#<?php echo $module['module_name'];?>_html #sequence_state").load(url,function(){
                if($(this).html().length>5){
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}


                    $(this).html(v.info);
                    if(v.state=='success'){window.location.href=window.location.href;}
                }	
            });
        });
        $("#<?php echo $module['module_name'];?>_html #group_"+get_param('id')).attr('class','current').css('width',$("#group_"+get_param('id')).width()+5);
        $("#<?php echo $module['module_name'];?>_html #current_group").html($("#<?php echo $module['module_name'];?>_html #group_"+get_param('id')).html()+"  &nbsp;");
        
        page=get_param("monxin").replace(".","_");
        $("#<?php echo $module['module_name'];?>_html #"+page+"_table").attr("class","current_table");		
        $("#<?php echo $module['module_name'];?>_html #"+page+"_td").addClass("current_page");
	   	$("#<?php echo $module['module_name'];?>_html #left_groups a:first-child").css('margin-top',0).css('padding-top',0);
	   	$("#<?php echo $module['module_name'];?>_html #left_groups a:last-child").css('margin-bottom',0).css('padding-bottom',0);
	   
            
    });
    </script>
    

	<style>
	#<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html #icons{width:100%; clear:both; color:#fff;}
    #<?php echo $module['module_name'];?>_html #icons li{ margin:5px; list-style-type:none; text-align:center; vertical-align:middle; width:23%; height:160px; overflow:hidden; float:left;}
    #<?php echo $module['module_name'];?>_html #icons img{width:70px; height:70px; border:0px; background:none; border-radius:none;}
    #<?php echo $module['module_name'];?>_html #icons span{ line-height:20px; font-size:1rem;}
    #<?php echo $module['module_name'];?>_html #icons a{ color:#fff; display:inline-block;}		
    #<?php echo $module['module_name'];?>_html #icons a:hover{ color:#f49800;}
	#<?php echo $module['module_name'];?>_html #icons li a:hover img{ width:80px; height:80px;}
    #<?php echo $module['module_name'];?>_html #icons .menu_sequence{width:50px;border-radius:10px; text-align:center; color:#666;}
    
    #<?php echo $module['module_name'];?>_html #left_groups{min-width:200px; _width:200px;vertical-align:text-top;}
    #<?php echo $module['module_name'];?>_html #left_groups a{ display:block; text-align:left;background-color:#09F; padding:5px; margin:5px; padding-right:0px;  color:#FFF; font-size:20px; line-height:30px; margin-right:-5px; padding-left:10px; background-position:right; background-repeat:repeat-y;}
	#<?php echo $module['module_name'];?>_html #left_groups a:hover{ }
    #<?php echo $module['module_name'];?>_html #left_groups .current{ display:block; text-align:left; background:#383838; margin:5px; margin-right:-5px;  color:#fff; line-height:35px; padding-left:10px; font-size:20px; color:#fff;}
    #<?php echo $module['module_name'];?>_html #right_td{background-color:#383838;width:100%;}
    
    #<?php echo $module['module_name'];?>_html #current_group_div{  width:120px; height:50px; line-height:50px; overflow:hidden;color:#FFF;padding-left:10px;   text-align:center; }
    #<?php echo $module['module_name'];?>_html #current_group_div a{}
    #<?php echo $module['module_name'];?>_html #current_group{ font-size:30px; font-family:"Microsoft YaHei";}   
    #<?php echo $module['module_name'];?>_html #index_view_page_table a:hover{ color:#fe9600;} 
    #<?php echo $module['module_name'];?>_html #index_view_function_table a:hover{ color:#fe9600;}
    #<?php echo $module['module_name'];?>_html .step a{ color: #FFF; font-size:28px; }
    #<?php echo $module['module_name'];?>_html .step_view a{ color:#fff; font-size:12px; }
    #<?php echo $module['module_name'];?>_html .step_edit a{color:#fff;  font-size:12px; }
    #<?php echo $module['module_name'];?>_html .current_table{ border-bottom:#FFF  solid  2px;}
    #<?php echo $module['module_name'];?>_html .current_table td{ padding-bottom:5px; }
	#<?php echo $module['module_name'];?>_html .current_table a:hover{ color:#fe9600;}	
    #<?php echo $module['module_name'];?>_html .current_table .step a{ color:#fff;}
    #<?php echo $module['module_name'];?>_html .current_table .step a:hover{ color:#fe9600;}
    #<?php echo $module['module_name'];?>_html .current_page a:after{ padding-left:3px;font: normal normal normal 1rem/1 FontAwesome; content:"\f0da"; }
    #<?php echo $module['module_name'];?>_html .step_split{ }
    #<?php echo $module['module_name'];?>_html #current_group_td{height:50px;}
    #<?php echo $module['module_name'];?>_html #menu_td{height:50px; white-space:nowrap;}
    #<?php echo $module['module_name'];?>_html #menu_td:after{ padding-left:3px;font: normal normal normal 2.5rem/1 FontAwesome; content:"\f105"; color: #FFF; }
    #<?php echo $module['module_name'];?>_html #page_td{height:50px; white-space:nowrap;}
    #<?php echo $module['module_name'];?>_html #page_td:after{ padding-left:3px;font: normal normal normal 2.5rem/1 FontAwesome; content:"\f105"; color: #FFF; }
    #<?php echo $module['module_name'];?>_html #function_td{ padding-right:40px; height:50px;}
	#<?php echo $module['module_name'];?>_html #program_option{float:left; margin-left:40px; color:#fff;}
	#<?php echo $module['module_name'];?>_html #program_option select {color:#000;}
    
    #right_td div table{margin:20px; background-color:#F60; display:inline-table;}
    #right_td div table a{ color:#FFF;}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">
    
    <div id="sequence_state" style="display:none;"></div>
    <table cellpadding="0" cellspacing="0" width="100%"><tbody>
    <tr><td id="left_groups" width="32%" align="right">
    <?php echo $module['groups']?>
    </td><td id="right_td" valign="top">
        <div align="center" >
        <table  border="0" cellspacing="0" cellpadding="0" >
        <tbody>
          <tr>
            <td align="right" id="current_group_td"><div id=current_group_div ><span id=current_group>:</span></div></td>
            <td id="menu_td">
                <table border="0" cellspacing="1" cellpadding="0" id="index_view_menu_table"> 
                  <tr>
                    <td rowspan="2" class="step"><a href="index.php?monxin=index.<?php echo $module['act'];?>_menu&id=<?php echo $_GET['id'];?>&program=<?php echo @$_GET['program'];?>"><?php echo self::$language['menu']?></a></td>
                    <td class="step_view"  id="index_view_menu_td"><a href="index.php?monxin=index.view_menu&id=<?php echo $_GET['id'];?>&program=<?php echo @$_GET['program'];?>"><?php echo self::$language['view']?></a></td>
                  </tr>
                  <tr>
                    <td  class="step_edit" id="index_edit_menu_td"><a href="index.php?monxin=index.edit_menu&id=<?php echo $_GET['id'];?>&program=<?php echo @$_GET['program'];?>"><?php echo self::$language['edit']?></a></td>
                  </tr>
                </table> 
            
            </td>
            <td id="page_td">
                <table border="0" cellspacing="2" cellpadding="0" id="index_view_page_table">
                  <tr>
                    <td rowspan="2" class="step"><a href="index.php?monxin=index.<?php echo $module['act'];?>_page&id=<?php echo $_GET['id'];?>&program=<?php echo @$_GET['program'];?>"><?php echo self::$language['page_power']?></a></td>
                    <td class=step_view  id="index_view_page_td"><a href="index.php?monxin=index.view_page&id=<?php echo $_GET['id'];?>&program=<?php echo @$_GET['program'];?>"><?php echo self::$language['view']?></a></td>
                  </tr>
                  <tr>
                    <td  class="step_edit" id="index_edit_page_td"><a href="index.php?monxin=index.edit_page&id=<?php echo $_GET['id'];?>&program=<?php echo @$_GET['program'];?>"><?php echo self::$language['edit']?></a></td>
                  </tr>
                </table>         
            </td>
            <td id="function_td">
                <table border="0" cellspacing="2" cellpadding="0" id="index_view_function_table" >
                  <tr>
                    <td rowspan="2" class="step"><a href="index.php?monxin=index.<?php echo $module['act'];?>_function&id=<?php echo $_GET['id'];?>&program=<?php echo @$_GET['program'];?>"><?php echo self::$language['function_power']?></a></td>
                    <td class=step_view  id="index_view_function_td"><a href="index.php?monxin=index.view_function&id=<?php echo $_GET['id'];?>&program=<?php echo @$_GET['program'];?>"><?php echo self::$language['view']?></a></td>
                  </tr>
                  <tr>
                    <td  class="step_edit" id="index_edit_function_td"><a href="index.php?monxin=index.edit_function&id=<?php echo $_GET['id'];?>&program=<?php echo @$_GET['program'];?>"><?php echo self::$language['edit']?></a></td>
                  </tr>
                </table>         
            </td>
          </tr>
          </tbody>
        </table>
        </div>
        <div id=program_option><?php echo self::$language['visible']?>：<select id=program name=program><option value=""><?php echo self::$language['all']?></option><?php echo $module['program_option'];?></select></div><br/>
    <?php echo $module['list']?>
    </td></tr></tbody></table>
    </div>
</div>
