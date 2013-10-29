<?php
/**
 * File name:client.php
 * �ͻ��˴���
 *
 * @author guisu.huang
 * @since 2012-04-11
 */
//header('Content-type: text/html;charset=iso-8859-1');
$host = "s11.app100658054.qqopenapp.com";
$port = 8004;

function gm_addCard($name,$prop,$n,$rem){
	set_time_limit(10);
	global $host;
	global $port;
	$openID = "9613523E247BD5BAD73C075EEC5FA2EE";
	$roleName = mb_convert_encoding($name,"utf-8","GBK");
	$cardId = $prop;
	$cardNum = $n;
	$remark = mb_convert_encoding($rem,"utf-8","GBK");

	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)or die("Could not create  socket\n"); // ����һ��Socket
	$connection = socket_connect($socket, $host, $port) or die("Could not connet server\n");    //  ����

	$ts =  floor(getMillisecond()/1000);
	$msg = "tgw_l7_forward\r\nHost:".$host.":".$port."\r\n\r\n";
	//$sm = "{\"user_gm_mgr_msg\",{\"add_money_to_user\",\"".$roleName."\",1,},}";
	//$sm1 = "{\\\"user_gm_mgr_msg\\\",{\\\"add_money_to_user\\\",\\\"".$roleName."\\\",1,},}";
	$sm = "{\"user_gm_mgr_msg\",{\"add_card_to_user\",\"".$roleName."\",".$cardId.",".$cardNum.",\"".$remark."\",},}";
	$sm1 = "{\\\"user_gm_mgr_msg\\\",{\\\"add_card_to_user\\\",\\\"".$roleName."\\\",".$cardId.",".$cardNum.",\\\"".$remark."\\\",},}";
	//����
	//$sm = "{\"user_gm_mgr_msg\",{\"add_score_to_user\",\"".$roleName."\",1,\"123123\",},}";
	//$sm1 = "{\\\"user_gm_mgr_msg\\\",{\\\"add_score_to_user\\\",\\\"".$roleName."\\\",1,\\\"123123\\\",},}";

	$message = "gm_msg:".$sm;
	$message1 = "gm_msg:".$sm1;
	$s = Md5($message.$ts."G-bits2TOP");
	$msg1 = "h#d{\"message\":\"".$message1."\",\"ts\":\"".$ts."\",\"sign\":\"".$s."\"}t#l";

	$r1 =$msg.$msg1;
	socket_write($socket,$r1) or die("Write failed\n"); // ���ݴ��� �������������Ϣ
	$count=0;
	$result = "";
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
	socket_close($socket);

}

function gm_addScore($name,$n,$rem){
	set_time_limit(10);
	global $host;
	global $port;
	$openID = "9613523E247BD5BAD73C075EEC5FA2EE";
	$roleName = mb_convert_encoding($name,"utf-8","GBK");
	$score = $n;
	$remark = mb_convert_encoding($rem,"utf-8","GBK");

	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)or die("Could not create  socket\n"); // ����һ��Socket

	$connection = socket_connect($socket, $host, $port) or die("Could not connet server\n");    //  ����

	$ts =  floor(getMillisecond()/1000);
	$msg = "tgw_l7_forward\r\nHost:".$host.":".$port."\r\n\r\n";
	//$sm = "{\"user_gm_mgr_msg\",{\"add_money_to_user\",\"".$roleName."\",1,},}";
	//$sm1 = "{\\\"user_gm_mgr_msg\\\",{\\\"add_money_to_user\\\",\\\"".$roleName."\\\",1,},}";

	//$sm = "{\"user_gm_mgr_msg\",{\"add_card_to_user\",\"".$roleName."\",44,2,\"ceshi\",},}";
	//$sm1 = "{\\\"user_gm_mgr_msg\\\",{\\\"add_card_to_user\\\",\\\"".$roleName."\\\",44,2,\\\"ceshi\\\",},}";

	//����
	$sm = "{\"user_gm_mgr_msg\",{\"add_score_to_user\",\"".$roleName."\",".$score.",\"".$remark."\",},}";
	$sm1 = "{\\\"user_gm_mgr_msg\\\",{\\\"add_score_to_user\\\",\\\"".$roleName."\\\",".$score.",\\\"".$remark."\\\",},}";
	$message = "gm_msg:".$sm;
	$message1 = "gm_msg:".$sm1;
	$s = Md5($message.$ts."G-bits2TOP");
	$msg1 = "h#d{\"message\":\"".$message1."\",\"ts\":\"".$ts."\",\"sign\":\"".$s."\"}t#l";

	$r1 =$msg.$msg1;

	socket_write($socket,$r1) or die("Write failed\n"); // ���ݴ��� �������������Ϣ
	$count=0;
	$result = "";
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
	socket_close($socket);
}


