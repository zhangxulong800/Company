<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./plugin/datePicker/index.php"></script>
    <script>
    $(document).ready(function(){
		
    });

    </script>
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html .store_name{}
    #<?php echo $module['module_name'];?>_html .store_name img{ height:2rem; padding-right:0.3rem;}
	#<?php echo $module['module_name'];?>_html .order_state_0{ }
	#<?php echo $module['module_name'];?>_html .order_state_1{ }
	#<?php echo $module['module_name'];?>_html .order_state_2{ }
	#<?php echo $module['module_name'];?>_html .sum_div{ margin-top:1rem; margin-bottom:1rem;}
	#<?php echo $module['module_name'];?>_html .me{  font-weight:bold;}
	
	#<?php echo $module['module_name'];?>_html .head_other{margin-top: 1rem;margin-bottom: 1rem;box-shadow: 0px 2px 5px 2px rgba(0, 0, 0, 0.1);padding: 0.5rem;}
	#<?php echo $module['module_name'];?>_html .order_div{margin-top: 1rem;margin-bottom: 1rem;box-shadow: 0px 2px 5px 2px rgba(0, 0, 0, 0.1);padding: 0.5rem; line-height:1.6rem;}
	#<?php echo $module['module_name'];?>_html .order_div .time_and_state{ white-space:nowrap; }
	#<?php echo $module['module_name'];?>_html .order_div .time_and_state .time{ display:inline-block; vertical-align:top; width:50%;}
	#<?php echo $module['module_name'];?>_html .order_div .time_and_state .state{display:inline-block; vertical-align:top; width:50%; text-align:right;}
	#<?php echo $module['module_name'];?>_html .order_div .buyer_and_shop{ white-space:nowrap; }
	#<?php echo $module['module_name'];?>_html .order_div .buyer_and_shop .buyer{ display:inline-block; vertical-align:top; width:34%;}
	#<?php echo $module['module_name'];?>_html .order_div .buyer_and_shop .order_agency_money{display:inline-block; vertical-align:top; width:27%; }
	#<?php echo $module['module_name'];?>_html .order_div .buyer_and_shop .shop_name{display:inline-block; vertical-align:top; width:40%; text-align:right;}
	
	#<?php echo $module['module_name'];?>_html .order_div .commission{ white-space:nowrap;  text-align:;left; border-top:#CCC 1px dashed;}
	#<?php echo $module['module_name'];?>_html .order_div .commission .shopkeeper_1{ display:inline-block; vertical-align:top; width:33%;}
	#<?php echo $module['module_name'];?>_html .order_div .commission .shopkeeper_2{display:inline-block; vertical-align:top; width:33%; }
	#<?php echo $module['module_name'];?>_html .order_div .commission .shopkeeper_3{display:inline-block; vertical-align:top; width:31%; text-align:right;}
	
	
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class=head_other>
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['buyer']?>"  class="form-control" ></m_label></div></div></div>
    
    
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <?php echo $module['filter']?>
		<span id=time_limit><span class=start_time_span><?php echo self::$language['pay']?><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
        <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>
		
		<?php echo $module['sum_html']?>
    </div>
    </div>
   	 <?php echo $module['list']?>
    <div class=m_row><?php echo $module['page']?></div>
    </div>
    </div>

</div>
