monxin_sql_startDROP TABLE IF EXISTS `monxin_bargain_detail`;m;o;n;
CREATE TABLE `monxin_bargain_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `l_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户砍价商品ID',
  `b_id` int(11) NOT NULL DEFAULT '0' COMMENT '规则ID',
  `g_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城商品ID',
  `username` varchar(30) NOT NULL COMMENT '砍价人',
  `time` bigint(12) NOT NULL DEFAULT '0' COMMENT '砍价时间',
  `money` decimal(12,2) NOT NULL COMMENT '砍下金额',
  `ip` varchar(32) NOT NULL COMMENT '用户IP',
  `l_username` varchar(30) DEFAULT NULL COMMENT '砍价发起人用户名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='砍价详情';m;o;n;
INSERT INTO `monxin_bargain_detail` (`id`,`l_id`,`b_id`,`g_id`,`username`,`time`,`money`,`ip`,`l_username`) VALUES
('15','11','9','43','monxin.com','1529549359','12.00','::1','monxin.com'),
('14','10','8','42','monxin.com','1529547847','3.00','192.168.31.138','monxin.com'),
('13','9','5','318','monxin.com','1529542580','45.00','::1','monxin.com'),
('12','8','7','45','monxin.com','1529542572','45.00','::1','monxin.com'),
('11','7','5','318','monxin.com','1529464772','45.00','192.168.31.138','monxin.com');m;o;n;
DROP TABLE IF EXISTS `monxin_bargain_goods`;m;o;n;
CREATE TABLE `monxin_bargain_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `g_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `time` bigint(12) NOT NULL DEFAULT '0' COMMENT '最后时间',
  `final_price` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '底价',
  `min_money` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '最小砍价金额',
  `max_money` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '最大砍价金额',
  `type` int(1) NOT NULL DEFAULT '0' COMMENT '购买限定 0非底价可购，1到底价才可购',
  `hour` int(3) NOT NULL DEFAULT '24' COMMENT '砍价时限(小时)',
  `view` int(11) NOT NULL DEFAULT '0' COMMENT '点击量',
  `sum_sold` int(11) NOT NULL DEFAULT '0' COMMENT '累计成交量',
  `sum_money` decimal(22,2) NOT NULL DEFAULT '0.00' COMMENT '累计成交额',
  `invitation` varchar(200) NOT NULL COMMENT '砍价邀请语',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品所属店铺ID',
  `username` varchar(30) NOT NULL COMMENT '所属店主',
  `state` int(1) NOT NULL DEFAULT '0' COMMENT '审核状态 0待审核 1审核通过 2审核 失败',
  `g_title` varchar(100) NOT NULL COMMENT '商品标题',
  `start_time` bigint(12) NOT NULL DEFAULT '0' COMMENT '上线时间',
  `end_time` bigint(12) NOT NULL DEFAULT '0' COMMENT '下线时间',
  `new` int(1) NOT NULL DEFAULT '1' COMMENT '帮砍价限定 1仅新用户可帮砍 2 新老用户都可帮砍',
  `method` int(1) NOT NULL DEFAULT '1' COMMENT '砍价模式 1前高后低，2随机，3前低后高',
  `quantity` int(5) NOT NULL DEFAULT '1' COMMENT '预计砍价次数',
  `sequence` int(3) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='商品砍价规则表';m;o;n;
INSERT INTO `monxin_bargain_goods` (`id`,`g_id`,`time`,`final_price`,`min_money`,`max_money`,`type`,`hour`,`view`,`sum_sold`,`sum_money`,`invitation`,`shop_id`,`username`,`state`,`g_title`,`start_time`,`end_time`,`new`,`method`,`quantity`,`sequence`) VALUES
('4','320','1529121470','12.00','1.00','3.00','1','1','0','0','0.00','我发现了一好货，快来帮我砍价','62','平台自营店','1','体恤打底衫_跨境短袖t恤2018夏季新款圆领青年潮牌半袖宽松体恤动画','1529164800','1530374399','2','3','18','0'),
('5','318','1529387578','240.00','5.00','45.00','0','24','24','3','1863.00','我发现了一好货，快来帮我砍价','62','平台自营店','1','ALLOY+/越甲智能旅行箱指纹解锁男女20寸登机箱24行李拉杆箱时尚','1528646400','1530287999','2','1','17','0'),
('6','317','1529304158','55.00','3.00','5.00','0','24','0','0','0.00','我发现了一好货，快来帮我砍价','62','平台自营店','1','法国大使（Delsey）经典马卡龙拉杆箱20英寸ABS登机旅行箱可扩容行李箱男女万向轮湖水绿882','1529078400','1529769599','1','1','153','0'),
('7','45','1529304447','600.00','3.00','45.00','0','24','4','0','0.00','我发现了一好货，快来帮我砍价','62','平台自营店','1','Samsung/三星 GALAXY Tab S2 SM-T710 WLAN 32GB 8.0英寸平板电脑','1529251200','1530374399','1','1','97','0'),
('8','42','1529508320','5.00','1.00','3.00','0','24','2','0','0.00','我发现了一好货，快来帮我砍价','62','平台自营店','1','Dell/戴尔 5000系列 M5455-1208 四核超薄家用办公手提笔记本电脑','1529164800','1530287999','1','1','3','5'),
('9','43','1529508359','0.00','1.00','12.00','0','24','5','0','0.00','我发现了一好货，快来帮我砍价','62','平台自营店','1','酷比魔方 i6 Air 双系统版 WIFI 32GB 9.7英寸win8 win10平板电脑','1529078400','1530287999','1','1','155','4');m;o;n;
DROP TABLE IF EXISTS `monxin_bargain_log`;m;o;n;
CREATE TABLE `monxin_bargain_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `b_id` int(11) NOT NULL DEFAULT '0' COMMENT '规则ID',
  `g_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城商品ID',
  `username` varchar(30) NOT NULL COMMENT '发起砍价人',
  `money` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '已砍金额',
  `quantity` int(5) NOT NULL DEFAULT '0' COMMENT '已砍次数',
  `start` bigint(12) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `state` int(1) NOT NULL DEFAULT '1' COMMENT '砍价状态 1砍价中 2砍价超时结束  3砍价完成 待购 4已购',
  `wx_qr` varchar(200) DEFAULT NULL COMMENT '微信自定义二维码',
  `order_money` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '成交价',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='用户砍价活动表';m;o;n;
INSERT INTO `monxin_bargain_log` (`id`,`b_id`,`g_id`,`username`,`money`,`quantity`,`start`,`state`,`wx_qr`,`order_money`,`order_id`) VALUES
('1','5','318','monxin.com','45.00','1','1529378877','2','http://weixin.qq.com/q/02fuBpVClh8HU10000007S','0.00','0'),
('2','5','318','monxin.com','197.00','5','1529379139','2','http://weixin.qq.com/q/02_TlTVolh8HU10000g07X','0.00','0'),
('3','5','318','平台自营店','45.00','1','1529387491','2','http://weixin.qq.com/q/02WLY0Vblh8HU10000M078','0.00','0'),
('7','5','318','monxin.com','45.00','1','1529464771','4','http://weixin.qq.com/q/02-9_aV5lh8HU10000w07w','621.00','67'),
('8','7','45','monxin.com','45.00','1','1529542571','1','','0.00','0'),
('9','5','318','monxin.com','45.00','1','1529542579','1','','0.00','0'),
('10','8','42','monxin.com','3.00','1','1529547846','1','','0.00','0'),
('11','9','43','monxin.com','12.00','1','1529549359','1','','0.00','0');m;o;n;
monxin_sql_end