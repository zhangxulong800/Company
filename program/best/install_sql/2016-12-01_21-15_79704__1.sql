monxin_sql_startDROP TABLE IF EXISTS `monxin_best_page`;m;o;n;
CREATE TABLE `monxin_best_page` (
  `id` int(5) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `sequence` int(5) NOT NULL default '0',
  `visible` int(1) NOT NULL default '1',
  `username` varchar(30) NOT NULL,
  `time` bigint(12) NOT NULL default '0',
  `visit` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;m;o;n;
INSERT INTO `monxin_best_page` (`id`,`title`,`sequence`,`visible`,`username`,`time`,`visit`) VALUES
('8','梦行分类信息系统','0','1','commonxin','1480494912','165'),
('7','梦行商企自营商城系统','0','1','commonxin','1480492945','118'),
('6','梦行多用户商城系统','0','1','commonxin','1480591655','522'),
('9','梦行商企建站系统','0','1','commonxin','1480496161','102'),
('10','梦行旅游系统','0','1','commonxin','1480498346','48'),
('11','梦行表单系统','0','1','commonxin','1480515137','81'),
('12','梦行大奖','0','1','commonxin','1480515952','48'),
('13','梦行扫码付','0','1','commonxin','1480516830','39'),
('14','梦行文档系统','0','1','commonxin','1480519574','38'),
('15','梦行客户跟单系统','0','1','commonxin','1480563073','81');m;o;n;
DROP TABLE IF EXISTS `monxin_best_paragraph`;m;o;n;
CREATE TABLE `monxin_best_paragraph` (
  `id` int(11) NOT NULL auto_increment,
  `best_id` int(11) NOT NULL default '0',
  `sequence` int(3) NOT NULL default '0',
  `title` varchar(100) default NULL,
  `content_pc` text,
  `is_full` int(1) NOT NULL default '1' COMMENT '是否满屏显示',
  `content_phone` text COMMENT '手机版内容 不填则使用PC',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=122 DEFAULT CHARSET=utf8;m;o;n;
INSERT INTO `monxin_best_paragraph` (`id`,`best_id`,`sequence`,`title`,`content_pc`,`is_full`,`content_phone`) VALUES
('3','6','1','概述','<img src=&#34;program/best/attachd/image/20161126/20161126115423_23452.jpg&#34; alt=&#34;&#34; /><img src=&#34;program/best/attachd/image/20161126/20161126115423_67230.jpg&#34; alt=&#34;&#34; /><img src=&#34;program/best/attachd/image/20161126/20161126115423_14023.jpg&#34; alt=&#34;&#34; /><img src=&#34;program/best/attachd/image/20161126/20161126115423_27281.jpg&#34; alt=&#34;&#34; /><img src=&#34;program/best/attachd/image/20161126/20161126115423_27523.jpg&#34; alt=&#34;&#34; /><img src=&#34;program/best/attachd/image/20161126/20161126115423_68952.jpg&#34; alt=&#34;&#34; /><img src=&#34;program/best/attachd/image/20161126/20161126115423_96610.jpg&#34; alt=&#34;&#34; /><img src=&#34;program/best/attachd/image/20161126/20161126115423_27622.jpg&#34; alt=&#34;&#34; /><img src=&#34;program/best/attachd/image/20161126/20161126115423_88173.jpg&#34; alt=&#34;&#34; /><img src=&#34;program/best/attachd/image/20161126/20161126115424_74140.jpg&#34; alt=&#34;&#34; /><img src=&#34;program/best/attachd/image/20161126/20161126115424_23252.jpg&#34; alt=&#34;&#34; /><img src=&#34;program/best/attachd/image/20161126/20161126115424_80241.jpg&#34; alt=&#34;&#34; />','1',''),
('4','6','3','试用','<script>
$(document).ready(function(){
	div=get_param(&#39;div&#39;);
	if(div!=&#39;&#39;){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(&#39;.&#39;+div).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+div+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	}
	$(&#34;.mall_function .nav a&#34;).hover(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	},function(){
	});	
	$(&#34;.mall_function .nav a&#34;).click(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
		return  false;
	});	
});
</script>
<style>
#qiao-wrap{ display:none !important;}
#diypage_show{ padding-top:5px;}
#diypage_show_html .title{ display:none;}
.mall_function{ color: #000;}
.mall_function a{ color: #000;}
.mall_function .nav{}
.mall_function .function_div{}
.mall_function .function_div ul{}
.mall_function .function_div ul li{ list-style:none; display:inline-block; vertical-align:top; margin:1%; width:14%;height: 10.71rem;}
.mall_function .function_div ul li a{ display:block; text-align:center;}
.mall_function .function_div ul li a:hover{ opacity:0.8;}
.mall_function .function_div ul li a img{ list-style:none; width:60%;    background: #009900;border-radius: 25%;}
.mall_function .function_div ul li a span{ line-height:30px; font-size:15px;}
.mall_function .function_div .admin_div{}
.mall_function .login_info{ margin-left:4%;  display:inline-block; background-color: #CCC; color:#FFF; border-radius:5px; padding:5px; line-height:20px;}
.mall_function .login_info a{ color:#FFF;}
.function_div > div{ display:none;}
</style>
<div class=&#34;mall_function&#34;>
	<ul class=&#34;nav nav-tabs&#34; device_tabs=&#34;1&#34;>
		<li role=&#34;presentation&#34; class=&#34;active&#34;>
			<a href=&#34;#&#34; class=&#34;admin&#34;>总管理员</a> 
		</li>
		<li role=&#34;presentation&#34;>
			<a href=&#34;#&#34; class=&#34;headquarter&#34;>连锁总部</a> 
		</li>
		<li role=&#34;presentation&#34;>
			<a href=&#34;#&#34; class=&#34;shopkeeper&#34;>店主</a> 
		</li>
		<li role=&#34;presentation&#34;>
			<a href=&#34;#&#34; class=&#34;cashier&#34;>收银员</a> 
		</li>
		<li role=&#34;presentation&#34;>
			<a href=&#34;#&#34; class=&#34;storekeeper&#34;>仓管员</a> 
		</li>
		<li role=&#34;presentation&#34;>
			<a href=&#34;#&#34; class=&#34;buyer&#34;>买家</a> 
		</li>
	</ul>
	<div class=&#34;function_div&#34;>
		<div class=&#34;admin_div&#34; style=&#34;display:block;&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://mall.monxin.com/index.php?monxin=mall.master&#34; target=&#34;_blank&#34;>http://mall.monxin.com/index.php?monxin=mall.master</a><br />
&nbsp;登 录 名: monxin.com<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.shop_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.shop_admin.png&#34; /><br />
<span>管理店铺</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.m_order_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.m_order_admin.png&#34; /><br />
<span>全站订单</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.m_goods_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.m_goods_admin.png&#34; /><br />
<span>全站商品</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.type&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.type.png&#34; /><br />
<span>全站商品分类</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.color&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.color.png&#34; /><br />
<span>商品颜色管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.m_comment_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.m_comment_admin.png&#34; /><br />
<span>全站评论</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.tag&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.tag.png&#34; /><br />
<span>商品标签</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.unit&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.unit.png&#34; /><br />
<span>商品单位</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.express&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.express.png&#34; /><br />
<span>快递设置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.pay_method&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.pay_method.png&#34; /><br />
<span>付款方式设置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.config&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.config.png&#34; /><br />
<span>综合设置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.search_log&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.search_log.png&#34; /><br />
<span>搜索记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.template&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.template.png&#34; /><br />
<span>店铺模板</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.talk&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.talk.png&#34; /><br />
<span>在线客服接口</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.finance&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.finance.png&#34; /><br />
<span>商城财务</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.agent_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.agent_admin.png&#34; /><br />
<span>招商员管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.bidding&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.bidding.png&#34; /><br />
<span>竟价点击记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.group_set&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.group_set.png&#34; /><br />
<span>用户组设置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.recommendation_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.recommendation_admin.png&#34; /><br />
<span>推荐码交易管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.headquarters&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.headquarters.png&#34; /><br />
<span>连锁总部管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.goods_db_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.goods_db_admin.png&#34; /><br />
<span>商品数据中心</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.receiving_mode&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.receiving_mode.png&#34; /><br />
<span>收货方式设置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.shop_tag&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.shop_tag.png&#34; /><br />
<span>店铺行业标签</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.span_shop&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.span_shop.png&#34; /><br />
<span>跨商圈店铺</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.create_card&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.create_card.png&#34; /><br />
<span>批开新购物卡</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.interest_index&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.interest_index.png&#34; /><br />
<span>兴趣管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.recommend_gain&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.recommend_gain.png&#34; /><br />
<span>荐人返佣表</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
		<div class=&#34;headquarter_div&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://mall.monxin.com/index.php?monxin=mall.headquarters_index&#34; target=&#34;_blank&#34;>http://mall.monxin.com/index.php?monxin=mall.headquarters_index</a><br />
&nbsp;登 录 名: 李一<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.goods_db&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.goods_db.png&#34; /><br />
<span>商品数据中心</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.branch&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.branch.png&#34; /><br />
<span>分店管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.branch_stock&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.branch_stock.png&#34; /><br />
<span>分店库存</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.branch_finance&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.branch_finance.png&#34; /><br />
<span>分店财务</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.branch_order&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.branch_order.png&#34; /><br />
<span>分店订单</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.s_type&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.s_type.png&#34; /><br />
<span>商品分类</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
		<div class=&#34;shopkeeper_div&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://mall.monxin.com/index.php?monxin=mall.seller&#34; target=&#34;_blank&#34;>http://mall.monxin.com/index.php?monxin=mall.seller</a><br />
&nbsp;登 录 名: 平台自营店<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.shop_index&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.shop_index.png&#34; /><br />
<span>店铺首页</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.batch_add_goods&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.batch_add_goods.png&#34; /><br />
<span>批量上架商品</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.shop_set&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.shop_set.png&#34; /><br />
<span>店铺设置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.s_type&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.s_type.png&#34; /><br />
<span>商品分类</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.s_tag&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.s_tag.png&#34; /><br />
<span>商品标签</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.turnover&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.turnover.png&#34; /><br />
<span>营业额统计</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.order_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.order_admin.png&#34; /><br />
<span>管理订单</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.goods_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.goods_admin.png&#34; /><br />
<span>商品管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.package_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.package_admin.png&#34; /><br />
<span>套餐管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.comment_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.comment_admin.png&#34; /><br />
<span>评论管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.stock&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.stock.png&#34; /><br />
<span>商品库存</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.stocktake&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.stocktake.png&#34; /><br />
<span>盘点计划</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.purchase&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.purchase.png&#34; /><br />
<span>入库记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.loss&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.loss.png&#34; /><br />
<span>报损记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.deduct_stock&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.deduct_stock.png&#34; /><br />
<span>非销售出库</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.shelf_life&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.shelf_life.png&#34; /><br />
<span>保质期提醒</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.position&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.position.png&#34; /><br />
<span>商品位置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.supplier&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.supplier.png&#34; /><br />
<span>商品供应商</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.free_shipping&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.free_shipping.png&#34; /><br />
<span>包邮地区设置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.s_express&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.s_express.png&#34; /><br />
<span>快递设置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.coupon_code&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.coupon_code.png&#34; /><br />
<span>红包</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.discount&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.discount.png&#34; /><br />
<span>批量限时打折</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.fulfil_preferential&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.fulfil_preferential.png&#34; /><br />
<span>店铺满元送</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.vouchers&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.vouchers.png&#34; /><br />
<span>纸质代金券</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.buy_coupon&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.buy_coupon.png&#34; /><br />
<span>单次购物券</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.s_search_log&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.s_search_log.png&#34; /><br />
<span>搜索记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.order_set&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.order_set.png&#34; /><br />
<span>订单相关设置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.shop_finance&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.shop_finance.png&#34; /><br />
<span>店铺财务</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.deposit&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.deposit.png&#34; /><br />
<span>缴纳保证金</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.annual_fees&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.annual_fees.png&#34; /><br />
<span>年费店铺</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.my_buyer&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.my_buyer.png&#34; /><br />
<span>店内会员</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.my_bidding&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.my_bidding.png&#34; /><br />
<span>竟价点击记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.buyer_group&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.buyer_group.png&#34; /><br />
<span>店内会员等级</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.recommendation_set&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.recommendation_set.png&#34; /><br />
<span>推荐码设置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.recommendation_log&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.recommendation_log.png&#34; /><br />
<span>推荐码返点记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.recharge&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.recharge.png&#34; /><br />
<span>店内充值记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.reg_recommend_goods&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.reg_recommend_goods.png&#34; /><br />
<span>荐人返佣品</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
		<div class=&#34;cashier_div&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://mall.monxin.com/index.php?monxin=index.user&#34; target=&#34;_blank&#34;>http://mall.monxin.com/index.php?monxin=index.uesr</a><br />
&nbsp;登 录 名: 张一<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.mall.checkout&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.checkout.png&#34; /><br />
<span>收银台</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.my_checkout_log&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.my_checkout_log.png&#34; /><br />
<span>我的收银记录</span></a> 
				</li>
			</ul>
		</div>
		<div class=&#34;storekeeper_div&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://mall.monxin.com/index.php?monxin=mall.storekeeper&#34; target=&#34;_blank&#34;>http://mall.monxin.com/index.php?monxin=mall.storekeeper</a><br />
&nbsp;登 录 名: test003<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.order_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.order_admin.png&#34; /><br />
<span>管理订单</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.goods_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.goods_admin.png&#34; /><br />
<span>商品管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.stock&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.stock.png&#34; /><br />
<span>商品库存</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.stocktake&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.stocktake.png&#34; /><br />
<span>盘点计划</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.purchase&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.purchase.png&#34; /><br />
<span>入库记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.loss&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.loss.png&#34; /><br />
<span>报损记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.deduct_stock&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.deduct_stock.png&#34; /><br />
<span>非销售出库</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.shelf_life&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.shelf_life.png&#34; /><br />
<span>保质期提醒</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.position&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.position.png&#34; /><br />
<span>商品位置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.supplier&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.supplier.png&#34; /><br />
<span>商品供应商</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
		<div class=&#34;buyer_div&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://mall.monxin.com/index.php?monxin=mall.seller&#34; target=&#34;_blank&#34;>http://mall.monxin.com/index.php?monxin=mall.seller</a><br />
&nbsp;登 录 名: 张三<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.my_order&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.my_order.png&#34; /><br />
<span>我的订单</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.my_cart&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.my_cart.png&#34; /><br />
<span>我的购物车</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.my_visit&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.my_visit.png&#34; /><br />
<span>我看过的商品</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.my_collect&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.my_collect.png&#34; /><br />
<span>我的收藏夹</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.receiver&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.receiver.png&#34; /><br />
<span>我的收货地址</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.coupon_usable&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.coupon_usable.png&#34; /><br />
<span>我的红包</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.privilege&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.privilege.png&#34; /><br />
<span>店铺权益</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.recommendation&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.recommendation.png&#34; /><br />
<span>我的推荐权</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.recommendation_gain&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.recommendation_gain.png&#34; /><br />
<span>推荐码成果</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
	</div>
</div>','0','<script>
$(document).ready(function(){
	div=get_param(&#39;div&#39;);
	if(div!=&#39;&#39;){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(&#39;.&#39;+div).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+div+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	}
	$(&#34;.mall_function .nav a&#34;).hover(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	},function(){
	});	
	$(&#34;.mall_function .nav a&#34;).click(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
		return  false;
	});	
});
</script>
<style>
#qiao-wrap{ display:none !important;}
#diypage_show{ padding-top:5px;}
#diypage_show_html .title{ display:none;}
.mall_function{ color: #000;}
.mall_function a{ color: #000;}
.mall_function .nav{ white-space:nowrap;}
.mall_function .nav a{ padding:5px !important;}
.mall_function .function_div{}
.mall_function .function_div ul{}
.mall_function .function_div ul li{  list-style:none; display:inline-block; vertical-align:top; margin:1%; width:30%; height:7rem;}
.mall_function .function_div ul li a{  display:block; text-align:center;}
.mall_function .function_div ul li a:hover{ opacity:0.8;}
.mall_function .function_div ul li a img{ list-style:none; width:60%;    background: #009900;border-radius: 25%;}
.mall_function .function_div ul li a span{ line-height:30px; font-size:13px;}
.mall_function .function_div .admin_div{}
.mall_function .login_info{ margin-left:4%;  display:inline-block; background-color: #CCC; color:#FFF; border-radius:5px; padding:5px; line-height:20px;white-space:nowrap;}
.mall_function .login_info a{ color:#FFF;}
.function_div > div{ display:none;}
</style>
<div class=&#34;mall_function&#34;>
	<ul class=&#34;nav nav-tabs&#34; device_tabs=&#34;1&#34;>
		<li role=&#34;presentation&#34; class=&#34;active&#34;>
			<a href=&#34;#&#34; class=&#34;admin&#34;>总管理员</a> 
		</li>
		<li role=&#34;presentation&#34;>
			<a href=&#34;#&#34; class=&#34;headquarter&#34;>连锁总部</a> 
		</li>
		<li role=&#34;presentation&#34;>
			<a href=&#34;#&#34; class=&#34;shopkeeper&#34;>店主</a> 
		</li>
		<li role=&#34;presentation&#34;>
			<a href=&#34;#&#34; class=&#34;cashier&#34;>收银员</a> 
		</li>
		<li role=&#34;presentation&#34;>
			<a href=&#34;#&#34; class=&#34;storekeeper&#34;>仓管员</a> 
		</li>
		<li role=&#34;presentation&#34;>
			<a href=&#34;#&#34; class=&#34;buyer&#34;>买家</a> 
		</li>
	</ul>
	<div class=&#34;function_div&#34;>
		<div class=&#34;admin_div&#34; style=&#34;display:block;&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://mall.monxin.com/index.php?monxin=mall.master&#34; target=&#34;_blank&#34;>http://mall.monxin.com/index.php?monxin=mall.master</a><br />
&nbsp;登 录 名: monxin.com<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.shop_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.shop_admin.png&#34; /><br />
<span>管理店铺</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.m_order_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.m_order_admin.png&#34; /><br />
<span>全站订单</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.m_goods_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.m_goods_admin.png&#34; /><br />
<span>全站商品</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.type&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.type.png&#34; /><br />
<span>全站商品分类</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.color&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.color.png&#34; /><br />
<span>商品颜色管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.m_comment_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.m_comment_admin.png&#34; /><br />
<span>全站评论</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.tag&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.tag.png&#34; /><br />
<span>商品标签</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.unit&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.unit.png&#34; /><br />
<span>商品单位</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.express&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.express.png&#34; /><br />
<span>快递设置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.pay_method&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.pay_method.png&#34; /><br />
<span>付款方式设置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.config&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.config.png&#34; /><br />
<span>综合设置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.search_log&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.search_log.png&#34; /><br />
<span>搜索记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.template&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.template.png&#34; /><br />
<span>店铺模板</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.talk&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.talk.png&#34; /><br />
<span>在线客服接口</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.finance&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.finance.png&#34; /><br />
<span>商城财务</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.agent_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.agent_admin.png&#34; /><br />
<span>招商员管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.bidding&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.bidding.png&#34; /><br />
<span>竟价点击记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.group_set&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.group_set.png&#34; /><br />
<span>用户组设置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.recommendation_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.recommendation_admin.png&#34; /><br />
<span>推荐码交易管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.headquarters&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.headquarters.png&#34; /><br />
<span>连锁总部管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.goods_db_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.goods_db_admin.png&#34; /><br />
<span>商品数据中心</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.receiving_mode&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.receiving_mode.png&#34; /><br />
<span>收货方式设置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.shop_tag&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.shop_tag.png&#34; /><br />
<span>店铺行业标签</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.span_shop&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.span_shop.png&#34; /><br />
<span>跨商圈店铺</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.create_card&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.create_card.png&#34; /><br />
<span>批开新购物卡</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.interest_index&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.interest_index.png&#34; /><br />
<span>兴趣管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.recommend_gain&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.recommend_gain.png&#34; /><br />
<span>荐人返佣表</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
		<div class=&#34;headquarter_div&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://mall.monxin.com/index.php?monxin=mall.headquarters_index&#34; target=&#34;_blank&#34;>http://mall.monxin.com/index.php?monxin=mall.headquarters_index</a><br />
&nbsp;登 录 名: 李一<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.goods_db&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.goods_db.png&#34; /><br />
<span>商品数据中心</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.branch&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.branch.png&#34; /><br />
<span>分店管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.branch_stock&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.branch_stock.png&#34; /><br />
<span>分店库存</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.branch_finance&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.branch_finance.png&#34; /><br />
<span>分店财务</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.branch_order&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.branch_order.png&#34; /><br />
<span>分店订单</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.s_type&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.s_type.png&#34; /><br />
<span>商品分类</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
		<div class=&#34;shopkeeper_div&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://mall.monxin.com/index.php?monxin=mall.seller&#34; target=&#34;_blank&#34;>http://mall.monxin.com/index.php?monxin=mall.seller</a><br />
&nbsp;登 录 名: 平台自营店<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.shop_index&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.shop_index.png&#34; /><br />
<span>店铺首页</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.batch_add_goods&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.batch_add_goods.png&#34; /><br />
<span>批量上架商品</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.shop_set&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.shop_set.png&#34; /><br />
<span>店铺设置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.s_type&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.s_type.png&#34; /><br />
<span>商品分类</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.s_tag&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.s_tag.png&#34; /><br />
<span>商品标签</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.turnover&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.turnover.png&#34; /><br />
<span>营业额统计</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.order_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.order_admin.png&#34; /><br />
<span>管理订单</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.goods_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.goods_admin.png&#34; /><br />
<span>商品管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.package_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.package_admin.png&#34; /><br />
<span>套餐管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.comment_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.comment_admin.png&#34; /><br />
<span>评论管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.stock&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.stock.png&#34; /><br />
<span>商品库存</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.stocktake&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.stocktake.png&#34; /><br />
<span>盘点计划</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.purchase&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.purchase.png&#34; /><br />
<span>入库记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.loss&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.loss.png&#34; /><br />
<span>报损记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.deduct_stock&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.deduct_stock.png&#34; /><br />
<span>非销售出库</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.shelf_life&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.shelf_life.png&#34; /><br />
<span>保质期提醒</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.position&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.position.png&#34; /><br />
<span>商品位置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.supplier&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.supplier.png&#34; /><br />
<span>商品供应商</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.free_shipping&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.free_shipping.png&#34; /><br />
<span>包邮地区设置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.s_express&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.s_express.png&#34; /><br />
<span>快递设置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.coupon_code&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.coupon_code.png&#34; /><br />
<span>红包</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.discount&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.discount.png&#34; /><br />
<span>批量限时打折</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.fulfil_preferential&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.fulfil_preferential.png&#34; /><br />
<span>店铺满元送</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.vouchers&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.vouchers.png&#34; /><br />
<span>纸质代金券</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.buy_coupon&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.buy_coupon.png&#34; /><br />
<span>单次购物券</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.s_search_log&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.s_search_log.png&#34; /><br />
<span>搜索记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.order_set&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.order_set.png&#34; /><br />
<span>订单相关设置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.shop_finance&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.shop_finance.png&#34; /><br />
<span>店铺财务</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.deposit&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.deposit.png&#34; /><br />
<span>缴纳保证金</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.annual_fees&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.annual_fees.png&#34; /><br />
<span>年费店铺</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.my_buyer&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.my_buyer.png&#34; /><br />
<span>店内会员</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.my_bidding&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.my_bidding.png&#34; /><br />
<span>竟价点击记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.buyer_group&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.buyer_group.png&#34; /><br />
<span>店内会员等级</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.recommendation_set&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.recommendation_set.png&#34; /><br />
<span>推荐码设置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.recommendation_log&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.recommendation_log.png&#34; /><br />
<span>推荐码返点记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.recharge&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.recharge.png&#34; /><br />
<span>店内充值记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.reg_recommend_goods&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.reg_recommend_goods.png&#34; /><br />
<span>荐人返佣品</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
		<div class=&#34;cashier_div&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://mall.monxin.com/index.php?monxin=index.user&#34; target=&#34;_blank&#34;>http://mall.monxin.com/index.php?monxin=index.uesr</a><br />
&nbsp;登 录 名: 张一<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.mall.checkout&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.checkout.png&#34; /><br />
<span>收银台</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.my_checkout_log&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.my_checkout_log.png&#34; /><br />
<span>我的收银记录</span></a> 
				</li>
			</ul>
		</div>
		<div class=&#34;storekeeper_div&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://mall.monxin.com/index.php?monxin=mall.storekeeper&#34; target=&#34;_blank&#34;>http://mall.monxin.com/index.php?monxin=mall.storekeeper</a><br />
&nbsp;登 录 名: test003<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.order_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.order_admin.png&#34; /><br />
<span>管理订单</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.goods_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.goods_admin.png&#34; /><br />
<span>商品管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.stock&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.stock.png&#34; /><br />
<span>商品库存</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.stocktake&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.stocktake.png&#34; /><br />
<span>盘点计划</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.purchase&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.purchase.png&#34; /><br />
<span>入库记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.loss&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.loss.png&#34; /><br />
<span>报损记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.deduct_stock&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.deduct_stock.png&#34; /><br />
<span>非销售出库</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.shelf_life&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.shelf_life.png&#34; /><br />
<span>保质期提醒</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.position&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.position.png&#34; /><br />
<span>商品位置</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.supplier&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.supplier.png&#34; /><br />
<span>商品供应商</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
		<div class=&#34;buyer_div&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://mall.monxin.com/index.php?monxin=mall.seller&#34; target=&#34;_blank&#34;>http://mall.monxin.com/index.php?monxin=mall.seller</a><br />
&nbsp;登 录 名: 张三<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.my_order&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.my_order.png&#34; /><br />
<span>我的订单</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.my_cart&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.my_cart.png&#34; /><br />
<span>我的购物车</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.my_visit&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.my_visit.png&#34; /><br />
<span>我看过的商品</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.my_collect&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.my_collect.png&#34; /><br />
<span>我的收藏夹</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.receiver&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.receiver.png&#34; /><br />
<span>我的收货地址</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.coupon_usable&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.coupon_usable.png&#34; /><br />
<span>我的红包</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.privilege&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.privilege.png&#34; /><br />
<span>店铺权益</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.recommendation&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.recommendation.png&#34; /><br />
<span>我的推荐权</span></a> 
				</li>
				<li>
					<a href=&#34;http://mall.monxin.com/index.php?monxin=mall.recommendation_gain&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/mall/default/page_icon/mall.recommendation_gain.png&#34; /><br />
<span>推荐码成果</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
	</div>
</div>'),
('5','0','0','','./index.php?monxin=mall.goods&id=i9','1',''),
('6','6','8','立即购买','./index.php?monxin=mall.goods&id=16','1','./index.php?monxin=mall.goods&id=16'),
('7','6','4','配套功能','<div id=&#34;image_show_thumb&#34; class=&#34;portlet light&#34; monxin-module=&#34;image_show_thumb&#34; align=&#34;left&#34; save_name=&#34;image_show_thumb(field:title/src|sequence_field:sequence|sequence_type:desc|quantity:100|target:_blank|sub_module_width:21%|image_height:11rem|detail_show_method:show)&#34; style=&#34;width:100%;&#34;>
<script>
    $(document).ready(function(){
    });
    </script>
<style>
	#image_show_thumb{ margin:5px; padding:0px;}
	#image_show_thumb .remark{ line-height:2.14rem;}
    #image_show_thumb .thumbs_div{ line-height:1.42rem; text-align:left; }
    #image_show_thumb .thumbs_div a{ margin-left:0.5%; margin-right:0.5%;  display:inline-block; vertical-align:top;  width:18%; overflow:hidden; text-align:center; margin-bottom:20px; }
    #image_show_thumb .thumbs_div a:hover{ border:1px solid #ddd; }
    #image_show_thumb .thumbs_div a span{ display:block; line-height:20px;}
    #image_show_thumb .thumbs_div a span .m_label{ display:inline-block;}
    #image_show_thumb .thumbs_div a .title{ display:block; font-size:0.9rem; height:2.14rem; line-height:2.14rem; display:block; overflow:hidden;}
    #image_show_thumb .thumbs_div a .time{ display:inline-block; float:left; padding-left:10px; line-height:2.85rem;}
    #image_show_thumb .thumbs_div a .time .time_symbol{display:inline-block;  display:none;}
	#image_show_thumb .thumbs_div a .visit{display:inline-block;font-size:0.86rem; width:30%;  line-height:2.85rem;text-align:right; float:right;}
	#image_show_thumb .thumbs_div a .visit .visit_symbol{display:inline-block; line-height:1.42rem;}
	#image_show_thumb .thumbs_div a .visit .visit_symbol:before{margin-left:5px; font: normal normal normal 1rem/1 FontAwesome; content:&#34;0a6&#34;; opacity:0.6;}
    #image_show_thumb .thumbs_div a .thumb_img{ vertical-align:middle;width:70% !important; max-width:70% !important; margin:0.5rem; margin-bottom:0px;}
    #image_show_thumb .thumbs_div a .thumb_img:hover{ opacity:0.8;}
	#image_show_thumb .thumbs_div div{}
	.page_row{ padding-left:0.5rem; padding-right:0.5rem;}
    </style>
	<div id=&#34;image_show_thumb_html&#34; class=&#34;module_div_bottom_margin&#34;>
		<div class=&#34;remark&#34;>
		</div>
		<div class=&#34;thumbs_div&#34;>
			<a href=&#34;index.php?monxin=diypage.show&id=170&#34; id=&#34;image_show_365&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_17_3849.png&#34; class=&#34;thumb_img&#34; alt=&#34;主系统&#34; /><span class=&#34;title&#34;>主系统</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=171&#34; id=&#34;image_show_361&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_13_6117.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行分类信息系统&#34; /><span class=&#34;title&#34;>梦行分类信息系统</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=169&#34; id=&#34;image_show_362&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_14_8580.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行分销&#34; /><span class=&#34;title&#34;>梦行分销</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=172&#34; id=&#34;image_show_366&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474161300_0_3640.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行扫码付&#34; /><span class=&#34;title&#34;>梦行扫码付</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=174&#34; id=&#34;image_show_360&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_12_7807.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行微信&#34; /><span class=&#34;title&#34;>梦行微信</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=173&#34; id=&#34;image_show_348&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_0_5907.png&#34; class=&#34;thumb_img&#34; alt=&#34;自定义网页&#34; /><span class=&#34;title&#34;>自定义网页</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=181&#34; id=&#34;image_show_349&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_1_2130.png&#34; class=&#34;thumb_img&#34; alt=&#34;图片幻灯片&#34; /><span class=&#34;title&#34;>图片幻灯片</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=175&#34; id=&#34;image_show_350&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_2_8816.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行展图&#34; /><span class=&#34;title&#34;>梦行展图</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=180&#34; id=&#34;image_show_351&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_3_6702.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行展文&#34; /><span class=&#34;title&#34;>梦行展文</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=176&#34; id=&#34;image_show_352&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_4_9066.png&#34; class=&#34;thumb_img&#34; alt=&#34;留言反馈&#34; /><span class=&#34;title&#34;>留言反馈</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=178&#34; id=&#34;image_show_353&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_5_2727.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行表单&#34; /><span class=&#34;title&#34;>梦行表单</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=image.show&id=354&type=80&order=sequence|desc&search=&#34; id=&#34;image_show_354&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_6_6903.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行自定义模块&#34; /><span class=&#34;title&#34;>梦行自定义模块</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=179&#34; id=&#34;image_show_356&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_8_1168.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行谈谈&#34; /><span class=&#34;title&#34;>梦行谈谈</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=182&#34; id=&#34;image_show_357&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_9_4150.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行采集&#34; /><span class=&#34;title&#34;>梦行采集</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=184&#34; id=&#34;image_show_358&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_10_5043.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行菜单&#34; /><span class=&#34;title&#34;>梦行菜单</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=177&#34; id=&#34;image_show_363&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_15_7393.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行PK&#34; /><span class=&#34;title&#34;>梦行PK</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=185&#34; id=&#34;image_show_364&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_16_5077.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行大奖&#34; /><span class=&#34;title&#34;>梦行大奖</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=186&#34; id=&#34;image_show_374&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_10/24/1477271246_0_4271.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行历程轴&#34; /><span class=&#34;title&#34;>梦行历程轴</span> 
			<div>
			</div>
</a> 
		</div>
	</div>
</div>','0',''),
('8','6','6','演示站','http://www.monxin.wang','1','http://www.monxin.wang'),
('9','6','2','主功能','<img src=&#34;program/best/attachd/image/20161126/20161126143648_55791.jpeg&#34; alt=&#34;&#34; />','1',''),
('10','0','0','','<img src=&#34;program/best/attachd/image/20161126/20161126115423_23452.jpg&#34; alt=&#34;&#34; /><img src=&#34;program/best/attachd/image/20161126/20161126115423_67230.jpg&#34; alt=&#34;&#34; /><img src=&#34;program/best/attachd/image/20161126/20161126115423_14023.jpg&#34; alt=&#34;&#34; /><img src=&#34;program/best/attachd/image/20161126/20161126115423_27281.jpg&#34; alt=&#34;&#34; /><img src=&#34;program/best/attachd/image/20161126/20161126115423_27523.jpg&#34; alt=&#34;&#34; /><img src=&#34;program/best/attachd/image/20161126/20161126115423_68952.jpg&#34; alt=&#34;&#34; /><img src=&#34;program/best/attachd/image/20161126/20161126115423_96610.jpg&#34; alt=&#34;&#34; /><img src=&#34;program/best/attachd/image/20161126/20161126115423_27622.jpg&#34; alt=&#34;&#34; /><img src=&#34;program/best/attachd/image/20161126/20161126115423_88173.jpg&#34; alt=&#34;&#34; /><img src=&#34;program/best/attachd/image/20161126/20161126115424_74140.jpg&#34; alt=&#34;&#34; /><img src=&#34;program/best/attachd/image/20161126/20161126115424_23252.jpg&#34; alt=&#34;&#34; /><img src=&#34;program/best/attachd/image/20161126/20161126115424_80241.jpg&#34; alt=&#34;&#34; />','1',''),
('11','7','1','概述','应用场景：厂商自营商城 便利店 超市 线下收银 进销存 ...<br />
应用方向举列：小米商城 华为商城 各企业官网商城<br />
方案特色：<br />
多网合一 PC商城、手机商城、微商城 一次到位<br />
PHP全开源，代码在手，权力我有。一次付费 终生使用<br />
线上线下无缝对接，线上商城 线下收银 仓库进销存 订单 库存 财务数据实时同步<br />
海量接口扩展 连接7亿网民，QQ登录　微信登录　支付宝　微信支付　物流接口...<br />
基于梦行框架，功能模块扩展 so easy <br />
<br />
<br />','0',''),
('12','7','2','主功能','正在开发中，请期待。','0',''),
('13','7','3','试用','正在开发中，请期待。','0',''),
('14','7','4','配套功能','<div id=&#34;image_show_thumb&#34; class=&#34;portlet light&#34; monxin-module=&#34;image_show_thumb&#34; align=&#34;left&#34; save_name=&#34;image_show_thumb(field:title/src|sequence_field:sequence|sequence_type:desc|quantity:100|target:_blank|sub_module_width:21%|image_height:11rem|detail_show_method:show)&#34; style=&#34;width:100%;&#34;>
<script>
    $(document).ready(function(){
    });
    </script>
<style>
	#image_show_thumb{ margin:5px; padding:0px;}
	#image_show_thumb .remark{ line-height:2.14rem;}
    #image_show_thumb .thumbs_div{ line-height:1.42rem; text-align:left; }
    #image_show_thumb .thumbs_div a{ margin-left:0.5%; margin-right:0.5%;  display:inline-block; vertical-align:top;  width:18%; overflow:hidden; text-align:center; margin-bottom:20px; }
    #image_show_thumb .thumbs_div a:hover{ border:1px solid #ddd; }
    #image_show_thumb .thumbs_div a span{ display:block; line-height:20px;}
    #image_show_thumb .thumbs_div a span .m_label{ display:inline-block;}
    #image_show_thumb .thumbs_div a .title{ display:block; font-size:0.9rem; height:2.14rem; line-height:2.14rem; display:block; overflow:hidden;}
    #image_show_thumb .thumbs_div a .time{ display:inline-block; float:left; padding-left:10px; line-height:2.85rem;}
    #image_show_thumb .thumbs_div a .time .time_symbol{display:inline-block;  display:none;}
	#image_show_thumb .thumbs_div a .visit{display:inline-block;font-size:0.86rem; width:30%;  line-height:2.85rem;text-align:right; float:right;}
	#image_show_thumb .thumbs_div a .visit .visit_symbol{display:inline-block; line-height:1.42rem;}
	#image_show_thumb .thumbs_div a .visit .visit_symbol:before{margin-left:5px; font: normal normal normal 1rem/1 FontAwesome; content:&#34;0a6&#34;; opacity:0.6;}
    #image_show_thumb .thumbs_div a .thumb_img{ vertical-align:middle;width:70% !important; max-width:70% !important; margin:0.5rem; margin-bottom:0px;}
    #image_show_thumb .thumbs_div a .thumb_img:hover{ opacity:0.8;}
	#image_show_thumb .thumbs_div div{}
	.page_row{ padding-left:0.5rem; padding-right:0.5rem;}
    </style>
	<div id=&#34;image_show_thumb_html&#34; class=&#34;module_div_bottom_margin&#34;>
		<div class=&#34;remark&#34;>
		</div>
		<div class=&#34;thumbs_div&#34;>
			<a href=&#34;index.php?monxin=diypage.show&id=170&#34; id=&#34;image_show_365&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_17_3849.png&#34; class=&#34;thumb_img&#34; alt=&#34;主系统&#34; /><span class=&#34;title&#34;>主系统</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=174&#34; id=&#34;image_show_360&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_12_7807.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行微信&#34; /><span class=&#34;title&#34;>梦行微信</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=173&#34; id=&#34;image_show_348&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_0_5907.png&#34; class=&#34;thumb_img&#34; alt=&#34;自定义网页&#34; /><span class=&#34;title&#34;>自定义网页</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=181&#34; id=&#34;image_show_349&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_1_2130.png&#34; class=&#34;thumb_img&#34; alt=&#34;图片幻灯片&#34; /><span class=&#34;title&#34;>图片幻灯片</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=175&#34; id=&#34;image_show_350&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_2_8816.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行展图&#34; /><span class=&#34;title&#34;>梦行展图</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=180&#34; id=&#34;image_show_351&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_3_6702.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行展文&#34; /><span class=&#34;title&#34;>梦行展文</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=176&#34; id=&#34;image_show_352&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_4_9066.png&#34; class=&#34;thumb_img&#34; alt=&#34;留言反馈&#34; /><span class=&#34;title&#34;>留言反馈</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=178&#34; id=&#34;image_show_353&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_5_2727.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行表单&#34; /><span class=&#34;title&#34;>梦行表单</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=image.show&id=354&type=80&order=sequence|desc&search=&#34; id=&#34;image_show_354&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_6_6903.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行自定义模块&#34; /><span class=&#34;title&#34;>梦行自定义模块</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=179&#34; id=&#34;image_show_356&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_8_1168.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行谈谈&#34; /><span class=&#34;title&#34;>梦行谈谈</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=182&#34; id=&#34;image_show_357&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_9_4150.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行采集&#34; /><span class=&#34;title&#34;>梦行采集</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=184&#34; id=&#34;image_show_358&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_10_5043.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行菜单&#34; /><span class=&#34;title&#34;>梦行菜单</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=177&#34; id=&#34;image_show_363&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_15_7393.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行PK&#34; /><span class=&#34;title&#34;>梦行PK</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=186&#34; id=&#34;image_show_374&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_10/24/1477271246_0_4271.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行历程轴&#34; /><span class=&#34;title&#34;>梦行历程轴</span> 
			<div>
			</div>
</a> 
		</div>
	</div>
</div>','0',''),
('15','7','5','演示站','暂无','0',''),
('16','7','7','立即购买','./index.php?monxin=mall.goods&id=26','1','./index.php?monxin=mall.goods&id=26'),
('17','8','1','概述','应用场景：同城信息平台 行业信息平台 ...<br />
应用方向举列：58 赶集 百姓 同城信息平台（租房 交友 找工作 二手市场...） 行业供求网<br />
方案特色：<br />
多网合一 PC站、手机站、微站 一次到位<br />
PHP全开源，代码在手，权力我有。永久免费使用<br />
自定义信息分类，信息输入项，妈妈再也不用担心我的二次开发费用了<br />
海量接口扩展 连接7亿网民，QQ登录　微信登录　支付宝　微信支付...<br />
基于梦行框架，功能模块扩展 so easy<br />','0',''),
('18','8','2','主功能','<img src=&#34;program/best/attachd/image/20161128/20161128045252_91589.jpg&#34; alt=&#34;&#34; />','1',''),
('19','8','3','试用','<script>
$(document).ready(function(){
	div=get_param(&#39;div&#39;);
	if(div!=&#39;&#39;){
		$(&#34;.info_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(&#39;.&#39;+div).parent().addClass(&#39;active&#39;);
		$(&#34;.info_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+div+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	}
	$(&#34;.info_function .nav a&#34;).hover(function(){
		$(&#34;.info_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.info_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	},function(){
	});	
	$(&#34;.info_function .nav a&#34;).click(function(){
		$(&#34;.info_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.info_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
		return  false;
	});	
});
</script>
<style>
#qiao-wrap{ display:none !important;}
#diypage_show{ padding-top:5px;}
#diypage_show_html .title{ display:none;}
.info_function{ color: #000;}
.info_function a{ color: #000;}
.info_function .nav{}
.info_function .function_div{}
.info_function .function_div ul{}
.info_function .function_div ul li{ list-style:none; display:inline-block; vertical-align:top; margin:1%; width:14%;height: 10.71rem;}
.info_function .function_div ul li a{ display:block; text-align:center;}
.info_function .function_div ul li a:hover{ opacity:0.8;}
.info_function .function_div ul li a img{ list-style:none; width:60%;    background: #009900;border-radius: 25%;}
.info_function .function_div ul li a span{ line-height:30px; font-size:15px;}
.info_function .function_div .admin_div{}
.info_function .login_info{ margin-left:4%;  display:inline-block; background-color: #CCC; color:#FFF; border-radius:5px; padding:5px; line-height:20px;}
.info_function .login_info a{ color:#FFF;}
.function_div > div{ display:none;}
</style>
<div class=&#34;info_function&#34;>
	<ul class=&#34;nav nav-tabs&#34; device_tabs=&#34;1&#34;>
		<li role=&#34;presentation&#34; class=&#34;active&#34;>
			<a href=&#34;#&#34; class=&#34;admin&#34;>总管理员</a> 
		</li>
		<li role=&#34;presentation&#34;>
			<a href=&#34;#&#34; class=&#34;other&#34;>其它会员</a> 
		</li>
	</ul>
	<div class=&#34;function_div&#34;>
		<div class=&#34;admin_div&#34; style=&#34;display:block;&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://info.monxin.com/index.php?monxin=ci.admin&#34; target=&#34;_blank&#34;>http://info.monxin.com/index.php?monxin=ci.admin</a><br />
&nbsp;登 录 名: monxin.com<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://info.monxin.com/index.php?monxin=ci.info_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/ci/default/page_icon/ci.info_admin.png&#34; /><br />
<span>信息管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://info.monxin.com/index.php?monxin=ci.type&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/ci/default/page_icon/ci.type.png&#34; /><br />
<span>分类管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://info.monxin.com/index.php?monxin=ci.tag&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/ci/default/page_icon/ci.tag.png&#34; /><br />
<span>信息标签</span></a> 
				</li>
				<li>
					<a href=&#34;http://info.monxin.com/index.php?monxin=ci.config&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/ci/default/page_icon/ci.config.png&#34; /><br />
<span>综合设置</span></a> 
				</li>
				<li>
					<a href=&#34;http://info.monxin.com/index.php?monxin=ci.search_log&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/ci/default/page_icon/ci.search_log.png&#34; /><br />
<span>搜索记录</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
		<div class=&#34;other_div&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://info.monxin.com/index.php?monxin=inde.user&#34; target=&#34;_blank&#34;>http://info.monxin.com/index.php?monxin=index.user</a><br />
&nbsp;登 录 名: 张一<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://info.monxin.com/index.php?monxin=ci.my_info&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/ci/default/page_icon/ci.my_info.png&#34; /><br />
<span>我发布的信息</span></a> 
				</li>
				<li>
					<a href=&#34;http://info.monxin.com/index.php?monxin=ci.add&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/ci/default/page_icon/ci.add.png&#34; /><br />
<span>发布信息</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
	</div>
</div>','0','<script>
$(document).ready(function(){
	div=get_param(&#39;div&#39;);
	if(div!=&#39;&#39;){
		$(&#34;.info_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(&#39;.&#39;+div).parent().addClass(&#39;active&#39;);
		$(&#34;.info_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+div+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	}
	$(&#34;.info_function .nav a&#34;).hover(function(){
		$(&#34;.info_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.info_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	},function(){
	});	
	$(&#34;.info_function .nav a&#34;).click(function(){
		$(&#34;.info_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.info_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
		return  false;
	});	
});
</script>
<style>
#qiao-wrap{ display:none !important;}
#diypage_show{ padding-top:5px;}
#diypage_show_html .title{ display:none;}
.info_function{ color: #000;}
.info_function a{ color: #000;}
.info_function .nav{ white-space:nowrap;}
.info_function .nav a{ padding:5px !important;}
.info_function .function_div{}
.info_function .function_div ul{}
.info_function .function_div ul li{  list-style:none; display:inline-block; vertical-align:top; margin:1%; width:30%; height:7rem;}
.info_function .function_div ul li a{  display:block; text-align:center;}
.info_function .function_div ul li a:hover{ opacity:0.8;}
.info_function .function_div ul li a img{ list-style:none; width:60%;    background: #009900;border-radius: 25%;}
.info_function .function_div ul li a span{ line-height:30px; font-size:13px;}
.info_function .function_div .admin_div{}
.info_function .login_info{ margin-left:4%;  display:inline-block; background-color: #CCC; color:#FFF; border-radius:5px; padding:5px; line-height:20px;white-space:nowrap;}
.info_function .login_info a{ color:#FFF;}
.function_div > div{ display:none;}
</style>
<div class=&#34;info_function&#34;>
	<ul class=&#34;nav nav-tabs&#34; device_tabs=&#34;1&#34;>
		<li role=&#34;presentation&#34; class=&#34;active&#34;>
			<a href=&#34;#&#34; class=&#34;admin&#34;>总管理员</a> 
		</li>
		<li role=&#34;presentation&#34;>
			<a href=&#34;#&#34; class=&#34;other&#34;>其它会员</a> 
		</li>
	</ul>
	<div class=&#34;function_div&#34;>
		<div class=&#34;admin_div&#34; style=&#34;display:block;&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://info.monxin.com/index.php?monxin=ci.admin&#34; target=&#34;_blank&#34;>http://info.monxin.com/index.php?monxin=ci.admin</a><br />
&nbsp;登 录 名: monxin.com<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://info.monxin.com/index.php?monxin=ci.info_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/ci/default/page_icon/ci.info_admin.png&#34; /><br />
<span>信息管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://info.monxin.com/index.php?monxin=ci.type&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/ci/default/page_icon/ci.type.png&#34; /><br />
<span>分类管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://info.monxin.com/index.php?monxin=ci.tag&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/ci/default/page_icon/ci.tag.png&#34; /><br />
<span>信息标签</span></a> 
				</li>
				<li>
					<a href=&#34;http://info.monxin.com/index.php?monxin=ci.config&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/ci/default/page_icon/ci.config.png&#34; /><br />
<span>综合设置</span></a> 
				</li>
				<li>
					<a href=&#34;http://info.monxin.com/index.php?monxin=ci.search_log&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/ci/default/page_icon/ci.search_log.png&#34; /><br />
<span>搜索记录</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
		<div class=&#34;other_div&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://info.monxin.com/index.php?monxin=inde.user&#34; target=&#34;_blank&#34;>http://info.monxin.com/index.php?monxin=index.user</a><br />
&nbsp;登 录 名: 张一<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://info.monxin.com/index.php?monxin=ci.my_info&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/ci/default/page_icon/ci.my_info.png&#34; /><br />
<span>我发布的信息</span></a> 
				</li>
				<li>
					<a href=&#34;http://info.monxin.com/index.php?monxin=ci.add&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/ci/default/page_icon/ci.add.png&#34; /><br />
<span>发布信息</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
	</div>
</div>'),
('20','8','4','配套功能','<div id=&#34;image_show_thumb&#34; class=&#34;portlet light&#34; monxin-module=&#34;image_show_thumb&#34; align=&#34;left&#34; save_name=&#34;image_show_thumb(field:title/src|sequence_field:sequence|sequence_type:desc|quantity:100|target:_blank|sub_module_width:21%|image_height:11rem|detail_show_method:show)&#34; style=&#34;width:100%;&#34;>
<script>
    $(document).ready(function(){
    });
    </script>
<style>
	#image_show_thumb{ margin:5px; padding:0px;}
	#image_show_thumb .remark{ line-height:2.14rem;}
    #image_show_thumb .thumbs_div{ line-height:1.42rem; text-align:left; }
    #image_show_thumb .thumbs_div a{ margin-left:0.5%; margin-right:0.5%;  display:inline-block; vertical-align:top;  width:18%; overflow:hidden; text-align:center; margin-bottom:20px; }
    #image_show_thumb .thumbs_div a:hover{ border:1px solid #ddd; }
    #image_show_thumb .thumbs_div a span{ display:block; line-height:20px;}
    #image_show_thumb .thumbs_div a span .m_label{ display:inline-block;}
    #image_show_thumb .thumbs_div a .title{ display:block; font-size:0.9rem; height:2.14rem; line-height:2.14rem; display:block; overflow:hidden;}
    #image_show_thumb .thumbs_div a .time{ display:inline-block; float:left; padding-left:10px; line-height:2.85rem;}
    #image_show_thumb .thumbs_div a .time .time_symbol{display:inline-block;  display:none;}
	#image_show_thumb .thumbs_div a .visit{display:inline-block;font-size:0.86rem; width:30%;  line-height:2.85rem;text-align:right; float:right;}
	#image_show_thumb .thumbs_div a .visit .visit_symbol{display:inline-block; line-height:1.42rem;}
	#image_show_thumb .thumbs_div a .visit .visit_symbol:before{margin-left:5px; font: normal normal normal 1rem/1 FontAwesome; content:&#34;0a6&#34;; opacity:0.6;}
    #image_show_thumb .thumbs_div a .thumb_img{ vertical-align:middle;width:70% !important; max-width:70% !important; margin:0.5rem; margin-bottom:0px;}
    #image_show_thumb .thumbs_div a .thumb_img:hover{ opacity:0.8;}
	#image_show_thumb .thumbs_div div{}
	.page_row{ padding-left:0.5rem; padding-right:0.5rem;}
    </style>
	<div id=&#34;image_show_thumb_html&#34; class=&#34;module_div_bottom_margin&#34;>
		<div class=&#34;remark&#34;>
		</div>
		<div class=&#34;thumbs_div&#34;>
			<a href=&#34;index.php?monxin=diypage.show&id=170&#34; id=&#34;image_show_365&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_17_3849.png&#34; class=&#34;thumb_img&#34; alt=&#34;主系统&#34; /><span class=&#34;title&#34;>主系统</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=174&#34; id=&#34;image_show_360&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_12_7807.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行微信&#34; /><span class=&#34;title&#34;>梦行微信</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=173&#34; id=&#34;image_show_348&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_0_5907.png&#34; class=&#34;thumb_img&#34; alt=&#34;自定义网页&#34; /><span class=&#34;title&#34;>自定义网页</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=181&#34; id=&#34;image_show_349&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_1_2130.png&#34; class=&#34;thumb_img&#34; alt=&#34;图片幻灯片&#34; /><span class=&#34;title&#34;>图片幻灯片</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=175&#34; id=&#34;image_show_350&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_2_8816.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行展图&#34; /><span class=&#34;title&#34;>梦行展图</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=180&#34; id=&#34;image_show_351&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_3_6702.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行展文&#34; /><span class=&#34;title&#34;>梦行展文</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=176&#34; id=&#34;image_show_352&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_4_9066.png&#34; class=&#34;thumb_img&#34; alt=&#34;留言反馈&#34; /><span class=&#34;title&#34;>留言反馈</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=178&#34; id=&#34;image_show_353&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_5_2727.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行表单&#34; /><span class=&#34;title&#34;>梦行表单</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=image.show&id=354&type=80&order=sequence|desc&search=&#34; id=&#34;image_show_354&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_6_6903.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行自定义模块&#34; /><span class=&#34;title&#34;>梦行自定义模块</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=179&#34; id=&#34;image_show_356&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_8_1168.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行谈谈&#34; /><span class=&#34;title&#34;>梦行谈谈</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=182&#34; id=&#34;image_show_357&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_9_4150.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行采集&#34; /><span class=&#34;title&#34;>梦行采集</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=184&#34; id=&#34;image_show_358&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_10_5043.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行菜单&#34; /><span class=&#34;title&#34;>梦行菜单</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=177&#34; id=&#34;image_show_363&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_15_7393.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行PK&#34; /><span class=&#34;title&#34;>梦行PK</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=186&#34; id=&#34;image_show_374&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_10/24/1477271246_0_4271.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行历程轴&#34; /><span class=&#34;title&#34;>梦行历程轴</span> 
			<div>
			</div>
</a> 
		</div>
	</div>
</div>','0',''),
('21','8','5','演示站','http://ci.monxin.com','1','http://ci.monxin.com'),
('22','8','7','立即购买','./index.php?monxin=mall.goods&id=14','1','./index.php?monxin=mall.goods&id=14'),
('24','6','7','使用案例','./index.php?monxin=image.show_thumb&type=77','0','./index.php?monxin=image.show_thumb&type=77'),
('25','9','1','概述','应用场景：各行各业商家网站<br />
应用方向举列：各公司官网<br />
方案特色：<br />
多网合一 PC站、手机站、微站 一次到位<br />
PHP全开源，代码在手，权力我有。永久免费使用<br />
可视化操作，看得见的，都可自己改，妈妈再也不用担心我的二次开发费用了<br />
海量接口扩展 连接7亿网民，QQ登录　微信登录　支付宝　微信支付...<br />
基于梦行框架，功能模块扩展 so easy <br />','0',''),
('26','10','1','概述','应用场景：旅游网 旅行社 各旅游社团<br />
应用方向举列：各旅行社官网<br />
方案特色：<br />
超详细的旅游线路展示程序：出发地 出团日期 行程特色 往返交通 行程安排 包含项目 不含项目 儿童安排 购物安排 注意事项 其它 &nbsp;<br />
多网合一 PC站、手机站、微旅游 一次到位<br />
PHP全开源，代码在手，权力我有。一次付费 终生使用<br />
海量接口扩展 连接7亿网民，QQ登录　微信登录　支付宝　微信支付　物流接口...<br />
可视化操作，看得见的，都可自己改，妈妈再也不用担心我的二次开发费用了<br />
基于梦行框架，功能模块扩展 so easy<br />','0',''),
('27','11','1','概述','应用场景：各类信息在线登记<br />
应用方向举列：在线报名 简历投递 加盟申请 信息登记 ...<br />
方案特色：<br />
各类输入框任君选：单行文本 多行文本 编辑器 下拉框 单选按钮 &nbsp;复选框 &nbsp;图片 多图片 文件上传 多文件上传 数字 时间 地图坐标 地区选择框<br />
多网合一 PC端、手机端、微站 一次到位<br />
PHP全开源，代码在手，权力我有。永久免费使用<br />
海量接口扩展 连接7亿网民，QQ登录　微信登录　支付宝　微信支付...<br />
基于梦行框架，功能模块扩展 so easy <br />
<br />','0',''),
('28','12','1','概述','方案名称：梦行大奖(刮刮乐 大转盘 摇红包)<br />
应用场景：各类节假日线上活动 公司周年庆活动 促销活动 引流量活动 开业活动<br />
方案特色：<br />
多网合一 电脑端活动、手机端活动、微信端活动 一次到位<br />
PHP全开源，代码在手，权力我有。一次付费 终生使用<br />
多种抽奖模式：留电话抽奖 分享朋友圈抽奖 积分抽奖 余额抽奖 输入抽奖码抽奖 <br />
丰富的奖品类型：包邮实物 自领实物 余额 积分 微信红包 <br />
海量接口扩展 连接7亿网民，QQ登录　微信登录　支付宝　微信支付　物流接口...<br />
基于梦行框架，功能模块扩展 so easy <br />
<br />
<br />','0',''),
('29','13','1','概述','应用场景：超市 餐厅 各收费站<br />
应用方向举列：各行各业线下实体店<br />
方案特色：<br />
快速对接支付宝　微信支付，收款，方便客户，成就自己<br />
多网合一 PC端、手机端、微站 一次到位<br />
PHP全开源，代码在手，权力我有。一次付费 终生使用<br />
海量接口扩展 连接7亿网民，QQ登录　微信登录　支付宝　微信支付...<br />
基于梦行框架，功能模块扩展 so easy <br />','0',''),
('30','14','1','概述','应用场景：各产品的 在线手册 帮助手册 教程文档 使用手册<br />
应用方向举列：梦行软件教程 各平台API文档<br />
方案特色：<br />
<br />
多网合一 PC端、手机端、微站 一次到位<br />
PHP全开源，代码在手，权力我有。一次付费 终生使用<br />
海量接口扩展 连接7亿网民，QQ登录　微信登录　支付宝　微信支付...<br />
基于梦行框架，功能模块扩展 so easy <br />','0',''),
('31','15','1','概述','应用场景：各公司业务部<br />
方案特色：<br />
客户入档 跟进 管理 好轻松<br />
多网合一 PC端、手机端、微站 一次到位<br />
PHP全开源，代码在手，权力我有。一次付费 终生使用<br />
海量接口扩展 连接7亿网民，QQ登录　微信登录　支付宝　微信支付...<br />
基于梦行框架，功能模块扩展 so easy <br />
<br />
<br />','0',''),
('32','0','0','','./index.php?monxin=mall.goods&id=16','1',''),
('35','7','6','使用案例','./index.php?monxin=image.show_thumb&type=78&detail_show_method=','0','./index.php?monxin=image.show_thumb&type=78&detail_show_method='),
('36','8','6','使用案例','./index.php?monxin=image.show_thumb&type=81&detail_show_method=','0','./index.php?monxin=image.show_thumb&type=81&detail_show_method='),
('37','0','0','','#','1',''),
('38','0','0','','#','1',''),
('39','0','0','','#','1',''),
('40','0','0','','#','1',''),
('41','0','0','','#','1',''),
('82','9','4','使用案例','./index.php?monxin=image.show_thumb&type=82&detail_show_method=','0','./index.php?monxin=image.show_thumb&type=82&detail_show_method='),
('83','9','5','立即购买','./index.php?monxin=mall.goods&id=18','1','./index.php?monxin=mall.goods&id=18'),
('81','9','3','演示站','http://www.monxin.cn/','1','http://www.monxin.cn/'),
('80','9','2','功能试用','<div id=&#34;image_show_thumb&#34; class=&#34;portlet light&#34; monxin-module=&#34;image_show_thumb&#34; align=&#34;left&#34; save_name=&#34;image_show_thumb(field:title/src|sequence_field:sequence|sequence_type:desc|quantity:100|target:_blank|sub_module_width:21%|image_height:11rem|detail_show_method:show)&#34; style=&#34;width:100%;&#34;>
<script>
    $(document).ready(function(){
    });
    </script>
<style>
	#image_show_thumb{ margin:5px; padding:0px;}
	#image_show_thumb .remark{ line-height:2.14rem;}
    #image_show_thumb .thumbs_div{ line-height:1.42rem; text-align:left; }
    #image_show_thumb .thumbs_div a{ margin-left:0.5%; margin-right:0.5%;  display:inline-block; vertical-align:top;  width:18%; overflow:hidden; text-align:center; margin-bottom:20px; }
    #image_show_thumb .thumbs_div a:hover{ border:1px solid #ddd; }
    #image_show_thumb .thumbs_div a span{ display:block; line-height:20px;}
    #image_show_thumb .thumbs_div a span .m_label{ display:inline-block;}
    #image_show_thumb .thumbs_div a .title{ display:block; font-size:0.9rem; height:2.14rem; line-height:2.14rem; display:block; overflow:hidden;}
    #image_show_thumb .thumbs_div a .time{ display:inline-block; float:left; padding-left:10px; line-height:2.85rem;}
    #image_show_thumb .thumbs_div a .time .time_symbol{display:inline-block;  display:none;}
	#image_show_thumb .thumbs_div a .visit{display:inline-block;font-size:0.86rem; width:30%;  line-height:2.85rem;text-align:right; float:right;}
	#image_show_thumb .thumbs_div a .visit .visit_symbol{display:inline-block; line-height:1.42rem;}
	#image_show_thumb .thumbs_div a .visit .visit_symbol:before{margin-left:5px; font: normal normal normal 1rem/1 FontAwesome; content:&#34;0a6&#34;; opacity:0.6;}
    #image_show_thumb .thumbs_div a .thumb_img{ vertical-align:middle;width:70% !important; max-width:70% !important; margin:0.5rem; margin-bottom:0px;}
    #image_show_thumb .thumbs_div a .thumb_img:hover{ opacity:0.8;}
	#image_show_thumb .thumbs_div div{}
	.page_row{ padding-left:0.5rem; padding-right:0.5rem;}
    </style>
	<div id=&#34;image_show_thumb_html&#34; class=&#34;module_div_bottom_margin&#34;>
		<div class=&#34;remark&#34;>
		</div>
		<div class=&#34;thumbs_div&#34;>
			<a href=&#34;index.php?monxin=diypage.show&id=170&#34; id=&#34;image_show_365&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_17_3849.png&#34; class=&#34;thumb_img&#34; alt=&#34;主系统&#34; /><span class=&#34;title&#34;>主系统</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=174&#34; id=&#34;image_show_360&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_12_7807.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行微信&#34; /><span class=&#34;title&#34;>梦行微信</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=173&#34; id=&#34;image_show_348&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_0_5907.png&#34; class=&#34;thumb_img&#34; alt=&#34;自定义网页&#34; /><span class=&#34;title&#34;>自定义网页</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=181&#34; id=&#34;image_show_349&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_1_2130.png&#34; class=&#34;thumb_img&#34; alt=&#34;图片幻灯片&#34; /><span class=&#34;title&#34;>图片幻灯片</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=175&#34; id=&#34;image_show_350&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_2_8816.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行展图&#34; /><span class=&#34;title&#34;>梦行展图</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=180&#34; id=&#34;image_show_351&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_3_6702.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行展文&#34; /><span class=&#34;title&#34;>梦行展文</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=176&#34; id=&#34;image_show_352&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_4_9066.png&#34; class=&#34;thumb_img&#34; alt=&#34;留言反馈&#34; /><span class=&#34;title&#34;>留言反馈</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=178&#34; id=&#34;image_show_353&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_5_2727.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行表单&#34; /><span class=&#34;title&#34;>梦行表单</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=image.show&id=354&type=80&order=sequence|desc&search=&#34; id=&#34;image_show_354&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_6_6903.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行自定义模块&#34; /><span class=&#34;title&#34;>梦行自定义模块</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=179&#34; id=&#34;image_show_356&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_8_1168.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行谈谈&#34; /><span class=&#34;title&#34;>梦行谈谈</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=182&#34; id=&#34;image_show_357&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_9_4150.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行采集&#34; /><span class=&#34;title&#34;>梦行采集</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=184&#34; id=&#34;image_show_358&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_10_5043.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行菜单&#34; /><span class=&#34;title&#34;>梦行菜单</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=177&#34; id=&#34;image_show_363&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_15_7393.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行PK&#34; /><span class=&#34;title&#34;>梦行PK</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=186&#34; id=&#34;image_show_374&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_10/24/1477271246_0_4271.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行历程轴&#34; /><span class=&#34;title&#34;>梦行历程轴</span> 
			<div>
			</div>
</a> 
		</div>
	</div>
</div>','0',''),
('84','10','2','主功能','<div style=&#34;text-align:center;&#34;>
	<img src=&#34;program/best/attachd/image/20161130/20161130093032_91749.png&#34; width=&#34;60%&#34; alt=&#34;&#34; style=&#34;line-height:1.5;&#34; /> 
</div>','0','前台演示网址：<a href=&#34;http://tour.monxin.com&#34; target=&#34;_blank&#34;>http://tour.monxin.com</a><br />
<br />
<script>
$(document).ready(function(){
	div=get_param(&#39;div&#39;);
	if(div!=&#39;&#39;){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(&#39;.&#39;+div).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+div+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	}
	$(&#34;.mall_function .nav a&#34;).hover(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	},function(){
	});	
	$(&#34;.mall_function .nav a&#34;).click(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
		return  false;
	});	
});
</script>
<style>
#qiao-wrap{ display:none !important;}
#diypage_show{ padding-top:5px;}
#diypage_show_html .title{ display:none;}
.mall_function{ color: #000;}
.mall_function a{ color: #000;}
.mall_function .nav{ white-space:nowrap;}
.mall_function .nav a{ padding:5px !important;}
.mall_function .function_div{}
.mall_function .function_div ul{}
.mall_function .function_div ul li{  list-style:none; display:inline-block; vertical-align:top; margin:1%; width:30%; height:7rem;}
.mall_function .function_div ul li a{  display:block; text-align:center;}
.mall_function .function_div ul li a:hover{ opacity:0.8;}
.mall_function .function_div ul li a img{ list-style:none; width:60%;    background: #009900;border-radius: 25%;}
.mall_function .function_div ul li a span{ line-height:30px; font-size:13px;}
.mall_function .function_div .admin_div{}
.mall_function .login_info{ margin-left:4%;  display:inline-block; background-color: #CCC; color:#FFF; border-radius:5px; padding:5px; line-height:20px;white-space:nowrap;}
.mall_function .login_info a{ color:#FFF;}
.function_div > div{ display:none;}
</style>
<div class=&#34;mall_function&#34;>
	<ul class=&#34;nav nav-tabs&#34; device_tabs=&#34;1&#34;>
		<li role=&#34;presentation&#34; class=&#34;active&#34;>
			<a href=&#34;#&#34; class=&#34;admin&#34;>总管理员</a> 
		</li>
		<li role=&#34;presentation&#34;>
			<a href=&#34;#&#34; class=&#34;other&#34;>其它会员</a> 
		</li>
	</ul>
	<div class=&#34;function_div&#34;>
		<div class=&#34;admin_div&#34; style=&#34;display:block;&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://tour.monxin.com/index.php?monxin=travel.index&#34; target=&#34;_blank&#34;>http://tour.monxin.com/index.php?monxin=travel.index</a><br />
&nbsp;登 录 名: monxin.com<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://tour.monxin.com/index.php?monxin=travel.line_admin&#34; target=&#34;_blank&#34;><img src=&#34;http://tour.monxin.com/templates/1/travel/default/page_icon/travel.line_admin.png&#34; /><br />
<span>旅游线路</span></a> 
				</li>
				<li>
					<a href=&#34;http://tour.monxin.com/index.php?monxin=travel.type&#34; target=&#34;_blank&#34;><img src=&#34;http://tour.monxin.com/templates/1/travel/default/page_icon/travel.type.png&#34; /><br />
<span>线路分类</span></a> 
				</li>
				<li>
					<a href=&#34;http://tour.monxin.com/index.php?monxin=travel.tag&#34; target=&#34;_blank&#34;><img src=&#34;http://tour.monxin.com/templates/1/travel/default/page_icon/travel.tag.png&#34; /><br />
<span>线路标签</span></a> 
				</li>
				<li>
					<a href=&#34;http://tour.monxin.com/index.php?monxin=travel.theme&#34; target=&#34;_blank&#34;><img src=&#34;http://tour.monxin.com/templates/1/travel/default/page_icon/travel.theme.png&#34; /><br />
<span>线路主题</span></a> 
				</li>
				<li>
					<a href=&#34;http://tour.monxin.com/index.php?monxin=travel.season&#34; target=&#34;_blank&#34;><img src=&#34;http://tour.monxin.com/templates/1/travel/default/page_icon/travel.season.png&#34; /><br />
<span>适合季节</span></a> 
				</li>
				<li>
					<a href=&#34;http://tour.monxin.com/index.php?monxin=travel.group&#34; target=&#34;_blank&#34;><img src=&#34;http://tour.monxin.com/templates/1/travel/default/page_icon/travel.group.png&#34; /><br />
<span>适合人群</span></a> 
				</li>
				<li>
					<a href=&#34;http://tour.monxin.com/index.php?monxin=travel.method&#34; target=&#34;_blank&#34;><img src=&#34;http://tour.monxin.com/templates/1/travel/default/page_icon/travel.method.png&#34; /><br />
<span>旅游方式</span></a> 
				</li>
				<li>
					<a href=&#34;http://tour.monxin.com/index.php?monxin=travel.insure&#34; target=&#34;_blank&#34;><img src=&#34;http://tour.monxin.com/templates/1/travel/default/page_icon/travel.insure.png&#34; /><br />
<span>旅游保险</span></a> 
				</li>
				<li>
					<a href=&#34;http://tour.monxin.com/index.php?monxin=travel.order_admin&#34; target=&#34;_blank&#34;><img src=&#34;http://tour.monxin.com/templates/1/travel/default/page_icon/travel.order_admin.png&#34; /><br />
<span>旅游订单</span></a> 
				</li>
				<li>
					<a href=&#34;http://tour.monxin.com/index.php?monxin=travel.search_log&#34; target=&#34;_blank&#34;><img src=&#34;http://tour.monxin.com/templates/1/travel/default/page_icon/travel.search_log.png&#34; /><br />
<span>搜索记录</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
		<div class=&#34;other_div&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://tour.monxin.com/index.php?monxin=travel.my_order&#34; target=&#34;_blank&#34;>http://tour.monxin.com/index.php?monxin=travel.my_order</a><br />
&nbsp;登 录 名: 张三<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://tour.monxin.com/index.php?monxin=travel.my_order&#34; target=&#34;_blank&#34;><img src=&#34;http://tour.monxin.com/templates/1/tour/default/page_icon/travel.my_order.png&#34; /><br />
<span>旅游订单</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
	</div>
</div>'),
('85','10','3','试用','前台演示网址：<a href=&#34;http://tour.monxin.com&#34; target=&#34;_blank&#34;>http://tour.monxin.com</a><br />
<br />
<script>
$(document).ready(function(){
	div=get_param(&#39;div&#39;);
	if(div!=&#39;&#39;){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(&#39;.&#39;+div).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+div+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	}
	$(&#34;.mall_function .nav a&#34;).hover(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	},function(){
	});	
	$(&#34;.mall_function .nav a&#34;).click(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
		return  false;
	});	
});
</script>
<style>
#qiao-wrap{ display:none !important;}
#diypage_show{ padding-top:5px;}
#diypage_show_html .title{ display:none;}
.mall_function{ color: #000;}
.mall_function a{ color: #000;}
.mall_function .nav{}
.mall_function .function_div{}
.mall_function .function_div ul{}
.mall_function .function_div ul li{ list-style:none; display:inline-block; vertical-align:top; margin:1%; width:14%;height: 10.71rem;}
.mall_function .function_div ul li a{ display:block; text-align:center;}
.mall_function .function_div ul li a:hover{ opacity:0.8;}
.mall_function .function_div ul li a img{ list-style:none; width:60%;    background: #009900;border-radius: 25%;}
.mall_function .function_div ul li a span{ line-height:30px; font-size:15px;}
.mall_function .function_div .admin_div{}
.mall_function .login_info{ margin-left:4%;  display:inline-block; background-color: #CCC; color:#FFF; border-radius:5px; padding:5px; line-height:20px;}
.mall_function .login_info a{ color:#FFF;}
.function_div > div{ display:none;}
</style>
<div class=&#34;mall_function&#34;>
	<ul class=&#34;nav nav-tabs&#34; device_tabs=&#34;1&#34;>
		<li role=&#34;presentation&#34; class=&#34;active&#34;>
			<a href=&#34;#&#34; class=&#34;admin&#34;>总管理员</a> 
		</li>
		<li role=&#34;presentation&#34; class=&#34;&#34;>
			<a href=&#34;#&#34; class=&#34;other&#34;>其它会员</a> 
		</li>
	</ul>
	<div class=&#34;function_div&#34;>
		<div class=&#34;admin_div&#34; style=&#34;display:block;&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://tour.monxin.com/index.php?monxin=travel.index&#34; target=&#34;_blank&#34;>http://tour.monxin.com/index.php?monxin=travel.index</a><br />
&nbsp;登 录 名: monxin.com<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://tour.monxin.com/index.php?monxin=travel.line_admin&#34; target=&#34;_blank&#34;><img src=&#34;http://tour.monxin.com/templates/1/travel/default/page_icon/travel.line_admin.png&#34; /><br />
<span>旅游线路</span></a> 
				</li>
				<li>
					<a href=&#34;http://tour.monxin.com/index.php?monxin=travel.type&#34; target=&#34;_blank&#34;><img src=&#34;http://tour.monxin.com/templates/1/travel/default/page_icon/travel.type.png&#34; /><br />
<span>线路分类</span></a> 
				</li>
				<li>
					<a href=&#34;http://tour.monxin.com/index.php?monxin=travel.tag&#34; target=&#34;_blank&#34;><img src=&#34;http://tour.monxin.com/templates/1/travel/default/page_icon/travel.tag.png&#34; /><br />
<span>线路标签</span></a> 
				</li>
				<li>
					<a href=&#34;http://tour.monxin.com/index.php?monxin=travel.theme&#34; target=&#34;_blank&#34;><img src=&#34;http://tour.monxin.com/templates/1/travel/default/page_icon/travel.theme.png&#34; /><br />
<span>线路主题</span></a> 
				</li>
				<li>
					<a href=&#34;http://tour.monxin.com/index.php?monxin=travel.season&#34; target=&#34;_blank&#34;><img src=&#34;http://tour.monxin.com/templates/1/travel/default/page_icon/travel.season.png&#34; /><br />
<span>适合季节</span></a> 
				</li>
				<li>
					<a href=&#34;http://tour.monxin.com/index.php?monxin=travel.group&#34; target=&#34;_blank&#34;><img src=&#34;http://tour.monxin.com/templates/1/travel/default/page_icon/travel.group.png&#34; /><br />
<span>适合人群</span></a> 
				</li>
				<li>
					<a href=&#34;http://tour.monxin.com/index.php?monxin=travel.method&#34; target=&#34;_blank&#34;><img src=&#34;http://tour.monxin.com/templates/1/travel/default/page_icon/travel.method.png&#34; /><br />
<span>旅游方式</span></a> 
				</li>
				<li>
					<a href=&#34;http://tour.monxin.com/index.php?monxin=travel.insure&#34; target=&#34;_blank&#34;><img src=&#34;http://tour.monxin.com/templates/1/travel/default/page_icon/travel.insure.png&#34; /><br />
<span>旅游保险</span></a> 
				</li>
				<li>
					<a href=&#34;http://tour.monxin.com/index.php?monxin=travel.order_admin&#34; target=&#34;_blank&#34;><img src=&#34;http://tour.monxin.com/templates/1/travel/default/page_icon/travel.order_admin.png&#34; /><br />
<span>旅游订单</span></a> 
				</li>
				<li>
					<a href=&#34;http://tour.monxin.com/index.php?monxin=travel.search_log&#34; target=&#34;_blank&#34;><img src=&#34;http://tour.monxin.com/templates/1/travel/default/page_icon/travel.search_log.png&#34; /><br />
<span>搜索记录</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
		<div class=&#34;other_div&#34; style=&#34;display:none;&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://tour.monxin.com/index.php?monxin=travel.my_order&#34; target=&#34;_blank&#34;>http://tour.monxin.com/index.php?monxin=travel.my_order</a><br />
&nbsp;登 录 名: 张三<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://tour.monxin.com/index.php?monxin=travel.my_order&#34; target=&#34;_blank&#34;><img src=&#34;http://tour.monxin.com/templates/1/tour/default/page_icon/travel.my_order.png&#34; /><br />
<span>旅游订单</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
	</div>
</div>
','0',''),
('86','10','4','配套功能','<div id=&#34;image_show_thumb&#34; class=&#34;portlet light&#34; monxin-module=&#34;image_show_thumb&#34; align=&#34;left&#34; save_name=&#34;image_show_thumb(field:title/src|sequence_field:sequence|sequence_type:desc|quantity:100|target:_blank|sub_module_width:21%|image_height:11rem|detail_show_method:show)&#34; style=&#34;width:100%;&#34;>
<script>
    $(document).ready(function(){
    });
    </script>
<style>
	#image_show_thumb{ margin:5px; padding:0px;}
	#image_show_thumb .remark{ line-height:2.14rem;}
    #image_show_thumb .thumbs_div{ line-height:1.42rem; text-align:left; }
    #image_show_thumb .thumbs_div a{ margin-left:0.5%; margin-right:0.5%;  display:inline-block; vertical-align:top;  width:18%; overflow:hidden; text-align:center; margin-bottom:20px; }
    #image_show_thumb .thumbs_div a:hover{ border:1px solid #ddd; }
    #image_show_thumb .thumbs_div a span{ display:block; line-height:20px;}
    #image_show_thumb .thumbs_div a span .m_label{ display:inline-block;}
    #image_show_thumb .thumbs_div a .title{ display:block; font-size:0.9rem; height:2.14rem; line-height:2.14rem; display:block; overflow:hidden;}
    #image_show_thumb .thumbs_div a .time{ display:inline-block; float:left; padding-left:10px; line-height:2.85rem;}
    #image_show_thumb .thumbs_div a .time .time_symbol{display:inline-block;  display:none;}
	#image_show_thumb .thumbs_div a .visit{display:inline-block;font-size:0.86rem; width:30%;  line-height:2.85rem;text-align:right; float:right;}
	#image_show_thumb .thumbs_div a .visit .visit_symbol{display:inline-block; line-height:1.42rem;}
	#image_show_thumb .thumbs_div a .visit .visit_symbol:before{margin-left:5px; font: normal normal normal 1rem/1 FontAwesome; content:&#34;0a6&#34;; opacity:0.6;}
    #image_show_thumb .thumbs_div a .thumb_img{ vertical-align:middle;width:70% !important; max-width:70% !important; margin:0.5rem; margin-bottom:0px;}
    #image_show_thumb .thumbs_div a .thumb_img:hover{ opacity:0.8;}
	#image_show_thumb .thumbs_div div{}
	.page_row{ padding-left:0.5rem; padding-right:0.5rem;}
    </style>
	<div id=&#34;image_show_thumb_html&#34; class=&#34;module_div_bottom_margin&#34;>
		<div class=&#34;remark&#34;>
		</div>
		<div class=&#34;thumbs_div&#34;>
			<a href=&#34;index.php?monxin=diypage.show&id=170&#34; id=&#34;image_show_365&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_17_3849.png&#34; class=&#34;thumb_img&#34; alt=&#34;主系统&#34; /><span class=&#34;title&#34;>主系统</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=174&#34; id=&#34;image_show_360&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_12_7807.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行微信&#34; /><span class=&#34;title&#34;>梦行微信</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=173&#34; id=&#34;image_show_348&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_0_5907.png&#34; class=&#34;thumb_img&#34; alt=&#34;自定义网页&#34; /><span class=&#34;title&#34;>自定义网页</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=181&#34; id=&#34;image_show_349&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_1_2130.png&#34; class=&#34;thumb_img&#34; alt=&#34;图片幻灯片&#34; /><span class=&#34;title&#34;>图片幻灯片</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=175&#34; id=&#34;image_show_350&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_2_8816.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行展图&#34; /><span class=&#34;title&#34;>梦行展图</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=180&#34; id=&#34;image_show_351&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_3_6702.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行展文&#34; /><span class=&#34;title&#34;>梦行展文</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=176&#34; id=&#34;image_show_352&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_4_9066.png&#34; class=&#34;thumb_img&#34; alt=&#34;留言反馈&#34; /><span class=&#34;title&#34;>留言反馈</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=178&#34; id=&#34;image_show_353&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_5_2727.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行表单&#34; /><span class=&#34;title&#34;>梦行表单</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=image.show&id=354&type=80&order=sequence|desc&search=&#34; id=&#34;image_show_354&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_6_6903.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行自定义模块&#34; /><span class=&#34;title&#34;>梦行自定义模块</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=179&#34; id=&#34;image_show_356&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_8_1168.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行谈谈&#34; /><span class=&#34;title&#34;>梦行谈谈</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=182&#34; id=&#34;image_show_357&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_9_4150.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行采集&#34; /><span class=&#34;title&#34;>梦行采集</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=184&#34; id=&#34;image_show_358&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_10_5043.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行菜单&#34; /><span class=&#34;title&#34;>梦行菜单</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=177&#34; id=&#34;image_show_363&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_15_7393.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行PK&#34; /><span class=&#34;title&#34;>梦行PK</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=186&#34; id=&#34;image_show_374&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_10/24/1477271246_0_4271.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行历程轴&#34; /><span class=&#34;title&#34;>梦行历程轴</span> 
			<div>
			</div>
</a> 
		</div>
	</div>
</div>','0',''),
('87','10','5','演示站','http://tour.monxin.com/','1','http://tour.monxin.com/'),
('88','10','6','使用案例','./index.php?monxin=image.show_thumb&type=83&detail_show_method=','0','./index.php?monxin=image.show_thumb&type=83&detail_show_method='),
('89','10','7','立即购买','./index.php?monxin=mall.goods&id=15','1','./index.php?monxin=mall.goods&id=15'),
('90','11','2','主功能','<div style=&#34;text-align:center;&#34;>
	<img src=&#34;program/best/attachd/image/20161128/20161128050117_13905.jpg&#34; width=&#34;80%&#34; alt=&#34;&#34; style=&#34;line-height:1.5;&#34; />
</div>','0',''),
('91','11','3','试用','<script>
$(document).ready(function(){
	div=get_param(&#39;div&#39;);
	if(div!=&#39;&#39;){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(&#39;.&#39;+div).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+div+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	}
	$(&#34;.mall_function .nav a&#34;).hover(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	},function(){
	});	
	$(&#34;.mall_function .nav a&#34;).click(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
		return  false;
	});	
});
</script>
<style>
#qiao-wrap{ display:none !important;}
#diypage_show{ padding-top:5px;}
#diypage_show_html .title{ display:none;}
.mall_function{ color: #000;}
.mall_function a{ color: #000;}
.mall_function .nav{}
.mall_function .function_div{}
.mall_function .function_div ul{}
.mall_function .function_div ul li{ list-style:none; display:inline-block; vertical-align:top; margin:1%; width:14%;height: 10.71rem;}
.mall_function .function_div ul li a{ display:block; text-align:center;}
.mall_function .function_div ul li a:hover{ opacity:0.8;}
.mall_function .function_div ul li a img{ list-style:none; width:60%;    background: #009900;border-radius: 25%;}
.mall_function .function_div ul li a span{ line-height:30px; font-size:15px;}
.mall_function .function_div .admin_div{}
.mall_function .login_info{ margin-left:4%;  display:inline-block; background-color: #CCC; color:#FFF; border-radius:5px; padding:5px; line-height:20px;}
.mall_function .login_info a{ color:#FFF;}
.function_div > div{ display:none;}
</style>
<div class=&#34;mall_function&#34;>
	<ul class=&#34;nav nav-tabs&#34; device_tabs=&#34;1&#34;>
		<li role=&#34;presentation&#34; class=&#34;active&#34;>
			<a href=&#34;#&#34; class=&#34;admin&#34;>总管理员</a> 
		</li>
		<li role=&#34;presentation&#34;>
			<a href=&#34;#&#34; class=&#34;other&#34;>其它会员</a> 
		</li>
	</ul>
	<div class=&#34;function_div&#34;>
		<div class=&#34;admin_div&#34; style=&#34;display:block;&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://form.monxin.com/index.php?monxin=form.table_admin&#34; target=&#34;_blank&#34;>http://form.monxin.com/index.php?monxin=form.table_admin</a><br />
&nbsp;登 录 名: monxin.com<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://form.monxin.com/index.php?monxin=form.table_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/form/default/page_icon/form.table_admin.png&#34; /><br />
<span>管理表单</span></a> 
				</li>
				<li>
					<a href=&#34;http://form.monxin.com/index.php?monxin=form.table_add&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/form/default/page_icon/form.table_add.png&#34; /><br />
<span>添加表单</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
		<div class=&#34;other_div&#34;>
			<ul>
				<li>
					<a href=&#34;http://form.monxin.com/&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/image/default/page_icon/image.add.png&#34; /><br />
<span>提交数据</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
	</div>
</div>','0','<script>
$(document).ready(function(){
	div=get_param(&#39;div&#39;);
	if(div!=&#39;&#39;){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(&#39;.&#39;+div).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+div+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	}
	$(&#34;.mall_function .nav a&#34;).hover(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	},function(){
	});	
	$(&#34;.mall_function .nav a&#34;).click(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
		return  false;
	});	
});
</script>
<style>
#qiao-wrap{ display:none !important;}
#diypage_show{ padding-top:5px;}
#diypage_show_html .title{ display:none;}
.mall_function{ color: #000;}
.mall_function a{ color: #000;}
.mall_function .nav{ white-space:nowrap;}
.mall_function .nav a{ padding:5px !important;}
.mall_function .function_div{}
.mall_function .function_div ul{}
.mall_function .function_div ul li{  list-style:none; display:inline-block; vertical-align:top; margin:1%; width:30%; height:7rem;}
.mall_function .function_div ul li a{  display:block; text-align:center;}
.mall_function .function_div ul li a:hover{ opacity:0.8;}
.mall_function .function_div ul li a img{ list-style:none; width:60%;    background: #009900;border-radius: 25%;}
.mall_function .function_div ul li a span{ line-height:30px; font-size:13px;}
.mall_function .function_div .admin_div{}
.mall_function .login_info{ margin-left:4%;  display:inline-block; background-color: #CCC; color:#FFF; border-radius:5px; padding:5px; line-height:20px;white-space:nowrap;}
.mall_function .login_info a{ color:#FFF;}
.function_div > div{ display:none;}
</style>
<div class=&#34;mall_function&#34;>
	<ul class=&#34;nav nav-tabs&#34; device_tabs=&#34;1&#34;>
		<li role=&#34;presentation&#34; class=&#34;active&#34;>
			<a href=&#34;#&#34; class=&#34;admin&#34;>总管理员</a> 
		</li>
		<li role=&#34;presentation&#34;>
			<a href=&#34;#&#34; class=&#34;other&#34;>其它会员</a> 
		</li>
	</ul>
	<div class=&#34;function_div&#34;>
		<div class=&#34;admin_div&#34; style=&#34;display:block;&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://form.monxin.com/index.php?monxin=form.table_admin&#34; target=&#34;_blank&#34;>http://form.monxin.com/index.php?monxin=form.table_admin</a><br />
&nbsp;登 录 名: monxin.com<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://form.monxin.com/index.php?monxin=form.table_admin&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/form/default/page_icon/form.table_admin.png&#34; /><br />
<span>管理表单</span></a> 
				</li>
				<li>
					<a href=&#34;http://form.monxin.com/index.php?monxin=form.table_add&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/form/default/page_icon/form.table_add.png&#34; /><br />
<span>添加表单</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
		<div class=&#34;other_div&#34;>
			<ul>
				<li>
					<a href=&#34;http://form.monxin.com&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/image/default/page_icon/image.add.png&#34; /><br />
<span>提交数据</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
	</div>
</div>'),
('92','11','4','配套功能','<div id=&#34;image_show_thumb&#34; class=&#34;portlet light&#34; monxin-module=&#34;image_show_thumb&#34; align=&#34;left&#34; save_name=&#34;image_show_thumb(field:title/src|sequence_field:sequence|sequence_type:desc|quantity:100|target:_blank|sub_module_width:21%|image_height:11rem|detail_show_method:show)&#34; style=&#34;width:100%;&#34;>
<script>
    $(document).ready(function(){
    });
    </script>
<style>
	#image_show_thumb{ margin:5px; padding:0px;}
	#image_show_thumb .remark{ line-height:2.14rem;}
    #image_show_thumb .thumbs_div{ line-height:1.42rem; text-align:left; }
    #image_show_thumb .thumbs_div a{ margin-left:0.5%; margin-right:0.5%;  display:inline-block; vertical-align:top;  width:18%; overflow:hidden; text-align:center; margin-bottom:20px; }
    #image_show_thumb .thumbs_div a:hover{ border:1px solid #ddd; }
    #image_show_thumb .thumbs_div a span{ display:block; line-height:20px;}
    #image_show_thumb .thumbs_div a span .m_label{ display:inline-block;}
    #image_show_thumb .thumbs_div a .title{ display:block; font-size:0.9rem; height:2.14rem; line-height:2.14rem; display:block; overflow:hidden;}
    #image_show_thumb .thumbs_div a .time{ display:inline-block; float:left; padding-left:10px; line-height:2.85rem;}
    #image_show_thumb .thumbs_div a .time .time_symbol{display:inline-block;  display:none;}
	#image_show_thumb .thumbs_div a .visit{display:inline-block;font-size:0.86rem; width:30%;  line-height:2.85rem;text-align:right; float:right;}
	#image_show_thumb .thumbs_div a .visit .visit_symbol{display:inline-block; line-height:1.42rem;}
	#image_show_thumb .thumbs_div a .visit .visit_symbol:before{margin-left:5px; font: normal normal normal 1rem/1 FontAwesome; content:&#34;0a6&#34;; opacity:0.6;}
    #image_show_thumb .thumbs_div a .thumb_img{ vertical-align:middle;width:70% !important; max-width:70% !important; margin:0.5rem; margin-bottom:0px;}
    #image_show_thumb .thumbs_div a .thumb_img:hover{ opacity:0.8;}
	#image_show_thumb .thumbs_div div{}
	.page_row{ padding-left:0.5rem; padding-right:0.5rem;}
    </style>
	<div id=&#34;image_show_thumb_html&#34; class=&#34;module_div_bottom_margin&#34;>
		<div class=&#34;remark&#34;>
		</div>
		<div class=&#34;thumbs_div&#34;>
			<a href=&#34;index.php?monxin=diypage.show&id=170&#34; id=&#34;image_show_365&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_17_3849.png&#34; class=&#34;thumb_img&#34; alt=&#34;主系统&#34; /><span class=&#34;title&#34;>主系统</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=174&#34; id=&#34;image_show_360&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_12_7807.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行微信&#34; /><span class=&#34;title&#34;>梦行微信</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=173&#34; id=&#34;image_show_348&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_0_5907.png&#34; class=&#34;thumb_img&#34; alt=&#34;自定义网页&#34; /><span class=&#34;title&#34;>自定义网页</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=181&#34; id=&#34;image_show_349&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_1_2130.png&#34; class=&#34;thumb_img&#34; alt=&#34;图片幻灯片&#34; /><span class=&#34;title&#34;>图片幻灯片</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=175&#34; id=&#34;image_show_350&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_2_8816.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行展图&#34; /><span class=&#34;title&#34;>梦行展图</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=180&#34; id=&#34;image_show_351&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_3_6702.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行展文&#34; /><span class=&#34;title&#34;>梦行展文</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=176&#34; id=&#34;image_show_352&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_4_9066.png&#34; class=&#34;thumb_img&#34; alt=&#34;留言反馈&#34; /><span class=&#34;title&#34;>留言反馈</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=178&#34; id=&#34;image_show_353&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_5_2727.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行表单&#34; /><span class=&#34;title&#34;>梦行表单</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=image.show&id=354&type=80&order=sequence|desc&search=&#34; id=&#34;image_show_354&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_6_6903.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行自定义模块&#34; /><span class=&#34;title&#34;>梦行自定义模块</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=179&#34; id=&#34;image_show_356&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_8_1168.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行谈谈&#34; /><span class=&#34;title&#34;>梦行谈谈</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=182&#34; id=&#34;image_show_357&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_9_4150.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行采集&#34; /><span class=&#34;title&#34;>梦行采集</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=184&#34; id=&#34;image_show_358&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_10_5043.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行菜单&#34; /><span class=&#34;title&#34;>梦行菜单</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=177&#34; id=&#34;image_show_363&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_15_7393.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行PK&#34; /><span class=&#34;title&#34;>梦行PK</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=186&#34; id=&#34;image_show_374&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_10/24/1477271246_0_4271.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行历程轴&#34; /><span class=&#34;title&#34;>梦行历程轴</span> 
			<div>
			</div>
</a> 
		</div>
	</div>
</div>','0',''),
('93','11','5','演示站','http://form.monxin.com/','1','http://form.monxin.com/');m;o;n;
INSERT INTO `monxin_best_paragraph` (`id`,`best_id`,`sequence`,`title`,`content_pc`,`is_full`,`content_phone`) VALUES
('94','11','6','使用案例','./index.php?monxin=image.show_thumb&type=84&detail_show_method=','0','./index.php?monxin=image.show_thumb&type=84&detail_show_method='),
('95','11','7','立即购买','./index.php?monxin=mall.goods&id=25','1','/index.php?monxin=mall.goods&amp;id=25'),
('96','12','2','主功能','<div style=&#34;text-align:center;&#34;>
	<img src=&#34;program/best/attachd/image/20161130/20161130141744_99436.png&#34; width=&#34;60%&#34; alt=&#34;&#34; style=&#34;line-height:1.5;&#34; />
</div>','1',''),
('97','12','3','试用','<script>
$(document).ready(function(){
	div=get_param(&#39;div&#39;);
	if(div!=&#39;&#39;){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(&#39;.&#39;+div).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+div+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	}
	$(&#34;.mall_function .nav a&#34;).hover(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	},function(){
	});	
	$(&#34;.mall_function .nav a&#34;).click(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
		return  false;
	});	
});
</script>
<style>
#qiao-wrap{ display:none !important;}
#diypage_show{ padding-top:5px;}
#diypage_show_html .title{ display:none;}
.mall_function{ color: #000;}
.mall_function a{ color: #000;}
.mall_function .nav{}
.mall_function .function_div{}
.mall_function .function_div ul{}
.mall_function .function_div ul li{ list-style:none; display:inline-block; vertical-align:top; margin:1%; width:14%;height: 10.71rem;}
.mall_function .function_div ul li a{ display:block; text-align:center;}
.mall_function .function_div ul li a:hover{ opacity:0.8;}
.mall_function .function_div ul li a img{ list-style:none; width:60%;    background: #009900;border-radius: 25%;}
.mall_function .function_div ul li a span{ line-height:30px; font-size:15px;}
.mall_function .function_div .admin_div{}
.mall_function .login_info{ margin-left:4%;  display:inline-block; background-color: #CCC; color:#FFF; border-radius:5px; padding:5px; line-height:20px;}
.mall_function .login_info a{ color:#FFF;}
.function_div > div{ display:none;}
</style>
<div class=&#34;mall_function&#34;>
	<ul class=&#34;nav nav-tabs&#34; device_tabs=&#34;1&#34;>
		<li role=&#34;presentation&#34; class=&#34;active&#34;>
			<a href=&#34;#&#34; class=&#34;admin&#34;>总管理员</a> 
		</li>
		<li role=&#34;presentation&#34;>
			<a href=&#34;#&#34; class=&#34;other&#34;>其它会员</a> 
		</li>
	</ul>
	<div class=&#34;function_div&#34;>
		<div class=&#34;admin_div&#34; style=&#34;display:block;&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://prize.monxin.com/index.php?monxin=index.user&#34; target=&#34;_blank&#34;>http://prize.monxin.com/index.php?monxin=index.user</a><br />
&nbsp;登 录 名: monxin.com<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.template&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/templates/1/prize/default/page_icon/prize.template.png&#34; /><br />
<span>活动分类模板</span></a> 
				</li>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.admin&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/templates/1/prize/default/page_icon/prize.admin.png&#34; /><br />
<span>全站活动管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.content&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/templates/1/prize/default/page_icon/prize.content.png&#34; /><br />
<span>我的活动</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
		<div class=&#34;other_div&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://prize.monxin.com/index.php?monxin=prize.my&#34; target=&#34;_blank&#34;>http://prize.monxin.com/index.php?monxin=prize.my</a><br />
&nbsp;登 录 名: 张三<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.my&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/templates/1/prize/default/page_icon/prize.my.png&#34; /><br />
<span>我的中奖记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.show&id=2&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/program/diymodule/attachd/image/20161018/20161018055310_12996.png&#34; /><br />
<span>刮刮乐</span></a> 
				</li>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.show&id=4&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/program/diymodule/attachd/image/20161018/20161018055310_85058.png&#34; /><br />
<span>大转盘</span></a> 
				</li>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.show&id=14&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/program/diymodule/attachd/image/20161018/20161018055310_35293.png&#34; /><br />
<span>摇红包</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
	</div>
</div>','0','<script>
$(document).ready(function(){
	div=get_param(&#39;div&#39;);
	if(div!=&#39;&#39;){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(&#39;.&#39;+div).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+div+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	}
	$(&#34;.mall_function .nav a&#34;).hover(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	},function(){
	});	
	$(&#34;.mall_function .nav a&#34;).click(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
		return  false;
	});	
});
</script>
<style>
#qiao-wrap{ display:none !important;}
#diypage_show{ padding-top:5px;}
#diypage_show_html .title{ display:none;}
.mall_function{ color: #000;}
.mall_function a{ color: #000;}
.mall_function .nav{ white-space:nowrap;}
.mall_function .nav a{ padding:5px !important;}
.mall_function .function_div{}
.mall_function .function_div ul{}
.mall_function .function_div ul li{  list-style:none; display:inline-block; vertical-align:top; margin:1%; width:30%; height:7rem;}
.mall_function .function_div ul li a{  display:block; text-align:center;}
.mall_function .function_div ul li a:hover{ opacity:0.8;}
.mall_function .function_div ul li a img{ list-style:none; width:60%;    background: #009900;border-radius: 25%;}
.mall_function .function_div ul li a span{ line-height:30px; font-size:13px;}
.mall_function .function_div .admin_div{}
.mall_function .login_info{ margin-left:4%;  display:inline-block; background-color: #CCC; color:#FFF; border-radius:5px; padding:5px; line-height:20px;white-space:nowrap;}
.mall_function .login_info a{ color:#FFF;}
.function_div > div{ display:none;}
</style>
<div class=&#34;mall_function&#34;>
	<ul class=&#34;nav nav-tabs&#34; device_tabs=&#34;1&#34;>
		<li role=&#34;presentation&#34; class=&#34;active&#34;>
			<a href=&#34;#&#34; class=&#34;admin&#34;>总管理员</a> 
		</li>
		<li role=&#34;presentation&#34;>
			<a href=&#34;#&#34; class=&#34;other&#34;>其它会员</a> 
		</li>
	</ul>
	<div class=&#34;function_div&#34;>
		<div class=&#34;admin_div&#34; style=&#34;display:block;&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://prize.monxin.com/index.php?monxin=index.user&#34; target=&#34;_blank&#34;>http://prize.monxin.com/index.php?monxin=index.user</a><br />
&nbsp;登 录 名: monxin.com<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.template&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/templates/1/prize/default/page_icon/prize.template.png&#34; /><br />
<span>活动分类模板</span></a> 
				</li>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.admin&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/templates/1/prize/default/page_icon/prize.admin.png&#34; /><br />
<span>全站活动管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.content&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/templates/1/prize/default/page_icon/prize.content.png&#34; /><br />
<span>我的活动</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
		<div class=&#34;other_div&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://prize.monxin.com/index.php?monxin=prize.my&#34; target=&#34;_blank&#34;>http://prize.monxin.com/index.php?monxin=prize.my</a><br />
&nbsp;登 录 名: 张三<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.my&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/templates/1/prize/default/page_icon/prize.my.png&#34; /><br />
<span>我的中奖记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.show&id=2&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/program/diymodule/attachd/image/20161018/20161018055310_12996.png&#34; /><br />
<span>刮刮乐</span></a> 
				</li>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.show&id=4&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/program/diymodule/attachd/image/20161018/20161018055310_85058.png&#34; /><br />
<span>大转盘</span></a> 
				</li>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.show&id=14&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/program/diymodule/attachd/image/20161018/20161018055310_35293.png&#34; /><br />
<span>摇红包</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
	</div>
</div>'),
('98','12','4','配套功能','<div id=&#34;image_show_thumb&#34; class=&#34;portlet light&#34; monxin-module=&#34;image_show_thumb&#34; align=&#34;left&#34; save_name=&#34;image_show_thumb(field:title/src|sequence_field:sequence|sequence_type:desc|quantity:100|target:_blank|sub_module_width:21%|image_height:11rem|detail_show_method:show)&#34; style=&#34;width:100%;&#34;>
<script>
    $(document).ready(function(){
    });
    </script>
<style>
	#image_show_thumb{ margin:5px; padding:0px;}
	#image_show_thumb .remark{ line-height:2.14rem;}
    #image_show_thumb .thumbs_div{ line-height:1.42rem; text-align:left; }
    #image_show_thumb .thumbs_div a{ margin-left:0.5%; margin-right:0.5%;  display:inline-block; vertical-align:top;  width:18%; overflow:hidden; text-align:center; margin-bottom:20px; }
    #image_show_thumb .thumbs_div a:hover{ border:1px solid #ddd; }
    #image_show_thumb .thumbs_div a span{ display:block; line-height:20px;}
    #image_show_thumb .thumbs_div a span .m_label{ display:inline-block;}
    #image_show_thumb .thumbs_div a .title{ display:block; font-size:0.9rem; height:2.14rem; line-height:2.14rem; display:block; overflow:hidden;}
    #image_show_thumb .thumbs_div a .time{ display:inline-block; float:left; padding-left:10px; line-height:2.85rem;}
    #image_show_thumb .thumbs_div a .time .time_symbol{display:inline-block;  display:none;}
	#image_show_thumb .thumbs_div a .visit{display:inline-block;font-size:0.86rem; width:30%;  line-height:2.85rem;text-align:right; float:right;}
	#image_show_thumb .thumbs_div a .visit .visit_symbol{display:inline-block; line-height:1.42rem;}
	#image_show_thumb .thumbs_div a .visit .visit_symbol:before{margin-left:5px; font: normal normal normal 1rem/1 FontAwesome; content:&#34;0a6&#34;; opacity:0.6;}
    #image_show_thumb .thumbs_div a .thumb_img{ vertical-align:middle;width:70% !important; max-width:70% !important; margin:0.5rem; margin-bottom:0px;}
    #image_show_thumb .thumbs_div a .thumb_img:hover{ opacity:0.8;}
	#image_show_thumb .thumbs_div div{}
	.page_row{ padding-left:0.5rem; padding-right:0.5rem;}
    </style>
	<div id=&#34;image_show_thumb_html&#34; class=&#34;module_div_bottom_margin&#34;>
		<div class=&#34;remark&#34;>
		</div>
		<div class=&#34;thumbs_div&#34;>
			<a href=&#34;index.php?monxin=diypage.show&id=170&#34; id=&#34;image_show_365&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_17_3849.png&#34; class=&#34;thumb_img&#34; alt=&#34;主系统&#34; /><span class=&#34;title&#34;>主系统</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=174&#34; id=&#34;image_show_360&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_12_7807.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行微信&#34; /><span class=&#34;title&#34;>梦行微信</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=173&#34; id=&#34;image_show_348&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_0_5907.png&#34; class=&#34;thumb_img&#34; alt=&#34;自定义网页&#34; /><span class=&#34;title&#34;>自定义网页</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=181&#34; id=&#34;image_show_349&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_1_2130.png&#34; class=&#34;thumb_img&#34; alt=&#34;图片幻灯片&#34; /><span class=&#34;title&#34;>图片幻灯片</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=175&#34; id=&#34;image_show_350&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_2_8816.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行展图&#34; /><span class=&#34;title&#34;>梦行展图</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=180&#34; id=&#34;image_show_351&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_3_6702.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行展文&#34; /><span class=&#34;title&#34;>梦行展文</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=176&#34; id=&#34;image_show_352&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_4_9066.png&#34; class=&#34;thumb_img&#34; alt=&#34;留言反馈&#34; /><span class=&#34;title&#34;>留言反馈</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=178&#34; id=&#34;image_show_353&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_5_2727.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行表单&#34; /><span class=&#34;title&#34;>梦行表单</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=image.show&id=354&type=80&order=sequence|desc&search=&#34; id=&#34;image_show_354&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_6_6903.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行自定义模块&#34; /><span class=&#34;title&#34;>梦行自定义模块</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=179&#34; id=&#34;image_show_356&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_8_1168.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行谈谈&#34; /><span class=&#34;title&#34;>梦行谈谈</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=182&#34; id=&#34;image_show_357&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_9_4150.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行采集&#34; /><span class=&#34;title&#34;>梦行采集</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=184&#34; id=&#34;image_show_358&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_10_5043.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行菜单&#34; /><span class=&#34;title&#34;>梦行菜单</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=177&#34; id=&#34;image_show_363&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_15_7393.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行PK&#34; /><span class=&#34;title&#34;>梦行PK</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=186&#34; id=&#34;image_show_374&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_10/24/1477271246_0_4271.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行历程轴&#34; /><span class=&#34;title&#34;>梦行历程轴</span> 
			<div>
			</div>
</a> 
		</div>
	</div>
</div>','0',''),
('99','12','5','演示站','http://prize.monxin.com/','1','http://prize.monxin.com/'),
('100','12','6','使用案例','./index.php?monxin=image.show_thumb&type=85&detail_show_method=','0','./index.php?monxin=image.show_thumb&amp;type=85&amp;detail_show_method='),
('101','12','7','立即购买','./index.php?monxin=mall.goods&id=1','1','./index.php?monxin=mall.goods&id=1'),
('102','13','2','主功能','<div style=&#34;text-align:center;&#34;>
	<img src=&#34;program/best/attachd/image/20161128/20161128050505_79587.jpg&#34; width=&#34;70%&#34; alt=&#34;&#34; style=&#34;line-height:1.5;&#34; />
</div>','1',''),
('103','13','3','试用','<script>
$(document).ready(function(){
	div=get_param(&#39;div&#39;);
	if(div!=&#39;&#39;){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(&#39;.&#39;+div).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+div+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	}
	$(&#34;.mall_function .nav a&#34;).hover(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	},function(){
	});	
	$(&#34;.mall_function .nav a&#34;).click(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
		return  false;
	});	
});
</script>
<style>
#qiao-wrap{ display:none !important;}
#diypage_show{ padding-top:5px;}
#diypage_show_html .title{ display:none;}
.mall_function{ color: #000;}
.mall_function a{ color: #000;}
.mall_function .nav{}
.mall_function .function_div{}
.mall_function .function_div ul{}
.mall_function .function_div ul li{ list-style:none; display:inline-block; vertical-align:top; margin:1%; width:14%;height: 10.71rem;}
.mall_function .function_div ul li a{ display:block; text-align:center;}
.mall_function .function_div ul li a:hover{ opacity:0.8;}
.mall_function .function_div ul li a img{ list-style:none; width:60%;    background: #009900;border-radius: 25%;}
.mall_function .function_div ul li a span{ line-height:30px; font-size:15px;}
.mall_function .function_div .admin_div{}
.mall_function .login_info{ margin-left:4%;  display:inline-block; background-color: #CCC; color:#FFF; border-radius:5px; padding:5px; line-height:20px;}
.mall_function .login_info a{ color:#FFF;}
.function_div > div{ display:none;}
</style>
<div class=&#34;mall_function&#34;>
	<ul class=&#34;nav nav-tabs&#34; device_tabs=&#34;1&#34;>
		<li role=&#34;presentation&#34; class=&#34;active&#34;>
			<a href=&#34;#&#34; class=&#34;admin&#34;>总管理员</a> 
		</li>
		<li role=&#34;presentation&#34;>
			<a href=&#34;#&#34; class=&#34;other&#34;>其它会员</a> 
		</li>
	</ul>
	<div class=&#34;function_div&#34;>
		<div class=&#34;admin_div&#34; style=&#34;display:block;&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://prize.monxin.com/index.php?monxin=index.user&#34; target=&#34;_blank&#34;>http://prize.monxin.com/index.php?monxin=index.user</a><br />
&nbsp;登 录 名: monxin.com<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.template&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/templates/1/prize/default/page_icon/prize.template.png&#34; /><br />
<span>活动分类模板</span></a> 
				</li>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.admin&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/templates/1/prize/default/page_icon/prize.admin.png&#34; /><br />
<span>全站活动管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.content&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/templates/1/prize/default/page_icon/prize.content.png&#34; /><br />
<span>我的活动</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
		<div class=&#34;other_div&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://prize.monxin.com/index.php?monxin=prize.my&#34; target=&#34;_blank&#34;>http://prize.monxin.com/index.php?monxin=prize.my</a><br />
&nbsp;登 录 名: 张三<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.my&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/templates/1/prize/default/page_icon/prize.my.png&#34; /><br />
<span>我的中奖记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.show&id=2&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/program/diymodule/attachd/image/20161018/20161018055310_12996.png&#34; /><br />
<span>刮刮乐</span></a> 
				</li>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.show&id=4&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/program/diymodule/attachd/image/20161018/20161018055310_85058.png&#34; /><br />
<span>大转盘</span></a> 
				</li>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.show&id=14&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/program/diymodule/attachd/image/20161018/20161018055310_35293.png&#34; /><br />
<span>摇红包</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
	</div>
</div>','0','<script>
$(document).ready(function(){
	div=get_param(&#39;div&#39;);
	if(div!=&#39;&#39;){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(&#39;.&#39;+div).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+div+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	}
	$(&#34;.mall_function .nav a&#34;).hover(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	},function(){
	});	
	$(&#34;.mall_function .nav a&#34;).click(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
		return  false;
	});	
});
</script>
<style>
#qiao-wrap{ display:none !important;}
#diypage_show{ padding-top:5px;}
#diypage_show_html .title{ display:none;}
.mall_function{ color: #000;}
.mall_function a{ color: #000;}
.mall_function .nav{ white-space:nowrap;}
.mall_function .nav a{ padding:5px !important;}
.mall_function .function_div{}
.mall_function .function_div ul{}
.mall_function .function_div ul li{  list-style:none; display:inline-block; vertical-align:top; margin:1%; width:30%; height:7rem;}
.mall_function .function_div ul li a{  display:block; text-align:center;}
.mall_function .function_div ul li a:hover{ opacity:0.8;}
.mall_function .function_div ul li a img{ list-style:none; width:60%;    background: #009900;border-radius: 25%;}
.mall_function .function_div ul li a span{ line-height:30px; font-size:13px;}
.mall_function .function_div .admin_div{}
.mall_function .login_info{ margin-left:4%;  display:inline-block; background-color: #CCC; color:#FFF; border-radius:5px; padding:5px; line-height:20px;white-space:nowrap;}
.mall_function .login_info a{ color:#FFF;}
.function_div > div{ display:none;}
</style>
<div class=&#34;mall_function&#34;>
	<ul class=&#34;nav nav-tabs&#34; device_tabs=&#34;1&#34;>
		<li role=&#34;presentation&#34; class=&#34;active&#34;>
			<a href=&#34;#&#34; class=&#34;admin&#34;>总管理员</a> 
		</li>
		<li role=&#34;presentation&#34;>
			<a href=&#34;#&#34; class=&#34;other&#34;>其它会员</a> 
		</li>
	</ul>
	<div class=&#34;function_div&#34;>
		<div class=&#34;admin_div&#34; style=&#34;display:block;&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://prize.monxin.com/index.php?monxin=index.user&#34; target=&#34;_blank&#34;>http://prize.monxin.com/index.php?monxin=index.user</a><br />
&nbsp;登 录 名: monxin.com<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.template&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/templates/1/prize/default/page_icon/prize.template.png&#34; /><br />
<span>活动分类模板</span></a> 
				</li>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.admin&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/templates/1/prize/default/page_icon/prize.admin.png&#34; /><br />
<span>全站活动管理</span></a> 
				</li>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.content&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/templates/1/prize/default/page_icon/prize.content.png&#34; /><br />
<span>我的活动</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
		<div class=&#34;other_div&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://prize.monxin.com/index.php?monxin=prize.my&#34; target=&#34;_blank&#34;>http://prize.monxin.com/index.php?monxin=prize.my</a><br />
&nbsp;登 录 名: 张三<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.my&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/templates/1/prize/default/page_icon/prize.my.png&#34; /><br />
<span>我的中奖记录</span></a> 
				</li>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.show&id=2&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/program/diymodule/attachd/image/20161018/20161018055310_12996.png&#34; /><br />
<span>刮刮乐</span></a> 
				</li>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.show&id=4&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/program/diymodule/attachd/image/20161018/20161018055310_85058.png&#34; /><br />
<span>大转盘</span></a> 
				</li>
				<li>
					<a href=&#34;http://prize.monxin.com/index.php?monxin=prize.show&id=14&#34; target=&#34;_blank&#34;><img src=&#34;http://prize.monxin.com/program/diymodule/attachd/image/20161018/20161018055310_35293.png&#34; /><br />
<span>摇红包</span></a> 
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
	</div>
</div>'),
('104','13','4','配套功能','<div id=&#34;image_show_thumb&#34; class=&#34;portlet light&#34; monxin-module=&#34;image_show_thumb&#34; align=&#34;left&#34; save_name=&#34;image_show_thumb(field:title/src|sequence_field:sequence|sequence_type:desc|quantity:100|target:_blank|sub_module_width:21%|image_height:11rem|detail_show_method:show)&#34; style=&#34;width:100%;&#34;>
<script>
    $(document).ready(function(){
    });
    </script>
<style>
	#image_show_thumb{ margin:5px; padding:0px;}
	#image_show_thumb .remark{ line-height:2.14rem;}
    #image_show_thumb .thumbs_div{ line-height:1.42rem; text-align:left; }
    #image_show_thumb .thumbs_div a{ margin-left:0.5%; margin-right:0.5%;  display:inline-block; vertical-align:top;  width:18%; overflow:hidden; text-align:center; margin-bottom:20px; }
    #image_show_thumb .thumbs_div a:hover{ border:1px solid #ddd; }
    #image_show_thumb .thumbs_div a span{ display:block; line-height:20px;}
    #image_show_thumb .thumbs_div a span .m_label{ display:inline-block;}
    #image_show_thumb .thumbs_div a .title{ display:block; font-size:0.9rem; height:2.14rem; line-height:2.14rem; display:block; overflow:hidden;}
    #image_show_thumb .thumbs_div a .time{ display:inline-block; float:left; padding-left:10px; line-height:2.85rem;}
    #image_show_thumb .thumbs_div a .time .time_symbol{display:inline-block;  display:none;}
	#image_show_thumb .thumbs_div a .visit{display:inline-block;font-size:0.86rem; width:30%;  line-height:2.85rem;text-align:right; float:right;}
	#image_show_thumb .thumbs_div a .visit .visit_symbol{display:inline-block; line-height:1.42rem;}
	#image_show_thumb .thumbs_div a .visit .visit_symbol:before{margin-left:5px; font: normal normal normal 1rem/1 FontAwesome; content:&#34;0a6&#34;; opacity:0.6;}
    #image_show_thumb .thumbs_div a .thumb_img{ vertical-align:middle;width:70% !important; max-width:70% !important; margin:0.5rem; margin-bottom:0px;}
    #image_show_thumb .thumbs_div a .thumb_img:hover{ opacity:0.8;}
	#image_show_thumb .thumbs_div div{}
	.page_row{ padding-left:0.5rem; padding-right:0.5rem;}
    </style>
	<div id=&#34;image_show_thumb_html&#34; class=&#34;module_div_bottom_margin&#34;>
		<div class=&#34;remark&#34;>
		</div>
		<div class=&#34;thumbs_div&#34;>
			<a href=&#34;index.php?monxin=diypage.show&id=170&#34; id=&#34;image_show_365&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_17_3849.png&#34; class=&#34;thumb_img&#34; alt=&#34;主系统&#34; /><span class=&#34;title&#34;>主系统</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=174&#34; id=&#34;image_show_360&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_12_7807.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行微信&#34; /><span class=&#34;title&#34;>梦行微信</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=173&#34; id=&#34;image_show_348&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_0_5907.png&#34; class=&#34;thumb_img&#34; alt=&#34;自定义网页&#34; /><span class=&#34;title&#34;>自定义网页</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=181&#34; id=&#34;image_show_349&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_1_2130.png&#34; class=&#34;thumb_img&#34; alt=&#34;图片幻灯片&#34; /><span class=&#34;title&#34;>图片幻灯片</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=175&#34; id=&#34;image_show_350&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_2_8816.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行展图&#34; /><span class=&#34;title&#34;>梦行展图</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=180&#34; id=&#34;image_show_351&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_3_6702.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行展文&#34; /><span class=&#34;title&#34;>梦行展文</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=176&#34; id=&#34;image_show_352&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_4_9066.png&#34; class=&#34;thumb_img&#34; alt=&#34;留言反馈&#34; /><span class=&#34;title&#34;>留言反馈</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=178&#34; id=&#34;image_show_353&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_5_2727.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行表单&#34; /><span class=&#34;title&#34;>梦行表单</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=image.show&id=354&type=80&order=sequence|desc&search=&#34; id=&#34;image_show_354&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_6_6903.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行自定义模块&#34; /><span class=&#34;title&#34;>梦行自定义模块</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=179&#34; id=&#34;image_show_356&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_8_1168.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行谈谈&#34; /><span class=&#34;title&#34;>梦行谈谈</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=182&#34; id=&#34;image_show_357&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_9_4150.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行采集&#34; /><span class=&#34;title&#34;>梦行采集</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=184&#34; id=&#34;image_show_358&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_10_5043.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行菜单&#34; /><span class=&#34;title&#34;>梦行菜单</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=177&#34; id=&#34;image_show_363&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_15_7393.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行PK&#34; /><span class=&#34;title&#34;>梦行PK</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=186&#34; id=&#34;image_show_374&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_10/24/1477271246_0_4271.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行历程轴&#34; /><span class=&#34;title&#34;>梦行历程轴</span> 
			<div>
			</div>
</a> 
		</div>
	</div>
</div>','0',''),
('106','13','5','使用案例','./index.php?monxin=image.show_thumb&type=86&detail_show_method=','0','./index.php?monxin=image.show_thumb&type=86&detail_show_method='),
('107','13','6','立即购买','./index.php?monxin=mall.goods&id=24','1','./index.php?monxin=mall.goods&id=24'),
('108','14','2','主功能','<div style=&#34;text-align:center;&#34;>
	<img src=&#34;program/best/attachd/image/20161130/20161130152303_18011.png&#34; width=&#34;60%&#34; alt=&#34;&#34; style=&#34;line-height:1.5;&#34; /><span style=&#34;line-height:1.5;&#34;></span>
</div>','1',''),
('110','14','3','配套功能','<div id=&#34;image_show_thumb&#34; class=&#34;portlet light&#34; monxin-module=&#34;image_show_thumb&#34; align=&#34;left&#34; save_name=&#34;image_show_thumb(field:title/src|sequence_field:sequence|sequence_type:desc|quantity:100|target:_blank|sub_module_width:21%|image_height:11rem|detail_show_method:show)&#34; style=&#34;width:100%;&#34;>
<script>
    $(document).ready(function(){
    });
    </script>
<style>
	#image_show_thumb{ margin:5px; padding:0px;}
	#image_show_thumb .remark{ line-height:2.14rem;}
    #image_show_thumb .thumbs_div{ line-height:1.42rem; text-align:left; }
    #image_show_thumb .thumbs_div a{ margin-left:0.5%; margin-right:0.5%;  display:inline-block; vertical-align:top;  width:18%; overflow:hidden; text-align:center; margin-bottom:20px; }
    #image_show_thumb .thumbs_div a:hover{ border:1px solid #ddd; }
    #image_show_thumb .thumbs_div a span{ display:block; line-height:20px;}
    #image_show_thumb .thumbs_div a span .m_label{ display:inline-block;}
    #image_show_thumb .thumbs_div a .title{ display:block; font-size:0.9rem; height:2.14rem; line-height:2.14rem; display:block; overflow:hidden;}
    #image_show_thumb .thumbs_div a .time{ display:inline-block; float:left; padding-left:10px; line-height:2.85rem;}
    #image_show_thumb .thumbs_div a .time .time_symbol{display:inline-block;  display:none;}
	#image_show_thumb .thumbs_div a .visit{display:inline-block;font-size:0.86rem; width:30%;  line-height:2.85rem;text-align:right; float:right;}
	#image_show_thumb .thumbs_div a .visit .visit_symbol{display:inline-block; line-height:1.42rem;}
	#image_show_thumb .thumbs_div a .visit .visit_symbol:before{margin-left:5px; font: normal normal normal 1rem/1 FontAwesome; content:&#34;0a6&#34;; opacity:0.6;}
    #image_show_thumb .thumbs_div a .thumb_img{ vertical-align:middle;width:70% !important; max-width:70% !important; margin:0.5rem; margin-bottom:0px;}
    #image_show_thumb .thumbs_div a .thumb_img:hover{ opacity:0.8;}
	#image_show_thumb .thumbs_div div{}
	.page_row{ padding-left:0.5rem; padding-right:0.5rem;}
    </style>
	<div id=&#34;image_show_thumb_html&#34; class=&#34;module_div_bottom_margin&#34;>
		<div class=&#34;remark&#34;>
		</div>
		<div class=&#34;thumbs_div&#34;>
			<a href=&#34;index.php?monxin=diypage.show&id=170&#34; id=&#34;image_show_365&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_17_3849.png&#34; class=&#34;thumb_img&#34; alt=&#34;主系统&#34; /><span class=&#34;title&#34;>主系统</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=174&#34; id=&#34;image_show_360&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_12_7807.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行微信&#34; /><span class=&#34;title&#34;>梦行微信</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=173&#34; id=&#34;image_show_348&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_0_5907.png&#34; class=&#34;thumb_img&#34; alt=&#34;自定义网页&#34; /><span class=&#34;title&#34;>自定义网页</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=181&#34; id=&#34;image_show_349&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_1_2130.png&#34; class=&#34;thumb_img&#34; alt=&#34;图片幻灯片&#34; /><span class=&#34;title&#34;>图片幻灯片</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=175&#34; id=&#34;image_show_350&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_2_8816.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行展图&#34; /><span class=&#34;title&#34;>梦行展图</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=180&#34; id=&#34;image_show_351&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_3_6702.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行展文&#34; /><span class=&#34;title&#34;>梦行展文</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=176&#34; id=&#34;image_show_352&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_4_9066.png&#34; class=&#34;thumb_img&#34; alt=&#34;留言反馈&#34; /><span class=&#34;title&#34;>留言反馈</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=178&#34; id=&#34;image_show_353&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_5_2727.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行表单&#34; /><span class=&#34;title&#34;>梦行表单</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=image.show&id=354&type=80&order=sequence|desc&search=&#34; id=&#34;image_show_354&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_6_6903.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行自定义模块&#34; /><span class=&#34;title&#34;>梦行自定义模块</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=179&#34; id=&#34;image_show_356&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_8_1168.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行谈谈&#34; /><span class=&#34;title&#34;>梦行谈谈</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=182&#34; id=&#34;image_show_357&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_9_4150.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行采集&#34; /><span class=&#34;title&#34;>梦行采集</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=184&#34; id=&#34;image_show_358&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_10_5043.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行菜单&#34; /><span class=&#34;title&#34;>梦行菜单</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=177&#34; id=&#34;image_show_363&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_15_7393.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行PK&#34; /><span class=&#34;title&#34;>梦行PK</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=186&#34; id=&#34;image_show_374&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_10/24/1477271246_0_4271.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行历程轴&#34; /><span class=&#34;title&#34;>梦行历程轴</span> 
			<div>
			</div>
</a> 
		</div>
	</div>
</div>','0',''),
('113','14','4','立即购买','./index.php?monxin=mall.goods&id=22','1','./index.php?monxin=mall.goods&id=22'),
('114','15','2','主功能','<div style=&#34;text-align:center;&#34;>
	<img src=&#34;program/best/attachd/image/20161201/20161201033029_59106.png&#34; alt=&#34;&#34; style=&#34;width:70%;line-height:1.5;&#34; /> 
</div>','0',''),
('115','15','3','试用','<script>
$(document).ready(function(){
	div=get_param(&#39;div&#39;);
	if(div!=&#39;&#39;){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(&#39;.&#39;+div).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+div+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	}
	$(&#34;.mall_function .nav a&#34;).hover(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	},function(){
	});	
	$(&#34;.mall_function .nav a&#34;).click(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
		return  false;
	});	
});
</script>
<style>
#diypage_show{ padding-top:5px;}
#diypage_show_html .title{ display:none;}
.mall_function{ color: #000;}
.mall_function a{ color: #000;}
.mall_function .nav{}
.mall_function .function_div{}
.mall_function .function_div ul{}
.mall_function .function_div ul li{ list-style:none; display:inline-block; vertical-align:top; margin:1%; width:14%;height: 10.71rem;}
.mall_function .function_div ul li a{ display:block; text-align:center;}
.mall_function .function_div ul li a:hover{ opacity:0.8;}
.mall_function .function_div ul li a img{ list-style:none; width:60%;    background: #009900;border-radius: 25%;}
.mall_function .function_div ul li a span{ line-height:30px; font-size:15px;}
.mall_function .function_div .admin_div{}
.mall_function .login_info{ margin-left:4%;  display:inline-block; background-color: #CCC; color:#FFF; border-radius:5px; padding:5px; line-height:20px;}
.mall_function .login_info a{ color:#FFF;}
.function_div > div{ display:none;}
</style>
<div class=&#34;mall_function&#34;>
	<ul class=&#34;nav nav-tabs&#34; device_tabs=&#34;1&#34;>
		<li role=&#34;presentation&#34; class=&#34;active&#34;>
			<a href=&#34;#&#34; class=&#34;admin&#34;>总管理员</a> 
		</li>
		<li role=&#34;seller&#34;>
			<a href=&#34;#&#34; class=&#34;seller&#34;>业务经理</a> 
		</li>
		<li role=&#34;presentation&#34;>
			<a href=&#34;#&#34; class=&#34;other&#34;>业务员</a> 
		</li>
	</ul>
	<div class=&#34;function_div&#34;>
		<div class=&#34;admin_div&#34; style=&#34;display:block;&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://crm.monxin.com/index.php?monxin=index.user&#34; target=&#34;_blank&#34;>http://crm.monxin.com/index.php?monxin=index.user</a><br />
&nbsp;登 录 名: monxin.com<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://crm.monxin.com/index.php?monxin=crm.customer&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/crm/default/page_icon/crm.customer.png&#34; /><br />
<span>客户管理</span></a>
				</li>
				<li>
					<a href=&#34;http://crm.monxin.com/index.php?monxin=crm.contract&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/crm/default/page_icon/crm.contract.png&#34; /><br />
<span>合同管理</span></a>
				</li>
				<li>
					<a href=&#34;http://crm.monxin.com/index.php?monxin=crm.salesman&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/crm/default/page_icon/crm.salesman.png&#34; /><br />
<span>管理业务员</span></a>
				</li>
				<li>
					<a href=&#34;http://crm.monxin.com/index.php?monxin=crm.manager&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/crm/default/page_icon/crm.manager.png&#34; /><br />
<span>管理业务经理</span></a>
				</li>
				<li>
					<a href=&#34;http://crm.monxin.com/index.php?monxin=crm.field&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/crm/default/page_icon/crm.field.png&#34; /><br />
<span>输入项管理</span></a>
				</li>
				<li>
					<a href=&#34;http://crm.monxin.com/index.php?monxin=crm.power&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/crm/default/page_icon/crm.power.png&#34; /><br />
<span>删除权限设置</span></a>
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
		<div class=&#34;seller_div&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://crm.monxin.com/index.php?monxin=index.user&#34; target=&#34;_blank&#34;>http://crm.monxin.com/index.php?monxin=index.user</a><br />
&nbsp;登 录 名: 张经理<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://crm.monxin.com/index.php?monxin=crm.customer&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/crm/default/page_icon/crm.customer.png&#34; /><br />
<span>客户管理</span></a>
				</li>
				<li>
					<a href=&#34;http://crm.monxin.com/index.php?monxin=crm.contract&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/crm/default/page_icon/crm.contract.png&#34; /><br />
<span>合同管理</span></a>
				</li>
				<li>
					<a href=&#34;http://crm.monxin.com/index.php?monxin=crm.salesman&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/crm/default/page_icon/crm.salesman.png&#34; /><br />
<span>管理业务员</span></a>
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
		<div class=&#34;other_div&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://crm.monxin.com/index.php?monxin=scanpay.pay&#34; target=&#34;_blank&#34;>http://crm.monxin.com/index.php?monxin=scanpay.pay</a><br />
&nbsp;登 录 名: 田一<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://crm.monxin.com/index.php?monxin=crm.customer&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/crm/default/page_icon/crm.customer.png&#34; /><br />
<span>客户管理</span></a>
				</li>
				<li>
					<a href=&#34;http://crm.monxin.com/index.php?monxin=crm.contract&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/crm/default/page_icon/crm.contract.png&#34; /><br />
<span>合同管理</span></a>
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
	</div>
</div>','0','<script>
$(document).ready(function(){
	div=get_param(&#39;div&#39;);
	if(div!=&#39;&#39;){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(&#39;.&#39;+div).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+div+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	}
	$(&#34;.mall_function .nav a&#34;).hover(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
	},function(){
	});	
	$(&#34;.mall_function .nav a&#34;).click(function(){
		$(&#34;.mall_function .nav li&#34;).removeClass(&#39;active&#39;);
		$(this).parent().addClass(&#39;active&#39;);
		$(&#34;.mall_function .function_div > div&#34;).css(&#39;display&#39;,&#39;none&#39;);
		$(&#34;.&#34;+$(this).attr(&#39;class&#39;)+&#34;_div&#34;).css(&#39;display&#39;,&#39;block&#39;);
		return  false;
	});	
});
</script>
<style>
#qiao-wrap{ display:none !important;}
#diypage_show{ padding-top:5px;}
#diypage_show_html .title{ display:none;}
.mall_function{ color: #000;}
.mall_function a{ color: #000;}
.mall_function .nav{ white-space:nowrap;}
.mall_function .nav a{ padding:5px !important;}
.mall_function .function_div{}
.mall_function .function_div ul{}
.mall_function .function_div ul li{  list-style:none; display:inline-block; vertical-align:top; margin:1%; width:30%; height:7rem;}
.mall_function .function_div ul li a{  display:block; text-align:center;}
.mall_function .function_div ul li a:hover{ opacity:0.8;}
.mall_function .function_div ul li a img{ list-style:none; width:60%;    background: #009900;border-radius: 25%;}
.mall_function .function_div ul li a span{ line-height:30px; font-size:13px;}
.mall_function .function_div .admin_div{}
.mall_function .login_info{ margin-left:4%;  display:inline-block; background-color: #CCC; color:#FFF; border-radius:5px; padding:5px; line-height:20px;white-space:nowrap;}
.mall_function .login_info a{ color:#FFF;}
.function_div > div{ display:none;}
</style>
<div class=&#34;mall_function&#34;>
	<ul class=&#34;nav nav-tabs&#34; device_tabs=&#34;1&#34;>
		<li role=&#34;presentation&#34; class=&#34;active&#34;>
			<a href=&#34;#&#34; class=&#34;admin&#34;>总管理员</a> 
		</li>
		<li role=&#34;seller&#34;>
			<a href=&#34;#&#34; class=&#34;seller&#34;>业务经理</a> 
		</li>
		<li role=&#34;presentation&#34;>
			<a href=&#34;#&#34; class=&#34;other&#34;>业务员</a> 
		</li>
	</ul>
	<div class=&#34;function_div&#34;>
		<div class=&#34;admin_div&#34; style=&#34;display:block;&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://crm.monxin.com/index.php?monxin=index.user&#34; target=&#34;_blank&#34;>http://crm.monxin.com/index.php?monxin=index.user</a><br />
&nbsp;登 录 名: monxin.com<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://crm.monxin.com/index.php?monxin=crm.customer&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/crm/default/page_icon/crm.customer.png&#34; /><br />
<span>客户管理</span></a>
				</li>
				<li>
					<a href=&#34;http://crm.monxin.com/index.php?monxin=crm.contract&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/crm/default/page_icon/crm.contract.png&#34; /><br />
<span>合同管理</span></a>
				</li>
				<li>
					<a href=&#34;http://crm.monxin.com/index.php?monxin=crm.salesman&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/crm/default/page_icon/crm.salesman.png&#34; /><br />
<span>管理业务员</span></a>
				</li>
				<li>
					<a href=&#34;http://crm.monxin.com/index.php?monxin=crm.manager&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/crm/default/page_icon/crm.manager.png&#34; /><br />
<span>管理业务经理</span></a>
				</li>
				<li>
					<a href=&#34;http://crm.monxin.com/index.php?monxin=crm.field&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/crm/default/page_icon/crm.field.png&#34; /><br />
<span>输入项管理</span></a>
				</li>
				<li>
					<a href=&#34;http://crm.monxin.com/index.php?monxin=crm.power&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/crm/default/page_icon/crm.power.png&#34; /><br />
<span>删除权限设置</span></a>
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
		<div class=&#34;seller_div&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://crm.monxin.com/index.php?monxin=index.user&#34; target=&#34;_blank&#34;>http://crm.monxin.com/index.php?monxin=index.user</a><br />
&nbsp;登 录 名: 张经理<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://crm.monxin.com/index.php?monxin=crm.customer&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/crm/default/page_icon/crm.customer.png&#34; /><br />
<span>客户管理</span></a>
				</li>
				<li>
					<a href=&#34;http://crm.monxin.com/index.php?monxin=crm.contract&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/crm/default/page_icon/crm.contract.png&#34; /><br />
<span>合同管理</span></a>
				</li>
				<li>
					<a href=&#34;http://crm.monxin.com/index.php?monxin=crm.salesman&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/crm/default/page_icon/crm.salesman.png&#34; /><br />
<span>管理业务员</span></a>
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
		<div class=&#34;other_div&#34;>
			<div class=&#34;login_info&#34;>
				管理入口: <a href=&#34;http://crm.monxin.com/index.php?monxin=scanpay.pay&#34; target=&#34;_blank&#34;>http://crm.monxin.com/index.php?monxin=scanpay.pay</a><br />
&nbsp;登 录 名: 田一<br />
登录密码: 123456
			</div>
			<ul>
				<li>
					<a href=&#34;http://crm.monxin.com/index.php?monxin=crm.customer&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/crm/default/page_icon/crm.customer.png&#34; /><br />
<span>客户管理</span></a>
				</li>
				<li>
					<a href=&#34;http://crm.monxin.com/index.php?monxin=crm.contract&#34; target=&#34;_blank&#34;><img src=&#34;templates/1/crm/default/page_icon/crm.contract.png&#34; /><br />
<span>合同管理</span></a>
				</li>
				<div style=&#34;clear:both;&#34;>
				</div>
			</ul>
		</div>
	</div>
</div>'),
('116','15','4','配套功能','<div id=&#34;image_show_thumb&#34; class=&#34;portlet light&#34; monxin-module=&#34;image_show_thumb&#34; align=&#34;left&#34; save_name=&#34;image_show_thumb(field:title/src|sequence_field:sequence|sequence_type:desc|quantity:100|target:_blank|sub_module_width:21%|image_height:11rem|detail_show_method:show)&#34; style=&#34;width:100%;&#34;>
<script>
    $(document).ready(function(){
    });
    </script>
<style>
	#image_show_thumb{ margin:5px; padding:0px;}
	#image_show_thumb .remark{ line-height:2.14rem;}
    #image_show_thumb .thumbs_div{ line-height:1.42rem; text-align:left; }
    #image_show_thumb .thumbs_div a{ margin-left:0.5%; margin-right:0.5%;  display:inline-block; vertical-align:top;  width:18%; overflow:hidden; text-align:center; margin-bottom:20px; }
    #image_show_thumb .thumbs_div a:hover{ border:1px solid #ddd; }
    #image_show_thumb .thumbs_div a span{ display:block; line-height:20px;}
    #image_show_thumb .thumbs_div a span .m_label{ display:inline-block;}
    #image_show_thumb .thumbs_div a .title{ display:block; font-size:0.9rem; height:2.14rem; line-height:2.14rem; display:block; overflow:hidden;}
    #image_show_thumb .thumbs_div a .time{ display:inline-block; float:left; padding-left:10px; line-height:2.85rem;}
    #image_show_thumb .thumbs_div a .time .time_symbol{display:inline-block;  display:none;}
	#image_show_thumb .thumbs_div a .visit{display:inline-block;font-size:0.86rem; width:30%;  line-height:2.85rem;text-align:right; float:right;}
	#image_show_thumb .thumbs_div a .visit .visit_symbol{display:inline-block; line-height:1.42rem;}
	#image_show_thumb .thumbs_div a .visit .visit_symbol:before{margin-left:5px; font: normal normal normal 1rem/1 FontAwesome; content:&#34;0a6&#34;; opacity:0.6;}
    #image_show_thumb .thumbs_div a .thumb_img{ vertical-align:middle;width:70% !important; max-width:70% !important; margin:0.5rem; margin-bottom:0px;}
    #image_show_thumb .thumbs_div a .thumb_img:hover{ opacity:0.8;}
	#image_show_thumb .thumbs_div div{}
	.page_row{ padding-left:0.5rem; padding-right:0.5rem;}
    </style>
	<div id=&#34;image_show_thumb_html&#34; class=&#34;module_div_bottom_margin&#34;>
		<div class=&#34;remark&#34;>
		</div>
		<div class=&#34;thumbs_div&#34;>
			<a href=&#34;index.php?monxin=diypage.show&id=170&#34; id=&#34;image_show_365&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_17_3849.png&#34; class=&#34;thumb_img&#34; alt=&#34;主系统&#34; /><span class=&#34;title&#34;>主系统</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=174&#34; id=&#34;image_show_360&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_12_7807.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行微信&#34; /><span class=&#34;title&#34;>梦行微信</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=173&#34; id=&#34;image_show_348&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_0_5907.png&#34; class=&#34;thumb_img&#34; alt=&#34;自定义网页&#34; /><span class=&#34;title&#34;>自定义网页</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=181&#34; id=&#34;image_show_349&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_1_2130.png&#34; class=&#34;thumb_img&#34; alt=&#34;图片幻灯片&#34; /><span class=&#34;title&#34;>图片幻灯片</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=175&#34; id=&#34;image_show_350&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_2_8816.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行展图&#34; /><span class=&#34;title&#34;>梦行展图</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=180&#34; id=&#34;image_show_351&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_3_6702.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行展文&#34; /><span class=&#34;title&#34;>梦行展文</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=176&#34; id=&#34;image_show_352&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_4_9066.png&#34; class=&#34;thumb_img&#34; alt=&#34;留言反馈&#34; /><span class=&#34;title&#34;>留言反馈</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=178&#34; id=&#34;image_show_353&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_5_2727.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行表单&#34; /><span class=&#34;title&#34;>梦行表单</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=image.show&id=354&type=80&order=sequence|desc&search=&#34; id=&#34;image_show_354&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_6_6903.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行自定义模块&#34; /><span class=&#34;title&#34;>梦行自定义模块</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=179&#34; id=&#34;image_show_356&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_8_1168.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行谈谈&#34; /><span class=&#34;title&#34;>梦行谈谈</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=182&#34; id=&#34;image_show_357&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_9_4150.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行采集&#34; /><span class=&#34;title&#34;>梦行采集</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=184&#34; id=&#34;image_show_358&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_10_5043.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行菜单&#34; /><span class=&#34;title&#34;>梦行菜单</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=177&#34; id=&#34;image_show_363&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_09/18/1474160592_15_7393.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行PK&#34; /><span class=&#34;title&#34;>梦行PK</span> 
			<div>
			</div>
</a><a href=&#34;index.php?monxin=diypage.show&id=186&#34; id=&#34;image_show_374&#34; target=&#34;_blank&#34;><img src=&#34;program/image/img_thumb/2016_10/24/1477271246_0_4271.png&#34; class=&#34;thumb_img&#34; alt=&#34;梦行历程轴&#34; /><span class=&#34;title&#34;>梦行历程轴</span> 
			<div>
			</div>
</a> 
		</div>
	</div>
</div>','0',''),
('117','15','5','演示站','http://crm.monxin.com/','1','http://crm.monxin.com/'),
('118','15','6','使用案例','./index.php?monxin=image.show_thumb&type=89&detail_show_method=','0','./index.php?monxin=image.show_thumb&type=89&detail_show_method='),
('119','15','7','立即购买','./index.php?monxin=mall.goods&id=13','1','./index.php?monxin=mall.goods&id=13'),
('120','0','0','','./index.php?monxin=mall.shop_goods_list&shop_id=62&type=19','1',''),
('121','6','5','周边硬件','./index.php?monxin=mall.shop_goods_list&shop_id=62&type=19','1','./index.php?monxin=mall.shop_goods_list&shop_id=62&type=19');m;o;n;
monxin_sql_end