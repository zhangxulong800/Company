<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./public/echarts.min.js"></script>
	<script src="./plugin/datePicker/index.php"></script>
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> #time_limit a[href='./index.php?monxin=mall.checkout_user&start_time=<?php echo $_GET['start_time']?>&end_time=<?php echo $_GET['end_time']?>']").attr('class','current');
		
		
		
		
		
		var pie_dom = document.getElementById("pie_container");
		var pie_Chart = echarts.init(pie_dom);
		var app = {};
		option = null;
		option = {
			title : {
				text: '',
				subtext: '',
				x:'center'
			},
			tooltip : {
				trigger: 'item',
				formatter: "{a} <br/>{b} : {c} ({d}%)"
			},
			legend: {
				orient: 'vertical',
				left: 'right',
				data: ['直接访2问','邮件营销','联盟广告','视频广告','搜索引擎xx']
			},
			series : [
				{
					name: 'xx',
					type: 'pie',
					radius : '55%',
					center: ['50%', '60%'],
					data:[
						<?php echo $module['user_data'];?>
					],
					itemStyle: {
						emphasis: {
							shadowBlur: 10,
							shadowOffsetX: 0,
							shadowColor: 'rgba(0, 0, 0, 0.5)'
						}
					}
				}
			]
		};
		;
		if (option && typeof option === "object") {
			var startTime = +new Date();
			pie_Chart.setOption(option, true);
			var endTime = +new Date();
			var updateTime = endTime - startTime;
			console.log("Time used:", updateTime);
		}
		
		
		
			
    });
	
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .filter{ height:40px;}
	#<?php echo $module['module_name'];?> #time_limit a{ margin-right:10px; display:inline-block;}
    .table thead tr td{ font-size:0.9rem; padding-left:1px; padding-right:1px;}
	#<?php echo $module['module_name'];?> .current{ color:#FFF; background-color:#F30; padding-left:5px; padding-right:5px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="filter">
    
    	<span id=time_limit><?php echo $module['months'];?> <?php echo self::$language['custom_date']?>: <span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
        <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['inquiry']?></a></span>
    </div>
   <div id="pie_container" style="height: 500px;"></div>
    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><?php echo self::$language['cashier'];?></td>
                <td><?php echo self::$language['recharge'];?><?php echo self::$language['currency']?></td>
                <td><?php echo self::$language['received_goods_money'];?></td>
                <td><?php echo self::$language['pay_method']['pos'];?></td>
                <td><?php echo self::$language['pay_method']['balance'];?></td>
                <td><?php echo self::$language['pay_method']['shop_balance'];?></td>
                <td><?php echo self::$language['pay_method']['weixin'];?></td>
                <td><?php echo self::$language['pay_method']['alipay'];?></td>
                <td><?php echo self::$language['pay_method']['weixin_p'];?></td>
                <td><?php echo self::$language['pay_method']['alipay_p'];?></td>
                <td><?php echo self::$language['pay_method']['meituan'];?></td>
                <td><?php echo self::$language['pay_method']['nuomi'];?></td>
                <td><?php echo self::$language['pay_method']['other'];?></td>
                <td><?php echo self::$language['credit'];?></td>
                <td><?php echo self::$language['exe_order'];?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo @$module['list']?>
        </tbody>
    </table></div>
    </div>
</div>
