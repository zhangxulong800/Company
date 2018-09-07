monxin_sql_startDROP TABLE IF EXISTS `monxin_credit_prize`;m;o;n;
CREATE TABLE `monxin_credit_prize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL COMMENT '奖品名称',
  `icon` varchar(60) DEFAULT NULL COMMENT '奖品图片',
  `url` varchar(100) DEFAULT NULL COMMENT '奖品详情链接',
  `money` int(7) NOT NULL DEFAULT '0' COMMENT '奖品所需积分',
  `sequence` int(3) NOT NULL DEFAULT '0' COMMENT '奖品排序',
  `use` int(6) NOT NULL DEFAULT '0' COMMENT '兑奖次数',
  `state` int(1) NOT NULL DEFAULT '1' COMMENT '奖品状态 0下线 1上线',
  `quantity` int(11) NOT NULL DEFAULT '0' COMMENT '剩余数量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='积分奖品表';m;o;n;
INSERT INTO `monxin_credit_prize` (`id`,`name`,`icon`,`url`,`money`,`sequence`,`use`,`state`,`quantity`) VALUES
('2','大白公仔毛绒玩具大号抱','','https://item.taobao.com/item.htm?id=520492641037','9000','0','0','1','100'),
('3','星战迷新宠BB-8机器人','','https://item.taobao.com/item.htm?spm=a230r.1.14.33.ENzohc&id=526543947217&ns=1&abbucket=15#detail','98000','9','0','1','100'),
('4','羊驼公仔草泥马','','https://item.taobao.com/item.htm?spm=2013.1.0.0.dI4YyG&id=39986373906','999','0','0','1','100'),
('5','发财树植物盆栽花卉','','','100','0','3','1','96'),
('6','444','','33','3','0','0','0','66'),
('7','BrainLink专业版 意念力头箍','','https://detail.tmall.com/item.htm?id=39069603557','333333','0','0','1','1'),
('8','正品99%牛角芦荟胶','','https://detail.tmall.com/item.htm?id=42044560773&skuId=74478423113','5000','0','0','1','66'),
('9','迪卡侬 儿童装长袖T恤','','https://detail.tmall.com/item.htm?id=521539920516','3000','0','0','1','28'),
('10','南京出发 大理丽江 跟团游','','https://items.alitrip.com/item.htm?id=542333413460','888888','0','0','1','16');m;o;n;
DROP TABLE IF EXISTS `monxin_credit_prize_log`;m;o;n;
CREATE TABLE `monxin_credit_prize_log` (
  `p_id` int(11) NOT NULL COMMENT '奖品ID',
  `p_name` varchar(100) DEFAULT NULL COMMENT '奖品名称',
  `username` varchar(30) DEFAULT NULL COMMENT '兑奖人',
  `money` int(8) NOT NULL DEFAULT '0' COMMENT '兑奖积分',
  `time` bigint(12) NOT NULL DEFAULT '0' COMMENT '兑奖时间',
  `state` int(1) NOT NULL DEFAULT '0' COMMENT '状态 0待发货 1已发货',
  `r_info` varchar(200) DEFAULT NULL COMMENT '收货信息',
  `s_info` varchar(500) DEFAULT NULL COMMENT '发货信息',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='积分兑奖记录';m;o;n;
INSERT INTO `monxin_credit_prize_log` (`p_id`,`p_name`,`username`,`money`,`time`,`state`,`r_info`,`s_info`,`id`) VALUES
('5','发财树植物盆栽花卉','monxin.com','100','1487517263','1','湖南省.怀化市.鹤城区 城东  金都景苑E栋3单元1809E 马先生 18099887733','<a target=_blank href=https://www.baidu.com/s?ie=utf-8&f=8&rsv_bp=0&rsv_idx=1&tn=baidu&wd=%E7%94%B3%E9%80%9A%E5%BF%AB%E9%80%92%203323444327873&rsv_pq=f0d50bfe002d447a&rsv_t=dc130rFo%2Bp32n4Vn0bIp6Y2R85GppB6NnQ1EWmXPnHWdDYEwBPiUf4%2BRBiI&rqlang=cn&rsv_enter=1&rsv_sug3=2&rsv_n=2 >申通快递 3323444327873</a>','1'),
('5','发财树植物盆栽花卉','monxin.com','100','1487559643','0','','','3');m;o;n;
monxin_sql_end