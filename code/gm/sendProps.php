<?php
/**
 * File name:client.php
 * 客户端代码
 *
 * @author guisu.huang
 * @since 2012-04-11
 */
//header('Content-type: text/html;charset=iso-8859-1');
$host = "s11.app100658054.qqopenapp.com";
$port = 8004;

function gm_addCard(){
	set_time_limit(10);
	$openID = "9613523E247BD5BAD73C075EEC5FA2EE";
	$roleName = mb_convert_encoding("果汁分你一半","utf-8","GBK");
	$cardId = 44;
	$cardNum = 1;
	$remark = mb_convert_encoding("测试","utf-8","GBK");

	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)or die("Could not create  socket\n"); // 创建一个Socket
	$connection = socket_connect($socket, $host, $port) or die("Could not connet server\n");    //  连接

	$ts =  floor(getMillisecond()/1000);
	$msg = "tgw_l7_forward\r\nHost:".$host.":".$port."\r\n\r\n";
	//$sm = "{\"user_gm_mgr_msg\",{\"add_money_to_user\",\"".$roleName."\",1,},}";
	//$sm1 = "{\\\"user_gm_mgr_msg\\\",{\\\"add_money_to_user\\\",\\\"".$roleName."\\\",1,},}";
	$sm = "{\"user_gm_mgr_msg\",{\"add_card_to_user\",\"".$roleName."\",".$cardId.",".$cardNum.",\"".$remark."\",},}";
	$sm1 = "{\\\"user_gm_mgr_msg\\\",{\\\"add_card_to_user\\\",\\\"".$roleName."\\\",".$cardId.",".$cardNum.",\\\"".$remark."\\\",},}";
	//积分
	//$sm = "{\"user_gm_mgr_msg\",{\"add_score_to_user\",\"".$roleName."\",1,\"123123\",},}";
	//$sm1 = "{\\\"user_gm_mgr_msg\\\",{\\\"add_score_to_user\\\",\\\"".$roleName."\\\",1,\\\"123123\\\",},}";

	$message = "gm_msg:".$sm;
	$message1 = "gm_msg:".$sm1;
	$s = Md5($message.$ts."G-bits2TOP");
	$msg1 = "h#d{\"message\":\"".$message1."\",\"ts\":\"".$ts."\",\"sign\":\"".$s."\"}t#l";

	$r1 =$msg.$msg1;
	echo"<br/>";
	socket_write($socket,$r1) or die("Write failed\n"); // 数据传送 向服务器发送消息
	$count=0;
	$result = "";
	echo $r1;
	echo"<br/>";
	while (false !=socket_recv($socket,$buff,150,MSG_WAITALL)) {
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
		break;
	}
	echo $result;
	socket_close($socket);

}

function gm_addScore($name,$n,$rem){
	set_time_limit(10);
	$host = "s11.app100658054.qqopenapp.com";
	$port = 8004;
	$openID = "9613523E247BD5BAD73C075EEC5FA2EE";
	$roleName = mb_convert_encoding($name,"utf-8","GBK");
	$score = $n;
	$remark = mb_convert_encoding($rem,"utf-8","GBK");

	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)or die("Could not create  socket\n"); // 创建一个Socket

	$connection = socket_connect($socket, $host, $port) or die("Could not connet server\n");    //  连接

	$ts =  floor(getMillisecond()/1000);
	$msg = "tgw_l7_forward\r\nHost:".$host.":".$port."\r\n\r\n";
	//$sm = "{\"user_gm_mgr_msg\",{\"add_money_to_user\",\"".$roleName."\",1,},}";
	//$sm1 = "{\\\"user_gm_mgr_msg\\\",{\\\"add_money_to_user\\\",\\\"".$roleName."\\\",1,},}";

	//$sm = "{\"user_gm_mgr_msg\",{\"add_card_to_user\",\"".$roleName."\",44,2,\"ceshi\",},}";
	//$sm1 = "{\\\"user_gm_mgr_msg\\\",{\\\"add_card_to_user\\\",\\\"".$roleName."\\\",44,2,\\\"ceshi\\\",},}";

	//积分
	$sm = "{\"user_gm_mgr_msg\",{\"add_score_to_user\",\"".$roleName."\",".$score.",\"".$remark."\",},}";
	$sm1 = "{\\\"user_gm_mgr_msg\\\",{\\\"add_score_to_user\\\",\\\"".$roleName."\\\",".$score.",\\\"".$remark."\\\",},}";
	$message = "gm_msg:".$sm;
	$message1 = "gm_msg:".$sm1;
	$s = Md5($message.$ts."G-bits2TOP");
	$msg1 = "h#d{\"message\":\"".$message1."\",\"ts\":\"".$ts."\",\"sign\":\"".$s."\"}t#l";

	$r1 =$msg.$msg1;

	echo"<br/>";
	socket_write($socket,$r1) or die("Write failed\n"); // 数据传送 向服务器发送消息
	$count=0;
	$result = "";
	echo $r1;
	echo"<br/>";
	while (false !=socket_recv($socket,$buff,100,MSG_WAITALL)) {
		$result = $result.$buff;
		if(strlen($result)>3 && strlen($result)==100){
			$zzz = substr($result,strlen($result)-3,3);
			if($zzz=="t#l"){
				$count++;
				if($count==2){
					break;
				}
			}
		}
		if(strlen($result)<100){
			break;
		}
	}
	echo $result;
	socket_close($socket);
}


