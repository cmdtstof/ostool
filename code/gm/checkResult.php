<link type="text/css" rel="stylesheet" href="../css/common.css" />
<?php
header('Content-type: text/html;charset=gbk');
ini_set('max_execution_time', '0');
function checkResult() {
	
	if(isset($_GET["filename"]))
	{
		$filename = $_GET["filename"];

		require '../utils/dbOstoolUtils.php';
		$strsql="SELECT num from buchang where filename like '%".$filename."%'";
		// 执行sql查询
		$result=mysql_query($strsql, $osconn);
		$old = 0;
		// 获取查询结果
		if(mysql_num_rows($result)>0){
			// 定位到第一条记录
			mysql_data_seek($result, 0);
			// 循环取出记录
			while ($row=mysql_fetch_row($result))
			{
				$old = $row[0];
				echo "预计发送数据".$row[0]."条";
				break;
			}
		}
		// 释放资源
		mysql_free_result($result);
		// 关闭连接
		mysql_close($osconn);
		
		
		
		require '../utils/dbTcgLogUtils.php';
		 // 从表中提取信息的sql语句
		$filenametemp = substr($filename, 0,strpos($filename, "."));
		$strsql="SELECT count(1) from gm_log where name='GMT' and memo like '%".$filenametemp."%'";
		$newnum = 0;
		// 执行sql查询
		$result=mysql_query($strsql, $tcglogconn);
		if(mysql_num_rows($result)>0){
			// 定位到第一条记录
			mysql_data_seek($result, 0);
			// 循环取出记录
			while ($row=mysql_fetch_row($result))
			{
				$newnum=$row[0];
				if($row[0]>=0){
					echo "<font color='red'>实际成功发送数据：".$row[0]."条</font>";
				}else{
					echo "<font color='red'>没有发送成功的数据</font>";		
				}
				break;
			}

		}else{
			echo "<font color='red'>没有数据</font>";
		}
		
		if($old>$newnum){
			echo "<br/>没有发送的数据有：";
			$showtable="<table id='tab1' class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' ><tr>";
			$showtable = $showtable."<th>序号</th><th>玩家</th><th>道具ID</th><th>数量</th><th>备注</th>";
			$showtable = $showtable."</tr>";
			
			$fp=fopen("upload/" . $filename,'r');
			$xh=0;
			while(!feof($fp))
			{
				$buffer=fgets($fp);
				if(strlen($buffer)>0){
					$buffer  = substr($buffer,0,strpos($buffer, ";"));
					$a = explode(',',$buffer);
					$rolename=$a[0];
					$prop=$a[1];
					$num=$a[2];
					$remark=$a[3];
					$strsql="SELECT count(1) from gm_log where name='GMT' and target = '$rolename' and memo like '%".$filenametemp."%'";
					$result=mysql_query($strsql, $tcglogconn);
					if(mysql_num_rows($result)>0){
						// 定位到第一条记录
						mysql_data_seek($result, 0);
						// 循环取出记录
						while ($row=mysql_fetch_row($result))
						{
							if($row[0]>0){
							}else{
								$xh++;
								$showtable = $showtable."<tr><td>".$xh."</td><td>".$rolename."</td><td>".$prop."</td><td>".$num."</td><td>".$remark."</td></tr>";	
							}
							break;
						}
			
					}else{
						echo "<font color='red'>没有数据</font>";
					}
					//gm_addItem($rolename,$prop,$num,$remark);
				}
			}
			
			$showtable = $showtable."</table>";
			echo $showtable;
		}
//		
//		
//		// 获取查询结果
//		$showtable="<table id='tab1' class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' ><tr>";
//		$showtable = $showtable."<th>序号</th><th>时间</th><th>GM</th><th>动作</th><th>玩家</th><th>备注</th>";
//		$showtable = $showtable."</tr>";
//
//		$c=mysql_num_rows($result);
//		echo $c;
//		if(mysql_num_rows($result)>0){
//			// 定位到第一条记录
//			mysql_data_seek($result, 0);
//			// 循环取出记录
//			$count=0;
//			while ($row=mysql_fetch_row($result))
//			{
//				$count++;
//				$showtable = $showtable."<tr><td>".$count."</td>";
//				for ($i=0; $i<mysql_num_fields($result); $i++ )
//				{
//
//				}
//				$showtable = $showtable."</tr>";
//			}
//			$showtable = $showtable."</table>";
//			echo $showtable;
//		}else{
//			echo "<font color='red'>没有数据</font>";
//		}
		// 释放资源
		mysql_free_result($result);
		// 关闭连接
		mysql_close($tcglogconn);

	}
	else
	{
		echo "<font color='red'>no data!</font>";
	}

}
checkResult();

function checkResult2() {
	
	if(isset($_GET["filename"]))
	{
		$filename = $_GET["filename"];
		require '../utils/dbTcgLogUtils.php';
		 // 从表中提取信息的sql语句
		$strsql="SELECT update_time,name,action,target,memo from gm_log where name='GMT' and memo like '%".$filename."%'";

		// 执行sql查询
		$result=mysql_query($strsql, $tcglogconn);
		// 获取查询结果
		$showtable="<table id='tab1' class='simpleList' border='1' cellspacing='0' cellpadding='5' rules='rows' ><tr>";
		$showtable = $showtable."<th>序号</th><th>时间</th><th>GM</th><th>动作</th><th>玩家</th><th>备注</th>";
		$showtable = $showtable."</tr>";

		if(mysql_num_rows($result)>0){
			// 定位到第一条记录
			mysql_data_seek($result, 0);
			// 循环取出记录
			$count=0;
			while ($row=mysql_fetch_row($result))
			{
				$count++;
				$showtable = $showtable."<tr><td>".$count."</td>";
				for ($i=0; $i<mysql_num_fields($result); $i++ )
				{
					if($row[$i]=="add_card_to_user"){
						$showtable = $showtable."<td>添加卡牌</td>";
					}else if($row[$i]=="add_item_to_user"){
						$showtable = $showtable."<td>添加物品</td>";
					}else if($row[$i]=="add_score_to_user"){
						$showtable = $showtable."<td>添加积分</td>";
					}else {
						$showtable = $showtable."<td>".$row[$i]."</td>";
					}

				}
				$showtable = $showtable."</tr>";
			}
			$showtable = $showtable."</table>";
			echo $showtable;
		}else{
			echo "<font color='red'>没有数据</font>";
		}
		// 释放资源
		mysql_free_result($result);
		// 关闭连接
		mysql_close($tcglogconn);

	}
	else
	{
		echo "<font color='red'>no data!</font>";
	}

}
?>