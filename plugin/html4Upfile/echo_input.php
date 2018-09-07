

<!--top_html4 echo_input(<?php echo $input_name?>) 开始-->
<div id=<?php echo $input_name;?>_ele style=" width:<?php echo $div_width;?>; display:inline-block;">
    <input type="hidden" id="<?php echo $input_name?>" name="<?php echo $input_name?>" />
    <input type="file"  id="<?php echo $input_name?>_file" name="<?php echo $input_name?>_file"  onchange="top_html4_upload(<?php echo "'{$input_name}','{$save_dir}','{$dir_append_date}','{$sourceName}','{$top_html4_suffix}','{$max_size}','$min_size','$save_name'";?>);"><img id="<?php echo $input_name?>_icon" src="execute.gif" style="display:none;" /><span  id="<?php echo $input_name?>_span"></span></div>
          
<!--top_html4 echo_input(<?php echo $input_name?>) 结束-->