function gm_addItem($name,$prop,$n,$rem){
	set_time_limit(10);
	$host = "s11.app100658054.qqopenapp.com";
	$port = 8004;
	$openID = "9613523E247BD5BAD73C075EEC5FA2EE";
	$roleName = mb_convert_encoding($name,"utf-8","GBK");
	$itemId = $prop;
	$itemNum = $n;
	$remark = mb_convert_encoding($rem,"utf-8","GBK");

	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)or die("Could not create  socket\n"); // 创建一个Socket

	$connection = socket_connect($socket, $host, $port) or die("Could not connet server\n");    //  连接

	$ts =  floor(getMillisecond()/1000);
	$msg = "tgw_l7_forward\r\nHost:".$host.":".$port."\r\n\r\n";
	//$sm = "{\"user_gm_mgr_msg\",{\"add_money_to_user\",\"".$roleName."\",1,},}";
	//$sm1 = "{\\\"user_gm_mgr_msg\\\",{\\\"add_money_to_user\\\",\\\"".$roleName."\\\",1,},}";

	$sm = "{\"user_gm_mgr_msg\",{\"add_item_to_user\",\"".$roleName."\",".$itemId.",".$itemNum.",\"".$remark."\",},}";
	$sm1 = "{\\\"user_gm_mgr_msg\\\",{\\\"add_item_to_user\\\",\\\"".$roleName."\\\",".$itemId.",".$itemNum.",\\\"".$remark."\\\",},}";

	//积分
	//$sm = "{\"user_gm_mgr_msg\",{\"add_score_to_user\",\"".$roleName."\",1,\"123123\",},}";
	//$sm1 = "{\\\"user_gm_mgr_msg\\\",{\\\"add_score_to_user\\\",\\\"".$roleName."\\\",1,\\\"123123\\\",},}";
	$message = "gm_msg:".$sm;
	$message1 = "gm_msg:".$sm1;
	$s = Md5($message.$ts."G-bits2TOP");
	$msg1 = "h#d{\"message\":\"".$message1."\",\"ts\":\"".$ts."\",\"sign\":\"".$s."\"}t#l";

	$r1 =$msg.$msg1;

	echo"<br/>";
	socket_write($socket,$r1) or die("Write failed\n"); // 数据传送 向服务器发送消息
	$count=0;
	$result = "";
	echo $r1;
	echo"<br/>";
	while (false !=socket_recv($socket,$buff,100,MSG_WAITALL)) {
		$result = $result.$buff;
		if(strlen($result)>3 && strlen($result)==100){
			$zzz = substr($result,strlen($result)-3,3);
			if($zzz=="t#l"){
				$count++;
				if($count==2){
					break;
				}
			}
		}
		if(strlen($result)<100){
			break;
		}
	}
	echo $result;
	socket_close($socket);
}
//gm_addScore("GMT",2000000,"测试");
function  getFileData($filename,$cmd){

	// 从表中提取信息的sql语句
	require '../utils/dbOstoolUtils.php';
	$strsql="SELECT rolename,propsId,num,remark from buchang where filename like '%".$filename."%'";


	//echo $strsql;
	// 执行sql查询
	$result=mysql_query($strsql, $osconn);
	// 获取查询结果
	if(mysql_num_rows($result)>0){
		// 定位到第一条记录
		mysql_data_seek($result, 0);
		// 循环取出记录
		while ($row=mysql_fetch_row($result))
		{
			if($cmd=="1"){ // 积分
				gm_addScore($row[0],$row[2],$row[3]."_".$filename);
			}else if($cmd=="2"){// 卡牌
				gm_addCard($row[0],$row[1],$row[2],$row[3]."_".$filename);
			}else if($cmd=="3"){// 物品
				gm_addItem($row[0],$row[1],$row[2],$row[3]."_".$filename);
			}else{
			}
		}
	}
	// 释放资源
	mysql_free_result($result);
	// 关闭连接
	mysql_close($osconn);
}
//
function getMillisecond() {
	list($s1, $s2) = explode(' ', microtime());
	return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
}


?>