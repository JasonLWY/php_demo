<?php

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


define('S_START_TIME',microtime(true)); 

//-------------------------------------------------------------------------------------------
//Session
session_start();                                                  // ���� Session

//-------------------------------------------------------------------------------------------

//·���趨

define('SDIR','');                                        //����·�� (��Ŀ¼����)

//SURL
define('SURL','http://'.$_SERVER ['HTTP_HOST'].SDIR);              //��վ��ַ

//SYS
define('SYS',preg_replace("/\\\/", '/', dirname(__FILE__) ) );     //ϵͳ��·��

//Core
define('Core',SYS.'/apps/core' );                                

//Apps
define('APPS',SYS.'/apps' );                                      //Ӧ�ø�·��

//---------------------------------------------------------------------------------------------

//��վ����

define('S_CHARSET','gbk');                    //��վ�ַ�����ʹ��ҳ������

define('S_TEMPLATE','default');               //վ��Ŀǰʹ�õķ��Ŀ¼�� default ΪϵͳĬ�Ϸ��

define('S_CACHE_TIME','18000');                //ģ�建���������ʱ�� ��λ�� 18000

define('S_REWRITE_URL','0');                  //α��̬���� 1 Ϊ�� 0 Ϊ��

define('S_CACHE_MEMORY_OPEN','0');            //�ڴ滺��   0 �� 1 ��

define('S_CACHE_MEMORY_CONNECT','0');         //�ڴ滺��־�����   0 �� 1 ��

define('S_SITE_SQL',0);                       //��̨�Ƿ����ִ��SQL 1 ���� 0 �ر�

define('S_ADMIN','1');                        //����Ա UID, ����֧�ֶ������Ա��֮��ʹ�� ��,�� �ָ��� 

define('S_HTML_ALLOW','<a><p><br></br><u><i><b><strong><img><em><span><div><font><h1><h2><h3><h4><h5><h6><ul></li><ol><table><tr><td>');  //�༭����ǩ


//---------------------------------------------------------------------------------------------

//�ϴ�Ŀ¼�趨

define('S_ATTACHMENT_DIR','attachment');      //�ϴ�Ŀ¼

define('S_UPLOAD_DIR',S_ATTACHMENT_DIR.'/upload'); //�ϴ��ļ�Ŀ¼

define('S_UPLOAD_CERTIFICATE_DIR',S_ATTACHMENT_DIR.'/certificate'); //�ϴ�֤��Ŀ¼

define('S_BACKUP_DIR',SYS.'/data/backup');   //�趨���ݿⱸ��Ŀ¼

//---------------------------------------------------------------------------------------------

//���ݿ�����

define('DB_HOST','localhost');                //��������ַ

define('DB_USER','mmsuinikan');                     //�û���

define('DB_PW','123456ddff');                      //����

define('DB_NAME','123mmsuinikanff');                  //���ݿ���

define('DB_TNAME','phpapp_');                 //����ǰ׺

define('DB_CHARSET','gbk');                  //���ݿ��ַ���

define('DB_CONNECT','0');                   //���ݿ�־����� 0 �� 1 ��


//��վ��־����

define('S_SITE_LOG',0);                       //��̨�Ƿ�����վ��־ 1 ���� 0 �ر�

define('S_SITE_LOG_SIZE',1024000);            //������վ��־�ļ���С ��λ �ֽ�

?>