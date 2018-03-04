INSERT INTO `phpapp_credit_level` (`lid`, `small`, `big`, `type`, `style`) VALUES
(1, 1, 10, 1, 'seller_credit_level1'),
(2, 11, 40, 1, 'seller_credit_level2'),
(3, 41, 90, 1, 'seller_credit_level3'),
(4, 91, 150, 1, 'seller_credit_level4'),
(5, 151, 250, 1, 'seller_credit_level5'),
(6, 251, 500, 1, 'seller_credit_level6'),
(7, 501, 1000, 1, 'seller_credit_level7'),
(8, 1001, 2000, 1, 'seller_credit_level8'),
(9, 2001, 5000, 1, 'seller_credit_level9'),
(10, 5001, 10000, 1, 'seller_credit_level10'),
(11, 10001, 20000, 1, 'seller_credit_level11'),
(12, 20001, 50000, 1, 'seller_credit_level12'),
(13, 50001, 100000, 1, 'seller_credit_level13'),
(14, 100001, 200000, 1, 'seller_credit_level14'),
(15, 200001, 500000, 1, 'seller_credit_level15'),
(16, 500001, 1000000, 1, 'seller_credit_level16'),
(17, 1000001, 2000000, 1, 'seller_credit_level16'),
(18, 2000001, 5000000, 1, 'seller_credit_level17'),
(19, 5000001, 10000000, 1, 'seller_credit_level18'),
(20, 10000001, 999999999, 1, 'seller_credit_level19'),
(21, 1, 10, 2, 'buyer_credit_level1'),
(22, 11, 40, 2, 'buyer_credit_level2'),
(23, 41, 90, 2, 'buyer_credit_level3'),
(24, 91, 150, 2, 'buyer_credit_level4'),
(25, 151, 250, 2, 'buyer_credit_level5'),
(26, 251, 500, 2, 'buyer_credit_level6'),
(27, 501, 1000, 2, 'buyer_credit_level7'),
(28, 1001, 2000, 2, 'buyer_credit_level8'),
(29, 2001, 5000, 2, 'buyer_credit_level9'),
(30, 5001, 10000, 2, 'buyer_credit_level10'),
(31, 10001, 20000, 2, 'buyer_credit_level11'),
(32, 20001, 50000, 2, 'buyer_credit_level12'),
(33, 50001, 100000, 2, 'buyer_credit_level13'),
(34, 100001, 200000, 2, 'buyer_credit_level14'),
(35, 200001, 500000, 2, 'buyer_credit_level15'),
(36, 500001, 1000000, 2, 'buyer_credit_level16'),
(37, 1000001, 2000000, 2, 'buyer_credit_level16'),
(38, 2000001, 5000000, 2, 'buyer_credit_level17'),
(39, 5000001, 10000000, 2, 'buyer_credit_level18'),
(40, 10000001, 999999999, 2, 'buyer_credit_level19');



INSERT INTO `phpapp_file_icon` (`fid`, `form`, `icon`, `type`) VALUES
(1, 'txt', 'images/fileicon/txt.png', 'text/plain'),
(2, 'pdf', 'images/fileicon/pdf.png', 'application/pdf'),
(3, 'zip', 'images/fileicon/zip.png', 'application/zip'),
(4, 'rar', 'images/fileicon/rar.png', 'application/x-rar'),
(5, 'doc', 'images/fileicon/doc.png', 'application/msword'),
(6, 'xls', 'images/fileicon/xls.png', 'application/vnd.ms-excel'),
(7, 'ppt', 'images/fileicon/ppt.png', 'application/x-empty'),
(8, 'mdb', 'images/fileicon/mdb.png', 'application/x-empty'),
(9, 'gif', 'images/fileicon/gif.png', 'image/gif'),
(10, 'png', 'images/fileicon/png.png', 'image/png'),
(11, 'jpg', 'images/fileicon/jpg.png', 'image/jpeg'),
(12, 'bmp', 'images/fileicon/bmp.png', 'image/bmp'),
(13, 'tif', 'images/fileicon/tif.png', 'image/tiff'),
(14, 'jpg', 'images/fileicon/jpg.png', 'image/jpg'),
(15, 'mp3', 'images/fileicon/mp3.png', 'audio/mpeg'),
(16, 'wma', 'images/fileicon/wma.png', 'audio/x-ms-wma'),
(17, 'rm', 'images/fileicon/rm.png', 'application/octet-stream');


