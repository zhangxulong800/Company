

<!--top_html5(<?php echo $input_name?>)开始-->
<div id=<?php echo $input_name;?>_ele style=" width:<?php echo $div_width;?>; display:inline-block;">
        <input type="file" id="<?php echo $input_name?>_file"  <?php echo $multiple;?> onChange="top_html5_UpladFile(<?php echo "'{$input_name}','{$save_dir}','{$dir_append_date}','{$sourceName}','{$top_html5_suffix}','{$max_size}','{$min_size}'";?>)" />
        <input type="hidden" id="<?php echo $input_name?>" name="<?php echo $input_name?>" />
        <a href="#" id="<?php echo $input_name?>_click_target" onClick="return top_html5_show_up_info('<?php echo $input_name?>','<?php echo $input_name?>');" style=" float:right;">︾</a>
       
        <div id=<?php echo $input_name?>_up_info style="display:none;">
            <div id="<?php echo $input_name?>_progress_div" style="display:none;"><progress id="<?php echo $input_name?>_progressBar" value="0" max="100"></progress><span id="<?php echo $input_name?>_percentage"></span></div>
            <fieldset style="width:<?php echo $div_width;?>; border-radius:10px; display:none" id="<?php echo $input_name?>_fieldset_succeedList">
                <legend><?php echo $language['upload_succeed'];?></legend><div id="<?php echo $input_name?>_succeedList"></div>
            </fieldset>
            <fieldset style="width:<?php echo $div_width;?>;border-radius:10px; display:none" id="<?php echo $input_name?>_fieldset_failedList">
                <legend><?php echo $language['upload_failed'];?></legend> <div id="<?php echo $input_name?>_failedList"></div>
        </fieldset>
    </div>
</div>
<!--top_html5(<?php echo $input_name?>) 结束-->
