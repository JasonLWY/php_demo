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


INSERT INTO phpapp_links (`displayorder`, `sitename`, `siteurl`, `description`, `logo`) VALUES( 0, 'PHPAPP', 'http://www.phpapp.cn', 'PHPAPP����ϵͳ','http://www.phpapp.cn/images/logo.gif');



INSERT INTO `phpapp_member_level` (`lid`, `title`, `small`, `big`, `style`, `color`) VALUES
(1, '��������', 0, 20, 'member_level1', ''),
(2, '��������', 21, 50, 'member_level2', ''),
(3, '�м�����', 51, 100, 'member_level3', ''),
(4, '�߼�����', 101, 200, 'member_level4', ''),
(5, 'Ԫ������', 201, 500, 'member_level5', ''),
(6, 'Ԫ˧����', 501, 999999999, 'member_level6', '#F00');



INSERT INTO `phpapp_nav` (`navid`, `navname`, `navurl`, `default`, `appid`, `blank`, `site`, `displayorder`) VALUES
(1, '��ҳ', 'index.php', 0, 56, 1, 0, 0),
(2, '�������', 'index.php?app=49', 0, 49, 1, 0, 0),
(3, '���˲�', 'index.php?app=55', 0, 55, 1, 0, 0),
(4, '�����', 'index.php?app=82', 0, 82, 1, 0, 0),
(5, '��������', 'member.php?app=9', 0, 9, 1, 0, 0),
(6, '��������', 'http://bbs.phpapp.cn', 0, 0, 1, 1, 10);



INSERT INTO `phpapp_nav_bottom` (`navid`, `navname`, `navurl`, `blank`, `displayorder`) VALUES
(1, '��������', 'index.php?app=23&action=1', 1, 0),
(2, '��ϵ��ʽ', 'index.php?app=23&action=2', 1, 0),
(3, '��������', 'index.php?app=23&action=3', 1, 0),
(4, '��վ��ͼ', 'index.php?app=46', 1, 0),
(6, '��������', 'index.php?app=57', 1, 0),
(5, '�ƹ�����', 'index.php?app=20', 0, 0);



INSERT INTO `phpapp_nav_top` (`navid`, `navname`, `navurl`, `blank`, `displayorder`) VALUES
(1, '��֤', 'member.php?app=12', 1, 0),
(2, '�ƹ�����', 'index.php?app=20', 1, 3);



INSERT INTO `phpapp_pay_tool` (`id_phpapp`, `name_phpapp`, `logo_phpapp`, `displayorder_phpapp`, `type_phpapp`, `status_phpapp`) VALUES
(52, '֧����', 'alipay_logo.gif', 0, 0, 0),
(56, '���л��', '', 99, 1, 0);




INSERT INTO `phpapp_prop` ( `appid`, `subject`, `content`, `day`, `count`, `price`, `status`, `icon`, `usergroup`, `sell`, `buynum`, `displayorder`, `type`) VALUES
(61, 'ȫվ��̬', '�������ڵ�������뵽ȫվ������̬��Ϣ', 1, 1, '0.00', 0, 'service_feed_icon', 3, 0, 10, 0, 0),
(63, '�б��Ƽ�', '�����������Ƽ��������б���(�ظ�ʹ�ÿ��Ծ�������)', 1, 0, '10.00', 0, 'service_top2_icon', 3, 0, 10, 10, 0),
(64, '���ظ��', '�������ύ�ĸ����ֻ����һ�˿ɼ�����������õĸ���ع⣡', 1, 1, '10.00', 0, 'service_draft_icon', 3, 0, 10, 0, 0),
(71, 'ʵ��Ͷ��', 'Ҫ��ʵ����֤�Ļ�Ա����Ͷ��', 1, 1, '10.00', 0, 'service_realnametask_icon', 3, 0, 10, 0, 0),
(63, '�б��Ƽ�', '�����ĸ���Ƽ���Ͷ���б���(�ظ�ʹ�ÿ��Ծ�������)', 1, 0, '10.00', 0, 'service_top2_icon', 3, 0, 10, 10, 1),
(64, '���ظ��', '���ύ�ĸ��ֻ�����͹����ɼ����������ĸ���عⱻ���ã�', 1, 1, '10.00', 0, 'service_draft_icon', 3, 0, 10, 0, 1),
(53, '��������', '�������������û���¼�ɼ���', 1, 1, '10.00', 0, 'service_task_icon', 3, 0, 10, 0, 0),
(61, 'ȫվ��̬', '�������ڵķ�����뵽ȫվ������̬��Ϣ', 1, 1, '0.00', 0, 'service_feed_icon', 3, 0, 10, 0, 2),
(63, '�б��Ƽ�', '�����ķ����Ƽ��ڷ����б���(�ظ�ʹ�ÿ��Ծ�������)', 1, 0, '10.00', 0, 'service_top2_icon', 3, 0, 10, 10, 2),
(71, 'ʵ���������', 'Ҫ��ʵ����֤�Ĺ������ܹ����ҵķ���', 1, 1, '10.00', 0, 'service_realnametask_icon', 3, 0, 10, 0, 2);