INSERT INTO phpapp_links (`displayorder`, `sitename`, `siteurl`, `description`, `logo`) VALUES( 0, 'PHPAPP', 'http://www.phpapp.cn', 'PHPAPP威客系统','http://www.phpapp.cn/images/logo.gif');



INSERT INTO `phpapp_member_level` (`lid`, `title`, `small`, `big`, `style`, `color`) VALUES
(1, '新生威客', 0, 20, 'member_level1', ''),
(2, '初级威客', 21, 50, 'member_level2', ''),
(3, '中级威客', 51, 100, 'member_level3', ''),
(4, '高级威客', 101, 200, 'member_level4', ''),
(5, '元老威客', 201, 500, 'member_level5', ''),
(6, '元帅威客', 501, 999999999, 'member_level6', '#F00');



INSERT INTO `phpapp_nav` (`navid`, `navname`, `navurl`, `default`, `appid`, `blank`, `site`, `displayorder`) VALUES
(1, '首页', 'index.php', 0, 56, 1, 0, 0),
(2, '任务大厅', 'index.php?app=49', 0, 49, 1, 0, 0),
(3, '找人才', 'index.php?app=55', 0, 55, 1, 0, 0),
(4, '买服务', 'index.php?app=82', 0, 82, 1, 0, 0),
(5, '管理中心', 'member.php?app=9', 0, 9, 1, 0, 0),
(6, '威客社区', 'http://bbs.phpapp.cn', 0, 0, 1, 1, 10);



INSERT INTO `phpapp_nav_bottom` (`navid`, `navname`, `navurl`, `blank`, `displayorder`) VALUES
(1, '关于我们', 'index.php?app=23&action=1', 1, 0),
(2, '联系方式', 'index.php?app=23&action=2', 1, 0),
(3, '友情链接', 'index.php?app=23&action=3', 1, 0),
(4, '网站地图', 'index.php?app=46', 1, 0),
(6, '帮助中心', 'index.php?app=57', 1, 0),
(5, '推广联盟', 'index.php?app=20', 0, 0);



INSERT INTO `phpapp_nav_top` (`navid`, `navname`, `navurl`, `blank`, `displayorder`) VALUES
(1, '认证', 'member.php?app=12', 1, 0),
(2, '推广联盟', 'index.php?app=20', 1, 3);



INSERT INTO `phpapp_pay_tool` (`id_phpapp`, `name_phpapp`, `logo_phpapp`, `displayorder_phpapp`, `type_phpapp`, `status_phpapp`) VALUES
(52, '支付宝', 'alipay_logo.gif', 0, 0, 0),
(56, '银行汇款', '', 99, 1, 0);




INSERT INTO `phpapp_prop` ( `appid`, `subject`, `content`, `day`, `count`, `price`, `status`, `icon`, `usergroup`, `sell`, `buynum`, `displayorder`, `type`) VALUES
(61, '全站动态', '将您现在的任务加入到全站所见动态信息', 1, 1, '0.00', 0, 'service_feed_icon', 3, 0, 10, 0, 0),
(63, '列表推荐', '将您的任务推荐在任务列表顶方(重复使用可以竞价排名)', 1, 0, '10.00', 0, 'service_top2_icon', 3, 0, 10, 10, 0),
(64, '隐藏稿件', '服务商提交的稿件，只有您一人可见，避免您获得的稿件曝光！', 1, 1, '10.00', 0, 'service_draft_icon', 3, 0, 10, 0, 0),
(71, '实名投稿', '要求实名认证的会员才能投稿', 1, 1, '10.00', 0, 'service_realnametask_icon', 3, 0, 10, 0, 0),
(63, '列表推荐', '将您的稿件推荐在投稿列表顶方(重复使用可以竞价排名)', 1, 0, '10.00', 0, 'service_top2_icon', 3, 0, 10, 10, 1),
(64, '隐藏稿件', '您提交的稿件只有您和雇主可见，避免您的稿件曝光被盗用！', 1, 1, '10.00', 0, 'service_draft_icon', 3, 0, 10, 0, 1),
(53, '隐藏任务', '隐藏任务内容用户登录可见！', 1, 1, '10.00', 0, 'service_task_icon', 3, 0, 10, 0, 0),
(61, '全站动态', '将您现在的服务加入到全站所见动态信息', 1, 1, '0.00', 0, 'service_feed_icon', 3, 0, 10, 0, 2),
(63, '列表推荐', '将您的服务推荐在服务列表顶方(重复使用可以竞价排名)', 1, 0, '10.00', 0, 'service_top2_icon', 3, 0, 10, 10, 2),
(71, '实名购买服务', '要求实名认证的雇主才能购买我的服务', 1, 1, '10.00', 0, 'service_realnametask_icon', 3, 0, 10, 0, 2);



