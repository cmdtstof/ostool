<?php
include './config/db.php';
include './common/fun/common.php';

$referrer = $_POST['referrer'];
$locationhref = $_POST['locationhref'];
$project = $_POST['project'];
$eventName = $_POST['eventName'];
$eventParam = $_POST['eventParam'];
$ip = getIP();
$sql = "INSERT INTO event_record (source,dist,ip,event_time,event_name,event_param,project) VALUES ('".$referrer."','".$locationhref."','".$ip."',now(),'".$eventName."','".$eventParam."','".$project."')";
$result=mysql_query($sql, $conn);
echo $id = mysql_insert_id();

// 释放资源
mysql_free_result($result);
mysql_close($conn);
?>