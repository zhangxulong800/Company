monxin_sql_startDROP TABLE IF EXISTS `monxin_talk_content`;m;o;n;
CREATE TABLE `monxin_talk_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_id` int(11) NOT NULL COMMENT '所属帖子ID',
  `for` int(11) DEFAULT '0' COMMENT '如是评论则回帖ID',
  `content` text COMMENT '内容',
  `time` bigint(12) NOT NULL DEFAULT '0' COMMENT '时间',
  `username` varchar(30) DEFAULT NULL COMMENT '操作员',
  `ip` varchar(20) DEFAULT NULL COMMENT '操作IP',
  `update_username` varchar(30) DEFAULT NULL COMMENT '最后编辑人',
  `visible` int(1) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `email` int(1) NOT NULL DEFAULT '0' COMMENT '评论通知邮箱',
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=648 DEFAULT CHARSET=utf8 COMMENT='回贴/评论 内容';m;o;n;
INSERT INTO `monxin_talk_content` (`id`,`title_id`,`for`,`content`,`time`,`username`,`ip`,`update_username`,`visible`,`email`) VALUES
('547','518','0','我是回帖，哈哈哈','1419864554','test004','127.0.0.1','','1','0'),
('548','518','547','我是评论，呵呵呵','1419864597','test004','127.0.0.1','','1','0'),
('571','668','0','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;据《经济参考报》日前报道，高龄农民工群体正陷入“留城工作难找、返乡缺乏依靠”的困境：无论是留在城市里打拼“讨生活”，还是返乡继续“干农活”，都面临着养老保险、找工作、职业病等问题。国家统计局发布的《2016年农民工监测调查报告》显示，2016年农民工总量达到28171万人，50岁以上农民工所占比重为19.2%，过5000万。<br />
<br />
　　这是一个哀伤的话题。在本该颐养天年、含饴弄孙的年龄，大批高龄农民工却不得不远离家乡，来到工厂甚至建筑工地，从事最苦最累的重体力活。高龄农民工为了更容易找到工作，有的持假身份证留在工地;有的不断地走进理发室将自己的白发染黑;有的甚至“靠吃肉补充体力获打工资格，哪家工地肉多就去哪。<br />
<br />
　　但是他们有更多的选择吗？高龄农民工的背后，几乎都站着并不宽裕的家庭。因为年轻时不活泛，没有手艺或更好营生手段，年龄大了还得继续卖苦力谋生；或者因为没能让孩子上成大学并凭此改变家庭命运；或者因为孩子上了大学但找不到好工作家庭继续贫困。看到家庭并无见好的模样，看到家里人都缺钱，操劳大半辈子的农民不得以重新出山，虽然累一些，可总比眼看着家里人都缺钱没办法好啊。<br />','1502429653','monxin.com','192.168.28.233','','1','0'),
('552','662','0','weegrfhj','1449654553','test004','127.0.0.1','','1','0'),
('555','662','552','生日蛋糕','1449664376','test004','127.0.0.1','','0','0'),
('556','662','552','34234','1449664386','test004','127.0.0.1','','1','0'),
('557','662','0','asdf','1449664398','test004','127.0.0.1','','1','0'),
('558','662','552','gnv','1450506891','test004','192.168.28.112','','1','0'),
('559','662','0','cjj','1450509181','test004','192.168.28.112','','1','0'),
('560','662','552','gh','1450509194','test004','192.168.28.112','','1','0'),
('572','669','0','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;据《经济参考报》日前报道，高龄农民工群体正陷入“留城工作难找、返乡缺乏依靠”的困境：无论是留在城市里打拼“讨生活”，还是返乡继续“干农活”，都面临着养老保险、找工作、职业病等问题。国家统计局发布的《2016年农民工监测调查报告》显示，2016年农民工总量达到28171万人，50岁以上农民工所占比重为19.2%，过5000万。<br />
<br />
　　这是一个哀伤的话题。在本该颐养天年、含饴弄孙的年龄，大批高龄农民工却不得不远离家乡，来到工厂甚至建筑工地，从事最苦最累的重体力活。高龄农民工为了更容易找到工作，有的持假身份证留在工地;有的不断地走进理发室将自己的白发染黑;有的甚至“靠吃肉补充体力获打工资格，哪家工地肉多就去哪。<br />
<br />
　　但是他们有更多的选择吗？高龄农民工的背后，几乎都站着并不宽裕的家庭。因为年轻时不活泛，没有手艺或更好营生手段，年龄大了还得继续卖苦力谋生；或者因为没能让孩子上成大学并凭此改变家庭命运；或者因为孩子上了大学但找不到好工作家庭继续贫困。看到家庭并无见好的模样，看到家里人都缺钱，操劳大半辈子的农民不得以重新出山，虽然累一些，可总比眼看着家里人都缺钱没办法好啊。<br />','1502430283','monxin.com','192.168.28.233','','1','0'),
('563','664','0','mhjgfghjk','1454468752','apink','192.168.28.120','','1','0'),
('564','665','0','<img src=&#34;editor/plugins/emoticons/images/19.gif&#34; border=&#34;0&#34; alt=&#34;&#34; />','1454477836','monxin.com','192.168.28.120','','1','0'),
('565','664','563','342','1458979542','monxin.com','127.0.0.1','','1','0'),
('566','664','563','33','1458979553','monxin.com','127.0.0.1','','1','0'),
('567','664','563','kd','1502416817','monxin.com','192.168.28.233','','1','0'),
('568','664','0','<img src=&#34;editor/plugins/emoticons/images/20.gif&#34; border=&#34;0&#34; alt=&#34;&#34; />','1502417555','monxin.com','192.168.28.233','','1','0'),
('569','666','0','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;先介绍一下我家的具体情况吧，我是家中长子，我老家是南方沿海小农村，简称A，父亲、外公、外婆是老师，我爷爷奶奶是农民，我妈属于被牺牲的一代，未读书，小小的就负责我外公外婆一家的生活起居，后来我跟着邓公的改革开放口号外出打拼，赚了点小钱，我爸拉着我们定居在沿海二线城市，简称S城吧，现在我爸是一家私企的副总，我妈全职，有2个弟弟，自评家庭情况中等。','1502429293','monxin.com','192.168.28.233','','1','0'),
('570','667','0','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;婆婆总算回去了，其实她这个行程是早在春节之前就确定了的，要回去变卖公公留下来的房子。<br />
<br />
　　同住以来，对她太多太多的忍让。可是只换来她变本加厉的谩骂侮辱。“老公”甚至给我说，如果不和他妈同住，就要离婚。<br />
<br />
　　最后一次，我终于下定决心，离婚就离婚，只要能够不再和那样负面的人在一起就可以了。他却说他想通了，他妈妈不适合和我们住在一起。送走，然后回来之后如果我接受还一起住，如果我不接受他再另外安排他妈妈。那个时候，他还是希望我继续让他妈妈同我们住一起。我说我不会接受。然后他说给他三天时间他考虑。最后回复说和他妈妈分开住。<br />
<br />
　　昨天，回到家里。人还是那个人，气息却再也不同。他说他心里像少了一块，不完整了，需要时间调整，他甚至想过什么都不管，去一个陌生的城市呆一阵子。他说他每天下班回来，都会无意识的去开他妈妈房间的门，他说他非常后悔他和他妈妈的所有争吵。<br />
<br />
　　心里，一下子凉到谷底。我以为，我们能够回来。但是我知道，一切不一样。后悔太多东西，后悔和他结婚，后悔一起买房，后悔在最开始的时候答应他妈妈过来住。<br />
<br />
　　我不知道我以后要和他怎么过下去了。他说他需要调整，我不知道我是否也需要调整。他拒绝和我说话，拒绝和我拥抱，拒绝交流，甚至拒绝共同承担生活费用。好吧，其实我也能够养活自己，所差的不就是欠一些债吗？<br />
<br />
　　我想我也需要作一些调整了，工资拿一部分存起来还债，另外一部分自己生活，以及，投资自己。总有一天，我会有离开他的勇气。<br />','1502429420','monxin.com','192.168.28.233','','1','0'),
('573','670','0','rgu','1502432903','monxin.com','192.168.28.175','','1','0'),
('574','667','570','理解','1502433096','monxin.com','192.168.28.233','','0','0'),
('575','667','570','什么人呢','1502433116','monxin.com','192.168.28.233','','1','0'),
('576','667','0','liii','1502433147','monxin.com','192.168.28.233','','1','0'),
('577','667','570','5555','1502434041','monxin.com','192.168.28.233','','1','0'),
('579','667','576','99','1502435461','monxin.com','192.168.28.233','','1','0'),
('580','669','0','4rr','1502437747','monxin.com','192.168.28.177','','1','0'),
('601','667','0','111&nbsp;&nbsp;&nbsp;&nbsp;','1502540531','monxin.com','::1','','1','0'),
('582','667','0','44<br />
<br />','1502439437','monxin.com','192.168.28.177','','1','0'),
('600','667','576','月','1502529404','monxin.com','192.168.28.233','','1','0'),
('584','666','569','11111111','1502442524','monxin.com','::1','','1','0'),
('585','666','569','jyxz','1502442539','monxin.com','::1','','1','0'),
('586','666','0','测试&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','1502520641','monxin.com','::1','','1','0'),
('587','666','0','我去','1502522345','monxin.com','::1','','1','0'),
('588','666','586','444','1502522721','monxin.com','::1','','1','0'),
('589','666','0','<img src=&#34;program/talk/attachd/image/20170812/20170812153246_54145.jpg&#34; alt=&#34;&#34; />','1502523171','monxin.com','::1','','1','0'),
('590','667','582','555','1502524096','monxin.com','192.168.28.233','','1','0'),
('591','667','582','555','1502524125','monxin.com','192.168.28.233','','1','0'),
('592','667','582','66','1502524142','monxin.com','192.168.28.233','','1','0'),
('593','667','582','77','1502524163','monxin.com','192.168.28.233','','1','0'),
('594','666','0','哥哥','1502524751','','192.168.28.175','','1','0'),
('595','666','0','4534','1502524786','monxin.com','::1','','1','0'),
('596','666','0','444','1502524797','monxin.com','192.168.28.233','','1','0'),
('597','666','0','测试&nbsp;&nbsp;&nbsp;&nbsp;','1502526779','monxin.com','::1','','1','1'),
('598','666','597','3444','1502526789','monxin.com','::1','','1','0'),
('602','667','0','222','1502540680','monxin.com','::1','','1','0'),
('603','667','0','333','1502540725','monxin.com','::1','','1','0'),
('604','667','0','44&nbsp;&nbsp;&nbsp;&nbsp;','1502540968','monxin.com','::1','','1','0'),
('605','667','0','55','1502541005','monxin.com','::1','','1','0'),
('606','667','0','66<br />','1502541189','monxin.com','::1','','1','0'),
('607','667','602','2b','1502541917','monxin.com','::1','','1','0');m;o;n;
INSERT INTO `monxin_talk_content` (`id`,`title_id`,`for`,`content`,`time`,`username`,`ip`,`update_username`,`visible`,`email`) VALUES
('608','667','603','3b','1502542159','monxin.com','::1','','1','0'),
('609','667','603','3c','1502542253','monxin.com','::1','','1','0'),
('610','667','603','3e','1502542426','monxin.com','::1','','1','0'),
('611','667','603','3f','1502542564','monxin.com','::1','','1','0'),
('612','667','603','3g','1502542709','monxin.com','::1','','1','0'),
('613','667','603','3q','1502542749','monxin.com','::1','','1','0'),
('614','667','603','3w','1502542816','monxin.com','::1','','1','0'),
('615','667','606','61','1502542834','monxin.com','::1','','1','0'),
('616','667','605','51','1502542926','monxin.com','::1','','1','0'),
('617','667','605','52','1502542942','monxin.com','::1','','1','0'),
('618','667','606','62','1502543271','张三','127.0.0.1','','1','0'),
('619','667','606','63','1502543293','张三','127.0.0.1','','1','0'),
('620','667','0','<img src=&#34;program/talk/attachd/image/20170812/20170812210828_14356.jpg&#34; alt=&#34;&#34; />','1502543313','张三','127.0.0.1','','1','0'),
('621','667','0','<img src=&#34;editor/plugins/emoticons/images/2.gif&#34; border=&#34;0&#34; alt=&#34;&#34; />','1502543488','张三','127.0.0.1','','1','0'),
('622','667','0','<img src=&#34;editor/plugins/emoticons/images/1.gif&#34; border=&#34;0&#34; alt=&#34;&#34; />','1502543517','张三','127.0.0.1','','1','0'),
('623','667','0','<img src=&#34;editor/plugins/emoticons/images/3.gif&#34; border=&#34;0&#34; alt=&#34;&#34; />','1502543539','monxin.com','::1','','1','0'),
('624','667','0','<img src=&#34;editor/plugins/emoticons/images/13.gif&#34; border=&#34;0&#34; alt=&#34;&#34; />','1502543783','monxin.com','192.168.28.175','','1','0'),
('625','667','0','<img src=&#34;program/talk/attachd/image/20170812/20170812211659_34098.jpg&#34; alt=&#34;&#34; />','1502543825','monxin.com','192.168.28.175','','1','0'),
('626','667','0','ttty','1502543859','monxin.com','192.168.28.175','','1','0'),
('627','667','0','tt','1502544012','monxin.com','192.168.28.175','','1','0'),
('628','667','0','ghg','1502544032','monxin.com','192.168.28.175','','1','0'),
('629','667','0','yhh','1502544082','monxin.com','192.168.28.175','','1','0'),
('630','667','0','fh','1502544359','monxin.com','192.168.28.175','','1','0'),
('631','667','0','<img src=&#34;editor/plugins/emoticons/images/44.gif&#34; border=&#34;0&#34; alt=&#34;&#34; />','1502544381','monxin.com','192.168.28.175','','1','0'),
('633','667','0','<img src=&#34;editor/plugins/emoticons/images/13.gif&#34; border=&#34;0&#34; alt=&#34;&#34; />','1502544586','monxin.com','192.168.28.175','','1','0'),
('634','667','0','<img src=&#34;program/talk/attachd/image/20170812/20170812213003_35065.jpg&#34; alt=&#34;&#34; />','1502544612','monxin.com','192.168.28.175','','1','0'),
('635','667','0','ze','1502544628','monxin.com','192.168.28.175','','1','0'),
('636','667','0','月','1502544867','张三','127.0.0.1','','1','0'),
('637','667','0','ii&nbsp; &nbsp; d&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','1502544960','monxin.com','::1','','0','0'),
('638','667','637','qw','1502544976','monxin.com','::1','','1','0'),
('639','667','0','tup','1502545014','monxin.com','192.168.28.175','','1','0'),
('640','667','0','555','1502548169','monxin.com','::1','','1','0'),
('643','667','0','56','1502548494','张三','127.0.0.1','','1','0'),
('644','671','0','55','1502550604','monxin.com','192.168.28.233','','1','0'),
('645','673','0','55','1502551160','monxin.com','192.168.28.233','','1','0'),
('646','674','0','55','1502551198','monxin.com','192.168.28.233','','1','0'),
('647','675','0','55','1502551229','monxin.com','192.168.28.233','','1','0');m;o;n;
DROP TABLE IF EXISTS `monxin_talk_title`;m;o;n;
CREATE TABLE `monxin_talk_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL COMMENT '标题',
  `type` int(11) NOT NULL COMMENT '所属分类ID',
  `sequence` int(5) NOT NULL DEFAULT '0' COMMENT '排序',
  `username` varchar(30) DEFAULT NULL COMMENT '发帖人',
  `time` bigint(12) NOT NULL DEFAULT '0' COMMENT '时间',
  `last_username` varchar(30) DEFAULT NULL COMMENT '最后编辑人',
  `last_time` bigint(12) NOT NULL DEFAULT '0' COMMENT '最后编辑时间',
  `ip` varchar(20) DEFAULT NULL COMMENT '发帖IP',
  `last_ip` varchar(20) DEFAULT NULL COMMENT '最后回帖IP',
  `visible` int(1) NOT NULL DEFAULT '1' COMMENT '显示状态',
  `key` varchar(300) DEFAULT NULL COMMENT '关联KEY',
  `visit` int(11) NOT NULL DEFAULT '0' COMMENT '访问量',
  `contents` int(5) NOT NULL DEFAULT '0' COMMENT '内容',
  `email` int(1) NOT NULL DEFAULT '0' COMMENT '回帖通知邮箱',
  `reply_time` bigint(12) NOT NULL DEFAULT '0' COMMENT '最后回帖时间',
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `key` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=681 DEFAULT CHARSET=utf8 COMMENT='梦行谈谈 主贴';m;o;n;
INSERT INTO `monxin_talk_title` (`id`,`title`,`type`,`sequence`,`username`,`time`,`last_username`,`last_time`,`ip`,`last_ip`,`visible`,`key`,`visit`,`contents`,`email`,`reply_time`) VALUES
('668','5000万高龄民工靠什么养老？','92','0','monxin.com','1502429653','','0','192.168.28.233','','1',',','1','1','0','1502429653'),
('671','55','83','0','monxin.com','1502550604','','0','192.168.28.233','','1',',','1','1','0','1502550604'),
('670','yyy','91','0','monxin.com','1502432903','','0','192.168.28.175','','1',',','2','1','0','1502432903'),
('669','5000万高龄民工靠什么养老？','82','0','monxin.com','1502430283','','0','192.168.28.233','','1',',','11','2','0','1502437747'),
('666','娶了一个心机婊 该如何翻盘','83','0','monxin.com','1502429293','','0','192.168.28.233','','1',',','69','12','0','1502526789'),
('667','老公说他需要调整','83','0','monxin.com','1502429420','','0','192.168.28.233','','1',',','212','52','0','1502548494'),
('672','444','83','0','monxin.com','1502551077','','0','::1','','1',',','1','0','0','0'),
('673','556','83','0','monxin.com','1502551160','','0','192.168.28.233','','1',',','1','1','0','1502551160'),
('674','5567','83','0','monxin.com','1502551198','','0','192.168.28.233','','1',',','1','1','0','1502551198'),
('675','55678','83','0','monxin.com','1502551229','','0','192.168.28.233','','1',',','1','1','0','1502551229'),
('676','ujj','83','0','monxin.com','1502551302','','0','192.168.28.175','','1',',','1','0','0','0'),
('677','ujjhjjfghu','83','0','monxin.com','1502551329','','0','192.168.28.175','','1',',','1','0','0','0'),
('678','fhh','83','0','monxin.com','1502551378','','0','192.168.28.175','','1',',','1','0','0','0'),
('679','感觉据我','83','0','monxin.com','1502551456','','0','192.168.28.175','','1',',','1','0','0','0'),
('680','配合刚刚','83','0','monxin.com','1502551584','','0','192.168.28.175','','1',',','1','0','0','0');m;o;n;
DROP TABLE IF EXISTS `monxin_talk_type`;m;o;n;
CREATE TABLE `monxin_talk_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '名称',
  `parent` int(11) NOT NULL COMMENT '父级ID',
  `sequence` int(5) NOT NULL DEFAULT '0' COMMENT '排序',
  `visible` int(1) NOT NULL DEFAULT '1' COMMENT '显示状态',
  `read_power` text COMMENT '读权限',
  `title_power` text COMMENT '发帖权限',
  `content_power` text COMMENT '回帖权限',
  `manager` varchar(30) DEFAULT NULL COMMENT '管理员(版主)',
  `title_sum` int(11) NOT NULL DEFAULT '0' COMMENT '累计主帖',
  `day_title_sum` int(11) NOT NULL DEFAULT '0' COMMENT '当天主帖',
  `content_sum` int(11) NOT NULL DEFAULT '0' COMMENT '累计回帖',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 COMMENT='梦行谈谈 分类';m;o;n;
INSERT INTO `monxin_talk_type` (`id`,`name`,`parent`,`sequence`,`visible`,`read_power`,`title_power`,`content_power`,`manager`,`title_sum`,`day_title_sum`,`content_sum`) VALUES
('82','民生','0','0','1','0|1|13|64|54|57|59|60|61|62|63|65|52|69|70|','1|13|54|57|59|60|61|62|63|52|53|','1|13|54|57|59|60|61|62|63|52|53|','monxin.com','1','0','3'),
('83','情感','0','0','1','0|','1|13|64|54|57|59|60|61|62|63|65|52|69|70|','1|13|64|54|57|59|60|61|62|63|65|52|69|70|','monxin.com','12','10','68'),
('85','美食','0','0','1','0|','1|13|54|57|59|60|61|62|63|52|53|','1|13|54|57|59|60|61|62|63|52|53|','monxin.com','0','0','0'),
('87','旅游','0','0','1','0|1|13|64|54|57|59|60|61|62|63|65|52|69|70|','1|13|64|54|57|59|60|61|62|63|65|52|69|70|','1|13|64|54|57|59|60|61|62|63|65|52|69|70|','monxin.com','0','0','0'),
('88','人文','0','0','1','0|1|13|64|54|57|59|60|61|62|63|65|52|69|70|','1|13|64|54|57|59|60|61|62|63|65|52|69|70|','1|13|64|54|57|59|60|61|62|63|65|52|69|70|','monxin.com','0','0','0'),
('89','游戏','0','0','1','0|1|13|64|54|57|59|60|61|62|63|65|52|69|70|','1|13|64|54|57|59|60|61|62|63|65|52|69|70|','1|13|64|54|57|59|60|61|62|63|65|52|69|70|','monxin.com','0','0','0'),
('90','汽车汽车汽车汽车汽车汽车汽车汽车','0','0','1','0|1|13|64|54|57|59|60|61|62|63|65|52|69|70|','1|13|64|54|57|59|60|61|62|63|65|52|69|70|','1|13|64|54|57|59|60|61|62|63|65|52|69|70|','monxin.com','0','0','0'),
('91','时尚','0','0','1','0|1|13|64|54|57|59|60|61|62|63|65|52|69|70|','1|13|64|54|57|59|60|61|62|63|65|52|69|70|','1|13|64|54|57|59|60|61|62|63|65|52|69|70|','monxin.com','1','1','1');m;o;n;
monxin_sql_end