INSERT INTO `phpapp_sns` (`id_phpapp`, `app_phpapp`, `name_phpapp`, `icon_small_phpapp`, `icon_middle_phpapp`, `icon_big_phpapp`, `description_phpapp`, `status_phpapp`) VALUES
(1, 58, '����΢��', 'sina_icon_small', '', 'sina_icon_big', '����΢���ʺŵ�¼\r\n<p>ͨ������΢���ʺŵ�¼����վ.</p>', 0),
(2, 59, 'QQ΢��', 'qqweibo_icon_small', '', 'qqweibo_icon_big', 'QQ΢���ʺŵ�¼\r\n<p>ͨ��QQ΢���ʺŵ�¼����վ.</p>', 0),
(3, 65, 'QQ', 'qq_icon_small ', '', 'qq_icon_big', '<p>ͨ��QQ�ʺŵ�¼����վ.</p>', 0),
(4, 66, '�Ա�', 'taobao_icon_small', '', 'taobao_icon_big', '<p>ͨ���Ա��ʺŵ�¼����վ.</p>', 0),
(5, 67, '����΢��', 'netease_icon_small', '', 'netease_icon_big', '<p>ͨ������΢���ʺŵ�¼����վ.</p>', 0),
(6, 69, '�Ѻ�', 'sohu_icon_small', '', 'sohu_icon_big', '<p>ͨ���Ѻ��ʺŵ�¼����վ.</p>', 0);


INSERT INTO `phpapp_space_style` (`sid`, `style`, `dir`, `type`, `usergroup`, `status`) VALUES
(1, 'Ĭ�Ϸ��', 'default', 0, 0, 0),
(2, '����·', 'grain', 0, 0, 0),
(3, '����', 'dynamic', 0, 0, 0),
(4, '��ɫ����', 'blue', 0, 0, 0);



INSERT INTO `phpapp_templateblock` (`id_phpapp`, `apps_phpapp`, `label_phpapp`, `quote_phpapp`, `status_phpapp`) VALUES
(1, 9, '��Ա������ҳ', 'memberhome', 0),
(2, 56, '��վ��ҳ-���ϲ˵�', 'shortcutmenu', 0),
(3, 56, '��վ��ҳ-�õ�Ƭ', 'defaultslide', 0),
(4, 56, '��վ��ҳ-���', 'scrollad', 0),
(5, 56, '��վ��ҳ-����-���ֵ�', 'publish', 0),
(6, 56, '��վ��ҳ-PHPAPP2.0ͷ��', 'defaulttoptwo', 1),
(7, 56, '��վ��ҳ-PHPAPP2.0�����б�', 'taskshowtwo', 1),
(8, 56, '��վ��ҳ-���ӷ��������б�', 'gridtask', 1),
(9, 82, '��վ��ҳ-������', 'sellerserviceshow', 0),
(10, 56, '��վ��ҳ-�ײ�����', 'defaulthelp', 0),
(11, 56, '��վ��ҳ-��������', 'defaultlink', 0),
(12, 22, '��վ����', 'search', 0),
(13, 56, '��վ��ҳ-���ӷ����˲��б�', 'gridjobs', 1),
(14, 56, '��վ��ҳ-���ӷ�������б�', 'gridservice', 1),
(15, 56, '��վ��ҳ-���Ӷ���', 'gridtop', 1),
(16, 56, '��վ��ҳ-���ӻõ�Ƭ', 'gridslide', 1),
(17, 56, '��վ��ҳ-���ɶ���', 'freetop', 0),
(18, 56, '��վ��ҳ-free��ҳ����', 'freeprocess', 0),
(19, 56, '��վ��ҳ-���������б�', 'freetask', 0),
(20, 56, '��վ��ҳ-������ҳ����', 'freeskills', 0),
(21, 56, '��վ�������', 'ad_double', 1);



