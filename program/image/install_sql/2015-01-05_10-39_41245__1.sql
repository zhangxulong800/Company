monxin_sql_startDROP TABLE IF EXISTS `monxin_image_img`;m;o;n;
CREATE TABLE `monxin_image_img` (
  `id` int(5) NOT NULL auto_increment,
  `title` varchar(100) default NULL,
  `content` text,
  `src` varchar(60) default NULL,
  `type` int(3) NOT NULL,
  `sequence` int(5) NOT NULL default '0',
  `visible` int(1) NOT NULL default '1',
  `editor` varchar(30) NOT NULL,
  `time` bigint(12) NOT NULL default '0',
  `visit` int(11) NOT NULL default '0',
  `link` varchar(300) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=253 DEFAULT CHARSET=utf8;m;o;n;
INSERT INTO `monxin_image_img` (`id`,`title`,`content`,`src`,`type`,`sequence`,`visible`,`editor`,`time`,`visit`,`link`) VALUES
('215','怀化市置顶网络','','2014_02/27/1393471778_0_4628.png','54','0','1','4','1395219474','7','http://to-top.com/'),
('216','全有商城','','2014_02/27/1393472632_0_9574.png','63','0','1','4','1395219469','7','http://www.quanyousc.com/'),
('217','搜怀网','','2014_02/27/1393472702_0_5798.png','55','0','1','4','1393472722','16','http://souhuai.net/'),
('213','梦行','','2014_02/27/1393471714_0_1598.png','54','0','1','4','1393471731','7','http://www.monxin.com/'),
('214','怀化瑞鑫投资','','2014_02/27/1393471742_0_1784.png','54','0','1','4','1395219480','11','http://www.hhrxim.com/'),
('212','恒德教育','','2014_02/27/1393471651_0_3089.png','61','0','1','4','1395219485','5','http://www.hnhdjy.cn/'),
('238','目录','','2014_11/26/1416990117_0_2613.jpg','63','0','1','4','1417268608','29',''),
('239','','','2014_12/05/1417749915_0_7685.jpg','66','0','1','4','1417749915','60',''),
('240','','','2014_12/05/1417749915_1_5762.jpg','66','0','1','4','1417749915','23',''),
('241','','','2014_12/05/1417749915_2_3087.jpg','66','0','1','4','1417749915','18',''),
('242','','','2014_12/05/1417749915_3_2196.jpg','66','0','1','4','1417795334','21',''),
('243','','','2014_12/05/1417749915_4_7222.jpg','66','0','1','4','1417795334','20',''),
('244','','','2014_12/05/1417749915_5_7660.jpg','66','0','1','4','1417795334','29',''),
('245','','','2014_12/05/1417749915_6_7960.jpg','66','0','1','4','1417795334','32',''),
('246','','','2014_12/05/1417749915_7_5104.jpg','66','0','1','4','1417795334','14',''),
('247','','','2014_12/05/1417749915_8_9765.jpg','66','0','1','4','1417795334','38',''),
('248','古典与流行的激情碰撞——节奏小...','','2014_12/05/1417749915_9_4196.jpg','66','0','1','4','1417795334','14',''),
('249','333','333','2014_12/05/1417749915_10_4448.jpg','66','0','1','4','1417879394','18',''),
('250','2222','towtwo','2014_12/05/1417749915_11_3072.jpg','66','0','1','4','1417871743','51',''),
('251','111','<span style=&#34;color:#383838;font-family:&#39;Microsoft YaHei&#39;;font-size:medium;line-height:normal;white-space:normal;background-color:#F5F7FA;&#34;>图片描述<span style=&#34;color:#383838;font-family:&#39;Microsoft YaHei&#39;;font-size:medium;line-height:normal;white-space:normal;background-color:#F5F7FA;&#34;>图片描述<span style=&#34;color:#383838;font-family:&#39;Microsoft YaHei&#39;;font-size:medium;line-height:normal;white-space:normal;background-color:#F5F7FA;&#34;>图片描述<span style=&#34;color:#383838;font-family:&#39;Microsoft YaHei&#39;;font-size:medium;line-height:normal;white-space:normal;background-color:#F5F7FA;&#34;>图片描述<span style=&#34;color:#383838;font-family:&#39;Microsoft YaHei&#39;;font-size:medium;line-height:normal;white-space:normal;background-color:#F5F7FA;&#34;>图片描述<span style=&#34;color:#383838;font-family:&#39;Microsoft YaHei&#39;;font-size:medium;line-height:normal;white-space:normal;background-color:#F5F7FA;&#34;>图片描述<span style=&#34;color:#383838;font-family:&#39;Microsoft YaHei&#39;;font-size:medium;line-height:normal;white-space:normal;background-color:#F5F7FA;&#34;>图片描述<span style=&#34;color:#383838;font-family:&#39;Microsoft YaHei&#39;;font-size:medium;line-height:normal;white-space:normal;background-color:#F5F7FA;&#34;>图片描述<span style=&#34;color:#383838;font-family:&#39;Microsoft YaHei&#39;;font-size:medium;line-height:normal;white-space:normal;background-color:#F5F7FA;&#34;>图片描述</span></span></span></span></span></span></span></span></span>','2014_12/05/1417749915_12_4908.jpg','61','0','1','4','1417966354','82',''),
('252','','a a a a a &nbsp;','2014_12/07/1417965874_0_1435.png','54','0','1','4','1418953071','10','');m;o;n;
DROP TABLE IF EXISTS `monxin_image_img_type`;m;o;n;
CREATE TABLE `monxin_image_img_type` (
  `id` int(3) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `parent` int(3) NOT NULL default '0',
  `sequence` int(3) NOT NULL default '0',
  `visible` int(1) NOT NULL default '1',
  `remark` text NOT NULL COMMENT '分类备注',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;m;o;n;
INSERT INTO `monxin_image_img_type` (`id`,`name`,`parent`,`sequence`,`visible`,`remark`) VALUES
('35','服务案例','0','0','1',''),
('54','企业站','35','0','1','<div>
	&nbsp;美观时尚，装点家居，创意礼品。<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;树脂流水工艺的特点：不仅是节能环保型的家居装饰品，也是一系列更加健康、更加精美的室内加湿器！人们生活水平的提高,都市生活的人们渴望把自然融入到家居环境中,因此自然风格的盆景是现代家居装饰独一玩二的选择。树脂工艺品设计精良，品质卓越，将现代与古典，都市与自然完美结合；寿命长，四十年不会风化，变色。&nbsp;
</div>
<br />'),
('55','门户站','35','0','1',''),
('60','商城站','35','0','1',''),
('61','教育行业','54','0','1',''),
('62','旅游行业','54','0','1',''),
('63','B2C','60','0','1',''),
('64','B2B','60','0','1',''),
('66','test','0','0','1','');m;o;n;
monxin_sql_end