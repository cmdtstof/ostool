<?php

  $tcg_server_name="10.204.153.101"; //���ݿ����������
  $tcg_username="chenyl"; // �������ݿ��û���
  $tcg_password="gbits2013"; // �������ݿ�����
  $tcg_database="tcg"; // ���ݿ������
  
    // ���ӵ����ݿ�
 if (!isset($tcgconn) || !$tcgconn){
	  $tcgconn=mysql_connect($tcg_server_name, $tcg_username,
							$tcg_password);
	
	  mysql_select_db($tcg_database, $tcgconn);
	  mysql_query("set names 'GBK'");
  }
?>

