<script language="javascript" type="text/javascript" src="../js/My97DatePicker/WdatePicker.js"></script>
<fieldset>
	<legend style="font-size:12px;color:#3333FF;">时间条件</legend>
				<input type="checkbox"  id="history" checked //>查询历史230（不含今日）
				时间从<input name="historystart"  id="historystart" value="<?php date_default_timezone_set("PRC"); echo date("Y-m-d",strtotime("-1 day"))." 00:00:00";?>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'%y-%M-{%d-1} 23:59:59'})"/>
				至<input name="historyend"  id="historyend" value="<?php date_default_timezone_set("PRC");echo date("Y-m-d",strtotime("-1 day"))." 23:59:59";?>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'historystart\')}',maxDate:'%y-%M-{%d-1} 23:59:59'})"/>
				<input type="checkbox" id="today" />本日数据
				时间从<input name="todaystart"  id="todaystart" value="<?php date_default_timezone_set("PRC");echo date("Y-m-d",time())." 00:00:00";?>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'todayend\')||\'%y-%M-%d %H:%m:%s\'}'})" />至
				<input name="todayend"  id="todayend" value="<?php date_default_timezone_set("PRC");echo date("Y-m-d H:i:s",time());?>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'todaystart\')}',maxDate:'%y-%M-%d %H:%m:%s'})"  onblur="todayTimeLimit(this);" />
</fieldset>