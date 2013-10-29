<?php    
 /* CAT:Line chart */ 
 /* pChart library inclusions */ 
 include("../plugs/pChar/class/pData.class.php"); 
 include("../plugs/pChar/class/pDraw.class.php"); 
 include("../plugs/pChar/class/pImage.class.php"); 
 
  $tcglog_server_name="127.0.0.1"; //数据库服务器名称
  $tcglog_username="chenyl"; // 连接数据库用户名
  $tcglog_password="cyl"; // 连接数据库密码
  $tcglog_database="tcglog"; // 数据库的名字  
  
  // 连接到数据库
  $tcglogconn=mysql_connect($tcglog_server_name, $tcglog_username,
                        $tcglog_password);
  mysql_select_db($tcglog_database, $tcglogconn);
  mysql_query("set names 'GBK'");
  $strsql = "SELECT date_format(from_unixtime(UNIX_TIMESTAMP(update_time)-UNIX_TIMESTAMP(update_time)%(3 * 60)), '%Y-%m-%d %H:%i') as data_time,SUM(count) as count  FROM gs_log where update_time  BETWEEN DATE_sub(NOW(),INTERVAL 60 MINUTE) and  NOW() and type='account' GROUP BY date_format(from_unixtime(UNIX_TIMESTAMP(update_time)-UNIX_TIMESTAMP(update_time)%(3 * 60)), '%Y-%m-%d %H:%i') ORDER BY date_format(from_unixtime(UNIX_TIMESTAMP(update_time)-UNIX_TIMESTAMP(update_time)%(3 * 60)), '%Y-%m-%d %H:%i') DESC";
   $result=mysql_query($strsql, $tcglogconn);
   $a = array();
   $b = array();
   if(mysql_num_rows($result)>0){
		mysql_data_seek($result, 0);
		// 循环取出记录
		while ($row=mysql_fetch_row($result))
		{
		 array_unshift($a,substr($row[0],11,5));
		 array_unshift($b,$row[1]);
		}
   }
   
   
   
   
 /* Create and populate the pData object */ 
 $MyData = new pData();   
 $MyData->addPoints($b,"online"); 
 //$MyData->addPoints(array(2,7,5,18,19,22),"Probe 2"); 
 $MyData->setSerieWeight("online",1); 
// $MyData->setSerieTicks("Probe 2",4); 
 $MyData->setAxisName(0,"PEOPLE NUM"); 
 
 $MyData->addPoints($a,"Labels"); 
 $MyData->setSerieDescription("Labels","Months"); 
 $MyData->setAbscissa("Labels"); 

 /* Create the pChart object */ 
 $myPicture = new pImage(900,500,$MyData); 

 /* Turn of Antialiasing */ 
 $myPicture->Antialias = FALSE; 

 /* Draw the background  背景*/ 
 $Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107); 
 $myPicture->drawFilledRectangle(0,0,900,500,$Settings); 

 /* Overlay with a gradient 图区*/ 
 $Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50); 
 $myPicture->drawGradientArea(0,0,900,500,DIRECTION_VERTICAL,$Settings); 
 $myPicture->drawGradientArea(0,0,900,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80)); 

 /* Add a border to the picture  表格外框*/ 
 $myPicture->drawRectangle(0,0,899,499,array("R"=>0,"G"=>0,"B"=>0)); 
  
 /* Write the chart title 标题*/  
 $myPicture->setFontProperties(array("FontName"=>"../plugs/pChar/fonts/Forgotte.ttf","FontSize"=>8,"R"=>255,"G"=>255,"B"=>255)); 
 $myPicture->drawText(10,16,"ONLINE PEOPLE",array("FontSize"=>11,"Align"=>TEXT_ALIGN_BOTTOMLEFT)); 

 /* Set the default font 字体*/ 
 $myPicture->setFontProperties(array("FontName"=>"../plugs/pChar/fonts/pf_arma_five.ttf","FontSize"=>6,"R"=>0,"G"=>0,"B"=>0)); 

 /* Define the chart area */ 
 $myPicture->setGraphArea(60,40,880,450); 

 /* Draw the scale */ 
 $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE); 
 $myPicture->drawScale($scaleSettings); 

 /* Turn on Antialiasing */ 
 $myPicture->Antialias = TRUE; 

 /* Enable shadow computing */ 
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 

 /* Draw the line chart */ 
 $myPicture->drawLineChart(); 
 $myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>TRUE,"BorderSize"=>2,"Surrounding"=>-60,"BorderAlpha"=>80)); 

 /* Write the chart legend */ 
 $myPicture->drawLegend(590,9,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255)); 

 /* Render the picture (choose the best way) */ 
 $myPicture->autoOutput("pictures/example.drawLineChart.plots.png"); 
?>