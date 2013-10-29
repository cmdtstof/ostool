
<?php
	
   header('Content-type: text/html;charset=GB2312');
  
  require '../utils/dbTcgLogUtils.php';
  $strsql = "SELECT date_format(from_unixtime(UNIX_TIMESTAMP(update_time)-UNIX_TIMESTAMP(update_time)%(3 * 60)), '%Y-%m-%d %H:%i') as data_time,SUM(count) as count  FROM gs_log where update_time  BETWEEN DATE_sub(NOW(),INTERVAL 6 MINUTE) and NOW() and type='account' GROUP BY date_format(from_unixtime(UNIX_TIMESTAMP(update_time)-UNIX_TIMESTAMP(update_time)%(3 * 60)), '%Y-%m-%d %H:%i') ORDER BY date_format(from_unixtime(UNIX_TIMESTAMP(update_time)-UNIX_TIMESTAMP(update_time)%(3 * 60)), '%Y-%m-%d %H:%i') DESC";
   $result=mysql_query($strsql, $tcglogconn);
   $a = array();
   $b = array();
   echo "当前在线：";
   if(mysql_num_rows($result)>0){
		mysql_data_seek($result, 0);
		// 循环取出记录
		$c=0;
		$s="";
		while ($row=mysql_fetch_row($result))
		{
			$s=$row[1]."(统计时间：".$row[0].")";
		  
			$c++;
			if($c==2){
				echo $s;
				break;
			}
		}
   }
?>
<br/>
<iframe src="online.php" border = "0" height="500" width="900"></iframe>
