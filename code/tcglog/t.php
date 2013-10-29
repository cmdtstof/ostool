<?php
header('Content-type: text/html;charset=GB2312');
require '../common/commonFun.php';
if(!isset($_POST['action'])){
}else if($_POST['action']=='search')
{

  require '../utils/dbBackupUtils.php';
  require '../utils/dbTcgLogUtils.php';
  require '../utils/iniUtils.php';
// 从表中提取信息的sql语句
  $strsql="SELECT ";
  if(!isset($_POST["showFileds"])|| $_POST["showFileds"]==""){
	$strsql=$strsql." * from ".$_POST["tablename"];
  }else{
  	$strsql=$strsql." ".$_POST["showFileds"]." from ".$_POST["tablename"];
  }
  
  if(!isset($_POST["condition"])|| $_POST["condition"]==""){
		
  }else{
	$str=urldecode($_POST["condition"]);
	$str =iconv("UTF-8","GBK",$str); //编码转换
		$strsql = $strsql." where ".$str;
  }
  
  $historysql = "";
  $historyflag = true;
  if(!isset($_POST["history"])|| $_POST["history"]==""){
	$historyflag = false;
  }else{
	$historyflag = true;
	$str=urldecode($_POST["history"]);
	$historysql =iconv("UTF-8","GBK",$str); //编码转换
  }
  
	$todaysql = "";
	$todayflag = false;
  if(!isset($_POST["today"])|| $_POST["today"]==""){
	$todaysql=false;
  }else{
	$todayflag = true;
	$str=urldecode($_POST["today"]);
	$todaysql =iconv("UTF-8","GBK",$str); //编码转换
  }
  
  if(!isset($_POST["filters"])|| $_POST["filters"]==""){
  }else{
		$str=urldecode($_POST["filters"]);
		$str =iconv("UTF-8","GBK",$str); //编码转换
		$todaysql = $todaysql." group by ".$str;
  }
  $todaysql = $strsql.$todaysql." order by update_time desc,id desc"." limit 0, ".$_POST["maxsize"];
	  
   // 执行sql查询
   $result="";
   $todayresult="";
   $a = array();
   $todaysize=0;
   if($todayflag){
   echo $todaysql;
	//mysql_select_db($tcglog_database, $tcglogconn);
	$todaysql = ceshi($tcglogconn,$tcglog_database,$_POST["tablename"],$todaysql);
    $result=mysql_query($todaysql, $tcglogconn);
	$todaysize =  mysql_num_rows($result);
	$todayresult = $result;
	array_unshift($a,$todayresult);
  }
   $historyresult="";
   if($historyflag){
		$historysize=$_POST["maxsize"]-$todaysize;
		if($historysize>0){
			  if(!isset($_POST["filters"])|| $_POST["filters"]==""){
			  }else{
				$str=urldecode($_POST["filters"]);
				$str =iconv("UTF-8","GBK",$str); //编码转换
					$historysql = $historysql." group by ".$str;
			  }
			$historysql = $strsql.$historysql." order by update_time desc,id desc"." limit 0, ".$historysize;
			
		 $historysql = ceshi($backupconn,$backup_database,$_POST["tablename"],$historysql);
			
			echo $historysql;
			//mysql_select_db($backup_database, $backupconn);
			if($result!=""&&mysql_num_rows($result)>0){
				$historyresult =mysql_query($historysql, $backupconn);
			}else{
				$result=mysql_query($historysql, $backupconn);
				$historyresult = $result;
			}
			array_unshift($a,$historyresult);
		}
	}
    // 获取查询结果
	$showtable="<table id='tab1' class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' ><tr>";
		//echo $historysql;
	for ($i=0; $i<mysql_num_fields($result); $i++){
		$ttt = $_POST["tablename"].".".mysql_field_name($result, $i); 
		$ty = mysql_field_type($result,$i);
		if($ty == 'int'){
			$ty = 1;
		}else{
			$ty = 0;
			}
		$showtable = $showtable."<th onclick='resort("."tab1.id".",".$i.",".$ty.");' >".$settings->get("$ttt")."</th>";
	}
	
	
	$flag = false;
    if(strstr($_POST["showFileds"],"remain_score")!=false ){
		if(strstr($_POST["showFileds"],"score_num")!=false){
			if(strstr($_POST["showFileds"],"type")!=false){
			$flag = true;
			}
		}
	}
	if($flag){ 
		$showtable = $showtable."<th>上次获取积分</th><th>校验</th>";
	}
	$showtable = $showtable."</tr>";
	$showtable = $showtable."<tbody>";
	$nodata = 0;
	for ($z=count($a)-1; $z>=0; $z--){
		if(mysql_num_rows($a[$z])>0){
			$nodata = 1;
			// 定位到第一条记录
			mysql_data_seek($a[$z], 0);
			// 循环取出记录
			while ($row=mysql_fetch_row($a[$z]))
			{
				$showtable = $showtable."<tr>";
			
				$lastval=0;
				$lasttype=1;
				$lastpoint=0;
				for ($i=0; $i<mysql_num_fields($a[$z]); $i++ )
				{
					$fn = mysql_field_name($a[$z], $i);
					if($fn=="blue_VIP" || $fn=="blue_vip" || $fn=="insider" || $fn=="first_complete"){
						$fv = "common_".$fn."."."$row[$i]";
					}else{
						$fv = $_POST["tablename"]."_".$fn."."."$row[$i]";
					}
					$r = $commonset->get("$fv") ;
				
					if($r == ""){
						$r = "$row[$i]";
					}
					$showtable = $showtable."<td>".$r."</td>";
					
					if($fn =="remain_score"){
						$lastval= $row[$i];
					}
					if($fn =="score_num"){
						$lastpoint= $row[$i];
					}
					if($fn =="type"){
						if($row[$i]==1)
							$lasttype= -1;
					}
				}
				if($flag){
					$showtable = $showtable."<td></td><td>".(($lasttype)*($lastpoint))."</td>";
				}
				$showtable = $showtable."</tr>";
			}
			
		}
	}
			$showtable = $showtable."</tbody>";
			$showtable = $showtable."</table>";
		echo $showtable;
	if($nodata==0){
			echo "<font color='red'>没有数据</font>";
	}
    // 释放资源
    mysql_free_result($result);
   // 关闭连接
    mysql_close($tcglogconn);
}
?>