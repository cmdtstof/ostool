<link type="text/css" rel="stylesheet" href="../css/common.css" />
<script type="text/javascript" src = "../js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src = "../js/common.js"></script>
<script type="text/javascript">
	function search22(){
		if($("#name").val()=="" && $("#account").val()==""){
			alert("�������ɫ���˺�");
			$("#name").focus();
			return ;
		}
		if($("#item_iid").val()==""){
			alert("�����뿨��IID");
			$("#item_iid").focus();
			return ;
		}
		if($("#update_time").val()==""){
			alert("�������ѯʱ�䣬��ʽ��ʽ�确2013-01-04 00:00:00��");
			$("#update_time").focus();
			return ;
		}
		if($("#update_time").val().length!=19){
			alert("ʱ���ʽ���󣬸�ʽ��ʽ�确2013-01-04 00:00:00:��");
			$("#update_time").focus();
			return ;
		}
		$("#form1").submit();
    }
	
	function opendetail(){
	var url = "detail.php?action=detail&table=item_log&name="+$("#name").val()+"&account="+$("#account").val()+"&item_iid="+$("#item_iid").val()+"&update_time="+$("#update_time").val();
	
				window.showModalDialog(encodeURI(encodeURI(url)),"","dialogWidth:800px;help:no;location:no;status:no;center:yes;scroll:no;");
	}
</script>
<?php
require '../utils/dbBackupUtils.php';
require '../utils/dbOstoolUtils.php';
require '../utils/iniUtils.php';
?>
<form id="form1" name="form1" method="post" action="items.php?action=search">
<fieldset>
		<legend style="font-size:12px;color:#3333FF;">�����Ʒͳ��</legend>
		��ɫ����<input id="name" name="name" value="<?php echo isset($_POST['name'])==1?$_POST['name']:"" ?>"/>
		�˺ţ�<input id="account" name="account" value="<?php echo isset($_POST['account'])==1?$_POST['account']:"" ?>"/>
		��ƷIID��<input id="item_iid" name="item_iid" value="<?php echo isset($_POST['item_iid'])==1?$_POST['item_iid']:"" ?>"/> 
		<?php 
			$strsql = "select time from users_update_time";
			$basetime="";
			$result=mysql_query($strsql, $osconn);
			if(mysql_num_rows($result)>0){
			// ��λ����һ����¼
				mysql_data_seek($result, 0);
				// ѭ��ȡ����¼
				while ($row=mysql_fetch_row($result))
				{
					 for ($i=0; $i<mysql_num_fields($result); $i++ )
					{
						$basetime = "$row[$i]";
						break;
					}
				}
			}
    		mysql_free_result($result);
			//mysql_close($osconn);
		?>
		ʱ��>=��<input id="update_time" name="update_time" value="<?php echo isset($_POST['update_time'])==1?$_POST['update_time']:$basetime ?>"/>��ʱ���ʽ '2013-01-04 00:00:00') 
		<input type="button" onClick="search22();" value ="��ѯ"/>
		<br /><font color="red">�����ݵĻ�����Ϣ��<?php echo $basetime ;?>
		</font>
</fieldset>
</form>	


