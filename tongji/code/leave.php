<?php
include './config/db.php';
include './common/fun/common.php';
header('Content-Type:text/html;Charset=utf-8');
  
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

$ip = getIP();

$sql = "select max(id) from vist  where ip = '".$ip."' and dist= '".$locationhref."' and project = '".$project."'";
$result=mysql_query($sql, $conn);
if(mysql_num_rows($result)>0){
	// 定位到第一条记录
	mysql_data_seek($result, 0);
	// 循环取出记录
	while ($row=mysql_fetch_row($result))
	{
		
		$recordid = $row[0];
		$sql = "update vist set leave_time = now() where id = '".$recordid."'";
		$result=mysql_query($sql, $conn);
	}
}
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