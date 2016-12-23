-- phpMyAdmin SQL Dump
-- version 4.5.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-12-15 05:39:37
-- 服务器版本： 5.7.10-log
-- PHP Version: 5.6.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testguest`
--

-- --------------------------------------------------------

--
-- 表的结构 `tg_article`
--

CREATE TABLE `tg_article` (
  `tg_id` mediumint(8) UNSIGNED NOT NULL,
  `tg_reid` mediumint(8) UNSIGNED NOT NULL,
  `tg_username` varchar(20) NOT NULL,
  `tg_denyreply` tinyint(1) NOT NULL DEFAULT '1',
  `tg_type` tinyint(2) UNSIGNED NOT NULL,
  `tg_title` varchar(40) NOT NULL,
  `tg_content` text NOT NULL,
  `tg_readcount` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `tg_commentcount` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `tg_nice` tinyint(1) NOT NULL DEFAULT '0',
  `tg_last_modify` datetime NOT NULL,
  `tg_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tg_article`
--

INSERT INTO `tg_article` (`tg_id`, `tg_reid`, `tg_username`, `tg_denyreply`, `tg_type`, `tg_title`, `tg_content`, `tg_readcount`, `tg_commentcount`, `tg_nice`, `tg_last_modify`, `tg_date`) VALUES
(1, 0, '炎日', 1, 1, '第一次发表帖子', '我要发表帖子了，第一次好激动啊！！！', 14, 0, 0, '0000-00-00 00:00:00', '2016-10-12 19:07:57'),
(2, 0, '晴雯', 1, 1, '寡人之于国也', '梁惠王曰：“寡人之于国也，尽心焉耳矣。河内凶，则移其民于河东，移其粟于河内。河东凶亦然。察邻国之政，无如寡人之用心者。邻国之民不加少，寡人之民不加多，何也？”孟子对曰：“王好战，请以战喻。填然鼓之，兵刃既接，弃甲曳兵而走，或百步而后止，或五十步而后止。以五十步笑百步，则何如？”曰：“不可。直不百步耳，是亦走也。”曰：“王如知此，则无望民之多于邻国也。不违农时，谷不可胜食也。数罟不入洿池，鱼鳖不可胜食也。斧斤以时入山林，材木不可胜用也。谷与鱼鳖不可胜食，材木不可胜用，是使民养生丧死无憾也。养生丧死无憾，王道之始也。五亩之宅，树之以桑，五十者可以衣帛矣。鸡豚狗彘之畜，无失其时，七十者可以食肉矣；百亩之田，勿夺其时，数口之家可以无饥矣；谨庠序之教，申之以孝悌之义，颁白者不负戴于道路矣。七十者衣帛食肉，黎民不饥不寒，然而不王者，未之有也。狗彘食人食而不知检，途有饿殍而不知发。人死，则曰：‘非我也，岁也。’是何异于刺人而杀之，曰：‘非我也，兵也。’王无罪岁，斯天下之民至焉。”\n', 7, 0, 0, '0000-00-00 00:00:00', '2016-10-13 09:29:37'),
(3, 0, '晴雯', 1, 1, 'Guset功能测试', '[size=10]字体大小[/size]\r\n[b]粗体[/b]\r\n[i]斜体[/i]\r\n[u]下划线[/u]\r\n[s]穿越线[/s]\r\n[color=#9c0]颜色[/color]\r\n[url]http://www.baidu.com[/url]\r\n[email]qingwen@qq.com[/email]\r\n[flash]http://player.youku.com/player.php/sid/XOTQyMDQ0OTU2/v.swf[/flash]', 32, 0, 0, '0000-00-00 00:00:00', '2016-10-13 09:44:38'),
(4, 0, '晴雯', 1, 1, '中国土豪新西兰买地建别墅：地基铺塑料泡沫', '    一对山东夫妇在新西兰买地建别墅，一开始就被地基雷到了。以前盖房子的地基都是浇30公分的水泥，他们是用20公分的塑料泡沫填充，据说这是新西兰普遍使用的新技术。不过，屋主还是觉得心里很不踏实。', 1, 0, 0, '0000-00-00 00:00:00', '2016-10-13 11:03:39'),
(5, 0, '晴雯', 1, 15, '张靓颖母亲手撕准女婿 他不爱我女儿 把她', '    据全明星探报道，张靓颖与男友冯轲将于11月15日在意大利结婚的消息，随后不久远在成都的张靓颖的母亲张桂英女士与全明星探取得了联系，发布一封致社会公众的公开信。在这封手写的公开信中，张桂英女士曝出惊人内幕，指准女婿冯轲欺骗张靓颖当了“小三”，侵吞张靓颖和她的公司股份，并表示冯轲不是一个可以把女儿托付终身的男人，明确反对张靓颖与冯轲的婚事。张桂英表示，自己直到现在都没收到女儿结婚的消息，现在冯轲想迫切的和靓颖结婚，自己担心他要名正言顺地继续掌控靓颖的财产，让女儿继续成为他的挣钱工具。', 1, 0, 0, '0000-00-00 00:00:00', '2016-10-13 11:08:59'),
(6, 0, '晴雯', 1, 1, '实拍朝鲜第二大城市 经济中心竟然如此破落', '[img]images/monipic/Korea1.jpg[/img]\n[img]images/monipic/Korea2.jpg[/img]', 5, 0, 0, '0000-00-00 00:00:00', '2016-10-13 11:13:38'),
(7, 0, '晴雯', 1, 1, '湖北农村汉低调晒别墅 逼格超高堪称教科书', '    70后大叔在外漂泊十几年，倦鸟归巢，回到老家农村盖房当农村汉。大叔低调晒自己盖房装修全过程，美式大别墅逼格超高，炸出一大波围观网友！看完只能说：房子太好！逼格太高！大叔太壕！', 5, 0, 0, '0000-00-00 00:00:00', '2016-10-13 11:18:37'),
(8, 0, '晴雯', 1, 1, '华人在美国买地建别墅 监理负责没花一分冤', '    一对华人夫妻在美国安家，男主人一直想住在梦想中的房子中，在权衡了各项条件之后终于决定买地建造自己梦想中的房子！请了个超级负责的监理，基本没浪费建房基金！', 3, 0, 0, '0000-00-00 00:00:00', '2016-10-13 11:20:08'),
(9, 0, '晴雯', 1, 1, '朋友圈新骗局:扫二维码可缴违停罚款', '[img]images/monipic/penalty.jpg[/img]', 3, 0, 0, '0000-00-00 00:00:00', '2016-10-13 11:22:49'),
(10, 0, '晴雯', 1, 1, '疑黄晓明朋友圈曝光 baby调侃:恭喜老', '[img]images/monipic/angelababy.jpeg[/img]', 3, 0, 0, '0000-00-00 00:00:00', '2016-10-13 11:24:38'),
(11, 0, '晴雯', 1, 1, '南京80后老公设计复式新房讨好老婆 网友', '    虽说有房子已经很能耐，但是会自己设计的话更牛！南京有一个80后准新郎，为了让老婆开心，自己设计装修了豪华的复式新房。网友都说，嫁这样的老公有安全感啊！', 3, 0, 0, '0000-00-00 00:00:00', '2016-10-13 11:26:12'),
(12, 0, '晴雯', 1, 5, '发改委：自2017年1月1日起全面放开食', '    中国证券网讯 发改委网站显示，9日，发改委发布放开食盐价格有关事项的通知。自2017年1月1日起，放开食盐出厂、批发和零售价格，由企业根据生产经营成本、食盐品质、市场供求状况等因素自主确定。各地要抓紧开展相关工作，确保食盐零售价格如期放开。', 3, 0, 0, '0000-00-00 00:00:00', '2016-10-13 11:27:37'),
(13, 0, '晴雯', 1, 1, '黑龙江游客国庆在越南火烧越南盾 被驱逐出', '    [img]images/monipic/fire.jpg[/img]\r\n\r\n    据国家旅游局网站消息，国家旅游局今天公布“十一”国庆假期投诉处理情况及近期查处的典型案件、不文明旅游行为和好游客、好导游事例。其中，黑龙江游客候歌顺赴越南旅游过程中，在岘港市一家酒吧火烧越南盾，因违反当地法律，被越南警方驱逐出境。经旅游不文明行为记录评审委员会审定，将候歌顺列入旅游不文明行为记录。', 5, 0, 0, '0000-00-00 00:00:00', '2016-10-13 11:29:46'),
(14, 0, '晴雯', 1, 1, '驴友非法穿越四川亚丁保护区因严重高反罹难', '    “这是一次天堂与地狱之间的穿越，是一段由新驴向老驴蜕变的历程……”风光奇美的四川稻城亚丁自然保护区，近年来吸引了越来越多游客慕名而来，在10月黄金游览周期到来前，像这样颇为诱人的招募帖在网上广为流传。其中不乏一些网友自发组织的穿越活动，选择了一些未开发的路线，加之队员缺乏户外经验和应急能力，时常导致危险发生。', 5, 0, 0, '0000-00-00 00:00:00', '2016-10-13 11:31:13'),
(15, 0, '晴雯', 1, 18, '冯轲回应张靓颖母亲控诉:自己财产属夫妻共同拥有', '    张靓颖与冯轲将于11月9号在意大利举行婚礼，不料，今日有媒体曝出张靓颖母亲张桂英公开信《我不想让女儿再错下去》。信中，张桂英称冯轲和张靓颖结婚意在名正言顺控制女儿财产。对此，冯轲9日在微博回应，列出财产协议书和律师见证书，称早已和张靓颖做过婚前财产公证，自己所有婚前婚后财产，均归属于张靓颖与冯轲共同所有。', 37, 0, 0, '2016-10-14 23:43:53', '2016-10-13 11:32:50'),
(16, 0, '晴雯', 1, 8, '服务员十一为赚外快将招嫖卡片塞进警察手里', '    安徽省蚌埠市男子朱某本是酒店服务员，国庆假期想赚点外快，在游客住宿较多的酒店派发招嫖卡片，见到化装成游客的民警后，他顺手又塞了两张到便衣警察的手里，于是他当场被@蚌埠公安在线钓鱼台派出所民警抓获，目前朱某已被依法行政拘留。', 18, 0, 0, '0000-00-00 00:00:00', '2016-10-13 11:33:47'),
(17, 0, '晴雯', 1, 1, '化解医患冲突需改革医疗体制', '    十一期间，国内发生两起医患冲突事件。山东莱钢医院发生暴力伤医案，儿科医生李宝华不幸离世；苏州大学附属儿童医院发生患儿家属留言恐吓医生事件。医患冲突再次成为舆论场上的热门话题。这些年来，医患冲突就像不定期爆发的活火山，每隔一段时间就会以狰狞的面目示人，但似乎永无消弭的迹象。不过，“变化”还是有的。前几年，舆论更多站在患者立场。而现在，舆论更多站在医生立场。这一改变的发生，主要是由于医护群体近年来在暴力威胁下逐渐抱团取暖，争夺话语权。', 21, 0, 1, '0000-00-00 00:00:00', '2016-10-13 11:34:38'),
(18, 0, '晴雯', 1, 1, '北京楼市新政或致违约潮 有家庭吃不消', '    一夜之间，从要不要高价买的纠结，切换到要不要违约的两难，这是北京“930”楼市新政后不少购房者正在经历的心态变化。《第一财经日报》记者日前调查走访发现，北京市场上已经出现买方解约或计划解约案例。而房地产经纪公司我爱我家日前提供给本报的分析报告称，预计将有20%~30%的客户或将取消或延缓换房计划。链家研究院的研究报告也指出，北京楼市调控新政对北京二手房市场的短期影响之一，就是违约和纠纷案例明显增多', 10, 0, 0, '0000-00-00 00:00:00', '2016-10-13 11:36:09'),
(19, 0, '晴雯', 1, 1, '李克强:改革成效不仅要看数字更要看切身感', '    2015年11月25日下午，李克强考察上海自贸区行政服务中心。在境外投资备案窗口，一位正办理备案的企业家告诉总理，过去需要两周才能走完的程序如今只需两天。李克强说，这种“只备案不审批”的模式创新，是优化投资和营商环境、提高国际竞争力的重要举措。“现在群众确实能感觉到，很多原本要‘跑腿’的事项被取消或下放了，但这个‘感觉’和新闻发布的‘数字’还是有差异。”李克强总理在10月8日的国务院常务会议上说。', 59, 1, 1, '0000-00-00 00:00:00', '2016-10-13 11:37:15'),
(20, 0, '晴雯', 1, 5, '蠢到令人发指！渣男其实是傻女人惯出来的', '    流了那么多眼泪的你，别人也不会觉得伟大，除了摇头叹息的同情，最后收到的顶多是一句：姑娘，你好傻。从少女时代，19岁的张靓颖就与冯轲在一起。在一次演唱会上，她公开求婚，他不情愿地走上台。恋爱十三年后，他们公开结婚消息，张母以极其轰动的方式手撕准女婿.', 517, 25, 1, '2016-10-18 20:47:34', '2016-10-13 11:38:59'),
(21, 20, '东方不败', 1, 1, 'RE：蠢到令人发指！渣男其实是傻女人惯出', '流了那么多眼泪的你，别人也不会觉得伟大，除了摇头叹息的同情，最后收到的顶多是一句：姑娘，你好傻。从少女时代，19岁的张靓颖就与冯轲在一起。在一次演唱会上，她公开求婚，他不情愿地走上台。恋爱十三年后，他们公开结婚消息，张母以极其轰动的方式手撕准女婿，心疼“傻女儿”。', 1, 0, 0, '0000-00-00 00:00:00', '2016-10-14 16:48:04'),
(22, 20, '东方不败', 1, 1, 'RE：蠢到令人发指！渣男其实是傻女人惯出', '[img]images/qpic/1/Q8.gif[/img]\r\n\r\n[img]images/qpic/2/Q5.gif[/img]\r\n\r\n[img]images/qpic/3/Q6.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2016-10-14 16:49:57'),
(23, 19, '凤姐', 1, 1, 'RE：李克强:改革成效不仅要看数字更要看', '有机会出来玩玩啊！！！\r\n\r\n[img]images/qpic/2/Q7.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2016-10-14 17:00:33'),
(24, 20, '克劳德', 1, 1, 'RE：蠢到令人发指！渣男其实是傻女', '不禁让我想到：到底什么是爱呢,什么有事对的爱呢？', 0, 0, 0, '0000-00-00 00:00:00', '2016-10-14 20:12:45'),
(25, 20, '克劳德', 1, 1, 'RE：蠢到令人发指！渣男其实', '百无聊赖！！！\r\n[img]images/qpic/1/Q4.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2016-10-14 20:13:44'),
(26, 20, '克劳德', 1, 1, 'RE：蠢到令人发指！渣', '[img]images/qpic/2/Q1.gif[/img]\r\n[img]images/qpic/2/Q6.gif[/img]\r\n[img]images/qpic/2/Q11.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2016-10-14 20:54:43'),
(27, 20, '克劳德', 1, 1, 'RE：蠢到令人发指！渣男其实是傻女人惯出', '[img]images/qpic/1/Q1.gif[/img][img]images/qpic/1/Q2.gif[/img][img]images/qpic/1/Q3.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2016-10-14 21:25:29'),
(28, 20, '克劳德', 1, 1, 'RE：蠢到令人发指！渣男其实是傻女人惯出', '[img]images/qpic/1/Q4.gif[/img][img]images/qpic/1/Q5.gif[/img][img]images/qpic/1/Q6.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2016-10-14 21:25:49'),
(29, 20, '克劳德', 1, 1, 'RE：蠢到令人发指！渣男其实是傻女人惯出', '[img]images/qpic/1/Q13.gif[/img][img]images/qpic/1/Q14.gif[/img][img]images/qpic/1/Q15.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2016-10-14 21:26:06'),
(30, 20, '克劳德', 1, 1, 'RE：蠢到令人发指！渣男其实是傻女人惯出', '[img]images/qpic/1/Q16.gif[/img][img]images/qpic/1/Q17.gif[/img][img]images/qpic/1/Q18.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2016-10-14 21:26:26'),
(31, 20, '克劳德', 1, 1, 'RE：蠢到令人发指！渣男其实是傻女人惯出', '[img]images/qpic/2/Q4.gif[/img][img]images/qpic/2/Q8.gif[/img][img]images/qpic/2/Q12.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2016-10-14 21:26:44'),
(32, 20, '克劳德', 1, 1, 'RE：蠢到令人发指！渣男其实是傻女人惯出', '[img]images/qpic/3/Q1.gif[/img][img]images/qpic/3/Q2.gif[/img][img]images/qpic/3/Q3.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2016-10-14 21:27:02'),
(33, 20, '克劳德', 1, 1, 'RE：蠢到令人发指！渣男其实是傻女人惯出', '[img]images/qpic/3/Q10.gif[/img][img]images/qpic/3/Q11.gif[/img][img]images/qpic/3/Q12.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2016-10-14 22:01:52'),
(34, 20, '克劳德', 1, 1, 'RE：蠢到令人发指！渣男其实是傻女人惯出', '[img]images/qpic/3/Q10.gif[/img][img]images/qpic/3/Q11.gif[/img][img]images/qpic/3/Q12.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2016-10-14 22:02:19'),
(44, 20, '炎日', 1, 1, 'RE：蠢到令人发指！渣男其实是傻女人惯出来的', '回帖SESSION测试！！！', 0, 0, 0, '0000-00-00 00:00:00', '2016-10-15 22:33:14'),
(45, 20, '炎日', 1, 1, 'RE：蠢到令人发指！渣男其实是傻女人惯出来的', '[img]images/qpic/2/Q3.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2016-10-18 19:24:40'),
(46, 20, '炎日', 1, 1, 'RE：蠢到令人发指！渣男其实是傻女人惯出来的', '[img]images/qpic/1/Q6.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2016-10-18 19:25:05'),
(47, 20, '炎日', 1, 1, 'RE：蠢到令人发指！渣男其实是傻女人惯出来的', '[img]images/qpic/3/Q21.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2016-10-18 19:25:24'),
(48, 20, '东方不败', 1, 1, '回复1楼的晴雯', 'sgdfgsgdfgsgdfgsgdfg', 0, 0, 0, '0000-00-00 00:00:00', '2016-10-24 08:16:15'),
(49, 0, '炎日', 1, 1, '供暖时间表已执行约40年，该改了 民调', '10月底以来，北方大部分地区气温骤降，公众希望提前供暖的呼吁升温。“新华视点”记者采访发现，集中供暖时间标准的制定在当初有特定历史背景，并已沿用约40年。随着气候条件和百姓生活条件的变化，“连续5天平均气温低于5摄氏度”的规定是否需要变一变？', 5, 0, 0, '0000-00-00 00:00:00', '2016-11-03 10:40:10'),
(50, 0, '炎日', 1, 1, '袁隆平种出“海水稻” 计划3年内亩产突破200公斤', '在近日举行的2016世界生命科学大会上，袁隆平介绍了正在探索种植的“海水稻”。据了解，青岛市日前成立了“青岛海水稻研发中心”，这是国内首个国家级海水稻研究发展中心，袁隆平担任该中心主任和首席科学家。该中心计划在3年时间内，实现海水稻种植亩产突破200公斤的目标。', 6, 0, 0, '0000-00-00 00:00:00', '2016-11-03 11:37:03');

-- --------------------------------------------------------

--
-- 表的结构 `tg_dir`
--

CREATE TABLE `tg_dir` (
  `tg_id` mediumint(8) UNSIGNED NOT NULL,
  `tg_name` varchar(20) NOT NULL,
  `tg_type` tinyint(1) UNSIGNED NOT NULL,
  `tg_password` char(40) DEFAULT NULL,
  `tg_content` varchar(200) DEFAULT NULL,
  `tg_cover` varchar(200) DEFAULT NULL,
  `tg_dir` varchar(200) NOT NULL,
  `tg_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tg_dir`
--

INSERT INTO `tg_dir` (`tg_id`, `tg_name`, `tg_type`, `tg_password`, `tg_content`, `tg_cover`, `tg_dir`, `tg_date`) VALUES
(3, '工作相片', 1, '7c4a8d09ca3762af61e59520943dc26494f8941b', '工作相片', 'images/monipic/photo1.jpg', 'photo/1476628957', '2016-10-16 22:42:37');

-- --------------------------------------------------------

--
-- 表的结构 `tg_flower`
--

CREATE TABLE `tg_flower` (
  `tg_id` mediumint(8) UNSIGNED NOT NULL,
  `tg_touser` varchar(20) NOT NULL,
  `tg_fromuser` varchar(20) NOT NULL,
  `tg_flower` mediumint(8) UNSIGNED NOT NULL,
  `tg_content` varchar(200) NOT NULL,
  `tg_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tg_flower`
--

INSERT INTO `tg_flower` (`tg_id`, `tg_touser`, `tg_fromuser`, `tg_flower`, `tg_content`, `tg_date`) VALUES
(2, '炎日', '炎日', 2, '真的很是欣赏你,送你的花，希望你收下！！！', '2016-10-24 21:31:03');

-- --------------------------------------------------------

--
-- 表的结构 `tg_friend`
--

CREATE TABLE `tg_friend` (
  `tg_id` mediumint(8) UNSIGNED NOT NULL,
  `tg_touser` varchar(20) NOT NULL,
  `tg_fromuser` varchar(20) NOT NULL,
  `tg_content` varchar(200) NOT NULL,
  `tg_state` tinyint(1) NOT NULL DEFAULT '0',
  `tg_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tg_friend`
--

INSERT INTO `tg_friend` (`tg_id`, `tg_touser`, `tg_fromuser`, `tg_content`, `tg_state`, `tg_date`) VALUES
(1, '花袭人', '令狐冲', '我很想和你交个朋友！', 0, '2016-10-07 08:14:37'),
(2, '任盈盈', '任我行', '我很想和你交个朋友！', 1, '2016-10-07 08:29:47'),
(3, '令狐冲', '任我行', '我很想和你交个朋友！', 1, '2016-10-07 08:29:58'),
(4, '东方不败', '任我行', '我很想和你交个朋友！', 0, '2016-10-07 08:30:45'),
(5, '李小龙', '任我行', '我很想和你交个朋友！', 1, '2016-10-07 08:30:55'),
(7, '克劳德', '任我行', '我很想和你交个朋友！', 0, '2016-10-07 08:31:16'),
(9, '王熙凤', '任我行', '我很想和你交个朋友！', 0, '2016-10-07 08:32:40'),
(10, '蜡笔小新', '任盈盈', '我很想和你交个朋友！', 0, '2016-10-07 08:37:03'),
(11, '令狐冲', '任盈盈', '我很想和你交个朋友！', 0, '2016-10-07 08:37:24'),
(12, '东方不败', '任盈盈', '我很想和你交个朋友！', 0, '2016-10-07 08:37:35'),
(13, '李小龙', '任盈盈', '我很想和你交个朋友！', 1, '2016-10-07 08:37:45'),
(15, '任盈盈', '薛宝钗', '我很想和你交个朋友！', 1, '2016-10-08 02:45:35'),
(16, '晴雯', '太傻', '我很想和你交个朋友！', 1, '2016-10-24 15:37:34'),
(17, '太傻', '炎日', '我很想和你交个朋友！', 1, '2016-10-24 21:44:16');

-- --------------------------------------------------------

--
-- 表的结构 `tg_message`
--

CREATE TABLE `tg_message` (
  `tg_id` mediumint(8) UNSIGNED NOT NULL,
  `tg_touser` varchar(20) NOT NULL,
  `tg_fromuser` varchar(20) NOT NULL,
  `tg_content` varchar(200) NOT NULL,
  `tg_state` tinyint(1) NOT NULL DEFAULT '0',
  `tg_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tg_message`
--

INSERT INTO `tg_message` (`tg_id`, `tg_touser`, `tg_fromuser`, `tg_content`, `tg_state`, `tg_date`) VALUES
(7, '晴雯', '一休', '你看起来好漂亮啊，可以交个朋友吗。', 1, '2016-10-06 03:25:48'),
(10, '任盈盈', '任我行', '这个山村，让习近平“把心留在这里”', 0, '2016-10-08 03:10:30'),
(9, '东方不败', '任我行', '你在干嘛呢，我很想你啊。', 1, '2016-10-07 08:30:35'),
(11, '任我行', '任我行', '这个山村，让习近平“把心留在这里”', 0, '2016-10-08 03:10:59'),
(12, '晴雯', '太傻', '他不情愿地走上台。恋爱十三年后，他们公开结婚消息，张母以极其轰动的方式手撕准女婿. ', 1, '2016-10-24 15:36:50');

-- --------------------------------------------------------

--
-- 表的结构 `tg_photo`
--

CREATE TABLE `tg_photo` (
  `tg_id` mediumint(8) UNSIGNED NOT NULL,
  `tg_name` varchar(40) NOT NULL,
  `tg_url` varchar(200) NOT NULL,
  `tg_content` varchar(200) DEFAULT NULL,
  `tg_sid` mediumint(8) UNSIGNED NOT NULL COMMENT '//图片所在目录ID',
  `tg_username` varchar(40) NOT NULL,
  `tg_readcount` smallint(5) NOT NULL,
  `tg_commentcount` smallint(5) NOT NULL,
  `tg_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tg_photo`
--

INSERT INTO `tg_photo` (`tg_id`, `tg_name`, `tg_url`, `tg_content`, `tg_sid`, `tg_username`, `tg_readcount`, `tg_commentcount`, `tg_date`) VALUES
(5, '美女1', 'photo/1476628957/1476690616.jpg', '好看', 3, '炎日', 7, 1, '2016-10-17 15:50:28'),
(6, '美女2', 'photo/1476628957/1476690643.jpg', '漂亮', 3, '炎日', 3, 0, '2016-10-17 15:50:50'),
(10, '老照片1', 'photo/1476628957/1476690821.jpg', '', 3, '炎日', 3, 0, '2016-10-17 15:53:45'),
(11, '老照片2', 'photo/1476628957/1476690844.jpg', '', 3, '炎日', 10, 0, '2016-10-17 15:54:07'),
(12, '老照片3', 'photo/1476628957/1476690864.jpg', '', 3, '炎日', 4, 0, '2016-10-17 15:54:29'),
(13, '老照片4', 'photo/1476628957/1476690888.jpg', '', 3, '炎日', 2, 0, '2016-10-17 15:54:50'),
(16, 'Q图1', 'photo/1476628957/1476768651.gif', '', 3, '炎日', 0, 0, '2016-10-18 13:30:53');

-- --------------------------------------------------------

--
-- 表的结构 `tg_photo_comment`
--

CREATE TABLE `tg_photo_comment` (
  `tg_id` mediumint(8) UNSIGNED NOT NULL,
  `tg_title` varchar(40) NOT NULL,
  `tg_content` varchar(200) NOT NULL,
  `tg_sid` mediumint(8) UNSIGNED NOT NULL,
  `tg_username` varchar(40) NOT NULL,
  `tg_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tg_photo_comment`
--

INSERT INTO `tg_photo_comment` (`tg_id`, `tg_title`, `tg_content`, `tg_sid`, `tg_username`, `tg_date`) VALUES
(1, 'RE：游戏图片3', '第一次评论图片啊~~~', 9, '炎日', '2016-10-17 22:55:18'),
(2, 'RE：游戏图片3', '[img]images/qpic/2/Q8.gif[/img]', 9, '炎日', '2016-10-17 22:59:18'),
(3, 'RE：游戏图片3', '[img]images/qpic/1/Q7.gif[/img]', 9, '炎日', '2016-10-17 22:59:32'),
(4, 'RE：游戏图片3', '[img]images/qpic/2/Q7.gif[/img]\r\n[img]images/qpic/2/Q5.gif[/img]\r\n[img]images/qpic/2/Q12.gif[/img]', 9, '炎日', '2016-10-17 22:59:56'),
(5, 'RE：游戏图片3', '[img]images/qpic/3/Q17.gif[/img]\r\n[img]images/qpic/3/Q16.gif[/img]\r\n[img]images/qpic/3/Q23.gif[/img]', 9, '炎日', '2016-10-17 23:00:18'),
(6, 'RE：游戏图片3', '[img]images/qpic/2/Q15.gif[/img]\r\n[img]images/qpic/2/Q8.gif[/img]', 9, '炎日', '2016-10-17 23:00:43'),
(7, 'RE：美女1', '看起来真的好美啊！！！', 5, '犀利哥', '2016-10-17 23:46:01'),
(8, 'RE：游戏图片2', '好酷啊！！！\r\n[img]images/qpic/2/Q14.gif[/img]', 8, '犀利哥', '2016-10-17 23:53:20');

-- --------------------------------------------------------

--
-- 表的结构 `tg_system`
--

CREATE TABLE `tg_system` (
  `tg_id` mediumint(8) UNSIGNED NOT NULL,
  `tg_webname` varchar(20) NOT NULL,
  `tg_article` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `tg_blog` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `tg_photo` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `tg_skin` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `tg_string` varchar(200) NOT NULL,
  `tg_post` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `tg_reply` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `tg_code` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `tg_register` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tg_system`
