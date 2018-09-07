monxin_sql_startDROP TABLE IF EXISTS `monxin_feedback_msg`;m;o;n;

CREATE TABLE `monxin_feedback_msg` (
  `id` int(11) NOT NULL auto_increment,
  `content` text NOT NULL,
  `sender` varchar(100) NOT NULL,
  `receive` varchar(100) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `time` bigint(12) NOT NULL default '0',
  `state` int(1) NOT NULL default '0',
  `answer` text NOT NULL,
  `answer_user` int(11) NOT NULL default '0',
  `answer_time` bigint(12) NOT NULL default '0',
  `sequence` int(5) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;m;o;n;

INSERT INTO `monxin_feedback_msg` (`id`,`content`,`sender`,`receive`,`ip`,`time`,`state`,`answer`,`answer_user`,`answer_time`,`sequence`) VALUES
('33','能提供学习梦行的教材吗？','不死','','127.0.0.1','1393469842','1','目前没有，但我们计划近期制作梦行视频教程，敬请关注我们。','4','1393470134','0'),
('34','梦行全开源吗？','mysite','','127.0.0.1','1393469902','1','为了更方便用户二次开发，梦行是全开源的。','4','1393470133','0'),
('35','您好您好','张三','~~~','192.168.0.105','1418716919','0','','0','0','0');m;o;n;

monxin_sql_end