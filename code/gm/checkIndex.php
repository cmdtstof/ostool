<link type="text/css" rel="stylesheet" href="../css/common.css" />
<?php
header('Content-type: text/html;charset=gbk');
require '../utils/dbOstoolUtils.php';
$server =$_SERVER['SERVER_NAME'];
// where server = '".$server."'
$strsql="SELECT filename,server from buchang  where server = '".$server."' group by filename order by filename desc";
// ִ��sql��ѯ
$result=mysql_query($strsql, $osconn);
// ��ȡ��ѯ���

$showtable="<table id='tab1' class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' ><tr>";
$showtable = $showtable."<th></th><th>�ļ���</th><th>������</th>";
$showtable = $showtable."</tr>";

if(mysql_num_rows($result)>0){
	// ��λ����һ����¼
	mysql_data_seek($result, 0);
	// ѭ��ȡ����¼
	while ($row=mysql_fetch_row($result))
	{
		//$temp = substr($row[0],strpos($row[0], "/")+1,strlen($row[0]));
		$showtable = $showtable."<tr><td><input type='radio' name='radiogroup' value='".$row[0]."'/></td><td>".$row[0]."</td><td>".$row[1]."</td></tr>";
	}
	$showtable = $showtable."</table>";
	echo $showtable;
}
// �ͷ���Դ
mysql_free_result($result);
// �ر�����
mysql_close($osconn);

?>

<input type="button" value="�˶�" onclick="checkfile()" />

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
        alert("��ѡ��Ҫ�˶Ե��ļ���");
    }
}
</script>