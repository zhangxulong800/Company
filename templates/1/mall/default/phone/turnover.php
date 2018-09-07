<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./plugin/datePicker/index.php"></script>
    <script>
	
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .limit a[href='./index.php?monxin=mall.turnover&start_time=<?php echo $_GET['start_time']?>&end_time=<?php echo $_GET['end_time']?>']").attr('class','current');
		$("#<?php echo $module['module_name'];?> .money_div .title").html($("#<?php echo $module['module_name'];?> .limit .current").html());
		if($("#<?php echo $module['module_name'];?> .limit .current").html()==null){
			$("#<?php echo $module['module_name'];?> .money_div .title").html('<?php echo $_GET['start_time']?>  <?php echo self::$language['to']?> <?php echo $_GET['end_time']?>');
		}
    });
    
    </script>
	<style>
    #<?php echo $module['module_name'];?>{background:#fff; padding-bottom:100px;}
    #<?php echo $module['module_name'];?> .date_limit{ text-align: center; line-height:30px; margin-top:0.5rem; border-bottom: #999 dashed 1px; padding-bottom:0.5rem;}
    #<?php echo $module['module_name'];?> .date_limit  .m_label{ display:inline-block; vertical-align:top; }
    #<?php echo $module['module_name'];?> .date_limit  .limit{display:inline-block; vertical-align:top; }
    #<?php echo $module['module_name'];?> .date_limit  .limit a{ display:inline-block; margin-left:10px;margin-right:10px; padding-left:5px; padding-right:5px; }
    #<?php echo $module['module_name'];?> .date_limit  .limit .current{ color:#FFF; background-color:#F30; }
    #<?php echo $module['module_name'];?> .date_limit  .limit input{ width:22%; }
	
	#<?php echo $module['module_name'];?> .money_div{ padding-top:20px; line-height:50px;  text-align:center; font-weight:bold;}
	#<?php echo $module['module_name'];?> .money_div .money_sum{ text-align:right; font-size:1.2rem; font-weight:normal; line-height:3rem; }
	#<?php echo $module['module_name'];?> .money_div .money_sum b{ display:inline-block; text-align:left; width:50%; color: #F00; font-size:1.5rem;}
	
	#<?php echo $module['module_name'];?> .money_div .other_sum{}
	#<?php echo $module['module_name'];?> .money_div .other_sum div{ display:inline-block; min-width:30%; height:3rem; line-height:3rem; background-color:#EFEFEF; border:#CCC solid 1px; text-align:center;  margin:1%; }
	#<?php echo $module['module_name'];?> .money_div .other_sum div a{ color:#F30;}
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	<div class=date_limit><span class=m_label style="display:none;"><?php echo self::$language['date'];?>: </span><div class=limit>
        	<?php echo $module['days'];?>
           
             <br /><span id=time_limit><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
        <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><span class=b_start> </span><span class=b_middle><?php echo self::$language['submit']?></span><span class=b_end> </span></a></span> 
        </div></div>
        
        <div class=money_div>
        	<div class=title></div>
            <div class=money_sum>
            	<?php echo self::$language['sum_turnover']?>: <b><?php echo $module['sum_turnover']?></b><br />
            	<?php echo self::$language['goods_cost_2']?>: <b><?php echo $module['goods_cost']?></b><br />
            	<?php echo self::$language['express_charge']?>: <b><?php echo $module['express_charge']?></b><br />
            	<?php echo self::$language['profit']?>: <b><?php echo $module['profit']?></b>
            </div>
            <div class=other_sum>
            	<div class=order><b><?php echo self::$language['order_id']?></b><a href=./index.php?monxin=mall.order_admin&start_time=<?php echo $_GET['start_time']?>&end_time=<?php echo $_GET['end_time']?> target=_blank><?php echo $module['order_count'];?></a><?php echo self::$language['a']?></div>
            	<div class=goods><b><?php echo self::$language['goods_sold_sum']?></b><a href=./index.php?monxin=mall.order_admin&start_time=<?php echo $_GET['start_time']?>&end_time=<?php echo $_GET['end_time']?> target=_blank><?php echo $module['goods_count'];?></a><?php echo self::$language['piece']?></div>
            	<div class=user><b><?php echo self::$language['user']?></b><a><?php echo $module['user_count'];?></a><?php echo self::$language['name2']?></div>
            </div>
        </div>
    	   

    </div>
</div>
