<?php  
/** 
 * File name:client.php 
 * �ͻ��˴��� 
 *  
 * @author guisu.huang 
 * @since 2012-04-11 
 */  
set_time_limit(0);  
  
$host = "127.0.0.1";  
$port = 10005;  
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)or die("Could not create  socket\n"); // ����һ��Socket  
   
$connection = socket_connect($socket, $host, $port) or die("Could not connet server\n");    //  ����  
socket_write($socket, "hello socket") or die("Write failed\n"); // ���ݴ��� �������������Ϣ  
while ($buff = socket_read($socket, 1024, PHP_NORMAL_READ)) {  
    echo("Response was:" . $buff . "\n");  
}  
socket_close($socket);  
?>