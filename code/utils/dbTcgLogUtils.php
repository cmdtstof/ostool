<?php
  $tcglog_server_name="211.155.83.10"; //���ݿ����������
  $tcglog_username="dbcenter"; // �������ݿ��û���
  $tcglog_password="dbcenter2013"; // �������ݿ�����
  $tcglog_database="qq_neice"; // ���ݿ������  
  
  // ���ӵ����ݿ�
  $tcglogconn=mysql_connect($tcglog_server_name, $tcglog_username,
                        $tcglog_password);
  mysql_select_db($tcglog_database, $tcglogconn);
  mysql_query("set names 'GBK'");
?>

