<?php
header('Content-type: text/html;charset=GB2312');
if(!isset($_POST['action'])){
}else if($_POST['action']=='search')
{
	require '.../../utils/iniUtils.php';

	$contttsql =" 1=1 ";
	if(!isset($_POST["name"])||$_POST["name"]==""){
	}else{
		$str=urldecode($_POST["name"]);
		$str =iconv("UTF-8","GBK",$str); //编码转换
		$contttsql = $contttsql." and name='".$str."'";
	}

	if(!isset($_POST["account"])||$_POST["account"]==""){
	}else{
		$str=urldecode($_POST["account"]);
		$str =iconv("UTF-8","GBK",$str); //编码转换
		$contttsql = $contttsql." and account='".$str."'";
	}

	$backsql=$contttsql;
	$todaysql=$contttsql;
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
			$todaysql = $contttsql." and update_time >= '".date("Y-m-d 00:00:00",time())."' and update_time <= '".$endtime."'";
		}else{ //只查今天
			$backsearch=0;
			$todaysearch=1;
			$todaysql = $contttsql." and update_time >= '".$starttime."' and update_time <= '".$endtime."'";
		}
		
		$backsql = $backsql." and update_time >= '".$starttime."' and update_time <= '".$endtime."'";
		//$contttsql = $contttsql." and update_time between '".$starttime."' and '".$endtime."'";
	}
	$todaysql = "select A.*,B.s,C.s from (SELECT name ,COUNT(DISTINCT duel_rid) as d  from duel_log where ".$todaysql." group by name)A left join (SELECT name ,COUNT(DISTINCT duel_rid)  as s from train_log where ".$todaysql." group by name  )B on  A.name = B.name left join (SELECT name ,COUNT(DISTINCT duel_rid) as s  from guide_log where ".$todaysql." group by name)C on A.name = C.name" ;
	$backsql = "select A.*,B.s,C.s from (SELECT name ,COUNT(DISTINCT duel_rid) as d  from duel_log where ".$backsql." group by name)A left join (SELECT name ,COUNT(DISTINCT duel_rid)  as s from train_log where ".$backsql." group by name  )B on  A.name = B.name left join (SELECT name ,COUNT(DISTINCT duel_rid) as s  from guide_log where ".$backsql." group by name)C on A.name = C.name" ;
	//$strsql = "select A.*,B.s,C.s from (SELECT name ,COUNT(DISTINCT duel_rid) as d  from duel_log where ".$contttsql." group by name)A left join (SELECT name ,COUNT(DISTINCT duel_rid)  as s from train_log where ".$contttsql." group by name  )B on  A.name = B.name left join (SELECT name ,COUNT(DISTINCT duel_rid) as s  from guide_log where ".$contttsql." group by name)C on A.name = C.name" ;
	
	$showtable="<table border='1'><tr><th>角色</th><th>duel_log数量</th><th>train_log数量</th><th>guide_log数量</th></tr>";
	$rolename="";
	$duel_num=0;
	$train_num=0;
	$guide_num=0;
	if($todaysearch==1){
		//echo $strsql;
		// 执行sql查询
   
		require '.../../utils/dbTcgLogUtils.php';
		$result=mysql_query($todaysql, $tcglogconn);
		// 获取查询结果
		if(mysql_num_rows($result)>0){
			// 定位到第一条记录
			mysql_data_seek($result, 0);
			// 循环取出记录
			while ($row=mysql_fetch_row($result))
			{
		
				$rolename=$row[0];
				$duel_num=$row[1];
				$train_num=$row[2];
				$guide_num=$row[3];
			}
		}
		// 释放资源
		mysql_free_result($result);
		// 关闭连接
		mysql_close($tcglogconn);
	}
	
	if($backsearch==1){
		//echo $strsql;
		// 执行sql查询
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
				$duel_num=$duel_num+$row[1];
				$train_num=$train_num+$row[2];
				$guide_num=$guide_num+$row[3];
			}
		}
		// 释放资源
		mysql_free_result($result);
		// 关闭连接
		mysql_close($backupconn);
	}
	$showtable = $showtable."<tr><td>".$rolename."</td><td>".$duel_num."</td><td>".$train_num."</td><td>".$guide_num."</td></tr>";
	$showtable = $showtable."</table>";
	if($rolename==""){
		echo "<font color='red'>没有数据</font>";
	}else{
		echo $showtable;
	}
}
?>