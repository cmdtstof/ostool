<link type="text/css" rel="stylesheet" href="../css/common.css" />
<?php
require '../utils/dbBackupDateUtils.php';

?>
������־
<table id='tab1' class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' >
<?php

	$starttime= '20130610';
	$endtime='20130616';
	if(isset($_GET['starttime']) && $_GET['starttime']!=""){
		$starttime = $_GET['starttime'];
	}
	if(isset($_GET['endtime']) && $_GET['endtime']!=""){
		$endtime = $_GET['endtime'];
	}
	
  $strsql="SELECT id,competition_date,competition_info,line_id from competition_data where competition_date >='".$starttime."' and competition_date <='".$endtime."' ";
  
  echo $strsql;
   // ִ��sql��ѯ
  	$result=mysql_query($strsql, $backupconn);
	 // ��ȡ��ѯ���
    $row=mysql_fetch_row($result);
	$cc=1;
	?>
	<tr><th>ID</th><th>����</th><th>��Ϣ</th><th>��·</th></tr>
	<?php 

	if(mysql_num_rows($result)>0){
		// ��λ����һ����¼
		mysql_data_seek($result, 0);
		// ѭ��ȡ����¼
		while ($row=mysql_fetch_row($result))
		{
	?>
	<tr>
	<?php
		$tt  = explode("},{",$row[2]);
		for ($i=0; $i<count($tt); $i++ ){
		?>
	<td><?php echo $cc?></td><td><?php echo $row[1]?></td><td>
	<?php
			//echo $tt[$i];
			$a1= strpos($tt[$i],"['group_champion']=[==");
			//echo $a1;
			$len = strlen("['group_champion']=[==");
			$t1= substr($tt[$i],$a1+$len);
			//echo $t1;
			$a2= strpos($t1,"]");
				//	echo $a2;

					$t2= substr($t1,1,$a2-1);
					echo $t2;
	?>
	</td><td><?php	echo $row[3]?></td></tr><tr>
	<?php	
	$cc++;
		}
		
	?>
	</tr>
	<?php
	   
		}
	}
    // �ͷ���Դ
    mysql_free_result($result);
		mysql_close($backupconn);
	
?>
</table>
