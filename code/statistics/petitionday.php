<?php
require '../utils/dbBackupDateUtils.php';
$starttime= '';
	$endtime='';
	if(isset($_GET['starttime']) && $_GET['starttime']!=""){
		$starttime = $_GET['starttime'];
	}
	if(isset($_GET['endtime']) && $_GET['endtime']!=""){
		$endtime = $_GET['endtime'];
	}
	
  $strsql="SELECT id,competition_date,competition_info,line_id from competition_data where competition_date >='".$starttime."' and competition_date <='".$endtime."' ";
   
   // ִ��sql��ѯ
  	$result=mysql_query($strsql, $backupconn);
	// ��ȡ��ѯ���
    $row=mysql_fetch_row($result);
	$cc=1;

	if(mysql_num_rows($result)>0){
		// ��λ����һ����¼
		mysql_data_seek($result, 0);
		// ѭ��ȡ����¼
		while ($row=mysql_fetch_row($result))
		{
			$tt  = explode("},{",$row[2]);
			for ($i=0; $i<count($tt); $i++ ){
				
				$a1= strpos($tt[$i],"['group_champion']=[==");
				$len = strlen("['group_champion']=[==");
				$t1= substr($tt[$i],$a1+$len);
				$a2= strpos($t1,"]");
				$t2= substr($t1,1,$a2-1);
				echo $cc.",".$row[1].",".$t2.",".$row[3].";";
				

			$cc++;
		}
			
	   
		}
	}
    // �ͷ���Դ
    mysql_free_result($result);
		mysql_close($backupconn);
	
?>