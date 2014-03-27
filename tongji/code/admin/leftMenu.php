<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</script>
<script type="text/javascript" language="javascript">
function showDiv(div){
	var d = document.getElementById(div).style.display;
	if(d=="none"){
		document.getElementById(div).style.display="";
	}else{
		document.getElementById(div).style.display="none";
	}
}
</script>
</head>
<body>
<?php $project_code = $_GET['project_code'];?>

<ul><a href="#" onClick="showDiv('div1');">项目总览</a>
<div id="div1" style="display:none;margin-left:10px;">
<li><a href="project/index.php" target="mainFrame">监控项目</a></li>
</div>
</ul>

<ul><a href="#" onClick="showDiv('div2');">访问</a>
<div id="div2" style="display:none;margin-left:10px;">
<li><a href="#"  onClick="showDiv('li1');">访问统计</a></li>
	<div id="li1" style="display:none;margin-left:10px;">
	<li><a href="vist/statistics/source.php?project_code=<?php echo $project_code;?>" target="mainFrame">按来源统计</a></li>
	<li><a href="vist/statistics/dist.php?project_code=<?php echo $project_code;?>" target="mainFrame">按访问页面统计</a></li>
	<li><a href="vist/statistics/ip.php?project_code=<?php echo $project_code;?>" target="mainFrame">按IP统计</a></li>
	<li><a href="vist/statistics/time.php?project_code=<?php echo $project_code;?>" target="mainFrame">按时间统计</a></li>
	</div>
<li><a href="vist/detail.php?project_code=<?php echo $project_code;?>" target="mainFrame">访问明细</a></li>
</div>
</ul>

<ul><a href="#" onClick="showDiv('div3');">事件</a>
<div id="div3" style="display:none;margin-left:10px;">
<li><a href="#"  onClick="showDiv('li2');">事件统计</a></li>
<div id="li2" style="display:none;margin-left:10px;">
	<li><a href="event/statistics/source.php?project_code=<?php echo $project_code;?>" target="mainFrame">按来源统计</a></li>
	<li><a href="event/statistics/dist.php?project_code=<?php echo $project_code;?>" target="mainFrame">按访问页面统计</a></li>
	<li><a href="event/statistics/ip.php?project_code=<?php echo $project_code;?>" target="mainFrame">按IP统计</a></li>
	<li><a href="event/statistics/time.php?project_code=<?php echo $project_code;?>" target="mainFrame">按时间统计</a></li>
	</div>
<li><a href="event/detail.php?project_code=<?php echo $project_code;?>" target="mainFrame">事件明细</a></li>
</div>
</ul>
</body>
</html>