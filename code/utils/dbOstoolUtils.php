<?php

  $os_server_name="211.155.83.10"; //���ݿ����������
  $os_username="dbcenter"; // �������ݿ��û���
  $os_password="dbcenter2013"; // �������ݿ�����
  $os_database="lztool"; // ���ݿ������
  
  // ���ӵ����ݿ�
  $osconn=mysql_connect($os_server_name, $os_username,
                        $os_password);
	mysql_select_db($os_database, $osconn);
  mysql_query("set names 'GBK'");
?>

