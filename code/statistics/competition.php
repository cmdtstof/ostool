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
		if($("#update_time").val()==""){
			alert("�������ѯʱ�䣬��ʽ��ʽ�确2013-01-04��");
			$("#update_time").focus();
			return ;
		}
		
		if($("#update_time").val().length!=10){
			alert("ʱ���ʽ���󣬸�ʽ��ʽ�确2013-01-04��");
			$("#update_time").focus();
			return ;
		}
		var dbs = document.getElementsByName("chooseDB");
		for(var i=0;i<dbs.length;i++){
			if(dbs[i].checked){
				$("#dbc").val(dbs[i].value);
			}
		}
		$("#form1").submit();
    }
	
</script>
<?php
require '../utils/dbBackupUtils.php';
require '../utils/dbTcgLogUtils.php';
require '../utils/iniUtils.php';
?>
<form id="form1" name="form1" method="post" action="competition.php?action=search">
<fieldset>
		<legend style="font-size:12px;color:#3333FF;">����������ʵ</legend>
		��ɫ����<input id="name" name="name" value="<?php echo isset($_POST['name'])==1?$_POST['name']:"" ?>"/>
		�˺ţ�<input id="account" name="account" value="<?php echo isset($_POST['account'])==1?$_POST['account']:"" ?>"/>
		ʱ��like��<input id="update_time" name="update_time" value="<?php echo isset($_POST['update_time'])==1?$_POST['update_time']:"" ?>"/> (ʱ���ʽ�硰2013-01-04��)
		<input type="button" onClick="search22();" value ="��ѯ"/>
		<br />
		<input type="hidden" name="dbc" id="dbc" value="<?php echo isset($_POST['dbc'])==1?$_POST['dbc']:"" ?>" />
		<input type="radio" name="chooseDB" value="0" checked />��ʷ����230<input type="radio" name="chooseDB" value = "1"/>��Ѷ����
</fieldset>
</form>	
<div><font color="red">
��ע��<br />
������ң����뽱�������ھ�����<br />
ս��10���ϣ�Ӯһ�Σ���1������زĿ�<br />
ս��30���ϣ�Ӯ���Σ���2������زĿ�<br />
ս��60���ϣ�Ӯ���Σ���3������زĿ�<br />
���ھ���<br />
������1���ʯ<br />
������3���ʯ<br />
</font></div>
<hr>
<?php
if(!isset($_GET['action'])){
}else if($_GET['action']=='search')
{
?>
������־
<table id='tab1' class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' >
<?php
  $strsql="SELECT * from competition_log where 1=1 ";
  if($_POST["name"]==""){
		
  }else{
		$strsql = $strsql." and name='".$_POST["name"]."'";
  }
  if($_POST["account"]==""){
  }else{
		$strsql = $strsql." and account='".$_POST["account"]."'";
  }
  
  if($_POST["update_time"]==""){
  }else{
		$strsql = $strsql." and update_time like '".$_POST["update_time"]."%'";
  }
	
	//echo $strsql;
   // ִ��sql��ѯ
   $result="";
   if($_POST["dbc"]=="0"){
		$result=mysql_query($strsql, $backupconn);
	}else{
		$result=mysql_query($strsql, $tcglogconn);
	}
    // ��ȡ��ѯ���
    $row=mysql_fetch_row($result);
?><tr><?php 
	for ($i=0; $i<mysql_num_fields($result); $i++){
	?><th><?php 
	$ttt = "competition_log.".mysql_field_name($result, $i); 
		echo $settings->get("$ttt")==""?$ttt:$settings->get("$ttt");
	?></th><?php 
	}
?></tr><?php 
	if(mysql_num_rows($result)>0){
		// ��λ����һ����¼
		mysql_data_seek($result, 0);
		// ѭ��ȡ����¼
		while ($row=mysql_fetch_row($result))
		{
	?>
	<tr>
	<?php
		  for ($i=0; $i<mysql_num_fields($result); $i++ )
		  {
	?>
	<td>
	<?php
	
		$fn = mysql_field_name($result, $i);
		if($fn=="blue_VIP" || $fn=="blue_vip" || $fn=="insider" || $fn=="first_complete"){
			$fv = "common_".$fn."."."$row[$i]";
		}else{
			if("$row[$i]"=="true" || "$row[$i]"=="false"){
				$fv = "competition_log_".$fn."."."$row[$i]"."1";
			}else{
				$fv = "competition_log_".$fn."."."$row[$i]";
			}
		}
		$r = $commonset->get("$fv") ;
		
		if($r == ""){
			$r = "$row[$i]";
		}
			echo $r. '';
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
	
?>
</table>
<?php
}

?>

<?php
if(!isset($_GET['action'])){
}else if($_GET['action']=='search')
{
?>
�����Ʒ
<table class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' >
<?php
  $strsql="SELECT * from item_log where item_from in ('competition','gm') ";
  if($_POST["name"]==""){
		
  }else{
		$strsql = $strsql." and name='".$_POST["name"]."'";
  }
  if($_POST["account"]==""){
  }else{
		$strsql = $strsql." and account='".$_POST["account"]."'";
  }
  
  if($_POST["update_time"]==""){
  }else{
		$strsql = $strsql." and update_time like '".$_POST["update_time"]."%'";
  }
	
   // ִ��sql��ѯ
    
   if($_POST["dbc"]=="0"){
		$result=mysql_query($strsql, $backupconn);
	}else{
		$result=mysql_query($strsql, $tcglogconn);
	}
    // ��ȡ��ѯ���
    $row=mysql_fetch_row($result);
?><tr><?php 
	for ($i=0; $i<mysql_num_fields($result); $i++){
	?><th><?php 
	$ttt = "item_log.".mysql_field_name($result, $i); 
		echo $settings->get("$ttt")==""?$ttt:$settings->get("$ttt");
	?></th><?php 
	}
?></tr><?php 
	if(mysql_num_rows($result)>0){
		// ��λ����һ����¼
		mysql_data_seek($result, 0);
		// ѭ��ȡ����¼
		while ($row=mysql_fetch_row($result))
		{
	?>
	<tr>
	<?php
		  for ($i=0; $i<mysql_num_fields($result); $i++ )
		  {
	?>
	<td>
	<?php
	
		$fn = mysql_field_name($result, $i);
		if($fn=="blue_VIP" || $fn=="blue_vip" || $fn=="insider" || $fn=="first_complete"){
			$fv = "common_".$fn."."."$row[$i]";
		}else{
			$fv = "item_log_".$fn."."."$row[$i]";
		}
		$r = $commonset->get("$fv") ;
		
		if($r == ""){
			$r = "$row[$i]";
		}
			echo $r. '';
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
	
?>
</table>
<?php
}

?>


<?php
if(!isset($_GET['action'])){
}else if($_GET['action']=='search')
{
?>
ս��
<table class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' >
<?php
  $strsql="SELECT SUM(duel_level_num) from duel_level_log where action='competition' ";
  if($_POST["name"]==""){
		
  }else{
		$strsql = $strsql." and name='".$_POST["name"]."'";
  }
  if($_POST["account"]==""){
  }else{
		$strsql = $strsql." and account='".$_POST["account"]."'";
  }
  
  if($_POST["update_time"]==""){
  }else{
		$strsql = $strsql." and update_time like '".$_POST["update_time"]."%'";
  }
	
	//echo $strsql;
   // ִ��sql��ѯ
    
   if($_POST["dbc"]=="0"){
		$result=mysql_query($strsql, $backupconn);
	}else{
		$result=mysql_query($strsql, $tcglogconn);
	}
    // ��ȡ��ѯ���
    $row=mysql_fetch_row($result);
?><tr><th>��ɫ</th><th>ս��</th></tr><?php 
	if(mysql_num_rows($result)>0){
		// ��λ����һ����¼
		mysql_data_seek($result, 0);
		// ѭ��ȡ����¼
		while ($row=mysql_fetch_row($result))
		{
	?>
	<tr><td><?php echo $_POST["name"];?></td>
	<?php
		  for ($i=0; $i<mysql_num_fields($result); $i++ )
		  {
	?>
	<td>
	<?php
			echo "$row[$i]";
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
    mysql_close($tcglogconn);
    
   if($_POST["dbc"]=="0"){
		mysql_close($backupconn);
	}else{
		mysql_close($tcglogconn);
	}
	
?>
</table>
<?php
}

?>
<script type="text/javascript">
	trStyleChange();
</script>