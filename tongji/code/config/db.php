<?php
  $db_server_name="127.0.0.1"; //��ݿ���������
  $db_username="luanzhan"; // l����ݿ��û���
  $db_password="gbits2013"; // l����ݿ�����
  $database="tongji"; // ��ݿ������
  
  $conn=mysql_connect($db_server_name, $db_username,
                        $db_password);
	  mysql_select_db($database, $conn);
  mysql_query("set names 'GBK'");
?>

