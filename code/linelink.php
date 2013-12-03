<?php

header('Content-type: text/html;charset=gbk');
error_reporting(E_ERROR);

if(!isset($_POST["host"])|| $_POST["host"]==""){
}else{
	if(!isset($_POST["port"])|| $_POST["port"]==""){
	}else{
		if(!isset($_POST["linename"])|| $_POST["linename"]==""){
		}else{
			$str=urldecode($_POST["linename"]);
			$str =iconv("UTF-8","GBK",$str); //编码转换
			//echo $_POST["host"].':'.$_POST["port"].$str.'<br/>';
			lineceshi($_POST["host"],$_POST["port"],$str);
		}
	}
}

function lineceshi($host, $port, $name){

	//echo $name."[".$host.":".$port."]";
	set_time_limit(10);
	$openID = "";
	$roleName = "";

	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or exit();  //创建一个Socket

	$connection = socket_connect($socket, $host, $port) ;    //  连接

	$result = "";
	if($connection){
		$ts =  floor(getMillisecond()/1000);
		$msg = "tgw_l7_forward\r\nHost:".$host.":".$port."\r\n\r\n";
		$sm = "{\"account\":\"".$openID."\",\"name\":\"".$roleName."\"}";
		$sm1 = "{\\\"account\\\":\\\"".$openID."\\\",\\\"name\\\":\\\"".$roleName."\\\"}";
		$message = "account_name_check:".$sm;
		$message1 = "account_name_check:".$sm1;
		$s = Md5($message.$ts."G-bits2TOP");
		$msg1 = "h#d{\"message\":\"".$message1."\",\"ts\":\"".$ts."\",\"sign\":\"".$s."\"}t#l";

		$r1 =$msg.$msg1;
		//echo $r1.'<br/>';
		socket_write($socket,$r1) or die("Write failed\n"); // 数据传送 向服务器发送消息
		$count=0;
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
	}
		socket_close($socket);

	//ECHO $result;
	if($result==''){
		echo '<font color="red" >连接失败</font><br/>';
	}else{
		echo '<font color="green" >连接成功</font><br/>';
	}
}

function getMillisecond() {
	list($s1, $s2) = explode(' ', microtime());
	return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
}
?>