<?php
header('Content-type: text/html;charset=GB2312');
if(!isset($_POST['action'])){
}else if($_POST['action']=='search')
{

  require '../utils/dbUtils.php';
  require '../utils/iniUtils.php';

  $strsql="SELECT * from auction_log where 1=1 ";
  if(!isset($_POST["name"])){
  }else{
	$str=urldecode($_POST["name"]);
	$str =iconv("UTF-8","GBK",$str); //����ת��
		$strsql = $strsql." and name='".$str."'";
  }
	
	//echo $strsql;
   // ִ��sql��ѯ
    $result=mysql_db_query($mysql_database, $strsql, $conn);
    // ��ȡ��ѯ���
	$showtable="<table id='tab1' class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' ><tr>";
	
	for ($i=0; $i<mysql_num_fields($result); $i++){
		$ttt = $_POST["table"].".".mysql_field_name($result, $i); 
		$showtable = $showtable."<th>".$settings->get("$ttt")."</th>";
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
	$showtable = $showtable."</table>";
	echo $showtable;
    // �ͷ���Դ
    mysql_free_result($result);
    // �ر�����
    mysql_close();
}
?>