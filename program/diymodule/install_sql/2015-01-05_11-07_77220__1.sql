monxin_sql_startDROP TABLE IF EXISTS `monxin_diymodule_module`;m;o;n;
CREATE TABLE `monxin_diymodule_module` (
  `id` int(5) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `title_visible` int(1) NOT NULL default '0',
  `content` text,
  `width` varchar(6) default NULL,
  `sequence` int(5) NOT NULL default '0',
  `height` varchar(6) default NULL,
  `editor` varchar(30) NOT NULL,
  `time` bigint(12) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=utf8;m;o;n;
INSERT INTO `monxin_diymodule_module` (`id`,`title`,`title_visible`,`content`,`width`,`sequence`,`height`,`editor`,`time`) VALUES
('90','联系我们','1','<script>
$(document).ready(function(){
	$(&#34;.diy_contcat .left_wx_icon&#34;).hover(function(){
		$(&#34;.diy_contcat .left_wx_q&#34;).css(&#39;display&#39;,&#39;block&#39;).css(&#39;top&#39;,$(this).offset().top-($(&#34;.diy_contcat .left_wx_q&#34;).height()/2)+28).css(&#39;left&#39;,$(this).offset().left+210);
	},function(){
		$(&#34;.diy_contcat .left_wx_q&#34;).css(&#39;display&#39;,&#39;none&#39;);		
	});
});
</script>
<style>
#diymodule_show_90_90_html .content {
padding: 5px;
}
.diy_contcat{}
.diy_contcat a{ display:block; padding-top:5px;}
.diy_contcat a:hover{ opacity:0.7;alpha(opacity=70);}
.diy_contcat a img{ border:none;}
.diy_contcat .left_wx_q{display:none; position:absolute; z-index:999;height:250px;}
</style>
<div class=&#34;diy_contcat&#34;>
	<a><img src=&#34;program/diymodule/attachd/image/20140801/20140801101856_59647.png&#34; alt=&#34;&#34; /></a> <a><img src=&#34;program/diymodule/attachd/image/20140801/20140801101955_61078.png&#34; alt=&#34;&#34; /></a> <a href=&#34;http://sighttp.qq.com/msgrd?v=1&uin=925434309&#34; target=&#34;_blank&#34;><img src=&#34;program/diymodule/attachd/image/20140801/20140801102050_26158.png&#34; alt=&#34;&#34; /></a> <a class=&#34;left_wx_icon&#34;><img src=&#34;program/diymodule/attachd/image/20140801/20140801102139_90925.png&#34; alt=&#34;&#34; /></a> <a href=&#34;index.php?monxin=diypage.show&id=83#map&#34;><img src=&#34;program/diymodule/attachd/image/20140801/20140801102232_80647.png&#34; alt=&#34;&#34; /></a> <img src=&#34;program/diymodule/attachd/image/20140801/20140801102321_35430.png&#34; class=&#34;left_wx_q&#34; alt=&#34;&#34; /> 
</div>','314px','0','auto','4','1406888913'),
('113','存图片模块 勿删','0','<img src=&#34;program/diymodule/attachd/image/20140804/20140804025710_44129.jpg&#34; alt=&#34;&#34; />','111px','0','111px','4','1407121041'),
('110','头部logo区','0','<script>
$(document).ready(function(){
	//alert($(window).width());
	if($(window).width()>1366){
		$(&#34;#diymodule_show_110&#34;).css(&#39;margin-left&#39;,($(window).width()-1366)/2);	
	}        
});
</script>
<style>
#diymodule_show_110{marign:0px;padding:0px;}
#diymodule_show_110_110_html{marign:0px;padding:0px;border:none; background:none;}
#diymodule_show_110 .module_title{display:none;}
#diymodule_show_110 .content{marign:0px;padding:0px;; }
#diymodule_show_110 img{padding-top:20px;padding-left:0px; height:100px;border:none;}
</style>
<img src=&#34;program/diymodule/attachd/image/20140920/20140920035413_37125.png&#34; alt=&#34;&#34; />','400px','0','100px','4','1412425759'),
('111','头部联系方式','0','<style>
#diymodule_show_111 .module_div_bottom_margin{border:0px; margin:0px;}
#diymodule_show_111 .content{padding:0px;}
</style>
<img src=&#34;program/diymodule/attachd/image/20140404/20140404091020_56194.png&#34; alt=&#34;&#34; />','340px','0','100px','4','1396603436'),
('112','商城diy','0','<style>
#diymodule_show_112{padding:0px;margin:0px;}
#diymodule_show_112_112_html .content{padding:0px;margin:0px; border-left:1px solid #e7e7e7;}
#diymodule_show_112_112_html{ width:100%;}
</style>
<script>
if($){
$(&#34;#diymodule_show_112&#34;).css(&#39;padding&#39;,0).css(&#39;padding-left&#39;,&#39;0&#39;).css(&#39;padding-right&#39;,&#39;0&#39;).css(&#39;width&#39;,&#39;99%&#39;).css(&#39;height&#39;,&#39;50px&#39;);
$(&#34;#diymodule_show_112&#34;).next().css(&#39;margin-top&#39;,-25);
}
</script>
<img src=&#34;program/diymodule/attachd/image/20140703/20140703141102_18673.png&#34; alt=&#34;&#34; />','1339px','0','50px','4','1404396669'),
('114','旅游广告A','0','<style>
#diymodule_show_114{margin-bottom:20px;}
#diymodule_show_114_114_html .module_title{display:none;}
#diymodule_show_114_114_html .content{padding:0px;overflow:hidden;}
</style>
<img src=&#34;program/diymodule/attachd/image/20140930/20140930082753_66417.jpg&#34; alt=&#34;&#34; />','100%','0','124px','4','1412066589'),
('115','旅游广告B','0','<style>
#diymodule_show_115{margin-bottom:20px;}
#diymodule_show_115_115_html .module_title{display:none;}
#diymodule_show_115_115_html .content{padding:0px;overflow:hidden;}
</style>
<img src=&#34;program/diymodule/attachd/image/20140930/20140930082853_95045.jpg&#34; alt=&#34;&#34; />','100%','0','123px','4','1412067038'),
('116','旅游广告C','0','<style>
#diymodule_show_116{margin-bottom:20px;}
#diymodule_show_116_116_html .module_title{display:none;}
#diymodule_show_116_116_html .content{padding:0px;overflow:hidden;}
</style>
<img src=&#34;program/diymodule/attachd/image/20140930/20140930083026_53731.jpg&#34; alt=&#34;&#34; />','100%','0','123px','4','1412066631'),
('117','旅游广告d','0','<style>
#diymodule_show_117{margin-bottom:20px;}
#diymodule_show_117_117_html .module_title{display:none;}
#diymodule_show_117_117_html .content{padding:0px;overflow:hidden;}
</style>
<img src=&#34;program/diymodule/attachd/image/20140930/20140930083128_15704.jpg&#34; alt=&#34;&#34; />','100%','0','124px','4','1412067062'),
('118','搜索框右侧模块','0','<style>
#diymodule_show_118{marign:0px;padding:0px;}
#diymodule_show_118_118_html{marign:0px;padding:0px;border:none; background:none;}
#diymodule_show_118 .module_title{display:none;}
#diymodule_show_118 .content{marign:0px;padding:0px;; }
#diymodule_show_118 img{padding-left:0px; height:130px;border:none;}
</style>
<img src=&#34;program/diymodule/attachd/image/20141004/20141004132556_92911.png&#34; alt=&#34;&#34; />','410px','0','130px','4','1412429160'),
('119','搜索框右侧模块(分类信息专用)','0','<style>
#diymodule_show_119{marign:0px;padding:0px;}
#diymodule_show_119_119_html{marign:0px;padding:0px;border:none; background:none;}
#diymodule_show_119 .module_title{display:none;}
#diymodule_show_119 .content{marign:0px;padding:0px;; }
#diymodule_show_119 img{padding-left:50px; padding-top:42px; border:none;}
</style>
<a href=&#34;index.php?monxin=ci.add_option_type&#34;><img alt=&#34;&#34; src=&#34;program/diymodule/attachd/image/20141120/20141120093050_82460.png&#34; /></a>','350px','0','140px','4','1416537808');m;o;n;
monxin_sql_end