<link type="text/css" rel="stylesheet" href="../css/common.css" />
<?php
header('Content-type: text/html;charset=gbk');
function checkResult() {
	
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
checkResult();
?>