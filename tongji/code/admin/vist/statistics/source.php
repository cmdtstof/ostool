<?php
header('Content-type: text/html;charset=utf-8');
include './../../../config/db.php';

$project_code = $_GET['project_code'];
$radioValue = $_GET['radioValue'];
?>

<input
	type="radio" name="s"
	<?php if($radioValue=='m' || !isset($radioValue) || $radioValue==''){?>
	checked <?php }?> value="m" onchange="change()" />
按月
<input type="radio" name="s"
	<?php if($radioValue=='w' ){?> checked <?php }?> value="w"
	onchange="change()" />
按周(以周六开始计算)
<input
	type="radio" name="s" <?php if($radioValue=='d'){?> checked <?php }?>
	value="d" onchange="change()" />
按日
<input
	type="radio" name="s" <?php if($radioValue=='h'){?> checked <?php }?>
	value="h" onchange="change()" />
按时
<br />
	<?php

	$datetimeContion = "DATE_FORMAT(access_time,'%Y-%m')";
	if($radioValue=='h'){
		$datetimeContion = "DATE_FORMAT(access_time,'%Y-%m-%d %H')";
	}else if($radioValue=='w'){
		$datetimeContion = "yearweek(DATE_ADD(access_time, INTERVAL 1 DAY))";
	}else if($radioValue=='d'){
		$datetimeContion = "DATE_FORMAT(access_time,'%Y-%m-%d')";
	}else{
		$datetimeContion = "DATE_FORMAT(access_time,'%Y-%m')";
	}
	$sql = "select * from (select project,".$datetimeContion.",source,count(1) as c from vist where project = '".$project_code."' group by project,".$datetimeContion.",source)A  order by A.c desc ";

	$result=mysql_query($sql, $conn);
	$showmsg = "没有数据";
	if(mysql_num_rows($result)>0){
		// 定位到第一条记录
		mysql_data_seek($result, 0);
		// 循环取出记录
		$showmsg = "<table border='1'>";
		$showmsg = $showmsg."<thead><tr><td>项目</td><td>时间</td><td>来源</td><td>访问数</td></tr></thead>";
		$showmsg= $showmsg."<tbody>";
		while ($row=mysql_fetch_row($result))
		{
			$showmsg= $showmsg."<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td></tr>";


		}
		$showmsg= $showmsg."</tbody></table>";

	}

	echo $showmsg;

	mysql_free_result($result);
	mysql_close($conn);
	?>

<script type="text/javascript" language="javascript">

function change()
{
	var radio = document.getElementsByName("s");
 	//var radio = document.getElementByIdx_x("form1");
  	// 用ById就不能取得全部的radio值,而是每次返回都为1
 	var radioLength = radio.length;
 	for(var i = 0;i < radioLength;i++)
 	{
	  	if(radio[i].checked)
	  	{
	   		var radioValue = radio[i].value;
	   		parent.document.getElementById('mainFrame').src=window.location+'&radioValue=' + radioValue;
	  	}
 	}
}
</script>
