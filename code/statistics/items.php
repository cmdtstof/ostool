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
		if($("#item_iid").val()==""){
			alert("请输入卡牌IID");
			$("#item_iid").focus();
			return ;
		}
		if($("#update_time").val()==""){
			alert("请输入查询时间，格式格式如‘2013-01-04 00:00:00’");
			$("#update_time").focus();
			return ;
		}
		if($("#update_time").val().length!=19){
			alert("时间格式错误，格式格式如‘2013-01-04 00:00:00:’");
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
		<legend style="font-size:12px;color:#3333FF;">玩家物品统计</legend>
		角色名：<input id="name" name="name" value="<?php echo isset($_POST['name'])==1?$_POST['name']:"" ?>"/>
		账号：<input id="account" name="account" value="<?php echo isset($_POST['account'])==1?$_POST['account']:"" ?>"/>
		物品IID：<input id="item_iid" name="item_iid" value="<?php echo isset($_POST['item_iid'])==1?$_POST['item_iid']:"" ?>"/> 
		<?php 
			$strsql = "select time from users_update_time";
			$basetime="";
			$result=mysql_query($strsql, $osconn);
			if(mysql_num_rows($result)>0){
			// 定位到第一条记录
				mysql_data_seek($result, 0);
				// 循环取出记录
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
		时间>=：<input id="update_time" name="update_time" value="<?php echo isset($_POST['update_time'])==1?$_POST['update_time']:$basetime ?>"/>（时间格式 '2013-01-04 00:00:00') 
		<input type="button" onClick="search22();" value ="查询"/>
		<br /><font color="red">此数据的基础信息是<?php echo $basetime ;?>
		</font>
</fieldset>
</form>	


<?php
if(!isset($_GET['action'])){
}else if($_GET['action']=='search')
{
$count = 0;
?>
<font color = "red">物品日志</font>
<table id='tab1' class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' ><tr><th>角色</th><th>物品名称</th><th>物品iid</th><th>获得总数</th><th>消耗总数</th><th>剩余数量</th><th>其中GM操作数量</th><th>明细</th></tr>
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
  $backsearch=0;//是否查询备份数据
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
   // 执行sql查询
    $result=mysql_query($tcglogsql, $tcglogconn);
    // 获取查询结果
	echo $result;
	if($result){
		$row=mysql_fetch_row($result);
		if(mysql_num_rows($result)>0){
			// 定位到第一条记录
			mysql_data_seek($result, 0);
			// 循环取出记录
			while ($row=mysql_fetch_row($result))
			{
			  for ($i=0; $i<mysql_num_fields($result); $i++ )
			  {
				$a[$i]=("$row[$i]"==""?0:$row[$i]);
				if($i==5) { //剩余数量
					$count = "$row[$i]"==""?0:$row[$i];
				}
				if($i==6) { //GM操作数量
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
		// 获取查询结果
		if($result){
			$row=mysql_fetch_row($result);
			if(mysql_num_rows($result)>0){
				// 定位到第一条记录
				mysql_data_seek($result, 0);
				
				// 循环取出记录
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
					if($i==5) { //剩余数量
						$count = $count+("$row[$i]"==""?0:$row[$i]);
					}
					if($i==6) { //GM操作数量
						$count = $count- ("$row[$i]"==""?0:$row[$i]);
					}
					//echo "$row[$i]"==""?0:$row[$i];
				  }
				}
			}
		}
	}
	?>
	<tr><td><?php echo $a[0];?></td><td><?php echo $a[1];?></td><td><?php echo $a[2];?></td><td><?php echo $a[3];?></td><td><?php echo $a[4];?></td><td><?php echo $a[5];?></td><td><?php echo $a[6];?></td><td><a href="#" onClick="opendetail();">明细</a></td></tr>
	<?php 
	// 释放资源
	mysql_free_result($result);
	mysql_close($backupconn);
	mysql_close($tcglogconn);
	?>
</table>

<font color = "red">玩家基础数据有 </font>
<table id='tab3' class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' ><tr><th>角色</th><th>物品iid</th><th>物品数量</th><th>绑定数量</th></tr>
<?php 
  $strsql="SELECT info from role where 1=1 ";
  if($_POST["name"]==""){
		
  }else{
		$strsql = $strsql." and name='".$_POST["name"]."'";
  }
	
	//echo $strsql;
   // 执行sql查询
	mysql_select_db($os_database, $osconn);
    $result=mysql_query($strsql, $osconn);
    // 获取查询结果
    $row=mysql_fetch_row($result);
	
	if(mysql_num_rows($result)>0){
		// 定位到第一条记录
		mysql_data_seek($result, 0);
		// 循环取出记录
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
    // 释放资源
    mysql_free_result($result);
    // 关闭连接
    mysql_close($osconn);
	?>
</table>

<font color = "red">玩家身上现有</font>
<table id='tab2' class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' ><tr><th>角色</th><th>物品iid</th><th>物品数量</th><th>绑定数量</th></tr>
<?php 
require '../utils/dbTcgUtils.php';
  $strsql="SELECT info from role where 1=1 ";
  if($_POST["name"]==""){
		
  }else{
		$strsql = $strsql." and name='".$_POST["name"]."'";
  }
	
	//echo $strsql;
   // 执行sql查询;
    $result=mysql_query($strsql, $tcgconn);
    // 获取查询结果
    $row=mysql_fetch_row($result);
	
	if(mysql_num_rows($result)>0){
		// 定位到第一条记录
		mysql_data_seek($result, 0);
		// 循环取出记录
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
    // 释放资源
    mysql_free_result($result);
	mysql_close($tcgconn);
	?>
</table>
丢失数据<font color = "red">（公式:基础数量(包含绑定)+剩余数量-现有数量(包含绑定)-GM操作数量）</font>
<table id='tab4' class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' >
<tr><td><?php echo $count;?></td></tr>
</table>
<?php
}

?>
<script type="text/javascript">
	trStyleChange();
</script>