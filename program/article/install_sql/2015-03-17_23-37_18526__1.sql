monxin_sql_startDROP TABLE IF EXISTS `monxin_article_article`;m;o;n;

CREATE TABLE `monxin_article_article` (
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
  `tag` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=224 DEFAULT CHARSET=utf8;m;o;n;

INSERT INTO `monxin_article_article` (`id`,`title`,`content`,`src`,`type`,`sequence`,`visible`,`editor`,`time`,`visit`,`link`,`tag`) VALUES
('223','aesdasd','asfd','','69','0','1','4','1418313370','6','','sDF|xdfas|sdf'),
('208','离DIY智能手机不远了：Project Ara开发者大会4月15日召开','<span style=&#34;background-color:;&#34;>&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=&#34;background-color:;&#34;>还有人记得Project Ara吗？这是由摩托罗拉提出的一个计划项目，它是一个开放且能高度模块化的智能手机平台，该平台能让用户像DIY电脑一样DIY自己的手机。包括新的应用处理器、屏幕、摄像头甚至脉搏血氧仪等等，只要是功能模块化的硬件，都可以按照自己的需求和个性化搭配。</span><br />
<span style=&#34;background-color:;&#34;>&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=&#34;background-color:;&#34;>这种如同搭积木一样的概念性手机设计，原本就很“科幻”，不易实现，再加上摩托罗拉被联想收购，在有些人眼中Project Ara项目似乎变得更是遥遥无期了。</span><br />
<span style=&#34;background-color:;&#34;>&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=&#34;background-color:;&#34;>但是事实并非如此，这只技术先进的项目团队目前已归属谷歌，在工作上他们仍开足马力奋力前进，而在今天，他们更是出来宣布第一个Ara开发者大会将于4月15日-16日举行。注册者可以通过直播视频参与并提问，还有少数被挑选出来的人，将有机会出席在加州山景城计算机历史博物馆举办的会议。</span><br />
<span style=&#34;background-color:;&#34;>&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=&#34;background-color:;&#34;>本次会议重点将放在Ara模块开发者工具包alpha版本上，它将给开发Ara模块的开发者带来工具，这应该会出现在发布会前，也就是四月初的某个时候，以便人们有时间熟悉并准备像样的反馈。</span><br />
<span style=&#34;background-color:;&#34;>&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=&#34;background-color:;&#34;>尽管会议是为开发者准备的，但其它人只要在这里注册，便可自由地观看现场视频，值得一提的是在线参与是免费的。</span><br />','','68','0','1','4','1393469822','7','',''),
('209','果合报告：iOS趋势及手游开发六大核心策略','<span style=&#34;background-color:;&#34;>&nbsp;&nbsp;&nbsp;&nbsp;国内移动应用广告平台果合发布了2013年年度报告，梳理了2013年中国iOS市场发展的基本脉络和2014年中国手游开发六大核心策略。<br />
&nbsp;&nbsp;&nbsp;&nbsp;报告以其旗下产品“智游汇MIX”所提供的数亿次插屏广告大数据为基础。2013年中国iOS市场发展的基本脉络主要研究发现如下：<br />
&nbsp;&nbsp;&nbsp;&nbsp;中国人晚上9点10点最爱玩手机，85%的用户选择 Wi-Fi 网络下打开手机应用；<br />
&nbsp;&nbsp;&nbsp;&nbsp;2013年苹果推出的iPhone 5S 表现出色，但iPhone 4/4S 仍占据市场主要份额，占比超60%；中国iOS用户系统更新速度加快，iOS 7发布两周市场占比已达30%；目前iOS 7份额达75%以上；<br />
&nbsp;&nbsp;&nbsp;&nbsp;iOS 7 推出后中国越狱用户大幅减少，国内移动用户已不再盲目追求盗版、越狱、破解等；<br />
&nbsp;&nbsp;&nbsp;&nbsp;移动插屏广告点击率、转化率高于 Banner 等广告形式。<br />
</span>&nbsp;&nbsp;&nbsp;&nbsp;结合以上结论及其长期在手机游戏市场的深入洞察，果合发布了2014年中国手游开发应当采用以下六大核心策略：<br />
<span style=&#34;background-color:;&#34;><br />
一、抓住iOS用户活跃最高峰<br />
&nbsp;&nbsp;&nbsp;&nbsp;国内用户使用游戏APP的高峰时段位于每天晚上的8点到11点。开发者可以将高峰时段作为市场营销与活动运营的重要时间节点。<br />
<br />
二、增加单机游戏的弱联网属性<br />
&nbsp;&nbsp;&nbsp;&nbsp;中国iOS用户更习惯于在 Wi-Fi 环境下玩游戏，在此趋势下：单机游戏开发者使游戏具备弱联网属性，增加游戏的排名、对战和交互性能，将能有效提升用户粘度和使用时间。果合分析认为，单机游戏的弱联网化将是2014年游戏开发的重要热点。<br />
<br />
三、iOS开发仍需考虑旧机型、软件更新需要提前准备<br />
&nbsp;&nbsp;&nbsp;&nbsp;虽然2013年苹果推出的iPhone 5S 等新机型表现出色，但统计显示：2013年iPhone 4/4S 合计市场份额仍超过60%，APP开发者仍需考虑 iPhone 4/4S 技术规格来开发游戏，或针对不同设备推出更具针对性的产品。<br />
</span>&nbsp; &nbsp;&nbsp;数据显示，iOS 7 发布一周，其市场份额就达到30%；发布后两个月，市场份额超50%。这折射出开发者在应对苹果系统升级方面需要尽早入手，提前准备。<span style=&#34;background-color:;&#34;><br />
<br />
四、转变越狱功能核心价值<br />
&nbsp;&nbsp;&nbsp;&nbsp;在当前中国iOS用户越狱比例逐步下降的趋势下，开发者应逐步转变越狱工具的使用理念。由于 app store 审核困难：未来使用越狱工具在APP上线前进行审核和测试，将成为中国越狱工具的核心价值。<br />
<br />
五、优化移动广告投放最大化开发收益<br />
&nbsp;&nbsp;&nbsp;&nbsp;目前中国只有3到5款iOS单机游戏在IAP（应用内付费）方面表现亮眼；绝大多数开发者收入来源仍以 in-app 广告为主。目前主流广告形式包括 Banner、插屏、积分墙推荐等，如何结合不同游戏形式，实现用户体验与广告收入最大化之间的最佳平衡将成为游戏开发者创造收入的首要思考议题。<br />
<br />
六、内容为王：回归到游戏本身<br />
&nbsp;&nbsp;&nbsp;&nbsp;近期，“萌将无双”、“幻想英雄”等游戏因涉及刷榜及“换皮”被苹果下架，而“梦想海贼王”则因为无IP授权也被突然下架；此外，近日苹果谷歌还同时加强了应用ASO审核，包括禁用所有带“Flappy”的应用（以利用“爆红游戏 Flappy Bird”的知名度营销）。种种脉动都说明游戏开发者仍需做好自身内容，这样才能在竞争更加激烈的2014年立于不败之地。（下图）<br />
<br />
</span><span style=&#34;background-color:;&#34;></span><br />','','67','0','1','4','1393469949','1','',''),
('210','当64bit遇上8核心：高通发布Snapdragon 615','<span style=&#34;background-color:;&#34;>&nbsp;&nbsp;&nbsp;&nbsp;高通近日宣布将扩展骁龙600系列处理器，新增高通骁龙610和615芯片组，用于高端移动计算终端。这两款全新芯片组集成美国高通技术公司第三代LTE调制解调器，支持Category 4的数据速率，满足包括LTE-Broadcast和LTE双卡双通（DSDA）等新要求。骁龙610和615芯片组旨在搭配美国高通技术公司RF360前端解决方案，支持OEM厂商推出可覆盖全球所有主要频段及制式的单一5模全球LTE SKU，这也是当今竞争激烈的手机市场的要求。除了支持LTE 外，这两款芯片组还集成了关键的3G技术，包括HSPA +（速度最高可达42Mbps）、CDMA和TD-SCDMA 。<br />
&nbsp;&nbsp;&nbsp;&nbsp;骁龙615芯片组是移动行业首款集成LTE和64位功能的商用八核解决方案，而骁龙 610芯片组则采用四核处理技术支持LTE和64位功能。凭借骁龙 610和615芯片组的推出，以及最近发布的骁龙410 芯片组，美国高通技术公司的产品组合已包含一系列64位4G LTE解决方案的强大阵容。骁龙 615 、610和410芯片组还支持ARMv8——最新的面向ARM兼容终端的指令集。ARMv8架构提供了最具能效的执行方式，同时保持兼容现有的32位软件。骁龙615 、610和410芯片组旨在最小化OEM厂商的开发成本，同时加速产品的开发和上市步伐。这三款芯片组管脚兼容，支持相同的Qualcomm电源管理、音频、Wi-Fi、蓝牙、射频和RF360解决方案，支持可扩展但一致的硬件设计。这三款芯片组采用的相同软件也具有可扩展性，包括支持64位ARMv8 CPU。此外，每款&nbsp;&nbsp;&nbsp;&nbsp;GPU不仅能提供卓越的图形性能，而且还支持最新的移动图形API（如DirectX 11.2和Open GL ES3.0），同时支持硬件加速几何着色和硬件曲面细分，带来更加细致、真实的移动游戏和炫丽的用户界面。Adreno 405还支持Full Profile OpenCL，实现卓越的GPGPU计算、视频和图像处理功能。显示引擎支持最高QHD（分辨率为2560x1600）的显示屏，并支持Miracast多媒体内容无线串流。通过内置H.265硬件解码器和集成Qualcomm VIVE™ 802.11ac Wi-Fi和蓝牙4.1的解决方案，无线内容可以实现高效传输。<br />
&nbsp;&nbsp;&nbsp;&nbsp;美国高通技术公司执行副总裁兼QCT联席总裁Murthy Renduchintala 表示：“美国高通技术公司通过提供业界领先的LTE调制解调器、64位多核处理和卓越的多媒体性能这三项无以伦比的组合，重新定义了高端移动终端的用户体验。64位处理能力是当今行业对这一层级处理器的要求，同时我们还通过在骁龙 600系列芯片组中提供八核和四核两种配置，并集成卓越的Adreno 405图形性能和功能强大的整套连接技术，来满足客户的需求。”<br />
&nbsp;&nbsp;&nbsp;&nbsp;美国高通技术公司还计划推出骁龙610和615处理器的参考设计（QRD）版本，在基于骁龙200和400处理器的QRD基础上，扩展广泛的QRD产品组合，以支持全新终端系列。QRD计划提供美国高通技术公司领先的技术创新、差异化的软硬件、能够节省客户技术成本和开发时间的便捷定制选项、由硬件元器件供应商和软件应用开发商构成的生态系统以及满足地区运营商需求的预测试和预验证。通过QRD计划，OEM厂商可以快速推出面向价格敏感的消费者的差异化智能手机。骁龙610和615芯片组的QRD版本预计将在2014年第四季度上市。<br />
</span><span style=&#34;background-color:;&#34;><br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
</span><br />','','67','0','1','4','1393470007','9','',''),
('211','深圳Maker Faire创客市集：国内外创客组团来参展','<span style=&#34;background-color:;&#34;><span&#34;>&nbsp;&nbsp;&nbsp;&nbsp;4月6日，由Seeed Studio、CSDN、雷锋网联合主办的2014深圳Maker Faire将在蛇口南海意库开幕，这也是国内首次举办的城市级Maker Faire。对于许多熟知Maker Faire的人来说，最吸引人的不仅仅是创客牛人启发心灵的演讲，创客市集上展出的各种关乎设计、生活、个人兴趣、艺术的创意产品更令人兴奋。</span><br />
<span > &nbsp;&nbsp;&nbsp;&nbsp;深圳Maker Faire向创客、创新硬件厂商、开源硬件开发商、3D打印、机器人开发团队等提供创客摊位。众多来自世界各地的创客和他们的作品，将汇聚于此，据说还将会有许多英国的创客会组团来参展。今年除了以Arduino为代表的开源硬件以外，观众还会看到一大波机器人作品跳上深圳Maker Faire的舞台。</span><br />
</span><span&#34;>&nbsp;&nbsp;&nbsp;&nbsp;比如由国内首本Arduino著作《Arduino开发实战指南》、《自律型机器人制作入门》、《Arduino电子设计实战指南：零基础篇》作者程晨。他曾做过wifi监控小车“闪开”、在小玩具蜘蛛机器人的基础上加以改进而来的蜘蛛坦克、通过脑电波来控制歌曲播放的脑控音乐播放器等有趣的作品。他还会带来更多有创意的作品来到Maker Faire。</span><span style=&#34;background-color:;&#34;><br />
<span> &nbsp;&nbsp;&nbsp;&nbsp;机器人对于许多人来说或许看起来很远，实则近在眼前，乐高就是很好的例子。在创客市集上，您还会看到这样一支团队，他们提供让人们动手去实现自己想法的积木式搭建平台，让用户可以用简单易用的模块像搭积木一样搭建出各种机器人、小型机械、艺术装置、产品原型等，而且它还兼容多种控制器和传感器如Arduino和乐高NXT控制器。而且这些由MakeBlock搭建的作品，还可与移动终端进行交互。</span><br />
<span> &nbsp;&nbsp;&nbsp;&nbsp;我们在去年办过Go Mobile智能硬件沙龙、HAXLR8on硬件Hackathon、索尼Smart Watch 2硬件Hackathon，以及MDCC智能硬件展。不论是从创客兴趣转化而来的作品，还是面向小众市场的产品，在这些活动中，我们看到了上百个硬件作品。还记得去年年初我们举办智能硬件沙龙在柴火创客空间看到的脑波控制飞行器Puzzlebox Orbit么？它的开发者张浩也会参与创客市集，带来全新的惊喜。</span><br />
<span> &nbsp;&nbsp;&nbsp;&nbsp;RoboPeak也是国内机器人及相关技术领域非常资深的团队，自2009年起他们就开始设计研发民用机器人平台系统、机器人操作系统(ROS)以及相关设备，供低成本高精度的激光定位测距、室内定位与自主地图测绘、机器人导航的全套解决方案。</span><br />
<span> &nbsp;&nbsp;&nbsp;&nbsp;同时还有PVC-BOT带来的“低成本、易实现”机器人项目，由UFactory带来的基于ABB工业机械臂为原型的uArm开源桌面型机械臂等更多产品也会参与创客市集。</span><br />
<span> &nbsp;&nbsp;&nbsp;&nbsp;除此之外，3D打印也将是本次创客市集的一大亮点，包括Weistek、Mostfun、Tunk3D、Mbot、理迪、小盒3D打印等团队，而且Makerbot的全球代理BRULE也会带来最新的3D打印机。</span><br />
<span> &nbsp;&nbsp;&nbsp;&nbsp;在创客市集上，除了可以看到这些Geek十足的产品以外，还有丰富的小彩蛋等待参观者自己去发现。Seeed Studio团队的小伙伴们设计并制作出十二款Maker Style的十二生肖形象贴纸，藏在市集中的不同摊位里。</span><br />
<span> &nbsp;&nbsp;&nbsp;&nbsp;目前，将在深圳Maker Faire创客市集摊位申请已经超额，更多通过申请的创客摊位还将陆续亮相，欢迎围观Maker Faire官网。前500位注册观展用户，现场签到有神秘礼物赠送！</span><br />
</span><span style=&#34;background-color:;&#34;><br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
</span><br />','','68','0','1','4','1395903594','23','',''),
('212','腾讯正式发布QQ浏览器微信版','<span style=&#34;background-color:;&#34;>&nbsp;&nbsp;&nbsp;&nbsp;近日，腾讯正式对外发布了QQ浏览器微信版，新版本聚焦办公场景，主打“边上网边聊微信”。并着重优化了微信网页版的诸多不足，尤其加强了微信作为办公工具的诸多功能。但是，微信朋友圈等功能还没有在PC端对外开放。<br />
&nbsp;&nbsp;&nbsp;&nbsp;相比之前的微信网页版，全新的QQ浏览器微信版将微信与浏览器进行了深度结合，不仅在办公效率上有着很大程度的提升，而且还支持以拖拽的方式，极大地改善了内容分享等多个功能。此外，还能将聊天内容同步到手机上，并用一个小红点对新内容或新信息进行“无扰式”提醒。<br />
&nbsp;&nbsp;&nbsp;&nbsp;主要功能包括：<br />
&nbsp;&nbsp;&nbsp;&nbsp;微信插件：微信侧栏与网页并存，更自然地边上网边微信（F4键随时隐藏微信界面）<br />
&nbsp;&nbsp;&nbsp;&nbsp;消息提醒：明显的新消息提醒，更快捷地查看和回复<br />
&nbsp;&nbsp;&nbsp;&nbsp;拖拽分享：网页图片/文字，拖一下就能发送给好友<br />
&nbsp;&nbsp;&nbsp;&nbsp;公众号收起：聊天时零打扰，阅读时更专注<br />
&nbsp;&nbsp;&nbsp;&nbsp;看图看视频更流畅：全屏看高清图，独立窗口看视频<br />
&nbsp;&nbsp;&nbsp;&nbsp;腾讯MIG浏览器产品部副总经理钟学丹表示，多屏合一的交互体验，是移动互联网发展的必然趋势， “不要一个屏在战斗”将成为更多微信用户的选择，但当下，频繁的屏幕切换仍然是白领人群最大的困扰之一。不少办公族都需要一边盯着手机看微信群里是否漏掉了领导的工作指示，一边要在电脑上进行文档写作和阅读工作。而此次QQ浏览器微信版最大变化就在于，通过侧边栏聊天框的模式，解决了此前微信网页版只能聊天，不能同时做其他工作的难题，可以实现“提升工作效率，办公聊天两不误”。<br />
</span><span style=&#34;background-color:;&#34;><br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
</span><br />','','68','0','1','4','1393470176','16','',''),
('213','《近匠》UPYUN——从开发者变为服务者','<span style=&#34;background-color:;&#34;>&nbsp;&nbsp;&nbsp;&nbsp;UPYUN（又拍云）专注于为互联网和移动互联网创业者提供非结构化数据的云存储、云处理和云分发服务。UPYUN的创业过程经历了三个阶段：2005年创办又拍网，是一个类似Flickr的个人相册产品；到2010年初，基于对又拍网用户需求的分析整理，我们发现电商、个人网站、外贸等行业对又拍网的使用有更高的需求，如图片外链、不限流量、缩略图、防盗链、打水印等等，继而上线了又拍图片管家的服务，这一阶段的业务范畴主要集中在图片云计算上；到2011年，我们接触到音频、视频类的客户越来越多，于是经过几个月的开发调试，上线了成熟版的UPYUN平台，业务范畴扩大到针对所有的静态文件，包括图片、音频、视频、js、css和各种小文件，等等。至今，累计为超过4万家企业提供付费云计算服务，其中不乏唱吧、捕鱼达人、蘑菇街、多看阅读、天天动听、知乎、等知名应用与网站。<br />
&nbsp;&nbsp;&nbsp;&nbsp;CSDN移动：为什么要做这样一个产品？开发者有什么样的需求？<br />
&nbsp;&nbsp;&nbsp;&nbsp;我们最初的创业项目是又拍网，我们发现当时无法在国内找到一个靠谱的基础云服务。为了解决静态数据的存储、处理和分发于一体的问题，所以我们自己在这方面投入了很大的精力。而又拍网的业务发展，却又因此错失最佳的时机。这一直是我们心里的遗憾：如果当时有一家类似UPYUN的基础云服务，又拍网今天的成就一定会更大。<br />
&nbsp;&nbsp;&nbsp;&nbsp;当然，失之东隅而收之桑榆。在今天看来，之前在又拍网基础设施架构上的投入，恰好为UPYUN的基础架构提前做好了布局，这是我们始料未及的。而正是由于我们自己曾经作为互联网项目创业者对基础云服务这方面业务的强烈需求，使我们更加了解创业者真正需要什么。<br />
&nbsp;&nbsp;&nbsp;&nbsp;CSDN移动：这个工具是针对移动开发的哪一个环节？在这个环节中，现在是一种什么状况？<br />
&nbsp;&nbsp;&nbsp;&nbsp;UPYUN主要是帮助用户解决静态数据的托管问题，其中包括开发过程中静态数据的上传、处理和下载的体验。UPYUN服务贯穿于整个产品开发过程和终端用户的使用体验中。<br />
&nbsp;&nbsp;&nbsp;&nbsp;上传环节：用户可以通过FTP、API和表单API三种方式进行数据上传。<br />
&nbsp;&nbsp;&nbsp;&nbsp;处理环节：用户上传数据的过程中，可以通过UPYUN的相关接口对图片、音频和视频进行处理。<br />
&nbsp;&nbsp;&nbsp;&nbsp;下载环节：将用户的静态数据推送到UPYUN的各地节点。终端用户请求产品静态数据时，直接从当地节点取数据。<br />
&nbsp;&nbsp;&nbsp;&nbsp;CSDN移动： 做了多久？什么时候推出的？<br />
</span>&nbsp;&nbsp;&nbsp;&nbsp;真正转型开始做基础云服务，是2010年初开始做针对图片业务的UPYUN，至今已经有4年时间。<span style=&#34;background-color:;&#34;><br />
&nbsp;&nbsp;&nbsp;&nbsp;CSDN移动： 从第一个内测版本到现在，您们做了些什么？<br />
&nbsp;&nbsp;&nbsp;&nbsp;实际上，从05年创业开始直到09年，我们所有的需求就是满足又拍网的需求，又拍网的产品形态决定了我们最初的需求都是针对图片的，包括图片的存储、处理和CDN加速。<br />
<br />
&nbsp;&nbsp;&nbsp;&nbsp;又拍网是UGC类型的个人相册，在存储过程中我们需要考虑到异地用户的上传速度，于是我们开发了分布式存储架构，让用户能够通过所在地的就近节点上传数据，提升数据上传的速度；此外，用户上传后，需要对图片做一些处理，如图片缩略图、防盗链等，于是我们增加了图片处理功能；最后，用户图片上传到相册后，可能会给自己的亲朋好友浏览，这就涉及到各地用户的下载问题，于是我们自建了静态数据的CDN分发通道，用于数据下载加速。又拍在图片管家时期，靠这“三板斧”也基本能够满足用户的使用需求了。<br />
&nbsp;&nbsp;&nbsp;&nbsp;到2010年初，针对图片业务的UPYUN平台上线之后，我们又陆续接触到了更多其他类型的客户。他们对音频、视频的处理需求很大，如唱吧、天天动听旗下的天天秀场等，于是我们又研发了音视频的转码功能。并不是说我们的客户不具备这方面的研发能力，只是这方面不是他们的核心业务。自己开发不仅会使整个创业周期变得更长，硬件投入成本更大，而且开发出来的效果也不一定比UPYUN更好。<br />
CSDN移动： 如何收费，盈利模式如何？<br />
&nbsp;&nbsp;&nbsp;&nbsp;UPYUN主要是面向企业客户提供收费的云服务，通过用户消耗的存储空间和流量来收费，这也是目前UPYUN的主要盈利模式。<br />
UPYUN按照用户的实际使用量来收费，并且在业务增长的同时，只需要扩展相应的存储空间和流量即可。相比于用户自建来说，一方面管理更加方便；另一方面也增加了图片、音频、视频的处理功能，相对自己单独部署服务器，有更多实用的功能；最后，按需收费也能极大程度上缩减运维成本，使用户把主要精力投入到自己的核心业务和运营上去。以上三点是众多客户选择使用UPYUN的重要原因。<br />
&nbsp;&nbsp;<br />
&nbsp;&nbsp;&nbsp;&nbsp;部分UPYUN 客户<br />
&nbsp;&nbsp;&nbsp;&nbsp;UPYUN用户如是说——<br />
&nbsp;&nbsp;&nbsp;&nbsp;365日历黄昆：又拍云同时提供了一套完整的API，包含手机客户端SDK和html表单等调用方式，可以方便的调用API上传图片或文件，上传过程中对图片类型支持旋转和裁剪等一系列操作。又拍云文件存储、图片存储等所有这些相关的功能都无需我们自己代码实现，同时减少大量的服务器运维工作，开发人员可以专注于产品，值得介绍给大家尝试一下。<br />
&nbsp;&nbsp;&nbsp;&nbsp;GIF快手银鑫：如果是购买传统的CDN服务，一般都是按带宽峰值收费的。这样的话，比较极限的情况，如果您这个月有一天由于某些原因，突然访问带宽使用达到100兆，但其余29天都只使用了1兆带宽，您仍然需要掏100兆的钱。这其实就是相当亏的。<br />
<br />
&nbsp;&nbsp;&nbsp;&nbsp;就像这个示意图中显示的一样，其实大部分国内的网站，平均流量和峰值流量还是差距很大的。如果您用CDN服务，就需要按图示的绿线付钱，而又拍的计费方式是按图示的黄色面积付钱。这对于流量峰值和流量均值间隔越大的网站，是越有利的。<br />
&nbsp;&nbsp;&nbsp;&nbsp;唱吧黄全能：目前我们的部分业务已经在又拍云上面运行了一段时间了，至少从这段时间的使用情况来看，又拍云的服务稳定性还不错，没出过什么问题。而且在双方的对接过程中，对接人员的响应速度非常快，这点要赞一个。&nbsp;<br />
CSDN移动：UPYUN 未来发展方向如何？<br />
&nbsp;&nbsp;&nbsp;&nbsp;随着移动互联网的快速发展，3G、4G网络的相继推出，用户也会对图片浏览、音频试听、视频播放等内容有更高需求。这也相应地要求了移动互联网创业者需要在应用中植入更多的静态数据，对静态数据的云存储、云处理和云分发的需求也会逐步加大，UPYUN业务的价值必然会被逐步地放大。</span><br />','','35','0','1','4','1393470289','7','',''),
('214','移动开发者必须了解的10大跨平台工具','<span style=&#34;background-color:;&#34;>&nbsp;&nbsp;&nbsp;&nbsp;成本低、周期短，易于上手，不用重新设计，种种好处让跨平台开发风头无量，也让诸多跨平台开发工具趁势崛起。在本文中，我们盘点了过去的一年里，最受开发者喜爱的跨平台移动应用开发工具，尤以HTML/JS/CSS开发为众，比如PhoneGap、Sencha Touch等，却也包含使用其他语言进行开发的工具，比如Xamarin，使用C#，就可以开发出能运行于各大主流移动平台之上的原生App。<br />
HTML/JavaScript/CSS篇<br />
<br />
1. PhoneGap<br />
&nbsp;&nbsp;&nbsp;&nbsp;说到跨平台开发工具，很多人首先会想到PhoneGap。这样一款能够让开发者使用HTML、JS、CSS来开发跨平台移动App的开源免费框架，一直以来都深受开发者喜爱，从iOS、Android、BB10、Windows Phone到Amazon Fire OS、Tizen等，各大主流移动平台一应俱全，还能让开发者充分利用地理位置、加速器、联系人、声音等手机核心功能。<br />
此前，在Native与Web谁主未来的大论毫无消停之时，许多人认为，类PhoneGap的应用开发框架天然优势在于支持跨平台，后期可扩展性较强，开发周期很短，熟悉Web技术的开发者可轻松上手，缺点在于性能上的确不如Native，后期还需针对各个版本分别优化开发等。如今，Hybrid App已然当家做主，PhoneGap在性能与平台特性支持上也有着极大的提高和改善，大有赶超Native之势。<br />
<br />
2. Sencha Touch<br />
&nbsp;&nbsp;&nbsp;&nbsp;Sencha Touch是一款基于HTML5、CSS3和JavaScript的移动Web应用开发框架，内置MVC系统，能够让开发者的HTML5应用看起来就像原生应用一样，全面兼容iOS、Android、BlackBerry、Windows Phone、Tizen等主流移动平台。除了常见的触摸手势之外，Sencha Touch还专为iOS、Android设备提供了单击、双击、滑动、滚动和双指缩放手势。&nbsp;<br />
HTML5应用开发的大热让众多跨平台开发框架逐渐风行，而Sencha Touch就是其中之一。能够让开发者以非常友好的方式从HTML5/CSS3/JS提取最多内容，并为其提供丰富而又易于使用的特性。Sencha Touch对于iOS平台的兼容性非常好，画面切换效果亦是相当流畅。<br />
相关链接：Sencha Touch在Mobilehub主页<br />
<br />
3. Titanium<br />
&nbsp;&nbsp;&nbsp;&nbsp;Titanium是Appcelerator公司旗下的一款开源的跨平台开发框架，和PhoneGap及Sencha Touch一样，都是让开发者使用HTML/CSS/JS来开发出原生的桌面及移动应用，还支持Python、Ruby和PHP。Titanium最大的特点就是，由于是基于硬件的开发，开发过程中所创建的应用可选择存储在设备或云端之上。<br />
通过其单一的JavaScript SDK开发原生iOS、Android、Hybrid及移动Web应用。<br />
通过其基于Eclipse的Titanium Studio，可以极大地简化开发流程。<br />
拥有高效代码块，让开发者编写更少的代码，创建出可扩展的应用程序。<br />
集成了MBaaS和Appcelerator Open Mobile Marketplace。<br />
</span><span style=&#34;background-color:;&#34;><br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
</span><br />','','35','0','1','4','1393470373','8','',''),
('215','OvershareKit：开源的iOS社交分享工具库','<span style=&#34;background-color:;&#34;>OvershareKit是一款开源的iOS社交分享工具库，基于MIT协议发布，代码业已托管到GitHub上。通过OvershareKit，开发者就不必再为给应用编写社交分享控件而烦恼，直接通过方法对其进行引用即可。<br />
OvershareKit的优点：<br />
分享界面布局简单，图标像素完美色彩饱满。<br />
多个可调选项，包括华丽的黑暗模式。<br />
支持Twitter、Facebook、App.net及Instapaper等主流社交分享平台。<br />
完整的多账户管理，包括身份认证及在Keychain中安全地保存凭证。<br />
优质的文本编辑视图，Riposte风格的滑动手势光标导航和自动智能引用。<br />
</span><span style=&#34;background-color:;&#34;><br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
</span><br />','','35','0','1','4','1393470414','1','',''),
('216','雨血·影之刃：参选2014年Unity游戏及应用大赛','<span style=&#34;background-color:;&#34;>&nbsp;&nbsp;&nbsp;&nbsp;备受瞩目的《雨血》系列横版格斗武侠手游——由网易代理重推的《影之刃》于今日（2月21日）进行首测，并宣布参加Unity游戏及应用大赛大中华赛区， 竞逐2014年Unity游戏及应用大赛（商业组）各类奖项 。<br />
&nbsp;&nbsp;&nbsp;&nbsp;在众多报名参加Unity游戏及应用大赛的商业组作品中，《影之刃》格外吸睛抢眼，其前身为单机游戏《雨血》系列，由80后独立游戏人梁其伟采用Unity游戏引擎制作，在欧美国家好评如潮并获“游戏中的艺术品”美誉。<br />
&nbsp;&nbsp;&nbsp;&nbsp;《雨血》系列由以梁其伟先生为主导的灵游坊开发团队制作，一经问世便在国内外获得广泛赞誉，成为近期中式武侠RPG代表作之一。其手游版《影之刃》由网易近期大力推广回馈玩家。《影之刃》采用梁其伟亲自构建的具有浓重个人色彩的画风，用近乎艺术的线与墨勾勒出一个异于传统的暗沉江湖。这款基于主机游戏品质， 并与手游游戏特点相结合的武侠手游采用Unity游戏引擎制作，用梁其伟自己的话说：“一个好的工具应该像人的手指一样，让人忘记这个工具本身的存在，而能够自由自在地表现设计理念。而Unity是很接近于这个标准的。”<br />
&nbsp;&nbsp;&nbsp;&nbsp;《影之刃》作为一款横版格斗武侠游戏，其战斗方式以极具打击感的连招为主。游戏描述了一个充满杀戮和变局的武侠江湖，蒸汽机械和人体改造术无处不在。身为杀手组织的玩家将只身闯入折损众多高手的南武林，遭遇环环相扣的阴谋危局，直面欺骗、背叛与死亡。游戏人物对话冷峻简短，富有强烈的古龙特色。玩家可从数十种招式中自由搭配，组成2条连招链，玩家可以自由配合普攻、闪避、格挡与浮空跳跃，用狂放不羁的快节奏连招杀掉每一个眼前的敌人。<br />
&nbsp;&nbsp;&nbsp;&nbsp;“我们希望让玩家看到，中国风的本土原创游戏并不输给走欧美路线的游戏，Unity是一个强大的工具，它能做出效果让人意想不到的产品, ”对于是否能通过Unity官方游戏大赛中国赛区走向全球赛区并最终斩获佳绩，灵游坊表示报以期待。<br />
&nbsp;&nbsp;&nbsp;&nbsp;当然，Unity游戏大赛也不仅仅是由大咖们主导角力的比赛，有别于其他游戏奖项评比，Unity游戏及应用大赛分商业组和原创组两个组别。商业组收取市场上较为成熟的作品参赛，而原创组接受中小型CP和独立开发团队的作品。原创组更单独添设“最佳学生奖”鼓励在校学生参加作品选拔（哪怕只是一个demo）。Unity引擎欢迎更多“民间生力军”和“散兵游勇”们加入到Unity阵营，创造更多平民游戏神话。<br />
&nbsp;&nbsp;&nbsp;&nbsp;Unity游戏及应用大赛（大中华区）是Unity官方在全球举办的最具权威的Unity游戏开发大赛，广泛征集来自企业、游戏工作室、独立开发者和在校学生所开发的Unity游戏。获奖作品将有机会获取海内外游戏应用平台丰厚推广资源、孵化资金与技术支持， 更将代表大中华区参加全球Unity Awards大赛争金夺银。本届中国区大赛，所有参赛作品将展开60余个奖项的角逐。</span><br />','2014_11/16/1416120305_0_2248.jpg','35','0','1','4','1416120308','11','',''),
('217','移动周报：对话智能硬件云服务平台Yeelink','<span style=&#34;background-color:;&#34;>&nbsp;&nbsp;&nbsp;&nbsp;在上周中，Facebook斥资190亿美元收购Whatsapp。消息一出，就有人爆料WhatsApp联合创始人Brian Acton，曾应聘Facebook遭拒。Brian Acton这一华丽转身，让众多求职者备受鼓舞。不过在受鼓舞的同时，是否更应该去加强自己的能力，来创造自己的辉煌……叮叮，把思绪拉回来，要知道上周我们主要做了开发工具以及服务的介绍，额……不会记不清了吧？那一起通过移动周报来回顾一下吧！<br />
<br />
1. Webix 1.5发布：一个强大的JavaScript UI组件库<br />
&nbsp;&nbsp;&nbsp;&nbsp;Webix是一个跨浏览器的JavaScript UI组件库，可以构建跨平台的HTML5和CSS3应用。日前，XB公司发布了新版的Webix 1.5，较之前的版本，Webix 1.5进行了一些改进。而其中最大的改进就是，能够更好的支持移动设备。除此之外，Webix 1.5在部件方面也有着很好的改善。<br />
</span>&nbsp;&nbsp;&nbsp;&nbsp;Webix 1.5在桌面和移动设备上准确运行能力的提升，使用户开发的Web应用程序，可以在多个平台上运行。除此之外，从1.5版开始，皮肤设计会倾向于扁平化，没有渐变、阴影和反射，使您的移动web应用更轻更时尚。而部件方面，像Tabbar、Charts、Accordion、Unitlist和Slider都有新的更改。<br />
<span style=&#34;background-color:;&#34;><br />
2. 《近匠》第12期：Yeelink——智能硬件云服务<br />
&nbsp;&nbsp;&nbsp;&nbsp;本期《近匠》对话Yeelink——国内首个开放的物联网平台。Yeeklink在平台方面以推动和推广智能产品的应用为主，目前定位于公益性平台。而在平台孵化和延伸的产品方面，则是成为新一代智能硬件销售的核心业务，希望能够革新现有的传统照明和电子产品的用户体验，打造消费者容易接受和喜欢的精品智能硬件产品。未来，Yeelink计划成为一个设计主导的产品公司。<br />
&nbsp;&nbsp;&nbsp;&nbsp;Yeelink的业务主要分两个部分，一是，服务众多创客的开放物联网平台产品，Yeelink.net ，将继续提供给创客和电子爱好者开发智能硬件的云平台，持续为Maker、个人开发者和EE工程师提供服务，简化硬件开发流程。二是， 智能照明产品Yeelight，开发革新照明体验的智能照明产品，提供革命性的光体验产品。<br />
<br />
3. Tizen真要来了！又有15家IT大佬成帮会成员<br />
&nbsp;&nbsp;&nbsp;&nbsp;Tizen是一款开源软件平台及操作系统，可以支持多种互联设备，而Tizen Association则是一个行业联盟，为Tizen平台的发展提供支持。近日， Tizen Association宣布新增15名合作伙伴项目成员，成员包括移动游戏发行商、运营商、应用程序开发商、移动软件管理供应商以及电信巨头。<br />
&nbsp;&nbsp;&nbsp;&nbsp;15名新成员是：AccuWeather、Acrodea、Baidu （百度）、CloudStreet、Cyberlightning、DynAgility、Gamevil、Inside Secure 、Ixonos、Nomovok、Piceasoft、Red Bend Software 、SoftBank Mobile、Sprint 、ZTE （中兴通讯）。<br />
<br />
4. Google Play services 4.2全球推送，完全支持Chromecast！<br />
&nbsp;&nbsp;&nbsp;&nbsp;2月14号，Google正式面向全球设备推送Google Play services 4.2，在此次新版本中，除了此前传言的Google Cast API支持，还对Google Drive API进行了更新，并添加了一个全新的客户端API。至此，Google Play服务终于实现了对Chromecast的官方完全支持。<br />
&nbsp;&nbsp;&nbsp;&nbsp;如此，开发者只需通过Google Cast SDK，将Chromecast集成到现有的移动或Web应用中，并在Google Cast开发者控制台上发布，就能够让用户通过智能手机及平板电脑，控制电视等大型设备显示的内容。<br />
<br />
5. 2014 Shenzhen Maker Faire：国内顶级创客聚会即将举行<br />
&nbsp;&nbsp;&nbsp;&nbsp;2014 Shenzhen Maker Faire将于04月06日在深圳蛇口南海意库正式拉开帷幕。Maker Faire是现今最大的全球创客盛会，它给DIY爱好者一个展示创意、创新的舞台，更是一个适合所有人参与、感受创客文化的嘉年华。<br />
&nbsp;&nbsp;&nbsp;&nbsp;本届Maker Faire由《Make》杂志授权，由SeeedStudio、CSDN、雷锋网主办。创客与硬件爱好者在此可全家参与得到不一样的亲子体验，不仅可以看到创意十足的展品和项目，更有知名创客精彩演讲，分享创客故事，展现创客文化的魅力。您还可以与全家全程参与不同主题的工作坊，享受动手创造的乐趣。<br />
<br />
6. Unite China·2014：上千Unity开发者狂欢、五大精品课程全面开启<br />
&nbsp;&nbsp;&nbsp;&nbsp;2014年4月13-14日，一年一度的Unity中国开发者大会将在北京国家会议中心举行。从2004年诞生至今，Unity作为一款强大的跨平台游戏引擎为开发者所熟知，更是以其多平台发布、友好的界面、极易上手的操作系统而闻名。而这场Unity开发者的年度盛会，则代表着全球Unity开发的最高水准和最高质量的技术交流。<br />
&nbsp;&nbsp;&nbsp;&nbsp;这次会议规模赶超以往，与会人员超过4000人次。大会现场，不仅有Unity专家讲师分享最新、最核心的Unity开发技术，Unity技术团队全天候开放式地提供技术指导解答，更有国内外知名制作人，及微软、三星、友盟等开发者服务平台和厂商进行精彩议题分享。<br />
<br />
7. CoconutKit：iOS开发必备的开源组件库<br />
&nbsp;&nbsp;&nbsp;&nbsp;CoconutKit是一款专门用于iOS开发的高质量开源组件库，基于MIT协议发布，代码业已托管到GitHub上。从简单的视图控制器到先进的本地化功能，CoconutKit可以减少iOS开发者对样板代码（Boilerplate code）的编写，提高代码的质量和执行可靠的应用程序框架。<br />
&nbsp;&nbsp;&nbsp;&nbsp;复杂的视图动画、高品质视图控制器容器和更易托管验证Core Data模型都是CoconutKit的主要特性。当然，CoconutKit的特性并不止这些，详细了解可以到GitHub上查看。<br />
&nbsp;&nbsp;&nbsp;&nbsp;除上述之外，当然也还有其他非常精彩的内容，比如从Camera360 V5版本发布，来看现代相机应用趋势。集中团队和资源打造成最佳支付平台，PayPal将面向全球开放移动SDK……更多热点，欢迎大家直接登录CSDN移动频道首页浏览查看，当然，您也可以订阅移动电子刊，即可直接在邮箱中查看每周移动开发最精华的内容。<br />
</span><br />','','67','0','1','4','1418316082','33','',''),
('218','Node.app：用Node.js API开发iOS“原生”应用','<span style=&#34;background-color:;&#34;>&nbsp;&nbsp;&nbsp;&nbsp;轻量、高效的Node.js，能够帮助程序员构建高度可伸缩的应用程序。这样一款服务器端的JavaScript解释器，一直以来都颇受Web开发者青睐，在移动开发者心目中的地位也是相当崇高，却又因种种原因对它望而却步。为此，来自德国的开发者Marcus Kida和工程师Sam Rijs共同开发了一款名为Node.app的，专门用于iOS开发的Node.js解释器，并在GitHub上创建了“Node.js for iOS”开源组织，将开发成果完全开放，与来自全球的开发者共同分享。<br />
&nbsp;&nbsp;&nbsp;&nbsp;Node.app能够为应用程序提供兼容Node.js的JavaScript API，不仅占用资源非常少，而且还允许最大限度的代码重用和快速创新。<br />
主要特性：<br />
&nbsp;&nbsp;&nbsp;&nbsp;最大限度的代码重用：在iOS应用开发过程中，开发者可以直接使用在服务器和前端能可靠运行的代码。<br />
&nbsp;&nbsp;&nbsp;&nbsp;数以万计的模块：拥有着非常丰富的模块资源，通过npm，开发者可以使用任意模块。<br />
&nbsp;&nbsp;&nbsp;&nbsp;快速创新：Node.app提供了开发者熟悉的Node.js API，使用起来非常方便。<br />
&nbsp;&nbsp;&nbsp;&nbsp;占用资源少：通过相同的快速系统功能，使用Node.app就如同标准的iOS代码一样，而用户在使用时，甚至不会注意到它并不是原生应用。</span><br />','','67','0','1','4','1395120023','216','',''),
('220','国庆放假通知','&nbsp;&nbsp;','','69','0','1','4','1416917606','4','',''),
('221','周日网站升级','&nbsp;','','69','0','1','4','1416917764','2','',''),
('222','明天总部开会','&nbsp;','','69','0','1','4','1416917796','1','','');m;o;n;

DROP TABLE IF EXISTS `monxin_article_article_type`;m;o;n;

CREATE TABLE `monxin_article_article_type` (
  `id` int(3) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `parent` int(3) NOT NULL default '0',
  `sequence` int(3) NOT NULL default '0',
  `visible` int(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;m;o;n;

INSERT INTO `monxin_article_article_type` (`id`,`name`,`parent`,`sequence`,`visible`) VALUES
('35','公司新闻','73','99','1'),
('68','国内新闻','65','0','0'),
('67','全球动态','65','0','1'),
('65','行业资讯','73','0','1'),
('69','公告通告','0','0','1'),
('73','新闻资讯','0','0','1'),
('75','国际新闻','73','0','1');m;o;n;

monxin_sql_end