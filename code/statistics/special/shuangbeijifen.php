<?php
header('Content-type: text/html;charset=GB2312');
if(!isset($_POST['action'])){
}else if($_POST['action']=='search'){
	require '.../../utils/iniUtils.php';
	$strsql="SELECT name ,count(*) from duel_log where 1=1 ";
	if(!isset($_POST["name"])||$_POST["name"]==""){
	}else{
		$str=urldecode($_POST["name"]);
		$str =iconv("UTF-8","GBK",$str); //����ת��
		$strsql = $strsql." and name='".$str."'";
	}

	if(!isset($_POST["account"])||$_POST["account"]==""){
	}else{
		$str=urldecode($_POST["account"]);
		$str =iconv("UTF-8","GBK",$str); //����ת��
		$strsql = $strsql." and account='".$str."'";
	}

	$backsql=$strsql;
	$todaysql=$strsql;
	$backsearch=0;//�Ƿ��ѯ��������
	$todaysearch=0;//�Ƿ��ѯ��������
	if(!isset($_POST["starttime"])||$_POST["starttime"]==""||!isset($_POST["endtime"])||$_POST["endtime"]==""){
	}else{
		$starttime=urldecode($_POST["starttime"]);
		$starttime =iconv("UTF-8","GBK",$starttime); //����ת��
		$endtime=urldecode($_POST["endtime"]);
		$endtime =iconv("UTF-8","GBK",$endtime); //����ת��
		date_default_timezone_set("PRC");
		if (strcmp(date("Y-m-d 00:00:00",time()),$endtime)>0){ //�鱸��
			$backsearch=1;
			$todaysearch=0;
		}else if (strcmp(date("Y-m-d 00:00:00",time()),$starttime)>0){//�鱸�ݺͽ���
			$backsearch=1;
			$todaysearch=1;
			$todaysql = $todaysql." and update_time >= '".date("Y-m-d 00:00:00",time())."' and update_time <= '".$endtime."'";
		}else{ //ֻ�����
			$backsearch=0;
			$todaysearch=1;
			$todaysql = $todaysql." and update_time >= '".$starttime."' and update_time <= '".$endtime."'";
		}
		$backsql = $backsql." and update_time >= '".$starttime."' and update_time <= '".$endtime."'";
	}
	$todaysql = $todaysql." and room_type <> 'freedom' and duel_result in (1,4) group by name";
	$backsql = $backsql." and room_type <> 'freedom' and duel_result in (1,4) group by name";
 
	$showtable="<table border='1'><tr><th>��ɫ</th><th>����</th></tr>";
	//echo $strsql;
	// ִ��sql��ѯ
	$rolename="";
	$num=0;
	if($todaysearch==1){
		require '.../../utils/dbTcgLogUtils.php';
		$result=mysql_query($todaysql, $tcglogconn);
		// ��ȡ��ѯ���
		if(mysql_num_rows($result)>0){
			// ��λ����һ����¼
			mysql_data_seek($result, 0);
			// ѭ��ȡ����¼
			while ($row=mysql_fetch_row($result))
			{
				$rolename = $row[0];
				$num = $row[1];
			}
		}		
		// �ͷ���Դ
		mysql_free_result($result);
		// �ر�����
		mysql_close($tcglogconn);
	}
	
	if($backsearch==1){
		require '.../../utils/dbBackupUtils.php';
		$result=mysql_query($backsql, $backupconn);
		// ��ȡ��ѯ���
		
		if(mysql_num_rows($result)>0){
			// ��λ����һ����¼
			mysql_data_seek($result, 0);
			// ѭ��ȡ����¼
			while ($row=mysql_fetch_row($result))
			{
				if($rolename=="")
					$rolename = $row[0];
				
				$num = $num+$row[1];
			}
		}
		// �ͷ���Դ
		mysql_free_result($result);
		// �ر�����
		mysql_close($backupconn);
	}
	$showtable = $showtable."<tr><td>".$rolename."</td><td>".$num."</td></tr>";
	$showtable = $showtable."</table>";
	if($rolename==""){
		echo "<font color='red'>û������</font>";
	}else{
		echo $showtable;
	}
}
?>