INSERT INTO `phpapp_union` (`id_phpapp`, `rebate_phpapp`, `service_phpapp`, `status_phpapp`) VALUES
(1, 0.1, 1, 0),
(2, 0.1, 2, 0),
(3, 0.1, 3, 0),
(4, 0.1, 4, 0),
(5, 0.1, 5, 0),
(6, 0.1, 6, 0),
(7, 0.1, 7, 0);




INSERT INTO `phpapp_apps_credit` (`id_phpapp`, `name_phpapp`, `apps_phpapp`, `action_phpapp`, `usergroup_phpapp`, `number_phpapp`, `credit_phpapp`, `status_phpapp`) VALUES
(1, '��¼����', 2, 1, 3, 30, 10, 0),
(19, '���ֶһ�', 4, 1, 3, 10, 10, 0),
(31, '���͵���', 80, 12, 3, 100, 1, 0),
(15, '���ٵ�¼', 2, 12, 3, 5, 20, 0),
(17, 'ע��ҳ��', 2, 2, 3, 1, 8, 0),
(20, '�������񷢲����֧��', 80, 4, 3, 50, 10, 0),
(21, '���͸�����', 80, 11, 3, 100, 12, 0),
(30, '����Ͷ��', 80, 6, 3, 30, 5, 0),
(32, '������������', 80, 8, 3, 10, 2, 0);




INSERT INTO `phpapp_member_message_type` (`mid`, `subject`, `displayorder`, `satus`, `notice`, `email`, `phone`) VALUES
(1, '���ҷ�����ɹ�,��֪ͨ��', 0, 0, 0, 0, 1),
(2, '���ҵ�������Ͷ��ʱ,��֪ͨ��', 0, 0, 0, 0, 1),
(3, '�����б�ʱ,��֪ͨ��', 0, 0, 0, 0, 1),
(4, '���ұ�ѡ���б�ʱ,��֪ͨ��', 0, 0, 0, 0, 1),
(5, '��������ɹ���ʱ,��֪ͨ��', 0, 0, 0, 0, 1),
(6, '������ȷ��֧��ʱ,��֪ͨ��', 0, 0, 0, 0, 1),
(7, '���ұ��ٱ�ʱ,��֪ͨ��', 0, 0, 0, 0, 1),
(8, '����������������ʱ,��֪ͨ��', 0, 0, 0, 0, 1),
(9, '�������ڶ�����Ҫ�󿪷�Ʊʱ,��֪ͨ��', 0, 0, 0, 0, 1),
(10, '���Է��ڶ���������ʱ,��֪ͨ��', 0, 0, 0, 0, 1),
(11, '��Ͷ������񵱹�������ӼۼӼ�ʱ,��֪ͨ��', 0, 0, 0, 0, 1),
(12, '���һ�ȡ���ƹ�ӵ��ʱ,��֪ͨ��', 0, 0, 0, 0, 1),
(13, '�������������,��֪ͨ��', 0, 0, 0, 0, 1),
(14, '���Է����۶���ʱ,��֪ͨ��', 0, 0, 0, 0, 1),
(15, '���������⽱����ʱ,��֪ͨ��', 0, 0, 0, 0, 1),
(16, '�����Ҹ���ĵ���ʱ,��֪ͨ��', 0, 0, 0, 0, 1),
(17, '���ҳɹ��˶������߱��Ϸ���ʱ,��֪ͨ��', 0, 0, 0, 0, 1),
(18, '�����յ�����άȨʱ,��֪ͨ��', 0, 0, 0, 0, 1),
(19, '�����յ��˿�ʱ,��֪ͨ��', 0, 0, 0, 0, 1),
(20, '�����˿�ɹ�ʱ,��֪ͨ��', 0, 0, 0, 0, 1),
(22, '���ҵ��������ʱ,��֪ͨ��', 0, 0, 0, 0, 1),
(23, '���ҵ���ֵ�������ʱ,��֪ͨ��', '0', '0', '0', '0', '1');



INSERT INTO `phpapp_refund_item` (`pid`, `project`, `status`) VALUES
(1, '����û��ԭ���', 0),
(2, '����û�а�Ҫ�����', 0),
(3, '�����������������', 0),
(4, '����', 0);



INSERT INTO `phpapp_report_type` (`rid`, `type`, `name`) VALUES
(1, 0, '�����������'),
(2, 0, '����������Ϣ'),
(3, 0, '����ɫ����Ϣ'),
(4, 0, '������ϵ��ʽ'),
(5, 2, '������ӳ�Ϯ'),
(6, 2, '����������󲻺ϸ�');
