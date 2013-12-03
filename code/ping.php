<?php

//$host = '10.204.144.129';
$host = '10.204.199.115';
$port = '8007';

$num = 3; //Ping次数

//获取时间

function mt_f (){

	list($usec,$sec) = explode(" ",microtime());

	return ((float)$usec + (float)$sec); //微秒加秒

}

function ping_f($host,$port){

	$time_s = mt_f();

	$ip = gethostbyname($host);

	$fp = @fsockopen($host,$port);

	if(!$fp)

	return 'reply time out!';

	$get = "GET / HTTP/1.1\r\nHost:".$host."\r\nConnect:".$port."Close\r\n";

	fputs($fp,$get);

	fclose($fp);

	$time_e = mt_f();

	$time = $time_e - $time_s;

	$time = ceil($time * 1000);

	return 'reply from '.$ip.':'.$port.' time = '.$time.'ms<br />';

}

echo 'ping to '.$host.' ['.gethostbyname($host).'] with port:'.$port.' of data:<br />';

for($i = 0;$i < $num;$i++){

	echo ping_f($host,$port);

	//每次运行中间间隔1S

	sleep(1);

	//刷新输出缓存

	ob_flush();

	flush();

}

?>