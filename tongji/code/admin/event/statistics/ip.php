<?php
header('Content-type: text/html;charset=utf-8');
include './../../../config/db.php';

$project_code = $_GET['project_code'];
$radioValue = $_GET['radioValue'];
?>

<input type="radio"
	name="s"
	<?php if($radioValue=='m' || !isset($radioValue) || $radioValue==''){?>
	checked <?php }?> value="m" onchange="change()" />
按月
<input type="radio" name="s"
	<?php if($radioValue=='w' ){?> checked <?php }?> value="w"
	onchange="change()" />
按周(以周六开始计算)
<input type="radio" name="s"
	<?php if($radioValue=='d'){?> checked <?php }?> value="d"
	onchange="change()" />
按日
<input type="radio" name="s"
	<?php if($radioValue=='h'){?> checked <?php }?> value="h"
	onchange="change()" />
按时
<br />
	<?php

	$datetimeContion = "DATE_FORMAT(event_time,'%Y-%m')";
	if($radioValue=='h'){
		$datetimeContion = "DATE_FORMAT(event_time,'%Y-%m-%d %H')";
	}else if($radioValue=='w'){
		$datetimeContion = "yearweek(DATE_ADD(event_time, INTERVAL 1 DAY))";
	}else if($radioValue=='d'){
		$datetimeContion = "DATE_FORMAT(event_time,'%Y-%m-%d')";
	}else{
		$datetimeContion = "DATE_FORMAT(event_time,'%Y-%m')";
	}

	$sql = "select * from (select project,".$datetimeContion.",ip,event_name,count(1) as c from event_record where project = '".$project_code."' group by project,".$datetimeContion.",ip,event_name)A  order by A.c desc ";
	$result=mysql_query($sql, $conn);
	$showmsg = "没有数据";
	if(mysql_num_rows($result)>0){
		// 定位到第一条记录
		mysql_data_seek($result, 0);
		// 循环取出记录
		$showmsg = "<table border='1'>";
		$showmsg = $showmsg."<thead><tr><td>项目</td><td>访问时间</td><td>ip</td><td>事件</td><td>访问数</td></tr></thead>";
		$showmsg= $showmsg."<tbody>";
		while ($row=mysql_fetch_row($result))
		{
			$showmsg= $showmsg."<tr><td>".$row[0]."</td>";
			if($radioValue=='w'){
				$showmsg= $showmsg."<td>".$row[1]."周</td>";
			}else{
				$showmsg= $showmsg."<td>".$row[1]."</td>";
			}
			$showmsg= $showmsg."<td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td></tr>";

		}
		$showmsg= $showmsg."</tbody></table>";

	}

	echo $showmsg;

	mysql_free_result($result);
	mysql_close($conn);
	?>

<script
	type="text/javascript" src="../../../js/common.js"></script>
