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
   
   // 执行sql查询
  	$result=mysql_query($strsql, $backupconn);
	// 获取查询结果
    $row=mysql_fetch_row($result);
	$cc=1;

	if(mysql_num_rows($result)>0){
		// 定位到第一条记录
		mysql_data_seek($result, 0);
		// 循环取出记录
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
    // 释放资源
    mysql_free_result($result);
		mysql_close($backupconn);
	
?>