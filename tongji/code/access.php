<?php
include './config/db.php';
include './common/fun/common.php';

$referrer = $_POST['referrer'];
$locationhref = $_POST['locationhref'];
$project = $_POST['project'];
$type = $_POST['type'];
$ip = getIP();
$sql = "INSERT INTO vist (source,dist,ip,access_time,type,project) VALUES ('".$referrer."','".$locationhref."','".$ip."',now(),'".$type."','".$project."')";
$result=mysql_query($sql, $conn);
echo $id = mysql_insert_id();
// 释放资源
mysql_free_result($result);
mysql_close($conn);
?>