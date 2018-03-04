INSERT INTO `phpapp_task_count_usergroup` (`gid`, `feetype`, `taskfee`, `unionfee`, `addunionfee`, `addtask`, `uploadfilestask`, `edittask`, `realnametask`, `messagetask`, `increasetask`, `addnumbertask`, `refundtask`, `smallrefundtask`, `extendnumbertask`, `extendmoneytask`, `maxmoneytask`, `smallmoneytask`, `addmoneytask`, `adddraft`, `editdraft`, `uploadfilesdraft`, `commentsdraft`, `votedraft`, `joinmoneydraft`, `addnumberdraft`, `appallow`) VALUES
(3, 0, 0.2, 0.02, 0.02, 0, 0, 0, 0, 0, 0, 100, 0, 10, 10, '10.00', '1000000.00', '0.00', '10.00', 0, 0, 0, 0, 0, '1000000.00', 100, 0),
(8, 0, 0.2, 0.02, 0.02, 0, 0, 0, 0, 0, 0, 100, 0, 10, 10, '10.00', '1000000.00', '10.00', '10.00', 0, 0, 0, 0, 0, '1000000.00', 100, 0),
(1, 0, 0.2, 0.02, 0.02, 0, 0, 0, 0, 0, 0, 100, 0, 10, 10, '10.00', '1000000.00', '10.00', '10.00', 0, 0, 0, 0, 0, '1000000.00', 100, 0),
(2, 0, 0.2, 0.02, 0.02, 0, 0, 0, 0, 0, 0, 100, 0, 10, 10, '10.00', '1000000.00', '10.00', '10.00', 0, 0, 0, 0, 0, '1000000.00', 100, 0),
(4, 0, 0.2, 0.02, 0.02, 0, 0, 0, 0, 0, 0, 100, 0, 10, 10, '10.00', '1000000.00', '10.00', '10.00', 0, 0, 0, 0, 0, '1000000.00', 100, 0),
(5, 0, 0.2, 0.02, 0.02, 0, 0, 0, 0, 0, 0, 100, 0, 10, 10, '10.00', '1000000.00', '10.00', '10.00', 0, 0, 0, 0, 0, '1000000.00', 100, 0);



INSERT INTO `phpapp_task_grab_usergroup` (`gid`, `feetype`, `taskfee`, `unionfee`, `addunionfee`, `appallow`, `addtask`, `uploadfilestask`, `edittask`, `realnametask`, `messagetask`, `increasetask`, `addnumbertask`, `refundtask`, `smallrefundtask`, `extendnumbertask`, `extendmoneytask`, `maxmoneytask`, `smallmoneytask`, `addmoneytask`, `adddraft`, `editdraft`, `uploadfilesdraft`, `commentsdraft`, `votedraft`, `joinmoneydraft`, `addnumberdraft`, `realnameaddtask`, `deletebid`) VALUES
(1, 0, 0.2, 0.02, 0.02, 0, 0, 0, 0, 0, 0, 0, 100, 0, 3, 10, '10.00', '1000000.00', '10.00', '10.00', 0, 0, 0, 0, 0, '1000000.00', 100, 0, 0),
(2, 0, 0.2, 0.02, 0.02, 0, 0, 0, 0, 0, 0, 0, 100, 0, 3, 10, '10.00', '1000000.00', '10.00', '10.00', 0, 0, 0, 0, 0, '1000000.00', 100, 0, 0),
(3, 0, 0.2, 0.02, 0.02, 0, 0, 0, 0, 0, 0, 0, 100, 0, 3, 10, '10.00', '1000000.00', '10.00', '10.00', 0, 0, 0, 0, 0, '1000000.00', 100, 0, 0),
(4, 0, 0.2, 0.02, 0.02, 0, 0, 0, 0, 0, 0, 0, 100, 0, 3, 10, '10.00', '1000000.00', '10.00', '10.00', 0, 0, 0, 0, 0, '1000000.00', 100, 0, 0),
(5, 0, 0.2, 0.02, 0.02, 0, 0, 0, 0, 0, 0, 0, 100, 0, 3, 10, '10.00', '1000000.00', '10.00', '10.00', 0, 0, 0, 0, 0, '1000000.00', 100, 0, 0);




INSERT INTO `phpapp_task_mode` (`mid`, `appid`, `name`, `displayorder`, `status`) VALUES
(1, 83, '招标任务', 1, 0),
(2, 80, '悬赏任务', 0, 0);


