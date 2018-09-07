monxin_sql_startDROP TABLE IF EXISTS `monxin_menu_menu`;m;o;n;
CREATE TABLE `monxin_menu_menu` (
  `id` int(3) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL,
  `url` varchar(300) NOT NULL,
  `sequence` int(3) NOT NULL default '0',
  `parent_id` int(3) NOT NULL default '0',
  `open_target` varchar(10) NOT NULL,
  `visible` int(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;m;o;n;
INSERT INTO `monxin_menu_menu` (`id`,`name`,`url`,`sequence`,`parent_id`,`open_target`,`visible`) VALUES
('1','服务案例','./index.php?monxin=image.show_thumb&type=35','995','5','_self','1'),
('2','产品展示','./index.php?monxin=image.show_thumb','997','5','_blank','1'),
('4','新闻资讯','./index.php?monxin=article.show_article_list&type=73','993','5','_self','1'),
('5','手机版主页菜单','#','0','0','_self','1'),
('6','联系我们','./index.php?monxin=diypage.show&id=83','987','5','_self','1'),
('7','关于我们','./index.php?monxin=diypage.show&id=80','999','5','_self','1'),
('8','留言反馈','./index.php?monxin=feedback.list','985','5','_self','1'),
('9','人才招聘','#','989','5','_self','1'),
('21','居家','#','0','16','_self','1'),
('10','招商加盟','./index.php?monxin=diypage.show&id=121','991','5','_self','1'),
('19','新品','#','0','16','_self','1'),
('20','鞋包','#','0','16','_self','1'),
('17','女装','#','0','16','_self','1'),
('18','男装','#','0','16','_self','1'),
('15','gh','ghj','0','5','_self','1'),
('16','商城按钮','#','0','0','_self','1'),
('14','More...','./index.php?monxin=image.show_thumb&type=69','0','5','_self','1'),
('22','数码','#','0','16','_self','1'),
('23','配饰','#','0','16','_self','1'),
('24','一折起','#','0','16','_self','1'),
('25','购物车','#','0','16','_self','1'),
('26','我的全有','#','0','16','_self','1');m;o;n;
monxin_sql_end