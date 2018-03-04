INSERT INTO `phpapp_slide` (`sid`, `appid`, `subject`, `link`, `image`, `displayorder`, `status`) VALUES
(1, 56, 'PHPAPP官方', 'http://www.phpapp.cn', './images/ad/grid_big_slide.jpg', 0, 0),
(2, 56, 'PHPAPP2.5演示', 'http://demo.phpapp.cn', './images/ad/phpapp2_big_slide.jpg', 0, 0);


INSERT INTO `phpapp_userguide` (`sid`, `appid`, `subject`, `link`, `image`, `displayorder`, `status`) VALUES
(1, 56, '第一张', 'http://www.phpapp.cn', '/images/userguide/default1.png', 0, 0),
(2, 56, '第二张', 'http://www.phpapp.cn', '/images/userguide/default2.png', 0, 0);


INSERT INTO `phpapp_advertising` (`id_phpapp`, `apps_phpapp`, `key_phpapp`, `name_phpapp`, `margin_phpapp`, `type_phpapp`, `parameters_phpapp`, `code_phpapp`, `displayorder_phpapp`, `status_phpapp`) VALUES
(1, 56, 'Default1', '网站顶部通栏广告', 'bottom:10px', 'img', 'a:5:{s:8:\"imgwidth\";i:0;s:9:\"imgheight\";i:0;s:7:\"imglink\";s:26:\"./images/ad/920px-80px.gif\";s:6:\"imgurl\";s:26:\"./images/ad/920px-80px.gif\";s:10:\"imgdescrip\";s:14:\"920px-80px.gif\";}', '<div style=\"margin-bottom:10px\"><a href=\"./images/ad/920px-80px.gif\" target=\"_blank\" title=\"920px-80px.gif\"><img src=\"./images/ad/920px-80px.gif\"   alt=\"920px-80px.gif\"/></a></div>', 0, 1),
(2, 56, 'Default2', '网站通栏底部', 'top:10px', 'img', 'a:5:{s:8:\"imgwidth\";i:0;s:9:\"imgheight\";i:0;s:7:\"imglink\";s:26:\"./images/ad/920px-80px.gif\";s:6:\"imgurl\";s:26:\"./images/ad/920px-80px.gif\";s:10:\"imgdescrip\";s:14:\"920px-80px.gif\";}', '<div style=\"margin-top:10px\"><a href=\"./images/ad/920px-80px.gif\" target=\"_blank\" title=\"920px-80px.gif\"><img src=\"./images/ad/920px-80px.gif\"   alt=\"920px-80px.gif\"/></a></div>', 0, 1),
(3, 49, 'TaskMode3', '任务右栏广告', 'top:10px', 'img', 'a:5:{s:8:\"imgwidth\";i:0;s:9:\"imgheight\";i:0;s:7:\"imglink\";s:27:\"./images/ad/270px-200px.gif\";s:6:\"imgurl\";s:27:\"./images/ad/270px-200px.gif\";s:10:\"imgdescrip\";s:15:\"270px-200px.gif\";}', '<div style=\"margin-top:10px\"><a href=\"./images/ad/270px-200px.gif\" target=\"_blank\" title=\"270px-200px.gif\"><img src=\"./images/ad/270px-200px.gif\"   alt=\"270px-200px.gif\"/></a></div>', 0, 1);