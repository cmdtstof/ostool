<?php
/**
 * File name:client.php
 * 客户端代码
 *
 * @author guisu.huang
 * @since 2012-04-11
 */
//header('Content-type: text/html;charset=iso-8859-1');


set_time_limit(10);
$host = "s11.app100658054.qqopenapp.com";
$port = 8004;
$openID = "9613523E247BD5BAD73C075EEC5FA2EE";
$roleName = mb_convert_encoding("大西瓜","utf-8","GBK");

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)or die("Could not create  socket\n"); // 创建一个Socket

$connection = socket_connect($socket, $host, $port) or die("Could not connet server\n");    //  连接

$ts =  floor(getMillisecond()/1000);
$msg = "tgw_l7_forward\r\nHost:".$host.":".$port."\r\n\r\n";
$sm = "{\"account\":\"".$openID."\",\"name\":\"".$roleName."\"}";
$sm1 = "{\\\"account\\\":\\\"".$openID."\\\",\\\"name\\\":\\\"".$roleName."\\\"}";
$message = "account_name_check:".$sm;
$message1 = "account_name_check:".$sm1;
$s = Md5($message.$ts."G-bits2TOP");
$msg1 = "h#d{\"message\":\"".$message1."\",\"ts\":\"".$ts."\",\"sign\":\"".$s."\"}t#l";

//System.out.println("发送：" + "\n" + msg + msg1);

$r1 =$msg.$msg1;
//$r2="tgw_l7_forward\r\nHost:s11.app100658054.qqopenapp.com:8004\r\n\r\nh#d{\"message\":\"account_name_check:{\\\"account\\\":\\\"4fc8c402297ab7f0f87c2f7a3d4da563\\\",\\\"name\\\":\\\"nights07\\\"}\",\"ts\":\"".$ts."\",\"sign\":\"ec265b4b45be643416a9ba177ae7442e\"}t#l";
echo $r1;
//echo "\n";
//echo $r2;
echo"<br/>";
socket_write($socket,$r1) or die("Write failed\n"); // 数据传送 向服务器发送消息
$count=0;
$result = "";
while (false !=socket_recv($socket,$buff,1,MSG_WAITALL)) {
	$result = $result.$buff;

	if(strlen($result)>3){
		$zzz = substr($result,strlen($result)-3,3);
		if($zzz=="t#l"){
			$count++;
			if($count==2){
				break;
			}
		}
	}
}
echo $result;
socket_close($socket);




function getMillisecond() {
	list($s1, $s2) = explode(' ', microtime());
	return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
}


?>