<link type="text/css" rel="stylesheet" href="../css/common.css" />
<?php
header('Content-type: text/html;charset=gbk');
ini_set('max_execution_time', '0');
function checkResult() {
	
	if(isset($_GET["filename"]))
	{
		$filename = $_GET["filename"];

		require '../utils/dbOstoolUtils.php';
		$strsql="SELECT num from buchang where filename like '%".$filename."%'";
		// ִ��sql��ѯ
		$result=mysql_query($strsql, $osconn);
		$old = 0;
		// ��ȡ��ѯ���
		if(mysql_num_rows($result)>0){
			// ��λ����һ����¼
			mysql_data_seek($result, 0);
			// ѭ��ȡ����¼
			while ($row=mysql_fetch_row($result))
			{
				$old = $row[0];
				echo "Ԥ�Ʒ�������".$row[0]."��";
				break;
			}
		}
		// �ͷ���Դ
		mysql_free_result($result);
		// �ر�����
		mysql_close($osconn);
		
		
		
		require '../utils/dbTcgLogUtils.php';
		 // �ӱ�����ȡ��Ϣ��sql���
		$filenametemp = substr($filename, 0,strpos($filename, "."));
		$strsql="SELECT count(1) from gm_log where name='GMT' and memo like '%".$filenametemp."%'";
		$newnum = 0;
		// ִ��sql��ѯ
		$result=mysql_query($strsql, $tcglogconn);
		if(mysql_num_rows($result)>0){
			// ��λ����һ����¼
			mysql_data_seek($result, 0);
			// ѭ��ȡ����¼
			while ($row=mysql_fetch_row($result))
			{
				$newnum=$row[0];
				if($row[0]>=0){
					echo "<font color='red'>ʵ�ʳɹ��������ݣ�".$row[0]."��</font>";
				}else{
					echo "<font color='red'>û�з��ͳɹ�������</font>";		
				}
				break;
			}

		}else{
			echo "<font color='red'>û������</font>";
		}
		
		if($old>$newnum){
			echo "<br/>û�з��͵������У�";
			$showtable="<table id='tab1' class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' ><tr>";
			$showtable = $showtable."<th>���</th><th>���</th><th>����ID</th><th>����</th><th>��ע</th>";
			$showtable = $showtable."</tr>";
			
			$fp=fopen("upload/" . $filename,'r');
			$xh=0;
			while(!feof($fp))
			{
				$buffer=fgets($fp);
				if(strlen($buffer)>0){
					$buffer  = substr($buffer,0,strpos($buffer, ";"));
					$a = explode(',',$buffer);
					$rolename=$a[0];
					$prop=$a[1];
					$num=$a[2];
					$remark=$a[3];
					$strsql="SELECT count(1) from gm_log where name='GMT' and target = '$rolename' and memo like '%".$filenametemp."%'";
					$result=mysql_query($strsql, $tcglogconn);
					if(mysql_num_rows($result)>0){
						// ��λ����һ����¼
						mysql_data_seek($result, 0);
						// ѭ��ȡ����¼
						while ($row=mysql_fetch_row($result))
						{
							if($row[0]>0){
							}else{
								$xh++;
								$showtable = $showtable."<tr><td>".$xh."</td><td>".$rolename."</td><td>".$prop."</td><td>".$num."</td><td>".$remark."</td></tr>";	
							}
							break;
						}
			
					}else{
						echo "<font color='red'>û������</font>";
					}
					//gm_addItem($rolename,$prop,$num,$remark);
				}
			}
			
			$showtable = $showtable."</table>";
			echo $showtable;
		}
//		
//		
//		// ��ȡ��ѯ���
//		$showtable="<table id='tab1' class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' ><tr>";
//		$showtable = $showtable."<th>���</th><th>ʱ��</th><th>GM</th><th>����</th><th>���</th><th>��ע</th>";
//		$showtable = $showtable."</tr>";
//
//		$c=mysql_num_rows($result);
//		echo $c;
//		if(mysql_num_rows($result)>0){
//			// ��λ����һ����¼
//			mysql_data_seek($result, 0);
//			// ѭ��ȡ����¼
//			$count=0;
//			while ($row=mysql_fetch_row($result))
//			{
//				$count++;
//				$showtable = $showtable."<tr><td>".$count."</td>";
//				for ($i=0; $i<mysql_num_fields($result); $i++ )
//				{
//
//				}
//				$showtable = $showtable."</tr>";
//			}
//			$showtable = $showtable."</table>";
//			echo $showtable;
//		}else{
//			echo "<font color='red'>û������</font>";
//		}
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

function checkResult2() {
	
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
?>