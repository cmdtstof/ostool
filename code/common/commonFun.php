<?php
 function ceshi($conn,$database,$tablename ,$sqlt){
 	$xxxxx="select collation_name from information_schema.COLUMNS where TABLE_SCHEMA='".$database."' and TABLE_NAME='".$tablename."' and column_name = 'name'";
	$r = $sqlt;
   // 执行sql查询
	$xresult=mysql_query($xxxxx, $conn);
	// 定位到第一条记录
	$num = mysql_num_rows($xresult);
	if($num>0){
		mysql_data_seek($xresult, 0);
		// 循环取出记录
		while ($xrow=mysql_fetch_row($xresult))
		{
			for ($i=0; $i<mysql_num_fields($xresult); $i++ )
			{
				$fn = "";
				if("$xrow[$i]"=="gbk_chinese_ci"){
					$fn = " COLLATE gbk_bin ";
				}else if("$xrow[$i]"=="utf8_general_ci"){
					$fn = " COLLATE utf8_bin ";
				}
				$seltemp = array('name '=>'name '.$fn);
				$r = strtr($sqlt,$seltemp);
				break;
			}
		}
		return $r;
	}
		
	return $r;
}
?>