INSERT INTO `phpapp_task_select` (`catid`, `name`, `upid`, `displayorder`, `code`, `status`) VALUES
(1, '任务类型', 0, 0, '', 0),
(2, '地区分类', 0, 1, '', 0),
(3, '实名投标', 0, 1, '', 0),
(4, '托管赏金', 0, 1, 'money>0', 0),
(5, '任务进度', 0, 1, '', 0),
(6, '投标总数', 0, 1, '', 0),
(7, '发布时间', 0, 1, '', 0),
(8, '结束时间', 0, 1, '', 0),
(10, '保证选稿', 0, 0, '', 0),
(11, '要求实名投标', 3, 1, 'realnametask=1', 0),
(12, '小于500元', 4, 1, 'money>0 AND money<500', 0),
(13, '500-1000元', 4, 1, 'money>500 AND money<1000', 0),
(14, '1000-2000元', 4, 1, 'money>1000 AND money<2000', 0),
(15, '2000-5000元', 4, 1, 'money>2000 AND money<5000', 0),
(16, '5000-1万', 4, 1, 'money>5000 AND money<10000', 0),
(17, '1万-2万', 4, 1, 'money>10000 AND money<20000', 0),
(18, '2万元以上', 4, 1, 'money>20000', 0),
(19, '进行中', 5, 1, 'process=4', 0),
(20, '加价', 5, 1, 'addmoneynum>0', 0),
(21, '已结束', 5, 1, 'process=5', 0),
(22, '没投标', 6, 1, 'draft_number=0', 0),
(23, '投标10个内', 6, 1, 'draft_number>0 AND draft_number<=10', 0),
(24, '投标10-20个', 6, 1, 'draft_number>10 AND draft_number<=20', 0),
(25, '投标20-50个', 6, 1, 'draft_number>20 AND draft_number<=50', 0),
(26, '投标50-100个', 6, 1, 'draft_number>50 AND draft_number<=100', 0),
(27, '投标大于100个', 6, 1, 'draft_number>100', 0),
(28, '今日', 7, 1, 'dateline>=UNIX_TIMESTAMP(timestamp(date(sysdate())))  AND dateline<=(UNIX_TIMESTAMP()+86400)', 0),
(29, '昨日', 7, 1, 'dateline>=(UNIX_TIMESTAMP()-86400) AND dateline<=UNIX_TIMESTAMP(timestamp(date(sysdate())))', 0),
(30, '近三天', 7, 1, 'dateline>=(UNIX_TIMESTAMP()-259200) AND dateline<=UNIX_TIMESTAMP(timestamp(date(sysdate())))', 0),
(31, '近一周', 7, 1, 'dateline>=(UNIX_TIMESTAMP()-604800) AND dateline<=UNIX_TIMESTAMP(timestamp(date(sysdate())))', 0),
(32, '近一个月', 7, 1, 'dateline>=(UNIX_TIMESTAMP()-2592000) AND dateline<=UNIX_TIMESTAMP(timestamp(date(sysdate())))', 0),
(33, '1天内结束', 8, 1, 'endtime>=UNIX_TIMESTAMP(timestamp(date(sysdate()))) AND endtime<=(UNIX_TIMESTAMP()+86400) AND process!=5', 0),
(34, '3天内结束', 8, 1, 'endtime>=UNIX_TIMESTAMP(timestamp(date(sysdate()))) AND endtime<=(UNIX_TIMESTAMP()+259200) AND process!=5', 0),
(35, '5天内结束', 8, 1, 'endtime>=UNIX_TIMESTAMP(timestamp(date(sysdate()))) AND endtime<=(UNIX_TIMESTAMP()+432000) AND process!=5', 0),
(36, '7天内结束', 8, 1, 'endtime>=UNIX_TIMESTAMP(timestamp(date(sysdate()))) AND endtime<=(UNIX_TIMESTAMP()+604800) AND process!=5', 0),
(37, '15天内结束', 8, 1, 'endtime>=UNIX_TIMESTAMP(timestamp(date(sysdate()))) AND endtime<=(UNIX_TIMESTAMP()+1296000) AND process!=5', 0),
(38, '30天内结束', 8, 1, 'endtime>=UNIX_TIMESTAMP(timestamp(date(sysdate()))) AND endtime<=(UNIX_TIMESTAMP()+2592000) AND process!=5', 0),
(39, '大于30天', 8, 1, 'endtime>=(UNIX_TIMESTAMP()+2592000)', 0),
(48, '不保证选稿', 10, 0, 'credit=2', 0),
(47, '保证选稿', 10, 0, 'credit=1', 0),
(46, '招标', 1, 0, 'appid=83', 0),
(45, '悬赏', 1, 0, 'appid=80', 0);



