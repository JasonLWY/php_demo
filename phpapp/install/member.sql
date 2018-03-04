INSERT INTO `phpapp_member_type` (`id_phpapp`, `name_phpapp`, `table_phpapp`, `status_phpapp`) VALUES(1, '个人', 'member_personal', 0);
INSERT INTO `phpapp_member_type` (`id_phpapp`, `name_phpapp`, `table_phpapp`, `status_phpapp`) VALUES(2, '公司', 'member_company', 0);

INSERT INTO `phpapp_usergroup` (`gid`, `usertype`, `groupname`, `icon`, `color`, `allowdomainname`, `allowlogin`, `allowskillnumber`) VALUES
(1, 1, '站点管理员', '', '', 0, 0, 6),
(2, 1, 'VIP会员', '', '', 0, 0, 8),
(3, 1, '普通会员', '', '', 0, 0, 5),
(4, 2, 'VIP公司', '', '', 0, 0, 6),
(5, 2, '普通公司', '', '', 0, 0, 6);

