<?php
header('Content-type: text/html;charset=GB2312');
if(!isset($_POST['action'])){

}else if($_POST['action']=='search')
{
  require '../utils/dbOstoolUtils.php';
  require '../utils/iniUtils.php';
// �ӱ�����ȡ��Ϣ��sql���
  $strsql="SELECT ";
  if(!isset($_POST["showFileds"])|| $_POST["showFileds"]==""){
	$strsql=$strsql." * from ".$_POST["tablename"];
  }else{
  	$strsql=$strsql." ".$_POST["showFileds"]." from ".$_POST["tablename"];
  }
    
  if(!isset($_POST["condition"])|| $_POST["condition"]==""){
		
  }else{
	$str=urldecode($_POST["condition"]);
	$str =iconv("UTF-8","GBK",$str); //����ת��
		$strsql = $strsql." where ".$str;
  }
  if(!isset($_POST["filters"])|| $_POST["filters"]==""){
  }else{
		$strsql = $strsql." group by ".$_POST["filters"];
  }
  
  if(!isset($_POST["maxsize"])|| $_POST["maxsize"]==""){
  }else{
	$strsql = $strsql." limit 0, ".$_POST["maxsize"];
  }
	  
	//echo $strsql;
   // ִ��sql��ѯ
    $result=mysql_query($strsql, $osconn);
    // ��ȡ��ѯ���
	$showtable="<table id='tab1' class='simpleList' style='width:50%;' border='1' cellspacing='0' cellpadding='5' rules='rows' ><tr>";
	
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
	
	
	$showtable = $showtable."</tr>";
	
	if(mysql_num_rows($result)>0){
		// ��λ����һ����¼
		mysql_data_seek($result, 0);
		// ѭ��ȡ����¼
		while ($row=mysql_fetch_row($result))
		{
		
			$showtable = $showtable."<tr>";
	
		  for ($i=0; $i<mysql_num_fields($result); $i++ )
		  {
			$fn = mysql_field_name($result, $i);
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
    mysql_close($osconn);
}
?>