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
		$str =iconv("UTF-8","GBK",$str); //����ת��
		$contttsql = $contttsql." and name='".$str."'";
	}

	if(!isset($_POST["account"])||$_POST["account"]==""){
	}else{
		$str=urldecode($_POST["account"]);
		$str =iconv("UTF-8","GBK",$str); //����ת��
		$contttsql = $contttsql." and account='".$str."'";
	}

	$backsql=$contttsql;
	$todaysql=$contttsql;
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
			$todaysql = $contttsql." and update_time >= '".date("Y-m-d 00:00:00",time())."' and update_time <= '".$endtime."'";
		}else{ //ֻ�����
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
	
	$showtable="<table border='1'><tr><th>��ɫ</th><th>duel_log����</th><th>train_log����</th><th>guide_log����</th></tr>";
	$rolename="";
	$duel_num=0;
	$train_num=0;
	$guide_num=0;
	if($todaysearch==1){
		//echo $strsql;
		// ִ��sql��ѯ
   
		require '.../../utils/dbTcgLogUtils.php';
		$result=mysql_query($todaysql, $tcglogconn);
		// ��ȡ��ѯ���
		if(mysql_num_rows($result)>0){
			// ��λ����һ����¼
			mysql_data_seek($result, 0);
			// ѭ��ȡ����¼
			while ($row=mysql_fetch_row($result))
			{
		
				$rolename=$row[0];
				$duel_num=$row[1];
				$train_num=$row[2];
				$guide_num=$row[3];
			}
		}
		// �ͷ���Դ
		mysql_free_result($result);
		// �ر�����
		mysql_close($tcglogconn);
	}
	
	if($backsearch==1){
		//echo $strsql;
		// ִ��sql��ѯ
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
				$duel_num=$duel_num+$row[1];
				$train_num=$train_num+$row[2];
				$guide_num=$guide_num+$row[3];
			}
		}
		// �ͷ���Դ
		mysql_free_result($result);
		// �ر�����
		mysql_close($backupconn);
	}
	$showtable = $showtable."<tr><td>".$rolename."</td><td>".$duel_num."</td><td>".$train_num."</td><td>".$guide_num."</td></tr>";
	$showtable = $showtable."</table>";
	if($rolename==""){
		echo "<font color='red'>û������</font>";
	}else{
		echo $showtable;
	}
}
?>