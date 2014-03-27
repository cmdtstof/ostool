<?php
include './config/db.php';
include './common/fun/common.php';

//$referrer = $_POST['referrer'];
//$locationhref = $_POST['locationhref'];
//$type = $_POST['type'];
$recordid = $_POST['recordid'];

//$sql = "INSERT INTO vist (source,dist,ip,leave_time,type) VALUES ('".$id."','".$locationhref."','".$ip."',now(),'".$type."')";
$sql = "update vist set leave_time = now() where id = '".$recordid."'";

$result=mysql_query($sql, $conn);
mysql_close($conn);
?>