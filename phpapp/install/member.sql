INSERT INTO `phpapp_member_type` (`id_phpapp`, `name_phpapp`, `table_phpapp`, `status_phpapp`) VALUES(1, '����', 'member_personal', 0);
INSERT INTO `phpapp_member_type` (`id_phpapp`, `name_phpapp`, `table_phpapp`, `status_phpapp`) VALUES(2, '��˾', 'member_company', 0);

INSERT INTO `phpapp_usergroup` (`gid`, `usertype`, `groupname`, `icon`, `color`, `allowdomainname`, `allowlogin`, `allowskillnumber`) VALUES
(1, 1, 'վ�����Ա', '', '', 0, 0, 6),
(2, 1, 'VIP��Ա', '', '', 0, 0, 8),
(3, 1, '��ͨ��Ա', '', '', 0, 0, 5),
(4, 2, 'VIP��˾', '', '', 0, 0, 6),
(5, 2, '��ͨ��˾', '', '', 0, 0, 6);