INSERT INTO `phpapp_task_seller_select` (`catid`, `name`, `upid`, `displayorder`, `code`, `status`) VALUES
(2, '地区分类', 0, 1, '', 0),
(3, '实名认证', 0, 1, '', 0),
(4, '用户类型', 0, 1, '', 0),
(5, '卖家好评', 0, 1, '', 0),
(7, '注册时间', 0, 1, '', 0),
(11, '已实名认证', 3, 1, 'd.realname=0', 0),
(12, '个人', 4, 1, 'c.usertype=1', 0),
(13, '企业', 4, 1, 'c.usertype=2', 0),
(19, '10个好评内', 5, 1, 'f.credit<=10', 0),
(20, '10-20个好评', 5, 1, 'f.credit>=10 AND f.credit<=20', 0),
(21, '20-50个好评', 5, 1, 'f.credit>=20 AND f.credit<=50', 0),
(22, '大于100个好评', 5, 1, 'f.credit>=100', 0),
(28, '今日', 7, 1, 'c.dateline>=UNIX_TIMESTAMP(timestamp(date(sysdate())))  AND c.dateline<=(UNIX_TIMESTAMP()+86400)', 0),
(29, '昨日', 7, 1, 'c.dateline>=(UNIX_TIMESTAMP()-86400) AND c.dateline<=UNIX_TIMESTAMP(timestamp(date(sysdate())))', 0),
(30, '近三天', 7, 1, 'c.dateline>=(UNIX_TIMESTAMP()-259200) AND c.dateline<=UNIX_TIMESTAMP(timestamp(date(sysdate())))', 0),
(31, '近一周', 7, 1, 'c.dateline>=(UNIX_TIMESTAMP()-604800) AND c.dateline<=UNIX_TIMESTAMP(timestamp(date(sysdate())))', 0),
(32, '近一个月', 7, 1, 'c.dateline>=(UNIX_TIMESTAMP()-2592000) AND c.dateline<=UNIX_TIMESTAMP(timestamp(date(sysdate())))', 0),
(39, '大于30天', 8, 1, 'c.endtime>=(UNIX_TIMESTAMP()+2592000)', 0);



INSERT INTO `phpapp_task_seller_usergroup` (`gid`, `feetype`, `taskfee`, `unionfee`, `addunionfee`, `appallow`, `addtask`, `buyservice`, `uploadfilestask`, `edittask`, `realnametask`, `addnumbertask`, `maxmoneytask`, `smallmoneytask`) VALUES
(1, 0, 0.2, 0.02, 0.02, 0, 0, 0, 0, 0, 0, 10, '1000000.00', '10.00'),
(2, 0, 0.2, 0.02, 0.02, 0, 0, 0, 0, 0, 0, 10, '1000000.00', '10.00'),
(3, 0, 0.2, 0.02, 0.2, 0, 0, 0, 0, 0, 1, 100, '1000000.00', '10.00'),
(4, 0, 0.2, 0.02, 0.02, 0, 0, 0, 0, 0, 0, 10, '1000000.00', '10.00'),
(5, 0, 0.2, 0.02, 0.02, 0, 0, 0, 0, 0, 0, 10, '1000000.00', '10.00');


INSERT INTO `phpapp_category` (`catid`, `upid`, `name`, `route`, `photolist`, `skills`, `nexts`, `color`, `type`, `displayorder`, `total`, `title`, `keywords`, `description`, `classname`) VALUES
(1, 0, '设计', 'sheji', 0, '1,2', '1,2', '', '49', 0, 0, '设计', 'LOGO设计,站标设计', '网页LOGO设计,LOGO设计,站标设计', 'menu_promotion'),
(2, 1, '标志/LOGO', 'logo', 0, '1,2', '2', '#FF0000', '49', 0, 0, 'LOGO设计', 'LOGO设计,站标设计', '网页LOGO设计,LOGO设计,站标设计', '');



INSERT INTO `phpapp_skills` (`sid`, `name`, `route`, `color`, `total`, `displayorder`, `title`, `keywords`, `description`, `classname`) VALUES
(1, 'PHP', 'php', '', 0, 0, 'PHP语言', 'PHP语言,PHP程序', 'PHP设计,PHP语言,PHP程序', ''),
(2, 'Web', 'web', '', 0, 0, '', '', '', ''),
(3, 'CSS', 'css', '', 0, 0, '', '', '', ''),
(4, 'Photoshop', 'photoshop', '', 0, 0, '', '', '', ''),
(5, 'Apache', 'apache', '', 0, 0, '', '', '', ''),
(6, 'HTML', 'html', '', 0, 0, '', '', '', ''),
(7, 'XML', 'xml', '', 0, 0, '', '', '', '');