<?php
header('Content-type: text/html;charset=utf-8');
include './../../config/db.php';

$sql = "select id,source,dist,access_time,leave_time,ip,project from vist order by access_time desc";
$result=mysql_query($sql, $conn);
$showmsg = "没有数据";
if(mysql_num_rows($result)>0){
	// 定位到第一条记录
	mysql_data_seek($result, 0);
	// 循环取出记录
	$showmsg = "<table border='1'>";
	$showmsg = $showmsg."<thead><tr><td>id</td><td>来源</td><td>访问页面</td><td>访问事件</td><td>离开时间</td><td>IP</td><td>项目</td></tr></thead>";
	$showmsg= $showmsg."<tbody>";
	while ($row=mysql_fetch_row($result))
	{
		$showmsg= $showmsg."<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td><td>".$row[5]."</td><td>".$row[6]."</td></tr>";


	}
	$showmsg= $showmsg."</tbody></table>";
	
}

echo $showmsg;

mysql_free_result($result);
mysql_close($conn);
?>