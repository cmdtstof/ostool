<?php
  $backup_server_name="180.186.33.223"; //数据库服务器名称
  $backup_username="dbcenter"; // 连接数据库用户名
  $backup_password="dbcenter2013"; // 连接数据库密码
  $backup_database="backup_zhengshi"; // 数据库的名字
  
  // 连接到数据库
  $backupconn=mysql_connect($backup_server_name, $backup_username,
                        $backup_password);
	  mysql_select_db($backup_database, $backupconn);
  mysql_query("set names 'GBK'");
?>

