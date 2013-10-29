<?php
  $tcglog_server_name="211.155.83.10"; //数据库服务器名称
  $tcglog_username="dbcenter"; // 连接数据库用户名
  $tcglog_password="dbcenter2013"; // 连接数据库密码
  $tcglog_database="qq_neice"; // 数据库的名字  
  
  // 连接到数据库
  $tcglogconn=mysql_connect($tcglog_server_name, $tcglog_username,
                        $tcglog_password);
  mysql_select_db($tcglog_database, $tcglogconn);
  mysql_query("set names 'GBK'");
?>