--

INSERT INTO `tg_system` (`tg_id`, `tg_webname`, `tg_article`, `tg_blog`, `tg_photo`, `tg_skin`, `tg_string`, `tg_post`, `tg_reply`, `tg_code`, `tg_register`) VALUES
(1, '千里草WEB俱乐部', 10, 15, 12, 2, '他妈的|NND|草|操|垃圾|淫荡|贱货|SB|sb|jb|JB|鸡巴|法轮功', 60, 15, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tg_user`
--

CREATE TABLE `tg_user` (
  `tg_id` mediumint(8) UNSIGNED NOT NULL,
  `tg_uniqid` char(40) NOT NULL,
  `tg_active` char(40) NOT NULL,
  `tg_username` varchar(20) NOT NULL,
  `tg_password` char(40) NOT NULL,
  `tg_question` varchar(20) NOT NULL,
  `tg_answer` char(40) NOT NULL,
  `tg_email` varchar(40) DEFAULT NULL,
  `tg_qq` varchar(10) DEFAULT NULL,
  `tg_url` varchar(40) DEFAULT NULL,
  `tg_sex` char(1) NOT NULL,
  `tg_face` varchar(20) DEFAULT NULL,
  `tg_switch` tinyint(1) UNSIGNED NOT NULL,
  `tg_autograph` varchar(200) DEFAULT NULL,
  `tg_level` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `tg_post_time` varchar(20) NOT NULL DEFAULT '0',
  `tg_reply_time` varchar(20) NOT NULL DEFAULT '0',
  `tg_reg_time` datetime NOT NULL,
  `tg_last_time` datetime NOT NULL,
  `tg_last_ip` varchar(20) NOT NULL,
  `tg_login_count` smallint(4) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tg_user`
--

INSERT INTO `tg_user` (`tg_id`, `tg_uniqid`, `tg_active`, `tg_username`, `tg_password`, `tg_question`, `tg_answer`, `tg_email`, `tg_qq`, `tg_url`, `tg_sex`, `tg_face`, `tg_switch`, `tg_autograph`, `tg_level`, `tg_post_time`, `tg_reply_time`, `tg_reg_time`, `tg_last_time`, `tg_last_ip`, `tg_login_count`) VALUES
(16, 'fc2fdf91ea3effa27138cc87522624cbb99b41ce', '', '花千骨', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'huaqiangu@qq.com', '123456', 'http://honglou.com', '女', 'images/face/m04.gif', 0, NULL, 0, '0', '0', '2016-09-29 05:42:51', '2016-10-15 23:30:52', '::1', 2),
(17, '4118564dc47de9bea0f57aa90c5f94fbb450f5ba', '', '炎日', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'yanri@qq.com', '147258369', 'http://yanri.com', '男', 'images/face/m01.gif', 0, NULL, 1, '1478144223', '1476789924', '2016-09-29 05:44:46', '2016-12-15 13:38:36', '::1', 41),
(18, '7d0f6ce5859f0ee0642a62adc23ee7eb92484e15', '', '红楼易梦', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是老师', '28df2384f9a450f13a4360f1bb822b8b533c7430', 'honglou@163.com', '147258', 'http://honglou163.com', '女', 'images/face/m25.gif', 0, NULL, 0, '0', '0', '2016-09-29 05:48:18', '2016-10-01 17:29:08', '::1', 1),
(19, '4cf985e18aee7e9fedf5cc6ee1fdba6d0d8fd830', '', '海贼王', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'haizeiwang@162.com', '123456', 'http://haizeiwang162.com', '男', 'images/face/m07.gif', 0, NULL, 0, '0', '0', '2016-09-29 05:50:01', '2016-10-01 17:29:08', '::1', 1),
(20, '6996688c142a0d4b82c670e2a5add158d626ae92', '', '黑猫警长', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'heimao@qq.com', '147258', 'http://heimao.com', '男', 'images/face/m06.gif', 0, NULL, 0, '0', '0', '2016-09-29 05:51:28', '2016-10-01 17:29:08', '::1', 1),
(21, '8916b6cb73155695136d2ad17f5545aa072add39', '', '一休', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'yixiu@163.com', '147258369', 'http://yixiu.com', '男', 'images/face/m03.gif', 0, NULL, 0, '0', '0', '2016-09-29 05:52:38', '2016-10-06 03:24:57', '::1', 2),
(22, 'afea621214eb70eaccf02ecc307fce694a7735e5', '', '薛杉杉', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'shanshan@qq.com', '147258', 'http://shanshan.com', '女', 'images/face/m09.gif', 0, NULL, 0, '0', '0', '2016-09-29 05:54:45', '2016-10-01 17:29:08', '::1', 1),
(23, '28c7dbbbdc8111b8959f72439476eda83e430621', '', '陆贞', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'luzhen@qq.com', '123456789', 'http://luzhen.com', '女', 'images/face/m49.gif', 0, NULL, 0, '0', '0', '2016-09-29 06:01:15', '2016-10-18 13:34:59', '::1', 2),
(24, '5752dae6b6fa4a078c746a052881e393ab4344b7', '', '贾宝玉', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'jiabaoyu@qq.com', '123456', 'http://jiabaoyu.com', '男', 'images/face/m08.gif', 0, NULL, 0, '0', '0', '2016-09-29 06:03:53', '2016-10-01 17:29:08', '::1', 1),
(25, '054542a1aacb61d8e3711b33c2c1956664d812bd', '', '林黛玉', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '7b52009b64fd0a2a49e6d8a939753077792b0554', 'lindaiyu@qq.com', '123456789', 'http://lindaiyu.com', '女', 'images/face/m21.gif', 0, NULL, 0, '0', '0', '2016-09-29 06:10:27', '2016-10-01 17:29:08', '::1', 1),
(26, '07dfab480b81fe5c2264caa399908ef87a05d420', '', '薛宝钗', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'xuebaochai@qq.com', '123456', 'http://xuebaochai.com', '女', 'images/face/m48.gif', 0, NULL, 0, '0', '0', '2016-09-29 06:17:08', '2016-10-08 02:45:21', '::1', 2),
(27, '03f575cc68b11e99eb133ee4d741e1aad1eddf2d', '', '贾琏', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', 'b3c0730cf3f50613e40561e67c871fdb92820cf9', 'jialian@126.com', '123456', 'http://jialian.com', '男', 'images/face/m17.gif', 0, NULL, 0, '0', '0', '2016-09-29 06:22:30', '2016-10-24 18:49:34', '::1', 2),
(28, 'f8ec5d03ccd4ce5ce87a0dcbde73e773117775cb', '', '花袭人', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', 'b3c0730cf3f50613e40561e67c871fdb92820cf9', 'xiren@qq.com', '147258', 'http://xiren.com', '女', 'images/face/m22.gif', 0, NULL, 0, '0', '0', '2016-09-29 06:24:19', '2016-10-01 17:29:08', '::1', 1),
(29, '5021f94e76bbafa814494bfe6444060cbaf68b08', '', '王熙凤', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '536fb6934062440c464ca2eef82b0be8e6b36cc8', 'xifeng@qq.com', '147258369', 'http://xifeng.sina.cn', '女', 'images/face/m24.gif', 0, NULL, 0, '0', '0', '2016-09-29 06:26:00', '2016-10-24 19:59:58', '::1', 5),
(30, '70f2df9469b1acac4f35f5de6f55e6ef3e6f3dea', '', '晴雯', '7c4a8d09ca3762af61e59520943dc26494f8941b', '147258', 'b3c0730cf3f50613e40561e67c871fdb92820cf9', 'qingwen@sina.com', '123456', 'http://qingwen.sina.cn', '女', 'images/face/m01.gif', 1, '我是晴雯', 0, '0', '0', '2016-09-29 06:27:49', '2016-10-24 19:05:13', '::1', 10),
(31, '644ff770771127252fa9fda8fa366de47cc3adae', '', '克劳德', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '5e06d22c8893e27d5a7243bd185faa94cc593072', 'crowd@gmail.com', '147258', 'http://json.com', '男', 'images/face/m11.gif', 0, NULL, 0, '0', '0', '2016-09-29 06:32:00', '2016-10-14 20:08:09', '::1', 2),
(32, 'b2ac93fae104428166439207ec1450857af1cde9', '', '董雅思', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '6b6277afcb65d33525545904e95c2fa240632660', 'yasi@qq.com', '123456', 'http://yasi.com', '女', 'images/face/m52.gif', 0, NULL, 1, '1476539012', '1476539296', '2016-09-29 06:33:23', '2016-10-18 11:32:34', '::1', 5),
(33, '9d7b007d3ec13e2ac59fb692f152a84e0bd8503a', '', '李小龙', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '9e071a3a594a8964cbefe784f8a6afaa94c0de17', 'lixiaolong@qq.com', '123456', 'http://lixiaolong.com', '男', 'images/face/m16.gif', 0, NULL, 0, '0', '0', '2016-09-29 06:38:28', '2016-10-08 03:00:13', '::1', 2),
(34, '85e87706e29d7c7a3070d979cba071479eebf2b2', '', '东方不败', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '25293f2761d658cc70c19515861842d712751bdc', 'dongfangbubai@126.com', '159357', 'http://dongfangbubai.com', '女', 'images/face/m01.gif', 1, '    日出东方,唯我不败;千秋万代,一统江湖! 教主文成武德、泽被苍生 ,千秋万载,一统江湖!\n\n[img]images/monipic/angelababy.jpeg[/img]', 1, '0', '1477268865', '2016-09-29 06:41:28', '2016-10-24 18:51:15', '::1', 13),
(35, 'f5ed938537b116b1dd161bc3d8bc1f1d45a1dd9e', '', '令狐冲', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', 'b3c0730cf3f50613e40561e67c871fdb92820cf9', 'linghuchong@qq.com', '159357', 'http://linghuchong.com', '男', 'images/face/m40.gif', 0, NULL, 0, '0', '0', '2016-09-29 06:44:46', '2016-10-07 07:42:38', '::1', 2),
(36, '8b9c4cb08cd2af63862402e891992a90c02c523a', '', '任盈盈', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', 'e54183e2a040e6c09e61eb22d542e3d57074b351', 'renyingying@qq.com', '136874', 'http://renyingying.com', '女', 'images/face/m28.gif', 0, NULL, 0, '0', '0', '2016-09-29 06:47:00', '2016-10-08 04:09:13', '::1', 5),
(37, '8d04fd81f22d5f86a2e9c527299249a63f24a3dd', '', '任我行', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '6b6277afcb65d33525545904e95c2fa240632660', 'renwoxing@gmail.com', '159357', 'http://renwoxing.com.cn', '男', 'images/face/m29.gif', 0, NULL, 0, '0', '0', '2016-09-29 06:50:07', '2016-10-08 05:05:39', '::1', 9),
(38, '9d18bcac8cbe0e79790b856f5eb773e18b111d89', '', '蜡笔小新', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'xiaoxin@gmail.com', '123456789', 'http://xiaoxin.com', '男', 'images/face/m01.gif', 0, NULL, 0, '0', '0', '2016-10-07 08:35:46', '2016-10-18 13:42:24', '::1', 2),
(39, '45dd3944cf90c82abb7de19ebbd232dc95d61b5b', '', '犀利哥', '7c4a8d09ca3762af61e59520943dc26494f8941b', '真的犀利吗', 'cadfda3ac5730c80ae2681cec15d87720a5a4f02', 'xili@qq.com', '123456', 'http://xili.com', '男', 'images/face/m30.gif', 0, NULL, 0, '0', '0', '2016-10-08 10:09:42', '2016-10-24 06:26:17', '::1', 2),
(40, 'fe3c195571c261978d617c3907552ff450d8c9fb', '', '凤姐', '7c4a8d09ca3762af61e59520943dc26494f8941b', '长得漂亮吗', 'c574bef2098dd32c6c793f9b5a92a28b706cbd6f', 'fengjie@qq.com', '123456789', 'http://fengjie.com', '女', 'images/face/m25.gif', 0, NULL, 0, '0', '0', '2016-10-08 10:11:31', '2016-10-14 16:59:13', '::1', 1),
(43, '39f3febe929ed60f3c77562a2a1404c4b6605c93', '', '太傻', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', 'e3772438aa53fb3a98fd15b3b53243e27f694c5a', 'taisha@qq.com', '123456', 'http://taisha.com', '女', 'images/face/m33.gif', 0, NULL, 1, '0', '0', '2016-10-24 01:53:33', '2016-12-15 12:58:36', '::1', 8),
(45, '46c4a2d22dfbce0affe866f92c9f4c86f551fe4f', '', '花木兰', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'huamulan@qq.com', '123456789', 'http://huamulanqq.com', '女', 'images/face/m30.gif', 0, NULL, 0, '0', '0', '2016-12-15 13:38:11', '2016-12-15 13:38:11', '::1', 0);

-- --------------------------------------------------------

--
-- 表的结构 `tg_word`
--

CREATE TABLE `tg_word` (
  `id` smallint(8) UNSIGNED NOT NULL,
  `fromuser` varchar(20) NOT NULL,
  `touser` varchar(20) NOT NULL,
  `content` varchar(200) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tg_article`
--
ALTER TABLE `tg_article`
  ADD PRIMARY KEY (`tg_id`);

--
-- Indexes for table `tg_dir`
--
ALTER TABLE `tg_dir`
  ADD PRIMARY KEY (`tg_id`);

--
-- Indexes for table `tg_flower`
--
ALTER TABLE `tg_flower`
  ADD PRIMARY KEY (`tg_id`);

--
-- Indexes for table `tg_friend`
--
ALTER TABLE `tg_friend`
  ADD PRIMARY KEY (`tg_id`);

--
-- Indexes for table `tg_message`
--
ALTER TABLE `tg_message`
  ADD PRIMARY KEY (`tg_id`);

--
-- Indexes for table `tg_photo`
--
ALTER TABLE `tg_photo`
  ADD PRIMARY KEY (`tg_id`);

--
-- Indexes for table `tg_photo_comment`
--
ALTER TABLE `tg_photo_comment`
  ADD PRIMARY KEY (`tg_id`);

--
-- Indexes for table `tg_system`
--
ALTER TABLE `tg_system`
  ADD PRIMARY KEY (`tg_id`);

--
-- Indexes for table `tg_user`
--
ALTER TABLE `tg_user`
  ADD PRIMARY KEY (`tg_id`);

--
-- Indexes for table `tg_word`
--
ALTER TABLE `tg_word`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `tg_article`
--
ALTER TABLE `tg_article`
  MODIFY `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- 使用表AUTO_INCREMENT `tg_dir`
--
ALTER TABLE `tg_dir`
  MODIFY `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `tg_flower`
--
ALTER TABLE `tg_flower`
  MODIFY `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `tg_friend`
--
ALTER TABLE `tg_friend`
  MODIFY `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- 使用表AUTO_INCREMENT `tg_message`
--
ALTER TABLE `tg_message`
  MODIFY `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- 使用表AUTO_INCREMENT `tg_photo`
--
ALTER TABLE `tg_photo`
  MODIFY `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- 使用表AUTO_INCREMENT `tg_photo_comment`
--
ALTER TABLE `tg_photo_comment`
  MODIFY `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- 使用表AUTO_INCREMENT `tg_system`
--
ALTER TABLE `tg_system`
  MODIFY `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `tg_user`
--
ALTER TABLE `tg_user`
  MODIFY `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- 使用表AUTO_INCREMENT `tg_word`
--
ALTER TABLE `tg_word`
  MODIFY `id` smallint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
