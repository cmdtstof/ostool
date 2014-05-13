<?php
include './config/db.php';
include './common/fun/common.php';
//header('Content-Type:text/html;Charset=utf-8');

$callback = $_GET["callback"];
if(!isset($callback) || $callback ==""){
	$callback = $_POST["callback"];
}

$referrer = $_GET['referrer'];
if(!isset($referrer) || $referrer ==""){
	$referrer = $_POST["referrer"];
}

$locationhref = $_GET['locationhref'];
if(!isset($locationhref) || $locationhref ==""){
	$locationhref = $_POST["locationhref"];
}

$project = $_GET['project'];
if(!isset($project) || $project ==""){
	$project = $_POST["project"];
}

$type = $_GET['type'];
if(!isset($type) || $type ==""){
	$type = $_POST["type"];
}

$eventName = $_GET['eventName'];
if(!isset($eventName) || $eventName ==""){
	$eventName = $_POST["eventName"];
}

$eventParam = $_GET['eventParam'];
if(!isset($eventParam) || $eventParam ==""){
	$eventParam = $_POST["eventParam"];
}

$ip = getIP();
$sql = "INSERT INTO event_record (source,dist,ip,event_time,event_name,event_param,project) VALUES ('".$referrer."','".$locationhref."','".$ip."',now(),'".$eventName."','".$eventParam."','".$project."')";
$result=mysql_query($sql, $conn);
//echo $id = mysql_insert_id();

// 释放资源
mysql_free_result($result);
mysql_close($conn);

$a = array(
 'referrer'=>$referrer,
    'locationhref'=>$locationhref,
    'project'=>$project,
    'type'=>$type,
    'ip'=>$ip,
    'func'=>$callback,
);
$r = json_encode($a);
echo "flightHandler($r)";
?>