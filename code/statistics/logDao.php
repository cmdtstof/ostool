<?php
header('Content-type: text/html;charset=GB2312');
if(!isset($_POST['action'])){
}else if($_POST['action']=='search')
{

  require '../utils/dbBackupUtils.php';
  require '../utils/dbTcgLogUtils.php';
  require '../utils/iniUtils.php';

  $strsql="SELECT * from ".$_POST["table"]." where 1=1 ";
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
  if(!isset($_POST["item_id"])||$_POST["item_id"]==""){
  }else{
	$str=urldecode($_POST["item_id"]);
	$str =iconv("UTF-8","GBK",$str); //编码转换
		$strsql = $strsql." and item_id='".$str."'";
  }
  if(!isset($_POST["auction_id"])||$_POST["auction_id"]==""){
  }else{
	$str=urldecode($_POST["auction_id"]);
	$str =iconv("UTF-8","GBK",$str); //编码转换
		$strsql = $strsql." and auction_id='".$str."'";
  }
  if(!isset($_POST["item_name"])||$_POST["item_name"]==""){
  }else{
	$str=urldecode($_POST["item_name"]);
	$str =iconv("UTF-8","GBK",$str); //编码转换
		$strsql = $strsql." and item_name like '".$str."%'";
  }  
  if(!isset($_POST["item_type"])||$_POST["item_type"]==""){
  }else{
	$str=urldecode($_POST["item_type"]);
	$str =iconv("UTF-8","GBK",$str); //编码转换
		$strsql = $strsql." and item_type = '".$str."'";
  }
  if(!isset($_POST["rid"])||$_POST["rid"]==""){
  }else{
	$str=urldecode($_POST["rid"]);
	$str =iconv("UTF-8","GBK",$str); //编码转换
		$strsql = $strsql." and rid = '".$str."'";
  }
  if(!isset($_POST["card_iid"])||$_POST["card_iid"]==""){
  }else{
	$str=urldecode($_POST["card_iid"]);
	$str =iconv("UTF-8","GBK",$str); //编码转换
		$strsql = $strsql." and card_iid = '".$str."'";
  }
  if(!isset($_POST["item_iid"])||$_POST["item_iid"]==""){
  }else{
	$str=urldecode($_POST["item_iid"]);
	$str =iconv("UTF-8","GBK",$str); //编码转换
		$strsql = $strsql." and item_iid = '".$str."'";
  }
  if(!isset($_POST["memo"])||$_POST["memo"]==""){
  }else{
	$str=urldecode($_POST["memo"]);
	$str =iconv("UTF-8","GBK",$str); //编码转换
		$strsql = $strsql." and memo = '".$str."'";
  }
  
  $backsql="";
  $tcglogsql=$strsql;
  $backsearch=0;//是否查询备份数据
  if(!isset($_POST["update_time"])||$_POST["update_time"]==""){
  }else{
	$str=urldecode($_POST["update_time"]);
	$str =iconv("UTF-8","GBK",$str); //编码转换
	date_default_timezone_set("PRC");
	if (strcmp(date("Y-m-d 00:00:00",time()),$str)>0){
		$backsearch=1;
		$tcglogsql=$strsql." and update_time >= '".date("Y-m-d 00:00:00",time())."'";
	}else{
		$backsearch=0;
		$tcglogsql=$strsql." and update_time >= '".$str."'";
	}
	$backsql = $strsql." and update_time >= '".$str."'";
	$strsql = $strsql." and update_time >= '".$str."'";
  }
	//echo $strsql;
   // 执行sql查询
   
	$showtable="<table id='tab1' class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' ><tr>";
	
	mysql_select_db($tcglog_database, $tcglogconn);
    $result=mysql_query($tcglogsql, $tcglogconn);
    // 获取查询结果
	
	for ($i=0; $i<mysql_num_fields($result); $i++){
		$ttt = $_POST["table"].".".mysql_field_name($result, $i); 
		$showtable = $showtable."<th>".$settings->get("$ttt")."</th>";
	}
	$showtable = $showtable."</tr>";
	
	if(mysql_num_rows($result)>0){
		// 定位到第一条记录
		mysql_data_seek($result, 0);
		// 循环取出记录
		while ($row=mysql_fetch_row($result))
		{
		
		$showtable = $showtable."<tr>";
		  for ($i=0; $i<mysql_num_fields($result); $i++ )
		  {
			$fn = mysql_field_name($result, $i);
			if($fn=="blue_VIP" || $fn=="insider" || $fn=="first_complete"){
				$fv = "common_".$fn."."."$row[$i]";
			}else{
				$fv = $_POST["table"]."_".$fn."."."$row[$i]";
			}
			$r = $commonset->get("$fv") ;
		
			if($r == ""){
				$r = "$row[$i]";
			}
			$showtable = $showtable."<td>".$r."</td>";
		  }
			$showtable = $showtable."</tr>";
		}
	}
	
	if($backsearch==1){
		$result=mysql_query($backsql, $backupconn);
		if(mysql_num_rows($result)>0){
			// 定位到第一条记录
			mysql_data_seek($result, 0);
			// 循环取出记录
			while ($row=mysql_fetch_row($result))
			{
			
			$showtable = $showtable."<tr>";
			  for ($i=0; $i<mysql_num_fields($result); $i++ )
			  {
				$fn = mysql_field_name($result, $i);
				if($fn=="blue_VIP" || $fn=="insider" || $fn=="first_complete"){
					$fv = "common_".$fn."."."$row[$i]";
				}else{
					$fv = $_POST["table"]."_".$fn."."."$row[$i]";
				}
				$r = $commonset->get("$fv") ;
			
				if($r == ""){
					$r = "$row[$i]";
				}
				$showtable = $showtable."<td>".$r."</td>";
			  }
				$showtable = $showtable."</tr>";
			}
		}
	}
	
	$showtable = $showtable."</table>";
	echo $showtable;
    // 释放资源
    mysql_free_result($result);
    // 关闭连接
    mysql_close($backupconn);
    mysql_close($tcglogconn);
}
?>