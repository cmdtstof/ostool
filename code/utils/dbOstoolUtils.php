<?php

  $os_server_name="211.155.83.10"; //数据库服务器名称
  $os_username="dbcenter"; // 连接数据库用户名
  $os_password="dbcenter2013"; // 连接数据库密码
  $os_database="lztool"; // 数据库的名字
  
  // 连接到数据库
  $osconn=mysql_connect($os_server_name, $os_username,
                        $os_password);
	mysql_select_db($os_database, $osconn);
  mysql_query("set names 'GBK'");
?>

