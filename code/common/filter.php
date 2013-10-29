<fieldset>
	<legend style="font-size:12px;color:#3333FF;">过滤条件</legend>
<?php 
// 定位到第一条记录
    mysql_data_seek($result, 0);
	$seltemp="";
    // 循环取出记录
	while ($row=mysql_fetch_row($result))
    {
      for ($i=0; $i<mysql_num_fields($result); $i++ )
      {
		if($seltemp==""){
			$seltemp = $seltemp.$row[$i];
		}else{
			$seltemp = $seltemp.",".$row[$i];
		}
		$ttt = $_GET["tablename"]."."."$row[$i]"; 
		$r = $settings->get("$ttt") ;
		if($r == ""){
			$r = "$row[$i]";
		}
		?><input type="checkbox"  name="filter" id="filter" value="<?php echo "$row[$i]";?>"><?php echo $r . '';?></checkbox><?php
      }
	}
?>
</fieldset>