<link type="text/css" rel="stylesheet" href="../css/common.css" />
<script type="text/javascript" src = "../js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src = "../js/common.js"></script>
<script type="text/javascript">
	function search22(){
		if($("#name").val()=="" && $("#account").val()==""){
			alert("请输入角色或账号");
			$("#name").focus();
			return ;
		}
		if($("#update_time").val()==""){
			alert("请输入查询时间，格式格式如‘2013-01-04’");
			$("#update_time").focus();
			return ;
		}
		
		if($("#update_time").val().length!=10){
			alert("时间格式错误，格式格式如‘2013-01-04’");
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
		<legend style="font-size:12px;color:#3333FF;">竞赛奖励核实</legend>
		角色名：<input id="name" name="name" value="<?php echo isset($_POST['name'])==1?$_POST['name']:"" ?>"/>
		账号：<input id="account" name="account" value="<?php echo isset($_POST['account'])==1?$_POST['account']:"" ?>"/>
		时间like：<input id="update_time" name="update_time" value="<?php echo isset($_POST['update_time'])==1?$_POST['update_time']:"" ?>"/> (时间格式如“2013-01-04”)
		<input type="button" onClick="search22();" value ="查询"/>
		<br />
		<input type="hidden" name="dbc" id="dbc" value="<?php echo isset($_POST['dbc'])==1?$_POST['dbc']:"" ?>" />
		<input type="radio" name="chooseDB" value="0" checked />历史数据230<input type="radio" name="chooseDB" value = "1"/>腾讯数据
</fieldset>
</form>	
<div><font color="red">
备注：<br />
所有玩家（参与奖，包含冠军）：<br />
战功10以上（赢一次），1个随机素材卡<br />
战功30以上（赢两次），2个随机素材卡<br />
战功60以上（赢三次），3个随机素材卡<br />
仅冠军：<br />
周赛：1灵魂石<br />
月赛：3灵魂石<br />
</font></div>
<hr>
<?php
if(!isset($_GET['action'])){
}else if($_GET['action']=='search')
{
?>
竞赛日志
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
   // 执行sql查询
   $result="";
   if($_POST["dbc"]=="0"){
		$result=mysql_query($strsql, $backupconn);
	}else{
		$result=mysql_query($strsql, $tcglogconn);
	}
    // 获取查询结果
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
		// 定位到第一条记录
		mysql_data_seek($result, 0);
		// 循环取出记录
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
    // 释放资源
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
获得物品
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
	
   // 执行sql查询
    
   if($_POST["dbc"]=="0"){
		$result=mysql_query($strsql, $backupconn);
	}else{
		$result=mysql_query($strsql, $tcglogconn);
	}
    // 获取查询结果
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
		// 定位到第一条记录
		mysql_data_seek($result, 0);
		// 循环取出记录
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
    // 释放资源
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
战功
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
   // 执行sql查询
    
   if($_POST["dbc"]=="0"){
		$result=mysql_query($strsql, $backupconn);
	}else{
		$result=mysql_query($strsql, $tcglogconn);
	}
    // 获取查询结果
    $row=mysql_fetch_row($result);
?><tr><th>角色</th><th>战功</th></tr><?php 
	if(mysql_num_rows($result)>0){
		// 定位到第一条记录
		mysql_data_seek($result, 0);
		// 循环取出记录
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
    // 释放资源
    mysql_free_result($result);
	
    // 关闭连接
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