INSERT INTO `phpapp_sns` (`id_phpapp`, `app_phpapp`, `name_phpapp`, `icon_small_phpapp`, `icon_middle_phpapp`, `icon_big_phpapp`, `description_phpapp`, `status_phpapp`) VALUES
(1, 58, '新浪微博', 'sina_icon_small', '', 'sina_icon_big', '新浪微博帐号登录\r\n<p>通过新浪微博帐号登录到本站.</p>', 0),
(2, 59, 'QQ微博', 'qqweibo_icon_small', '', 'qqweibo_icon_big', 'QQ微博帐号登录\r\n<p>通过QQ微博帐号登录到本站.</p>', 0),
(3, 65, 'QQ', 'qq_icon_small ', '', 'qq_icon_big', '<p>通过QQ帐号登录到本站.</p>', 0),
(4, 66, '淘宝', 'taobao_icon_small', '', 'taobao_icon_big', '<p>通过淘宝帐号登录到本站.</p>', 0),
(5, 67, '网易微博', 'netease_icon_small', '', 'netease_icon_big', '<p>通过网易微博帐号登录到本站.</p>', 0),
(6, 69, '搜狐', 'sohu_icon_small', '', 'sohu_icon_big', '<p>通过搜狐帐号登录到本站.</p>', 0);


INSERT INTO `phpapp_space_style` (`sid`, `style`, `dir`, `type`, `usergroup`, `status`) VALUES
(1, '默认风格', 'default', 0, 0, 0),
(2, '颗粒路', 'grain', 0, 0, 0),
(3, '动感', 'dynamic', 0, 0, 0),
(4, '蓝色经典', 'blue', 0, 0, 0);



INSERT INTO `phpapp_templateblock` (`id_phpapp`, `apps_phpapp`, `label_phpapp`, `quote_phpapp`, `status_phpapp`) VALUES
(1, 9, '会员管理首页', 'memberhome', 0),
(2, 56, '网站首页-左上菜单', 'shortcutmenu', 0),
(3, 56, '网站首页-幻灯片', 'defaultslide', 0),
(4, 56, '网站首页-广告', 'scrollad', 0),
(5, 56, '网站首页-公告-提现等', 'publish', 0),
(6, 56, '网站首页-PHPAPP2.0头部', 'defaulttoptwo', 1),
(7, 56, '网站首页-PHPAPP2.0任务列表', 'taskshowtwo', 1),
(8, 56, '网站首页-格子分类任务列表', 'gridtask', 1),
(9, 82, '网站首页-服务商', 'sellerserviceshow', 0),
(10, 56, '网站首页-底部帮助', 'defaulthelp', 0),
(11, 56, '网站首页-友情链接', 'defaultlink', 0),
(12, 22, '网站搜索', 'search', 0),
(13, 56, '网站首页-格子分类人才列表', 'gridjobs', 1),
(14, 56, '网站首页-格子分类服务列表', 'gridservice', 1),
(15, 56, '网站首页-格子顶部', 'gridtop', 1),
(16, 56, '网站首页-格子幻灯片', 'gridslide', 1),
(17, 56, '网站首页-自由顶部', 'freetop', 0),
(18, 56, '网站首页-free首页流程', 'freeprocess', 0),
(19, 56, '网站首页-自由任务列表', 'freetask', 0),
(20, 56, '网站首页-自由首页技能', 'freeskills', 0),
(21, 56, '网站对联广告', 'ad_double', 1);