<?php
if(!isset($_GET['action'])){
}else if($_GET['action']=='search')
{
$count = 0;
?>
<font color = "red">��Ʒ��־</font>
<table id='tab1' class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' ><tr><th>��ɫ</th><th>��Ʒ����</th><th>��Ʒiid</th><th>�������</th><th>��������</th><th>ʣ������</th><th>����GM��������</th><th>��ϸ</th></tr>
<?php 
require '../utils/dbTcgLogUtils.php';
  $strsql="SELECT name,item_name,item_iid,SUM(iF(action ='add',item_num,0)) as addNum,SUM(iF(action ='remove',item_num,0)) as removeNum,SUM(iF(action ='add',item_num,0)) - SUM(iF(action ='remove',item_num,0)) as nowNum,(SUM(iF(action ='add' and item_from = 'gm',item_num,0))-SUM(iF(action ='remove' and item_from = 'gm',item_num,0)) )as gmos from item_log where 1=1 ";
  
  if($_POST["name"]==""){
		
  }else{
		$strsql = $strsql." and name='".$_POST["name"]."'";
  }
  if($_POST["account"]==""){
		
  }else{
		$strsql = $strsql." and account='".$_POST["account"]."'";
  }
  if($_POST["item_iid"]==""){
  }else{
		$strsql = $strsql." and item_iid=".$_POST["item_iid"]."";
  }
  
  $strsql = $strsql." and item_from not in ('consume','add_value','destory','destroy','item_apply_add','item_apply_add') ";
	
  $backsql="";
  $tcglogsql=$strsql;
  $backsearch=0;//�Ƿ��ѯ��������
  if($_POST["update_time"]==""){
		
  }else{
		//$strsql = $strsql." and update_time >= '".$_POST["update_time"]."'";
		date_default_timezone_set("PRC");
		if (strcmp(date("Y-m-d 00:00:00",time()),$_POST["update_time"])>0){
			$backsearch=1;
			$tcglogsql=$strsql." and update_time >= '".date("Y-m-d 00:00:00",time())."'";
		}else{
			$backsearch=0;
			$tcglogsql=$strsql." and update_time >= '".$_POST["update_time"]."'";
		}
		$backsql = $strsql." and update_time >= '".$_POST["update_time"]."'";
  }
	$a = array("","","",0,0,0,0);
	//echo $strsql;
   // ִ��sql��ѯ
    $result=mysql_query($tcglogsql, $tcglogconn);
    // ��ȡ��ѯ���
	echo $result;
	if($result){
		$row=mysql_fetch_row($result);
		if(mysql_num_rows($result)>0){
			// ��λ����һ����¼
			mysql_data_seek($result, 0);
			// ѭ��ȡ����¼
			while ($row=mysql_fetch_row($result))
			{
			  for ($i=0; $i<mysql_num_fields($result); $i++ )
			  {
				$a[$i]=("$row[$i]"==""?0:$row[$i]);
				if($i==5) { //ʣ������
					$count = "$row[$i]"==""?0:$row[$i];
				}
				if($i==6) { //GM��������
					$count = $count- ("$row[$i]"==""?0:$row[$i]);
				}
				//echo "$row[$i]"==""?0:$row[$i];
			  }
			}
		}
	}
	if($backsearch==1){
	//echo $backsql;
		mysql_select_db($backup_database, $backupconn);
		$result=mysql_query($backsql, $backupconn);
		echo $result;
		// ��ȡ��ѯ���
		if($result){
			$row=mysql_fetch_row($result);
			if(mysql_num_rows($result)>0){
				// ��λ����һ����¼
				mysql_data_seek($result, 0);
				
				// ѭ��ȡ����¼
				while ($row=mysql_fetch_row($result))
				{
				  for ($i=0; $i<mysql_num_fields($result); $i++ )
				  {
					if($i>2){
						$a[$i]=$a[$i]+("$row[$i]"==""?0:$row[$i]);
					}else{
						if($a[$i]=="")
							$a[$i]=("$row[$i]"==""?0:$row[$i]);
					}
					if($i==5) { //ʣ������
						$count = $count+("$row[$i]"==""?0:$row[$i]);
					}
					if($i==6) { //GM��������
						$count = $count- ("$row[$i]"==""?0:$row[$i]);
					}
					//echo "$row[$i]"==""?0:$row[$i];
				  }
				}
			}
		}
	}
	?>
	<tr><td><?php echo $a[0];?></td><td><?php echo $a[1];?></td><td><?php echo $a[2];?></td><td><?php echo $a[3];?></td><td><?php echo $a[4];?></td><td><?php echo $a[5];?></td><td><?php echo $a[6];?></td><td><a href="#" onClick="opendetail();">��ϸ</a></td></tr>
	<?php 
	// �ͷ���Դ
	mysql_free_result($result);
	mysql_close($backupconn);
	mysql_close($tcglogconn);
	?>
</table>

<font color = "red">��һ��������� </font>
<table id='tab3' class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' ><tr><th>��ɫ</th><th>��Ʒiid</th><th>��Ʒ����</th><th>������</th></tr>
<?php 
  $strsql="SELECT info from role where 1=1 ";
  if($_POST["name"]==""){
		
  }else{
		$strsql = $strsql." and name='".$_POST["name"]."'";
  }
	
	//echo $strsql;
   // ִ��sql��ѯ
	mysql_select_db($os_database, $osconn);
    $result=mysql_query($strsql, $osconn);
    // ��ȡ��ѯ���
    $row=mysql_fetch_row($result);
	
	if(mysql_num_rows($result)>0){
		// ��λ����һ����¼
		mysql_data_seek($result, 0);
		// ѭ��ȡ����¼
		while ($row=mysql_fetch_row($result))
		{
	?>
	<tr><td><?php echo $_POST["name"];?></td><td><?php echo $_POST["item_iid"];?></td>
	<?php
		  for ($i=0; $i<mysql_num_fields($result); $i++ )
		  {
	?>
	<td>
			<?php
					$a1= strpos($row[$i],"['item']=");
					//echo $a1;
					$t1= substr($row[$i],$a1);
					//echo $t1;
					$a2= strpos($t1,"},}");
					//echo $a2;
					$t2= substr($t1,0,$a2+1);
					//echo $t2;
					$len = strlen("['id']=".$_POST["item_iid"].",['num']=");
					$start  = strpos($t2,"['id']=".$_POST["item_iid"].",['num']=");
					if($start>0){
						$subs = substr($t2,$start+$len);				
						$end  = strpos($subs,",");
						echo substr($subs,0,$end);
						$count = $count+ substr($subs,0,$end);
					}else{
						echo "0";
					}
			?>
	</td><td>
	<?php
					$a1= strpos($row[$i],"['binding_item']=");
					//echo $a1;
					$t1= substr($row[$i],$a1);
					//echo $t1;
					$a2= strpos($t1,"},}");
					//echo $a2;
					$t2= substr($t1,0,$a2+1);
					//echo $t2;
					$len = strlen("['id']=".$_POST["item_iid"].",['num']=");
					$start  = strpos($t2,"['id']=".$_POST["item_iid"].",['num']=");
					if($start>0){
						$subs = substr($t2,$start+$len);				
						$end  = strpos($subs,",");
						echo substr($subs,0,$end);
						$count = $count+ substr($subs,0,$end);
					}else{
						echo "0";
					}
			?>
	</td>
	<?php
		  }
	?>
	</tr>
	<?php
	   
		}
	}
    // �ͷ���Դ
    mysql_free_result($result);
    // �ر�����
    mysql_close($osconn);
	?>
</table>

<font color = "red">�����������</font>
<table id='tab2' class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' ><tr><th>��ɫ</th><th>��Ʒiid</th><th>��Ʒ����</th><th>������</th></tr>
<?php 
require '../utils/dbTcgUtils.php';
  $strsql="SELECT info from role where 1=1 ";
  if($_POST["name"]==""){
		
  }else{
		$strsql = $strsql." and name='".$_POST["name"]."'";
  }
	
	//echo $strsql;
   // ִ��sql��ѯ;
    $result=mysql_query($strsql, $tcgconn);
    // ��ȡ��ѯ���
    $row=mysql_fetch_row($result);
	
	if(mysql_num_rows($result)>0){
		// ��λ����һ����¼
		mysql_data_seek($result, 0);
		// ѭ��ȡ����¼
		while ($row=mysql_fetch_row($result))
		{
	?>
	<tr><td><?php echo $_POST["name"];?></td><td><?php echo $_POST["item_iid"];?></td>
	<?php
		  for ($i=0; $i<mysql_num_fields($result); $i++ )
		  {
	?>
			<td>
			<?php
					$a1= strpos($row[$i],"['item']=");
					//echo $a1;
					$t1= substr($row[$i],$a1);
					//echo $t1;
					$a2= strpos($t1,"},}");
					//echo $a2;
					$t2= substr($t1,0,$a2+1);
					//echo $t2;
					$len = strlen("['id']=".$_POST["item_iid"].",['num']=");
					$start  = strpos($t2,"['id']=".$_POST["item_iid"].",['num']=");
					if($start>0){
						$subs = substr($t2,$start+$len);				
						$end  = strpos($subs,",");
						echo substr($subs,0,$end);
						$count = $count- substr($subs,0,$end);
					}else{
						echo "0";
					}
					
					?>
			</td><td>
	<?php
					$a1= strpos($row[$i],"['binding_item']=");
					//echo $a1;
					$t1= substr($row[$i],$a1);
					//echo $t1;
					$a2= strpos($t1,"},}");
					//echo $a2;
					$t2= substr($t1,0,$a2+1);
					//echo $t2;
					$len = strlen("['id']=".$_POST["item_iid"].",['num']=");
					$start  = strpos($t2,"['id']=".$_POST["item_iid"].",['num']=");
					if($start>0){
						$subs = substr($t2,$start+$len);				
						$end  = strpos($subs,",");
						echo substr($subs,0,$end);
						$count = $count- substr($subs,0,$end);
					}else{
						echo "0";
					}
					?>
			</td>
	<?php
		  }
	?>
	</tr>
	<?php
	   
		}
	}
    // �ͷ���Դ
    mysql_free_result($result);
	mysql_close($tcgconn);
	?>
</table>
��ʧ����<font color = "red">����ʽ:��������(������)+ʣ������-��������(������)-GM����������</font>
<table id='tab4' class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' >
<tr><td><?php echo $count;?></td></tr>
</table>
<?php
}

?>
<script type="text/javascript">
	trStyleChange();
</script>