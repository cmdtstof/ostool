<?php
header('Content-type: text/html;charset=GB2312');
if(!isset($_POST['action'])){
}else if($_POST['action']=='search'){
	require '.../../utils/iniUtils.php';
	$strsql="SELECT name ,count(*) from duel_log where 1=1 ";
	if(!isset($_POST["name"])||$_POST["name"]==""){
	}else{
		$str=urldecode($_POST["name"]);
		$str =iconv("UTF-8","GBK",$str); //编码转换
		$strsql = $strsql." and name='".$str."'";
	}

	if(!isset($_POST["account"])||$_POST["account"]==""){
	}else{
		$str=urldecode($_POST["account"]);
		$str =iconv("UTF-8","GBK",$str); //编码转换
		$strsql = $strsql." and account='".$str."'";
	}

	$backsql=$strsql;
	$todaysql=$strsql;
	$backsearch=0;//是否查询备份数据
	$todaysearch=0;//是否查询当日数据
	if(!isset($_POST["starttime"])||$_POST["starttime"]==""||!isset($_POST["endtime"])||$_POST["endtime"]==""){
	}else{
		$starttime=urldecode($_POST["starttime"]);
		$starttime =iconv("UTF-8","GBK",$starttime); //编码转换
		$endtime=urldecode($_POST["endtime"]);
		$endtime =iconv("UTF-8","GBK",$endtime); //编码转换
		date_default_timezone_set("PRC");
		if (strcmp(date("Y-m-d 00:00:00",time()),$endtime)>0){ //查备份
			$backsearch=1;
			$todaysearch=0;
		}else if (strcmp(date("Y-m-d 00:00:00",time()),$starttime)>0){//查备份和今天
			$backsearch=1;
			$todaysearch=1;
			$todaysql = $todaysql." and update_time >= '".date("Y-m-d 00:00:00",time())."' and update_time <= '".$endtime."'";
		}else{ //只查今天
			$backsearch=0;
			$todaysearch=1;
			$todaysql = $todaysql." and update_time >= '".$starttime."' and update_time <= '".$endtime."'";
		}
		$backsql = $backsql." and update_time >= '".$starttime."' and update_time <= '".$endtime."'";
	}
	$todaysql = $todaysql." and room_type <> 'freedom' and duel_result in (1,4) group by name";
	$backsql = $backsql." and room_type <> 'freedom' and duel_result in (1,4) group by name";
 
	$showtable="<table border='1'><tr><th>角色</th><th>数量</th></tr>";
	//echo $strsql;
	// 执行sql查询
	$rolename="";
	$num=0;
	if($todaysearch==1){
		require '.../../utils/dbTcgLogUtils.php';
		$result=mysql_query($todaysql, $tcglogconn);
		// 获取查询结果
		if(mysql_num_rows($result)>0){
			// 定位到第一条记录
			mysql_data_seek($result, 0);
			// 循环取出记录
			while ($row=mysql_fetch_row($result))
			{
				$rolename = $row[0];
				$num = $row[1];
			}
		}		
		// 释放资源
		mysql_free_result($result);
		// 关闭连接
		mysql_close($tcglogconn);
	}
	
	if($backsearch==1){
		require '.../../utils/dbBackupUtils.php';
		$result=mysql_query($backsql, $backupconn);
		// 获取查询结果
		
		if(mysql_num_rows($result)>0){
			// 定位到第一条记录
			mysql_data_seek($result, 0);
			// 循环取出记录
			while ($row=mysql_fetch_row($result))
			{
				if($rolename=="")
					$rolename = $row[0];
				
				$num = $num+$row[1];
			}
		}
		// 释放资源
		mysql_free_result($result);
		// 关闭连接
		mysql_close($backupconn);
	}
	$showtable = $showtable."<tr><td>".$rolename."</td><td>".$num."</td></tr>";
	$showtable = $showtable."</table>";
	if($rolename==""){
		echo "<font color='red'>没有数据</font>";
	}else{
		echo $showtable;
	}
}
?>