<link type="text/css" rel="stylesheet" href="../css/common.css" />
<script type="text/javascript" language="javascript">
function showDiv(div){
	var d = document.getElementById(div).style.display;
	if(d=="none"){
		document.getElementById(div).style.display="";
	}else{
		document.getElementById(div).style.display="none";
	}
}
</script>
<body  style="overflow:scroll;">

<ul><a href="../tcg/onlinenum.php" target="mainFrame">当前在线</a>
</ul>
<ul><a href="../SOC.php" target="mainFrame">线服状况</a>
</ul>

<ul><a href="#" onClick="showDiv('sumDiv');">统计查询</a>
<div id="sumDiv" style="display:none;">
<li><a style="text-decoration:none;color:#4c4c4c;" href="../tcglog/search.php?tablename=score_log" target="mainFrame">玩家积分日志</a></li>
<li><a style="text-decoration:none;color:#4c4c4c;" href="../statistics/carduse.php" target="mainFrame">玩家卡牌统计</a></li>
<li><a style="text-decoration:none;color:#4c4c4c;" href="../statistics/competition.php" target="mainFrame">竞赛奖励核实</a></li>
<li><a style="text-decoration:none;color:#4c4c4c;" href="../statistics/items.php" target="mainFrame">玩家物品统计</a></li>
<li><a style="text-decoration:none;color:#4c4c4c;" href="../statistics/auctionVerify.php" target="mainFrame">拍卖行数据核实</a></li>
<li><a style="text-decoration:none;color:#4c4c4c;" href="../statistics/shuanbeikabei.php" target="mainFrame">双倍积分、卡背核实</a></li>
<li><a style="text-decoration:none;color:#4c4c4c;" href="../statistics/orderVerify.php" target="mainFrame">充值核实</a></li>
</div>
</ul>

<?php
require '../utils/iniUtils.php';
require '../utils/dbBackupUtils.php';
require '../utils/dbTcgLogUtils.php';

require 'logname..php';
?>

<ul><a href="#" onClick="showDiv('singleDiv');">tcglog单表查询</a>
<div id="singleDiv" style="display:none;">
<?php
    // 循环取出记录
	for($i=0,$l=count($arr); $i<$l; $i++) {
	?>
<li>
<a style="text-decoration:none;color:#4c4c4c;"href="../tcglog/search.php?tablename=<?php
		$ttt = "$arr[$i]"."."."$arr[$i]"."_title"; 
		echo "$arr[$i]";?>"  target="mainFrame" ><?php 
		$r = $settings->get("$ttt") ;
		if($r == ""){
			$r = "$arr[$i]";
		}
		echo $r. '';?>
</a></li>
<?php
	}
?>
</div>
</ul>
<ul><a href="#" onClick="showDiv('s11Div');">tcg数据查询</a>
<div id="s11Div" style="display:none;">
<li><a style="text-decoration:none;color:#4c4c4c;" href="../tcg/tcg_search.php?tablename=role" target="mainFrame">role数据</a></li>
<li><a style="text-decoration:none;color:#4c4c4c;" href="../tcg/tcg_search.php?tablename=account" target="mainFrame">account数据</a></li>
<li><a style="text-decoration:none;color:#4c4c4c;" href="../tcg/tcg_search.php?tablename=auction_data" target="mainFrame">拍卖行数据</a></li>
</div>
</ul>

<ul><a href="#" onClick="showDiv('ostoolDiv');">ostool数据查询</a>
<div id="ostoolDiv" style="display:none;">
<li><a style="text-decoration:none;color:#4c4c4c;" href="../ostool/ostool_search.php?tablename=card" target="mainFrame">卡牌信息</a></li>
<li><a style="text-decoration:none;color:#4c4c4c;" href="../ostool/ostool_search.php?tablename=item" target="mainFrame">物品信息</a></li>
</div>
</ul>

<ul><a href="#" onClick="showDiv('baseDiv');">基础数据说明</a>
<div id="baseDiv" style="display:none;">
<li><a style="text-decoration:none;color:#4c4c4c;" href="../base/log.html" target="mainFrame">log规范</a></li>
<li><a style="text-decoration:none;color:#4c4c4c;" href="../base/no.html" target="mainFrame">任务、战役、训练的编号和奖励</a></li>
</div>
</ul>
<?php 
require 'userinfo.php';
if($_COOKIE["username"]==$os_user_name){ ?>
<ul><a href="#" onClick="showDiv('gmDiv');">GM功能</a>
<div id="gmDiv" style="display:none;">
<li><a style="text-decoration:none;color:#4c4c4c;" href="../gm/roleCheckIndex.php" target="mainFrame">角色核对</a></li>
<li><a style="text-decoration:none;color:#4c4c4c;" href="../gm/sendPropsIndex.php" target="mainFrame">道具补发</a></li>
<li><a style="text-decoration:none;color:#4c4c4c;" href="../gm/checkIndex.php" target="mainFrame">补发核实</a></li>
</div>
</ul>
<?php }?>
</body>