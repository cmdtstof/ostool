<?php

  $tcg_server_name="10.204.153.101"; //数据库服务器名称
  $tcg_username="chenyl"; // 连接数据库用户名
  $tcg_password="gbits2013"; // 连接数据库密码
  $tcg_database="tcg"; // 数据库的名字
  
    // 连接到数据库
 if (!isset($tcgconn) || !$tcgconn){
	  $tcgconn=mysql_connect($tcg_server_name, $tcg_username,
							$tcg_password);
	
	  mysql_select_db($tcg_database, $tcgconn);
	  mysql_query("set names 'GBK'");
  }
?>

