<?php
header('Content-type: text/html;charset=utf-8');
include './../../config/db.php';
include './../../common/fun/common.php';

$sql = "select id,name,code from project";
$result=mysql_query($sql, $conn);
$showmsg = "没有数据";
if(mysql_num_rows($result)>0){
	// 定位到第一条记录
	mysql_data_seek($result, 0);
	// 循环取出记录
	$showmsg = "<table border='1'>";
	$showmsg = $showmsg."<thead><tr><td>id</td><td>项目名称</td><td>项目编码</td></tr></thead>";
	$showmsg= $showmsg."<tbody>";
	while ($row=mysql_fetch_row($result))
	{
		$showmsg= $showmsg."<tr><td>".$row[0]."</td><td>".getGBK($row[1])."</td><td>".$row[2]."</td></tr>";
	}
	$showmsg= $showmsg."</tbody></table>";
}

echo $showmsg;

mysql_free_result($result);
mysql_close($conn);
?>