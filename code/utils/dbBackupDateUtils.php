<?php
  $backup_server_name="180.186.33.223"; //���ݿ����������
  $backup_username="dbcenter"; // �������ݿ��û���
  $backup_password="dbcenter2013"; // �������ݿ�����
  $backup_database="backup_zhengshi"; // ���ݿ������
  
  // ���ӵ����ݿ�
  $backupconn=mysql_connect($backup_server_name, $backup_username,
                        $backup_password);
	  mysql_select_db($backup_database, $backupconn);
  mysql_query("set names 'GBK'");
?>

