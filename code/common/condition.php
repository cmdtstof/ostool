<fieldset>
	<legend style="font-size:12px;color:#3333FF;">查询条件</legend>
	<table border="0">
		<tr>
			<td rowspan="3">
				<input type="hidden" id="condition" name="condition"/>
				<select size="5" style="width:400px;" id="ccccccc" name="ccccccc" multiple="multiple"></select>
			</td>
			<td>
				最大显示数量:<input type="text" id="maxsize" size=4  name="maxsize" onblur="minmaxsize(this);"value="100"/><font color="#FF0000" >（一次最大显示10000条）</font>
			</td>
		<tr>
		<tr>
			<td>
				<input type="button" name = "del" onclick="del2();" value="删除条件" />
				<input type="button" name = "search" id = "search" onclick="search22();" value="查询" />
			</td>
		</tr>
	</table>
</fieldset>