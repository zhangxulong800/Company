<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./public/echarts.min.js"></script>
    <script>
	function inquiry_username(){
		window.location.href='./index.php?monxin=mall.interest_user_detail&show_time=year&username='+$("#<?php echo $module['module_name'];?> .user_limit .username").val();
	}
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .user_limit .submit").click(function(){
			
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .user_limit .username").keydown(function(event){
			if(event.keyCode==13){inquiry_username();}
				
		});
		
		$("#<?php echo $module['module_name'];?> .limit a[data='<?php echo $_GET['show_time']?>']").attr('class','current');
		var current_limit =$("#<?php echo $module['module_name'];?> .limit .current").html();
		if($("#<?php echo $module['module_name'];?> .limit .current").html()==null){
			current_limit='<?php echo $_GET['username']?>';
		}
		
		
		var pie_dom = document.getElementById("pie_container");
		var pie_Chart = echarts.init(pie_dom);
		var app = {};
		option = null;
		option = {
			title : {
				text: current_limit,
				subtext: '<?php echo self::$language['visit_count']?>(<?php echo $module['sum'];?>)',
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
					name: '<?php echo self::$language['visit_count']?>',
					type: 'pie',
					radius : '55%',
					center: ['50%', '60%'],
					data:[
						<?php echo $module['group'];?>
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
		
		
		
				
		var bar_dom = document.getElementById("bar_container");
		var bar_Chart = echarts.init(bar_dom);
		var app = {};
		option = null;
		option = {
			tooltip : {
				trigger: 'axis',
				axisPointer : {            // 坐标轴指示器，坐标轴触发有效
					type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
				}
			},
			grid: {
				left: '3%',
				right: '4%',
				bottom: '3%',
				containLabel: true
			},
			xAxis : [
				{
					type : 'value'
				}
			],
			yAxis : [
				{
					type : 'category',
					axisTick : {show: false},
					data : [<?php echo $module['word_name'];?>]
				}
			],
			series : [
				{
					name:'<?php echo self::$language['user_quantity']?>',
					type:'bar',
					stack: '总量',
					label: {
						normal: {
							show: true
						}
					},
					data:[<?php echo $module['word_value'];?>]
				}
			]
		};
		;
		if (option && typeof option === "object") {
			var startTime = +new Date();
			bar_Chart.setOption(option, true);
			var endTime = +new Date();
			var updateTime = endTime - startTime;
			console.log("Time used:", updateTime);
		}
				
    });
    
    </script>
	<style>
    #<?php echo $module['module_name'];?>{background:#fff; padding-bottom:100px;}
    #<?php echo $module['module_name'];?> .date_limit{ line-height:30px; margin-top:20px;}
    #<?php echo $module['module_name'];?> .date_limit  .m_label{ display:inline-block; vertical-align:top; }
    #<?php echo $module['module_name'];?> .date_limit  .limit{display:inline-block; vertical-align:top; }
    #<?php echo $module['module_name'];?> .date_limit  .limit a{ display:inline-block; margin-left:10px;margin-right:10px; padding-left:5px; padding-right:5px; }
    #<?php echo $module['module_name'];?> .date_limit  .limit .current{ color:#FFF; background-color:#F30; }
    #<?php echo $module['module_name'];?> .date_limit  .limit input{ width:140px; }
	#<?php echo $module['module_name'];?> #container{ height:200rem; margin-top:2rem;}
	#<?php echo $module['module_name'];?> .user_limit{ text-align:right;}
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
        
        <div class=user_limit><?php echo self::$language['username']?>:<input type="text" class="username" value="<?php echo @$_GET['username']?>" /> <a href=# class=submit><?php echo self::$language['inquiry'];?></a></div>
    	   
 		<div id="pie_container" style="height: 500px;"></div>

		<div id="bar_container" style="height: 800px"></div>
    </div>
</div>
