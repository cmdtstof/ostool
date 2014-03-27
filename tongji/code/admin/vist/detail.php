
<?php
header('Content-type: text/html;charset=utf-8');
include './../../config/db.php';

$project_code = $_GET['project_code'];

$sql = "select id,source,dist,access_time,leave_time,ip from vist where project = '".$project_code."' order by access_time desc LIMIT 0,100";
$result=mysql_query($sql, $conn);
$showmsg = "没有数据";
if(mysql_num_rows($result)>0){
	// 定位到第一条记录
	mysql_data_seek($result, 0);
	// 循环取出记录
	//只显示前100条
	$showmsg ="只显示前100条<BR/>"; 
	$showmsg = $showmsg."<table border='1'>";
	$showmsg = $showmsg."<thead><tr><td>id</td><td>来源</td><td>访问页面</td><td>访问时间</td><td>离开时间</td><td>IP</td></tr></thead>";
	$showmsg= $showmsg."<tbody>";
	while ($row=mysql_fetch_row($result))
	{
		$showmsg= $showmsg."<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td><td>".$row[5]."</td></tr>";
	}
	$showmsg= $showmsg."</tbody></table>";
}

echo $showmsg;
mysql_free_result($result);
mysql_close($conn);
?>