INSERT INTO `phpapp_union` (`id_phpapp`, `rebate_phpapp`, `service_phpapp`, `status_phpapp`) VALUES
(1, 0.1, 1, 0),
(2, 0.1, 2, 0),
(3, 0.1, 3, 0),
(4, 0.1, 4, 0),
(5, 0.1, 5, 0),
(6, 0.1, 6, 0),
(7, 0.1, 7, 0);




INSERT INTO `phpapp_apps_credit` (`id_phpapp`, `name_phpapp`, `apps_phpapp`, `action_phpapp`, `usergroup_phpapp`, `number_phpapp`, `credit_phpapp`, `status_phpapp`) VALUES
(1, '登录积分', 2, 1, 3, 30, 10, 0),
(19, '积分兑换', 4, 1, 3, 10, 10, 0),
(31, '悬赏点评', 80, 12, 3, 100, 1, 0),
(15, '快速登录', 2, 12, 3, 5, 20, 0),
(17, '注册页面', 2, 2, 3, 1, 8, 0),
(20, '悬赏任务发布完成支付', 80, 4, 3, 50, 10, 0),
(21, '悬赏稿件审核', 80, 11, 3, 100, 12, 0),
(30, '悬赏投稿', 80, 6, 3, 30, 5, 0),
(32, '悬赏任务留言', 80, 8, 3, 10, 2, 0);




INSERT INTO `phpapp_member_message_type` (`mid`, `subject`, `displayorder`, `satus`, `notice`, `email`, `phone`) VALUES
(1, '当我发任务成功,请通知我', 0, 0, 0, 0, 1),
(2, '当我的任务有投标时,请通知我', 0, 0, 0, 0, 1),
(3, '当我中标时,请通知我', 0, 0, 0, 0, 1),
(4, '当我被选不中标时,请通知我', 0, 0, 0, 0, 1),
(5, '当威客完成工作时,请通知我', 0, 0, 0, 0, 1),
(6, '当雇主确认支付时,请通知我', 0, 0, 0, 0, 1),
(7, '当我被举报时,请通知我', 0, 0, 0, 0, 1),
(8, '当有我任务有留言时,请通知我', 0, 0, 0, 0, 1),
(9, '当雇主在订单里要求开发票时,请通知我', 0, 0, 0, 0, 1),
(10, '当对方在订单里留言时,请通知我', 0, 0, 0, 0, 1),
(11, '我投标的任务当雇主任务加价加件时,请通知我', 0, 0, 0, 0, 1),
(12, '当我获取到推广拥金时,请通知我', 0, 0, 0, 0, 1),
(13, '当订单交易完成,请通知我', 0, 0, 0, 0, 1),
(14, '当对方评价订单时,请通知我', 0, 0, 0, 0, 1),
(15, '当雇主额外奖励我时,请通知我', 0, 0, 0, 0, 1),
(16, '当对我稿件的点评时,请通知我', 0, 0, 0, 0, 1),
(17, '当我成功退订消费者保障服务时,请通知我', 0, 0, 0, 0, 1),
(18, '当我收到交易维权时,请通知我', 0, 0, 0, 0, 1),
(19, '当我收到退款时,请通知我', 0, 0, 0, 0, 1),
(20, '当我退款成功时,请通知我', 0, 0, 0, 0, 1),
(22, '当我的任务过期时,请通知我', 0, 0, 0, 0, 1),
(23, '当我的增值服务过期时,请通知我', '0', '0', '0', '0', '1');



INSERT INTO `phpapp_refund_item` (`pid`, `project`, `status`) VALUES
(1, '卖家没发原稿件', 0),
(2, '卖家没有按要求完成', 0),
(3, '卖家完成质量有问题', 0),
(4, '其它', 0);



INSERT INTO `phpapp_report_type` (`rid`, `type`, `name`) VALUES
(1, 0, '发布垃圾广告'),
(2, 0, '发布敏感信息'),
(3, 0, '发布色情信息'),
(4, 0, '含有联系方式'),
(5, 2, '稿件涉嫌抄袭'),
(6, 2, '稿件正常被审不合格');
