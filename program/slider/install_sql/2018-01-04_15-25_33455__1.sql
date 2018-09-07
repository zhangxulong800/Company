monxin_sql_startDROP TABLE IF EXISTS `monxin_slider_group`;m;o;n;
CREATE TABLE `monxin_slider_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL COMMENT '名称',
  `style` varchar(100) NOT NULL COMMENT '动画风格',
  `width` varchar(30) DEFAULT NULL COMMENT '宽度',
  `height` varchar(30) DEFAULT NULL COMMENT '高度',
  `editor` varchar(30) DEFAULT NULL COMMENT '最后编辑人',
  `time` bigint(12) NOT NULL DEFAULT '0' COMMENT '最后编辑时间',
  `duration` int(11) NOT NULL DEFAULT '20' COMMENT '切换速度',
  `delay` int(11) NOT NULL DEFAULT '20' COMMENT '暂停时间',
  `visit` int(11) NOT NULL DEFAULT '0' COMMENT '展示量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='幻灯片 组';m;o;n;
INSERT INTO `monxin_slider_group` (`id`,`title`,`style`,`width`,`height`,`editor`,`time`,`duration`,`delay`,`visit`) VALUES
('15','商城头部 电脑版','width_full','100%','27%','4','1480664973','30','30','8691'),
('16','分类信息 广告位','swipe','972px','32.14rem','4','1480668420','20','20','373'),
('27','商城头部 手机版','width_full','100%','220px','4','1480668209','20','20','2167'),
('28','分类信息  手机版','width_full','100%','220px','4','1480667858','20','20','168'),
('29','企业型   PC版 首页','width_full','100%','32.14rem','4','1480665604','20','20','2'),
('30','企业型    手机版 首页','width_full','100%','220px','4','1480667632','20','20','4'),
('31','旅游站 电脑版','width_full','100%','27%','4','1481683041','30','30','13'),
('32','旅游站  手机版','width_full','100%','220px','4','1481682712','20','20','5');m;o;n;
DROP TABLE IF EXISTS `monxin_slider_img`;m;o;n;
CREATE TABLE `monxin_slider_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` varchar(11) DEFAULT NULL COMMENT '所属组ID',
  `name` text COMMENT '名称',
  `url` varchar(300) DEFAULT NULL COMMENT '链接',
  `target` varchar(10) DEFAULT '_self' COMMENT '链接打开方式',
  `sequence` int(3) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=168 DEFAULT CHARSET=utf8 COMMENT='幻灯片图片';m;o;n;
INSERT INTO `monxin_slider_img` (`id`,`group_id`,`name`,`url`,`target`,`sequence`) VALUES
('99','28','#','http://www.monxin.com/index.php?monxin=best.show&id=12','_blank','0'),
('98','28','#','http://www.monxin.com/index.php?monxin=best.show&id=8','_blank','0'),
('97','28','#','http://www.monxin.com/index.php?monxin=best.show&id=6','_blank','0'),
('56','14','2','#','_self','0'),
('57','14','1','#','_self','0'),
('58','14','3','#','_self','0'),
('85','16',' #',' http://www.monxin.com/index.php?monxin=best.show&id=12','_blank','0'),
('84','16',' #',' http://www.monxin.com/index.php?monxin=best.show&id=8','_blank','0'),
('72','19','3','234','_self','0'),
('83','16',' #',' http://www.monxin.com/index.php?monxin=best.show&id=6','_blank','0'),
('100','15','#','http://www.monxin.com/index.php?monxin=best.show&id=8','_blank','888'),
('102','27','#','http://www.monxin.com/index.php?monxin=best.show&id=6','_blank','99'),
('155','27','#','http://www.monxin.com/index.php?monxin=best.show&id=13','_blank','96'),
('156','27','#','http://www.monxin.com/index.php?monxin=best.show&id=11','_blank','95'),
('149','15','#','http://www.monxin.com/index.php?monxin=best.show&id=6','_blank','999'),
('150','15','#','http://www.monxin.com/index.php?monxin=best.show&id=13','_blank','998'),
('151','15','#','http://www.monxin.com/index.php?monxin=best.show&id=12','_blank','997'),
('152','15','#','http://www.monxin.com/index.php?monxin=best.show&id=11','_blank','996'),
('153','27','#','http://www.monxin.com/index.php?monxin=best.show&id=8','_blank','98'),
('154','27','#','http://www.monxin.com/index.php?monxin=best.show&id=12','_blank','97'),
('140','32','#','#','_blank','0'),
('141','32','#','#','_blank','0'),
('142','32','#','#','_blank','0'),
('143','32','#','#','_blank','0'),
('144','32','#','#','_blank','0'),
('131','31','#','#','_blank','0'),
('132','31','#','#','_blank','0'),
('133','31','#','#','_blank','0'),
('134','31','#','#','_blank','0'),
('135','31','#','#','_blank','0'),
('119','29','#','http://www.monxin.com/index.php?monxin=best.show&id=6','_blank','0'),
('120','29','#','http://www.monxin.com/index.php?monxin=best.show&id=8','_blank','0'),
('121','29','#','http://www.monxin.com/index.php?monxin=best.show&id=12','_blank','0'),
('122','29','#','http://www.monxin.com/index.php?monxin=best.show&id=13','_blank','0'),
('167','31','#','#','_self','0'),
('123','29','#','http://www.monxin.com/index.php?monxin=best.show&id=11','_blank','0'),
('161','32','#','#','_self','0'),
('162','32','#','#','_self','0'),
('163','32','#','#','_self','0'),
('124','30','#','http://www.monxin.com/index.php?monxin=best.show&id=6','_blank','0'),
('125','30','#','http://www.monxin.com/index.php?monxin=best.show&id=8','_blank','0'),
('126','30','#','http://www.monxin.com/index.php?monxin=best.show&id=12','_blank','0'),
('127','30','#','http://www.monxin.com/index.php?monxin=best.show&id=13','_blank','0'),
('158','28','#','http://www.monxin.com/index.php?monxin=best.show&id=11','_self','0'),
('128','30','#','http://www.monxin.com/index.php?monxin=best.show&id=11','_self','0'),
('157','28','#','http://www.monxin.com/index.php?monxin=best.show&id=13','_self','0'),
('166','31','#','#','_self','0'),
('165','31','#','#','_self','0'),
('164','31','#','#','_self','0'),
('159','16','#','http://www.monxin.com/index.php?monxin=best.show&id=13','_self','0');m;o;n;
INSERT INTO `monxin_slider_img` (`id`,`group_id`,`name`,`url`,`target`,`sequence`) VALUES
('160','16','#','http://www.monxin.com/index.php?monxin=best.show&id=11','_self','0');m;o;n;
monxin_sql_end