<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		temp='<?php echo @$_GET['ids']?>';
		temp=temp.split(',');
		for(i in temp){
			if(temp[i]){$("#<?php echo $module['module_name'];?> [d_id="+temp[i]+"]").addClass('selected');}
			
		}
		$("#<?php echo $module['module_name'];?>_html .list b").click(function(){
			if($(this).attr('class')!='selected'){
				$(this).attr('class','selected');
			}else{
				$(this).attr('class','');
			}	
			set_selected();
		});
    });
    
	function set_selected(){
		var ids='';
		var names='';
		$("#<?php echo $module['module_name'];?> .list b").each(function(index, element) {
            if($(this).attr('class')=='selected'){ids+=$(this).attr('d_id')+',';names+='<b>'+$(this).html()+'</b>';}
        });
		parent.set_groups(<?php echo @$_GET['w_id']?>,ids,names);	
	}
    </script>
    <style>
    #<?php echo $module['module_name'];?>_html .name{width:200px;}
	#<?php echo $module['module_name'];?>_html .list{}
	#<?php echo $module['module_name'];?>_html .list b{ font-weight:normal; display:inline-block; vertical-align:top; width:8.5%; overflow:hidden; white-space: nowrap; line-height:2rem; border-radius:0.5rem; margin:0.5rem; background-color: #F6F6F6; border:#ccc solid 1px; text-indent:5px;  cursor:pointer;}
	#<?php echo $module['module_name'];?>_html .list b:hover{ background-color:#F90; color:#FFF;}
	#<?php echo $module['module_name'];?>_html .list b i{ font-style:normal;}
	#<?php echo $module['module_name'];?>_html .list .selected{ background-color:#F90; color:#FFF; border:#fff solid 1px; }
	#<?php echo $module['module_name'];?>_html .list .selected:after{margin-left:5px; font: normal normal normal 1rem/1 FontAwesome; content:"\f00c";}
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
		<div class=list><?php echo $module['list']?></div>
    </div>

</div>
