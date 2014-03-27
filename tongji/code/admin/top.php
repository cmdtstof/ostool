<?php
header('Content-type: text/html;charset=utf-8');
include './../config/db.php';
include './../common/fun/common.php';

$sql = "select id,name,code from project order by ordernum asc";
$result=mysql_query($sql, $conn);
$showmsg = "请选择查询项目：<select id='project' onchange='ddd();' >";
if(mysql_num_rows($result)>0){
	// 定位到第一条记录
	mysql_data_seek($result, 0);
	// 循环取出记录
	while ($row=mysql_fetch_row($result))
	{
		$showmsg= $showmsg."<option value='".$row[2]."'>".getGBK($row[1])."</option>";
	}
	
}
$showmsg = $showmsg."</select>";
echo $showmsg;

mysql_free_result($result);
mysql_close($conn);
?>


<script type="text/javascript" language="javascript">
ddd();
function ddd(){
	var project = document.getElementById("project");
	var projectIndex  = project.selectedIndex;
	var text = project.options[projectIndex].text; // 选中文本
	var value = project.options[projectIndex].value; // 选中值
	parent.document.getElementById('leftFrame').src='leftMenu.php?project_code='+value;
	parent.document.getElementById('mainFrame').src='welcome.php';
	
}
</script>