function gm_addItem($name,$prop,$n,$rem){
	set_time_limit(10);
	global $host;
	global $port;
	$openID = "9613523E247BD5BAD73C075EEC5FA2EE";
	$roleName = mb_convert_encoding($name,"utf-8","GBK");
	$itemId = $prop;
	$itemNum = $n;
	$remark = mb_convert_encoding($rem,"utf-8","GBK");

	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)or die("Could not create  socket\n"); // ����һ��Socket

	$connection = socket_connect($socket, $host, $port) or die("Could not connet server\n");    //  ����

	$ts =  floor(getMillisecond()/1000);
	$msg = "tgw_l7_forward\r\nHost:".$host.":".$port."\r\n\r\n";
	//$sm = "{\"user_gm_mgr_msg\",{\"add_money_to_user\",\"".$roleName."\",1,},}";
	//$sm1 = "{\\\"user_gm_mgr_msg\\\",{\\\"add_money_to_user\\\",\\\"".$roleName."\\\",1,},}";

	$sm = "{\"user_gm_mgr_msg\",{\"add_item_to_user\",\"".$roleName."\",".$itemId.",".$itemNum.",\"".$remark."\",},}";
	$sm1 = "{\\\"user_gm_mgr_msg\\\",{\\\"add_item_to_user\\\",\\\"".$roleName."\\\",".$itemId.",".$itemNum.",\\\"".$remark."\\\",},}";

	//����
	//$sm = "{\"user_gm_mgr_msg\",{\"add_score_to_user\",\"".$roleName."\",1,\"123123\",},}";
	//$sm1 = "{\\\"user_gm_mgr_msg\\\",{\\\"add_score_to_user\\\",\\\"".$roleName."\\\",1,\\\"123123\\\",},}";
	$message = "gm_msg:".$sm;
	$message1 = "gm_msg:".$sm1;
	$s = Md5($message.$ts."G-bits2TOP");
	$msg1 = "h#d{\"message\":\"".$message1."\",\"ts\":\"".$ts."\",\"sign\":\"".$s."\"}t#l";

	$r1 =$msg.$msg1;

	socket_write($socket,$r1) or die("Write failed\n"); // ���ݴ��� �������������Ϣ
	$count=0;
	$result = "";
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
	socket_close($socket);
}
//gm_addScore("GMT",2000000,"����");
function  getFileData($filename,$cmd){
	$fp=fopen("upload/".$filename,'r');
	$filenametemp = substr($filename, 0,strpos($filename, "."));
	//echo $filenametemp;
	while(!feof($fp))
	{
		$buffer=fgets($fp);
		if(strlen($buffer)>0){
			$buffer  = substr($buffer,0,strpos($buffer, ";"));
			$a = explode(',',$buffer);
			$rolename=$a[0];
			$prop=$a[1];
			$num=$a[2];
			$remark=$a[3];
			if($cmd=="1"){ // ����
				gm_addScore($rolename,$num,$remark."_".$filenametemp);
			}else if($cmd=="2"){// ����
				gm_addCard($rolename,$prop,$num,$remark."_".$filenametemp);
			}else if($cmd=="3"){// ��Ʒ
				gm_addItem($rolename,$prop,$num,$remark."_".$filenametemp);
			}else{
			}
		}
	}
	fclose($fp);
	// �ӱ�����ȡ��Ϣ��sql���
	echo "���ͽ������ϴ��ļ���Ϊ��".$filename."<br/>������������أ����Ժ�˶Բ������";
}


function  getFileData2($filename,$cmd){
	// �ӱ�����ȡ��Ϣ��sql���
	$filenametemp = substr($filename, 0,strpos($filename, "."));
	require '../utils/dbOstoolUtils.php';
	$strsql="SELECT rolename,propsId,num,remark from buchang where filename like '%".$filename."%'";
	// ִ��sql��ѯ
	$result=mysql_query($strsql, $osconn);
	// ��ȡ��ѯ���
	if(mysql_num_rows($result)>0){
		// ��λ����һ����¼
		mysql_data_seek($result, 0);
		// ѭ��ȡ����¼
		while ($row=mysql_fetch_row($result))
		{
			if($cmd=="1"){ // ����
				gm_addScore($row[0],$row[2],$row[3]."_".$filenametemp);
			}else if($cmd=="2"){// ����
				gm_addCard($row[0],$row[1],$row[2],$row[3]."_".$filenametemp);
			}else if($cmd=="3"){// ��Ʒ
				gm_addItem($row[0],$row[1],$row[2],$row[3]."_".$filenametemp);
			}else{
			}
		}
	}
	// �ͷ���Դ
	mysql_free_result($result);
	// �ر�����
	mysql_close($osconn);

	echo "���ͽ������ϴ��ļ���Ϊ��".$filename."<br/>������������أ����Ժ�˶Բ������";
}

function getMillisecond() {
	list($s1, $s2) = explode(' ', microtime());
	return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
}

if(isset($_GET["filename"]) && isset($_GET["cmd"]))
{
	$filename = $_GET["filename"];
	$cmd = $_GET["cmd"];
	getFileData($filename,$cmd);
}

?>