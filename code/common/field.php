<fieldset>
		<legend style="font-size:12px;color:#3333FF;"><?php 
$tn = $_GET["tablename"].".".$_GET["tablename"]."_title"; echo $settings->get("$tn")==""?$_GET["tablename"]:$settings->get("$tn");?>_�ֶ�</legend>
<?php
    // ��ȡ��ѯ���
    $row=mysql_fetch_row($result);
// ��λ����һ����¼
    mysql_data_seek($result, 0);
	$seltemp="";
    // ѭ��ȡ����¼
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
		?><input type="checkbox" checked name="shows" id="shows" value="<?php echo "$row[$i]";?>"><?php echo $r . '';?></checkbox><?php
      }
	}
?>
</fieldset>