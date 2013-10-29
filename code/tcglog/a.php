<script type="text/javascript" src = "../js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src = "../js/common.js"></script>
<script type="text/javascript">
	function search22(){	
		var x =document.getElementById("ccccccc");
		if(x.length==0){
			alert("请增加查询条件");
			return ;
		}
		var search1 =document.getElementById("search");
		var temp ="";
		for(var i=0; i<x.length; i++){
			if(temp ==""){
				temp =  x.options[i].value +" "; 
			}else{
				if(x.options[i].value.indexOf('update_time')>=0){
					temp =  x.options[i].value + " and " + temp; 
				}else{
					temp +=  " and " + x.options[i].value; 
				}
			}
		}
		$("#condition").val(temp);
		var d = document.getElementsByName("shows");
		var s = "";
		for(i=0;i<d.length;i++){
		 var t = d[i];
		 if(t.checked){
			if(s==""){
				s=t.value;
			}else{
				s=s+","+ t.value;
			}
		 }
		}
		$("#showFileds").val(s);
		
		var f = document.getElementsByName("filter");
		var fs = "";
		for(i=0;i<f.length;i++){
		 var t = f[i];
		 if(t.checked){
			var fn = t.value;
			//if(fn=='name'){
			//	if( $("#collate").val()=="gbk_chinese_ci"){
			//		fn = fn + " COLLATE gbk_bin";
			//	}else if($("#collate").val()=="utf8_general_ci"){
			//		fn = fn + " COLLATE utf8_bin";
			//	}		
			//}
			if(fs==""){
				fs=fn;
			}else{
				fs=fs+","+ fn;
			}
		 }
		}
		$("#filters").val(fs);
		var history="";
		if(!document.getElementById("history").checked && !document.getElementById("today").checked){
				alert("请选择时间条件");
				return ;
		}
		if(document.getElementById("history").checked){
			var s = document.getElementById("historystart").value;
			var e = document.getElementById("historyend").value;
			if(s==""&& e==""){
				alert("请输入时间条件");
				return ;
			}else{
				if(s!=""){
					history += " and update_time >='" + s + "'";
				}
				if(e!=""){
					history += " and update_time <='" + e + "'";
				}
			}
			
		}
		var today="";
		if(document.getElementById("today").checked){
			var s = document.getElementById("todaystart").value;
			var e = document.getElementById("todayend").value;
			if(s==""&& e==""){
				alert("请输入时间条件");
				return ;
			}else{
				if(s!=""){
					today += " and update_time >='" + s + "'";
				}
				if(e!=""){
					today += " and update_time <='" + e + "'";
				}
			}
		}
		
		//	alert($("#filters").val());
		search1.disabled="true";
		var d = "action=search&tablename="+$("#tablename").val()+"&collate="+$("#collate").val()+"&showFileds="+$("#showFileds").val()+"&condition="+
		$("#condition").val()+"&maxsize="+$("#maxsize").val()+"&filters="+$("#filters").val()+"&history="+history+"&today="+today;
		$.ajax({
			type:'POST',
			url:'t.php',
			data:encodeURI(encodeURI(d)),
			timeout:timeout,
			error:function (data){
				alert("系统繁忙，请稍后再试");
				search1.disabled="";
				},
			success:function(result){
				$("#tableshow1").html(result);
				search1.disabled="";
				init();
				trStyleChange();
			}
			
		});
    }
</script>
<?php
  //查询 字段
  $strsql="select column_name from information_schema.COLUMNS where TABLE_SCHEMA='".$backup_database."' and TABLE_NAME='".$_GET["tablename"]."'";
 //	echo $strsql;
   // 执行sql查询
    $result=mysql_query($strsql, $backupconn);
	//echo $strsql;
	?>
	<?php 
require '../common/field.php';
require '../common/filter.php';
require '../common/choose.php';
require '../common/condition_log.php';
?>
<?php
    // 释放资源
    mysql_free_result($result);
    // 关闭连接
    mysql_close($backupconn);

?>
<?php
require '../common/condition.php';
require '../common/showdata.php';
?>
