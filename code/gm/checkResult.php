<link type="text/css" rel="stylesheet" href="../css/common.css" />
<?php
header('Content-type: text/html;charset=gbk');
function checkResult() {
	
	if(isset($_GET["filename"]))
	{
		$filename = $_GET["filename"];
		require '../utils/dbTcgLogUtils.php';
		 // �ӱ�����ȡ��Ϣ��sql���
		$strsql="SELECT update_time,name,action,target,memo from gm_log where name='GMT' and memo like '%".$filename."%'";

		// ִ��sql��ѯ
		$result=mysql_query($strsql, $tcglogconn);
		// ��ȡ��ѯ���
		$showtable="<table id='tab1' class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' ><tr>";
		$showtable = $showtable."<th>���</th><th>ʱ��</th><th>GM</th><th>����</th><th>���</th><th>��ע</th>";
		$showtable = $showtable."</tr>";

		if(mysql_num_rows($result)>0){
			// ��λ����һ����¼
			mysql_data_seek($result, 0);
			// ѭ��ȡ����¼
			$count=0;
			while ($row=mysql_fetch_row($result))
			{
				$count++;
				$showtable = $showtable."<tr><td>".$count."</td>";
				for ($i=0; $i<mysql_num_fields($result); $i++ )
				{
					if($row[$i]=="add_card_to_user"){
						$showtable = $showtable."<td>��ӿ���</td>";
					}else if($row[$i]=="add_item_to_user"){
						$showtable = $showtable."<td>�����Ʒ</td>";
					}else if($row[$i]=="add_score_to_user"){
						$showtable = $showtable."<td>��ӻ���</td>";
					}else {
						$showtable = $showtable."<td>".$row[$i]."</td>";
					}

				}
				$showtable = $showtable."</tr>";
			}
			$showtable = $showtable."</table>";
			echo $showtable;
		}else{
			echo "<font color='red'>û������</font>";
		}
		// �ͷ���Դ
		mysql_free_result($result);
		// �ر�����
		mysql_close($tcglogconn);

	}
	else
	{
		echo "<font color='red'>no data!</font>";
	}


}
checkResult();
?>