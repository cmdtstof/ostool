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


<ul><a href="#" onClick="showDiv('sumDiv');">ͳ�Ʋ�ѯ</a>
<div id="sumDiv" style="display:none;">
<li><a style="text-decoration:none;color:#4c4c4c;" href="../tcglog/search.php?tablename=score_log" target="mainFrame">��һ�����־</a></li>
<li><a style="text-decoration:none;color:#4c4c4c;" href="../statistics/carduse.php" target="mainFrame">��ҿ���ͳ��</a></li>
<li><a style="text-decoration:none;color:#4c4c4c;" href="../statistics/competition.php" target="mainFrame">����������ʵ</a></li>
<li><a style="text-decoration:none;color:#4c4c4c;" href="../statistics/items.php" target="mainFrame">�����Ʒͳ��</a></li>
<li><a style="text-decoration:none;color:#4c4c4c;" href="../statistics/auctionVerify.php" target="mainFrame">���������ݺ�ʵ</a></li>
<li><a style="text-decoration:none;color:#4c4c4c;" href="../statistics/shuanbeikabei.php" target="mainFrame">˫�����֡�������ʵ</a></li>
<li><a style="text-decoration:none;color:#4c4c4c;" href="../statistics/orderVerify.php" target="mainFrame">��ֵ��ʵ</a></li>
</div>
</ul>

<?php
require '../utils/iniUtils.php';
require '../utils/dbBackupUtils.php';
require '../utils/dbTcgLogUtils.php';
   //��ѯ �ֶ�
  $strsql="select table_name,table_collation from information_schema.TABLES where TABLE_SCHEMA='".$backup_database."'";
  // ִ��sql��ѯ
   $result=mysql_query($strsql, $backupconn);
   // ��ȡ��ѯ���
   $row=mysql_fetch_row($result);
	// ��λ����һ����¼
    mysql_data_seek($result, 0);
	$seltemp="";
?>

<ul><a href="#" onClick="showDiv('singleDiv');">tcglog�����ѯ</a>
<div id="singleDiv" style="display:none;">
<?php
    // ѭ��ȡ����¼
    while ($row=mysql_fetch_row($result))
    {
?>
<li>
<a style="text-decoration:none;color:#4c4c4c;"href="../tcglog/search.php?tablename=<?php
		if($seltemp==""){
			$seltemp = $seltemp.$row[0];
		}else{
			$seltemp = $seltemp.",".$row[0];
		}
		$ttt = "$row[0]"."."."$row[0]"."_title"; 
		echo "$row[0]";?>&collate=<?php echo "$row[1]"?>"  target="mainFrame" ><?php 
		$r = $settings->get("$ttt") ;
		if($r == ""){
			$r = "$row[0]";
		}
		echo $r. '';?>
</a></li>
<?php
	}
    // �ͷ���Դ
    mysql_free_result($result);
    // �ر�����
    mysql_close($backupconn);
?>
</div>
</ul>

<ul><a href="#" onClick="showDiv('s11Div');">tcg���ݲ�ѯ</a>
<div id="s11Div" style="display:none;">
<li><a style="text-decoration:none;color:#4c4c4c;" href="../tcg/tcg_search.php?tablename=role" target="mainFrame">role����</a></li>
<li><a style="text-decoration:none;color:#4c4c4c;" href="../tcg/tcg_search.php?tablename=account" target="mainFrame">account����</a></li>
<li><a style="text-decoration:none;color:#4c4c4c;" href="../tcg/tcg_search.php?tablename=auction_data" target="mainFrame">����������</a></li>
</div>
</ul>

<ul><a href="#" onClick="showDiv('ostoolDiv');">ostool���ݲ�ѯ</a>
<div id="ostoolDiv" style="display:none;">
<li><a style="text-decoration:none;color:#4c4c4c;" href="../ostool/ostool_search.php?tablename=card" target="mainFrame">������Ϣ</a></li>
<li><a style="text-decoration:none;color:#4c4c4c;" href="../ostool/ostool_search.php?tablename=item" target="mainFrame">��Ʒ��Ϣ</a></li>
</div>
</ul>

<ul><a href="#" onClick="showDiv('baseDiv');">��������˵��</a>
<div id="baseDiv" style="display:none;">
<li><a style="text-decoration:none;color:#4c4c4c;" href="../base/log.html" target="mainFrame">log�淶</a></li>
<li><a style="text-decoration:none;color:#4c4c4c;" href="../base/no.html" target="mainFrame">����ս�ۡ�ѵ���ı�źͽ���</a></li>
</div>
</ul>
</body>