monxin_sql_startDROP TABLE IF EXISTS `monxin_weixin_account`;m;o;n;
CREATE TABLE `monxin_weixin_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qr_code` varchar(100) DEFAULT NULL COMMENT '二维码',
  `username` varchar(30) NOT NULL COMMENT '所属用户',
  `name` varchar(100) DEFAULT NULL COMMENT '名称',
  `wid` varchar(100) DEFAULT NULL COMMENT '微信号原始ID',
  `account` varchar(100) DEFAULT NULL COMMENT '微信号',
  `area` varchar(100) DEFAULT NULL COMMENT '所在地区ID',
  `if_email` varchar(50) DEFAULT NULL COMMENT '新消息通知邮箱',
  `if_weixin` varchar(100) DEFAULT NULL COMMENT '新消息通知微信',
  `keyword` varchar(255) DEFAULT NULL COMMENT '业务关键词',
  `AppId` varchar(100) DEFAULT NULL COMMENT '应用ID',
  `AppSecret` varchar(100) DEFAULT NULL COMMENT '应用密钥',
  `token` varchar(100) DEFAULT NULL COMMENT 'token',
  `time` bigint(12) NOT NULL DEFAULT '0' COMMENT '最后编辑时间',
  `state` int(1) NOT NULL DEFAULT '1' COMMENT '状态 参考本语言数组account_state',
  `smtp_url` varchar(100) DEFAULT NULL COMMENT '发邮件网址',
  `smtp_account` varchar(50) DEFAULT NULL COMMENT '发邮件账号',
  `smtp_password` varchar(50) DEFAULT NULL COMMENT '发邮件密码',
  `sequence` int(5) NOT NULL DEFAULT '0' COMMENT '排序',
  `receive_if_email` int(1) NOT NULL DEFAULT '0' COMMENT '收到信息是否通知邮箱',
  `no_keyword_if_email` int(1) NOT NULL DEFAULT '0' COMMENT '无关键词回复是否通知邮箱',
  `no_search_if_email` int(1) NOT NULL DEFAULT '1' COMMENT '无搜索结果是否通知邮箱',
  `receive_if_weixin` int(1) NOT NULL DEFAULT '0' COMMENT '收到信息是否通知微信',
  `no_keyword_if_weixin` int(1) NOT NULL DEFAULT '0' COMMENT '无关键词回复是否通知微信',
  `no_search_if_weixin` int(1) NOT NULL DEFAULT '1' COMMENT '无搜索结果是否通知微信',
  `open_search` int(1) NOT NULL DEFAULT '1' COMMENT '是否开启搜索',
  `receptionist_power` int(1) NOT NULL DEFAULT '0' COMMENT '已开通多客服',
  `receptionist_open` int(1) NOT NULL DEFAULT '0' COMMENT '启用人工服务',
  `receptionist_where` int(1) NOT NULL DEFAULT '1' COMMENT '转人工客服条件,当',
  `weixin_token` text COMMENT '微信得到的token相关信息',
  `manager` varchar(100) DEFAULT NULL COMMENT '微信管理员',
  PRIMARY KEY (`id`),
  UNIQUE KEY `wid` (`wid`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COMMENT='梦行微信 公众号';m;o;n;
INSERT INTO `monxin_weixin_account` (`id`,`qr_code`,`username`,`name`,`wid`,`account`,`area`,`if_email`,`if_weixin`,`keyword`,`AppId`,`AppSecret`,`token`,`time`,`state`,`smtp_url`,`smtp_account`,`smtp_password`,`sequence`,`receive_if_email`,`no_keyword_if_email`,`no_search_if_email`,`receive_if_weixin`,`no_keyword_if_weixin`,`no_search_if_weixin`,`open_search`,`receptionist_power`,`receptionist_open`,`receptionist_where`,`weixin_token`,`manager`) VALUES
('51','2017_04/08/1491619657_0_7754.jpg','monxin.com','测试','gh_7eca8f5d4da0','test','0','','','','wxe92b5bb5e6dfc097','95dcf26a695d9cc7505f9b59328a8416','monxin','1491619687','1','','','','0','0','0','1','0','0','1','1','0','0','1','{&#34;AppId&#34;:&#34;wxe92b5bb5e6dfc097&#34;,&#34;token&#34;:&#34;Goam0-vQj_s_stv-fdaENlAHaaA89oVE7dBBP8RG70aZCWm0_tBPL9jCBHUJCcAYg-aLf3KZRAvUrZCsmqdq6J-1R-XZJDtWLIXikSrU4TyocuFVDRVeuBBz6FsHhWj1XBXaAJABFB&#34;,&#34;ticket&#34;:&#34;sM4AOVdWfPE4DxkXGEs8VEyqU1K6NP1TvYvVH6DRvraAPBTcp1F0Hc3jxo213r8S3Z1ojWzyQjqQNIbYOLDrMA&#34;,&#34;expires_in&#34;:1493347885}',',平台自营店,');m;o;n;
DROP TABLE IF EXISTS `monxin_weixin_authcode`;m;o;n;
CREATE TABLE `monxin_weixin_authcode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(32) DEFAULT NULL COMMENT '用户openid',
  `code` varchar(32) DEFAULT NULL COMMENT '验证码',
  `time` bigint(12) NOT NULL DEFAULT '0' COMMENT '时间',
  `wid` varchar(32) DEFAULT NULL COMMENT '微信号原始ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='梦行微信 微信验证码';m;o;n;
DROP TABLE IF EXISTS `monxin_weixin_auto_answer`;m;o;n;
CREATE TABLE `monxin_weixin_auto_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wid` varchar(100) DEFAULT NULL COMMENT '所属微信号原始ID',
  `key` varchar(100) DEFAULT NULL COMMENT '关键词',
  `input_type` varchar(20) DEFAULT NULL COMMENT '输入类型',
  `output_type` varchar(10) DEFAULT NULL COMMENT '回复类型',
  `time` bigint(12) NOT NULL DEFAULT '0' COMMENT '最后编辑时间',
  `text` text COMMENT '文本回复内容',
  `image` varchar(55) DEFAULT NULL COMMENT '图片回复内容',
  `voice` varchar(55) DEFAULT NULL COMMENT '语音回复内容',
  `video` varchar(55) DEFAULT NULL COMMENT '视频回复内容',
  `function` varchar(100) DEFAULT NULL COMMENT '回复函数',
  `state` int(1) NOT NULL DEFAULT '1' COMMENT '启用状态',
  `like` int(11) NOT NULL DEFAULT '0' COMMENT '是否精准匹配',
  `sequence` int(5) NOT NULL DEFAULT '0' COMMENT '排序',
  `author` varchar(30) NOT NULL COMMENT '操作人',
  `use_count` int(11) NOT NULL DEFAULT '0',
  `visit` int(11) NOT NULL DEFAULT '0' COMMENT '使用次数',
  PRIMARY KEY (`id`),
  KEY `key` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=547 DEFAULT CHARSET=utf8 COMMENT='梦行微信 自动回复 ';m;o;n;
INSERT INTO `monxin_weixin_auto_answer` (`id`,`wid`,`key`,`input_type`,`output_type`,`time`,`text`,`image`,`voice`,`video`,`function`,`state`,`like`,`sequence`,`author`,`use_count`,`visit`) VALUES
('546','gh_7eca8f5d4da0','无关键词回复及搜索结果时返回:no_keyword_and_no_search_then_answer','text','text','1491619687','','','','','','1','0','0','monxin','0','0'),
('545','gh_7eca8f5d4da0','当:收到网址|MsgType:link','text','text','1491619687','当:收到网址','','','','','1','0','0','monxin','0','0'),
('544','gh_7eca8f5d4da0','当:收到视频|MsgType:video','text','text','1491619687','当:收到视频','','','','','1','0','0','monxin','0','0'),
('543','gh_7eca8f5d4da0','当:收到语音|MsgType:voice','text','text','1491619687','当:收到语音','','','','','1','0','0','monxin','0','0'),
('542','gh_7eca8f5d4da0','当:收到图片|MsgType:image','text','text','1491619687','当:收到图片','','','','','1','0','0','monxin','0','0'),
('541','gh_7eca8f5d4da0','当:收到位置|MsgType:location','text','text','1491619687','当:收到位置','','','','','1','0','0','monxin','0','0'),
('540','gh_7eca8f5d4da0','当:取消关注|MsgType:event|Event:unsubscribe','text','text','1491619687','当:取消关注','','','','','1','0','0','monxin','0','0'),
('539','gh_7eca8f5d4da0','当:用户关注|MsgType:event|Event:subscribe','text','text','1491619687','当:用户关注','','','','','1','0','0','monxin','0','0');m;o;n;
DROP TABLE IF EXISTS `monxin_weixin_dialog`;m;o;n;
CREATE TABLE `monxin_weixin_dialog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` varchar(100) DEFAULT NULL COMMENT '发信人',
  `to` varchar(100) DEFAULT NULL COMMENT '收信人',
  `type` varchar(30) DEFAULT NULL COMMENT '信息类型',
  `input_type` varchar(20) NOT NULL COMMENT '回复信息类型',
  `content` text COMMENT '信息内容',
  `time` bigint(12) NOT NULL DEFAULT '0' COMMENT '时间',
  `wid` varchar(100) NOT NULL COMMENT '所属微信原始ID',
  `read` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1237 DEFAULT CHARSET=utf8 COMMENT='梦行微信 粉丝聊天日志';m;o;n;
INSERT INTO `monxin_weixin_dialog` (`id`,`from`,`to`,`type`,`input_type`,`content`,`time`,`wid`,`read`) VALUES
('179','','','text','text','带回家','1394116021','','0'),
('180','','','text','text','叫你','1394116126','','0'),
('181','','','text','text','家里','1394116269','','0');m;o;n;
DROP TABLE IF EXISTS `monxin_weixin_diy_qr`;m;o;n;
CREATE TABLE `monxin_weixin_diy_qr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wid` varchar(100) DEFAULT NULL COMMENT '所属微信原始id',
  `key` varchar(100) DEFAULT NULL COMMENT '二维码参数',
  `time` bigint(12) NOT NULL DEFAULT '0' COMMENT '时间',
  `name` varchar(30) DEFAULT NULL COMMENT '名称',
  `auto_answer` int(1) NOT NULL DEFAULT '0' COMMENT '执行自动回复',
  `auto_answer_id` int(11) NOT NULL DEFAULT '0' COMMENT '自动回复ID',
  `url` varchar(100) DEFAULT NULL COMMENT '微信给的二维码数据URL',
  `type` int(1) NOT NULL DEFAULT '0' COMMENT '有效期是否永久',
  PRIMARY KEY (`id`),
  KEY `key` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='梦行微信 自定义二维码';m;o;n;
INSERT INTO `monxin_weixin_diy_qr` (`id`,`wid`,`key`,`time`,`name`,`auto_answer`,`auto_answer_id`,`url`,`type`) VALUES
('23','gh_e0f0d1349e23','get_reg_authcode','1453429942','微信扫一扫接收验证码','1','491','http://weixin.qq.com/q/9ET6PArleHsB2TrVKWzF','1'),
('22','gh_7eca8f5d4da0','get_reg_authcode','1453393953','微信扫一扫接收验证码','1','490','http://weixin.qq.com/q/_0PuScrla6wSCXYdFGtR','1'),
('33','gh_7eca8f5d4da0','test','1478668728','test','1','512','http://weixin.qq.com/q/YkO2jkXlO6xC3unSTG1R','0');m;o;n;
DROP TABLE IF EXISTS `monxin_weixin_function`;m;o;n;
CREATE TABLE `monxin_weixin_function` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL COMMENT '函数名称',
  `description` varchar(30) DEFAULT NULL COMMENT '功能描述',
  `sequence` int(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `state` int(1) NOT NULL DEFAULT '1' COMMENT '启用状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='梦行微信 函数';m;o;n;
INSERT INTO `monxin_weixin_function` (`id`,`name`,`description`,`sequence`,`state`) VALUES
('6','echo_login','显示登陆界面4','8','1'),
('7','echo_reg','显示注册界面','0','1'),
('11','get_authcode','微信扫码返回验证码','0','1');m;o;n;
DROP TABLE IF EXISTS `monxin_weixin_mass`;m;o;n;
CREATE TABLE `monxin_weixin_mass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `icon` varchar(60) DEFAULT NULL,
  `url` varchar(50) DEFAULT NULL,
  `sequence` int(4) NOT NULL DEFAULT '0',
  `last_time` bigint(12) NOT NULL DEFAULT '0',
  `visit` int(11) NOT NULL DEFAULT '0',
  `wid` varchar(100) DEFAULT NULL COMMENT '所属公众号ID',
  `media_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COMMENT='微信群发备选信息表';m;o;n;
INSERT INTO `monxin_weixin_mass` (`id`,`title`,`icon`,`url`,`sequence`,`last_time`,`visit`,`wid`,`media_id`) VALUES
('63','33','2017_04/08/1491619723_0_3068.jpg','./index.php?monxin=index.admin_users','0','1491619726','0','gh_7eca8f5d4da0','_e_x_MkTTVnkTYPjkitOF30yIFFyqPUpKszj8R8IaLpidIwNU-DpnaQZ39os5r8f'),
('64','雅诗兰黛（Estee Lauder）特润修护系列套装（眼霜15ml+精华50ml+面霜+水+洁+唇彩+面膜）礼盒','2017_04/09/3a51f286ab662436e6a55bf2aa7a06de.jpg','./index.php?monxin=mall.goods&id=293','0','1491719518','0','gh_7eca8f5d4da0','xjuI1WEu06X_6G49ycYKz98DlvfYs4q7Ngu1jcXkQNMoOMpNDqvLxJoNxYn706qv'),
('65','33','2017_04/09/1483337704_0_9569.jpg','./index.php?monxin=mall.goods&id=296','0','1491719518','0','gh_7eca8f5d4da0','dAIt-_qEeKTIQ54LfCVZQZvbUN5EZ2CL5imNQOelZXLjaQ3Ec9BnG6cT2xtkQKRg'),
('66','送键盘Teclast/台电 X2 Pro WIFI 64GB Win10 11.6英寸平板电脑','2017_04/09/1443164491_0_8477.jpg','./index.php?monxin=mall.goods&id=47','0','1491719857','0','gh_7eca8f5d4da0','CHoya4NJMgwh-X67BVACYUmcz_ppJkX6U56zFcsFWOR62dLSwDk-oVdd2HuZRN3V'),
('67','QRTECH 麦本本 金麦3 14英寸金属超薄笔记本 i5超极本 轻薄手提33','2017_04/09/023140d71025383ee9dbe2f147184e40.jpg','./index.php?monxin=mall.goods&id=61','0','1491719857','0','gh_7eca8f5d4da0','BYAlWrhDvAXkOF0DU71pSLUBHLQxDBpHiRgi6RKpY-5otC6ty1T9WLL5sm11cRbn'),
('68','234234','2017_04/09/1454811715_0_2027.jpg','./index.php?monxin=mall.goods&id=75','0','1491719857','0','gh_7eca8f5d4da0','mJ9Nog7NYbrHWxX4GRoVAXQsvlV8VeEfCA4GbJFR3H6XOQflkuyhY5gQ9ZZlfGb3'),
('69','34','2017_04/09/1454815301_0_5693.jpg','./index.php?monxin=mall.goods&id=76','0','1491719857','0','gh_7eca8f5d4da0','k7vk-G7JrYZxLKVkiFyzKGXbme65CfODtE-BDEI09FSzuANpFvF2B7_8ddu3vR0d'),
('70','鲜百年  山东蓬莱富士 红富士 6个装 0.9~1.1kg 自营水果','2017_04/09/a01fe8b71991d8d1793aa2098cabcc55.jpg','./index.php?monxin=mall.goods&id=289','0','1491719857','0','gh_7eca8f5d4da0','jfCsIzY2IDfFoJyynnP87repcKynbTBkhwgEiKbY0P24Io72Eqp2Y7RdzxgsM-_R'),
('71','小汤山 彩椒 约400g 自营蔬菜','2017_04/09/5c7086ac2952914d1e7d3ad75ef4fe19.jpg','./index.php?monxin=mall.goods&id=290','0','1491719857','0','gh_7eca8f5d4da0','aDMusisiexDgieQYXylzGclLeNsYjMlX4JuPkRavBlzzOukUjwtg0e_Jreyl4nyB'),
('72','唐人基 新西兰鲜嫩羔羊肉卷1000g 精选羊肉生鲜 豆捞菜品精选羊肉片 火锅食材','2017_04/09/b0dc82a1fb444027ddcd3bc018b350e4.jpg','./index.php?monxin=mall.goods&id=291','0','1491719857','0','gh_7eca8f5d4da0','CdCjZAZtZfezN81GIft3QmdgY203qSgp1PkqW8DAEWgFz-Yuax8hObCEgD2prjwa'),
('73','唐人基 深海鱼滑180g*2盒 福州鱼丸豆捞菜品 火锅食材 海鲜丸子','2017_04/09/d12af46cec58436f725ad69ed6fe2350.jpg','./index.php?monxin=mall.goods&id=292','0','1491719857','0','gh_7eca8f5d4da0','tJzZfJpDLriIyUN80yNrfKeiwYi77mwOm0PFk_PkCTQcXOzrEEkw1uUBHl13knQc'),
('74','雅诗兰黛（Estee Lauder）特润修护系列套装（眼霜15ml+精华50ml+面霜+水+洁+唇彩+面膜）礼盒','2017_04/09/3a51f286ab662436e6a55bf2aa7a06de.jpg','./index.php?monxin=mall.goods&id=293','0','1491719857','0','gh_7eca8f5d4da0','nse8dKiZBSO3b8LnAxUwF5dfoAchBlP1ga0xYTUmLPlo9V4HkAO2bvgtAp3GcQX3'),
('75','33','2017_04/09/1483337704_0_9569.jpg','./index.php?monxin=mall.goods&id=296','0','1491719857','0','gh_7eca8f5d4da0','AmFy21XiiDGUwGWIMG722Qu9mFN7nF4847PtSNXw37mcT109DA4QLJBMx-fKIPlX'),
('76','Apple/苹果 iPhone 6 16GB 移动联通电信4G手机','2017_04/09/1443105131_0_3989.jpg','./index.php?monxin=mall.goods&id=27','0','1491722613','0','gh_7eca8f5d4da0','STvtC0ibUIKW7j-MWTdcEibAYdKN9nEyoRO5AqR-YvfmvcKl3oNvu0OiCBxExA40'),
('77','Air2 分期Apple/苹果 iPad Air 2 WLAN 16GB WIFI平板电脑 ipad6','2017_04/09/1443105835_0_5937.jpg','./index.php?monxin=mall.goods&id=28','0','1491722613','0','gh_7eca8f5d4da0',''),
('78','洋酒PK预调鸡尾酒威士忌伏特加白兰地鸡尾酒果味酒 275ml*6瓶','2017_04/09/184ca5f90d151f96559a7e43f963d113.jpg','./index.php?monxin=mall.goods&id=23','0','1491722869','0','gh_7eca8f5d4da0','');m;o;n;
DROP TABLE IF EXISTS `monxin_weixin_menu`;m;o;n;
CREATE TABLE `monxin_weixin_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL COMMENT '名称',
  `url` varchar(255) DEFAULT NULL COMMENT '链接',
  `parent` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `visible` int(1) NOT NULL DEFAULT '1' COMMENT '显示状态',
  `sequence` int(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `wid` varchar(100) DEFAULT NULL COMMENT '所属微信原始ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=173 DEFAULT CHARSET=utf8 COMMENT='梦行微信 菜单';m;o;n;
DROP TABLE IF EXISTS `monxin_weixin_news`;m;o;n;
CREATE TABLE `monxin_weixin_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_id` int(11) NOT NULL COMMENT '所属关键词ID',
  `img` varchar(55) DEFAULT NULL COMMENT '图片',
  `title` varchar(255) DEFAULT NULL COMMENT '标题 ',
  `sequence` int(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `url` varchar(255) DEFAULT NULL COMMENT '链接',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=152 DEFAULT CHARSET=utf8 COMMENT='梦行微信 多图文';m;o;n;
INSERT INTO `monxin_weixin_news` (`id`,`key_id`,`img`,`title`,`sequence`,`url`) VALUES
('70','208','2014_03/14/1394799484_0_2028.jpg','','0',''),
('71','208','2014_03/14/1394799491_0_3977.png','','-1','');m;o;n;
DROP TABLE IF EXISTS `monxin_weixin_search_function`;m;o;n;
CREATE TABLE `monxin_weixin_search_function` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '函数名称',
  `description` varchar(50) NOT NULL COMMENT '功能说明 ',
  `sequence` int(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `state` int(1) NOT NULL DEFAULT '1' COMMENT '启用状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='梦行微信 搜索函数';m;o;n;
INSERT INTO `monxin_weixin_search_function` (`id`,`name`,`description`,`sequence`,`state`) VALUES
('5','search_diypage','搜索自定义网页','99','1'),
('6','search_article','搜索梦行展文','9','1'),
('7','search_image','搜索梦行展图','999','1'),
('8','search_mall_goods','搜索梦行商城的商品','9999','1'),
('9','search_shop_goods','搜索梦行店铺的商品','0','0');m;o;n;
DROP TABLE IF EXISTS `monxin_weixin_single_news`;m;o;n;
CREATE TABLE `monxin_weixin_single_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属关键词ID',
  `img` varchar(55) DEFAULT NULL COMMENT '图片',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `description` text COMMENT '内容',
  `url` varchar(255) DEFAULT NULL COMMENT '链接',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COMMENT='梦行微信 单图文';m;o;n;
INSERT INTO `monxin_weixin_single_news` (`id`,`key_id`,`img`,`title`,`description`,`url`) VALUES
('22','200','2014_03/06/1394095436_0_6156.png','你妹','你姐','http://to-top.com'),
('25','222','2014_03/11/1394506668_0_7412.jpg','置顶网络','置顶网络','http://to-top.com'),
('49','316','2015_03/09/1425888987_0_8286.jpg','公司简介','怀化市永强商贸有限公司成立于2009年3月，主要经营百货日化，代理的品牌主要有：上海的百雀羚，德国拜尔的舒蕾、美涛、妮维雅，上海的小叮当，广东中山凯达灭害灵、凯达家具，广州浪奇，广西奥奇丽田七、康齿灵，广东瑞虎染发剂，湖南株洲氧净，广东名臣蒂花之秀，长沙博锐84，美国庄臣爱家等国内外著名品牌。

永强商贸有限公司前身是怀化宏美日化，1999年就从事百货日化这个行业，至今有将近有二十年的历史，企业本着诚信经营、用心服务的宗旨，本着专注品牌、经营品牌的理念。把一个夫妻店一步一步发展到目前有员工四十个，年销量突破一千多万元的小型商贸企业。

   本公司目前业务覆盖到湖南、贵州、云南 、重庆等区域，覆盖的渠道有批发部，日化店、KA卖场，BC类超市，宾馆，餐馆，水洗厂等。公司在未来二年计划利用网络开拓新的市场：淘宝、天猫、微商城都在规划中。永强商贸公司的未来是美好的，前途是光明的！只要努力，我们的梦想就会实现！

   永强商贸有限公司感谢多年来关心和支持本公司的客户朋友，只因有你们永强才能走到今天！只因有你们永强才能发展到目前的规模！有你们的一路相伴，永强商贸会走得越远！越高！越坚强！
                              ',''),
('54','341','2015_07/22/1437564379_0_5234.jpg','感谢您关注世界旅游小姐大赛，我们会第一时间推送大赛信息给您','全有商城世界旅游小姐大赛（MTI）诞生在1965年美国的德拉维尔。

我们的赛事延续了40余年举办至今42届，我们代表了世界的美丽心声！

我们将与你共同见证全球美丽

全有商城为世界旅游小姐大赛（MTI）网络媒体合作商

咨询热线①：0745-2736499

咨询热线②：15115234999

点击进入大赛介绍
','http://www.quanyousc.com/index.php?monxin=diypage.show&id=124');m;o;n;
DROP TABLE IF EXISTS `monxin_weixin_user`;m;o;n;
CREATE TABLE `monxin_weixin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` bigint(12) NOT NULL DEFAULT '0' COMMENT '首次关注时间',
  `subscribe` int(1) NOT NULL DEFAULT '0' COMMENT '是否关注中',
  `subscribe_time` bigint(12) NOT NULL DEFAULT '0' COMMENT '最后关注时间',
  `state` int(1) NOT NULL DEFAULT '1' COMMENT '启用状态',
  `openid` varchar(100) DEFAULT NULL COMMENT '微信openid',
  `username` varchar(30) DEFAULT NULL COMMENT '站内用户名',
  `wid` varchar(100) DEFAULT NULL COMMENT '所属公众号原始ID',
  `nickname` varchar(50) DEFAULT NULL COMMENT '呢称',
  `sex` varchar(10) DEFAULT NULL COMMENT '性别',
  `area` varchar(100) DEFAULT NULL COMMENT '所在地区',
  `headimgurl` varchar(255) DEFAULT NULL COMMENT '图像',
  `privilege` varchar(30) DEFAULT NULL COMMENT '特权',
  `latitude` varchar(10) DEFAULT NULL COMMENT '最后纬度',
  `longitude` varchar(10) DEFAULT NULL COMMENT '最后经度',
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=174 DEFAULT CHARSET=utf8 COMMENT='梦行微信 公众号粉丝';m;o;n;
DROP TABLE IF EXISTS `monxin_weixin_user_location`;m;o;n;
CREATE TABLE `monxin_weixin_user_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wid` varchar(32) DEFAULT NULL COMMENT '公众号ID',
  `openid` varchar(32) DEFAULT NULL COMMENT '用户ID',
  `latitude` varchar(10) DEFAULT NULL COMMENT '纬度',
  `longitude` varchar(10) DEFAULT NULL COMMENT '经度',
  `precision` varchar(10) DEFAULT NULL COMMENT '精度',
  `time` bigint(12) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=266 DEFAULT CHARSET=utf8 COMMENT='梦行微信 粉丝位置日志';m;o;n;
INSERT INTO `monxin_weixin_user_location` (`id`,`wid`,`openid`,`latitude`,`longitude`,`precision`,`time`) VALUES
('7','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552422','109.943245','70.000000','1438962655'),
('6','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552420','109.943390','40.000000','1438962638'),
('5','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552357','109.943230','40.000000','1438962632'),
('8','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552357','109.943237','40.000000','1438962720'),
('9','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552341','109.943169','40.000000','1438962912'),
('10','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552341','109.943169','40.000000','1438962987'),
('11','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552391','109.943291','40.000000','1438963036'),
('12','gh_a8cdcaab89ce','ousfhjooVPI_3onUKOWTLNSwB3rE','27.558039','109.960396','65.000000','1438963548'),
('13','gh_a8cdcaab89ce','ousfhjvRcNNpszaw_BWsCZUzp2Ck','27.546631','109.946556','70.000000','1438964633'),
('14','gh_a8cdcaab89ce','ousfhjvRcNNpszaw_BWsCZUzp2Ck','27.546635','109.946571','90.000000','1438964705'),
('15','gh_a8cdcaab89ce','ousfhjo936ZcJ-864pWgLxSLbLCg','27.556070','109.967308','960.000000','1438995633'),
('16','gh_a8cdcaab89ce','ousfhjo936ZcJ-864pWgLxSLbLCg','27.552378','109.964027','920.000000','1438995675'),
('17','gh_a8cdcaab89ce','ousfhjo936ZcJ-864pWgLxSLbLCg','27.556070','109.967308','960.000000','1438995736'),
('18','gh_a8cdcaab89ce','ousfhjgKH0Ifc_KWkiV2bW9mymp4','27.556070','109.967308','960.000000','1438996802'),
('19','gh_a8cdcaab89ce','ousfhjgKH0Ifc_KWkiV2bW9mymp4','27.556070','109.967308','960.000000','1438996884'),
('20','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552355','109.943260','40.000000','1439000064'),
('21','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552261','109.943253','60.000000','1439000307'),
('22','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552187','109.943138','40.000000','1439000358'),
('23','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552193','109.943146','40.000000','1439000377'),
('24','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552195','109.943130','60.000000','1439000434'),
('25','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552189','109.943130','40.000000','1439002715'),
('26','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552229','109.943176','70.000000','1439003018'),
('27','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552286','109.943275','70.000000','1439004033'),
('28','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552219','109.943214','40.000000','1439004717'),
('29','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552219','109.943214','40.000000','1439004947'),
('30','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552193','109.943184','40.000000','1439005039'),
('31','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552191','109.943199','40.000000','1439005065'),
('32','gh_a8cdcaab89ce','ousfhjlN_IPp-RJ0af5pyg_Td9bI','27.583158','110.027542','110.000000','1439012489'),
('33','gh_a8cdcaab89ce','ousfhjlN_IPp-RJ0af5pyg_Td9bI','27.583158','110.027542','110.000000','1439012777'),
('34','gh_a8cdcaab89ce','ousfhjlN_IPp-RJ0af5pyg_Td9bI','27.583158','110.027542','110.000000','1439012847'),
('35','gh_a8cdcaab89ce','ousfhjlN_IPp-RJ0af5pyg_Td9bI','27.583158','110.027542','110.000000','1439013647'),
('36','gh_a8cdcaab89ce','ousfhjlN_IPp-RJ0af5pyg_Td9bI','27.583158','110.027542','110.000000','1439014034'),
('37','gh_a8cdcaab89ce','ousfhjlN_IPp-RJ0af5pyg_Td9bI','27.583158','110.027542','110.000000','1439014098'),
('38','gh_a8cdcaab89ce','ousfhjlN_IPp-RJ0af5pyg_Td9bI','27.583158','110.027542','110.000000','1439014375'),
('39','gh_a8cdcaab89ce','ousfhjo936ZcJ-864pWgLxSLbLCg','27.551371','109.988770','880.000000','1439016688'),
('40','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552208','109.943207','40.000000','1439022107'),
('41','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552225','109.943153','40.000000','1439022402'),
('42','gh_a8cdcaab89ce','ousfhjlN_IPp-RJ0af5pyg_Td9bI','27.583158','110.027542','110.000000','1439023683'),
('43','gh_a8cdcaab89ce','ousfhjgKH0Ifc_KWkiV2bW9mymp4','27.545551','109.986282','110.000000','1439040784'),
('44','gh_a8cdcaab89ce','ousfhjiS3qQdZHZtnUmJPWkjn9jg','27.558523','109.966866','65.000000','1439086416'),
('45','gh_a8cdcaab89ce','ousfhjiS3qQdZHZtnUmJPWkjn9jg','27.558559','109.966835','65.000000','1439086528'),
('46','gh_a8cdcaab89ce','ousfhjiS3qQdZHZtnUmJPWkjn9jg','27.558527','109.966759','65.000000','1439087193'),
('47','gh_a8cdcaab89ce','ousfhjiS3qQdZHZtnUmJPWkjn9jg','27.558538','109.966843','65.000000','1439087342'),
('48','gh_a8cdcaab89ce','ousfhjiS3qQdZHZtnUmJPWkjn9jg','27.558081','109.967278','65.000000','1439092197'),
('49','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552404','109.943237','120.000000','1439102541'),
('50','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552221','109.943214','70.000000','1439102599'),
('51','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552233','109.943268','60.000000','1439102658'),
('52','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552216','109.943245','40.000000','1439102666'),
('53','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552210','109.943192','40.000000','1439102779'),
('54','gh_a8cdcaab89ce','ousfhjlp2rrg9RJGshhIQunb1rk8','29.543060','106.515862','65.000000','1439107518');m;o;n;
INSERT INTO `monxin_weixin_user_location` (`id`,`wid`,`openid`,`latitude`,`longitude`,`precision`,`time`) VALUES
('55','gh_a8cdcaab89ce','ousfhjlnliZIeDRvfyDQXjZF9JrU','27.555849','109.961243','750.000000','1439108320'),
('56','gh_a8cdcaab89ce','ousfhjlnliZIeDRvfyDQXjZF9JrU','27.555849','109.961243','1330.00000','1439108518'),
('57','gh_a8cdcaab89ce','ousfhjlnliZIeDRvfyDQXjZF9JrU','27.555849','109.961243','750.000000','1439108659'),
('58','gh_a8cdcaab89ce','ousfhjlnliZIeDRvfyDQXjZF9JrU','27.555849','109.961243','750.000000','1439108747'),
('59','gh_a8cdcaab89ce','ousfhjlnliZIeDRvfyDQXjZF9JrU','27.555849','109.961243','750.000000','1439108939'),
('60','gh_a8cdcaab89ce','ousfhjlnliZIeDRvfyDQXjZF9JrU','27.557316','109.959244','880.000000','1439109194'),
('61','gh_a8cdcaab89ce','ousfhjlnliZIeDRvfyDQXjZF9JrU','27.557316','109.959244','880.000000','1439109440'),
('62','gh_a8cdcaab89ce','ousfhjlnliZIeDRvfyDQXjZF9JrU','27.548048','109.958710','1620.00000','1439109670'),
('63','gh_a8cdcaab89ce','ousfhjijTTj0NbIduRY0yAVlfCPQ','27.539848','109.970024','40.000000','1439109734'),
('64','gh_a8cdcaab89ce','ousfhjlnliZIeDRvfyDQXjZF9JrU','27.557316','109.959244','880.000000','1439109745'),
('65','gh_a8cdcaab89ce','ousfhjijTTj0NbIduRY0yAVlfCPQ','27.539381','109.968742','110.000000','1439109771'),
('66','gh_a8cdcaab89ce','ousfhjlnliZIeDRvfyDQXjZF9JrU','27.557316','109.959244','880.000000','1439109896'),
('67','gh_a8cdcaab89ce','ousfhjlnliZIeDRvfyDQXjZF9JrU','27.557316','109.959244','880.000000','1439110007'),
('68','gh_a8cdcaab89ce','ousfhjlnliZIeDRvfyDQXjZF9JrU','27.557316','109.959244','880.000000','1439110154'),
('69','gh_a8cdcaab89ce','ousfhjlnliZIeDRvfyDQXjZF9JrU','27.557316','109.959244','880.000000','1439110227'),
('70','gh_a8cdcaab89ce','ousfhjldQuZ8HMbQUzAip0JuAPe4','27.559364','109.959618','90.000000','1439112810'),
('71','gh_a8cdcaab89ce','ousfhjgLFZprKOO4YWH7Telk35_o','27.558130','109.957443','40.000000','1439115388'),
('72','gh_a8cdcaab89ce','ousfhjldQuZ8HMbQUzAip0JuAPe4','27.570986','109.959236','120.000000','1439115515'),
('73','gh_a8cdcaab89ce','ousfhjldQuZ8HMbQUzAip0JuAPe4','27.571245','109.960068','110.000000','1439117005'),
('74','gh_a8cdcaab89ce','ousfhjldQuZ8HMbQUzAip0JuAPe4','27.571217','109.959930','120.000000','1439117138'),
('75','gh_a8cdcaab89ce','ousfhjldQuZ8HMbQUzAip0JuAPe4','27.571114','109.959633','110.000000','1439117262'),
('76','gh_a8cdcaab89ce','ousfhjldQuZ8HMbQUzAip0JuAPe4','27.571217','109.959930','120.000000','1439117332'),
('77','gh_a8cdcaab89ce','ousfhjldQuZ8HMbQUzAip0JuAPe4','27.571312','109.960342','120.000000','1439117520'),
('78','gh_a8cdcaab89ce','ousfhjldQuZ8HMbQUzAip0JuAPe4','27.571095','109.959946','110.000000','1439117540'),
('79','gh_a8cdcaab89ce','ousfhjlnliZIeDRvfyDQXjZF9JrU','27.555849','109.961243','750.000000','1439118559'),
('80','gh_a8cdcaab89ce','ousfhjl9qHoBxqsEUBr1J519vDd8','27.551996','109.966866','1260.00000','1439118940'),
('81','gh_a8cdcaab89ce','ousfhjl9qHoBxqsEUBr1J519vDd8','27.557692','109.966026','1030.00000','1439119109'),
('82','gh_a8cdcaab89ce','ousfhjsp5NiqtvqiLtfnO1Ch8F6Q','27.557755','109.967262','60.000000','1439122386'),
('83','gh_a8cdcaab89ce','ousfhjsp5NiqtvqiLtfnO1Ch8F6Q','27.557768','109.967247','60.000000','1439123064'),
('84','gh_a8cdcaab89ce','ousfhjldQuZ8HMbQUzAip0JuAPe4','27.571245','109.960068','110.000000','1439123498'),
('85','gh_a8cdcaab89ce','ousfhjj_EMTWgynoGQhmX5QL433g','27.557484','109.967575','65.000000','1439126410'),
('86','gh_a8cdcaab89ce','ousfhjg5dmwtWSXDKaedt_usTefU','27.571489','109.960167','60.000000','1439127562'),
('87','gh_a8cdcaab89ce','ousfhjg5dmwtWSXDKaedt_usTefU','27.571548','109.960144','90.000000','1439127622'),
('88','gh_a8cdcaab89ce','ousfhjg5dmwtWSXDKaedt_usTefU','27.571493','109.960182','70.000000','1439127688'),
('89','gh_a8cdcaab89ce','ousfhjj_EMTWgynoGQhmX5QL433g','27.557671','109.967400','5.000000','1439128166'),
('90','gh_a8cdcaab89ce','ousfhjm-cIX295BcB8lVrgjrfC9g','27.557289','109.968277','40.000000','1439132186'),
('91','gh_a8cdcaab89ce','ousfhjm-cIX295BcB8lVrgjrfC9g','27.556055','109.967293','40.000000','1439134124'),
('92','gh_a8cdcaab89ce','ousfhjunHKRfxu2jxy6T5u3BV6c4','27.566820','110.004448','90.000000','1439167753'),
('93','gh_a8cdcaab89ce','ousfhjunHKRfxu2jxy6T5u3BV6c4','27.566875','110.004463','70.000000','1439167770'),
('94','gh_a8cdcaab89ce','ousfhjunHKRfxu2jxy6T5u3BV6c4','27.566799','110.004402','60.000000','1439167860'),
('95','gh_a8cdcaab89ce','ousfhjunHKRfxu2jxy6T5u3BV6c4','27.566824','110.004440','40.000000','1439167922'),
('96','gh_a8cdcaab89ce','ousfhjunHKRfxu2jxy6T5u3BV6c4','27.566952','110.004608','70.000000','1439167949'),
('97','gh_a8cdcaab89ce','ousfhjunHKRfxu2jxy6T5u3BV6c4','27.566944','110.004524','60.000000','1439168025'),
('98','gh_a8cdcaab89ce','ousfhjunHKRfxu2jxy6T5u3BV6c4','27.567047','110.004509','60.000000','1439168069'),
('99','gh_a8cdcaab89ce','ousfhjunHKRfxu2jxy6T5u3BV6c4','27.566889','110.004539','40.000000','1439168133'),
('100','gh_a8cdcaab89ce','ousfhjunHKRfxu2jxy6T5u3BV6c4','27.566919','110.004410','40.000000','1439168187'),
('101','gh_a8cdcaab89ce','ousfhjunHKRfxu2jxy6T5u3BV6c4','27.566906','110.004517','40.000000','1439168241'),
('102','gh_a8cdcaab89ce','ousfhjunHKRfxu2jxy6T5u3BV6c4','27.566944','110.004524','60.000000','1439168277'),
('103','gh_a8cdcaab89ce','ousfhjunHKRfxu2jxy6T5u3BV6c4','27.567047','110.004509','60.000000','1439168336'),
('104','gh_a8cdcaab89ce','ousfhjunHKRfxu2jxy6T5u3BV6c4','27.566944','110.004410','70.000000','1439168427');m;o;n;
INSERT INTO `monxin_weixin_user_location` (`id`,`wid`,`openid`,`latitude`,`longitude`,`precision`,`time`) VALUES
('105','gh_a8cdcaab89ce','ousfhjunHKRfxu2jxy6T5u3BV6c4','27.566814','110.004509','40.000000','1439168487'),
('106','gh_a8cdcaab89ce','ousfhjunHKRfxu2jxy6T5u3BV6c4','27.566973','110.004356','90.000000','1439168998'),
('107','gh_a8cdcaab89ce','ousfhjunHKRfxu2jxy6T5u3BV6c4','27.566671','110.004478','70.000000','1439169042'),
('108','gh_a8cdcaab89ce','ousfhjunHKRfxu2jxy6T5u3BV6c4','27.566799','110.004402','60.000000','1439169071'),
('109','gh_a8cdcaab89ce','ousfhjhl2G5IxcEhlIUhqLS9_jbo','27.545664','109.947411','192.000000','1439186308'),
('110','gh_a8cdcaab89ce','ousfhjhl2G5IxcEhlIUhqLS9_jbo','27.545664','109.947411','192.000000','1439186526'),
('111','gh_a8cdcaab89ce','ousfhjhl2G5IxcEhlIUhqLS9_jbo','27.545664','109.947411','192.000000','1439203089'),
('112','gh_a8cdcaab89ce','ousfhjhl2G5IxcEhlIUhqLS9_jbo','27.545664','109.947411','192.000000','1439210755'),
('113','gh_a8cdcaab89ce','ousfhjpaISfwmj5RWpFWv29zAuLU','27.539625','109.996811','1570.00000','1439246318'),
('114','gh_a8cdcaab89ce','ousfhjlnliZIeDRvfyDQXjZF9JrU','27.553194','109.947754','940.000000','1439255286'),
('115','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.545862','109.944878','40.000000','1439269467'),
('116','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.545849','109.944855','40.000000','1439270084'),
('117','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.545853','109.944885','40.000000','1439270441'),
('118','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.545914','109.944923','40.000000','1439270515'),
('119','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.545876','109.944901','40.000000','1439270560'),
('120','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.545883','109.944901','40.000000','1439270650'),
('121','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.545809','109.944855','40.000000','1439273000'),
('122','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.545816','109.944847','40.000000','1439273078'),
('123','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.546284','109.945511','40.000000','1439281815'),
('124','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.546337','109.945419','40.000000','1439282045'),
('125','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.546335','109.945450','40.000000','1439282086'),
('126','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.546291','109.945404','40.000000','1439282140'),
('127','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.546322','109.945557','40.000000','1439283889'),
('128','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.546312','109.945580','40.000000','1439283926'),
('129','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.546227','109.945625','40.000000','1439284081'),
('130','gh_a8cdcaab89ce','ousfhjhl2G5IxcEhlIUhqLS9_jbo','27.545664','109.947411','192.000000','1439284271'),
('131','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.546314','109.945496','40.000000','1439284292'),
('132','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.546263','109.945496','40.000000','1439285630'),
('133','gh_a8cdcaab89ce','ousfhjhl2G5IxcEhlIUhqLS9_jbo','27.545664','109.947411','192.000000','1439287177'),
('134','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.544302','109.946579','940.000000','1439300922'),
('135','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.544302','109.946579','940.000000','1439301053'),
('136','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.544302','109.946579','940.000000','1439301891'),
('137','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.544302','109.946579','940.000000','1439302284'),
('138','gh_a8cdcaab89ce','ousfhjgU7Bvri4F4krzvwUN5xG2w','27.541891','109.995422','65.000000','1439379950'),
('139','gh_a8cdcaab89ce','ousfhjmaiVF5sr9rmhDoI76GAgnc','27.541523','109.978394','40.000000','1439442868'),
('140','gh_a8cdcaab89ce','ousfhjpCOsD9tGmgAm0r1s37C9ZI','27.541504','109.978386','40.000000','1439443323'),
('141','gh_a8cdcaab89ce','ousfhjpCOsD9tGmgAm0r1s37C9ZI','27.541529','109.978386','60.000000','1439445038'),
('142','gh_a8cdcaab89ce','ousfhjpCOsD9tGmgAm0r1s37C9ZI','27.541525','109.978394','40.000000','1439445407'),
('143','gh_a8cdcaab89ce','ousfhjpCOsD9tGmgAm0r1s37C9ZI','27.541475','109.978378','60.000000','1439445835'),
('144','gh_a8cdcaab89ce','ousfhjpCOsD9tGmgAm0r1s37C9ZI','27.541479','109.978378','40.000000','1439461618'),
('145','gh_a8cdcaab89ce','ousfhjjCYqieH-UbSOvbDtcQAHxo','27.555059','109.977150','65.000000','1439464995'),
('146','gh_a8cdcaab89ce','ousfhjtMtTPzZmtYmAqRbwosJrI8','27.541479','109.978371','40.000000','1439469264'),
('147','gh_a8cdcaab89ce','ousfhjpzF9MlEEsJOYUM9Ca5WsR0','26.884544','109.726387','65.000000','1439474391'),
('148','gh_a8cdcaab89ce','ousfhjpzF9MlEEsJOYUM9Ca5WsR0','26.884605','109.726334','65.000000','1439475727'),
('149','gh_a8cdcaab89ce','ousfhjpzF9MlEEsJOYUM9Ca5WsR0','26.884424','109.726295','10.000000','1439475743'),
('150','gh_a8cdcaab89ce','ousfhjpzF9MlEEsJOYUM9Ca5WsR0','26.884424','109.726295','5.000000','1439476260'),
('151','gh_a8cdcaab89ce','ousfhjtMtTPzZmtYmAqRbwosJrI8','27.523642','109.966675','1360.00000','1439479415'),
('152','gh_a8cdcaab89ce','ousfhjve_rnW_WSItFJZfiHq0Jkk','27.550470','109.958763','120.000000','1439512229'),
('153','gh_a8cdcaab89ce','ousfhjve_rnW_WSItFJZfiHq0Jkk','27.550470','109.958763','120.000000','1439512289'),
('154','gh_a8cdcaab89ce','ousfhjve_rnW_WSItFJZfiHq0Jkk','27.550573','109.958237','120.000000','1439513580');m;o;n;
INSERT INTO `monxin_weixin_user_location` (`id`,`wid`,`openid`,`latitude`,`longitude`,`precision`,`time`) VALUES
('155','gh_a8cdcaab89ce','ousfhjve_rnW_WSItFJZfiHq0Jkk','27.550446','109.958359','120.000000','1439513659'),
('156','gh_a8cdcaab89ce','ousfhjve_rnW_WSItFJZfiHq0Jkk','27.550484','109.958534','110.000000','1439513722'),
('157','gh_a8cdcaab89ce','ousfhjlnliZIeDRvfyDQXjZF9JrU','27.079191','109.986610','900.000000','1439529592'),
('158','gh_a8cdcaab89ce','ousfhjtMtTPzZmtYmAqRbwosJrI8','27.524389','109.970947','1570.00000','1439536929'),
('159','gh_a8cdcaab89ce','ousfhjtMtTPzZmtYmAqRbwosJrI8','27.524199','109.969696','700.000000','1439549706'),
('160','gh_a8cdcaab89ce','ousfhjve_rnW_WSItFJZfiHq0Jkk','27.556513','109.961304','1010.00000','1439553440'),
('161','gh_a8cdcaab89ce','ousfhjqnbFYyJqtfDI7itVT5GVeY','27.552082','109.964088','90.000000','1439553681'),
('162','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.550247','109.961945','1420.00000','1439553733'),
('163','gh_a8cdcaab89ce','ousfhjqnbFYyJqtfDI7itVT5GVeY','27.552044','109.964149','110.000000','1439553864'),
('164','gh_a8cdcaab89ce','ousfhjqnbFYyJqtfDI7itVT5GVeY','27.554888','109.952240','110.000000','1439561910'),
('165','gh_a8cdcaab89ce','ousfhjqnbFYyJqtfDI7itVT5GVeY','27.555847','109.951965','110.000000','1439561948'),
('166','gh_a8cdcaab89ce','ousfhjqnbFYyJqtfDI7itVT5GVeY','27.558104','109.951210','110.000000','1439561992'),
('167','gh_a8cdcaab89ce','ousfhjqnbFYyJqtfDI7itVT5GVeY','27.555801','109.951981','110.000000','1439562008'),
('168','gh_a8cdcaab89ce','ousfhjqnbFYyJqtfDI7itVT5GVeY','27.555828','109.951965','110.000000','1439562065'),
('169','gh_a8cdcaab89ce','ousfhjqqLS3b4avgcZgfzVVqAcwI','27.545774','109.944855','70.000000','1439595095'),
('170','gh_a8cdcaab89ce','ousfhjve_rnW_WSItFJZfiHq0Jkk','27.580364','110.038467','930.000000','1439613674'),
('171','gh_a8cdcaab89ce','ousfhjve_rnW_WSItFJZfiHq0Jkk','27.584831','110.036148','1700.00000','1439687555'),
('172','gh_a8cdcaab89ce','ousfhjvpacVXRgWeExEc1z5jUcF4','27.554943','109.956131','40.000000','1439690050'),
('173','gh_a8cdcaab89ce','ousfhjvpacVXRgWeExEc1z5jUcF4','27.554928','109.956116','40.000000','1439690146'),
('174','gh_a8cdcaab89ce','ousfhjvpacVXRgWeExEc1z5jUcF4','27.554934','109.956024','40.000000','1439690529'),
('175','gh_a8cdcaab89ce','ousfhjve_rnW_WSItFJZfiHq0Jkk','27.580364','110.038467','930.000000','1439691141'),
('176','gh_a8cdcaab89ce','ousfhjvpacVXRgWeExEc1z5jUcF4','27.554945','109.956131','40.000000','1439691236'),
('177','gh_a8cdcaab89ce','ousfhjve_rnW_WSItFJZfiHq0Jkk','27.580364','110.038467','930.000000','1439691243'),
('178','gh_a8cdcaab89ce','ousfhjve_rnW_WSItFJZfiHq0Jkk','27.584831','110.036148','1700.00000','1439691334'),
('179','gh_a8cdcaab89ce','ousfhjvpacVXRgWeExEc1z5jUcF4','27.554972','109.956184','40.000000','1439691507'),
('180','gh_a8cdcaab89ce','ousfhjvpacVXRgWeExEc1z5jUcF4','27.554968','109.956146','40.000000','1439692492'),
('181','gh_a8cdcaab89ce','ousfhjkRAHz8mb0YVUnXBMotZPs0','27.552408','109.953766','70.000000','1439777846'),
('182','gh_a8cdcaab89ce','ousfhjkRAHz8mb0YVUnXBMotZPs0','27.552408','109.953766','70.000000','1439780316'),
('183','gh_a8cdcaab89ce','ousfhjkRAHz8mb0YVUnXBMotZPs0','27.552408','109.953766','70.000000','1439780624'),
('184','gh_a8cdcaab89ce','ousfhjkRAHz8mb0YVUnXBMotZPs0','27.552408','109.953766','70.000000','1439780789'),
('185','gh_a8cdcaab89ce','ousfhjpH1CL1uHadAvtAI-WMPR_Q','27.556099','109.967308','65.000000','1439793285'),
('186','gh_a8cdcaab89ce','ousfhjpH1CL1uHadAvtAI-WMPR_Q','27.556112','109.967270','65.000000','1439793480'),
('187','gh_a8cdcaab89ce','ousfhju5GljSpl7e7qEx4fMBrwyI','27.560898','109.977135','120.000000','1439854326'),
('188','gh_a8cdcaab89ce','ousfhju5GljSpl7e7qEx4fMBrwyI','27.560898','109.977135','120.000000','1439854422'),
('189','gh_a8cdcaab89ce','ousfhjhtok4dYWT0o9gwT42bcfow','27.551443','109.952614','120.000000','1439859798'),
('190','gh_a8cdcaab89ce','ousfhjhtok4dYWT0o9gwT42bcfow','27.553535','109.948227','60.000000','1439863456'),
('191','gh_a8cdcaab89ce','ousfhjhtok4dYWT0o9gwT42bcfow','27.553541','109.948257','60.000000','1439863848'),
('192','gh_a8cdcaab89ce','ousfhjhtok4dYWT0o9gwT42bcfow','27.553541','109.948257','60.000000','1439863942'),
('193','gh_a8cdcaab89ce','ousfhjpH1CL1uHadAvtAI-WMPR_Q','29.527678','108.783936','81.907700','1439910241'),
('194','gh_a8cdcaab89ce','ousfhjhtok4dYWT0o9gwT42bcfow','27.552294','109.948952','90.000000','1439956895'),
('195','gh_a8cdcaab89ce','ousfhjhtok4dYWT0o9gwT42bcfow','27.552271','109.949051','70.000000','1439957023'),
('196','gh_a8cdcaab89ce','ousfhjjXOgqw43IM84huOlEBzKVc','27.550467','109.957809','920.000000','1439974494'),
('197','gh_a8cdcaab89ce','ousfhjjXOgqw43IM84huOlEBzKVc','27.550467','109.957809','920.000000','1439974574'),
('198','gh_a8cdcaab89ce','ousfhjjXOgqw43IM84huOlEBzKVc','27.550467','109.957809','920.000000','1439975666'),
('199','gh_a8cdcaab89ce','ousfhjjXOgqw43IM84huOlEBzKVc','27.550467','109.957809','920.000000','1439975749'),
('200','gh_a8cdcaab89ce','ousfhjkLsAVFnByAla8nAP2Knt3c','27.552399','109.953827','65.000000','1440030784'),
('201','gh_a8cdcaab89ce','ousfhjnICkfeiSKAPm7hpNq1xSYI','27.540857','109.943558','65.000000','1440031764'),
('202','gh_a8cdcaab89ce','ousfhjlnliZIeDRvfyDQXjZF9JrU','27.089724','109.989716','930.000000','1440061710'),
('203','gh_a8cdcaab89ce','ousfhjvpacVXRgWeExEc1z5jUcF4','27.552549','109.953117','90.000000','1440085357'),
('204','gh_a8cdcaab89ce','ousfhjlbFGqsvQANwJc9Z2I7m6zo','27.556118','109.967323','65.000000','1440121466');m;o;n;
INSERT INTO `monxin_weixin_user_location` (`id`,`wid`,`openid`,`latitude`,`longitude`,`precision`,`time`) VALUES
('205','gh_a8cdcaab89ce','ousfhjlbFGqsvQANwJc9Z2I7m6zo','27.556063','109.967308','65.000000','1440121477'),
('206','gh_a8cdcaab89ce','ousfhjmkQnTWg8LWrRL1D_hFyCzs','27.539095','109.969109','65.000000','1440121536'),
('207','gh_a8cdcaab89ce','ousfhjvpacVXRgWeExEc1z5jUcF4','27.552389','109.953224','90.000000','1440121680'),
('208','gh_a8cdcaab89ce','ousfhjvmMmGoGlftWilHRL_DD0YE','27.406404','109.942764','65.000000','1440121726'),
('209','gh_a8cdcaab89ce','ousfhjqAKD94zku8LpJ6dtb1fnBc','27.537771','110.000832','65.000000','1440121954'),
('210','gh_a8cdcaab89ce','ousfhjpzeIgPQ5ohVFjBr6DwmBnc','27.535887','109.997566','40.000000','1440121992'),
('211','gh_a8cdcaab89ce','ousfhjlp2rrg9RJGshhIQunb1rk8','27.574835','109.969475','65.000000','1440121993'),
('212','gh_a8cdcaab89ce','ousfhjqwHkf0zX3CXv-2_aNyhcg0','27.557369','109.951996','91.709625','1440122095'),
('213','gh_a8cdcaab89ce','ousfhjrA2f9jIUsJS3gTagYM6G2c','27.551582','109.952110','820.000000','1440122205'),
('214','gh_a8cdcaab89ce','ousfhjplHw3K15wkjrIh4lET_oC8','27.551928','109.952049','65.606674','1440122457'),
('215','gh_a8cdcaab89ce','ousfhjsah3u86_nMF4BC12zanEqE','34.586281','105.726898','65.000000','1440122560'),
('216','gh_a8cdcaab89ce','ousfhjr3kArMDjgrMS0WMETxSU4U','27.539051','109.949394','40.000000','1440122573'),
('217','gh_a8cdcaab89ce','ousfhjksVltJFShvs7tgJ2jEEwdg','26.575350','109.677582','70.000000','1440122738'),
('218','gh_a8cdcaab89ce','ousfhjmkQnTWg8LWrRL1D_hFyCzs','27.539196','109.969589','65.000000','1440123053'),
('219','gh_a8cdcaab89ce','ousfhjhrbSgy64oGHGR1bv5mWZi8','27.523251','109.965370','960.000000','1440123850'),
('220','gh_a8cdcaab89ce','ousfhjhY3dkoT_WJtRIBYxQ3MaGI','27.551289','109.982758','65.000000','1440124040'),
('221','gh_a8cdcaab89ce','ousfhjo-6hX78Hk952-MWgVqYosw','37.456352','116.265907','40.000000','1440124055'),
('222','gh_a8cdcaab89ce','ousfhjkGsqJvhU0ujglh04rXKdro','28.461674','110.402794','65.000000','1440124913'),
('223','gh_a8cdcaab89ce','ousfhjrk-daRnTbhm8s2Rnu_Htu4','27.357925','109.168205','60.000000','1440125532'),
('224','gh_a8cdcaab89ce','ousfhjrk-daRnTbhm8s2Rnu_Htu4','27.358007','109.167938','120.000000','1440125975'),
('225','gh_a8cdcaab89ce','ousfhjqZKWXaYTJ6ROUflnGmHOq8','27.545391','109.945740','40.000000','1440127819'),
('226','gh_a8cdcaab89ce','ousfhjneSOgOFUBub6SkJIDRo8_0','27.550396','109.941628','110.000000','1440129420'),
('227','gh_a8cdcaab89ce','ousfhjsFGSJCsnB6uWEMmpsiK6Bc','27.559837','109.969193','65.000000','1440131788'),
('228','gh_a8cdcaab89ce','ousfhjlDK5sZeUFZmP-wLV2f_LKw','27.297085','109.024094','1490.00000','1440134562'),
('229','gh_a8cdcaab89ce','ousfhjpzeIgPQ5ohVFjBr6DwmBnc','27.535875','109.997574','40.000000','1440136334'),
('230','gh_a8cdcaab89ce','ousfhjpzeIgPQ5ohVFjBr6DwmBnc','27.535910','109.997604','70.000000','1440136558'),
('231','gh_a8cdcaab89ce','ousfhjpzeIgPQ5ohVFjBr6DwmBnc','27.535877','109.997566','40.000000','1440136570'),
('232','gh_a8cdcaab89ce','ousfhjpzeIgPQ5ohVFjBr6DwmBnc','27.535887','109.997566','40.000000','1440136591'),
('233','gh_a8cdcaab89ce','ousfhjpzeIgPQ5ohVFjBr6DwmBnc','27.535889','109.997581','40.000000','1440136614'),
('234','gh_a8cdcaab89ce','ousfhjrA2f9jIUsJS3gTagYM6G2c','27.557646','109.967331','70.000000','1440137703'),
('235','gh_a8cdcaab89ce','ousfhjmvCL4vq5ACgbNqaGZh1xKM','27.538906','109.951134','60.000000','1440139610'),
('236','gh_a8cdcaab89ce','ousfhjjXOgqw43IM84huOlEBzKVc','27.550423','109.957794','920.000000','1440144166'),
('237','gh_a8cdcaab89ce','ousfhjqJLicxPizdEn3s3xZH8cvA','22.603949','114.138000','40.000000','1440144937'),
('238','gh_a8cdcaab89ce','ousfhjqJLicxPizdEn3s3xZH8cvA','22.604115','114.138039','40.000000','1440145029'),
('239','gh_a8cdcaab89ce','ousfhjn9uVx21tZUHT1gbuRDDAxo','27.551790','109.951988','1170.00000','1440147737'),
('240','gh_a8cdcaab89ce','ousfhjn9uVx21tZUHT1gbuRDDAxo','27.551790','109.951988','1170.00000','1440147892'),
('241','gh_a8cdcaab89ce','ousfhjjXOgqw43IM84huOlEBzKVc','27.550486','109.951324','840.000000','1440149683'),
('242','gh_a8cdcaab89ce','ousfhjhrbSgy64oGHGR1bv5mWZi8','27.523251','109.965370','960.000000','1440150292'),
('243','gh_a8cdcaab89ce','ousfhjvoe_j9KRtClYfyoCmbZZWU','27.550743','109.956192','40.000000','1440150996'),
('244','gh_a8cdcaab89ce','ousfhjnSMsxLZiIdmOE3-Wf1C5ho','27.483646','109.655685','120.000000','1440153734'),
('245','gh_a8cdcaab89ce','ousfhjkLsAVFnByAla8nAP2Knt3c','27.538248','109.990089','65.000000','1440159234'),
('246','gh_a8cdcaab89ce','ousfhjn9uVx21tZUHT1gbuRDDAxo','27.550949','109.954575','40.000000','1440166713'),
('247','gh_a8cdcaab89ce','ousfhjn9uVx21tZUHT1gbuRDDAxo','27.550974','109.954529','40.000000','1440167130'),
('248','gh_a8cdcaab89ce','ousfhjn9uVx21tZUHT1gbuRDDAxo','27.551029','109.954590','40.000000','1440167483'),
('249','gh_a8cdcaab89ce','ousfhjn9uVx21tZUHT1gbuRDDAxo','27.550976','109.954529','40.000000','1440167539'),
('250','gh_a8cdcaab89ce','ousfhjn9uVx21tZUHT1gbuRDDAxo','27.550974','109.954529','40.000000','1440167716'),
('251','gh_a8cdcaab89ce','ousfhjpH1CL1uHadAvtAI-WMPR_Q','27.554859','109.966919','65.000000','1440167971'),
('252','gh_a8cdcaab89ce','ousfhjsOx7e1kLZ_rGzXzuaLzjSk','27.552385','109.943306','40.000000','1440219834'),
('253','gh_a8cdcaab89ce','ousfhjigghrL9ZbyrgQft9f0wlZ0','30.192940','120.231361','65.000000','1440220761'),
('254','gh_a8cdcaab89ce','ousfhjhY6eZJqZQgwCWH-DHcKah0','27.545900','109.939995','65.000000','1440232964');m;o;n;
INSERT INTO `monxin_weixin_user_location` (`id`,`wid`,`openid`,`latitude`,`longitude`,`precision`,`time`) VALUES
('255','gh_a8cdcaab89ce','ousfhjsY8jcXcus_DZVsSLVySgBE','28.007725','110.196518','40.000000','1440241503'),
('256','gh_a8cdcaab89ce','ousfhjsY8jcXcus_DZVsSLVySgBE','28.007750','110.196495','40.000000','1440241898'),
('257','gh_a8cdcaab89ce','ousfhjkLsAVFnByAla8nAP2Knt3c','27.538448','109.990227','65.000000','1440256937'),
('258','gh_a8cdcaab89ce','ousfhjsqTA84xHFK8lKzTCio9F3g','27.539757','109.969246','90.000000','1440299715'),
('259','gh_a8cdcaab89ce','ousfhjsqTA84xHFK8lKzTCio9F3g','27.539759','109.969246','90.000000','1440300778'),
('260','gh_a8cdcaab89ce','ousfhjnih567W4JITh0H1hXknNdI','28.020506','110.200249','60.000000','1440373965'),
('261','gh_a8cdcaab89ce','ousfhjn9uVx21tZUHT1gbuRDDAxo','27.550974','109.954521','40.000000','1440420541'),
('262','gh_a8cdcaab89ce','ousfhjrk5sjUkjwZqNDfF2VvJEd8','27.519922','109.980301','70.146484','1440428081'),
('263','gh_a8cdcaab89ce','ousfhjkLsAVFnByAla8nAP2Knt3c','27.552282','109.953697','65.000000','1440658377'),
('264','gh_a8cdcaab89ce','ousfhjkLsAVFnByAla8nAP2Knt3c','27.552246','109.953644','65.000000','1440743176'),
('265','gh_a8cdcaab89ce','ousfhjve_rnW_WSItFJZfiHq0Jkk','27.550049','109.958694','90.000000','1440765748');m;o;n;
monxin_sql_end