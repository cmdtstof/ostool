<link type="text/css" rel="stylesheet" href="../css/common.css" />
<?php
header('Content-type: text/html;charset=gbk');
require '../utils/dbOstoolUtils.php';
$server =$_SERVER['SERVER_NAME'];
// where server = '".$server."'
$strsql="SELECT filename,server from buchang  where server = '".$server."' group by filename order by filename desc";
// 执行sql查询
$result=mysql_query($strsql, $osconn);
// 获取查询结果

$showtable="<table id='tab1' class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' ><tr>";
$showtable = $showtable."<th></th><th>文件名</th><th>服务器</th>";
$showtable = $showtable."</tr>";

if(mysql_num_rows($result)>0){
	// 定位到第一条记录
	mysql_data_seek($result, 0);
	// 循环取出记录
	$xh=0;
	while ($row=mysql_fetch_row($result))
	{
		//$temp = substr($row[0],strpos($row[0], "/")+1,strlen($row[0]));
		$showtable = $showtable."<tr><td><input type='radio' name='radiogroup' value='".$row[0]."' ";
		if($xh==0){
			$showtable = $showtable." checked";
		}
		$showtable = $showtable."/></td><td>".$row[0]."</td><td>".$row[1]."</td></tr>";
		$xh++;
	}
	$showtable = $showtable."</table>";
	echo $showtable;
}
// 释放资源
mysql_free_result($result);
// 关闭连接
mysql_close($osconn);

?>

<input type="button" value="核对" onclick="checkfile()" />

<script type="text/javascript">

function checkfile(){
	var chk = -1;
	var chkObjs = document.getElementsByName("radiogroup");
    for(var i=0;i<chkObjs.length;i++){
        if(chkObjs[i].checked){
            chk = i;
            break;
        }
    }
    if(chk!=-1){
    	this.location = "checkResult.php?filename="+chkObjs[chk].value;
    }else{
        alert("请选择要核对的文件！");
    }
}
</script>