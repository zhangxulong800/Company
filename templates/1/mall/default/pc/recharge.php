<script src="./plugin/datePicker/index.php"></script>
<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .limit a[href='./index.php?monxin=mall.recharge&start_time=<?php echo $_GET['start_time']?>&end_time=<?php echo $_GET['end_time']?>']").attr('class','current');
		$("#<?php echo $module['module_name'];?> .money_div .title").html($("#<?php echo $module['module_name'];?> .limit .current").html());
		if($("#<?php echo $module['module_name'];?> .limit .current").html()==null){
			$("#<?php echo $module['module_name'];?> .money_div .title").html('<?php echo $_GET['start_time']?>  <?php echo self::$language['to']?> <?php echo $_GET['end_time']?>');
		}
    });
    </script>
    
   <style>
    #<?php echo $module['module_name'];?> { }
    #<?php echo $module['module_name'];?>_html{ padding-top:20px;padding-bottom:20px;}
	#<?php echo $module['module_name'];?>_html .line{ display:inline-block; width:30%; line-height:50px;}
	#<?php echo $module['module_name'];?>_html .line .input input{}
	#<?php echo $module['module_name'];?>_html .sum{ text-align:right; line-height:3rem;}
	#<?php echo $module['module_name'];?>  .limit{display:inline-block; vertical-align:top; }
    #<?php echo $module['module_name'];?>  .limit a{ display:inline-block; margin-left:10px;margin-right:10px; padding-left:5px; padding-right:5px; }
    #<?php echo $module['module_name'];?>  .limit .current{ color:#FFF; background-color:#F30; }
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html" monxin-table=1>
        <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['username']?>"  class="form-control" ></m_label></div></div></div>
        <div class="filter">
                <?php echo self::$language['content_filter']?>:
                
            <span id=time_limit class=limit><?php echo $module['days'];?>&nbsp; &nbsp;  <?php echo self::$language['custom_date']?>: <span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
            <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>
        </div>
    	<div class=sum><?php echo self::$language['sum']?>:<?php echo $module['sum']?></div>
        <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <td><?php echo self::$language['username']?></td>
                    <td><?php echo self::$language['money']?></td>
                    <td><?php echo self::$language['time']?></td>
                    <td><?php echo self::$language['operator']?></td>
                </tr>
            </thead>
            <tbody>
        <?php echo $module['list']?>
            </tbody>
        </table></div>
        <?php echo $module['page']?>
        
    
    
    </div>
</div>

