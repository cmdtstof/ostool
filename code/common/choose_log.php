
<fieldset>
		<legend style="font-size:12px;color:#3333FF;">条件选择</legend>
字段:
<select id="fieldname" name="fieldname"><?php

    mysql_data_seek($result, 0);
	$seltemp="";
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
		?><option value="<?php echo "$row[$i]";?>"><?php echo $r . '';?></option><?php
      }
	}
?>
</select>
比较关系:
<select id="guanxi" name="guanxi">
	<option value="=">=</option>
	<option value=">">></option>
	<option value=">=">>=</option>
	<option value="<" > <</option>
	<option value="<="><=</option>
	<option value="!=">!=</option>
	<option value="like">like</option>
</select>
值:<input type="text" id="fieldvalue" name="fieldvalue" />
<input type="hidden" name="filters"  id="filters" readOnly value=""/>
<input type="hidden" id="tablename" name="tablename" readOnly value="<?php echo $_GET["tablename"];?>"/>
<input type="hidden" name="showFileds"  id="showFileds" readOnly value=""/>
<input type="hidden" name="filters"  id="filters" readOnly value=""/>
<input class="login-regist" id = "diary-right-margin" type="button" name = "add" onclick="addcondition();" value="增加条件" />
</fieldset>